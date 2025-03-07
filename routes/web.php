<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileLinkController;

Auth::routes();

Route::get('/file/download/{token}', function ($token) {
    return view('download', ['token' => $token]);
})->name('file.download');

Route::post('/file/download/{token}', [FileLinkController::class, 'download'])->name('file.download.process');

Route::get('{page}', 'App\Http\Controllers\MainController')->where('page', '.*');
