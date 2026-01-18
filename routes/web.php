<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController,
    App\Http\Controllers\ProductoController,
    App\Http\Controllers\PlantillaController,
    App\Http\Controllers\PdfController;
    

Route::get('/', function () {
    return view('welcome');
});

#main
Route::get('/main', [MainController::class, 'main']);

#producto
Route::get('/productos', [ProductoController::class, 'mostrar']);
Route::get('/producto/crear', [ProductoController::class, 'create']);
Route::post('/productos', [ProductoController::class, 'store']);

#plantilla
Route::get('/plantilla', [PlantillaController::class, 'plantilla']);
#pdf
Route::get('/pdf', [PdfController::class, 'descargarPdf']);