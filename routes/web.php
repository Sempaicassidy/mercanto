<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('login');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/manager', function () {
    return view('manager.dashboard');
});

Route::get('/manager/dashboard', function () {
    return view('manager.dashboard');
});

Route::get('/manager/analytics', function () {
    return view('manager.analytics');
});

Route::get('/analytics', function () {
    return view('manager.analytics');
});

Route::get('/manager/statistics', function () {
    return redirect('/manager/analytics');
});
