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
        Schema::create('cobro_facturas', function (Blueprint $table) {
            $table->id();
            $table->string('valor');
            $table->string('medio_pago');
            $table->foreignId('user_cobro_id')->constrained('users');
            $table->foreignId('afiliado_id')->constrained('afiliados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cobro_facturas');
    }
};
