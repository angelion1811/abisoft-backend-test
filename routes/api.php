<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;
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

Route::middleware(['auth:sanctum'])->prefix('/items')->group(function() {
    Route::get("/",         [ItemController::class, 'index']);
    Route::get("/all",      [ItemController::class, 'getAll']);
    Route::get("/{id}",     [ItemController::class, 'show']);
    Route::post("/",        [ItemController::class, 'store']);
    Route::put("/{id}",     [ItemController::class, 'update']);
    Route::delete("/{id}",  [ItemController::class, 'destroy']);
});

Route::middleware(['auth:sanctum'])->prefix('/tests')->group(function() {
    Route::post("/ping",            [TestController::class, 'ping']);
    Route::get("/",                 [TestController::class, 'index']);

    Route::get("/by-user/{user_id}",[TestController::class, 'getByUser']);
    Route::get("/by-users",         [TestController::class, 'getByUsers']);
    Route::get("/to-item/{item_id}",[TestController::class, 'getToItem']);
    Route::get("/to-items",         [TestController::class, 'getToItems']);

    Route::get("/general-report",   [TestController::class, 'getGeneralReport']);
});

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
