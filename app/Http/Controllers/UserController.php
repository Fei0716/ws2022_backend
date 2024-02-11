<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(){
        $users = User::all();
        return view('user.index')->with(['users' => $users]);
    }

    // load up user profile
    public function show(User $user){
        return view('user.show')->with(['user' => $user]);
    }
    public function block( Request $request,User $user){
        $user->blocked_reason = $request->get('reason');
        $user->save();
        return redirect()->back();
    }
    public function unblock(User $user){
        $user->blocked_reason = null;
        $user->save();
        return redirect()->back();
    }
}
