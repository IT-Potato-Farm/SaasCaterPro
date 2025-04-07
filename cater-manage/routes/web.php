<?php

use App\Models\Cart;
use App\Models\Order;
use App\Mail\TestEmail;
use App\Models\Package;
use App\Models\CartItem;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CartController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PostCategories;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\PackageItemController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\PackageUtilityController;
use App\Http\Controllers\HomePageController;
use App\Http\Controllers\AdminHomePanelController;


// route navigation each page


// user route

Route::get('/loginpage', [UserController::class, 'gologin'])->name('login');

Route::get('/register', function () {
    return view('register');
});


// ginawa ko comment dahil may reviews na -M
// Route::get('/', function () {
//     return view('homepage');
// })->name('landing');

Route::get('/', function () {
    $reviews = Review::with('user')->latest()->get();
    return view('homepage', compact('reviews'));
})->name('landing');

// para sa cms -M
Route::get('/homecontent', [HomePageController::class, 'showHomePage'])->name('home-content');

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/home-panel', [AdminHomePanelController::class, 'index'])->name('home-panel.index');
    Route::put('/home-panel/{section}', [AdminHomePanelController::class, 'update'])->name('home-panel.update');
});











// end cms -M

Route::get('/all-menus', function () {
    return view('menupage');
})->name('all-menu');
// Route::get('/login', function () {
//     return view('login');
// });


//  User Dashboard ===================
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('userdashboard');
    Route::get('/user/dashboard/order/{id}', [UserDashboardController::class, 'show'])->name('order.show');
});



// Route::get('/userdashboard/order-details', function () {
//     return view('order-process');
// })->name('orderdetails');

// landing menu fetch package
Route::get('/get-package/{id}', function ($id) {
    return response()->json(Package::findOrFail($id));
});
// Route::get('/package/details/{id}', [PackageController::class, 'showPackageDetails'])->name('displayPackage');
Route::get('/packages/{id}', [PackageController::class, 'PackageDetails']);











Route::post('/login/loginacc', [UserController::class, 'login'])->name('user.login');
Route::post('/register/registeracc', [UserController::class, 'register'])->name('user.register');



Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // email verification notice
    Route::get('/email/verify', [UserController::class, 'verifyNotice'])->name('verification.notice');

    // email veirification handler
    Route::get('/email/verify/{id}/{hash}', [UserController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');

    // resend verification email

    Route::post('/email/verification-notification', [UserController::class, 'verifyHandler'])->middleware(['throttle:6,1'])->name('verification.send');
});



// Route::post('/register/registerapi', [UserController::class, 'register']);
// Route::post('/loginapi', [UserController::class,'login']);


Route::get('/home', function () {

    return view('home');
});


// DATE ROUTE FUNCTION API FOR GETTING THE DATEEEESSSS   partial, ongoing, paid, completed statuses are blocked.
Route::get('/get-booked-dates', function () {
    $bookedDates = Order::whereNotIn('status', ['cancelled'])
        ->get()
        ->map(function ($order) {
            return [
                'start' => $order->event_date_start,
                'end' => $order->event_date_end,
            ];
        });

    return response()->json($bookedDates);
});


//CATEGORY ROUTES
// Route::post('/create-category', [PostCategories::class,'createCategory']);





// MENUU ROUTE
// Route::get('/menu', [MenuController::class, 'index'])->name('menu.index');
// Route::post('/menu/store', [MenuController::class, 'addMenu'])->name('menu.addMenu');
// Route::put('/menu/{id}/edit', [MenuController::class, 'editMenu'])->name('menu.edit');
// Route::delete('/menu/{id}', [MenuController::class, 'deleteMenu'])->name('menu.delete');

// Route::get('/menu-details/{id}', [MenuController::class, 'getMenuDetails']);
// void na yung MENUU 



// package route
Route::post('/package/store', [PackageController::class, 'store'])->name('package.store');

Route::put('/packages/edit/{id}', [PackageController::class, 'editPackage'])->name('package.edit');
Route::delete('/package/{id}', [PackageController::class, 'deletePackage'])->name('package.delete');
// checking ng names if existing etc
Route::get('/package/check-name', [PackageController::class, 'checkName'])->name('package.checkName');
Route::get('/check-option-type', [PackageController::class, 'checkOptionType']);



Route::get('/package/details/{id}', [PackageController::class, 'showDetails'])
    ->name('package.details');

// package item route
Route::resource('package_items', PackageItemController::class);
Route::post('/packageitemoption/store', [PackageItemController::class, 'optionstore'])->name('package_food_item_options.store');
Route::post('/package-items/check-name', [PackageItemController::class, 'checkName'])->name('package_items.checkName');
Route::post('/packageutility/store', [PackageUtilityController::class, 'store'])->name('package_utilities.store');

Route::get('/get-existing-menu-items/{package}', [PackageItemController::class, 'getExistingMenuItems']);
Route::get('/get-existing-package-items/{package}', [PackageItemController::class, 'getExistingpackageItems']);

