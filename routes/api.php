<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BookController;
use App\Models\User;
use App\Models\Book;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/authenticated', function () {
    return true;
});


Route::prefix('/user')->group( function (){
    Route::post('/register', [userController::class , 'register']);
    Route::post('/login', [userController::class , 'login']);
    Route::post('/logout', [userController::class , 'logout']);
    Route::get('/check', [userController::class , 'checkLogin']);
});

// Route::post('/create', [UserController::class , 'register']);


Route::prefix('/book')->group( function (){
    Route::post('/store', [BookController::class , 'store']);
    Route::get('/show/{id_user}', [BookController::class , 'show']);
    Route::delete('/delete/{id}',[BookController::class, 'destroy']);
    Route::put('/update/{id}',[BookController::class, 'update']);
  
});