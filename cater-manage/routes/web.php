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

// route navigation each page
Route::get('/', function () {
    return view('homepage');
});
Route::get('/landing', function () {
    return view('homepage');
})->name('landing');
Route::get('/all-menus', function () {
    return view('menupage');
})->name('all-menu');
// Route::get('/login', function () {
//     return view('login');
// });

Route::get('/cart', function () {
    return view('cartpage');
})->name('cartpage');


// user route
Route::get('/login', function () {
    return view('login');
});
Route::get('/loginpage', function () {
    return view('loginpage');
});
Route::get('/register', function () {
    return view('register');
});
Route::post('/login/loginacc', [UserController::class, 'login'])->name('user.login');
Route::post('/register/registeracc', [UserController::class, 'register'])->name('user.register');
// Route::post('/register/registerapi', [UserController::class, 'register']);
// Route::post('/loginapi', [UserController::class,'login']);
Route::post('/logout', [UserController::class, 'logout'])->name('logout');


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
// Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
// Route::post('/menu/store', [MenuController::class, 'addMenu'])->name('menu.addMenu');
// Route::put('/menu/{id}/edit', [MenuController::class, 'editMenu'])->name('menu.edit');
// Route::delete('/menu/{id}', [MenuController::class, 'deleteMenu'])->name('menu.delete');

// Route::get('/menu-details/{id}', [MenuController::class, 'getMenuDetails']);
// void na yung MENUU 

// package route
Route::post('/package/store', [PackageController::class, 'store'])->name('package.store');

// menu items
Route::resource('menu-items', MenuItemController::class);
Route::post('/menuitems/store', [MenuItemController::class, 'store'])->name('menuitems.addMenu');
Route::put('/menuitems/{id}/edit', [MenuItemController::class, 'editItem'])->name('menuitems.edit');
Route::delete('/menuitems/{id}', [MenuItemController::class, 'deleteItem'])->name('menuitems.deleteItem');

Route::get('/check-name-availability', [MenuItemController::class, 'checkNameAvailability'])
    ->name('check-name-availability');

Route::get('/check-package-name', [PackageController::class, 'checkName'])->name('package-name-availability');


// ORDERS

// cart
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');

// order
Route::get('/cart/checkout', function () {
    return view('checkoutpage');
    })->name('checkoutpage');




    
// middleware 
Route::middleware([AdminMiddleware::class])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::get('/admin/finaldashboard', [AdminController::class, 'test'])->name('admin.finaldashboard');
    Route::get('/admin/admindashboard', [AdminController::class, 'dashboard'])->name('admin.admindashboard');
});
