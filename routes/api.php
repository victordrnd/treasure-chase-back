<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\InscriptionHHController;
use App\Http\Controllers\MaterielController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\RoomController;
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



    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', [AuthController::class, 'login']);//->middleware('date:2021-11-01 12:00');
        Route::post('register', [AuthController::class, 'register']);//->middleware('date:2021-11-01 12:00');
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
    Route::get('/events', [EventController::class, "list"]);


    Route::group(['middleware' => 'jwt.verify'], function () {
        Route::group(['prefix' => 'auth'], function () {
            Route::get('current', [AuthController::class, 'getCurrentUser']);
        });

        Route::group(['prefix' => 'materiels'], function () {
            Route::get('/',         [MaterielController::class, 'list']);
        });

        Route::group(['prefix' => 'cart'], function () {
            Route::get('/',         [PanierController::class, 'show']);
            Route::post('/',        [PanierController::class, 'saveCart']);
            Route::get('/complete', [PanierController::class, 'complete']);
            Route::post('/pay',    [PanierController::class, 'sendNotification']);
            Route::get('/position', [PanierController::class, 'getPosition']);
        });

        Route::group(['prefix' => 'rooms'], function () {
            Route::get('/',                 [RoomController::class, 'list']);
            Route::get('/{id}',             [RoomController::class, 'show'])->where('id', '[0-9]+');
            Route::get('/token/{code}',     [RoomController::class, "getFromToken"]);
            Route::post('/join',            [RoomController::class, 'join']);
            Route::get('/leave',            [RoomController::class, 'leave']);
            Route::put('/',                 [RoomController::class, 'update']);
        });

        Route::group(['prefix' => 'details'],function(){
            Route::post('/',        [PanierController::class, 'saveDetails']);
        });
    });
    Route::get("/status",           [AdminController::class, 'listStatus']);

    Route::group(['prefix' => 'admin', 'middleware' => ['jwt.verify', 'auth.is_admin']], function () {
        Route::post('upload/pumpkin',   [AdminController::class, 'upload']);
        Route::get('pumpkin/stats',     [AdminController::class, 'getCountByDate']);
        Route::get('billets',           [AdminController::class, 'getBillets']);
        Route::get("/status",           [AdminController::class, 'listStatus']);

        Route::group(['prefix' => 'events'], function () {
            Route::get('/', [EventController::class, "list"]);
            Route::get('/{id}', [EventController::class, "show"])->where('id', '[0-9]+');;
            Route::post('/', [EventController::class, "store"]);
        });

        Route::group(['prefix' => 'cart'], function () {
            Route::get('/{user_id}',        [AdminController::class, "showCart"])->where('id', '[0-9]+');
            Route::post('/confirm',         [AdminController::class, "confirmCart"]);
            Route::post('/remove_item',     [AdminController::class, "removeItemPanier"]);
            Route::post('/add_item',        [AdminController::class, "addItemPanier"]);
        });


        Route::group(['prefix' => 'users'], function () {
            Route::get("/", [UserScanController::class, 'getAll']);
            Route::get('/{id}',            [AdminController::class, "getUser"]);
            Route::post('/',               [AdminController::class, "updateUser"]);
            Route::post('/reset-password', [AdminController::class, 'resetPassword']);
            Route::post('/sendsms',        [AdminController::class, 'sendSms']);
        });

        Route::group(['prefix' => "rooms"], function(){
            Route::get('/',         [AdminController::class,"listRooms"]);
            Route::get('/users/available',   [AdminController::class, "getUsersWithoutRooms"]);
        });

        Route::get('/export',              [AdminController::class, 'export']);
    });
