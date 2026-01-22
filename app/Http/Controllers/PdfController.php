<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class PdfController extends Controller
{
    public function buscar(Request $request)
    {
        try {
            // Validar los datos de entrada
            $request->validate([
                'material' => 'required',
                'documento' => 'required',
            ]);

            // Debug: Ver qué datos llegan
            \Log::info('Buscando datos:', [
                'material' => $request->material,
                'documento' => $request->documento
            ]);

            // Reutilizamos la lógica de tu consulta
            $totalQuantity = DB::table('registros')
                ->join('batches', 'registros.id', '=', 'batches.registro_id')
                ->where('registros.material', $request->material)
                ->where('registros.material_document', $request->documento)
                ->sum('batches.quantity');

            // Obtener descripción
            $descripcion = DB::table('registros')
                ->where('material', $request->material)
                ->where('material_document', $request->documento)
                ->value('material_description');

            // Obtener lista de batches concatenados
            $batchesIds = DB::table('registros')
                ->join('batches', 'registros.id', '=', 'batches.registro_id')
                ->where('registros.material', $request->material)
                ->where('registros.material_document', $request->documento)
                ->pluck('batches.batch')
                ->unique()
                ->implode(', ');

            // Obtener fecha (tomamos la del primer batch encontrado)
            $fecha = DB::table('registros')
                ->join('batches', 'registros.id', '=', 'batches.registro_id')
                ->where('registros.material', $request->material)
                ->where('registros.material_document', $request->documento)
                ->whereNotNull('batches.date')
                ->value('batches.date');

            $result = [
                'material' => $request->material,
                'material_document' => $request->documento,
                'material_description' => $descripcion,
                'total_quantity' => (int) $totalQuantity,
                'batches_list' => $batchesIds,
                'delivery_date' => $fecha // Enviamos la fecha
            ];

            \Log::info('Resultado encontrado:', $result);

            // Respondemos con JSON para que JavaScript lo lea
            return response()->json($result);

        } catch (\Exception $e) {
            \Log::error('Error en buscar:', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function descargarPdf(Request $request)
    {
        // 1. Validación de datos
        $data = $request->validate([
            'purchase_order' => 'required',
            'material_number' => 'required',
            'ean' => 'required',
            'delivery_date' => 'required',
            'batch' => 'required',
            'quantity' => 'required',
            'nombre_seleccionado' => 'required',
            'batches' => 'nullable|string', // Campo adicional para información extra de batches
        ]);

        // 2. Ejecución de la consulta con Agrupamiento (GroupBy)
        // Agregamos groupBy para que el SUM() funcione correctamente en SQL
        $result = DB::table('registros')
            ->join('batches', 'registros.id', '=', 'batches.registro_id')
            ->select(
                'registros.material',
                'registros.material_description',
                'registros.material_document',
                'batches.batch',
                'batches.date',
                DB::raw('SUM(batches.quantity) as total_quantity')
            )
            ->where('registros.material', '=', $request->purchase_order)
            ->where('registros.material_document', '=', $request->material_number)
            ->where('batches.date', '=', $request->delivery_date)
            ->where('batches.batch', '=', $request->batch)
            ->groupBy(
                'registros.material',
                'registros.material_description',
                'registros.material_document',
                'batches.batch',
                'batches.date'
            )
            ->first();

        // 3. Generación y descarga del PDF
        // Pasamos todos los datos necesarios en un solo array
        return Pdf::loadView('productos.plantilla', [
            'modo' => 'pdf',
            'nombre' => 'PRUEBA PDF',
            'purchase_order' => $request->purchase_order,
            'material_number' => $request->material_number,
            'ean' => $request->ean,
            'delivery_date' => $request->delivery_date,
            'batch' => $request->batch,
            'quantity' => $request->quantity,
            'batches' => $request->batches, // Campo adicional
            'nombre_seleccionado' => $request->nombre_seleccionado,
            'result' => $result, // Aquí viaja la suma y los datos de la DB
        ])
            ->setPaper('legal', 'portrait')
            ->setOption('dpi', 72)
            ->setOption('defaultFont', 'Verdana')
            ->download('formulario.pdf');
    }
}
