<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
	/**
	 * Run the migrations.
	 */
	public function up(): void
	{
		Schema::create('tratamiento_farmacologicos', function (Blueprint $table) {
			$table->id();
			$table->foreignId('consulta_id')->constrained('consultas');
			$table->string('dosis');
			$table->string('horario');
			$table->foreignId('via_administracion_id')->constrained('vias_administracion');
			$table->text('descripcion_tratamiento')->nullable();
			$table->foreignId('creado_por')->constrained('users');
            $table->timestamps();
        });
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('tratamiento_farmacologicos');
	}
};
