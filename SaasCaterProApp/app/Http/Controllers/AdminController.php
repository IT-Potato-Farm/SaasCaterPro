<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index(){

        //Ensuring the user is logged in and is an admin before showing the dashboard
        if (Auth::check() && Auth::user()->role === 'admin'){
            return view('admin.dashboard');
        }

        return redirect('/')->with('error', 'Access denied! Only Admins can access this page.');
    }
}
