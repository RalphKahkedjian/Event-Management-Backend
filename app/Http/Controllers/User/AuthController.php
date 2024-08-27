<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Models\Attendee;
use App\Models\Organizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function register(RegistrationRequest $request)
    {
        $user = new User();
        $user->name = $request->get('name');
        $user->email = $request->get('email');
        $user->password = Hash::make($request->get('password'));
        $user->age = $request->get('age');
        $user->role = $request->get('role');
        $user->save();

        if($user->age < 18) {
            return response()->json([
                "status" => false,
                "message" => "Sorry, you are too young"
            ],403);
        }
    
        if (strtolower($user->role) === 'organizer') {
            $organizer = new Organizer();
            $organizer->name = $user->name;
            $organizer->user_id = $user->id;
            $organizer->rating = 0;
            $organizer->description = '';
            $organizer->save();
    
            $accessToken = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                "status" => true,
                "message" => "Organizer Registered Successfully",
                "user" => $user,
                "organizer" => $organizer,
                "token" => $accessToken
            ]);
    
        } elseif ( strtolower($user->role) === 'attendee') {
            $attendee = new Attendee();
            $attendee->name = $user->name;
            $attendee->user_id = $user->id; 
            $attendee->wallet = 0.00;
            $attendee->save();
    
            $accessToken = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                "status" => true,
                "message" => "Attendee Registered Successfully",
                "user" => $user,
                "attendee" => $attendee,
                "token" => $accessToken
            ]);
        } else {
            return response()->json([
                "status" => false,
                "message" => "Invalid role. Role must be either 'organizer' or 'attendee'."
            ], 400);
        }
    }

    public function login(Request $request){
        $request -> validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        $credentials = $request->only(['email', 'password']);
        $user = User::where('email' , $credentials['email'])->first();
        if($user && Hash::check($credentials['password'], $user->password)) {
            $accessToken = $user->createToken('authToken')->plainTextToken;
            return response()->json([
                "status" => true,
                "message" => "User logged in successfully",
                "user" => $user,
                "token" => $accessToken
            ]);
        }
        else {
            return response()->json([
                "status" => false,
                "message" => "Incorrect email or password"
            ],401);
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
