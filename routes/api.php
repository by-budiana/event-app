<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenueController;    
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;


Route::apiResource('venues', VenueController::class); 
Route::apiResource('categories', CategoryController::class); 
Route::apiResource('events', EventController::class);