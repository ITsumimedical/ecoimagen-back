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
        Schema::table('concurrencias', function (Blueprint $table) {
            $table->dropForeign('concurrencias_afiliado_id_foreign', 'concurrencias_dx_ingreso_foreign', 'concurrencias_ips_atencion_foreign');
            $table->dropColumn(['afiliado_id','dx_ingreso','fecha_ingreso','via_ingreso','unidad_funcional','estancia_total','tipo_hospitalizacion','reingreso_hospitalizacion30dias','reingreso_hospitalizacion15dias','especialidad_tratante','ips_atencion']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('concurrencias', function (Blueprint $table) {
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->foreignId('dx_ingreso')->constrained('cie10s');
            $table->date('fecha_ingreso')->nullable();
            $table->string('via_ingreso')->nullable();
            $table->string('unidad_funcional')->nullable();
            $table->smallInteger('estancia_total')->nullable()->default(0);
            $table->string('tipo_hospitalizacion')->nullable();
            $table->string('reingreso_hospitalizacion15dias')->nullable();
            $table->string('reingreso_hospitalizacion30dias')->nullable();
            $table->string('especialidad_tratante')->nullable();
            $table->foreignId('ips_atencion')->nullable()->constrained('reps');
        });
    }
};
