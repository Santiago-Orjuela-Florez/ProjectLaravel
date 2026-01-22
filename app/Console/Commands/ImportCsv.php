<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Registro;
use App\Models\Batch;
use Illuminate\Support\Facades\Storage;
use League\Csv\Reader;

class ImportCsv extends Command
{
    protected $signature = 'import:csv {file}';
    protected $description = 'Importa datos desde un archivo CSV';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $csvFile = storage_path('app/public/registros.csv');  // Ajusta la ruta si es necesario

        // Leer el archivo CSV
        $csv = array_map('str_getcsv', file($csvFile));

        // Usar la primera fila como encabezados
        $header = array_shift($csv);

        // Eliminar el BOM (Byte Order Mark) si está presente
        $header = array_map(function ($value) {
            return ltrim($value, "\u{FEFF}"); // Elimina el BOM
        }, $header);

        // Recorrer las filas y procesar los datos
        foreach ($csv as $row) {
            $row = array_combine($header, $row);  // Asocia las columnas con los encabezados

            // Crear o encontrar el registro
            $registro = Registro::firstOrCreate([
                'material' => $row['Material'],  // Coincide con el encabezado CSV
                'material_document' => $row['Material Document'],  // Coincide con el encabezado CSV
            ], [
                'material_description' => $row['Material Description'],  // Coincide con el encabezado CSV
            ]);

            // Convertir la fecha del formato CSV (dd/mm/yyyy) al formato de base de datos (yyyy-mm-dd)
            $date = null;
            if (!empty($row['Document Date'])) {
                try {
                    $date = \Carbon\Carbon::createFromFormat('d/m/Y', $row['Document Date'])->format('Y-m-d');
                } catch (\Exception $e) {
                    $this->warn("Fecha inválida en la fila: {$row['Document Date']}");
                }
            }

            // Crear los batches asociados
            $registro->batches()->firstOrCreate([
                'batch' => $row['Batch'],  // Coincide con el encabezado CSV
            ], [
                'quantity' => $row['Qty in Un. of Entry'],  // Añade el valor de 'quantity'
                'date' => $date,  // Añade la fecha
            ]);


        }

        // Mensaje de éxito
        $this->info('Datos importados correctamente.');
    }

}