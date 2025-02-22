<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

//GET route example
Route::get('/', function () {
    return view('home');
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