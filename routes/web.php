<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('{page}', 'App\Http\Controllers\MainController')->where('page', '.*');
