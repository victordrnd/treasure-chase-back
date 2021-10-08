<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserCollectionResource;
use App\Imports\PumpkinsImport;
use App\Models\Pumkin;
use App\Models\Pumpkin;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\Console\Input\Input;

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
}
