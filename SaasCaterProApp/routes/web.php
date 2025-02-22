<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

//GET route example
Route::get('/landing', function () {
    return view('landing');
});

Route::get('/home', function () {
    return view('home');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/register', function () {
    return view('register');
});

//Parameters using routes
Route::get('/parameter/{firstname}/{lastname}', function ($firstname, $lastname) {
    return $firstname . " " . $lastname;
});

//Named routes using name()
Route::get('/test', function () {
    return "This is a Test!";
})->name("testpage");

//Grouped routes using prefix()
Route::get('/portfolio', function () {
    return view('portfolio');
});

Route::prefix("portfolio")->group(function() {
    Route::get('/company', function () {
        return view('company');
    });

    Route::get('/organization', function () {
        return view('organization');
    });
});

//POST route example
Route::post("/formsubmitted", function (Request $request) {

    //Validation
    $request->validate([
        'fullname' => 'required|min:3|max:30',
        'email' => 'required|min:3|max:30|email',
    ]);

    $fullname = $request->input("fullname"); //In PHP, $fullname = $_POST["fullname"];
    $email = $request->input("email"); //In PHP, $email = $_POST["email"];
    
    return "Your full name is {$request->input('fullname')}, and your email is $email!";
})->name("formsubmitted");









//Traversy Media Example

use App\Models\Listing;

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
