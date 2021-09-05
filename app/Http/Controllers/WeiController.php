<?php

namespace App\Http\Controllers;

use App\Models\Wei;
use Illuminate\Http\Request;

class WeiController extends Controller {
    public function store(Request $req) {
        $wei = Wei::updateOrCreate(
            [
                'email' => $req->email,
                'phone' => $req->phone
            ],
            $req->except(['email', 'phone'])
        );
        return $wei;
    }


    public function all() {
        return Wei::all();
    }
}