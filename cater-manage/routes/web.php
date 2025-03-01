<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PostCategories;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuItemController;

Route::get('/', function () {
    return view('home');
});
Route::get('/landing', function () {
    return view('homepage');
});
Route::get('/all-menus', function () {
    return view('menupage');
});
// Route::get('/login', function () {
//     return view('login');
// });

// user route
Route::get('/login', function () {
    return view('login');
});
Route::get('/register', function () {
    return view('register');
});
Route::post('/login/loginacc', [UserController::class, 'login'])->name('user.login');
Route::post('/register/registeracc', [UserController::class, 'register'])->name('user.register');
// Route::post('/register/registerapi', [UserController::class, 'register']);
// Route::post('/loginapi', [UserController::class,'login']);
Route::post('/logout', [UserController::class,'logout']);


Route::get('/home', function () {
    
    return view('home');
});





//CATEGORY ROUTES
// Route::post('/create-category', [PostCategories::class,'createCategory']);


Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

// add
Route::post('/categories/store', [CategoryController::class, 'addCategory'])->name('categories.addCategory');

// edit
Route::put('/categories/{id}/edit', [CategoryController::class, 'editCategory'])->name('categories.edit');

// delete
Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory'])->name('categories.delete');

// MENUU ROUTE
Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
Route::post('/menu/store', [MenuController::class, 'addMenu'])->name('menu.addMenu');
Route::put('/menu/{id}/edit', [MenuController::class, 'editMenu'])->name('menu.edit');
Route::delete('/menu/{id}', [MenuController::class, 'deleteMenu'])->name('menu.delete');

// menu items
Route::resource('menu-items', MenuItemController::class);
Route::post('/menuitems/store', [MenuItemController::class, 'store'])->name('menuitems.addMenu');
Route::get('/check-name-availability', [MenuItemController::class, 'checkNameAvailability'])
    ->name('check-name-availability');


    
// middleware 
Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
});
