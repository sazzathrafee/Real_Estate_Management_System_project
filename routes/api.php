<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PropertyApiController;

Route::get('/properties', [PropertyApiController::class, 'index']);
Route::get('/properties/featured', [PropertyApiController::class, 'featured']);
Route::get('/properties/city/{city}', [PropertyApiController::class, 'byCity']);
Route::get('/properties/type/{type}', [PropertyApiController::class, 'byType']);
Route::get('/properties/{id}', [PropertyApiController::class, 'show']);
Route::post('/properties', [PropertyApiController::class, 'store']);
Route::put('/properties/{id}', [PropertyApiController::class, 'update']);
Route::delete('/properties/{id}', [PropertyApiController::class, 'destroy']);
