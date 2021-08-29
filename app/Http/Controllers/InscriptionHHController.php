<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateInscriptionHHRequest;
use App\Models\HappyHour;
use App\Models\InscriptionHH;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InscriptionHHController extends Controller {
    public function store(CreateInscriptionHHRequest $req) {
        $count = HappyHour::where('id', $req->hh_id)->count();
        if ($count < 150) {
            $inscriptions = InscriptionHH::where('email', $req->email)->count();
            if ($count < 3) {

                $hh = InscriptionHH::firstOrCreate(
                    [
                        'hh_id' => $req->hh_id,
                        'email' => $req->email
                    ],
                    [
                        'filiere' => $req->filiere,
                        'lastname' => $req->lastname,
                        'firstname' => $req->firstname,
                        'code' => uniqid("hh_")
                    ]
                );
                return $hh->load('hh');
            } else {
                return response()->json("Tu as déjà participé au nombre maximum de HH", 401);
            }
        } else {
            return response()->json("Aucune place n'est disponible pour ce HH", 401);
        }
    }


    public function scan($code) {
        $inscription =  InscriptionHH::where('code', $code)->firstOrFail();
        if(Carbon::parse($inscription->hh->date)->isToday()){
            $inscription->scan_count += 1;
            $inscription->save();
            return $inscription;
        }else{
            return response()->json("La date du HH n'est pas valide pour aujourd'hui (".$inscription->hh->date.")", 401);
        }
    }
}
