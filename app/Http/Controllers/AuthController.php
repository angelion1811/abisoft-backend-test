<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Auth;

class AuthController extends Controller
{
    public static function register(RegisterRequest $request)
    {
        $data = $request->all();
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        $token = $user->createToken("auth-token")->plainTextToken;
        return response()->json(compact("token"));
    }

    public static function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only("email", "password")))
            return response()->json(['message'=>"Invalid credentials"], 400);

        $token = Auth::user()->createToken("auth-token")->plainTextToken;
        return response()->json(compact("token"));
    }
}
