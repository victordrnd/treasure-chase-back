<?php

namespace App\Http\Controllers;

use App\Models\Panier;
use App\Models\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    //

    public function getAll(){
        $periods =  Period::all();
        foreach ($periods as &$period) {
            $period->remaining = 15 - Panier::where('period_id', $period->id)->count();
            $period->disabled = ($period->disabled || $period->remaining == 0) ? true : false;
        }
        return $periods;
    }



    public function updatePeriod(Request $req){
        $period = Period::where('id',$req->id)->update([
            'disabled' => $req->disabled
        ]);
        return Period::find($req->id);
    }
}
