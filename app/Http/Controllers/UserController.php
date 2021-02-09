<?php

namespace App\Http\Controllers;

use App\Http\Requests\Admin\AddScoreRequest;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller {
    public function editScore(AddScoreRequest $request) {
        //if ($req->passcode == "victordrnd") {
            $user = User::find($request->id);
            $user->score = $request->score;
            $user->save();
            return response()->json($user);
        //}
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
}
