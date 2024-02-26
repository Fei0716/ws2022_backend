<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class AuthController extends Controller
{
    public function signup(Request $request){
        $validated = $request->validate([
            'username' => 'required|unique:users|min:4|max:60',
            'password' => 'required|min:8|max:65536',
        ]);
        
        $user = new User();
        $user->username = $validated['username'];
        $user->password = Hash::make($validated['password']);
        $user->save();

        $token =  $user->createToken($user->username , ['*'] ,Carbon::now()->addHour());

        return response([
            'status' => 'success',
            'token' => $token->plainTextToken,//create api token using laravel sanctum
        ],201);
    }

    public function signin(Request $request){
        $user = User::where('username' , $request->username)->first();

        if($user && Hash::check($request->password , $user->password)){
            if($user->blocked_reason != null){
                return response()->json([
                    'status' => 'blocked',
                    'message' => 'You are blocked from accessing the application',
                    'reason' => User::$BLOCKED_REASONS[$user->blocked_reason ],
                ],401);
            }
            $user->last_login_at = Carbon::now();
            $user->save();

            $token = $user->createToken($user->username , ['*'] , Carbon::now()->addHour());

            return response([
                'status' => 'success',
                'token' => $token->plainTextToken,//create api token using laravel sanctum
            ],200);
        }else{
            return response()->json([
                'status' => 'invalid',
                'message' => 'Wrong username or password',
            ] , 401);
        }
    }   
    public function signout(Request $request){
        // user() returns instance of authenticated user based on token
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => 'success',
        ],200);
    }

}
