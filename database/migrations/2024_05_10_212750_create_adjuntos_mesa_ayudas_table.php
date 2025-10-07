 <?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateAdjuntosMesaAyudasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adjuntos_mesa_ayudas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 400)->comment('Campo para guardar nombre del adjunto max 400 caracteres');
            $table->string('ruta')->comment('Campo para guardar ruta del adjunto');
            $table->foreignId('mesa_ayuda_id')->comment('Relacion con tabla mesa_ayuda')->constrained('mesa_ayudas');
            $table->SoftDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adjuntos_mesa_ayudas');
    }
}
