<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

Route::get('/test/{firstname}/{lastname}', function ($firstname, $lastname) {
    return $firstname . " " . $lastname;
});