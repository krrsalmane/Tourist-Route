<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItineraryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::post('/register',[AuthController::class,'register']);
Route::post('/login',[AuthController::class,'login']);
Route::post('/logout',[AuthController::class,'logout']);

Route::apiResource('itineraries', ItineraryController::class);


// // Public
// Route::apiResource('itineraries', ItineraryController::class)->only(['index', 'show']);

// // Protected
// Route::middleware('auth:sanctum')->group(function () {
//     Route::apiResource('itineraries', ItineraryController::class)->except(['index', 'show']);
// });