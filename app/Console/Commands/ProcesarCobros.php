<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\CobroServicios\Services\CobroServicioService;
use Carbon\Carbon;

class ProcesarCobros extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'procesar:cobros';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Iniciando proceso de registros de cobros...');

        $consultaIds = DB::table('consultas as c')
            ->join('afiliados as a', 'c.afiliado_id', '=', 'a.id')
            ->join('entidades as e', 'a.entidad_id', '=', 'e.id')
            ->join('cups as c2', 'c.cup_id', '=', 'c2.id')
            ->join('reps as r', 'a.ips_id', '=', 'r.id')
            ->where('c.estado_id', 9)
            ->where('c.tipo_consulta_id', '!=', 1)
            // ->whereNotIn('c.cup_id', [6919, 7016, 9302]) // opcional
            ->whereNotIn('a.id', [
                810856,
                810837,
                835475,
                832175,
                863276,
                831379,
                857843,
                835474,
                810855,
                810846,
                857845,
                810594,
                833412,
                829304
            ])
            ->where('a.entidad_id', 1)
            ->where('c.hora_inicio_atendio_consulta', '>=', '2025-06-01 00:00:00')
            ->orderBy('c.id')
            ->pluck('c.id');
            // ->count();
            // dd('datosConsulta', $consultaIds);
        // Procesar en bloques para no sobrecargar la memoria
        foreach ($consultaIds as $consultaId) {
            // $consultaId = 4787125;
            try {
                app(CobroServicioService::class)->comandoRegistroCobros($consultaId);
                $this->info("Registro factura cumimedical: {$consultaId}");
            } catch (\Throwable $th) {
                $errorMessage = "Error al registrar cobro para el consulta_id: {$consultaId}. Error: {$th->getMessage()}\n";
                file_put_contents(storage_path('logs/errores_cobro.txt'), $errorMessage, FILE_APPEND);
                continue;
            }
        }
        $this->info('Proceso de registro de facturas finalizado correctamente.');
    }
}
