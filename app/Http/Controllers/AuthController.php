<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request, User $user)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->getMessageBag(), 422);
        }
        $userData = $request->only('name', 'email', 'password');

        $email = $request->input('email');
        if (User::where('email', $email)->first()) {
            return response()->json('The email is already registered!');
        }

        $user = $user->create($userData);
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
