<?php

namespace App\Http\Controllers;

use App\Http\Requests\JoinRoomRequest;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;

class RoomController extends Controller {
    public function list() {
        $user = auth()->user();
        if($user->is_admin){
            $rooms = Room::with('members')->get();
        }else{
            $rooms = Room::where('is_private', false)->where('is_liste', false)->get();
            foreach ($rooms as &$room) {
                $room_members = User::where('room_id', $room->id)->get(["id", "lastname", "firstname","filiere"]);
                $room->members = $room_members;    
            }
        }
        return $rooms;
    }


    public function join(JoinRoomRequest $req) {
        $room = Room::where("id",$req->room_id)->first();
        $user = auth()->user();
        $panier = $user->panier;
        if(!is_null($panier)){
            if($panier->status->code == "finished" || $panier->status->code == "waiting_second_paiement"){
                if(!$user->is_bde){
                    if(strlen($user->n_cheque ?? "") < 5){
                        return response()->json("Le cheque de caution n'a toujours pas été enregistré", 401);
                    }
                }
                if ($room->is_private) {
                    if ($room->code != $req->code) {
                        return response()->json("Le code de cette chambre est incorrect", 401);
                    }
                }
                if ($room->capacity > $room->members_count) {
                    if($room->members_count == 0){
                        $room->leader_id = $user->id;
                        $room->save();
                    }
                    $user->room_id = $room->id;
                    $user->save();
                    return $this->show($room->id);
                }else{
                    response()->json("La chambre est complète", 401);
                }
            }else{
                return response()->json("Vous n'avez pas terminé votre paiement de la skiweek", 401);
            }
        }
        return response()->json("Un erreur est survenue", 401);
    }


    public function update(Request $req){
        $user = auth()->json();

        $room = Room::find($req->id);
        if($user->id != $room->leader_id && !$user->is_admin){
            return response()->json("Vous n'êtes pas le responsable de cette chambre", 401);
        }
        $room->update([
            'is_private' => $req->is_private
        ]);
        return $room;
    }


    public function leave(){
        $user = auth()->user();
        if($user->room_id){
            $id = $user->room_id;
            $room = Room::where('leader_id', $user->id)->first();
            if(!is_null($room)){
                $room->is_private = false;
                $room->code = null;
                $room->leader_id = null;
                $room->save();
            }
            $user->room_id = null;
            $user->save();
            return $this->show($id);
        }
        return response()->json("Une erreur est survenue", 401);
    }

    public function show($id){
        $room = Room::where('id', $id)->where('is_private', false)->first();
        if(!is_null($room)){
            $room_members = User::where('room_id', $room->id)->get(["id", "lastname", "firstname","filiere"]);
            $room->members = $room_members;
            return $room;
        }
        return response()->json("Cette chambre n'existe pas", 404);
    }

    public function getFromToken($code){
        $room = Room::where('code', $code)->first();
        if(!is_null($room)){
            return $room;
        }
        return response()->json("Ce lien ne correspond a aucune chambre", 404);
    }


}
