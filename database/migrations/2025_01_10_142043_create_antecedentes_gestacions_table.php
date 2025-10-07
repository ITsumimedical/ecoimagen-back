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
		Schema::create('antecedentes_gestacions', function (Blueprint $table) {
			$table->id();
			$table->integer('gestacion_numero');
			$table->integer('controles');
			$table->string('amenazas_aborto');
			$table->string('infecciones_embarazo');
			$table->boolean('enfermedades_tratamiento');
			$table->text('descripcion_enfermedades_tratamiento')->nullable();
			$table->boolean('alcoholismo');
			$table->boolean('drogadiccion');
			$table->integer('edad_madre');
			$table->integer('edad_padre');
			$table->string('consanguinidad');
			$table->foreignId('creado_por')->constrained('users');
			$table->softDeletes();
			$table->timestamps();
		});
	}

	/**
	 * Reverse the migrations.
	 */
	public function down(): void
	{
		Schema::dropIfExists('antecedentes_gestacions');
	}
};
