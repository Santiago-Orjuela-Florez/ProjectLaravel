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
                'material_document' => $request->documento,
                'material_lot' => $request->material
            ]);

            // Reutilizamos la lógica de tu consulta
            $totalQuantity = DB::table('registros')
                ->join('batches', 'registros.id', '=', 'batches.registro_id')
                ->where('registros.material', $request->documento)
                ->where('registros.material_document', $request->material)
                ->sum('batches.quantity');

            // Obtener descripción
            $descripcion = DB::table('registros')
                ->where('material', $request->documento)
                ->where('material_document', $request->material)
                ->value('material_description');

            // Obtener lista de batches concatenados
            $batchesArray = DB::table('registros')
                ->join('batches', 'registros.id', '=', 'batches.registro_id')
                ->where('registros.material', $request->documento)
                ->where('registros.material_document', $request->material)
                ->pluck('batches.batch')
                ->unique()
                ->values()
                ->toArray();

            // Lógica de distribución de Batches
            $primaryBatch = '';
            $extraBatchesList = '';

            if (count($batchesArray) > 0) {
                // El primero siempre va al campo principal
                $primaryBatch = $batchesArray[0];

                // Si hay más de uno, el resto va a la lista de extras
                if (count($batchesArray) > 1) {
                    $extraBatchesList = implode(', ', array_slice($batchesArray, 1));
                }
            }

            // Obtener fecha (tomamos la del primer batch encontrado)
            $fecha = DB::table('registros')
                ->join('batches', 'registros.id', '=', 'batches.registro_id')
                ->where('registros.material', $request->documento)
                ->where('registros.material_document', $request->material)
                ->whereNotNull('batches.date')
                ->value('batches.date');

            $result = [
                'material' => $request->material,
                'material_document' => $request->documento,
                'material_description' => $descripcion,
                'total_quantity' => (int) $totalQuantity,
                'primary_batch' => $primaryBatch,       // Dato para el campo 'Batch'
                'extra_batches_list' => $extraBatchesList, // Dato para el campo 'Batches' (abajo)
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
            'sign_warehouse' => 'required',
            'sign_inventory' => 'required',
            'batches' => 'nullable|string',
            'pallets' => 'nullable',
            'units' => 'nullable',
            'pallets2' => 'nullable',
            'units2' => 'nullable',
            'manufacturing_date' => 'nullable',
            'best_before_date' => 'nullable',
            'inspeccion' => 'nullable|array', // Validar array de checkboxes
            'fallos' => 'nullable|array', // Nuevo array para items no cumplidos (X)
            'radio_check' => 'nullable',
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
            'pallets' => $request->pallets,
            'units' => $request->units,
            'pallets2' => $request->pallets2,
            'units2' => $request->units2,
            'manufacturing_date' => $request->manufacturing_date,
            'best_before_date' => $request->best_before_date,
            'delivery_date' => $request->delivery_date,
            'batch' => $request->batch,
            'quantity' => $request->quantity,
            'batches' => $request->batches,
            'inspeccion' => $request->inspeccion, // Pasamos el array de inspección
            'fallos' => $request->fallos, // Pasamos los fallos a la vista
            'sign_warehouse' => $request->sign_warehouse,
            'sign_inventory' => $request->sign_inventory,
            'radio_check' => $request->radio_check,
            'result' => $result, // Aquí viaja la suma y los datos de la DB
        ])
            ->setPaper('legal', 'portrait')
            ->setOption('dpi', 72)
            ->setOption('defaultFont', 'DejaVu Sans')
            ->download('formulario.pdf');
    }
}
