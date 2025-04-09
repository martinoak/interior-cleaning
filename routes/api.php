<?php

use App\Http\Controllers\Admin\VehicleController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::resource('vehicles', VehicleController::class)->except(['create', 'edit']);
});
