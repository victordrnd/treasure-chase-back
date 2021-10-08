<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserEventRequest;
use App\Models\User;
use App\Models\UserEvent;
use App\Models\UserScan;
use Illuminate\Http\Request;

class UserEventController extends Controller
{
    public function store(CreateUserEventRequest $req){
        $user_event  =  UserEvent::create([
            'user_id' => UserScan::where('code', $req->code)->first()->id,
            'event_id' => $req->event_id,
            'asso' => $req->input('asso', null)
        ]);

        return $user_event->load('user');
    }
}
