<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController,
    App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('welcome');
});

#main
Route::get('/main', [MainController::class, 'main']);

#producto
Route::get('/productos', [ProductoController::class, 'mostrar']);
Route::get('/producto/crear', [ProductoController::class, 'create']);
Route::post('/productos', [ProductoController::class, 'store']);