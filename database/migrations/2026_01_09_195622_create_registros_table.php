<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('registros', function (Blueprint $table) {
            $table->id(); // id autoincrement
            $table->string('material')->notNullable();
            $table->string('material_document')->notNullable();
            $table->string('material_description')->notNullable();

            // Asegurarnos que la combinación material + material_document sea única
            $table->unique(['material', 'material_document']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('registros');
    }
};