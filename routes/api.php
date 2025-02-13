<?php

use App\Http\Controllers\Api\VehicleController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::resource('vehicles', VehicleController::class)->except(['create', 'edit']);
    Route::get('vehicles/vtp/{filename}', [VehicleController::class, 'serveVTP']);
});
