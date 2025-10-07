<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use function Symfony\Component\String\b;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('medicamentos', function (Blueprint $table) {
            $table->boolean('regulado')->nullable();
            $table->string('pbs')->nullable();
            $table->boolean('alto_costo')->nullable();
            $table->boolean('acuerdo_228')->nullable();
            $table->string('clasificacion_riesgo')->nullable();
            $table->boolean('oncologico')->nullable();
            $table->string('origen')->nullable();
            $table->boolean('refrigerado')->nullable();
            $table->boolean('control_especial')->nullable();
            $table->boolean('costoso')->nullable();
            $table->boolean('comercial')->nullable();
            $table->boolean('generico')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('medicamentos', function (Blueprint $table) {
            $table->boolean('regulado')->nullable();
            $table->string('pbs')->nullable();
            $table->boolean('alto_costo')->nullable();
            $table->boolean('acuerdo_228')->nullable();
            $table->string('clasificacion_riesgo')->nullable();
            $table->boolean('oncologico')->nullable();
            $table->string('origen')->nullable();
            $table->boolean('refrigerado')->nullable();
            $table->boolean('control_especial')->nullable();
            $table->boolean('costoso')->nullable();
            $table->boolean('comercial')->nullable();
            $table->boolean('generico')->nullable();
        });
    }
};
