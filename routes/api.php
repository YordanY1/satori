<?php


use App\Http\Controllers\EcontDirectoryController;

Route::get('/econt/cities',  [EcontDirectoryController::class, 'cities']);
Route::get('/econt/offices', [EcontDirectoryController::class, 'offices']);
