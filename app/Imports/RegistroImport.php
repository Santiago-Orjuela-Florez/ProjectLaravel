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

        // Crear el batch si existe
        if (!empty($row['batch'])) {
            Batch::firstOrCreate([
                'registro_id' => $registro->id,
                'batch' => $row['batch'],
            ], [
                'quantity' => isset($row['qty_in_un_of_entry']) ? (int) $row['qty_in_un_of_entry'] : 0,
                'date' => isset($row['document_date']) ? \Carbon\Carbon::createFromFormat('d/m/Y', $row['document_date'])->format('Y-m-d') : null,
            ]);
        }

        return $registro;
    }
}
