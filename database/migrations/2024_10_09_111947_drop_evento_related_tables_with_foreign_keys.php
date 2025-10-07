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
        Schema::table('eventos_seguridads', function (Blueprint $table) {
            $table->dropForeign('eventos_seguridads_ingreso_concurrencia_id_foreign');
        });

        Schema::table('evento_noti_inmediatas', function (Blueprint $table) {
            $table->dropForeign('evento_noti_inmediatas_ingreso_concurrencia_id_foreign');
        });

        Schema::table('evento_centinelas', function (Blueprint $table) {
            $table->dropForeign('evento_centinelas_ingreso_concurrencia_id_foreign');
        });

        Schema::dropIfExists('eventos_seguridads');
        Schema::dropIfExists('evento_noti_inmediatas');
        Schema::dropIfExists('evento_centinelas');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::create('eventos_seguridads', function (Blueprint $table) {
            $table->id();
            $table->string('observacion');
            $table->string('evento');
            $table->unsignedBigInteger('ingreso_concurrencia_id');
            $table->foreign('ingreso_concurrencia_id')
                ->references('id')
                ->on('ingreso_concurrencias')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('evento_noti_inmediatas', function (Blueprint $table) {
            $table->id();
            $table->string('observacion');
            $table->string('evento');
            $table->unsignedBigInteger('ingreso_concurrencia_id');
            $table->foreign('ingreso_concurrencia_id')
                ->references('id')
                ->on('ingreso_concurrencias')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Schema::create('evento_centinelas', function (Blueprint $table) {
            $table->id();
            $table->string('observacion');
            $table->string('evento');
            $table->unsignedBigInteger('ingreso_concurrencia_id');
            $table->foreign('ingreso_concurrencia_id')
                ->references('id')
                ->on('ingreso_concurrencias')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }
};
