<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'auth'], function(){
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
});
Route::group(['middleware' => 'jwt.verify'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::get('current', [AuthController::class, 'getCurrentUser']);
    });

    Route::group(["prefix" => "games"], function(){
        Route::get('my', [GameController::class, "getMyGames"]);
        Route::post('finished', [GameController::class, "gameFinished"]);
        Route::get('loose', [GameController::class, "loose"]);
    });
});


Route::group(['prefix' => 'admin'], function(){
    Route::get("users", [UserController::class, 'getAll']);
    Route::post('score/edit', [UserController::class, 'editScore']);
    Route::post('score/add', [UserController::class, 'addScore']);
});
