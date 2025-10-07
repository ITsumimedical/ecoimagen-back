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
        Schema::create('adjuntorips', function (Blueprint $table) {
            $table->id();
            $table->string('url_json');
             $table->string('url_xml');
             $table->string('url_cuv');
             $table->string('numero_factura');
             $table->string('codigo_prestador');
             $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adjuntorips');
    }
};
