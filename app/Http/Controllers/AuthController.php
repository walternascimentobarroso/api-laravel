<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request, User $user)
    {
        $userData = $request->only('name', 'email', 'password');
        if (!$user = $user->create($userData)) {
            abort(500, 'error created user');
        }
        return response()->json(['data' => $user], 200);
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (!auth()->attempt($credentials)) {
            return response()->json('Invalid Credentials', 200);
        }
        /** @var \App\Models\User $user **/
        $user = auth()->user();
        $token = $user->createToken('JWT')->plainTextToken;
        return response()->json(['access_token' => $token], 200);
    }

    public function logout()
    {
        /** @var \App\Models\User $user **/
        $user = auth()->user();
        /** @var \Laravel\Sanctum\PersonalAccessToken $token */
        $token = $user->currentAccessToken();
        $token->delete();
        return response()->json([], 204);
    }

    public function me()
    {
        /** @var \App\Models\User $user **/
        $user = auth()->user();
        return response()->json($user, 200);
    }
}
