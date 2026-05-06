<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InventoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
  
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [AuthController::class, 'users']);
    Route::get('/user', [AuthController::class, 'user']);
    Route::post('/logout', [AuthController::class,'logout']);
    Route::post('/add-user', [AuthController::class,'store']);
    Route::put('/update-user/{id}', [AuthController::class,'update']);
    Route::delete('/del-user/{id}', [AuthController::class,'destroy']);

    Route::get('/all-inventory', [InventoryController::class, 'index']);
    Route::post('/add-inventory', [InventoryController::class, 'store']);
    Route::put('/update-inventory/{id}', [InventoryController::class, 'update']);
    Route::delete('/del-inventory/{id}', [InventoryController::class, 'destroy']);
    });