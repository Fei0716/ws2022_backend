<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\AdminUser;

class AuthController extends Controller
{
    function index(){
        return view('auth.index');
    }
    function login(Request $request){
        if(Auth::attempt($request->only('username', 'password'))){
            AdminUser::where('username',$request->username)->update([
                'last_login_at' => Carbon::now(),
            ]);
            return redirect()->route('admin.index')->with(['success' => 'Login Successful']);
        }else{
            return back()->with(['error' => 'Username or password is incorrect']);
        }
    }
    function logout(){
        Auth::logout();

        return redirect()->route('loginPage')->with('success', 'Logout Successful');
    }
}
