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
        Schema::create('test_assist', function (Blueprint $table) {
            $table->id();
            $table->integer('resultadoItemA')->nullable();
            $table->integer('resultadoItemB')->nullable();
            $table->integer('resultadoItemC')->nullable();
            $table->integer('resultadoItemD')->nullable();
            $table->integer('resultadoItemE')->nullable();
            $table->integer('resultadoItemF')->nullable();
            $table->integer('resultadoItemG')->nullable();
            $table->integer('resultadoItemH')->nullable();
            $table->integer('resultadoItemI')->nullable();
            $table->integer('resultadoItemJ')->nullable();
            $table->integer('resultadoItemW')->nullable();
            $table->integer('resultadoItemX')->nullable();
            $table->string('interpretacion_item8')->nullable();
            $table->foreignId('consulta_id')->nullable()->constrained('consultas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_assist');
    }
};
