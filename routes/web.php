<?php

use App\Http\Controllers\ProfileController;
use App\Http\Resources\StadiumOwnerResource;
use App\Models\StadiumOwner;
use App\Models\Team;
use App\Models\User;
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


Route::get('/home', function () {
    return view('welcome');
})->name('home');

Route::get('/', function () {
    return view('welcome');
});

//Route::get('/dashboard', function () {
//    return view('dashboard');
//})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('user', \App\Http\Controllers\UserController::class);
    Route::resource('admin', \App\Http\Controllers\AdminController::class);
    Route::resource('stadium-owner', \App\Http\Controllers\StadiumOwnerController::class);
    Route::resource('sport', \App\Http\Controllers\SportsController::class);
    Route::resource('stadium-type', \App\Http\Controllers\StadiumTypeController::class);

    Route::post('/upload-image', [\App\Http\Controllers\StadiumOwnerController::class,'uploadImage'])->name('upload-image');

});
Route::get('/update/database', [\App\Http\Controllers\UpdateController::class, 'database']);
Route::get('/test', function () {
    $user = 1;
    return User::find($user);
    return !strpos("I love php, I love php too!","pshp");
    $a='foo';
    function foo(){echo 'hey';}
    return $a();
    $users = User::all();
     $sports = \App\Models\Sport::with(['positions'])->get();
//    Team::factory()
//        ->count(40)
//        ->create();
    $teams = Team::with('sport.positions')->get();
//    $team = Team::first();
    foreach ($teams as $team) {
        foreach ($team->sport->positions as $position){
//            return $position;
            $team->users()->attach($users->first(),['position_id'=>$position->id]);
        }
        return $team->load('users');
//            $sport = Sport::create(['name' => Str::lower($sportName)]);
//            $sport->positions()->createMany(array_map(function ($position) {
//                return ['name' => Str::lower($position)];
//            }, $positions));
    }



    $guards =[];
    if(\Illuminate\Support\Facades\Auth::guard('admin')->check()){
        $guards[] = 'admin';
    }
//
//    if(\Illuminate\Support\Facades\Auth::guard('user')->check()){
//        $guards[] = 'user';
//    }

    if(\Illuminate\Support\Facades\Auth::guard('web')->check()){
        $guards[] = 'web';
    }

    return $guards;

});
require __DIR__.'/auth.php';

Route::get('/clear-cache', function () {
    return \Artisan::call('optimize:clear');
});

Route::get('storage-link', function (){
    return \Illuminate\Support\Facades\Artisan::call('storage:link');
});
