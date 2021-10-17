<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompletePanierRequest;
use App\Http\Requests\CreatePanierRequest;
use App\Http\Requests\SaveCartRequest;
use App\Models\ItemPanier;
use App\Models\Panier;
use App\Models\Period;
use App\Models\Status;
use Illuminate\Http\Request;

class PanierController extends Controller {

    public function show() {
        return Panier::where('id', auth()->user()->panier_id)->with('items')->firstOrFail();
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
            $date = Carbon::parse("2021-11-08 20:00:00");
        }
        if ($date > Carbon::now()) {
            return response()->json(['error' => "Le service sera accessible " . $date->diffForHumans()], 401);
        }
        $finished = Panier::where('status_id', Status::where('code', 'finished')->first()->id)->count();
        $waiting_paiement = Panier::where('status_id', Status::where('code', 'waiting_paiement')->first()->id)->count();
        if (($finished + $waiting_paiement) < 350) {
            $code = 'waiting_paiement';
        } else {
            $code = 'waiting_list';
        }
        $panier = $user->panier;
        if($panier->status->code == 'unfinished'){
            $panier->completed_at = Carbon::now()->toDateTimeString();
        }
        $panier->status_id = Status::where('code', $code)->first()->id;
        $panier->save();
    }
}
