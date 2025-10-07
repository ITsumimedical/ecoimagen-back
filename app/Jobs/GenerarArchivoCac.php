<?php

namespace App\Jobs;

use App\Http\Modules\Cac\Repositories\PatologiasCacRepository;
use App\Http\Modules\Cac\Services\CacService;
use App\Http\Modules\Historia\Repositories\HistoricoRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GenerarArchivoCac implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle(CacService $cacService): void
    {
        $cacService->generarArchivoCac($this->data);
    }
}
