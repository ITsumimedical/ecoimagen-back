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
        Schema::create('salud_ocupacionals', function (Blueprint $table) {
            $table->id();
            // MOTIVO DE CONSULTA
            $table->string('tipo_examen')->nullable();
            $table->string('tipo_consulta')->nullable();
            $table->string('enfermedad_actual');
            // ANTECEDENTES OCUPACIONALES
            $table->string('antecedente_empresa')->nullable();
            $table->string('antecedente_cargo')->nullable();
            $table->string('f')->nullable();
            $table->string('q')->nullable();
            $table->string('b')->nullable();
            $table->string('erg')->nullable();
            $table->string('psic')->nullable();
            $table->string('mec')->nullable();
            $table->string('elec')->nullable();
            $table->string('otro')->nullable();
            $table->string('tiempo')->nullable();
            $table->string('uso_e_p_p')->nullable();
            $table->string('fecha_accidentes')->nullable();
            $table->string('empresa_accidentes')->nullable();
            $table->string('causa')->nullable();
            $table->string('tipo_lesion')->nullable();
            $table->string('parte_afectada')->nullable();
            $table->string('dias_incap')->nullable();
            $table->string('secuelas')->nullable();
            $table->string('fecha')->nullable();
            $table->string('empresa')->nullable();
            $table->string('diagnostico')->nullable();
            $table->string('reubicacion')->nullable();
            $table->string('indemnizacion')->nullable();
            // habitos
            $table->string('anios_fumador')->nullable();
            $table->string('cigarrillos_al_dia')->nullable();
            $table->string('fumo')->nullable();
            $table->string('hace_cuanto_no_fuma')->nullable();
            $table->string('frecuencia')->nullable();
            $table->string('tipo')->nullable();
            $table->string('cuales')->nullable();
            $table->string('cual')->nullable();
            $table->string('regularidad')->nullable();
            // REVISION POR SISTEMAS
            $table->string('cabeza_y_orl')->nullable();
            $table->string('sistema_neurologico')->nullable();
            $table->string('sistema_cardiopulmonar')->nullable();
            $table->string('sistema_digestivo')->nullable();
            //$table->string('sistema_musculo_esqueletico')->nullable();
            $table->string('sistema_genitourinario')->nullable();
            $table->string('piel_y_faneras')->nullable();
            $table->string('otros')->nullable();
            $table->string('espirometria')->nullable();
            $table->string('espirometria_si')->nullable();
            $table->string('espirometria_no')->nullable();
            // CONDICIONES EN SALUD
            $table->string('nombre_de_la_empresa')->nullable();
            $table->string('cargo')->nullable();
            $table->string('antiguedad')->nullable();
            $table->string('factoresRiesgo')->nullable();
            $table->string('antecedentesenfermedad')->nullable();
            $table->string('origenEnfermedades')->nullable();
            $table->string('antecedentedetrabajo')->nullable();
            $table->string('antecedenteenfermedadlaboral')->nullable();
            $table->string('enfermedadComun')->nullable();
            $table->string('antecedentesfamiliares')->nullable();
            $table->string('patologiaAntecedente')->nullable();
            $table->string('masaCorporal')->nullable();
            $table->string('patologiaOsteomuscular')->nullable();
            $table->string('patologiaCardiovascular')->nullable();
            $table->string('patologiaMetabolica')->nullable();
            $table->string('infecciososParasitaria')->nullable();
            $table->string('patologiaSangre')->nullable();
            $table->string('trastronosMentales')->nullable();
            $table->string('patologiaNervioso')->nullable();
            $table->string('patologiaOjo')->nullable();
            $table->string('patologiaOido')->nullable();
            $table->string('patologiaRespiratorio')->nullable();
            $table->string('patologiaDigestivo')->nullable();
            $table->string('patologiaPiel')->nullable();
            $table->string('patologiaUrinario')->nullable();
            $table->string('malformacionCongenitas')->nullable();
            $table->string('diagnosticos_neoplasicos')->nullable();
            // EXAMEN FISICO OCUPACIONAL
            $table->string('condiciones_generales')->nullable();
            $table->string('dominancia_motora')->nullable();
            $table->string('talla')->nullable();
            $table->string('peso')->nullable();
            $table->string('f_c')->nullable();
            $table->string('f_r')->nullable();
            $table->string('imc')->nullable();
            $table->string('perimetroabdominal')->nullable();
            $table->string('presionsistolica')->nullable();
            $table->string('presiondiastolica')->nullable();
            $table->string('presionarterialmedia')->nullable();
            $table->string('t')->nullable();
            $table->string('cabeza')->nullable();
            $table->string('ojos')->nullable();
            $table->string('fondo_de_ojos')->nullable();
            $table->string('oidos')->nullable();
            $table->string('otoscopia')->nullable();
            $table->string('nariz')->nullable();
            $table->string('boca')->nullable();
            $table->string('dentadura')->nullable();
            $table->string('faringe')->nullable();
            $table->string('cuello')->nullable();
            $table->string('mamas')->nullable();
            $table->string('torax')->nullable();
            $table->string('corazon')->nullable();
            $table->string('pulmones')->nullable();
            $table->string('columna')->nullable();
            $table->string('abdomen')->nullable();
            $table->string('genitales_externos')->nullable();
            $table->string('miembros_sup')->nullable();
            $table->string('miembros_inf')->nullable();
            $table->string('reflejos')->nullable();
            $table->string('motilidad')->nullable();
            $table->string('fuerza_muscular')->nullable();
            $table->string('marcha')->nullable();
            $table->string('piel_faneras')->nullable();
            $table->string('ampliacion_hallazgos')->nullable();
            // CONDUCTA OCUPACIONAL
            $table->string('Planmanejo')->nullable();
            $table->string('Recomendaciones')->nullable();
            $table->string('aptitud_laboral_medico')->nullable();
            $table->string('vigilancia_epidemiologico')->nullable();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->foreignId('tipo_consulta_id')->nullable()->constrained('tipo_consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salud_ocupacionals');
    }
};
