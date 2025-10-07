<?php

namespace App\Jobs;

use App\Http\Modules\LogsKeiron\Services\KeironService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class EnviosKeironJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 1;
    public $timeout = 300;
    public array $request;
    public $consulta;
    private int $tipo;
    private array $transicion;

    /**
     * Create a new job instance.
     */
    public function __construct(array $request, $consulta = null, int $tipo)
    {
        $this->request = $request;
        $this->consulta = $consulta;
        $this->tipo = $tipo;
    }
    /**
     * Execute the job.
     */
    public function handle(KeironService $keironService)
    {
        if ($this->tipo == 1) {
            $keironService->consultasApikeiron($this->request, $this->consulta);
        }

        if ($this->tipo == 2) {
            $keironService->cambiarEstadoApiKeiron(config('services.keiron.status_cancelado'), config('services.keiron.transition_cancelado'), $this->request["consulta"]);
        }

    }

    public function failed(\Throwable $exception)
    {
        dispatch(new EnviosKeironJob($this->request, $this->consulta, $this->tipo))
            ->delay(now()->addSeconds(30))
            ->onQueue('envios-keiron-crm');
    }

}
