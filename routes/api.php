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
//Route::middleware(['auth:sanctum'])->group(function () {

Route::get('/test', function (Request $request) {
    \Illuminate\Support\Facades\Auth::guard('user')->attempt(['phone'=>'01155032697']);
    return auth()->user();
    $user = \App\Models\User::find(10);
    return $user->isPendingFriendsTo('1');
//    return $user->pendingFriendsTo()->get(); //الناس اللي اليوزر بعتلهم
//    return $request->user();
    });
//});

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
                Route::delete('/reject', [\App\Http\Controllers\Api\FriendController::class,'reject']);
                Route::delete('/cancel', [\App\Http\Controllers\Api\FriendController::class,'cancel']);
                Route::delete('/delete', [\App\Http\Controllers\Api\FriendController::class,'delete']);

                Route::get('/sentRequests', [\App\Http\Controllers\Api\FriendController::class,'getSentRequests']);
                Route::get('/pendingRequests', [\App\Http\Controllers\Api\FriendController::class,'getPendingRequests']);
            });

            Route::prefix('team')->group(function () {
                Route::get('/', [\App\Http\Controllers\Api\TeamController::class,'index']);
                Route::post('/', [\App\Http\Controllers\Api\TeamController::class,'store']);
                Route::post('/update', [\App\Http\Controllers\Api\TeamController::class,'update']);
                Route::post('/add-member', [\App\Http\Controllers\Api\TeamController::class,'addMember']);
            });

            Route::get('/sport', [\App\Http\Controllers\Api\SportController::class,'index']);
            Route::post('/sport', [\App\Http\Controllers\Api\SportController::class,'store']);

            Route::get('/stadium', [\App\Http\Controllers\Api\StadiumController::class,'index']);

            Route::get('/stadium', [\App\Http\Controllers\Api\StadiumController::class,'store']);


//            Route::apiResource('team', \App\Http\Controllers\TeamController::class)->only(['index','store']);



    });

});
