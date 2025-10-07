<?php

namespace App\Http\Modules\Eventos\AccionesMejora\Services;

use App\Http\Modules\Eventos\AccionesMejora\Models\AccionesMejoraEvento;
use App\Http\Modules\Eventos\AccionesMejora\Repositories\AccionMejoraRepository;
use App\Http\Modules\Eventos\Adjunto\Repositories\AdjuntoEventoAdversoRepository;
use App\Http\Modules\Eventos\Analisis\Models\AnalisisEvento;
use App\Http\Modules\Eventos\EventosAdversos\Models\EventoAdverso;
use App\Http\Modules\Eventos\EventosAsignados\Models\EventoAsignado;
use App\Http\Modules\Eventos\GestionEventos\Models\GestionEvento;
use App\Traits\ArchivosTrait;
use Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AccionMejoraService
{

    use ArchivosTrait;

    public function __construct(
        protected AccionMejoraRepository $accionMejoraRepository,
        protected AdjuntoEventoAdversoRepository $adjuntoEventoAdversoRepository,
        protected AccionesMejoraEvento $accionesMejoraEvento,
        protected EventoAdverso $eventoAdverso,
    ) {}

    public function actualizarAccion($request, $accionMejoraEvento)
    {
        return DB::transaction(function () use ($request, $accionMejoraEvento) {
            // Actualizar atributos de la acción de mejora
            $accionMejoraEvento->fill($request->only([
                'nombre',
                'observacion',
                'fecha_cumplimiento',
                'fecha_seguimiento',
                'estado',
                'responsable'
            ]))->save();

            if ($request->hasFile('adjuntos')) {
                $ruta = 'adjuntosEventoAdverso';
                foreach ($request->file('adjuntos') as $archivo) {
                    $nombre = $archivo->getClientOriginalName();
                    $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');

                    $this->adjuntoEventoAdversoRepository->crear([
                        'nombre' => $nombre,
                        'ruta' => $subirArchivo,
                        'accion_mejora_id' => $accionMejoraEvento->id,
                    ]);
                }
            }

            $analisisEvento = AnalisisEvento::find($accionMejoraEvento->analisis_evento_id);
            if ($analisisEvento) {
                $eventoAdverso = EventoAdverso::find($analisisEvento->evento_adverso_id);

                if ($eventoAdverso) {
                    $accionesPendientes = AccionesMejoraEvento::where('analisis_evento_id', $analisisEvento->id)
                        ->where('estado', '!=', 'CUMPLIDO')
                        ->exists();
                    $eventoAdverso->estado_id = $accionesPendientes ? 38 : 39;
                    $eventoAdverso->save();
                }
            }
            GestionEvento::create([
                'accion' => 'Actualización de acción de mejora',
                'evento_adverso_id' => $analisisEvento->evento_adverso_id ?? null,
                'user_id' => Auth::id(),
                'motivo' => 'Se actualiza una acción de mejora',
                'created_at' => now(),
            ]);
            return $accionMejoraEvento;
        });
    }


    public function actualizarDeletedAt($accionMejoraEvento)
    {
        return DB::transaction(function () use ($accionMejoraEvento) {
            $accionMejoraEvento->deleted_at = now();
            $accionMejoraEvento->save();

            $analisis_id = $accionMejoraEvento->analisis_evento_id;
            $registrosRelacionados = AccionesMejoraEvento::where('analisis_evento_id', $analisis_id)
                ->whereNull('deleted_at')
                ->exists();

            if (!$registrosRelacionados) {
                EventoAdverso::whereHas('analisisEvento', function ($q) use ($analisis_id) {
                    $q->where('id', $analisis_id);
                })
                    ->update(['estado_id' => 16]);
            }
            return $accionMejoraEvento;
        });
    }


    public function crearAccionesMejora($request)
    {
        return DB::transaction(function () use ($request) {
            $accionMejora = $this->accionesMejoraEvento::create([
                'nombre' => $request['nombre'],
                'fecha_cumplimiento' => $request['fecha_cumplimiento'],
                'fecha_seguimiento' => $request['fecha_seguimiento'],
                'estado' => $request['estado'],
                'analisis_evento_id' => $request['analisis_evento_id'],
            ]);

            $estados = $this->accionesMejoraEvento::where('analisis_evento_id', $request['analisis_evento_id'])
                ->pluck('estado');

            $nuevoEstado = $estados->contains(fn($estado) => $estado !== 'CUMPLIDO') ? 38 : 39;

            $this->eventoAdverso::where('id', $request['evento_adverso_id'])->update(['estado_id' => $nuevoEstado]);

            //Asignar el evento a los responsables elegidos
            $asignaciones = array_map(fn($userId) => [
                'evento_adverso_id' => $request['evento_adverso_id'],
                'user_id' => $userId,
                'accion_mejora_id' => $accionMejora->id
            ], $request['user_responsable_id']);
            EventoAsignado::insert($asignaciones);

            GestionEvento::create([
                'accion' => 'Creación de acción de mejora',
                'evento_adverso_id' => $request['evento_adverso_id'],
                'user_id' => Auth::id(),
                'motivo' => 'Se registra una nueva acción de mejora',
                'created_at' => now(),
            ]);

             return $accionMejora;
        });
    }
}
