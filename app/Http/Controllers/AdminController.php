<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminUser;

class AdminController extends Controller
{
    function index(){
        $adminUsers = AdminUser::all();
        return view('admin.index')->with(['adminUsers' => $adminUsers]);
    }
}
