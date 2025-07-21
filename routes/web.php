<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
   if (auth()->check()) {
        return redirect('/home');
    } else {
        return redirect('/login');
    }
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
