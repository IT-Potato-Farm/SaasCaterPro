<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('home');
});
Route::get('/register', function () {
    return view('register');
});
Route::get('/login', function () {
    return view('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
});

Route::get('/home', function () {
    return view('home');
});

Route::post('/registerapi', [UserController::class, 'register']);
Route::post('/loginapi', [UserController::class,'login']);
Route::post('/logout', [UserController::class,'logout']);
