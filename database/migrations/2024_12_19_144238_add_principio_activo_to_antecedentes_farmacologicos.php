<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('antecedentes_farmacologicos', function (Blueprint $table) {
            $table->foreignId('principio_activo_id')->nullable()->constrained('principio_activos');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('antecedentes_farmacologicos', function (Blueprint $table) {
            $table->dropForeign(['principio_activo_id']); // Elimina la restricción de clave foránea
            $table->dropColumn('principio_activo_id'); //elimina la columna
        });
    }
};
