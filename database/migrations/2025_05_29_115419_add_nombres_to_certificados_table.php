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
        Schema::table('certificados', function (Blueprint $table) {
            $table->string('primer_nombre')->nullable();
			$table->string('segundo_nombre')->nullable();
			$table->string('primer_apellido')->nullable();
			$table->string('segundo_apellido')->nullable();

			$table->string('nombre_completo')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('certificados', function (Blueprint $table) {
            $table->dropColumn(['primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido']);
			$table->string('nombre_completo')->nullable(false)->change();
        });
    }
};
