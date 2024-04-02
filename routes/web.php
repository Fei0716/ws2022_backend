<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ScoreController;

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

Route::middleware('guest')->group(function(){
    Route::get('/admin' , [AuthController::class, 'index'])->name('loginPage');
    Route::post('/login' , [AuthController::class, 'login'])->name('login');
});

Route::middleware('auth')->group(function(){
    Route::get('/' , [AdminController::class, 'index'])->name('admin.index');
    Route::post('/logout' , [AuthController::class, 'logout'])->name('logout');

    // for managing users
    Route::get('/user', [UserController::class, 'index'])->name('user.index');
    Route::get('/user/{user}' , [UserController::class, 'show'])->name('user.profile');
    Route::put('/user/{user}/unblock' , [UserController::class, 'unblock'])->name('user.unblock');
    Route::put('/user/{user}/block' , [UserController::class, 'block'])->name('user.block');

    // for managing games
    Route::resource('game' , GameController::class)->only(['index', 'show' ,'destroy']);
    // for removing scores
    Route::delete('/score/{game}' , [ScoreController::class,'destroyAll'])->name('score.destroyAll');

    Route::delete('/scores/{score}' , [ScoreController::class,'destroy'])->name('score.destroy');
    Route::delete('/score/{user}/{game}' , [ScoreController::class,'destroyPlayer'])->name('score.destroyPlayer');
});
