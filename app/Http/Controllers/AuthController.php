<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\PasswordResetRequest;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller {

  public function login(LoginRequest $request) {
    $credentials = $request->only(['email', 'password']);
    if ($request->is_admin) {
      if (!auth()->user()->is_admin) {
        return response()->json(['error' => 'Unauthorized'], 401);
      }
    }
    $data = $this->formatToken($credentials);
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
    $data = $this->formatToken($credentials);
    return response()->json($data, 200);
  }

  public function passwordReset(PasswordResetRequest $req) {
    $user = User::where('token', $req->token)->first();
    $user->password = Hash::make($req->password);
    $user->token = null;
    $user->save();
    $credentials = [
      'email' => $user->email,
      'password' =>  $req->password
    ];
    return $this->formatToken($credentials);
  }

  public function getUserFromPasswordResetToken($token) {
    return User::where('token', $token)->firstOrFail()->makeVisible(['email']);
  }


  public function getCurrentUser() {
    return response()->json(auth()->user());
  }


  private function formatToken($credentials) {
    if (!$token = auth()->setTTL(525600)->attempt($credentials)) {
      return response()->json(['error' => 'Unauthorized'], 401);
    }
    $data =  [
      'user' => auth()->user(),
      'token' => $token,
    ];
    return $data;
  }
}
