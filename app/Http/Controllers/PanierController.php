<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompletePanierRequest;
use App\Http\Requests\CreatePanierRequest;
use App\Http\Requests\SaveCartRequest;
use App\Http\Requests\SaveUserDetailsRequest;
use App\Http\Requests\SendNotificationRequest;
use App\Http\Resources\UserResource;
use App\Models\ItemPanier;
use App\Models\Panier;
use App\Models\Period;
use App\Models\Status;
use Carbon\Carbon;
use Facade\FlareClient\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use Illuminate\Http\Client\Pool as ClientPool;

class PanierController extends Controller {

    public function show() {
        return Panier::where('id', auth()->user()->panier_id)->with('items', 'status')->firstOrFail();
    }

    public function saveDetails(SaveUserDetailsRequest $req){
        $user = auth()->user();
        $user->fill($req->only('poids', 'pointure', 'taille', 'is_surf'));
        $user->save();
        return $user;
    }

    public function saveCart(SaveCartRequest $req) {
        $user = auth()->user();
        if (is_null($user->panier_id)) {
            $panier = Panier::create([
                'status_id' => Status::where('code', 'unfinished')->first()->id
            ]);
            $user->panier_id = $panier->id;
            $user->save();
        }
        $touched_items = [];
        foreach ($req->items as $item) {
            $item = ItemPanier::updateOrCreate(
                [
                    'panier_id' => $user->panier_id,
                    'model_type' => "App\\Models\\" . $item['model'],
                    'model_id' => $item['id']
                ]
            );
            $touched_items[] = $item->id;
        }
        ItemPanier::where('panier_id', $user->panier_id)->whereNotIn('id', $touched_items)->delete();
        return $user->panier;
    }


    public function complete() {
        $user = auth()->user();
        if ($user->is_bde || $user->is_liste) {
            $date = Carbon::parse("2021-11-05 12:00:00");
        } else {
            $date = Carbon::parse("2021-11-08 22:00:00");
        }
        if ($date > Carbon::now()) {
            return response()->json(['error' => "Le service sera accessible " . $date->diffForHumans()], 401);
        }
        $status_ids = Status::whereIn('code', ['finished', 'waiting_paiement', 'waiting_second_paiement'])->pluck("id");
        $count = Panier::whereIn('status_id', $status_ids)->count();
        if ($count < 350) {
            $code = 'waiting_paiement';
            $user->is_allowed = true;
            $user->save();
        } else {
            $code = 'waiting_list';
        }
        $panier = $user->panier;
        if ($panier->status->code == 'unfinished') {
            $panier->completed_at = Carbon::now()->toDateTimeString();
        }
        $status = Status::where('code', $code)->first();
        $panier->status_id = $status->id;
        $panier->save();
        return $status;
    }


    public function sendNotification(SendNotificationRequest $req) {
        $user = auth()->user()->makeVisible(['email']);
        if (in_array($user->panier->status->code, ['waiting_paiement', 'waiting_second_paiement'])) {
            $responses = Http::pool(function (ClientPool $pool) use ($user, $req) {
                [
                    $pool->withOptions([
                        'timeout' => 2,
                    ])->post('https://pumpkin.black-pinthere.fr/payout_cart', [
                        'user' => json_encode($user),
                        'price' => ($req->two_time || $user->panier->status->code == "waiting_second_paiement") ? $user->panier->price / 2 : $user->panier->price,
                    ])
                ];
            });
            return $responses;
        }
        return response()->json(['error' => "Vous n'avez pas la permission d'exécuter cette action"], 401);
    }


    public function getPosition() {
        $user = auth()->user();
        $panier = $user->panier;
        if ($panier->status->code == "waiting_list") {
            $position = Panier::where('completed_at', '<', $panier->completed_at)->where('status_id', Status::where('code', 'waiting_list')->first()->id)->count();
            return $position + 1;
        }
        return response()->json(['error' => "Vous n'êtes pas en file d'attente"], 401);
    }
}
