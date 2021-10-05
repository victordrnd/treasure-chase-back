<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller {

    public function login(LoginRequest $request)
    {
      $credentials = $request->only(['email', 'password']);
      if (!$token = auth()->setTTL(525600)->attempt($credentials)) {
        return response()->json(['error' => 'Unauthorized'], 401);
      }
      if($request->is_admin){
        if(!auth()->user()->is_admin){
          return response()->json(['error' => 'Unauthorized'], 401);
        }
      }
      $data =  [
        'user' => auth()->user(),
        'token' => $token,
        'expire' => \Carbon\Carbon::now()->addMinutes(auth()->factory()->getTTL())->format('Y-m-d H:i:s')
      ];
      return response()->json($data);
    }

    
    public function register(RegisterRequest $request) {
        $password = $request->password;
        $request->merge(['password' => Hash::make($request->password)]);
        $user = new User($request->all());
        $user->save();

        $credentials = [
            'email' => $request->email,
            'password' =>  $password
        ];
        if (!$token = auth()->setTTL(525600)->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $data =  [
            'user' => $user,
            'token' => $token,
        ];
        return response()->json($data, 200);
    }


    public function getCurrentUser()
    {
      return response()->json(auth()->user());    
    }
}
