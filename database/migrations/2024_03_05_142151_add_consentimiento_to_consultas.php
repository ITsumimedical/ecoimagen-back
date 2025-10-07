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
        Schema::table('consultas', function (Blueprint $table) {
            $table->string('firma_paciente',1000)->nullable();
            $table->string('aceptacion_consentimiento')->nullable();
            $table->string('firmante')->nullable();
            $table->string('numero_documento_representante')->nullable();
            $table->string('declaracion_a')->nullable();
            $table->string('declaracion_b')->nullable();
            $table->string('declaracion_c')->nullable();
            $table->string('nombre_profesional')->nullable();
            $table->string('nombre_representante')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('consultas', function (Blueprint $table) {
            //
        });
    }
};
