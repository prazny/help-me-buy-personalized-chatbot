<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Models\User;
use Auth;
use Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{

    public function login(LoginUserRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token = $user->createToken("HelpMeBuyUser-{$user->email}")->plainTextToken;
            return response([
                'email' => $user->email,
                'name' => $user->name,
                'token' => $token,
            ], 200);
        } else {
            return response(null, 403);
        }
    }

    public function register(RegisterUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken("HelpMeBuyUser-{$user->email}")->plainTextToken;
        return response([
            'email' => $user->email,
            'name' => $user->name,
            'token' => $token,
        ], 200);
    }

    public function getUser(Request $request)
    {
        return $request->user();
    }
}
