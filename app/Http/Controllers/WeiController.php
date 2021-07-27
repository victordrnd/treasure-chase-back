<?php

namespace App\Http\Controllers;

use App\Models\Wei;
use Illuminate\Http\Request;

class WeiController extends Controller
{
    public function register(Request $req){
        $wei = new Wei($req->all());
        $wei->save();
        return $wei;
    }
}
