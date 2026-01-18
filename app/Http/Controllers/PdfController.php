<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function descargarPdf(Request $request)
    {
        $data = [
            'modo' => 'pdf',
            'nombre' => 'PRUEBA PDF'
        ];

        $purchase_order = $request->purchase_order;

        $pdf = Pdf::loadView('productos.plantilla', $data)
            ->setPaper('legal', 'portrait')
            ->setOption('dpi', 72)
            ->setOption('defaultFont', 'Verdana');


        return Pdf::loadView('productos.plantilla', [
            'modo' => 'pdf',
            'nombre' => 'PRUEBA PDF',
            'purchase_order' => $purchase_order,

        ])
            ->setPaper('legal', 'portrait')
            ->download('formulario.pdf');
    }
}
