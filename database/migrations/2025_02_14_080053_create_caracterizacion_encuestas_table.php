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
        Schema::create('caracterizacion_encuestas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('afiliado_id')->constrained('afiliados');

            //stan1
            $table->integer('departamento')->nullable();
            $table->integer('municipioResidencia')->nullable();
            $table->text('barrioEncuestado')->nullable()->default('');
            $table->text('direccionEncuestado')->nullable()->default('');
            $table->integer('numeroFamilia')->nullable();
            $table->integer('estratoVivienda')->nullable();
            $table->integer('numeroHogaresResiden')->nullable();
            $table->integer('numeroPersonasResiden')->nullable();
            $table->integer('numeroFamiliasQueResiden')->nullable();
            $table->integer('numeroEbs')->nullable();
            $table->text('prestadorPrimario')->nullable()->default('');
            $table->integer('codigoFicha')->nullable();
            $table->date('fechaDiligenciamiento')->nullable();
            $table->text('nombreEncuestador')->nullable()->default('');
            $table->text('cargoEncuestador')->nullable()->default('');

            //stan2
            $table->text('tipoFamilia')->nullable()->default('');
            $table->integer('numeroPersonasConformanFamilia')->nullable();
            $table->text('funcionalidadFamilia')->nullable()->default('');
            $table->text('cuidadorNinos')->nullable()->default('');
            $table->text('escalaZarit')->nullable()->default('');
            $table->text('ecopama')->nullable()->default('');
            $table->text('ninosFamilia')->nullable()->default('');
            $table->text('embarazada')->nullable()->default('');
            $table->text('adultosFamilia')->nullable()->default('');
            $table->text('conflictoArmado')->nullable()->default('');
            $table->text('discapacidad')->nullable()->default('');
            $table->text('miembroEnfermo')->nullable()->default('');
            $table->text('enfermedadCronica')->nullable()->default('');
            $table->text('violencia')->nullable()->default('');
            $table->text('vulnerabilidadFamilia')->nullable()->default('');
            $table->text('cuidadoFamilia')->nullable()->default('');
            $table->text('antecedentesMiembro')->nullable()->default('');
            $table->text('cualesAntecedentesMiembro')->nullable()->default('');
            $table->text('ttoAntecedentesMiembro')->nullable()->default('');
            $table->text('obtieneAlimentos')->nullable()->default('');
            $table->text('otroObtieneAlimentos')->nullable()->default('');
            $table->text('habitos')->nullable()->default('');
            $table->text('recursos')->nullable()->default('');
            $table->text('cuidadoEntorno')->nullable()->default('');
            $table->text('practicasSanas')->nullable()->default('');
            $table->text('recursoSocial')->nullable()->default('');
            $table->text('autonomiaAdultos')->nullable()->default('');
            $table->text('prevencionEnfermedades')->nullable()->default('');
            $table->text('cuidadoAncestral')->nullable()->default('');
            $table->text('capacidadFamilia')->nullable()->default('');

            //stan3
            $table->json('miembrosFamilia')->nullable()->default(json_encode([]));

            //stan4
            $table->text('tipoVivienda')->nullable()->default('');
            $table->text('otroTipoVivienda')->nullable()->default('');
            $table->text('paredVivienda')->nullable()->default('');
            $table->text('otroParedVivienda')->nullable()->default('');
            $table->text('pisoVivienda')->nullable()->default('');
            $table->text('otroPisoVivienda')->nullable()->default('');
            $table->text('techoVivienda')->nullable()->default('');
            $table->text('otroTechoVivienda')->nullable()->default('');
            $table->integer('numeroCuartos')->nullable();
            $table->text('hacinamiento')->nullable()->default('');
            $table->json('riesgosVivienda')->nullable()->default(json_encode([]));
            $table->json('entornos')->nullable()->default(json_encode([]));
            $table->text('combustible')->nullable()->default('');
            $table->text('otroCombustible')->nullable()->default('');
            $table->text('criaderos')->nullable()->default('');
            $table->text('cualesCriaderos')->nullable()->default('');
            $table->json('viviendaCondiciones')->nullable()->default(json_encode([]));
            $table->text('otroViviendaCondiciones')->nullable()->default('');
            $table->text('trabajoEnVivienda')->nullable()->default('');
            $table->json('seleccionMascotas')->nullable();
            $table->json('mascotas')->nullable();
            $table->text('otroMascota')->nullable()->default('');
            $table->text('agua')->nullable()->default('');
            $table->text('otroAgua')->nullable()->default('');
            $table->text('disponenExcretas')->nullable()->default('');
            $table->text('otroDisponenExcretas')->nullable()->default('');
            $table->text('aguasResiduales')->nullable()->default('');
            $table->text('otroAguasResiduales')->nullable()->default('');
            $table->text('basuras')->nullable()->default('');
            $table->text('otroBasuras')->nullable()->default('');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caracterizacion_encuestas');
    }
};
