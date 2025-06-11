<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Property\PropertyController;

Route::middleware('auth:api')->group(function () {
    Route::post('/create-property', [PropertyController::class, 'createProperty']);
});

