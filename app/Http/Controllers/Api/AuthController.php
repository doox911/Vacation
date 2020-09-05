<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller {

  public function login(Request $request) {
    try {
      $request->validate([
        'email' => 'email|required',
        'password' => 'required'
      ]);

      $credentials = request(['email', 'password']);

      if (!Auth::attempt($credentials)) {
        return response()->json([
          'status_code' => 500,
          'message' => 'Unauthorized'
        ]);
      }

      $user = User::where('email', $request->email)->first();

      if (!Hash::check($request->password, $user->password, [])) {
        throw new \Exception('Error in Login');
      }

      $tokenResult = $user->createToken('authToken')->plainTextToken;

      return response()->json([
        'status_code' => 200,
        'access_token' => $tokenResult,
        'user' => $user,
        'token_type' => 'Bearer',
      ]);
    } catch (Exception $error) {
      return response()->json([
        'status_code' => 500,
        'message' => 'Error in Login',
        'error' => $error,
      ]);
    }
  }

  public function logout(Request $request, User $user) {
    $user->tokens()->delete();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return response()->json([
      'logout' => true,
    ]);
  }
}
