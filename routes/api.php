<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\InscriptionHHController;
use App\Http\Controllers\MaterielController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\TombolaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserEventController;
use App\Http\Controllers\UserScanController;
use App\Http\Controllers\WeiController;
use App\Models\UserScan;
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


Route::group(['prefix' => 'auth', 'middleware' => 'throttle:15,1'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('password-reset', [AuthController::class, 'passwordReset']);
    Route::get('/token/{token}', [AuthController::class,  'getUserFromPasswordResetToken']);
});

//UserScan
Route::group(['prefix' => 'user_scans'], function () {
    Route::post('/', [UserScanController::class, 'store']);
});

Route::group(['prefix' => 'user_events'], function () {
    Route::post('/', [UserEventController::class, 'store']);
});




Route::group(['middleware' => 'jwt.verify'], function () {
    Route::group(['prefix' => 'auth'], function () {
        Route::get('current', [AuthController::class, 'getCurrentUser']);
    });

    Route::group(['prefix' => 'materiels'], function(){
        Route::get('/',         [MaterielController::class, 'list']);
    });

    Route::group(['prefix' => 'cart'], function(){
        Route::get('/',         [PanierController::class, 'show']);
        Route::post('/',        [PanierController::class, 'saveCart']);
    });
});

Route::group(['prefix' => 'admin', 'middleware' => ['jwt.verify', 'auth.is_admin']], function () {
    Route::get("users", [UserScanController::class, 'getAll']);
    Route::post('upload/pumpkin',   [AdminController::class, 'upload']);
    Route::get('pumpkin/stats',    [AdminController::class, 'getCountByDate']);
    Route::get('billets',       [AdminController::class,    'getBillets']);//->middleware('date:2021-10-06 16:00');

    Route::group(['prefix' => 'events'], function () {
        Route::get('/', [EventController::class, "list"]);
        Route::get('/{id}', [EventController::class, "show"])->where('id', '[0-9]+');;
        Route::post('/', [EventController::class, "store"]);
    });
});
