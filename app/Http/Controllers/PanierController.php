<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreatePanierRequest;
use App\Models\Panier;
use App\Models\Period;
use Illuminate\Http\Request;

class PanierController extends Controller
{
    //

    public function create(CreatePanierRequest $req){
        $count = Panier::where('period_id', $req->period_id)->count();
        if($count< 15){
            $panier = Panier::create($req->all());
            return $panier;
        }
        return response()->json(["error" => "Tous les paniers sont déjà réservés pour cette période."], 422);
    }


    public function getAll(){
        return Period::with("paniers")->get();
    }

    public function delete(Request $req){
        Panier::where('id', $req->id)->delete();
        return $this->getAll();
    }
}
