<?php

namespace App\Http\Modules\MesaAyuda\MesaAyuda\Services;

use App\Traits\ArchivosTrait;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\MesaAyuda\MesaAyuda\Models\MesaAyuda;
use App\Http\Modules\AdjuntoMesaAyuda\Models\AdjuntosMesaAyuda;
use App\Http\Modules\MesaAyuda\MesaAyuda\Repositories\MesaAyudaRepository;
use App\Http\Modules\MesaAyuda\MesaAyuda\Models\MesaAyudaFechaMetaHistorial;
use App\Http\Modules\MesaAyuda\CategoriaMesaAyudaUser\Model\CategoriaMesaAyudaUser;
use App\Http\Modules\MesaAyuda\AdjuntosMesaAyudas\Repositories\AdjuntosMesaAyudasRepository;
use App\Http\Modules\MesaAyuda\SeguimientoActividades\Models\SeguimientoActividades;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class MesaAyudaService
{
    use ArchivosTrait;

    public function __construct(
        private MesaAyudaRepository $mesaAyudaRepository,
        private AdjuntosMesaAyudasRepository $adjuntosMesaAyuda,
    ) {}

    public function RadicarSolicitud($request)
    {
        $usuario_registra_id = auth()->id();
        $data = $request;
        $data['usuario_registra_id'] = $usuario_registra_id;
    }

    public function radicar($data)
    {
        $this->RadicarSolicitud($data);
        $mesaAyuda = $this->mesaAyudaRepository->crear($data);
        // Asignar el caso a todos los usuarios de la categoría especificada
        $this->crearActualizarAsignacion($mesaAyuda->id, $data['categoria_mesa_ayuda_id']);
        if (isset($data['adjuntos'])) {
            $archivos = $data['adjuntos'];
            $ruta = 'adjuntosMesaAyuda';
            if (sizeof($archivos) >= 1) {
                foreach ($archivos as $archivo) {
                    $nombreOriginal = $archivo->getClientOriginalName();
                    $nombre = $mesaAyuda->id . '/' . time() . $nombreOriginal;
                    $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                    $this->adjuntosMesaAyuda->crearAdjunto($mesaAyuda->id, $nombreOriginal, $subirArchivo);
                }
            }
        }
        $this->enviarNotificaciones($mesaAyuda, 'creado');

        return $mesaAyuda;
    }

    public function reasignar($mesaAyudaId, $data)
    {
        ($this->mesaAyudaRepository->update($mesaAyudaId, [
            'categoria_mesa_ayuda_id' => $data['categoria_mesa_ayuda_id'],
            'estado_id' => 15,
        ]));

        $this->crearActualizarAsignacion($mesaAyudaId, $data['categoria_mesa_ayuda_id']);
        DB::table('seguimiento_actividades')->insert([
            'respuesta' => $data['motivo'],
            'user_id' => auth()->id(),
            'mesa_ayuda_id' => $mesaAyudaId,
            'estado_id' => 15,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $casoReasignado = $this->mesaAyudaRepository->find($mesaAyudaId);
        $this->enviarNotificaciones($casoReasignado, 'reasignado');

        return $casoReasignado;
    }

    public function reabrirCaso($mesaAyudaId, $data)
    {
        $this->mesaAyudaRepository->update($mesaAyudaId, [
            'categoria_mesa_ayuda_id' => $data['categoria_mesa_ayuda_id'],
            'estado_id' => 6,
        ]);

        $this->crearActualizarAsignacion($mesaAyudaId, $data['categoria_mesa_ayuda_id']);
        DB::table('seguimiento_actividades')->insert([
            'respuesta' => $data['motivo'],
            'user_id' => auth()->id(),
            'estado_id' => 6,
            'mesa_ayuda_id' => $mesaAyudaId,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $casoReabierto = $this->mesaAyudaRepository->find($mesaAyudaId);
        $this->enviarNotificaciones($casoReabierto, 'reabierto');

        return $casoReabierto;
    }

    private function crearActualizarAsignacion($mesaAyudaId, $categoriaId)
    {
        DB::table('asignados_mesa_ayudas')->where('mesa_ayuda_id', $mesaAyudaId)->delete();
        $usuarios = CategoriaMesaAyudaUser::where('categoria_mesa_ayuda_id', $categoriaId)->get();

        foreach ($usuarios as $usuario) {
            DB::table('asignados_mesa_ayudas')->insert([
                'mesa_ayuda_id' => $mesaAyudaId,
                'categoria_mesa_ayuda_id' => $categoriaId,
                'user_id' => $usuario->user_id,
                'estado_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }


    public function comentario($mesaAyudaId, $data)
    {

        $casoActualizado = $this->mesaAyudaRepository->find($mesaAyudaId);

        $casoActualizado->update([
            'estado_id' => 19,
        ]);

        $comentarioId = DB::table('seguimiento_actividades')->insertGetId([
            'respuesta' => $data['motivo'],
            'user_id' => auth()->id(),
            'mesa_ayuda_id' => $mesaAyudaId,
            'estado_id' => 18,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Guardar adjuntos si vienen
        if (isset($data['archivos'])) {
            $archivos = $data['archivos'];
            $adjuntos = $this->guardarAdjuntos($casoActualizado, $archivos);

            // Asociar cada adjunto al comentario creado
            foreach ($adjuntos as $adjunto) {
                DB::table('seguimiento_actividades')
                    ->where('id', $comentarioId)
                    ->update([
                        'adjunto' => $adjunto->id ?? null,
                    ]);
            }
        }

        $this->enviarMensaje($casoActualizado, 'comentado', $data['motivo']);

        return $casoActualizado;
    }

    public function gestionando($mesaAyudaId, $data)
    {
        $this->mesaAyudaRepository->update($mesaAyudaId, [
            'estado_id' => 19,
        ]);

        DB::table('seguimiento_actividades')->insert([
            'respuesta' => $data['motivo'],
            'user_id' => auth()->id(),
            'mesa_ayuda_id' => $mesaAyudaId,
            'estado_id' => 18,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $casoGestionando = $this->mesaAyudaRepository->find($mesaAyudaId);
        $this->enviarMensaje($casoGestionando, 'gestionando');

        return $casoGestionando;
    }


    public function responderComentario($mesaAyudaId, $data)
    {
        $this->mesaAyudaRepository->update($mesaAyudaId, [
            'estado_id' => 19,
        ]);

        DB::table('seguimiento_actividades')->insert([
            'respuesta' => $data['motivo'],
            'user_id' => auth()->id(),
            'mesa_ayuda_id' => $mesaAyudaId,
            'estado_id' => 19,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $mesaAyuda = $this->mesaAyudaRepository->find($mesaAyudaId);
        if (isset($data['adjuntos'])) {
            $archivos = $data['adjuntos'];
            $ruta = 'adjuntosMesaAyuda';
            if (sizeof($archivos) >= 1) {
                foreach ($archivos as $archivo) {
                    $nombreOriginal = $archivo->getClientOriginalName();
                    $nombre = $mesaAyuda->id . '/' . time() . '_' . $nombreOriginal;
                    $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                    $this->adjuntosMesaAyuda->crearAdjunto($mesaAyuda->id, $nombreOriginal, $subirArchivo);
                }
            }
        }

        $this->enviarNotificaciones($mesaAyuda, 'Respuesta al comentario');

        return $mesaAyuda;
    }



    private function enviarNotificaciones($mesaAyuda, $accion)
    {
        $usuarios = CategoriaMesaAyudaUser::where('categoria_mesa_ayuda_id', $mesaAyuda->categoria_mesa_ayuda_id)
            ->with('user')
            ->get();

        foreach ($usuarios as $usuario) {
            $this->enviarCorreo($usuario->user->email, $mesaAyuda, $accion);
        }
    }

    private function enviarMensaje($mesaAyuda, $accion, $motivo = '')
    {
        $usuario = MesaAyuda::where('id', $mesaAyuda->id)
            ->with('user')
            ->first();

        if ($usuario) {
            $this->enviarCorreo($usuario->user->email, $mesaAyuda, $accion, $motivo);
        }
    }

    public function calificarGestion($mesaAyudaId, $calficacion)
    {
        $mesaAyuda = $this->mesaAyudaRepository->find($mesaAyudaId);
        $mesaAyuda->calficacion = $calficacion;
        $mesaAyuda->save();
    }

    private function enviarCorreo($email, $mesaAyuda, $accion, $motivo = '')
    {
        $subject = 'Notificación de Mesa de Ayuda';
        $viewData = [
            'mesaAyuda' => $mesaAyuda,
            'accion' => $accion,
            'motivo' => $motivo
        ];


        Mail::send('email_mesa_ayuda', $viewData, function ($message) use ($email, $subject) {
            $message->to($email)
                ->subject($subject);
        });
    }

    public function definirFechaMeta(int $id, string $fecha, ?string $motivo = null): void
    {
        $fechaParseada = Carbon::parse($fecha)->startOfDay();
        $mesaAyuda = $this->mesaAyudaRepository->buscar($id);

        $fechaActual = $mesaAyuda->fecha_meta_solucion
            ? Carbon::parse($mesaAyuda->fecha_meta_solucion)->startOfDay()
            : null;

        $esActualizacion = !is_null($fechaActual);
        $fechaCambio = $fechaActual?->ne($fechaParseada);

        if ($esActualizacion && $fechaCambio) {
            if (is_null($motivo)) {
                throw new \InvalidArgumentException('Debe proporcionar un motivo para actualizar la fecha meta.');
            }

            MesaAyudaFechaMetaHistorial::create([
                'mesa_ayuda_id'  => $mesaAyuda->id,
                'fecha_anterior' => $fechaActual,
                'fecha_nueva'    => $fechaParseada,
                'modificado_por' => Auth::id(),
                'motivo'         => $motivo,
            ]);
        }

        $mesaAyuda->fecha_meta_solucion = $fechaParseada;
        $mesaAyuda->save();

        $usuario = User::find($mesaAyuda->usuario_registra_id);

        if ($usuario?->email) {
            $motivoCorreo = sprintf(
                "Se ha iniciado la gestión de su caso con ID #%d.\n\n" .
                    "🗓️ Fecha meta de solución: %s\n\n" .
                    "Tenga en cuenta que esta fecha es una estimación y puede estar sujeta a cambios dependiendo del tipo de caso y condiciones operativas.",
                $mesaAyuda->id,
                $fechaParseada->translatedFormat('d \d\e F \d\e Y') // Ej: 28 de julio de 2025
            );

            $this->enviarCorreo(
                $usuario->email,
                $mesaAyuda,
                'Asignado fecha tentativa de solución de su caso',
                $motivoCorreo
            );
        }
    }

    public function guardarAdjuntos($mesaAyuda, $archivos)
    {
        $adjuntosGuardados = [];

        if (isset($archivos) && sizeof($archivos) >= 1) {
            $ruta = 'adjuntosMesaAyuda';
            foreach ($archivos as $archivo) {
                $nombreOriginal = $archivo->getClientOriginalName();
                $nombre = $mesaAyuda->id . '/' . time() . '_' . $nombreOriginal;

                $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');

                // crea el adjunto en base de datos
                $adjunto = $this->adjuntosMesaAyuda->crearAdjunto(
                    $mesaAyuda->id,
                    $nombreOriginal,
                    $subirArchivo
                );

                $adjuntosGuardados[] = $adjunto;
            }
        }

        return $adjuntosGuardados;
    }

    public function solucionarSolicitud(Request $request, int $mesaAyudaId): JsonResponse
    {
        try {
            $user = auth()->user();

            $seguimiento = SeguimientoActividades::create([
                'user_id' => $user->id,
                'respuesta' => $request->respuesta ?? null,
                'mesa_ayuda_id' => $mesaAyudaId,
                'estado_id' => 17, // Estado: Solucionado
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $mesaAyuda = MesaAyuda::findOrFail($mesaAyudaId);

            // Guardar adjuntos si existen
            if ($request->hasFile('archivos')) {
                $archivos = $request->file('archivos'); // Array de archivos
                $adjuntos = $this->guardarAdjuntos($mesaAyuda, $archivos);

                // Guardar todos los IDs en JSON para no sobrescribir
                $idsAdjuntos = [];
                foreach ($adjuntos as $adjunto) {
                    $idsAdjuntos[] = $adjunto->id ?? null;
                }

                $seguimiento->update([
                    'adjunto' => json_encode($idsAdjuntos)
                ]);
            }

            $mesaAyuda->update(['estado_id' => 17]);

            return response()->json([
                'message' => 'Solicitud solucionada con éxito',
                'seguimiento' => $seguimiento,
            ], Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Ocurrió un error al procesar la solicitud',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
