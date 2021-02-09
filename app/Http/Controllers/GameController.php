<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameFinishedRequest;
use App\Models\UserGame;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller {
    public function getMyGames() {
        $games = auth()->user()->load('games');
        return response()->json($games);
    }


    public function loose() {
        $user = auth()->user();
        $user->score = 0;
        $user->save();
        UserGame::where('user_id', $user->id)->delete();
        return response()->json($user);
    }

    public function gameFinished(GameFinishedRequest $req) {

        $hashes = ["tetris" => "0504fe59bf7be7f8e96f2bde914f6f746b5bc6ba2f9b9e2d73b52cb03ddebc9898ee710db2c0d4c30cd76a35068d85bf1c1f1adb9cf79f197495d0568bd4174a",
         "liste" =>"a6a70f6286973095b42ac429ff2cd9a69387d370a2c1d991d7f0ff5fc3225007637cef90fac17bff9b32374632794344776d6aae3161fa72fcebef04f58d6745",
         "memory" => "ea9d55028674b64120f8cff216a5d9d586c2be35f7b114df0f408630a12acd6159201f9a2d450cbc24eec97a1ddf642959beb61472b9c78a479959eb7ab7a141",
         "soundpad" => "485a8e22a7f844c77e49e9e61f4980fae11025450dfed019cde0161c04214acc272808075e2e383c4c45deadc0f4c3c8fab9662177566faba9eec5c6282f697b",
         "qrcode" => "2fcb40fb19e6d570fbe6e5fd3d9b4ea886cc575b00fc77f92f836d41fff72317551266005c2dbefb169fe1d7d8463d9e5ddfa39610bb54deea99e4da0dd0f84a",
         "piano" => "37d2b2f84d18d98ce521093260fb0e2e6c0c546baedf2dea25ac527e72f9039db389c5ad11ec51112f40226e5c6f897b92d9c2e9ccd6a4af7d2da66daa533dbc",
         "snake" => "1517525d969d53f3b1fce628a93e1ff508ca66fdcbd37b3e149d947d17111a711e096e35ce1cd20e6e8a5b0a53b735db1b84a479af9a3e00d481217dbe544a55"];
        if($hashes[$req->step] == $req->integrity){
            $game = Game::where('slug', $req->step)->first();
            $user = auth()->user();
            $exist = UserGame::where('game_id', $game->id)->where('user_id', $user->id)->count();
            if ($exist == 0) {
                UserGame::create([
                    'game_id' => $game->id,
                    'user_id' => $user->id
                ]);
                $user->score += $game->score;
                $user->save();
                return response()->json($user->load('games'));
            } else {
                return response()->json("error", 401);
            }
        }else{
            return response()->json(["error" => "https://www.youtube.com/watch?v=sODZLSHJm6Q"], 403);
        }
    }
}
