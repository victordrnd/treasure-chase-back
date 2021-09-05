<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateUserEventRequest;
use App\Models\UserEvent;
use Illuminate\Http\Request;

class UserEventController extends Controller
{
    public function store(CreateUserEventRequest $req){
        $user_event  =  UserEvent::create([
            'user_id' => User::where('code', $req->code)->first()->id,
            'event_id' => $req->event_id
        ]);

        return $user_event->load('user');
    }
}
