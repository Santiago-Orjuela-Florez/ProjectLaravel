<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductoController,
    App\Http\Controllers\PlantillaController,
    App\Http\Controllers\PdfController;
    

Route::get('/', [PlantillaController::class, 'plantilla']);
#pdf
Route::post('/pdf', [PdfController::class, 'descargarPdf'])
    ->name('formulario.pdf');

#producto
Route::get('/productos', [ProductoController::class, 'mostrar']);
Route::get('/producto/crear', [ProductoController::class, 'create']);
Route::post('/productos', [ProductoController::class, 'store']);



