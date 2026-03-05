<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

use App\Http\Controllers\VehiculoController;

Route::resource('vehiculos', VehiculoController::class);