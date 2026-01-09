<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id(); // id autoincrement
            $table->unsignedBigInteger('registro_id'); // foreign key al registro
            $table->string('batch')->notNullable();
            $table->integer('quantity')->notNullable();

            $table->foreign('registro_id')->references('id')->on('registros')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('batches');
    }
};
