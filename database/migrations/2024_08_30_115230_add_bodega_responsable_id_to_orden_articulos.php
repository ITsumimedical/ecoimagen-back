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
        Schema::table('orden_articulos', function (Blueprint $table) {
            $table->foreignId('bodega_responsable_id')->nullable()->constrained('bodegas');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orden_articulos', function (Blueprint $table) {
            $table->dropForeign(['bodega_responsable_id']); // Eliminar la clave foránea
            $table->dropColumn('bodega_responsable_id'); // Eliminar la columna
        });
    }
};
