<?php

namespace App\Http\Modules\GestionPqrsf\Formulario\Services;

use App\Traits\ArchivosTrait;
use Illuminate\Support\Facades\Mail;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\ResponsablePqrsf\Models\ResponsablePqrsf;
use App\Http\Modules\GestionPqrsf\Formulario\Models\Formulariopqrsf;
use App\Http\Modules\GestionPqrsf\Repositories\GestionPqrsfRepository;
use App\Http\Modules\Pqrsf\AsignadosPqrsf\Repositories\AsignadoPqrsfRepository;
use App\Http\Modules\GestionPqrsf\AdjuntosPqrsf\Repositories\AdjuntoPqrsfRepository;
use App\Http\Modules\GestionPqrsf\Formulario\Repositories\FormulariopqrsfRepository;
use App\Http\Modules\GestionPqrsf\Models\EncuestaSatisfaccionPqr;
use App\Http\Modules\GestionPqrsf\Models\GestionPqrsf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Http\Modules\Pqrsf\AsignadosPqrsf\Model\Asignado;
use App\Mail\RadicacionPqrfsMail;
use Exception;

class FormularioPqrsfService
{

    use ArchivosTrait;

    public function __construct(
        private FormulariopqrsfRepository $formulariopqrsfRepository,
        private GestionPqrsfRepository $gestionPqrsfRepository,
        private AdjuntoPqrsfRepository $adjuntoPqrsfRepository,
        private AsignadoPqrsfRepository $asignadoPqrsfRepository
    ) {}

    public function crear($data)
    {
        $pqr =  $this->formulariopqrsfRepository->crear($data);
        $gestion = $this->gestionPqrsfRepository->guardarGestion($pqr->id, $data['afiliado_id'], 3, 'Creo pqrf', Auth::user()->id);
        $paciente  = Afiliado::where('id', $data['afiliado_id'])->first();
        //Verificar si 'adjuntos' está definido y no está vacío
        if (isset($data['adjuntos']) && sizeof($data['adjuntos']) >= 1) {
            $archivos = $data['adjuntos'];
            $ruta = 'adjuntosPqrsf';
            foreach ($archivos as $archivo) {
                $nombreOriginal = $archivo->getClientOriginalName();
                $nombre = $data['documento'] . '/' . time() . $nombreOriginal;
                $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                $this->adjuntoPqrsfRepository->crearAdjunto($gestion['id'], $nombreOriginal, $subirArchivo);
            }
        }
        // Envío de correo electrónico
        Mail::send('radicacion_pqr_email', ['radicado_id' => $pqr->id, 'tipo' => 'Crear', 'name' => $paciente->primer_nombre, 'apellido' => $paciente->primer_apellido], function ($m) use ($data) {
            $m->to($data['correo'])->subject('Notificación Radicación');
        });

        return $pqr->id;
    }


    public function actualizar($data)
    {


        $pqr = $this->formulariopqrsfRepository->actualizarPqr($data);
        if ($pqr != 'no') {
            $this->gestionPqrsfRepository->guardarGestion($pqr->id, $pqr->afiliado_id, 5, 'Actualizo Pqrsf', Auth::user()->id);
        }

        return 'ok';
    }

    public function anular($data)
    {
        $pqr = $this->formulariopqrsfRepository->estado($data, 5);
        if ($pqr == true) {
            $this->gestionPqrsfRepository->guardarGestion($data['pqrsf_id'], $data['afiliado_id'], 4, $data['motivo'], Auth::user()->id);
        }
        return 'ok';
    }

