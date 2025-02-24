<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/get', 'App\Http\Controllers\GetController');
    Route::apiResource('files', 'App\Http\Controllers\FileController');
});
