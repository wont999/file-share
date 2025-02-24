<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FileLinkController;
use App\Http\Controllers\GetController;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::get('/get', [GetController::class, 'index']);
    Route::apiResource('files', FileController::class);

    Route::get('/files/{file}/links', [FileLinkController::class, 'index']);
    Route::post('/files/{file}/links', [FileLinkController::class, 'store']);
    Route::delete('/links/{link}', [FileLinkController::class, 'destroy']);
});

Route::post('/file/download/{token}', [FileLinkController::class, 'download']);
