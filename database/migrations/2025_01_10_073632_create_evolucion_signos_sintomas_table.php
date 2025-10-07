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
		Schema::create('evolucion_signos_sintomas', function (Blueprint $table) {
			$table->id();
			$table->foreignId('consulta_id')->constrained('consultas');
			$table->date('fecha_inicio');
			$table->time('tiempo_inicio');
			$table->text('signos_sintomas');
			$table->text('estresores_importantes');
			$table->text('estado_actual');
			$table->text('profesional_consultado_antes');
			$table->foreignId('creado_por')->constrained('users');
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('evolucion_signos_sintomas');
	}
};
