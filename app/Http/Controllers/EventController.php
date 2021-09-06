<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEventRequest;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function list(){
        return Event::orderBy('created_at', 'desc')->get();
    }

    public function show($id){
        return Event::where('id', $id)->with('users')->first();
    }

    
    public function store(CreateEventRequest $req){
        return Event::create([
            'label' => $req->label,
            'code' => $req->code
        ]);
    }
}
