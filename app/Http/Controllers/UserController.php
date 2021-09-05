<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AddScoreRequest;
use App\Http\Requests\CreateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller {
    public function editScore(AddScoreRequest $request) {
        if ($request->passcode == "victordrnd") {
            $user = User::find($request->id);
            $user->score = $request->score;
            $user->save();
            return response()->json($user);
        }
    }

    public function addScore(AddScoreRequest $request) {
        if ($req->passcode == "victordrnd") {
            $user = User::find($request->id);
            $user->score += $request->score;
            $user->save();
            return response()->json($user);
        }
    }

    public function getAll() {
        return response()->json(User::orderBy("score", "desc")->orderBy("updated_at", "asc")->select('id', 'firstname', 'lastname', 'score')->get());
    }

    public function store(CreateUserRequest $req) {
        return User::firstOrCreate(
            ['email' => $req->email],
            [
                'firstname' => $req->firstname,
                'lastname' => $req->lastname,
                'filiere' => $req->filiere,
                'code' => uniqid("cpe_")
            ]
        );
    }
}
