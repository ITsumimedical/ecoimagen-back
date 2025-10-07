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
        Schema::table('orden_procedimientos', function (Blueprint $table) {
            $table->text('firma_consentimiento')->nullable();
            $table->text('firma_discentimiento')->nullable();
            $table->timestamp('fecha_firma_discentimiento')->nullable();
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
        Schema::table('orden_procedimientos', function (Blueprint $table) {
            $table->dropColumn('firma_consentimiento');
            $table->dropColumn('firma_discentimiento');
            $table->dropColumn('fecha_firma_discentimiento');
            $table->dropColumn('aceptacion_consentimiento');
            $table->dropColumn('firmante');
            $table->dropColumn('numero_documento_representante');
            $table->dropColumn('declaracion_a');
            $table->dropColumn('declaracion_b');
            $table->dropColumn('declaracion_c');
            $table->dropColumn('nombre_profesional');
            $table->dropColumn('nombre_representante');
        });
    }
};
