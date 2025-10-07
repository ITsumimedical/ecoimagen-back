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
        Schema::create('consentimientos_informados_urgencias', function (Blueprint $table) {
            $table->id();
            $table->string('tipo')->nullable();
            $table->date('fecha');
            $table->string('servicio')->nullable();
            $table->string('canalizacion')->nullable();
            $table->string('terapias')->nullable();
            $table->string('toma_muestras')->nullable();
            $table->string('aspiracion')->nullable();
            $table->string('administracion_medicamento')->nullable();
            $table->string('curaciones')->nullable();
            $table->string('sonda_oro')->nullable();
            $table->string('inmovilizacion')->nullable();
            $table->string('cateterismo')->nullable();
            $table->string('higiene_aseo')->nullable();
            $table->string('enemas')->nullable();
            $table->string('traslados')->nullable();
            $table->string('gases_arteriales')->nullable();
            $table->string('otro')->nullable();
            $table->string('confirmacion_documento')->nullable();
            $table->string('confirmacion_paciente')->nullable();
            $table->string('certifico')->nullable();
            $table->string('doctor')->nullable();
            $table->string('acuerdo')->nullable();
            $table->string('retiro')->nullable();
            $table->string('observacion')->nullable();
            $table->text('firma_paciente')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('admision_urgencia_id')->nullable()->constrained('admisiones_urgencias');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('consentimientos_informados_urgencias');
    }
};
