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
        Schema::table('empalme', function (Blueprint $table) {
            $table->foreignId('cup_id')->nullable()->constrained('cups');
            $table->foreignId('codesumi_id')->nullable()->constrained('codesumis');
            $table->foreignId('codigo_propio_id')->nullable()->constrained('codigo_propios');
            $table->string('anexos')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('empalme', function (Blueprint $table) {
            //
        });
    }
};
