<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostCategories;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;

Route::get('/', function () {
    return view('home');
});
Route::get('/register', function () {
    return view('register');
});
Route::get('/login', function () {
    return view('login');
});

// Route::get('/dashboard', function () {
    
//     return view('dashboard');
// });

Route::get('/home', function () {
    
    return view('home');
});

Route::post('/registerapi', [UserController::class, 'register']);
Route::post('/loginapi', [UserController::class,'login']);
Route::post('/logout', [UserController::class,'logout']);


//CATEGORY ROUTES
// Route::post('/create-category', [PostCategories::class,'createCategory']);
Route::post('/categories/store', [CategoryController::class, 'addCategory'])->name('categories.addCategory');


// middleware 
Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});
