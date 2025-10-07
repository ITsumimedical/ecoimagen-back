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
        Schema::table('cups', function (Blueprint $table) {
            $table->foreignId('modalidad_grupo_tec_sal_id')->nullable()->constrained('modalidad_grupo_tec_sals');
            $table->foreignId('grupo_servicio_id')->nullable()->constrained('grupo_servicios');
            $table->foreignId('codigo_servicio_id')->nullable()->constrained('codigo_servicios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cups', function (Blueprint $table) {
            $table->foreignId('modalidad_grupo_tec_sal_id')->nullable()->constrained('modalidad_grupo_tec_sals');
            $table->foreignId('grupo_servicio_id')->nullable()->constrained('grupo_servicios');
            $table->foreignId('codigo_servicio_id')->nullable()->constrained('codigo_servicios');
        });
    }
};
