<?php

use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/file/download/{token}', function ($token) {
    return view('download', ['token' => $token]);
})->name('file.download');

Route::get('{page}', 'App\Http\Controllers\MainController')->where('page', '.*');