// menu items
Route::resource('menu-items', MenuItemController::class);
Route::post('/menuitems/store', [MenuItemController::class, 'store'])->name('menuitems.addMenu');
Route::put('/menuitems/{id}/edit', [MenuItemController::class, 'editItem'])->name('menuitems.edit');
Route::delete('/menuitems/{id}', [MenuItemController::class, 'deleteItem'])->name('menuitems.deleteItem');

Route::get('/check-name-availability', [MenuItemController::class, 'checkNameAvailability'])
    ->name('check-name-availability');

// Route::get('/check-package-name', [PackageController::class, 'checkName'])->name('package-name-availability');




// ------------------------------------------------

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cartver2', [CartController::class, 'index2'])->name('cart.index2');
Route::get('/cartdup', [CartController::class, 'index'])->name('cart.sanagumana');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
// cart
Route::middleware(['auth', 'verified'])->group(function () {
   

    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    // Route::put('/cart/edit/{id}', [CartController::class, 'update'])->name('cart.update');
    
});
Route::patch('/cart/update/{id}', [CartItemController::class, 'update'])->name('cart.item.update');
Route::delete('/cart/item/{id}', [CartItemController::class, 'destroy'])->name('cart.item.destroy');

// Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
// CART COUNT LIVE AJAX
Route::get('/cart/count', function () {
    $user = Auth::user();
    
    // For guests, use the session to get cart items
    if (!$user) {
        $cart = session()->get('cart', ['items' => []]);
        return response()->json(['count' => count($cart['items'])]);
    }

    // For authenticated users, use the database to get cart items
    return response()->json(['count' => $user->cart ? $user->cart->items->count() : 0]);
})->name('cart.count');

// order
Route::get('/checkoutpage', function () {
    return view('checkoutpage');
});


// CHECKOUT ROUTEE
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::middleware('auth')->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // After order creation, a confirmation page.
    Route::get('/order/confirmation/{order}', [OrderController::class, 'confirmation'])->name('order.confirmation');
});



// route for admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // ROUTE IN ADMIN DASHBOARDS
    Route::get('/admin/finaldashboard', [AdminController::class, 'goDashboard'])->name('admin.finaldashboard');
    Route::get('/admin/finaldashboard/category', [AdminController::class, 'goCategoryDashboard'])->name('admin.categorydashboard');
    Route::get('/admin/finaldashboard/products', [AdminController::class, 'goProductsDashboard'])->name('admin.products');
    Route::get('/admin/finaldashboard/packages', [AdminController::class, 'goPackageDashboard'])->name('admin.packages');
    Route::get('/admin/finaldashboard/bookings', [AdminController::class, 'goBookingsDashboard'])->name('admin.bookings');
    Route::get('/admin/finaldashboard/users', [AdminController::class, 'goUserDashboard'])->name('admin.allusers');
    // Route::get('/admin/admindashboard', [AdminController::class, 'dashboard'])->middleware('verified')->name('admin.admindashboard');
    Route::get('/admin/admindashboard', [AdminController::class, 'dashboard'])->name('admin.admindashboard');

    // categiry
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    // add
    Route::post('/categories/store', [CategoryController::class, 'addCategory'])->name('categories.addCategory');
    Route::put('/categories/{id}/edit', [CategoryController::class, 'editCategory'])->name('categories.edit');
    Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory'])->name('categories.delete');

    // invoice and filter
    Route::get('/orders/{order}/invoice', [OrderController::class, 'generateInvoice'])->name('order.invoice');
    Route::get('/orders/filter', [OrderController::class, 'index'])->name('orders.filter');

    // cancel order
    Route::put('/orders/{order}/cancelOrder', [OrderController::class, 'cancel'])->name('orderUser.cancel');
    

    // booking  management
    Route::get('/orders/{order}/invoice', [OrderController::class, 'generateInvoice'])->name('order.invoice');
    Route::put('/orders/{order}/mark-paid', [OrderController::class, 'markAsPaid'])->name('orders.mark-paid');
    Route::put('/orders/{order}/mark-unpaid', [OrderController::class, 'markAsUnpaid'])->name('orders.mark-unpaid');
    Route::put('/orders/{order}/mark-ongoing', [OrderController::class, 'markAsOngoing'])->name('orders.mark-ongoing');
    Route::put('/orders/{order}/mark-partial', [OrderController::class, 'markAsPartial'])->name('orders.mark-partial');
    Route::put('/orders/{order}/mark-completed', [OrderController::class, 'markAsCompleted'])->name('orders.mark-completed');
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('order.cancel');

    // PENALTY
    Route::post('/orders/{order}/add-penalty', [OrderController::class, 'addPenalty'])->name('orders.add-penalty');
});


// Reviews route
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.leaveReview');    
    Route::get('/user/dashboard/order/{id}/review', [UserDashboardController::class, 'showReview'])->name('showReview');
    Route::delete('/user/dashboard/order/{order}/review/{review}', [ReviewController::class, 'deleteReview'])->name('deleteReview');
});

Route::middleware(['auth', 'check.review.edit.time'])->group(function () {
    Route::get('/user/dashboard/order/{order}/review/edit', [UserDashboardController::class, 'editReview'])->name('editReview');
    Route::put('/user/dashboard/order/{order}/review', [UserDashboardController::class, 'updateReview'])->name('updateReview');  
});