<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollectionResource;
use App\Http\Resources\UserResource;
use App\Imports\PumpkinsImport;
use App\Models\Panier;
use App\Models\Pumkin;
use App\Models\Pumpkin;
use App\Models\Status;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Console\Input\Input;
use Illuminate\Support\Str;
use SMSFactor\Laravel\Facade\Message;

class AdminController extends Controller
{
    public function checkIsAdmin(){
        return auth()->user()->is_admin;
    }


    public function upload(Request $req){
        $file = $req->file('file')->store('pumpkin');
        Excel::import(new PumpkinsImport, $file);
        return Pumpkin::all();
    }

    public function getCountByDate()
    {
        return Pumpkin::groupBy(\DB::raw('DATE(date)'))
            ->orderBy('date', 'DESC')->get(array(
                \DB::raw('DATE(date) as name'),
                \DB::raw('COUNT(*) as value')
            ));
    }

    public function getBillets(){
        return new UserCollectionResource(User::all());
    }

    public function showCart($user_id){
        return Panier::where('id', User::find($user_id)->panier_id)->with('items', 'status')->firstOrFail();
    }


    public function updateUser(Request $req){
        $user = User::find($req->id);
        $user->fill($req->all());
        $user->save();
        return new UserResource($user);
    }

    public function resetPassword(Request $req){
        $user = User::find($req->user_id);
        $token = Str::random(20);
        $user->token = $token;
        $user->save();
        return ['token' => $token];
    }

    public function sendSms(Request $req){
        $user = User::find($req->user_id);
        return Message::send([
            'to' => '0611286286',
            'text' => "Black Pinthère\n Ton mot de passe a été réinitialisé, voici le lien pour le définir :\n https://black-pinthere.fr/password-reset/".$user->token,
            'pushtype' => 'alert',
            'sender' => 'BDE CPE'
        ]);
    }

    public function confirmCart(Request $req){
        $user = User::find($req->user_id);
        $user->panier->status_id = Status::where('code', 'finished')->first()->id;
        $user->panier->save();
        return new UserResource($user);
    }


    public function listStatus(){
        return Status::all();
    }
}
