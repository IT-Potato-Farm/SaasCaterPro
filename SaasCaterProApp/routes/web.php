<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

//GET route example
Route::get('/landing', function () {
    return view('landing');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});



//Traversy Media Example

use App\Models\listing;

//All Listings
Route::get('/', function() {
    return view('listings', [
        'heading' => 'Latest Listings',
        'listings' => Listing::all()
    ]);
});

//Single Listing
Route::get('/listings/{id}', function($id) {
    return view('listing', [
        'listing' => Listing::find($id)
    ]);
}); 
