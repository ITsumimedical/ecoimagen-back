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
        Schema::create('estructura_factura_electronicas', function (Blueprint $table) {
            $table->id();
            $table->integer('number');
            $table->integer('type_document_id');
            $table->date('date');
            $table->time('time');
            $table->string('resolution_number');
            $table->string('prefix');
            $table->string('notes');
            $table->boolean('disable_confirmation_text');
            $table->string('establishment_name');
            $table->string('establishment_address');
            $table->string('establishment_phone');
            $table->string('establishment_municipality');
            $table->string('establishment_email');
            $table->boolean('sendmail');
            $table->boolean('sendmailtome');
            $table->boolean('send_customer_credentials');
            $table->string('seze');
            $table->jsonb('email_cc_list');
            $table->string('annexes');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estructura_factura_electronicas');
    }
};
