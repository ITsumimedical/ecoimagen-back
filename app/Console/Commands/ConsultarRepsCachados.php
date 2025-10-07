<?php

namespace App\Console\Commands;

use App\Http\Modules\Reps\Repositories\RepsRepository;
use Illuminate\Console\Command;

class ConsultarRepsCachados extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:consultar-reps-cachados';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    protected $repsRepository;
    // Inyecta el repositorio en el constructor
    public function __construct(RepsRepository $repsRepository)
    {
        parent::__construct();
        $this->repsRepository = $repsRepository;
    }

    /**
     * Ejecuta el comando.
     *
     * @return void
     */
    public function handle()
    {
        try {
            // Llama a la función consultarRepsCachados
            $reps = $this->repsRepository->listarRepsCachados();

            // Simplemente muestra un mensaje en la consola
            $this->info('Consulta ejecutada correctamente, se han obtenido ' . count($reps) . ' reps.');
        } catch (\Throwable $th) {
            // Muestra el error directamente en la consola
            $this->error('Error al consultar reps cachados: ' . $th->getMessage());
        }
    }
}
