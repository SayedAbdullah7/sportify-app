<?php

use App\Http\Controllers\ProfileController;
use App\Http\Resources\StadiumOwnerResource;
use App\Models\StadiumOwner;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::resource('user', \App\Http\Controllers\UserController::class);
Route::resource('admin', \App\Http\Controllers\AdminController::class);
Route::resource('stadium-owner', \App\Http\Controllers\StadiumOwnerController::class);

Route::get('/home', function () {
    return view('welcome');
})->name('home');

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::get('/test', function () {
    $model = StadiumOwner::first();
    $array = new StadiumOwnerResource($model);
    return dd($array);
});
require __DIR__.'/auth.php';
