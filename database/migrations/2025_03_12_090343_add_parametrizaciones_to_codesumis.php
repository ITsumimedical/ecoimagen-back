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
        Schema::table('codesumis', function (Blueprint $table) {
            $table->foreignId('unidad_medida_id')->nullable()->constrained('unidades_medidas_medicamentos');
            $table->foreignId('unidad_medida_dispensacion_id')->nullable()->constrained('unidades_medidas_dispensacions');
            $table->foreignId('ffm_id')->nullable()->constrained('forma_farmaceutica_ffm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('codesumis', function (Blueprint $table) {
            $table->dropForeign(['unidad_medida_id', 'unidad_medida_dispensacion_id', 'ffm_id']);
            $table->dropColumn(['unidad_medida_id', 'unidad_medida_dispensacion_id', 'ffm_id']);
        });
    }
};
