<?php

use App\Http\Controllers\CommandeController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\DonneeController;
use App\Http\Controllers\PieceController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;





Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::apiResource('users', UserController::class);



Route::apiResource('pieces', PieceController::class);
// Route::apiResource('pieces', PieceController::class);

// Route::post('/commande', [CommandeController::class, 'send']);
Route::get('/devices/{id}/donnees', [DeviceController::class, 'show']);
Route::post('/data', [DonneeController::class, 'store']);
