<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Http\Resources\UserCollectionResource;
use App\Http\Resources\UserResource;
use App\Imports\PumpkinsImport;
use App\Models\ItemPanier;
use App\Models\Panier;
use App\Models\Pumpkin;
use App\Models\Status;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Str;
use SMSFactor\Laravel\Facade\Message;
use Illuminate\Support\Facades\Cache;

class AdminController extends Controller {
    public function checkIsAdmin() {
        return auth()->user()->is_admin;
    }


    public function upload(Request $req) {
        $file = $req->file('file')->store('pumpkin');
        Excel::import(new PumpkinsImport, $file);
        return Pumpkin::all();
    }

    public function getCountByDate() {
        return Pumpkin::groupBy(\DB::raw('DATE(date)'))
            ->orderBy('date', 'DESC')->get(array(
                \DB::raw('DATE(date) as name'),
                \DB::raw('COUNT(*) as value')
            ));
    }

    public function getBillets(Request $req) {
        if ($req->clear == "true") {
            Cache::forget('billets');
        }
        return Cache::remember('billets', 60 * 15, function () {
            return json_encode(new UserCollectionResource(User::with('panier', 'billet')->orderBy('lastname')->get()));
        });
    }

    public function showCart($user_id) {
        return Panier::where('id', User::find($user_id)->panier_id)->with('items', 'status')->firstOrFail();
    }


    public function updateUser(Request $req) {
        $user = User::find($req->id);
        $user->fill($req->all());
        $user->save();
        return new UserResource($user);
    }

    public function getUser($id) {
        $user = User::find($id);
        return new UserResource($user);
    }

    public function resetPassword(Request $req) {
        $user = User::find($req->user_id);
        $token = Str::random(20);
        $user->token = $token;
        $user->save();
        return ['token' => $token];
    }

    public function sendSms(Request $req) {
        $user = User::find($req->user_id);
        Message::send([
            'to' => $user->phone,
            'text' => "Black Pinthère\nTon mot de passe a été réinitialisé, voici le lien pour le définir :\nhttps://black-pinthere.fr/password-reset/" . $user->token,
            'pushtype' => 'alert',
            'sender' => 'BDE CPE'
        ]);
        return $user;
    }

    public function confirmCart(Request $req) {
        $user = User::find($req->user_id);
        $user->panier->status_id = Status::where('code', 'finished')->first()->id;
        if (is_null($user->panier->completed_at)) {
            $user->panier->completed_at = Carbon::now()->toDateTimeString();
        }
        $user->panier->save();
        return new UserResource($user);
    }


    public function listStatus() {
        return Cache::rememberForever('status', function () {
            return Status::all();
        });
    }


    public function export(Request $req) {
        $filepath = Excel::store(new UsersExport(), 'public/export.xlsx', null, null, [
            'visibility' => 'public'
        ]);
        $protocol = "https://"; //$req->secure() ? "https://" : "http://";
        return ['path' => $protocol . $req->getHttpHost() . "/storage/export.xlsx"];
    }


    public function removeItemPanier(Request $req) {
        ItemPanier::destroy($req->item_id);
        return "true";
    }


    public function addItemPanier(Request $req) {
        if ($req->model_type != "Materiel") {
            ItemPanier::updateOrCreate(
                [
                    'model_type' => "App\\Models\\" . $req->model_type,
                    'panier_id' => $req->panier_id
                ],
                [
                    'model_id' => $req->model_id,
                ]
            );
        } else {
            ItemPanier::updateOrCreate(
                [
                    'model_type' => "App\\Models\\" . $req->model_type,
                    'model_id' => $req->model_id,
                    'panier_id' => $req->panier_id
                ]
            );
        }

        return Panier::where('id', $req->panier_id)->with('items', 'status')->firstOrFail();
    }
}
