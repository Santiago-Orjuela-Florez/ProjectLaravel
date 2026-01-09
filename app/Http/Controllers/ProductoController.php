<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    public function mostrar()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }
    public function create()
    {
        return view('productos.create');
    }
    public function store(Request $request)
    {
        Producto::create([
            'nombre' => $request -> input ('nombre'),
            'precio' => $request -> input ('precio'),
        ]);
        return redirect('/productos');
    }
}
