<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\Property\LeaseApiController;
use App\Http\Controllers\API\Property\PropertyController;

Route::middleware('auth:api')->group(function () {
    Route::post('/create-property', [PropertyController::class, 'createProperty']);
    Route::get('/units/without-building/{entityId}', [PropertyController::class, 'getUnitsWithoutBuilding']);
    Route::get('/buildings/{entityId}', [PropertyController::class, 'getAllBuildings']);
    Route::get('/properties/{entityId}', [PropertyController::class, 'getPropertiesByEntity']);
});


