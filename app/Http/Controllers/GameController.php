<?php

namespace App\Http\Controllers;

use App\Http\Requests\GameFinishedRequest;
use App\Models\UserGame;
use App\Models\Game;
use Illuminate\Http\Request;

class GameController extends Controller
{
    public function getMyGames(){
        $games = auth()->user()->load('games');
        return response()->json($games);
    }


    public function loose(){
        $user = auth()->user();
        $user->score = 0;
        $user->save();
        return response()->json($user);  
    }

    public function gameFinished(GameFinishedRequest $req){
        $game = Game::where('slug',$req->step)->first();
        $user = auth()->user();
        $exist = UserGame::where('game_id', $game->id)->where('user_id', $user->id)->count();
        if($exist == 0){
            UserGame::create([
                'game_id' => $game->id,
                'user_id' => $user->id
            ]);
            $user->score += $game->score;
            $user->save();
            return response()->json($user->load('games'));
        }else{
            return response()->json("error", 401);
        }
    }
}
