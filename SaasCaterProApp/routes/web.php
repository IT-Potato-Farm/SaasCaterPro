<?php

use Illuminate\Support\Facades\Route;

//GET routes examples
Route::get('/', function () {
    return view('home');
});

//Parameters using Routes
Route::get('/portfolio/{firstname}/{lastname}', function ($firstname, $lastname) {
    return $firstname . " " . $lastname;
});