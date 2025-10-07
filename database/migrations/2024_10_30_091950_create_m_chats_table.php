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
        Schema::create('m_chats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('consulta_id')->constrained('consultas');
            $table->string('señala_mira');
            $table->string('sordo');
            $table->string('juegos_fantasia');
            $table->string('se_sube_cosas');
            $table->string('movimientos_inusuales_dedos');
            $table->string('señala_cosas_fuera_alcance');
            $table->string('muestra_llama_atencion');
            $table->string('interesa_otros_niños');
            $table->string('muestra_cosas_acercandolas');
            $table->string('responde_llamado_nombre');
            $table->string('sonrie_el_tambien');
            $table->string('molestan_ruidos_cotidianos');
            $table->string('camina_solo');
            $table->string('mira_ojos_cuando_habla');
            $table->string('imita_movimientos');
            $table->string('gira_mirar_usted_mira');
            $table->string('intenta_hagan_cumplidos');
            $table->string('entiende_ordenes');
            $table->string('mira__reacciones');
            $table->string('gusta_juegos_movimientos');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_chats');
    }
};
