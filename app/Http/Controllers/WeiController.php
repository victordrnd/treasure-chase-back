<?php

namespace App\Http\Controllers;

use App\Models\Wei;
use Illuminate\Http\Request;

class WeiController extends Controller
{
    public function store(Request $req){
        $wei = new Wei($req->all());
        $wei->save();
        return $wei;
    }


    public function all(){
        return Wei::all();
    }
}
