<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::middleware([])->group(function () {
    Route::middleware([])->prefix('stadium-owner')->group(function () {
        //login and
        Route::get('/generate-otp-availability', [\App\Http\Controllers\Api\StadiumOwnerController::class, 'generateOtpAvailability']);
        Route::get('/generate-otp', [\App\Http\Controllers\Api\StadiumOwnerController::class, 'generateOtp']);
        Route::get('/verify-otp', [\App\Http\Controllers\Api\StadiumOwnerController::class, 'verifyOtp']);
    });
    Route::middleware([])->prefix('user')->group(function () {
        //login and register
        Route::get('/generate-otp', [\App\Http\Controllers\Api\UserController::class,'generateOtp']);
        Route::get('/verify-otp', [\App\Http\Controllers\Api\UserController::class,'verifyOtp']);
        Route::get('/register', [\App\Http\Controllers\Api\UserController::class,'register']);

    });
});
