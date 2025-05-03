<?php

use App\Models\Cart;
use App\Models\Order;
use App\Mail\TestEmail;
use App\Models\Package;
use App\Models\CartItem;
use App\Mail\InvoiceMail;
use App\Models\PrivacyPolicy;
use App\Models\WhyChooseUsSection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use App\Mail\RemainingBalanceReminder;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PostCategories;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrdersController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\PackageController;
use App\Http\Controllers\PenaltyController;
use App\Http\Controllers\ReportsController;
use App\Http\Controllers\UserApiController;
use App\Http\Controllers\UtilityController;
use App\Http\Middleware\PreventAdminAccess;
use App\Http\Controllers\CartItemController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\ItemOptionController;
use App\Http\Controllers\PackageItemController;
use App\Http\Controllers\VerifyEmailController;
use App\Http\Controllers\NavbarSettingController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\ReviewSectionController;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\ForgotPasswordController;
use App\Http\Controllers\PackageUtilityController;
use App\Http\Controllers\Admin\HeroSectionController;
use App\Http\Controllers\Admin\FooterSectionController;
use App\Http\Controllers\Admin\AboutUsSectionController;
use App\Http\Controllers\Admin\BookingSettingController;
use App\Http\Controllers\Admin\WhyChooseUsSectionController;
use App\Http\Controllers\Admin\ReviewSectionSettingController;



// Route::get('/preview-email', function () {
//     $order = Order::latest()->first(); 
//     $remainingBalance = $order->total - $order->amount_paid;

//     return (new RemainingBalanceReminder($order, $remainingBalance))->render();
// });

// Route::get('/debug/invoice/{order}', function (Order $order) {
//     $invoiceMail = new InvoiceMail($order);
//     return $invoiceMail->render(); 
// });


Route::get('/all-reviews', [ReviewController::class, 'index'])->name('all.reviews');






Route::get('/user/dashboard', function () {
    return redirect()->route('admin.reports');
});



// PREVENT ADMIN ACCESSING CUSTOMER SIDE
Route::middleware([PreventAdminAccess::class])->group(function () {
    Route::get('/all-menus', function () {
        return view('menupage');
    })->name('all-menu');
    Route::get('/', function () {
        return view('homepage');
    })->name('landing');






});


// DEBUG EMAIL
Route::get('/debug-order-email/{orderId}', function ($orderId) {
    $order = Order::find($orderId);  // Replace with the actual method to retrieve the order.

    if ($order) {
        return view('emails.order_confirmation', compact('order'));  // Adjust view path accordingly
    } else {
        return "Order not found!";
    }
});

Route::post('/test', function () {
    return response()->json(['message' => 'Test route works!']);
});
// SAMPLE PRINT
Route::get('/reports/orders/print', [ReportsController::class, 'printOrdersReport'])
    ->name('reports.orders.print')
    ->middleware('auth');

Route::get('/privacy-policy', function () {
    return view('privacy-policy');
})->name('privacy.policy');

Route::get('/loginpage', [UserController::class, 'gologin'])->name('login');
Route::get('/register', [UserController::class, 'goregister'])->name('register');





// Route::get('/login', function () {
//     return view('login');
// });


//  User VERIFIED Dashboard ===================
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








