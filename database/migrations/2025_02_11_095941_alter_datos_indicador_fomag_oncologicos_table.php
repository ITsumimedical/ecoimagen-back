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
        Schema::table('datos_indicador_fomag_oncologicos', function (Blueprint $table) {
            $table->string('control_psa')->nullable()->after('riesgo_aplica_prostata');
            $table->boolean('disentimiento')->nullable()->default(false);
            $table->string('clasificacion_riesgo_internacional_lh_lnh')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('datos_indicador_fomag_oncologicos', function (Blueprint $table) {
            $table->string('fecha_control_psa')->nullable()->after('riesgo_aplica_prostata');
            $table->boolean('disentimiento')->nullable()->default(false);
            $table->string('clasificacion_riesgo_internacional_lh_lnh')->nullable();
        });
    }
};
