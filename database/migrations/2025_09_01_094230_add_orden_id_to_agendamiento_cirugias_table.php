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
        Schema::table('agendamiento_cirugias', function (Blueprint $table) {
            $table->foreignId('orden_id')->nullable()->constrained('ordenes');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('agendamiento_cirugias', function (Blueprint $table) {
            $table->dropForeign('orden_id');
            $table->dropColumn('orden_id');
        });
    }
};
