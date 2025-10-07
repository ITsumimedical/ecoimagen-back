<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orden_articulo_intrahospitalarios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orden_id')->constrained('ordenes');
            $table->foreignId('codesumi_id')->constrained('codesumis');
            $table->foreignId('estado_id')->constrained('estados');
            $table->foreignId('via_administracion_id')->constrained('vias_administracion');
            $table->string('finalizacion');
            $table->decimal('dosis', 8, 2);
            $table->decimal('frecuencia', 8, 2)->nullable();
            $table->string('unidad_tiempo')->nullable();
            $table->decimal('horas_vigencia');
            $table->decimal('cantidad');
            $table->text('observacion');
            $table->foreignId('user_crea_id')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orden_articulo_intrahospitalarios');
    }
};
