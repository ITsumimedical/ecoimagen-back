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
        Schema::create('gestion_pqrsfs', function (Blueprint $table) {
            $table->id();
            $table->text('motivo');
            $table->string('responsable')->nullable();
            $table->date('fecha')->nullable();
            $table->string('medio')->nullable();
            $table->string('aquien_not')->nullable();
            $table->string('parentesco')->nullable();
            $table->foreignId('formulario_pqrsf_id')->nullable()->constrained('formulariopqrsfs');
            $table->foreignId('user_id')->nullable()->constrained('users');
            $table->foreignId('afiliado_id')->nullable()->constrained('afiliados');
            $table->foreignId('tipo_id')->nullable()->constrained('tipos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gestion_pqrsfs');
    }
};
