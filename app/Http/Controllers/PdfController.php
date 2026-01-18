<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function descargarPdf()
    {
        $data = [
            'modo' => 'pdf',
            'nombre' => 'PRUEBA PDF'
        ];

        $pdf = Pdf::loadView('productos.plantilla', $data)
            ->setPaper('legal', 'portrait')
            ->setOption('dpi', 72)
            ->setOption('defaultFont', 'Helvetica');


        return Pdf::loadView('productos.plantilla', $data)
            ->setPaper('legal', 'portrait')
            ->download('test.pdf');
    }
}