    public function solucionar($data)
    {
        // Verificar el estado del PQRSF (estado 17)
        $pqr = $this->formulariopqrsfRepository->estado($data, 17);
        $paciente = Afiliado::where('id', $data['afiliado_id'])->first();

        // Si el PQRSF está en estado 6, realizar la lógica de consulta y creación de gestiones
        $pqrEstado6 = $this->formulariopqrsfRepository->estado($data, 6);

        if ($pqrEstado6) {
            // Obtener los `area_responsable_id` del modelo `Asignado` para el `formulario_pqrsf_id` correspondiente
            $areasAsignadasPqr = Asignado::where('formulario_pqrsf_id', $data['pqrsf_id'])
                                        ->pluck('area_responsable_id');

            // Obtener los registros existentes de `GestionPqrsf` con tipo_id 8 o 22 para los que hicieron devolucion y no hay que registrarles gestion automatica
            $gestionesExistentes = GestionPqrsf::where('formulario_pqrsf_id', $data['pqrsf_id'])
                                            ->whereIn('tipo_id', [8,22])
                                            ->pluck('area_responsable_id');

            // Filtrar las áreas que no tienen una gestión de tipo 8 o 22
            $areasSinGestion = $areasAsignadasPqr->diff($gestionesExistentes);

            // Crear nuevos registros de gestión para las áreas sin gestión
            foreach ($areasSinGestion as $areaId) {
                $this->gestionPqrsfRepository->guardarGestionResponsable($data['pqrsf_id'], $data['afiliado_id'], 8, 'Gestión automática', Auth::user()->id, $areaId);
            }

            // Actualizar el estado del PQRSF a 17
            $this->formulariopqrsfRepository->estado($data, 17);
        }

        if ($pqr || $pqrEstado6) {
            // Guardar la gestión original
            $gestion = $this->gestionPqrsfRepository->guardarGestion($data['pqrsf_id'], $data['afiliado_id'], 9, $data['motivo'], Auth::user()->id);

            // Manejo de archivos adjuntos
            $archivos = $data['adjuntos'] ?? [];
            $path = [];
            $nombreArchivo = [];

            // Procesar archivos adjuntos si se enviaron
            if (!empty($archivos)) {
                $ruta = 'adjuntosPqrsf';

                foreach ($archivos as $archivo) {
                    $nombre = $archivo->getClientOriginalName();
                    $nombreArchivo[] = $nombre;
                    $nombreFinal = auth()->user()->id . '/' . time() . $nombre;

                    // Guardar el archivo
                    $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombreFinal, 'server37');

                    if ($subirArchivo) {
                        // Guardar la referencia del archivo adjunto en la base de datos
                        $this->adjuntoPqrsfRepository->crearAdjunto($gestion['id'], $nombre, $subirArchivo);
                        $path[] = $subirArchivo;
                    } else {
                        // Manejar el error en caso de que no se pueda subir el archivo
                        return response()->json(['error' => 'Error al subir el archivo adjunto.'], 500);
                    }
                }
            }

            // Verificar que el correo del paciente no sea nulo
            if (!$data['email']) {
                return response()->json(['error' => 'Correo del destinatario no proporcionado.'], 400);
            }

            // Envio del correo
            Mail::to($data['email'])->send(new RadicacionPqrfsMail($data, $paciente, $path, $nombreArchivo));

        } else {
            // Manejar el caso donde el estado del PQRSF no es válido
            return response()->json(['error' => 'Estado del PQRSF no válido.'], 400);
        }

