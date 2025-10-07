<?php

namespace App\Http\Modules\Eventos\Analisis\Services;

use App\Http\Modules\Eventos\Analisis\Models\AnalisisEvento;
use App\Http\Modules\Eventos\EventosAdversos\Models\EventoAdverso;
use App\Http\Modules\Eventos\GestionEventos\Models\GestionEvento;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AnalisisEventosService
{


    public function crearActualizarEventoAnalisis(array $data)
    {
        return DB::transaction(function () use ($data) {
            $estado_id = $data['estado_id'];
            unset($data['estado_id']);
            $analisisEvento = AnalisisEvento::updateOrCreate(['evento_adverso_id' => $data['evento_adverso_id']], $data);
            EventoAdverso::where('id', $data['evento_adverso_id'])->update(['estado_id' => $estado_id]);
            GestionEvento::create([
                'accion' => 'Análisis de caso',
                'evento_adverso_id' => $data['evento_adverso_id'],
                'user_id' => Auth::id(),
                'motivo' => 'Se realiza análisis del caso',
                'created_at' => now(),
            ]);
            return $analisisEvento;
        });
    }
}
