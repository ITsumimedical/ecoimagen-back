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
        Schema::create('antecedente_partos', function (Blueprint $table) {
            $table->id();
            $table->integer('edad_gestacional');
            $table->string('tipo_parto');
            $table->string('presentacion_cefalica');
            $table->boolean('inducido_pitocin');
            $table->text('forceps');
            $table->boolean('cesarea');
            $table->text('descipricion_cesarea')->nullable();
            $table->string('peso');
            $table->string('talla');
            $table->boolean('anoxia');
            $table->boolean('reanimacion');
            $table->boolean('incubadora');
            $table->text('descripcion_incubadora')->nullable();
            $table->string('tiempo_incubadora')->nullable();
            $table->boolean('succion');
            $table->boolean('malformaciones');
            $table->text('descripcion_malformaciones')->nullable();
            $table->boolean('hipoglucemia');
            $table->boolean('desnutricion');
            $table->boolean('ictericia');
            $table->text('descripcion_ictericia')->nullable();
            $table->boolean('convulsiones');
            $table->text('descripcion_convulsiones')->nullable();
            $table->boolean('alta_hospitalaria');
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->foreignId('creador_por')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('antecedente_partos');
    }
};
