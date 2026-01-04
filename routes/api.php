<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VenueController;    
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\AuthApiController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentsController;
// use App\Http\Controllers\AuthApiController; 

Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);

Route::middleware( 'auth:sanctum')->group(function () {
    Route::get('/profile', [AuthApiController::class, 'profile']);
    Route::post('/logout', [AuthApiController::class, 'logout']);

});
// routes/api.php
Route::apiResource('orders', OrderController::class);
Route::apiResource('venues', VenueController::class); 
Route::apiResource('categories', CategoryController::class); 
Route::apiResource('events', EventController::class);

Route::post('/payment', [PaymentsController::class, 'store']);
Route::post('/payment/callback', [PaymentsController::class, 'callback']);