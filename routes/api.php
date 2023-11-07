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

Route::get('/test', function (Request $request) {
    return $request->user();
});
Route::middleware([])->group(function () {
    Route::middleware([])->prefix('stadium-owner')->group(function () {
        //login and
//        Route::post('/generate-otp-availability', [\App\Http\Controllers\Api\StadiumOwnerController::class, 'generateOtpAvailability']);
        Route::post('/generate-otp', [\App\Http\Controllers\Api\StadiumOwnerController::class, 'generateOtp']);
        Route::post('/verify-otp', [\App\Http\Controllers\Api\StadiumOwnerController::class, 'verifyOtp']);
    });
    Route::middleware([])->prefix('user')->group(function () {
        //login and register
        Route::post('/generate-otp', [\App\Http\Controllers\Api\UserController::class,'generateOtp']);
        Route::post('/verify-otp', [\App\Http\Controllers\Api\UserController::class,'verifyOtp']);
        Route::post('/register', [\App\Http\Controllers\Api\UserController::class,'register']);

        Route::middleware(['auth:sanctum'])->group(function () {
            Route::get('/show', [\App\Http\Controllers\Api\UserController::class,'show']);
            Route::post('/update', [\App\Http\Controllers\Api\UserController::class,'update']);

        });
    });

    Route::middleware(['auth:sanctum'])->group(function () {
            Route::prefix('friend')->group(function () {
                Route::get('/', [\App\Http\Controllers\Api\FriendController::class,'index']);
                Route::post('/send', [\App\Http\Controllers\Api\FriendController::class,'send']);
                Route::get('/available', [\App\Http\Controllers\Api\FriendController::class,'available']);
                Route::post('/accept', [\App\Http\Controllers\Api\FriendController::class,'accept']);

                Route::get('/sentRequests', [\App\Http\Controllers\Api\FriendController::class,'getSentRequests']);
                Route::get('/pendingRequests', [\App\Http\Controllers\Api\FriendController::class,'getPendingRequests']);

            });

    });

});
