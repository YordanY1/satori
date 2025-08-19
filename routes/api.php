<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\EcontDirectoryController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::prefix('econt')->group(function () {
    Route::get('/cities',  [EcontDirectoryController::class, 'cities']);   // GET /api/econt/cities
    Route::get('/offices', [EcontDirectoryController::class, 'offices']);  // GET /api/econt/offices
});
