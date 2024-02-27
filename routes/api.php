<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\GameController;
use App\Http\Controllers\Api\v1\UserController;
use App\Http\Controllers\Api\v1\ScoreController;

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
    Route::prefix('v1')->middleware('json.response')->group(function(){
        Route::post('/auth/signup' , [AuthController::class, 'signup']);
        Route::post('/auth/signin' , [AuthController::class, 'signin']);

        // Below are routes that required token
        Route::middleware('auth:sanctum')->group(function(){
            Route::post('auth/signout' , [AuthController::class, 'signout']);
            Route::apiResource('games' , GameController::class);
            Route::get('users/{user}' , [UserController::class , 'show']);
            Route::get('games/{game}/scores' , [ScoreController::class , 'show']);
            Route::post('games/{game}/scores' , [ScoreController::class , 'store']);

            Route::get('games/{game}/{version}' , [GameController::class, 'getGameFile']);
            Route::post('games/{game}/upload' , [GameController::class,'uploadGameFile']);
        });
    });

