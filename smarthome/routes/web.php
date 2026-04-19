<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommandeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceController;
use App\Http\Controllers\MaisonController;
use App\Http\Controllers\PieceController;
use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;


Route::get('/', [DashboardController::class, 'index'])->middleware('auth')->name('dashboard');

//Auth routes
Route::get('/login', function () {
    return view('auth.login');
})->name('login.index');

Route::get('/register', function () {
    return view('auth.register');
})->name('register.index');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Routes homes
Route::get('/homes/create', function () {
    return view('homes.create');
})->middleware('auth')->name('homes.create');

Route::post('/homes/store', [MaisonController::class, 'store'])->middleware('auth')->name('homes.store');

Route::get('/homes/{id}', [MaisonController::class, 'show'])->middleware('auth')->name('homes.show');
//Routes device
Route::get('/devices', function () {
    return 'Devices';
})->middleware('auth')->name('devices');

// Routes Rooms
Route::get('/rooms', [PieceController::class, 'index'])->middleware('auth')->name('rooms');
// Route::get('/rooms', function () {
//     return view('rooms.index');
// })->name('rooms');

Route::get('/rooms/create', function () {
    return view('rooms.create');
})->name('rooms.create');

Route::get('/rooms/{id}', [PieceController::class, 'show'])->middleware('auth')->name('rooms.show');


Route::post('/rooms/store', [PieceController::class, 'store'])->middleware('auth')->name('rooms.store');

// Routes for devices
Route::post('/devices/store', [DeviceController::class, 'store'])->middleware('auth')->name('devices.store');

//Routes for commandes
Route::post('commande/send', [CommandeController::class, 'send'])->middleware('auth')->name('commande.send');
// // Routes scènes
// Route::get('/scenes', function () {
//     return 'Scenes';
// })->middleware('auth')->name('scenes');

// Route::get('/notifications', function () {
//     return 'Notifications';
// })->middleware('auth')->name('notifications');

// Route::get('/settings', function () {
//     return 'Settings';
// })->middleware('auth')->name('settings');

