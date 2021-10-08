<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AddScoreRequest;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserScan;

class UserScanController extends Controller {


    public function getAll() {
        return UserScan::all();
    }

    public function store(CreateUserRequest $req) {
        return UserScan::firstOrCreate(
            ['email' => $req->email],
            [
                'firstname' => $req->firstname,
                'lastname' => $req->lastname,
                'filiere' => $req->filiere,
                'code' => uniqid("cpe_")
            ]
        )->makeVisible(['code']);
    }
}
