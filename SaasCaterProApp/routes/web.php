<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PostCategories;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\PackageItemController;

Route::get('/', function () {
    return view('home');
});

Route::get('/home', function () {
    return view('home');
});

//ACCOUNT ROUTES
Route::get('/user', function () {return view('user');});
Route::get('/login', function () {return view('login');});
Route::get('/loginpage', function () {return view('loginpage');});
Route::get('/register', function () {return view('register');});
Route::post('/login/loginacc', [UserController::class, 'login'])->name('user.login');
Route::post('/register/registeracc', [UserController::class, 'register'])->name('user.register');
// Route::post('/register/registerapi', [UserController::class, 'register']);
// Route::post('/loginapi', [UserController::class,'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

//Middleware Routes

Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/finaldashboard', [AdminController::class, 'test'])->name('admin.finaldashboard');
    Route::get('/admin/admindashboard', [AdminController::class, 'dashboard'])->name('admin.admindashboard');
});


//CATEGORY ROUTES

Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
Route::post('/categories/store', [CategoryController::class, 'addCategory'])->name('categories.addCategory');
Route::put('/categories/{id}/edit', [CategoryController::class, 'editCategory'])->name('categories.edit');
Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory'])->name('categories.delete');

//MENU ROUTES

// Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
// Route::post('/menu/store', [MenuController::class, 'addMenu'])->name('menu.addMenu');
// Route::put('menu/{id}/edit', [MenuController::class, 'editMenu'])->name('menu.edit');
// Route::delete('/menu/{id}', [MenuController::class, 'deletemenu'])->name('menu.delete');

//MENU ITEMS ROUTES

Route::resource('menu-items', MenuItemController::class);
Route::post('/menuitems/store', [MenuItemController::class, 'store'])->name('menuitems.addMenu');
Route::put('/menuitems/{id}/edit', [MenuItemController::class, 'editItem'])->name('menuitems.edit');
Route::delete('/menuitems/{id}', [MenuItemController::class, 'deleteItem'])->name('menuitems.deleteItem');
Route::get('/check-name-availability', [MenuItemController::class, 'checkNameAvailability'])->name('check-name-availability');
Route::get('/check-package-name', [PackageController::class, 'checkName'])->name('package-name-availability');


// PACKAGE ROUTES

Route::post('/package/store', [PackageController::class, 'store'])->name('package.store');
Route::put('/packages/edit/{id}', [PackageController::class, 'editPackage'])->name('package.edit');
Route::delete('/package/{id}', [PackageController::class, 'deletePackage'])->name('package.delete');

// PACKAGE ITEMS ROUTES

Route::resource('package_items', PackageItemController::class);
Route::get('/get-existing-menu-items/{package}', [PackageItemController::class, 'getExistingMenuItems']);

//CART ROUTES

Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::get('/cart', function () {return view('cartpage');})->name('cartpage');

//ORDER ROUTES

Route::get('/cart/checkout', function () {return view('checkoutpage');})->name('checkoutpage');