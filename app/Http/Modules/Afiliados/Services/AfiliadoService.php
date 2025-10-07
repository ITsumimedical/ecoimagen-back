<?php

namespace App\Http\Modules\Afiliados\Services;

use Error;
use Illuminate\Support\Str;
use App\Traits\ArchivosTrait;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\TipoDocumentos\Models\TipoDocumento;
use App\Http\Modules\Afiliados\Repositories\AfiliadoRepository;
use App\Http\Modules\NovedadesAfiliados\Requests\CrearNovedadAfiliadoRequest;
use App\Http\Modules\NovedadesAfiliados\Repositories\NovedadAfiliadoRepository;

class AfiliadoService
{

    use ArchivosTrait;
    protected $afiliadoRepository;
    protected $novedadRepository;

    public function __construct(AfiliadoRepository $afiliadoRepository)
    {
        $this->afiliadoRepository = $afiliadoRepository;
        $this->novedadRepository = new NovedadAfiliadoRepository;
    }

    /**
     **Carga masiva de afiliados y novedades
     * @param Object $request
     * @return boolean
     * @author kobatime
     */
    public function actualizarNovedades($request)
    {

        // !Ruta de cargue de archivo
        $ruta_011 = '\Cargue_Archivos\Usuarios_Hosvital';
        // !separando el adjunto del request
        $archivo = $request->file('adjunto');
        // !subir archivo al FTP
        // return $archivo;
        $nombre = $archivo->getClientOriginalName();
        $ruta_archivo = $this->subirArchivoNombre($ruta_011, $archivo, $nombre, 'server37');
        // !Se genera un nombre al archivo
        $nombre_archivo = explode('/', $ruta_archivo);
        // !Procedimiento almacenado que genera lectura del archivo
        $ejecutarProcedimiento = (DB::select('exec dbo.sp_NovedadesDiariasUsFomag ?', [$nombre_archivo[1]]));
        // !Se elimina el archivo del FTP
        return $ejecutarProcedimiento;
        $eliminar_archivo = $this->borrarArchivo($ruta_archivo, 'server37');
    }