Route::get('/forgot-password', [ForgotPasswordController::class, 'showForgotPasswordForm'])->name('password.request');
Route::post('/forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('/reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');


Route::post('/login/loginacc', [UserController::class, 'login'])->name('user.login');
Route::post('/register/registeracc', [UserController::class, 'register'])->name('user.register');


// email veirification handler
// Route::get('/email/verify/{id}/{hash}', [UserController::class, 'verifyEmail'])->middleware(['signed'])->name('verification.verify');




Route::middleware('auth')->group(function () {
    Route::post('/logout', [UserController::class, 'logout'])->name('logout');

    // verification notice page
    Route::get('/email/verify', [VerifyEmailController::class, 'verifyNotice'])
        ->name('verification.notice');

    // Process the verification code
    Route::post('/email/verify', [VerifyEmailController::class, 'verifyEmail'])
        ->name('verification.verify-code');

    // Resend the verification code
    Route::post('/email/verify/resend', [VerifyEmailController::class, 'verifyHandler'])
        ->middleware('throttle:6,1')
        ->name('verification.resend-code');


});



// DATE ROUTE FUNCTION API FOR GETTING THE DATEEEESSSS   partial, ongoing, paid, completed statuses are blocked.

Route::get('/get-booked-dates', function () {

    $bookingSetting = \App\Models\BookingSetting::first();  // assuming one global setting
    $limit = $bookingSetting->events_per_day ?? 1;

    $fullyBookedDates = Order::whereNotIn('status', ['cancelled'])
        ->get()
        ->flatMap(function ($order) {
            $startDateTime = new DateTime($order->event_date_start . ' ' . $order->event_start_time);
            $endDateTime = new DateTime($order->event_date_end . ' ' . $order->event_start_end);
            $dateChunks = [];

            while ($startDateTime <= $endDateTime) {
                $dateChunks[] = $startDateTime->format('Y-m-d');
                $startDateTime->modify('+1 day');
            }

            return $dateChunks;
        })
        ->countBy()  // counts how many times each date appears
        ->filter(function ($count) use ($limit) {
            return $count >= $limit;
        })
        ->keys()  // Only the date values
        ->toArray();
    // Get blocked dates from BookingSetting
    $blockedDates = $bookingSetting->blocked_dates ?? [];

    // Merge both lists and remove duplicates
    $disabledDates = array_unique(array_merge($fullyBookedDates, $blockedDates));

    // Format as [{ start: date, end: date }]
    $formatted = collect($disabledDates)->map(function ($date) {
        return [
            'start' => $date,
            'end' => $date,  // single day block
        ];
    })->values();

    return response()->json($formatted);
});


Route::get('/bookings/occupied-times', [OrderController::class, 'getOccupiedTimes'])->name('bookings.occupied-times');
Route::get('/bookings/available-slots', [CheckoutController::class, 'getAvailableSlots'])->name('bookings.available-slots');
//CATEGORY ROUTES
// Route::post('/create-category', [PostCategories::class,'createCategory']);







Route::get('/items/select2', [ItemController::class, 'select2Items'])->name('items.select2');
// Route::get('/get-allcategories', [CategoryController::class, 'getAll'])->name('categories.get');

Route::get('/api/item-options', [ItemOptionController::class, 'getOptions']);
Route::get('/item-categories', [ItemOptionController::class, 'getCategories']);

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

// NAME VALIDATION UNIQUE
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





// cart
Route::middleware(['auth', 'verified'])->group(function () {
    // ------------------------------------------------

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
// Route::get('/checkoutpage', function () {
//     return view('checkoutpage');
// });


// CHECKOUT ROUTEE
Route::get('/checkout', [CheckoutController::class, 'show'])->name('checkout.show');
Route::middleware('auth')->group(function () {
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

    // After order creation, a confirmation page.
    Route::get('/order/confirmation/{order}', [OrderController::class, 'confirmation'])->name('order.confirmation');
});
// SEARCH
Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/privacy-policyshow', [PrivacyPolicyController::class, 'show'])->name('privacy-policy.show');

Route::post('/reviews/submit', [ReviewController::class, 'store'])->name('reviews.leaveReview');

// CUSTOMER ROUTE IF LOGGED IN
Route::middleware(['auth', 'verified', PreventAdminAccess::class])->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cartver2', [CartController::class, 'index2'])->name('cart.index2');
    Route::get('/cartdup', [CartController::class, 'index3'])->name('cart.sanagumana');
    // cancel order
    Route::put('/orders/{order}/cancelOrder', [OrderController::class, 'cancel'])->name('orderUser.cancel');
    // Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.leaveReview');

    Route::get('/test-route', function() {
        return [
            'review_route' => route('reviews.leaveReview'),
            'base_url' => url('/')
        ];
    });

    Route::get('/reviews/{id}/edit', [ReviewController::class, 'edit'])->name('reviews.editReview');
    Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('reviews.updateReview');
});

Route::delete('/reviews/{review}/delete', [ReviewController::class, 'destroy'])->name('reviews.destroy');



//USERS
Route::post('/api/users/create', [UserApiController::class, 'store'])->name('api.users.store');
Route::get('/api/users/{id}', [UserApiController::class, 'show'])->name('api.users.show');
Route::put('/api/users/{id}', [UserApiController::class, 'update'])->name('api.users.update');
Route::delete('/api/users/{id}', [UserApiController::class, 'destroy'])->name('api.users.destroy');
Route::put('/api/users/{id}/role', [UserApiController::class, 'updateRole'])->name('api.users.role');

Route::get('/api/orders/{id}/details', [OrderController::class, 'getOrderDetails']);
Route::get('/api/orders/{id}', [OrderController::class, 'getPenalties']);

// route for admin
Route::middleware(['auth', 'admin'])->group(function () {

    Route::resource('users', UserController::class);
    // CMS MANAGEMENT admin.hero.index
    Route::prefix('admin')->name('admin.')->group(function () {

        // NAVBAR CMS
        Route::get('/navbar', [NavbarSettingController::class, 'index'])->name('navbar.index');
        Route::get('/navbar/edit', [NavbarSettingController::class, 'edit'])->name('navbar.edit');
        Route::put('/navbar/update', [NavbarSettingController::class, 'update'])->name('navbar.update');
        // Hero Section CMS
        Route::get('/hero-section', [HeroSectionController::class, 'index'])->name('hero.index');
        Route::put('/hero-section/{id}', [HeroSectionController::class, 'update'])->name('hero.update');

        // WHY CHOOSE US
        Route::get('/whychooseus-section', [WhyChooseUsSectionController::class, 'index'])->name('whychoose.index');
        Route::put('/whychooseus-section/{id}', [WhyChooseUsSectionController::class, 'update'])->name('whychoose.update');

        // ABOUT US
        Route::get('/adboutus-section', [AboutUsSectionController::class, 'index'])->name('aboutus.index');
        Route::put('/aboutus-section/{id}', [AboutUsSectionController::class, 'update'])->name('aboutus.update');

        // REVIEWS
        Route::get('/review-section', [ReviewSectionSettingController::class, 'index'])->name('review.index');
        Route::get('/review-section-settings', [ReviewSectionSettingController::class, 'edit'])->name('review.edit');
        Route::put('/review-section/{id}', [ReviewSectionSettingController::class, 'update'])->name('review.update');

        // FOOTER
        Route::get('/footer-section', [FooterSectionController::class, 'index'])->name('footer.index');
        Route::put('/footer-section/{id}', [FooterSectionController::class, 'update'])->name('footer.update');
        // PRIVACY POLICY

        Route::get('/admin/privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy.index');
        Route::put('/admin/privacy-policy/{id}', [PrivacyPolicyController::class, 'update'])->name('privacy.update');
    });

    // BOOK SETTINGS SERVICE
    Route::get('/booking-settings', [BookingSettingController::class, 'index'])->name('admin.booking-settings.index');
    Route::get('/booking-settings/edit', [BookingSettingController::class, 'edit'])->name('admin.booking-settings.edit');
    Route::put('/booking-settings/update', [BookingSettingController::class, 'update'])->name('admin.booking-settings.update');

    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');
    // ROUTE IN ADMIN DASHBOARDS
    Route::get('/admin/finaldashboard', [AdminController::class, 'goDashboard'])->name('admin.finaldashboard');
    Route::get('/admin/finaldashboard/settings', [AdminController::class, 'gosettingDashboard'])->name('admin.settingdashboard');
    Route::get('/admin/finaldashboard/category', [AdminController::class, 'goCategoryDashboard'])->name('admin.categorydashboard');
    Route::get('/admin/finaldashboard/products', [AdminController::class, 'goProductsDashboard'])->name('admin.products');
    Route::get('/admin/finaldashboard/packages', [AdminController::class, 'goPackageDashboard'])->name('admin.packages');

    // PACKAGE UTILITIES
    Route::get('/admin/finaldashboard/utilities', [AdminController::class, 'goUtilityDashboard'])->name('admin.utilities');
    Route::post('/packageutility/store', [PackageUtilityController::class, 'store'])->name('package_utilities.store');
    Route::put('/packageutility/update/{id}', [PackageUtilityController::class, 'update'])->name('package_utilities.update');
    // Route::delete('/packageutility/delete/{id}', [PackageUtilityController::class, 'destroy'])->name('package_utilities.destroy');

    // UTILITY ADD
    Route::resource('utilities', UtilityController::class);

    Route::get('/admin/finaldashboard/reports', [AdminController::class, 'goReportsDashboard'])->name('admin.reports');
    Route::get('/admin/finaldashboard/bookings', [AdminController::class, 'goBookingsDashboard'])->name('admin.bookings');
    Route::get('/admin/finaldashboard/users', [AdminController::class, 'goUserDashboard'])->name('admin.allusers');
    Route::get('/admin/finaldashboard/reports/customer', [AdminController::class, 'goCustomerReport'])->name('admin.reports.customer');
    Route::get('/admin/finaldashboard/reports/penalties', [PenaltyController::class, 'index'])->name('admin.reports.penalties');

    // Route::get('/admin/admindashboard', [AdminController::class, 'dashboard'])->middleware('verified')->name('admin.admindashboard');
    Route::get('/admin/admindashboard', [AdminController::class, 'dashboard'])->name('admin.admindashboard');


    // ULAM ITEM STORE
    Route::resource('items', ItemController::class);
    Route::post('/items/check-name', [ItemController::class, 'checkName'])->name('items.checkName');
    Route::put('/items/{id}/edit', [ItemController::class, 'update'])->name('item.edit');
    Route::delete('/items/{id}', [ItemController::class, 'destroy'])->name('item.delete');

    // ITEM OPTIONS
    Route::post('/items-option/store', [ItemOptionController::class, 'store'])->name('itemOptions.store');
    Route::put('/item-options/{id}', [ItemOptionController::class, 'update'])->name('itemOption.edit');
    Route::delete('/item-options/{id}', [ItemOptionController::class, 'destroy'])->name('itemOption.delete');
    Route::post('/item-options/check-type', [ItemOptionController::class, 'checkType'])->name('itemOptions.checkType');

    // LINK OPTION TO ITEMS
    Route::post('/items/link-options', [ItemOptionController::class, 'linkItemOptionToItem'])->name('items.linkItemOption');
    Route::post('/items/unlink-item-option', [ItemOptionController::class, 'unlinkItemOptionFromItem'])->name('items.unlinkItemOption');

    Route::get('/item-options/{itemId}', [ItemOptionController::class, 'getItemOptions'])->name('item-options.fetch');
    // GET EXISTING ITEM OPTION TO ITEM
    Route::get('/items/{itemId}/existing-options', [ItemOptionController::class, 'getExistingItemOptionsForItem'])->name('items.getExistingOptions');
    Route::get('/admin/package/{packageId}/assigned-options', [AdminController::class, 'getAssignedOptions']);


    // LINK ITEMS TO PACKAGE ROUTE
    Route::post('/packages/{packageId}/link-items', [PackageController::class, 'linkItemsToPackage'])->name('packages.linkItemsToPackage');
    Route::post('/link-item-to-package', [PackageController::class, 'addItemToPackage'])->name('admin.addItemToPackage');
    // LINK UTILS TO PACKAGE
    Route::post('/link-util-to-package', [PackageController::class, 'addUtilToPackage'])->name('admin.addUtilToPackage');
    Route::get('/get-utilities-for-package', [PackageController::class, 'getUtilitiesForPackage'])->name('getUtilitiesForPackage');

    // DELETE ITEMS  FROM PACKAGE
    Route::delete('packages/{id}/remove-items', [PackageController::class, 'removeItemFromPackage'])->name('admin.removeItemFromPackage');
    Route::get('packages/{id}', [PackageController::class, 'showItemsOnPackage'])->name('package.show');


    // Route to fetch item options via AJAX
    Route::get('/items/{item}/available-options', [AdminController::class, 'getItemOptions'])->name('admin.getItemOptions');
    // GET PACKAGE OPTIONS BASED ON PACKAGE
    Route::get('/admin/package-item-options/{packageId}/{itemId}', [AdminController::class, 'packageItemOptions']);


    // categiry
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::post('/categories/store', [CategoryController::class, 'addCategory'])->name('categories.addCategory');
    Route::put('/categories/{id}/edit', [CategoryController::class, 'editCategory'])->name('categories.edit');
    Route::delete('/categories/{id}', [CategoryController::class, 'deleteCategory'])->name('categories.delete');

    // invoice and filter
    Route::get('/orders/{order}/invoice', [OrderController::class, 'generateInvoice'])->name('order.invoice');
    Route::get('/orders/filter', [OrderController::class, 'index'])->name('orders.filter');




    // booking  management
    Route::get('/orders/{order}/invoice', [OrderController::class, 'generateInvoice'])->name('order.invoice');
    Route::put('/orders/{order}/mark-paid', [OrderController::class, 'markAsPaid'])->name('orders.mark-paid');
    Route::put('/orders/{order}/mark-unpaid', [OrderController::class, 'markAsUnpaid'])->name('orders.mark-unpaid');
    Route::put('/orders/{order}/mark-ongoing', [OrderController::class, 'markAsOngoing'])->name('orders.mark-ongoing');
    Route::put('/orders/{order}/mark-partial', [OrderController::class, 'markAsPartial'])->name('orders.mark-partial');
    Route::put('/orders/{order}/mark-completed', [OrderController::class, 'markAsCompleted'])->name('orders.mark-completed');
    Route::put('/orders/{order}/cancel', [OrderController::class, 'cancelOrder'])->name('order.cancel');
    Route::delete('/orders/{id}', [OrderController::class, 'destroy'])->name('orders.destroy');
    Route::put('/orders/{order}/archive', [OrderController::class, 'archive'])->name('orders.archive');


    // PENALTY
    Route::post('/orders/{order}/add-penalty', [OrderController::class, 'addPenalty'])->name('orders.add-penalty');

    Route::post('/store', [PenaltyController::class, 'store'])->name('api.penalties.store');
    Route::post('/create', [PenaltyController::class, 'create'])->name('api.penalties.create');
    Route::get('/{penalty}', [PenaltyController::class, 'show'])->name('api.penalties.show');
    Route::put('/{penalty}', [PenaltyController::class, 'update'])->name('api.penalties.update');
    Route::delete('/{penalty}', [PenaltyController::class, 'destroy'])->name('api.penalties.destroy');

    // AJAX ROUTE
    Route::get('/get-custom-date-range', [AdminController::class, 'getCustomDateRangeData'])
    ->name('admin.reports.customRange');
    Route::get('/chart/custom-range', [AdminController::class, 'customChartRange'])->name('chart.customRange');

});


