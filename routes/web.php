<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController,
    App\Http\Controllers\PlantillaController,
    App\Http\Controllers\PdfController;
    
    


Route::middleware('auth')->group(function () {

    Route::get('/formulario', [PlantillaController::class, 'plantilla']);

    #pdf
    Route::post('/pdf', [PdfController::class, 'descargarPdf'])
        ->name('formulario.pdf');

    Route::post('/buscar-datos', [PdfController::class, 'buscar'])->name('datos.buscar');

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});

#login
Route::middleware('guest')->group(function () {
    Route::get('/login', [App\Http\Controllers\AuthController::class, 'showLogin'])->name('login');
    Route::post('/register', [App\Http\Controllers\AuthController::class, 'register'])->name('register');
    Route::post('/login', [App\Http\Controllers\AuthController::class, 'login'])->name('login.post');
});