        return 'ok';
    }



    public function asignar($data)
    {
        $usuarios = ResponsablePqrsf::whereHas('areasResponsables', callback: function ($query) use ($data) {
            $query->whereIn('area_responsable_pqrsfs.id', $data['area']);
        })->get();
        
        $pqr = $this->formulariopqrsfRepository->estado($data, 6);
        if ($pqr == true) {
            foreach ($data['area'] as $area) {
                //se registran las areas responsables a las que se le asigno la pqr
                $this->gestionPqrsfRepository->guardarGestionResponsable($data['pqrsf_id'], $data['afiliado_id'], 6, 'Asigno Pqrsf', Auth::user()->id,$area);
                $this->asignadoPqrsfRepository->crearAsignado($area, $data['pqrsf_id']);
            }
        }
        Mail::send(
            'email_alert_pqrsfs',
            ['pqrsfid' => $data['pqrsf_id'], 'cedula' => $data['numero_documento']],
            function ($m) use ($usuarios) {
                foreach ($usuarios as $user) {
                    $m->to($user->correo)->subject('Notificación Asignación PQRF');
                }
            }
        );
        return 'ok';
    }

    /**
     * Respuesta a la PQRF, En caso de que la respuesta sea una devolución o una
     * respuesta final se evalua si todas las areas que estan asignadas a la PQRF hayan
     * dado respuesta, de ser asi se envía el PQRF a PreSolucionados
     * @param array $data Datos para la creación de la gestión de PQRF
     * @return array
     * @throws \Exception
     * @author Thomas
     */
    public function respuesta($data)
    {
        DB::beginTransaction();

        try {
            // Guardar la gestión de la Respuesta a la PQRF
            $gestionPQRF = GestionPqrsf::create([
                'formulario_pqrsf_id' => $data['pqrsf_id'],
                'user_id' => auth()->user()->id,
                'afiliado_id' => $data['afiliado_id'],
                'tipo_id' => $data['tipo_id'],
                'motivo' => $data['motivo'],
                'area_responsable_id' => $data['area_responsable_id'],
                'fecha' => Carbon::now()
            ]);

            // Verificar si hay archivos adjuntos
            if (isset($data['adjuntos']) && sizeof($data['adjuntos']) >= 1) {
                $archivos = $data['adjuntos'];
                $ruta = 'adjuntosPqrsf';
                foreach ($archivos as $archivo) {
                    $nombre = $archivo->getClientOriginalName();
                    $nombreFinal = auth()->user()->id . '/' . time() . $nombre;
                    $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombreFinal, 'server37');
                    $this->adjuntoPqrsfRepository->crearAdjunto($gestionPQRF->id, $nombre, $subirArchivo);
                }
            }

            if ($data['tipo_id'] == 22) {

                 // Actualizar estado de asignado y verificar asignados activos
                Asignado::where('formulario_pqrsf_id', $data['pqrsf_id'])
                ->where('area_responsable_id', $data['area_responsable_id'])
                ->update(['estado_id' => 2]);

                $nuevoEstado = Asignado::where('formulario_pqrsf_id', $data['pqrsf_id'])->where('estado_id', 1)->exists() ? 6 : 18;
                Formulariopqrsf::where('id', $data['pqrsf_id'])->update(['estado_id' => $nuevoEstado]);

            } elseif ($data['tipo_id'] == 8) {
                  // Verificar si todas las áreas asignadas tienen respuesta
                $areasAsignadas = Asignado::where('formulario_pqrsf_id', $data['pqrsf_id'])->pluck('area_responsable_id')->toArray();

                //verificar que las áreas tienen respuesta sea final o devolucion y se obtienen los id unicos
                $areasConRespuestas = GestionPqrsf::where('formulario_pqrsf_id', $data['pqrsf_id'])
                ->whereIn('tipo_id', [8,22])
                ->whereIn('area_responsable_id', $areasAsignadas)
                ->distinct('area_responsable_id')
                ->pluck('area_responsable_id')
                ->toArray();

                Asignado::where('formulario_pqrsf_id', $data['pqrsf_id'])
                    ->where('area_responsable_id',$data['area_responsable_id'])
                    ->update(['estado_id' => 2]);

                // Actualizar estado si todas las áreas asignadas tienen respuesta
                if (empty(array_diff($areasAsignadas, $areasConRespuestas))) {
                    Formulariopqrsf::where('id', $data['pqrsf_id'])->update(['estado_id' => 18]);
                }
            }

            DB::commit();

            // Retornar un mensaje junto con los datos de la gestión
            return [
                'success' => true,
                'message' => 'La respuesta se ha registrado exitosamente.',
                'data' => $gestionPQRF
            ];
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }



    public function reclasificar($data)
    {


        $pqr = $this->formulariopqrsfRepository->reclasificarPqr($data);
        if ($pqr == true) {
            $this->gestionPqrsfRepository->guardarGestion($data['pqrsf_id'], $data['afiliado_id'], 5, 'Actualizo Pqrsf', Auth::user()->id);
        }

        return 'ok';
    }


    public function respuestaFinal($data)
    {
        // Guardar la gestión del PQRSF
        $gestion = $this->gestionPqrsfRepository->guardarGestion(
            $data['pqrsf_id'],
            $data['afiliado_id'],
            9,
            $data['respuesta'],
            Auth::user()->id
        );

        // Verificar si 'adjuntos' está definido y no está vacío
        $alladjuntos = [];
        if (isset($data['adjuntos']) && sizeof($data['adjuntos']) >= 1) {
            $archivos = $data['adjuntos'];
            $ruta = 'adjuntosPqrsf';
            foreach ($archivos as $archivo) {
                $nombreOriginal = $archivo->getClientOriginalName();
                $nombre = $data['documento'] . '/' . time() . $nombreOriginal;
                $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');

                // Asegurarse de que el archivo se subió correctamente
                if ($subirArchivo) {
                    $this->adjuntoPqrsfRepository->crearAdjunto(
                        $gestion['id'],
                        $nombreOriginal,
                        $subirArchivo
                    );
                    $alladjuntos[] = $subirArchivo;
                }
            }
        }

        // Preparar la solución o respuesta
        $solucion = $data['respuesta'];

        // Envío de correo electrónico
        try {
            Mail::send(
                'email_solution_pqrsfs',
                ['datospaciente' => $data, 'solucion' => $solucion],
                function ($m) use ($data, $alladjuntos) {
                    $m->to($data['email'], $data['nombre'])
                        ->subject('PQRSF Solucionado');

                    // Adjuntar archivos al correo si hay adjuntos
                    foreach ($alladjuntos as $ruta) {
                        $m->attach(public_path('storage/' . $ruta));
                    }
                }
            );
        } catch (\Exception $e) {
            // Manejar el error del envío de correo
            Log::error('Error al enviar el correo: ' . $e->getMessage());
        }

        // Cambiar estado del PQRSF a resuelto
        $this->formulariopqrsfRepository->estado($data, 17);

        return 'ok';
    }



    public function reasignar($data)
    {
        $usuarios = ResponsablePqrsf::whereHas('areasResponsables', function ($query) use ($data) {
            $query->whereIn('area_responsable_pqrsfs.id', $data['area']);
        })->get();

        $pqr = Formulariopqrsf::where('id', $data['pqrsf_id']);
        if ($pqr == true) {
            $motivo = isset($data['motivo']) && !empty($data['motivo']) ? $data['motivo'] : 'Asigno Pqrsf';
            foreach ($data['area'] as $area) {
                $this->gestionPqrsfRepository->guardarGestionResponsable($data['pqrsf_id'],$data['afiliado_id'],10,$motivo,Auth::user()->id,$area);
                $this->asignadoPqrsfRepository->crearAsignado($area, $data['pqrsf_id']);
            }

            $pqr->update(['estado_id' => 6]);
        }
        Mail::send(
            'email_alert_pqrsfs',
            ['pqrsfid' => $data['pqrsf_id'], 'cedula' => $data['numero_documento']],
            function ($m) use ($usuarios) {
                foreach ($usuarios as $user) {
                    $m->to($user->correo)->subject('Notificación Asignación PQRF');
                }
            }
        );
    return 'ok';
    }


    public function cargueMasivo($datos)
    {
        $existe = [];
        $noExiste = [];
        $errores = [];
        $msg = '';

        // Contamos la cantidad de líneas primero
        $lineas = (new FastExcel)->import($datos['adjunto']);
        $numeroLineas = count($lineas);

        // Verificamos si el archivo tiene más de 700 líneas
        if ($numeroLineas > 700) {
            return ['message' => 'El archivo contiene más de 700 registros, por favor ajusta el tamaño.'];
        }

        // Recorremos las líneas para validar todos los datos antes de guardar
        foreach ($lineas as $line) {
            $documento_string = (string)$line["Documento"];
            $paciente = Afiliado::where('numero_documento', $documento_string)->where('estado_afiliacion_id', 1)->first();
            $email = filter_var($line["Email"], FILTER_VALIDATE_EMAIL);
            $usuario = User::find($line['Usuario_id']);

            // Validación de usuario
            if (!$usuario) {
                $errores[] = "El usuario con ID {$line['Usuario_id']} no existe o está inactivo.";
                continue;
            }

            // Validación de campos numéricos y email
            if (!is_numeric($line["Telefono"])) {
                $errores[] = "El teléfono del documento {$documento_string} no es numérico.";
                continue;
            }

            if (!$email) {
                $errores[] = "El email del documento {$documento_string} no es válido.";
                continue;
            }

            // Validación de campos obligatorios vacíos
            if (empty($line["Email"]) || !is_numeric($line["Telefono"]) || empty($line["Descripcion"])) {
                $errores[] = "Campos obligatorios vacíos en el documento {$documento_string}: (Email, Teléfono, Descripción)";
                continue;
            }

            if ($paciente) {
                // Si el paciente existe, lo añadimos al array 'existe'
                $data = $line;
                $data["afiliado_id"] = $paciente->id;
                $data["user_id"] = $line['Usuario_id'];
                $existe[] = $data;
            } else {
                // Si el paciente no existe, lo añadimos al array 'noExiste'
                if (empty($line["Documento"])) {
                    $errores[] = "El campo 'Documento' está vacío.";
                } else {
                    $noExiste[] = "Documento {$documento_string} no existe en el sistema o se encuentra inactivo.";
                }
            }
        }

        // Si hay errores, los devolvemos sin guardar nada
        if (!empty($errores)) {
            return ['message' => 'Errores encontrados', 'detalles' => $errores];
        }

        // Si hay registros que no existen
        if (!empty($noExiste)) {
            return ['message' => 'Algunos documentos no existen', 'detalles' => $noExiste];
        }

        // Si los registros existen, procedemos a guardarlos
        foreach ($existe as $key) {
            $pqrsf = new Formulariopqrsf();
            $pqrsf->afiliado_id = $key['afiliado_id'];
            $pqrsf->tipo_solicitud_id = 6;
            $pqrsf->codigo_super = !empty($key['Supersalud']) ? $key['Supersalud'] : null;
            $pqrsf->correo = $key['Email'];
            $pqrsf->telefono = $key['Telefono'];
            $pqrsf->descripcion = $key['Descripcion'];
            $pqrsf->canal_id = 11;
            $pqrsf->estado_id = 10;
            $pqrsf->usuario_registra_id = $key['user_id'];
            $pqrsf->quien_genera = 'Usuario';
            $pqrsf->save();

            // Guardamos la gestión de manera segura
            $this->gestionPqrsfRepository->guardarGestion(
                $pqrsf->id,
                $key['afiliado_id'],
                3,
                'Creo pqrf',
                $key['user_id']
            );
        }

        return ['message' => 'Carga de PQRSF con éxito'];
    }


    public function descargaFormato()
    {
        $formato = collect([
            [
                'Documento' => '',
                'Email' => '',
                'Telefono' => '',
                'Descripcion' => '',
                'Supersalud' => ''
            ]
        ]);

        return (new FastExcel($formato))->download('file.xls');
    }

    public function crearPqrsfAutogestion($data)
    {
        $pqr = new Formulariopqrsf();
        $pqr->quien_genera = $data['quien_genera'];
        $pqr->documento_genera = $data['documento_genera'];
        $pqr->nombre_genera = $data['nombre_genera'];
        $pqr->correo = $data['correo'];
        $pqr->telefono = $data['telefono'];
        $pqr->reabierta = false;
        $pqr->descripcion = $data['descripcion'];
        $pqr->canal_id = $data['canal_id'];
        $pqr->tipo_solicitud_id = $data['tipo_solicitud_id'];
        $pqr->afiliado_id = $data['afiliado_id'];
        $pqr->usuario_registra_id = $data['usuario_registra_id'];
        $pqr->estado_id = 10;

        $pqr->save();

        $gestion = $this->gestionPqrsfRepository->guardarGestion($pqr->id, $data['afiliado_id'], 3, 'Creo pqrf', Auth::user()->id);

        if (isset($data['adjuntos']) && sizeof($data['adjuntos']) >= 1) {
            $archivos = $data['adjuntos'];
            $ruta = 'adjuntosPqrsf';
            foreach ($archivos as $archivo) {
                $nombreOriginal = $archivo->getClientOriginalName();
                $nombre = $data['documento_genera'] . '/' . time() . $nombreOriginal;
                $subirArchivo = $this->subirArchivoNombre($ruta, $archivo, $nombre, 'server37');
                $this->adjuntoPqrsfRepository->crearAdjunto($gestion['id'], $nombreOriginal, $subirArchivo);
            }
        }

        return $pqr->id;
    }

    public function listarPqrsfAutogestion($radicadoId = null)
    {
        $afiliadoId = Afiliado::where('user_id', auth()->user()->id)->first()->id;

        // Construir la consulta
        $query = Formulariopqrsf::with([
            'estado', 
            'solicitud',
            'gestionPqr'=>function($query){
                $query->where('tipo_id',9);
            },
            'gestionPqr.adjuntos'
            ])
            ->where('afiliado_id', $afiliadoId)
            ->orderBy('id', 'desc');

        // Aplicar filtro si se proporciona
        if ($radicadoId) {
            $query->where('id', $radicadoId);
        }

        return $query->get();
    }

    public function actualizarDatosContactoPqrsf($pqrsfId, $data)
    {
        $pqrsf = Formulariopqrsf::findOrFail($pqrsfId);

        $pqrsf->update([
            'correo' => $data['correo'],
            'telefono' => $data['telefono'],
        ]);

        return response()->json([
            'message' => 'Datos de contacto actualizados con éxito.',
            'status' => 'success',
            'pqrsf_id' => $pqrsf->id,
        ]);
    }


    public function cargueMasivoSupersalud($request)
    {
        // Obtener el archivo
        $archivo = $request['archivo'];

        // Inicializar FastExcel
        $fastExcel = new FastExcel();

        // Cargar el archivo y obtener una colección
        $coleccion = $fastExcel->import($archivo->getRealPath());
        // Inicializar un array para almacenar errores
        $errores = [];

        // Obtener todos los documentos en una sola consulta para mejorar la eficiencia
        $documentos = $coleccion->pluck('Numero de Documento')->filter()->unique()->toArray();
        $afiliados = Afiliado::whereIn('numero_documento', $documentos)->get()->keyBy('numero_documento');

        $columnasMapeadas = $coleccion->map(function ($item, $index) use (&$errores, $afiliados) {
            $fila = $index + 1;

            // Validar campos requeridos
            if (empty($item['Numero de Documento'])) {
                $errores[] = "Fila {$fila}: El campo 'Numero de Documento' es obligatorio.";
                return null;
            }

            if (empty($item['Correo Electronico'])) {
                $errores[] = "Fila {$fila}: El campo 'Correo Electronico' es obligatorio.";
                return null;
            }

            if (empty($item['ID Usuario'])) {
                $errores[] = "Fila {$fila}: El campo 'ID Usuario' es obligatorio.";
                return null;
            }

            // Buscar afiliado basado en el documento
            $afiliado = $afiliados->get($item['Numero de Documento']);

            // Verificar si el afiliado existe
            if (!$afiliado) {
                $errores[] = "Fila {$fila}: Afiliado con documento {$item['Numero de Documento']} no encontrado.";
                return null;
            }

            // Verificar si el ID de usuario existe
            $usuarioExiste = User::find($item['ID Usuario']);
            if (!$usuarioExiste) {
                $errores[] = "Fila {$fila}: El ID Usuario {$item['ID Usuario']} no es válido.";
                return null;
            }

            // Mapear los datos para la inserción
            return [
                'afiliado_id' => $afiliado->id,
                'documento_genera' => $item['Numero de Documento'],
                'correo' => $item['Correo Electronico'],
                'telefono' => $item['Telefono'] ?? null,
                'descripcion' => $item['Descripcion'] ?? null,
                'codigo_super' => $item['Codigo Supersalud'] ?? null,
                'usuario_registra_id' => $item['ID Usuario'] ?? null,
                'quien_genera' => 'Usuario',
                'tipo_solicitud_id' => 6,
                'canal_id' => 11,
                'estado_id' => 10
            ];
        })->filter();

        // Si hay errores, devolverlos
        if (!empty($errores)) {
            return response()->json([
                'errores' => $errores,
                'status' => 'error',
            ], 400);
        }

        // Convertir la colección a un array para la inserción masiva
        if ($columnasMapeadas->isNotEmpty()) {
            DB::beginTransaction();
            try {
                foreach ($columnasMapeadas as $columna) {
                    $formulario = Formulariopqrsf::create($columna);

                    // Crear otro registro relacionado y asociarlo con formulario_pqrsf_id
                    GestionPqrsf::create([
                        'formulario_pqrsf_id' => $formulario->id,
                        'user_id' => $columna['usuario_registra_id'],
                        'afiliado_id' => $formulario->afiliado_id,
                        'tipo_id' => 3,
                        'motivo' => 'Creó PQRSF',
                        'fecha' => Carbon::now(),
                    ]);
                }

                DB::commit();
            } catch (Exception $e) {
                DB::rollBack();
                throw new Exception($e->getMessage());
            }
        } else {
            throw new Exception('No se encontraron registros para cargar.');
        }

        return response()->json(['mensaje' => 'Cargue masivo realizado exitosamente']);
    }


    /**
     * Guarda una gestión y se asocia a una PQR.
     * @param mixed $pqr_id
     * @param mixed $tipo
     * @param mixed $motivo
     * @return GestionPqrsf|\Illuminate\Database\Eloquent\Model
     * @author AlejoSR
     */
    public function guardarGestion($pqr_id,$tipo,$motivo)
    {
        try{
            #se obtiene la PQR asociada
            $pqr = $this->formulariopqrsfRepository->obtenerPqr($pqr_id);
            
            #se obtiene la información del usuario que solucionó la PQR para asociarlo
            $usuario_registra =$pqr->load('gestionPqr')->gestionPqr->where('tipo_id',9)->value('user_id');

            #se obtiene la información del afiliado asociado
            $afiliado = $pqr->afiliado_id;

            #se registra la gestión
            $gestion = $this->gestionPqrsfRepository->guardarGestion($pqr_id,$afiliado,$tipo,$motivo,$usuario_registra);

            return $gestion;


        }catch(\Throwable $th){
            throw $th;
        }
    }

    /**
     * Obtiene la respuesta del envío o  rebote de los correos y los procesa de acuerdo al asunto de interes (Notificación Solución caso) que obedece a PQRS
     * @param array $respuesta
     * @return bool|GestionPqrsf|mixed|\Illuminate\Database\Eloquent\Model
     * @author AlejoSR
     */
    public function solucionEmailWebHook(array $respuesta)
    {
        // dd($respuesta);
        #si el evento es de mi interés, en este caso "entregado", entonces proceso para guardar la gestión exitosa
            if ($respuesta['event'] === "delivered") {

                #Si asunto del correo es relacionado con la notificación de la solución del caso (de nuestro interés)
                if (str_contains($respuesta['subject'], 'Notificación Solución caso')) {
                    $email = explode(" ", $respuesta['subject']);

                    #el id de la pqr está en la posicion 3 del asunto del correo
                    $pqrId = (int)$email[3];

                    
                    #se guarda la gestión del caso
                    return $this->guardarGestion($pqrId, 50, 'El correo fue enviado de manera exitosa a la bandeja de entrada del usuario');
                }
        #si el evento fue rebotado o email invalido proceso con error
            } else if ($respuesta['event'] === "soft_bounce" || $respuesta['event'] === "hard_bounce" || $respuesta['event'] === "invalid_email") {
                
                #si el evento es de rebote o correo invalido, registro en el historico
                if (str_contains($respuesta['subject'], 'Notificación Solución caso')) {
                    $email = explode(" ", $respuesta['subject']);
                    $pqrId = (int)$email[3];

                    #se guarda la gestión del caso
                    $this->guardarGestion($pqrId, 51, 'Hubo un error durante el envío y la entrega del correo de notificación al usuario.');
                    
                    #actualizo el estado de la pqr para regresar a presolucionados y que hagan la gestión del envío nuevamente
                    $pqrsId = [
                        'pqrsf_id' => $pqrId
                    ];
                    return $this->formulariopqrsfRepository->estado($pqrsId,18);
                }
            }
    }


    /**
     * Procesa y almacena los datos de la encuesta de satisfacción diligenciada por los usuarios.
     * @param array $datos
     * @throws \Exception
     * @return EncuestaSatisfaccionPqr|\Illuminate\Database\Eloquent\Model
     */
    public function guardarEncuesta(array $datos)
    {
        try{
        #verificamos si la encuesta ya existe, en caso de que sea asi, se arroja error de duplicidad
        $encuesta = EncuestaSatisfaccionPqr::where('formulario_pqr_id',$datos['radicado'])->first();
        
        if($encuesta){
            throw new Exception('La encuesta de satisfaccion para el radicado '.$datos['radicado'].' ya fue diligenciada');
        }
        
        #si no existe, se crea el registro de la encuesta
        $registro = EncuestaSatisfaccionPqr::create([
            'formulario_pqr_id' => $datos['radicado'],
            'solucion_final' => $datos['pregunta1'],
            'comprension_clara' => $datos['pregunta2'],
            'respuesta_coherente' => $datos['pregunta3']
        ]);

        return $registro;

        }catch(\Throwable $th){
            throw $th;
        }
    }
}
