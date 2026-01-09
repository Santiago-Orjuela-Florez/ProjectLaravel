<?php

namespace App\Imports;

use App\Models\Registro;
use App\Models\Batch;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class RegistroImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        // Crear el registro principal
        $registro = Registro::firstOrCreate([
            'material' => $row['material'],
            'material_document' => $row['material_document'],
        ], [
            'material_description' => $row['material_description'],
        ]);

        // Iterar sobre las columnas de batch
        foreach ($row as $column => $value) {
            // Si el nombre de la columna comienza con "batch" (ejemplo: "batch1", "batch2", etc.)
            if (strpos($column, 'batch') !== false && !empty($value)) {
                Batch::firstOrCreate([
                    'registro_id' => $registro->id,
                    'batch' => $value,
                ]);
            }
        }

        return $registro;
    }
}
