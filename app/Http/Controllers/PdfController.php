<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function descargarPdf(Request $request)
    {
        $data = $request->validate([
            'purchase_order' => 'required',
            'material_number' => 'required',
            'ean' => 'required',
            'delivery_date' => 'required',
            'batch' => 'required',
            'quantity' => 'required',
            'nombre_seleccionado' => 'required',
        ]);

        

        $purchase_order = $request->purchase_order;
        $material_number = $request->material_number;
        $ean = $request->ean;
        $delivery_date = $request->delivery_date;
        $batch = $request->batch;
        $quantity = $request->quantity;
        $nombre_seleccionado = $request->nombre_seleccionado;

        // Note: The $pdf variable assignment below seems unused as we return a new Pdf instance, preserving existing structure though.
        $pdf = Pdf::loadView('productos.plantilla', $data)
            ->setPaper('legal', 'portrait')
            ->setOption('dpi', 72)
            ->setOption('defaultFont', 'Verdana');


        return Pdf::loadView('productos.plantilla', [
            'modo' => 'pdf',
            'nombre' => 'PRUEBA PDF',
            'purchase_order' => $purchase_order,
            'material_number' => $material_number,
            'ean' => $ean,
            'delivery_date' => $delivery_date,
            'batch' => $batch,
            'quantity' => $quantity,
            'nombre_seleccionado' => $nombre_seleccionado,
        ])
            ->setPaper('legal', 'portrait')
            ->download('formulario.pdf');
    }
}
