<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PersonController;
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

Route::middleware(['auth:sanctum'])->prefix('/users')->group(function() {
    Route::get('/all', [UserController::class, 'getAll']);
});

Route::middleware([])->prefix('/persons')->group(function() {
    Route::get("/",         [PersonController::class, 'index']);
    Route::get("/all",      [PersonController::class, 'getAll']);
    Route::get("/{id}",     [PersonController::class, 'show']);
    Route::post("/",        [PersonController::class, 'store']);
    Route::put("/{id}",     [PersonController::class, 'update']);
    Route::delete("/{id}",  [PersonController::class, 'destroy']);
});



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
