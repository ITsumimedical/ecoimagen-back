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
        Schema::table('log_consolidados', function (Blueprint $table) {
            $table->foreignId('tipo_consolidado_id')->nullable()->constrained('tipo_consolidados')->after('id');
            $table->string('nombre', 255)->nullable()->after('tipo_consolidado_id');
            $table->string('descripcion', 500)->nullable()->after('nombre');
            $table->foreignId('estado_id')->default(1)->constrained('estados')->after('descripcion');
            $table->foreignId('user_id')->nullable()->constrained('users')->after('estado_id');
            $table->timestamp('fecha_generacion')->nullable()->after('user_id');
            $table->timestamp('fecha_finalizacion')->nullable()->after('fecha_generacion');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('log_consolidados', function (Blueprint $table) {
            $table->dropForeign(['tipo_consolidado_id']);
            $table->dropColumn('tipo_consolidado_id');
            $table->dropColumn('nombre');
            $table->dropColumn('descripcion');
            $table->dropForeign(['estado_id']);
            $table->dropColumn('estado_id');
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->dropColumn('fecha_generacion');
            $table->dropColumn('fecha_finalizacion');
        });
    }
};