    /**
     **Valida la informacion de novedades
     * @param Array $data
     * @return boolean|Array
     * @author kobatime
     */
    public function validarNovedadAfiliado($data)
    {
        $crearRequest = new CrearNovedadAfiliadoRequest();
        $reglas = $crearRequest->rules();
        $validator = Validator::make($data, $reglas);

        if ($validator->fails()) {
            throw new Error(json_encode($validator->errors()), Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return false;
    }

    /**
     **Preparar informacion de novedades
     * @param int $novedad_id
     * @param int $idAfiliado
     * @return Array
     * @author kobatime
     */
    public function prepararDataNovedad($novedad_id, $idAfiliado)
    {

        $novedad['fecha_novedad'] = now();
        $novedad['motivo'] = 'Creacion de Afiliado';
        $novedad['user_id'] = Auth::id();
        $novedad['tipo_novedad_afiliados_id'] = $novedad_id;
        $novedad['afiliado_id'] = $idAfiliado;
        $novedad['estado_id'] = 1;

        return $novedad;
    }

    /**
     **Preparar informacion de afiliado
     * @author jdss
     */
    public function validacionRedVital($data)
    {
        $afiliado = $this->afiliadoRepository->validacionRedVital($data);
        return $afiliado;
        if ($afiliado) {
            return $this->afiliadoRepository->citasAfiliado($data['documento']);
        }

        if (isset(Auth::user()->id)) {
            return 'La cedula no registra en nuestra base de datos';
        } else {
            return 'Señor usuario su cédula y/o contraseña son incorrectos.';
        }
    }

    public function verificacionEdad($edad, $tipo_documento)
    {
        $tipoDocumentoEsperado = null;

        switch (true) {
            case $edad >= 0 && $edad <= 1:
                $tipoDocumentoEsperado = [12, 3]; // Permitimos ambos tipos de documento
                break;
            case $edad > 1 && $edad <= 7:
                $tipoDocumentoEsperado = 3;
                break;
            case $edad > 7 && $edad <= 17:
                $tipoDocumentoEsperado = 2;
                break;
            case $edad >= 18 && $edad <= 120:
                $tipoDocumentoEsperado = 1;
                break;
            default:
                throw new \Exception("Edad no válida para ningún tipo de documento.");
        }

        // Verificar si el tipo de documento está en la lista permitida
        if (is_array($tipoDocumentoEsperado)) {
            if (!in_array($tipo_documento, $tipoDocumentoEsperado)) {
                return true; // Tipo de documento no válido
            }
        } elseif ($tipo_documento !== $tipoDocumentoEsperado) {
            return true; // Tipo de documento no válido
        }

        return null; // Tipo de documento válido

    }

    public function crearAfiliado($request)
    {
        return DB::transaction(function () use ($request) {
            $cotizante = null;

            if ((int) $request['tipo_afiliado_id'] == 1) {
                $cotizante = $this->afiliadoRepository->verificarEstado(
                    $request['numero_documento_cotizante'],
                    $request['tipo_documento_cotizante']
                );

                if (isset($cotizante->error)) {
                    throw new \Exception($cotizante->error);
                }
            }

            $this->validarParentescoAfiliado($request);
            $this->validarTipoDocumentoYEdad($request);

            if ($cotizante) {
                $this->validarTipoAfiliadoPorEdad($request, $cotizante);
                $this->validarTipoAfiliadoCotizante($request, $cotizante);
                $this->validarPadreBeneficiarioParaNieto($request, $cotizante);
                $this->validarGestante($request, $cotizante);
            }

            $clavesForaneas = [
                'tipo_documento',
                'tipo_documento_cotizante',
                'tipo_documento_padre_beneficiario',
            ];

            foreach ($clavesForaneas as $campo) {
                if (!empty($request[$campo]) && !TipoDocumento::find($request[$campo])) {
                    throw new \Exception("El valor del campo '{$campo}' con ID {$request[$campo]} no existe en la tabla tipo_documentos.");
                }
            }

            $email = ($request['tipo_documento'] == 5)
                ? 'CE' . $request['numero_documento'] . '@sumimedical.com'
                : $request['numero_documento'] . '@sumimedical.com';

            if (User::where('email', $email)->exists()) {
                throw new \Exception("El correo {$email} ya está registrado. Verifica si el afiliado ya fue creado previamente.");
            }

            try {
                $user = User::create([
                    'email' => $email,
                    'password' => bcrypt($request['numero_documento']),
                    'tipo_usuario_id' => 2,
                    'reps_id' => $request['ips_id'],
                    'activo' => true,
                ]);
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() === '23000') {
                    throw new \Exception("No se pudo crear el usuario porque el correo {$email} ya existe.");
                }

                throw new \Exception("Error al crear el usuario: " . $e->getMessage());
            }

            $archivos = [
                'ruta_adj_doc_cotizante',
                'ruta_adj_doc_beneficiario',
                'ruta_adj_solic_firmada',
                'ruta_adj_matrimonio',
                'ruta_adj_rc_nacimiento_beneficiario',
                'ruta_adj_rc_nacimiento_cotizante',
                'ruta_adj_cert_discapacidad_hijo'
            ];

            if ($request instanceof \Illuminate\Http\Request) {
                $requestArray = $request->all();

                $archivosSeleccionados = array_filter($request->only($archivos));
                $ruta = 'adjuntosAfiliados';

                $urls = [];
                $archivosFormateados = [];

                foreach ($archivosSeleccionados as $campo => $archivo) {
                    if ($archivo instanceof \Illuminate\Http\UploadedFile) {
                        $nombre = $archivo->getClientOriginalName();
                        $uuid = Str::uuid();
                        $nombreUnicoAdjunto = $uuid . '.' . $nombre;
                        $this->subirArchivoNombre($ruta, $archivo, $nombreUnicoAdjunto, 'server37');

                        $rutaArchivo = $ruta . '/' . $nombreUnicoAdjunto;

                        $urls[] = [
                            'campo' => $campo,
                            'url' => $rutaArchivo
                        ];

                        $archivosFormateados[] = [
                            'uuid' => (string) $uuid,
                            'nombre' => $nombre,
                            'campo' => $campo,
                        ];
                    }
                }

                foreach ($urls as $archivo) {
                    $requestArray[$archivo['campo']] = $archivo['url'];
                }
            } else {
                $requestArray = $request;
            }

            $afiliadoData = array_intersect_key($requestArray, array_flip([
                'tipo_documento',
                'fecha_vigencia_documento',
                'numero_documento',
                'primer_nombre',
                'segundo_nombre',
                'primer_apellido',
                'segundo_apellido',
                'entidad_id',
                'sexo',
                'fecha_nacimiento',
                'edad_cumplida',
                'ciclo_vida_atencion',
                'fecha_afiliacion',
                'tipo_afiliacion_id',
                'tipo_afiliado_id',
                'tipo_documento_cotizante',
                'numero_documento_cotizante',
                'fecha_defuncion',
                'parentesco',
                'tipo_documento_padre_beneficiario',
                'numero_documento_padre_beneficiario',
                'estado_afiliacion_id',
                'escalafon',
                'exento_pago',
                'grupo_sanguineo',
                'nivel_educativo',
                'cargo',
                'tipo_nombramiento',
                'nivel_ensenanza',
                'area_ensenanza_nombrado',
                'ocupacion',
                'estado_civil',
                'orientacion_sexual',
                'identidad_genero',
                'gestante',
                'semanas_gestacion',
                'fecha_posible_parto',
                'discapacidad',
                'grado_discapacidad',
                'grupo_poblacional',
                'victima_conflicto_armado',
                'pais_id',
                'departamento_id',
                'municipio_id',
                'dane_municipio',
                'departamento_atencion_id',
                'ips_id',
                'region',
                'municipio_atencion_id',
                'telefono',
                'celular1',
                'celular2',
                'correo1',
                'correo2',
                'direccion_residencia_via',
                'direccion_residencia_numero_exterior',
                'direccion_residencia_interior',
                'direccion_residencia_barrio',
                'direccion_residencia_numero_interior',
                'zona_vivienda',
                'mpio_residencia_id',
                'dpto_residencia_id',
                'departamento_afiliacion_id',
                'orden_judicial',
                'numero_folio',
                'fecha_folio',
                'proferido',
                'cuidad_orden_judicial',
                'municipio_afiliacion_id',
                'ruta_adj_doc_cotizante',
                'ruta_adj_doc_beneficiario',
                'ruta_adj_solic_firmada',
                'ruta_adj_matrimonio',
                'ruta_adj_rc_nacimiento_beneficiario',
                'ruta_adj_rc_nacimiento_cotizante',
                'ruta_adj_cert_discapacidad_hijo',
                'plan',
                'categoria',
            ]));

            $afiliadoData['user_id'] = $user->id;
            $afiliadoData['id_afiliado'] = 0;

            $afiliado = Afiliado::create($afiliadoData);

            $this->novedadRepository->crearNovedadAfiliado($afiliado->id, $request);

            return $afiliado;
        });
    }

    public function validarParentescoAfiliado($request)
    {
        $tipoAfiliado = (int) $request['tipo_afiliado_id'];
        $parentesco = strtolower(trim($request['parentesco'] ?? ''));
        $edad = (int) $request['edad_cumplida'];
        $discapacidad = strtolower(trim($request['discapacidad'] ?? 'sin discapacidad'));

        $tieneDiscapacidad = $discapacidad !== 'sin discapacidad';

        $condiciones = [
            $tipoAfiliado == 1 && $parentesco === 'hijo del docente' && $edad > 26 && !$tieneDiscapacidad,
            $tipoAfiliado == 6 && $parentesco === 'hijo del docente' && $edad > 25 && !$tieneDiscapacidad,
            $tipoAfiliado == 1 && $parentesco === 'menor en custodia' && $edad > 18 && !$tieneDiscapacidad,
            $tipoAfiliado == 1 && in_array($parentesco, ['conyuge', 'cónyuge']) && $edad < 18,
        ];

        if (in_array(true, $condiciones, true)) {
            throw new \Exception('El parentesco relacionado a la afiliación no cumple con las condiciones establecidas');
        }
    }

    public function validarTipoAfiliadoPorEdad($request, $cotizante)
    {
        $tipoAfiliado = (int) $request['tipo_afiliado_id'];
        $estadoCotizante = (int) $cotizante->estado_afiliacion_id;
        $tipoCotizante = (int) $cotizante->tipo_afiliado_id;

        $condiciones = [
            in_array($tipoCotizante, [3, 5]) && $estadoCotizante != 1,
            $tipoCotizante == 4 && $estadoCotizante != 31 && $tipoAfiliado != 6,
            $tipoCotizante != 4 && $tipoAfiliado == 6,
        ];

        if (in_array(true, $condiciones, true)) {
            throw new \Exception('El estado o tipo de afiliación del cotizante no es válido para la afiliación del beneficiario');
        }
    }

    public function validarTipoAfiliadoCotizante($request, Afiliado $cotizante)
    {
        $tipoAfiliadoBeneficiario = (int) $request['tipo_afiliado_id'];
        $estadoCotizante = (int) $cotizante->estado_afiliacion_id;
        $tipoCotizante = (int) $cotizante->tipo_afiliado_id;

        $esSustitutoPensional = $tipoAfiliadoBeneficiario == 6;

        $condiciones = [
            in_array($tipoCotizante, [2, 5]) && $estadoCotizante != 1,

            // Cotizante Fallecido (4) con estado diferente de Retirado (31) y el afiliado no es sustituto pensional (6)
            $tipoCotizante == 4 && $estadoCotizante != 31 && !$esSustitutoPensional,

            // Cotizante diferente a Fallecido (4) y el afiliado es sustituto pensional
            $tipoCotizante != 4 && $esSustitutoPensional,
        ];

        if (in_array(true, $condiciones, true)) {
            throw new \Exception('El estado o tipo de afiliación del cotizante no es válido para la afiliación del beneficiario');
        }
    }

    public function validarPadreBeneficiarioParaNieto($request)
    {
        $parentesco = strtolower(trim($request['parentesco'] ?? ''));

        if (!in_array($parentesco, ['nieto', 'nieto menor o igual a 60 días'])) {
            return;
        }

        $tipoDocPadre = $request['tipo_documento_padre_beneficiario'] ?? null;
        $numeroDocPadre = $request['numero_documento_padre_beneficiario'] ?? null;

        if (empty($tipoDocPadre) || empty($numeroDocPadre)) {
            throw new \Exception('El padre beneficiario relacionado no existe en la base de datos');
        }

        $padre = $this->afiliadoRepository->buscarAfiliadoActivoPorDocumento(
            $request['numero_documento_padre_beneficiario'],
            $request['tipo_documento_padre_beneficiario']
        );

        if (!$padre) {
            throw new \Exception('El padre beneficiario relacionado no existe en la base de datos');
        }

        $this->validarRelacionPadreBeneficiario($request, $padre);
    }

    public function validarRelacionPadreBeneficiario($request, $padre)
    {
        $parentescoActual = strtolower(trim($request['parentesco']));
        if (!in_array($parentescoActual, ['nieto', 'nieto menor o igual a 60 días'])) {
            return;
        }

        $parentescoPadre = strtolower(trim($padre->parentesco ?? ''));
        $discapacidad = strtolower(trim($padre->discapacidad ?? 'sin discapacidad'));

        $esHijoDocente = $parentescoPadre == 'Hijo del Docente';
        $esHijoDiscapacitado = $parentescoPadre == 'Hijo Discapacitado';

        $tieneDiscapacidad = $discapacidad != 'sin discapacidad';

        if (
            !$esHijoDocente &&
            !($esHijoDiscapacitado && $tieneDiscapacidad)
        ) {
            throw new \Exception('La relación del afiliado padre encontrado con el número de documento no es válida');
        }
    }

    public function validarGestante($request, $cotizante)
    {
        $gestante = strtolower(trim($request['gestante'] ?? 'No'));
        if ($gestante != 'Si') {
            return;
        }

        $estadoCotizante = (int) ($cotizante->estado_afiliacion_id ?? 0);
        $parentesco = strtolower(trim($request['parentesco'] ?? ''));

        $parentescoValido = in_array($parentesco, ['conyuge', 'cónyuge', 'compañero']);
        $estadoValido = !in_array($estadoCotizante, [31, 32]); // retirado o protección laboral

        if (!$parentescoValido || !$estadoValido) {
            throw new \Exception('El beneficiario no puede ser marcado como gestante si el cotizante no cumple con las condiciones requeridas');
        }
    }

    private function validarTipoDocumentoYEdad($request)
    {
        $tipoDocumento = (int) $request['tipo_documento'];
        $edad = (int) $request['edad_cumplida'];
        $tipoAfiliadoId = (int) $request['tipo_afiliado_id'];
        $esBeneficiario = ($tipoAfiliadoId === 1); // = Beneficiario
        $esCotizante = ($tipoAfiliadoId === 2); // = Cotizante
        $esSustituto = ($tipoAfiliadoId === 6); // = Sustituto pensional

        $mensajes = [];

        // Certificado de Nacido Vivo (ID 12)
        if ($tipoDocumento === 12 && (!$esBeneficiario || $edad > 0.25)) {
            $mensajes[] = "No se puede asignar Certificado de Nacido Vivo a un no beneficiario o a un beneficiario mayor de 3 meses.";
        }

        // Registro civil de nacimiento (ID 3)
        if ($tipoDocumento === 3 && (!$esBeneficiario || $edad > 8)) {
            $mensajes[] = "No se puede asignar Registro Civil a un no beneficiario o a un beneficiario mayor de 8 años.";
        }

        // Tarjeta de identidad (ID 2)
        if ($tipoDocumento === 2 && (
            !$esBeneficiario && !$esSustituto || $edad < 7 || $edad > 18
        )) {
            $mensajes[] = "Tarjeta de Identidad solo se puede asignar a beneficiarios o sustitutos entre 7 y 18 años.";
        }

        // Cédula de ciudadanía (ID 1)
        if ($tipoDocumento === 1 && ($esCotizante || $esBeneficiario) && $edad < 18) {
            $mensajes[] = "No se puede asignar Cédula de Ciudadanía a cotizantes o beneficiarios menores de 18 años.";
        }

        // Cédula de extranjería (ID 5)
        if ($tipoDocumento === 5 && ($esCotizante || $esBeneficiario) && ($edad < 7 || empty($request['es_extranjero_residente']))) {
            $mensajes[] = "Cédula de Extranjería requiere ser extranjero residente y tener mínimo 7 años si es cotizante o beneficiario.";
        }

        // Permiso especial de permanencia (ID 9)
        if ($tipoDocumento === 9 && $esBeneficiario && $edad < 18) {
            $mensajes[] = "Permiso Especial de Permanencia no puede asignarse a beneficiarios menores de 18 años.";
        }

        // Menor Sin Identificación (ID 13)
        if ($tipoDocumento === 13 && (!$esBeneficiario || $edad > 18)) {
            $mensajes[] = "Menor sin identificación solo aplica a beneficiarios menores de 18 años.";
        }

        if (!empty($mensajes)) {
            throw new \Exception(implode(' ', $mensajes));
        }
    }

    public function actualizarDireccionAfiliado($idAfiliado, $nuevaDireccion)
    {
        $afiliado = Afiliado::findOrFail($idAfiliado);

        $afiliado->update([
            'direccion_residencia_cargue' => $nuevaDireccion,
        ]);

        return $afiliado;
    }

    public function validarParentesco(string $parentesco, string $numeroDocumentoCotizante): void
    {
        $parentesco = $this->normalizarTexto($parentesco);

        switch (true) {
            case str_contains($parentesco, 'conyugue') || str_contains($parentesco, 'companero'):
                $conyuges = $this->cotizanteTieneConyuge($numeroDocumentoCotizante);
                if ($conyuges->isNotEmpty()) {
                    throw new \Exception('Este cotizante ya tiene un beneficiario con parentesco Conyugue o Compañero');
                }
                break;

            case str_contains($parentesco, 'padre') || str_contains($parentesco, 'madre'):
                $padres = $this->cotizanteTienePadres($numeroDocumentoCotizante);
                if ($padres->count() >= 2) {
                    throw new \Exception('Este cotizante ya tiene dos beneficiarios con parentesco Padre o Madre');
                }
                break;
        }
    }

    public function cotizanteTieneConyuge(string $numeroDocumento)
    {
        $afiliados = $this->afiliadoRepository->obtenerPosiblesConyuges($numeroDocumento);

        $conyuges = $afiliados->filter(function ($afiliado) {
            $parentesco = $this->afiliadoRepository->normalizarTexto($afiliado->parentesco ?? '');

            return str_contains($parentesco, 'conyugue') || str_contains($parentesco, 'companero');
        });

        return $conyuges->values();
    }

    public function cotizanteTienePadres(string $numeroDocumento)
    {
        $afiliados = Afiliado::select('id', 'parentesco')
            ->where('numero_documento_cotizante', trim((string) $numeroDocumento))
            ->where('tipo_afiliado_id', 1)
            ->get();

        $padres = $afiliados->filter(function ($afiliado) {
            $parentesco = $this->normalizarTexto($afiliado->parentesco ?? '');
            return str_contains($parentesco, 'padre') || str_contains($parentesco, 'madre');
        });

        return $padres->values();
    }

    private function normalizarTexto(string $texto): string
    {
        $texto = mb_strtolower($texto);
        $texto = str_replace(['á', 'é', 'í', 'ó', 'ú', 'ñ'], ['a', 'e', 'i', 'o', 'u', 'n'], $texto);
        return preg_replace('/\s+/', '', $texto);
    }

    public function adjuntosPorAfiliado(int $id)
    {
        $afiliado = Afiliado::where('id', $id)->first();
        $camposAdjuntos = [
            'ruta_adj_doc_cotizante',
            'ruta_adj_doc_beneficiario',
            'ruta_adj_solic_firmadas',
            'ruta_adj_matrimonio',
            'ruta_adj_rc_nacimiento_beneficiario',
            'ruta_adj_rc_nacimiento_cotizante',
            'ruta_adj_cert_discapacidad_hijo',
        ];

        $urls = [];

        foreach ($camposAdjuntos as $campo) {
            $ruta = $afiliado->$campo;
            if (!empty($ruta)) {
                $urls[$campo] = Storage::disk('digital')->temporaryUrl($ruta, now()->addMinutes(5));
            } else {
                $urls[$campo] = null;
            }
        }
        return $urls;
    }
}
