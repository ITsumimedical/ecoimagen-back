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
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->bigInteger('user_id')->nullable()->change();
            $table->string('provider',255)->nullable()->change();
            $table->text('redirect')->nullable()->change();
            $table->boolean('personal_access_client')->nullable()->change();
            $table->boolean('password_client')->nullable()->change();
            $table->boolean('revoked')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('oauth_clients', function (Blueprint $table) {
            $table->bigInteger('user_id')->nullable(false)->change();
            $table->string('provider')->nullable(false)->change();
            $table->text('redirect')->nullable(false)->change();
            $table->boolean('personal_access_client')->nullable(false)->change();
            $table->boolean('password_client')->nullable(false)->change();
            $table->boolean('revoked')->nullable(false)->change();
        });
    }
};
