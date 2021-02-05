<?php

namespace App\Http\Controllers;

use App\Http\Requests\TombolaTicketRequest;
use App\Models\Tombola;
use Illuminate\Http\Request;

class TombolaController extends Controller
{
    public function newTicket(TombolaTicketRequest $req){
        $tombola = [];
        for ($i = 0; $i < $req->count; $i++) {
            $tombola[] = Tombola::create([
                'firstname' => $req->firstname,
                'lastname' => $req->lastname,
                'email' => $req->email,
                'adresse' => $req->adresse,
                'filiere' => $req->filiere
            ]);
        }
        return response()->json($tombola);

    }
}
