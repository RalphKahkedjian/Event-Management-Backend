<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //function for user registration
    public function register(RegistrationRequest $request) {
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->age = $request->get('age');

        $user->save();
        $accessToken = $user->createToken('authToken')->plainTextToken;
        return response()->json([
            "status" => true,
            "message" => "User Registered Successfully",
            "user" => $user,
            "token" => $accessToken
        ]);
    }

    public function login(LoginRequest $request) {
        $user = User::where('email', $request->get('email'))->first();

        if ($user && Hash::check($request->get('password'), $user->password)) {
            $accessToken = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                "status" => true,
                "message" => "User logged in successfully",
                "user" => $user,
                "access_token" => $accessToken
            ], 200);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Wrong email or password"
            ], 401);
        }
    }
    public function ListUsers() {
        $users = User::all();
        if($users->isEmpty()) {
            return response()->json([
                "status" => false,
                "message" => "No Users Found"
            ]);
        }
        else {
            return response()->json([
                "status" => true,
                "message" => "Users List",
                "Users" => [
                    "Description" => $users
                ]
            ]);
        }
    }
}
