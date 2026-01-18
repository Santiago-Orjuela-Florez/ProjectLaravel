<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlantillaController extends Controller
{
    public function plantilla()
    {
        return view('productos.plantilla');   
    }
}
