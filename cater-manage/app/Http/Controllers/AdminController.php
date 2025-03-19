<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Package;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        // user authenticated and admin
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
        }

        
        $packages = Package::all();

        // Pass the packages to view
        return view('admin.dashboard', compact('packages'));
    }


    public function test()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('admin.finaldashboard');
        }

        return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
    }
    public function dashboard()
    {
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('admin.admindashboard');
        }

        return redirect('/')->with('error', 'Access denied! Only admins can access this page.');
    }
}
