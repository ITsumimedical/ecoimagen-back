<?php

namespace App\Services;

namespace App\Http\Modules\Rips\Services;

use App\Http\Modules\Municipios\Models\Municipio;
use Exception;
use Symfony\Component\DomCrawler\Crawler;
use ZipArchive;
use App\Mail\EnviarZipRips;
use Illuminate\Support\Str;
use App\Traits\ArchivosTrait;
use Illuminate\Http\Response;
use App\Http\Services\ZipService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Rips\Ac\Models\Ac;
use App\Http\Modules\Rips\Af\Models\Af;
use App\Http\Modules\Rips\Ah\Models\Ah;
use App\Http\Modules\Rips\Am\Models\Am;
use App\Http\Modules\Rips\An\Models\An;
use App\Http\Modules\Rips\Ap\Models\Ap;
use App\Http\Modules\Rips\At\Models\At;
use App\Http\Modules\Rips\Au\Models\Au;
use App\Http\Modules\Rips\Ct\Models\Ct;
use Illuminate\Support\Facades\Storage;
use GuzzleHttp\Exception\RequestException;
use App\Http\Modules\Rips\Models\Adjuntorip;
use App\Http\Modules\Prestadores\Models\Prestador;
use App\Http\Modules\Rips\PaquetesRips\Models\PaqueteRip;
use Rap2hpoutre\FastExcel\SheetCollection;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\File;
use Error;

class RipService
{

    use ArchivosTrait;

    public function __construct(private ZipService $zipService) {}

    public function generarRips($data)
    {
        $data['region'] = $data['region'] ?? '';
        $data['user_id'] = Auth::id();
        if ($data['resolucion'] == '3374') {
            return $this->EjecutarProcedimientosParaRipsTxt3374($data);
        } else {
            return $this->EjecutarProcedimientosParaRipsJson($data);
        }
    }

    /**
     * Ejecutar Funciones para generar RIPS TXT
     *
     * @param $data
     * @return array
     * @author Calvarez
     */
    public function EjecutarProcedimientosParaRipsTxt3374($data)
    {
        $tipo = $data['tipo'] != 'CONSOLIDADO RIPS SUMIMEDICAL' ? $data['tipo'] : '';

        return [
            'ac' => DB::select('select * from fn_rips_ac_r3374 (?, ?, ?, ?, ?, ?)', [
                $data['fecha_inicio'],
                $data['fecha_fin'],
                intval($data['entidad']),
                strval($data['user_id']),
                strval($data['region']),
                $tipo //Se agrega param de tipo para filtrar por tipo de RIP (ODONTOLOGICO, ETC, LLEGA EN STRING)
            ]),
            'ap' => DB::select('select * from fn_rips_ap_r3374 (?, ?, ?, ?, ?, ?)', [
                $data['fecha_inicio'],
                $data['fecha_fin'],
                intval($data['entidad']),
                strval($data['user_id']),
                strval($data['region']),
                $tipo //Se agrega param de tipo para filtrar por tipo de RIP (ODONTOLOGICO, ETC, LLEGA EN STRING)
            ]),
            'am' => DB::select('select * from fn_rips_am_r3374 (?, ?, ?, ?, ?, ?)', [
                $data['fecha_inicio'],
                $data['fecha_fin'],
                intval($data['entidad']),
                strval($data['user_id']),
                strval($data['region']),
                $tipo //Se agrega param de tipo para filtrar por tipo de RIP (ODONTOLOGICO, ETC, LLEGA EN STRING)
            ]),
            'at' => DB::select('select * from fn_rips_at_r3374 (?, ?, ?, ?, ?, ?)', [
                $data['fecha_inicio'],
                $data['fecha_fin'],
                $data['entidad'],
                strval($data['user_id']),
                strval($data['region']),
                $tipo //Se agrega param de tipo para filtrar por tipo de RIP (ODONTOLOGICO, ETC, LLEGA EN STRING)
            ]),
            'us' => DB::select('select * from fn_rips_us_r3374 (?)', [strval($data['user_id'])]),
            'af' => DB::select('select * from fn_rips_af_r3374 (?, ?, ?, ?)', [
                $data['fecha_inicio'],
                $data['fecha_fin'],
                intval($data['entidad']),
                strval($data['user_id']),
            ]),
            'ct' => DB::select('select * from fn_rips_ct_r3374 (?, ?)', [
                $data['fecha_fin'],
                strval($data['user_id'])
            ]),
        ];
    }

    /**
     * Ejecutar Funciones para generar RIPS JSON
     *
     * @param $data
     * @return array
     * @author Calvarez
     */
    public function EjecutarProcedimientosParaRipsJson($data)
    {
        $fechaInicio = $data['fecha_inicio'] ?? '';
        $fechaFin = $data['fecha_fin'] ?? '';
        $region = $data['region'] ?? '';
        $entidad = intval($data['entidad'] ?? 0);
        $user_id = strval($data['user_id'] ?? '');
        $clasificacion = $data['tipo'] == 'CONSOLIDADO RIPS SUMIMEDICAL' ? '' : ($data['tipo'] ?? '');
        $sede = $data['codigo_habilitacion_reps'] ?? '';

        // Consulta RIPS por tipo de archivo
        $af = DB::select("SELECT * FROM fn_rips_af_r2275(?,?,?,?,?,?,?)", [
            $fechaInicio,
            $fechaFin,
            $entidad,
            $user_id,
            $region,
            $clasificacion,
            $sede
        ]);

        $us = DB::select("SELECT * FROM fn_rips_us_r2275(?)", [$user_id]);
        $ac = DB::select("SELECT * FROM fn_rips_ac_r2275(?)", [$user_id]);
        $ap = DB::select("SELECT * FROM fn_rips_ap_r2275(?)", [$user_id]);
        $am = DB::select("SELECT * FROM fn_rips_am_r2275(?)", [$user_id]);
        $au = DB::select("SELECT * FROM fn_rips_au_r2275()");
        $ah = DB::select("SELECT * FROM fn_rips_ah_r2275()");
        $at = DB::select("SELECT * FROM fn_rips_at_r2275(?)", [$user_id]);

        $factura = $af[0] ?? null;

        $json = [
            "numDocumentoIdObligado" => $factura->numDocumentoIdObligado ?? '',
            "numFactura" => $factura->num_factura ?? 'SUMI900033371',
            "tipoNota" => null,
            "numNota" => null,
            "usuarios" => []
        ];

        $serviciosPorUsuario = [];

        foreach (['ac' => $ac, 'am' => $am, 'ap' => $ap, 'au' => $au, 'ah' => $ah, 'at' => $at] as $tipo => $datos) {
            foreach ($datos as $item) {
                // Normalizar campo de consecutivo según la función (algunos traen mayúscula)
                $doc = $item->ConsecutivoUsuario ?? $item->ConsecutivoUsuario ?? null;
                if (!$doc)
                    continue;
                $doc = trim(strval($doc));

                // Inicializar servicios por tipo si no existen
                if (!isset($serviciosPorUsuario[$doc])) {
                    $serviciosPorUsuario[$doc] = [
                        'consultas' => [],
                        'medicamentos' => [],
                        'procedimientos' => [],
                        'urgencias' => [],
                        'hospitalizacion' => [],
                        'otrosServicios' => []
                    ];
                }
                unset($item->ConsecutivoUsuario);

                foreach ($item as $key => $value) {
                    if (is_string($value)) {
                        $item->$key = str_replace(["\r", "\n"], '', $value);
                    }
                }

                // clasificamos por tipo
                switch ($tipo) {
                    case 'ac':
                        $serviciosPorUsuario[$doc]['consultas'][] = $item;
                        break;
                    case 'am':
                        $serviciosPorUsuario[$doc]['medicamentos'][] = $item;
                        break;
                    case 'ap':
                        $serviciosPorUsuario[$doc]['procedimientos'][] = $item;
                        break;
                    case 'au':
                        $serviciosPorUsuario[$doc]['urgencias'][] = $item;
                        break;
                    case 'ah':
                        $serviciosPorUsuario[$doc]['hospitalizacion'][] = $item;
                        break;
                    case 'at':
                        $serviciosPorUsuario[$doc]['otrosServicios'][] = $item;
                        break;
                }
            }
        }

        foreach ($us as $usuario) {
            $doc = trim(strval($usuario->consecutivo));
            $cedulaAfiliado = $usuario->numDocumentoIdentificacion;

            $usuarioData = [
                "tipoDocumentoIdentificacion" => $usuario->tipoDocumentoIdentificacion,
                "numDocumentoIdentificacion" => $cedulaAfiliado,
                "tipoUsuario" => $usuario->tipoUsuario,
                "fechaNacimiento" => $usuario->fechaNacimiento,
                "codSexo" => $usuario->codSexo,
                "codPaisResidencia" => $usuario->codPaisResidencia,
                "codMunicipioResidencia" => $usuario->codMunicipioResidencia,
                "codZonaTerritorialResidencia" => $usuario->codZonaTerritorialResidencia,
                "incapacidad" => $usuario->incapacidad,
                "consecutivo" => $usuario->consecutivo,
                "codPaisOrigen" => $usuario->codPaisOrigen,
            ];

            $servicios = collect($serviciosPorUsuario[$doc] ?? [])
                ->filter(fn($items) => !empty($items))
                ->toArray();

            if (!empty($servicios)) {
                $usuarioData['servicios'] = $servicios;
            }

            $json['usuarios'][] = $usuarioData;
        }

        return $json;
    }


    public function generarContenidoArchivosTXT(array $resultados): array
    {
        $archivos = [];

        foreach ($resultados as $key => $rows) {
            $contenido = array_map(fn($row) => implode(',', (array) $row), $rows);
            $archivos[strtoupper($key) . '.txt'] = implode("\n", $contenido);
        }

        return $archivos;
    }

    public function guardarArchivosYGenerarURLs(array $archivos, array $data)
    {
        $temporal = storage_path('app/temp/rips');

        if (!is_dir($temporal)) {
            mkdir($temporal, 0755, true);
        }

        // Guardar archivos en la carpeta temporal
        foreach ($archivos as $nombreArchivo => $contenido) {
            file_put_contents("{$temporal}/{$nombreArchivo}", $contenido);
        }

        $archivosEnCarpeta = glob($temporal . '/*');
        if (empty($archivosEnCarpeta)) {
            throw new Exception('No hay archivos para comprimir en la carpeta', 400);
        }

        // Crear el ZIP
        $zipRuta = $this->zipService->crear($temporal, 'rips.zip');

        // Verificar que el ZIP se creó correctamente
        if (!file_exists($zipRuta)) {
            throw new Exception("No se pudo generar el archivo ZIP");
        }

        // Subir el ZIP a S3
        $ruta = 'ZipRipsOdontologia';
        $uuid = Str::uuid();
        $nombreUnicoAdjunto = $uuid . '.zip';

        Storage::disk('server37')->put($ruta . '/' . $nombreUnicoAdjunto, file_get_contents($zipRuta));

        // Generar URL temporal del archivo en S3
        $urlTemporal = Storage::disk('server37')->temporaryUrl($ruta . '/' . $nombreUnicoAdjunto, now()->addMinutes(5));

        // Enviar correo con la URL
        Mail::to($data['email'])->send(new EnviarZipRips($urlTemporal));

        unlink($zipRuta);

        foreach (glob($temporal . '/*') as $archivo) {
            unlink($archivo);
        }

        return [$urlTemporal];
    }


    function historicoRipsEntidad($historico)
    {
        $query = Adjuntorip::with('prestador:nombre_prestador,nit,codigo_habilitacion');
        if ($historico) {
            $query->where('created_by', Auth::id());
        }
        return $query->get();
    }

    /**
     * Funcion para validar el CUV y que coincidad el numero de factura
     *
     * @param  mixed $data
     * @return void
     */
    function validarCuv($cuv)
    {

        $cuvN = $cuv['CodigoUnicoValidacion']
            ?? $cuv['codigoUnicoValidacion']
            ?? throw new Exception('Estructura del código CUV no válido!');

        $url = 'https://validadorderipscolombia.com/consulta-codigo-unico-de-validacion-cuv?cuv=' . $cuvN;

        $response = Http::get($url);

        if ($response->failed()) {
            return null;
        }

        $html = $response->body();

        $crawler = new Crawler($html);

        $scripts = $crawler->filter('script')->each(function (Crawler $node) {
            return $node->text();
        });

        $cuvJsonString = null;

        foreach ($scripts as $scriptContent) {
            if (preg_match('/let cuv_json\s*=\s*(.+?);/s', $scriptContent, $matches)) {
                $cuvJsonString = $matches[1];
                break;
            }
        }

        if (!$cuvJsonString) {
            return null;
        }

        $cuvJsonString = rtrim(trim($cuvJsonString), ';');

        $cuvJsonString = html_entity_decode($cuvJsonString);
        $cuvJsonString = trim($cuvJsonString, "` \t\n\r\0\x0B");

        $data = json_decode($cuvJsonString, true);


        if (json_last_error() !== JSON_ERROR_NONE) {
            return null;
        }

        if (isset($data) && !empty($data['ResultadosValidacion'])) {
            $observaciones = $data['ResultadosValidacion'][0]['Observaciones'];
            return throw new Exception($observaciones);
        }

        return $data;
    }

    public function guardarArchivosJson($request)
    {
        try {
            $data = $this->leerArchivoJsonNormalizado($request['archivojson']);
            $dataCuv = $this->leerArchivoJsonNormalizado($request['archivocuv']);

            $numFacturaJson = $data['numFactura'] ?? $data['NumFactura'] ?? null;
            $numFacturaCuv = $dataCuv['numFactura'] ?? $dataCuv['NumFactura'] ?? null;

            if (trim($numFacturaCuv) !== trim($numFacturaJson)) {
                throw new \Exception("Los números de factura del CUV y del RIPS no son iguales", 400);
            }

            $numDocumentoId = $data['numDocumentoIdObligado'] ?? $data['NumDocumentoIdObligado'] ?? null;

            $sede = Rep::whereHas('prestadores', function ($query) use ($data, $numDocumentoId) {
                $query->where('nit', $numDocumentoId);
            })->first();

            if (is_null($sede)) {
                throw new Exception('No se encontró una sede asociada al prestador con NIT ' . $numDocumentoId, 422);
            }

            $prestador = $sede->prestador;

            // Validar el CUV
            $validarCuvSispro = $this->validarCuv($dataCuv);

            if (!$validarCuvSispro) {
                throw new Exception('No se ha podido generar el paquete de Rips ', 400);
            }

            $paqueteExistente = $this->buscarPaqueteExistente($sede->id, $numFacturaJson);

            if ($paqueteExistente && (int) $paqueteExistente->estado_id != 30) {
                throw new Exception('Ya se ha registrado un cargue de Paquete Rips', 400);
            }

            // Crear paquete con estado exitoso
            $paqueteRips = $this->crearPaqueteRips([
                'nombre' => $numFacturaJson,
                'nombre_rep' => $sede['nombre'],
                'codigo' => $sede['codigo'],
                'estado_id' => 13,
                'rep_id' => $sede->id,
                'entidad' => 3
            ]);
        } catch (\Throwable $th) {
            // Captura errores de validación de datos y conexiones
            throw new Exception($th->getMessage(), $th->getCode() ?: 400);
        }

        // Transacción para guardar datos
        try {
            DB::beginTransaction();

            $registros = $this->procesarDatosUsuario($data['usuarios'], $paqueteRips->id, $numFacturaJson);


            $this->guardarRegistros($registros);
            $this->guardarFacturas($registros['registroAF'], $numFacturaJson, $prestador, $paqueteRips->id, $validarCuvSispro);
            $this->guardarConteos($registros['registroCT'], $paqueteRips->id);
            $this->guardarArchivos($request, $paqueteRips->id, $numDocumentoId, $numFacturaJson);

            DB::commit();

            return $paqueteRips;
        } catch (\Exception $e) {
            DB::rollback();
            throw new Exception("No se procesaron los Rips con éxito: " . $e->getMessage(), 400);
        }
    }

    /**
     * Lectura de archivo JSON
     *
     * @param $archivo
     * @author Calvarez
     */
    private function leerArchivoJson($archivo)
    {
        $jsonContent = file_get_contents($archivo);
        return json_decode($jsonContent, true);
    }

    /**
     * Crear un nuevo paquete de RIPS
     *
     * @param $data
     * @author Calvarez
     */
    private function crearPaqueteRips(array $data)
    {
        $data['user_id'] = Auth::id();
        return PaqueteRip::create($data);
    }

    /**
     * Procesar los datos de los usuarios con cada uno de sus servicios
     *
     * @param  mixed $usuarios, $paqueteRipId, $numFactura
     * @author Calvarez
     */
    private function procesarDatosUsuario($usuarios, $paqueteRipId, $numFactura)
    {
        $acs = [];
        $aps = [];
        $ams = [];
        $ats = [];
        $aus = [];
        $ahs = [];
        $ans = [];
        $registroAF = [];
        $registroCT = [];
        $now = now();
        foreach ($usuarios as $usuario) {
            $servicios = $usuario['servicios'];
            $tipoDocumento = $usuario['tipoDocumentoIdentificacion'];
            $numeroDocumento = $usuario['numDocumentoIdentificacion'];
            if (isset($servicios['consultas'])) {

                foreach ($servicios['consultas'] as $consulta) {
                    $this->actualizarRegistros($registroAF, $registroCT, $consulta['codPrestador'], $consulta['vrServicio'], 'AC');
                    $acs[] = $this->crearAc($now, $consulta, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura);
                }
            }

            if (isset($servicios['procedimientos'])) {
                foreach ($servicios['procedimientos'] as $procedimiento) {
                    $this->actualizarRegistros($registroAF, $registroCT, $procedimiento['codPrestador'], $procedimiento['vrServicio'], 'AP');
                    $aps[] = $this->crearAp($now, $procedimiento, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura);
                }
            }

            if (isset($servicios['medicamentos'])) {
                foreach ($servicios['medicamentos'] as $medicamento) {
                    $this->actualizarRegistros($registroAF, $registroCT, $medicamento['codPrestador'], $medicamento['vrServicio'], 'AM');
                    $ams[] = $this->crearAm($now, $medicamento, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura);
                }
            }

            if (isset($servicios['otrosServicios'])) {
                foreach ($servicios['otrosServicios'] as $otroServicio) {
                    $this->actualizarRegistros($registroAF, $registroCT, $otroServicio['codPrestador'], $otroServicio['vrServicio'], 'AT');
                    $ats[] = $this->crearAt($now, $otroServicio, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura);
                }
            }

            if (isset($servicios['urgencias'])) {
                foreach ($servicios['urgencias'] as $urgencia) {
                    $this->actualizarRegistros($registroAF, $registroCT, $urgencia['codPrestador'], 0, 'AU');
                    $aus[] = $this->crearAu($now, $urgencia, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura);
                }
            }

            if (isset($servicios['hospitalizacion'])) {
                foreach ($servicios['hospitalizacion'] as $hospitalizacion) {
                    $this->actualizarRegistros($registroAF, $registroCT, $hospitalizacion['codPrestador'], 0, 'AH');
                    $ahs[] = $this->crearAh($now, $hospitalizacion, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura);
                }
            }

            if (isset($servicios['recienNacidos'])) {
                foreach ($servicios['recienNacidos'] as $recienNacido) {
                    $this->actualizarRegistros($registroAF, $registroCT, $recienNacido['codPrestador'], 0, 'AN');
                    $ans[] = $this->crearAn($now, $recienNacido, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura);
                }
            }
        }
        return [
            'acs' => $acs,
            'aps' => $aps,
            'ams' => $ams,
            'ats' => $ats,
            'aus' => $aus,
            'ahs' => $ahs,
            'ans' => $ans,
            'registroAF' => $registroAF,
            'registroCT' => $registroCT,
        ];
    }

    /**
     * Actualzar registros de la tabla AF y CT
     *
     * @param $registroAF, $registroCT, $codPrestador, $valorServicio, $tipoServicio
     * @author Calvarez
     */
    private function actualizarRegistros(&$registroAF, &$registroCT, $codPrestador, $valorServicio, $tipoServicio)
    {
        if (isset($registroAF[$codPrestador])) {
            $registroAF[$codPrestador] += $valorServicio;
        } else {
            $registroAF[$codPrestador] = $valorServicio;
        }

        if (isset($registroCT[$codPrestador][$tipoServicio])) {
            $registroCT[$codPrestador][$tipoServicio]++;
        } else {
            $registroCT[$codPrestador][$tipoServicio] = 1;
        }
    }

    /**
     * Recoleccion de datos para el registro de consultas
     *
     * @param $now, $consulta, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura
     * @author Calvarez
     */
    private function crearAc($now, $consulta, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura)
    {

        return [
            'codigo_prestador' => $consulta['codPrestador'],
            'fecha_consulta' => $consulta['fechaInicioAtencion'],
            'numero_autorizacion' => $consulta['numAutorizacion'],
            'consulta' => $consulta['codConsulta'],
            'finalidad_consulta' => $consulta['finalidadTecnologiaSalud'],
            'causa_externa' => $consulta['causaMotivoAtencion'],
            'diagnostico_principal' => $consulta['codDiagnosticoPrincipal'],
            'codigo_relacionado1' => $consulta['codDiagnosticoRelacionado1'],
            'codigo_relacionado2' => $consulta['codDiagnosticoRelacionado2'],
            'codigo_relacionado3' => $consulta['codDiagnosticoRelacionado3'],
            'tipo_diagnostico_principal' => $consulta['tipoDiagnosticoPrincipal'],
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento,
            'valor_neto_pagar' => $consulta['vrServicio'],
            'valor_consulta' => $consulta['vrServicio'],
            'valor_cuota_moderadora' => $consulta['valorPagoModerador'],
            'numero_factura' => $numFactura,
            'paquete_rip_id' => $paqueteRipId,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    /**
     * Recoleccion de datos para el registro de procedimientos
     *
     * @param  mixed $now, $procedimiento, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura
     * @author Calvarez
     */
    private function crearAp($now, $procedimiento, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura)
    {

        return [
            'codigo_prestador' => $procedimiento['codPrestador'],
            'fecha_procedimiento' => $procedimiento['fechaInicioAtencion'],
            'numero_autorizacion' => $procedimiento['numAutorizacion'],
            'procedimiento' => $procedimiento['codProcedimiento'],
            'finalidad_procedimiento' => $procedimiento['finalidadTecnologiaSalud'],
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento,
            'diagnostico_primario' => $procedimiento['codDiagnosticoPrincipal'],
            'diagnostico_relacionado' => $procedimiento['codDiagnosticoRelacionado'],
            'complicacion' => $procedimiento['codComplicacion'],
            'valor_procedimiento' => $procedimiento['vrServicio'],
            'ambito_procedimiento' => '',
            'personal_atiende' => '',
            'acto_quirurgico' => '',
            'numero_factura' => $numFactura,
            'paquete_rip_id' => $paqueteRipId,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    /**
     * Recoleccion de datos para el registro de medicamentos
     *
     * @param  mixed $now, $medicamento, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura
     * @author Calvarez
     */
    private function crearAm($now, $medicamento, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura)
    {
        return [
            'codigo_prestador' => $medicamento['codPrestador'],
            'numero_autorizacion' => $medicamento['numAutorizacion'],
            'tipo_medicamento' => $medicamento['tipoMedicamento'],
            'codigo_medicamento' => $medicamento['codTecnologiaSalud'],
            'nombre_generico' => $medicamento['nomTecnologiaSalud'],
            'concentracion_medicamento' => $medicamento['concentracionMedicamento'],
            'unidad_medida' => $medicamento['unidadMedida'],
            'forma_farmaceutica' => $medicamento['formaFarmaceutica'],
            'numero_unidades' => $medicamento['cantidadMedicamento'],
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento,
            'valor_unitario_medicamento' => $medicamento['vrUnitMedicamento'],
            'valor_total_medicamento' => $medicamento['vrServicio'],
            'numero_factura' => $numFactura,
            'paquete_rip_id' => $paqueteRipId,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    /**
     * Recoleccion de datos para el registro de otros servicios
     *
     * @param $now, $otroServicio, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura
     * @author Calvarez
     */
    private function crearAt($now, $otroServicio, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura)
    {

        return [
            'codigo_prestador' => $otroServicio['codPrestador'],
            'numero_autorizacion' => $otroServicio['numAutorizacion'],
            'tipo_servicio' => $otroServicio['tipoOS'],
            'codigo_servicio' => $otroServicio['codTecnologiaSalud'],
            'nombre_servicio' => $otroServicio['nomTecnologiaSalud'],
            'cantidad' => $otroServicio['cantidadOS'],
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento,
            'valor_unitario' => $otroServicio['vrUnitOS'],
            'valor_total' => $otroServicio['vrServicio'],
            'numero_factura' => $numFactura,
            'paquete_rip_id' => $paqueteRipId,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    /**
     * Recoleccion de datos para el registro de urgencias
     *
     * @param $now, $urgencia, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura
     * @author Calvarez
     */
    private function crearAu($now, $urgencia, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura)
    {
        return [
            'numero_autorizacion' => $numFactura,
            'codigo_prestado' => $urgencia['codPrestador'],
            'fecha_ingreso' => $urgencia['fechaInicioAtencion'],
            'causa_externa' => $urgencia['causaMotivoAtencion'],
            'diagnostico_salida' => $urgencia['codDiagnosticoPrincipalE'],
            'diagnostico_relacion_salida1' => $urgencia['codDiagnosticoRelacionadoE1'],
            'diagnostico_relacion_salida2' => $urgencia['codDiagnosticoRelacionadoE2'],
            'diagnostico_relacion_salida3' => $urgencia['codDiagnosticoRelacionadoE3'],
            'estado_salida' => $urgencia['condicionDestinoUsuarioEgreso'],
            'causa_basica_muerte' => $urgencia['codDiagnosticoCausaMuerte'],
            'fecha_salida_usuario' => $urgencia['fechaEgreso'],
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento,
            'numero_factura' => $numFactura,
            'paquete_rip_id' => $paqueteRipId,
            'hora_ingreso' => '00:00',
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    /**
     * Recoleccion de datos para el registro de hospitalizacion
     *
     * @param $now, $hospitalizacion, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura
     * @author Calvarez
     */
    private function crearAh($now, $hospitalizacion, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura)
    {
        return [
            'codigo_prestador' => $hospitalizacion['codPrestador'],
            'via_ingreso' => $hospitalizacion['viaIngresoServicioSalud'],
            'fecha_ingreso' => $hospitalizacion['fechaInicioAtencion'],
            'numero_autorizacion' => $hospitalizacion['numAutorizacion'],
            'causa_externa' => $hospitalizacion['causaMotivoAtencion'],
            'diagnostico_principal_ingreso' => $hospitalizacion['codDiagnosticoPrincipal'],
            'diagnostico_principal_egreso' => $hospitalizacion['codDiagnosticoPrincipalE'],
            'diagnaostico_relacionado_1' => $hospitalizacion['codDiagnosticoRelacionadoE1'],
            'diagnaostico_relacionado_2' => $hospitalizacion['codDiagnosticoRelacionadoE2'],
            'diagnaostico_relacionado_3' => $hospitalizacion['codDiagnosticoRelacionadoE3'],
            'diagnostico_complicacion' => $hospitalizacion['codComplicacion'],
            'estado_salida' => $hospitalizacion['condicionDestinoUsuarioEgreso'],
            'diagnostico_causa_muerte' => $hospitalizacion['codDiagnosticoCausaMuerte'],
            'fecha_egreso' => $hospitalizacion['fechaEgreso'],
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento,
            'numero_factura' => $numFactura,
            'paquete_rip_id' => $paqueteRipId,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    /**
     * Recoleccion de datos para el registro de recien nacidos
     *
     * @param $now, $recienNacido, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura
     * @author Calvarez
     */
    private function crearAn($now, $recienNacido, $tipoDocumento, $numeroDocumento, $paqueteRipId, $numFactura)
    {
        return [
            'codigo_prestador' => $recienNacido['codPrestador'],
            'tipo_documento' => $tipoDocumento,
            'numero_documento' => $numeroDocumento,
            'fecha_nacimiento' => $recienNacido['fechaNacimiento'],
            'edad_gestional' => $recienNacido['edadGestacional'],
            'sexo' => $recienNacido['codSexoBiologico'],
            'peso' => $recienNacido['peso'],
            'diagnostico_recien_nacido' => $recienNacido['codDiagnosticoPrincipal'],
            'causa_muerte' => $recienNacido['codDiagnosticoCausaMuerte'],
            'fecha_muerte' => $recienNacido['fecha_muerte'],
            'gestion_prenatal' => $recienNacido['numConsultasCPrenatal'],
            'numero_factura' => $$numFactura,
            'paquete_rip_id' => $paqueteRipId,
            'created_at' => $now,
            'updated_at' => $now,
        ];
    }

    /**
     * Guardar registros en las tablas AC, AP, AM, AT, AU, AH y AN
     *
     * @param $registros
     * @author Calvarez
     */
    private function guardarRegistros($registros)
    {
        set_time_limit(-1);

        try {
            DB::beginTransaction();

            // se crean los chuncks
            $acsDividido = array_chunk($registros['acs'], 100);
            $apsDividido = array_chunk($registros['aps'], 100);
            $amsDividido = array_chunk($registros['ams'], 100);
            $atsDividido = array_chunk($registros['ats'], 100);
            $ausDividido = array_chunk($registros['aus'], 100);
            $ahsDividido = array_chunk($registros['ahs'], 100);
            $ansDividido = array_chunk($registros['ans'], 100);

            foreach ($acsDividido as $loteAcs) {
                Ac::insert($loteAcs);
            }

            foreach ($apsDividido as $loteAps) {
                Ap::insert($loteAps);
            }

            foreach ($amsDividido as $loteAms) {
                Am::insert($loteAms);
            }

            foreach ($atsDividido as $loteAts) {
                At::insert($loteAts);
            }

            foreach ($ausDividido as $loteAus) {
                Au::insert($loteAus);
            }

            foreach ($ahsDividido as $loteAcs) {
                Ah::insert($loteAcs);
            }

            foreach ($ansDividido as $loteAns) {
                An::insert($loteAns);
            }


            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();

            throw new Exception($th->getMessage(), 500);
        }
    }

    /**
     * Guardar facturas en la tabla AF
     *
     * @param $registroAF,$numeroFactura,$prestador,$paqueteRipId
     * @author Calvarez
     */
    private function guardarFacturas($registroAF, $numeroFactura, $prestador, $paqueteRipId, $validarCuvSispro)
    {

        $prestador->load('municipio');
        $nombre = $this->obtenerCodigoMunicipio(($prestador->municipio->nombre));
        $facturas = [];
        foreach ($registroAF as $codPrestador => $valorNeto) {
            $facturas[] = [
                'tipo_identificacion' => 'NI',
                'numero_identificacion' => $prestador->nit,
                'numero_factura' => $numeroFactura,
                'fechaexpedicion_factura' => now(),
                'fecha_inicio' => now(),
                'fecha_final' => now(),
                'nombre_admin' => $prestador->nombre_prestador,
                'valor_neto' => $validarCuvSispro['TotalFactura'],
                'codigo_prestador' => $codPrestador,
                'paquete_rip_id' => $paqueteRipId,
                'created_at' => now(),
                'updated_at' => now(),
                'codigo_entidad' => $nombre,
                'user_id' => Auth::id(),
            ];
        }
        Af::insert($facturas);
    }

    /**
     * Asigna codigo municipio para contrato magdalena
     * @param mixed $municipio
     * @autor Samir C
     */
    private function obtenerCodigoMunicipio($municipio)
    {
        $mapa = [

            'BARRANQUILLA' => 'EAS027-1',
            'BOSCONIA' => 'EAS027-1',
            'CHIRIGUANA' => 'EAS027-1',
            'CIENAGA' => 'EAS027-1',
            'PUERTO COLOMBIA' => 'EAS027-1',
            'SABANALARGA' => 'EAS027-1',
            'SANTA MARTA' => 'EAS027-1',
            'VALLEDUPAR' => 'EAS027-1'

        ];
        return $mapa[$municipio] ?? 'EAS027';
    }

    /**
     * Guardar conteos en la tabla CT
     *
     * @param $registroCT, $paqueteRipId
     * @author Calvarez
     */
    private function guardarConteos($registroCT, $paqueteRipId)
    {
        $conteos = [];
        foreach ($registroCT as $codPrestador => $conteosServicios) {
            foreach ($conteosServicios as $nombreArchivo => $cantidadRegistros) {
                $conteos[] = [
                    'fecha_radicado' => now(),
                    'codigo_prestador' => $codPrestador,
                    'nombre_archivo' => $nombreArchivo,
                    'catidad_registros' => $cantidadRegistros,
                    'paquete_rip_id' => $paqueteRipId,
                ];
            }
        }
        Ct::insert($conteos);
    }

    /**
     * Guardar los adjuntos en el S3 digital
     *
     * @param $request,$paqueteRipId,$codigoPrestador,$numeroFactura
     * @author Calvarez
     */
    private function guardarArchivos($request, $paqueteRipId, $codigoPrestador, $numeroFactura)
    {
        $path = '/rips/sumimedical/' . $paqueteRipId;

        $xmlPath = Storage::disk('server37')->putFileAs($path, $request['archivoxml']->getRealPath(), $request['archivoxml']->getClientOriginalName());
        $cuvPath = Storage::disk('server37')->putFileAs($path, $request['archivocuv']->getRealPath(), $request['archivocuv']->getClientOriginalName());
        $jsonPath = Storage::disk('server37')->putFileAs($path, $request['archivojson']->getRealPath(), $request['archivojson']->getClientOriginalName());
        // dd($request['soporte']);
        if ($request['soporte']) {
            $files = $request['soporte'];
            foreach ($files as $file) {
                $adjuntoSoporte = Storage::disk('server37')->putFileAs($path, $file->getRealPath(), preg_replace('/\s+/', '', $file->getClientOriginalName()));
            }
        }

        Adjuntorip::create([
            'url_json' => $jsonPath,
            'url_xml' => $xmlPath,
            'url_cuv' => $cuvPath,
            'url_adjunto' => $path,
            'created_by' => Auth::id(),
            'codigo_prestador' => $codigoPrestador,
            'numero_factura' => $numeroFactura,
            'paquete_rip_id' => $paqueteRipId,
        ]);
    }


    public function excelJson($request)
    {
        $arrFinal = [];
        $archivos = [
            'AC' => 'consultas',
            'AP' => 'procedimientos',
            'AM' => 'medicamentos',
            'AT' => 'otrosServicios',
            'AU' => 'urgencias',
            'AH' => 'hospitalizacion',
            'AN' => 'recienNacidos'
        ];


        $inputFileType = 'Xlsx';
        $inputFileName = $request["archivo"];

        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $worksheetData = $reader->listWorksheetInfo($inputFileName);

        $reader->setLoadSheetsOnly('AF');
        $spreadsheet = $reader->load($inputFileName);
        $worksheet = $spreadsheet->getActiveSheet();
        $af = $worksheet->toArray();
        $arrFinal = [
            $af[0][0] => $af[1][0],
            $af[0][1] => $af[1][1],
            $af[0][2] => strtoupper($af[1][2]) === "NULL" ? null : $af[1][2],
            $af[0][3] => strtoupper($af[1][3]) === "NULL" ? null : $af[1][3],
            'usuarios' => []
        ];
        $reader->setLoadSheetsOnly('US');
        $spreadsheet = $reader->load($inputFileName);
        $worksheet = $spreadsheet->getActiveSheet();
        $us = $worksheet->toArray();
        $usCabeceras = $us[0];
        unset($us[0]);
        foreach ($us as $usuarios) {
            $arrUs = [];
            for ($i = 0; $i < count($usCabeceras); $i++) {
                $arrUs[$usCabeceras[$i]] = $usuarios[$i];
            }
            $arrUs['servicios'] = [];
            $arrFinal['usuarios'][] = $arrUs;
        }

        foreach ($worksheetData as $worksheet) {
            if (strtoupper($worksheet['worksheetName']) !== 'US' && strtoupper($worksheet['worksheetName']) !== 'AF') {
                $sheetName = $worksheet['worksheetName'];
                $reader->setLoadSheetsOnly($sheetName);
                $spreadsheet = $reader->load($inputFileName);
                $worksheet = $spreadsheet->getActiveSheet();
                $registros = $worksheet->toArray();
                $cabeceras = $registros[0];
                // $exclusion = array_search('consecutivousuario', $cabeceras);
                // if ($exclusion !== false) {
                //     unset($cabeceras[$exclusion]);
                // }
                unset($registros[0]);
                foreach ($registros as $registro) {
                    $arrRegistro = [];
                    for ($i = 0; $i < count($cabeceras); $i++) {
                        $arrRegistro[$cabeceras[$i]] = $registro[$i];
                    }

                    if (count($arrRegistro) > 0) {
                        $keyUsuario = array_search($arrRegistro['consecutivousuario'], array_column($arrFinal['usuarios'], 'consecutivo'));
                        if ($keyUsuario !== false) {
                            unset($arrRegistro['consecutivousuario']);
                            $arrFinal['usuarios'][$keyUsuario]['servicios'][$archivos[strtoupper($sheetName)]][] = $arrRegistro;
                        }
                    }
                }
            }
        }

        return $arrFinal;
    }

    public function jsonExcel($request)
    {
        $json = file_get_contents($request["archivo"]);
        $json_data = json_decode($json, true);

        $arrFinal = [
            'af' => [],
            'us' => [],
            'ac' => [],
            'at' => [],
            'an' => [],
            'ap' => [],
            'am' => [],
            'au' => [],
            'ah' => []
        ];
        foreach ($json_data as $keyTransaccion => $valorTransaccion) {
            if ($keyTransaccion !== 'usuarios') {
                $arrFinal['af'][0][$keyTransaccion] = $valorTransaccion;
            }
            if ($keyTransaccion === 'usuarios') {
                foreach ($valorTransaccion as $usuario) {
                    $us = $usuario;
                    $servicios = $usuario['servicios'];
                    unset($us['servicios']);
                    $arrFinal['us'][] = $us;
                    if (isset($servicios['consultas'])) {
                        $arrFinal['ac'] = array_merge($arrFinal['ac'], $this->formatearArray($servicios['consultas'], $usuario['consecutivo']));
                    }
                    if (isset($servicios['otrosServicios'])) {
                        $arrFinal['at'] = array_merge($arrFinal['at'], $this->formatearArray($servicios['otrosServicios'], $usuario['consecutivo']));
                    }
                    if (isset($servicios['recienNacidos'])) {
                        $arrFinal['an'] = array_merge($arrFinal['an'], $this->formatearArray($servicios['recienNacidos'], $usuario['consecutivo']));
                    }
                    if (isset($servicios['procedimientos'])) {
                        $arrFinal['ap'] = array_merge($arrFinal['ap'], $this->formatearArray($servicios['procedimientos'], $usuario['consecutivo']));
                    }
                    if (isset($servicios['medicamentos'])) {
                        $arrFinal['am'] = array_merge($arrFinal['am'], $this->formatearArray($servicios['medicamentos'], $usuario['consecutivo']));
                    }
                    if (isset($servicios['urgencias'])) {
                        $arrFinal['au'] = array_merge($arrFinal['au'], $this->formatearArray($servicios['urgencias'], $usuario['consecutivo']));
                    }
                    if (isset($servicios['hospitalizacion'])) {
                        $arrFinal['ah'] = array_merge($arrFinal['ah'], $this->formatearArray($servicios['hospitalizacion'], $usuario['consecutivo']));
                    }
                }
            }
        }
        $hojas = [];
        if (count($arrFinal['af']) > 0)
            $hojas['AF'] = $arrFinal['af'];
        if (count($arrFinal['ac']) > 0)
            $hojas['AC'] = $arrFinal['ac'];
        if (count($arrFinal['at']) > 0)
            $hojas['AT'] = $arrFinal['at'];
        if (count($arrFinal['an']) > 0)
            $hojas['AN'] = $arrFinal['an'];
        if (count($arrFinal['ap']) > 0)
            $hojas['AP'] = $arrFinal['ap'];
        if (count($arrFinal['am']) > 0)
            $hojas['AM'] = $arrFinal['am'];
        if (count($arrFinal['au']) > 0)
            $hojas['AU'] = $arrFinal['au'];
        if (count($arrFinal['ah']) > 0)
            $hojas['AH'] = $arrFinal['ah'];
        if (count($arrFinal['us']) > 0)
            $hojas['US'] = $arrFinal['us'];
        $sheets = new SheetCollection($hojas);
        return $sheets;
    }

    public function formatearArray($arrayJson, $id)
    {
        $array = array_map(function ($data) use ($id) {
            $format = $data;
            $format['consecutivousuario'] = $id;
            return $format;
        }, $arrayJson);
        return $array;
    }

    public function ripsJsonHorus1()
    {
        set_time_limit(0);
        $rutaJson = '/rips/json';
        $rutaXml = '/rips/xml';
        $rutaCuv = '/rips/cuv';
        $rutaDestinoBase = '/rips/completos';
        $disk = Storage::disk('server37');

        $archivos = $disk->files($rutaJson);
        $contador = 1;

        foreach ($archivos as $archivo) {
            $nombreArchivo = basename($archivo);
            $partes = explode('_', $nombreArchivo);
            if (empty($partes[0])) {
                continue;
            }

            $nombreBase = $partes[0];

            // Buscar archivos que tengan el mismo nombre base para armar la carpeta completados
            $jsonPath = "$rutaJson/{$nombreBase}_...";
            $xmlPath = collect($disk->files($rutaXml))->first(fn($f) => str_starts_with(basename($f), $nombreBase));
            $cuvPath = collect($disk->files($rutaCuv))->first(fn($f) => str_starts_with(basename($f), $nombreBase));
            $jsonMatch = collect($disk->files($rutaJson))->first(fn($f) => str_starts_with(basename($f), $nombreBase));

            if ($xmlPath && $cuvPath && $jsonMatch) {
                $carpetaDestino = "$rutaDestinoBase/" . str_pad($contador, 4, '0', STR_PAD_LEFT);
                $disk->makeDirectory($carpetaDestino);

                // Copiar archivos al directorio de destino
                $disk->copy($jsonMatch, "$carpetaDestino/" . basename($jsonMatch));
                $disk->copy($xmlPath, "$carpetaDestino/" . basename($xmlPath));
                $disk->copy($cuvPath, "$carpetaDestino/" . basename($cuvPath));

                $contador++;
            }
        }

        return "Proceso completado. Se crearon $contador carpetas.";
    }

    /**
     * envia rips json en zip al correo diligenciado
     * @param $ripsGenerados
     * @param $correo
     * @author Jose vasquez
     */
    public function enviarRipsJson2275($ripsGenerados, $correo)
    {
        $nombreArchivo = 'ripsJson2275';

        $rutaCarpeta = storage_path('app/public/ripsJson');

        $rutaArchivo = $rutaCarpeta . "/$nombreArchivo.json";
        $rutaZip = $rutaCarpeta . "/$nombreArchivo.zip";

        if (!File::exists($rutaCarpeta)) {
            File::makeDirectory($rutaCarpeta, 0755, true);
        }

        File::put($rutaArchivo, json_encode($ripsGenerados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        $zip = new ZipArchive();
        if ($zip->open($rutaZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) === true) {
            $zip->addFile($rutaArchivo, "$nombreArchivo.json");
            $zip->close();
        }

        $rutaS3 = "ripsJson/$nombreArchivo.zip";

        Storage::disk('server37')->put($rutaS3, file_get_contents($rutaZip));

        $url = Storage::disk('server37')->temporaryUrl($rutaS3, now()->addHours(24));

        Mail::to($correo)->send(new EnviarZipRips($url));

        $ubicacionCarpeta = storage_path('app/public/rips');

        if (File::exists($ubicacionCarpeta)) {
            File::deleteDirectory($ubicacionCarpeta);
        }
    }
    public function getRadicados(array $datos)
    {
        $fechaDesde = $datos['fecha_desde'];
        $fechaHasta = $datos['fecha_hasta'];
        $prestadorId = $datos['prestador_id'] ?? null;

        $usuario = auth()->user();
        $permiso = $usuario->hasPermissionTo('rips.pendientes.todos');

        $query = PaqueteRip::select([
            'paquete_rips.id',
            'paquete_rips.nombre',
            'paquete_rips.motivo',
            's.nombre as sede',
            'paquete_rips.estado_id',
            'paquete_rips.parcial',
            'p.nit',
            's.codigo_habilitacion',
            'paquete_rips.created_at',
            'paquete_rips.updated_at',
            'adj.url_json',
            'adj.url_xml',
            'adj.url_cuv',
            'adj.url_adjunto',
            DB::raw('SUM(a.valor_neto::numeric) as valor')
        ])
            ->with(['afs'])
            ->join('reps as s', 's.id', '=', 'paquete_rips.rep_id')
            ->join('prestadores as p', 'p.id', '=', 's.prestador_id')
            ->join('afs as a', 'a.paquete_rip_id', '=', 'paquete_rips.id')
            ->leftjoin('adjuntorips as adj', 'adj.paquete_rip_id', '=', 'paquete_rips.id')
            ->whereNotNull('paquete_rips.estado_id')
            ->where('paquete_rips.created_at', '>=', $fechaDesde . " 00:00:00.000")
            ->where('paquete_rips.created_at', '<=', $fechaHasta . " 23:59:00.000")
            ->groupBy(
                'paquete_rips.id',
                'paquete_rips.nombre',
                'paquete_rips.motivo',
                's.nombre',
                'paquete_rips.estado_id',
                'paquete_rips.parcial',
                'p.nit',
                's.codigo_habilitacion',
                'paquete_rips.created_at',
                'paquete_rips.updated_at',
                'adj.url_json',
                'adj.url_xml',
                'adj.url_cuv',
                'adj.url_adjunto'
            );


        if ($prestadorId) {
            $query->where('s.prestador_id', $prestadorId);
        }

        if (!$permiso) {
            $query->where('paquete_rips.user_id', auth()->user()->id);
        }

        return $query->get();
    }

    public function buscarPaqueteExistente($rep, $numFactura)
    {
        return PaqueteRip::where('rep_id', $rep)->where('nombre', $numFactura)->first();
    }

    public function generarRIPSJanier()
    {
        set_time_limit(0);
        $rutasJson = Adjuntorip::select('url_json')->whereBetween('created_at', ['2025-07-01 00:00:00', '2025-07-31 00:00:00'])->get();
        $disk = Storage::disk('server37'); // disco S3 o configurado

        foreach ($rutasJson as $ruta) {
            $rutaArchivo = $ruta->url_json; // nombre o ruta relativa del archivo en S3

            // Si tu ruta en url_json no incluye el prefijo /rips/sumimedical/ y necesitas agregarlo:
            // $rutaArchivoCompleta = $rutaOrigen . $rutaArchivo;
            // sino directamente:
            $rutaArchivoCompleta = $rutaArchivo;

            // Verificamos que el archivo exista en el disco
            if ($disk->exists($rutaArchivoCompleta)) {
                // Leemos el contenido del archivo JSON
                $contenidoJson = $disk->get($rutaArchivoCompleta);

                // Decodificamos el JSON
                $datos = json_decode($contenidoJson, true);
                $llaveActualizar = $datos['numFactura'];
                try {
                    $ac = Ac::where('numero_factura', $llaveActualizar)->firstOrFail();

                    $ac->update([
                        'codservicio' => $datos['usuarios'][0]['servicios']['consultas'][0]['codServicio'],
                        'conceptorecaudo' => $datos['usuarios'][0]['servicios']['consultas'][0]['conceptoRecaudo'],
                        'consecutivo' => $datos['usuarios'][0]['servicios']['consultas'][0]['codServicio'],
                        'gruposervicios' => $datos['usuarios'][0]['servicios']['consultas'][0]['grupoServicios'],
                        'modalidadgruposerviciotecsal' => $datos['usuarios'][0]['servicios']['consultas'][0]['modalidadGrupoServicioTecSal'],
                        'numfevpagomoderador' => $datos['usuarios'][0]['servicios']['consultas'][0]['numFEVPagoModerador'],
                        'valorpagomoderador' => $datos['usuarios'][0]['servicios']['consultas'][0]['valorPagoModerador'],
                        'tipo_documento_afiliado' => $datos['usuarios'][0]['tipoDocumentoIdentificacion'],
                        'numero_documento_afiliado' => $datos['usuarios'][0]['numDocumentoIdentificacion'],
                    ]);
                } catch (\Throwable $th) {
                    var_dump("No existe la factura $llaveActualizar en AC");
                }
                try {
                    $ap = Ap::where('numero_factura', $llaveActualizar)->firstOrFail();
                    $ap->update([
                        'codservicio' => $datos['usuarios'][0]['servicios']['procedimientos'][0]['codServicio'],
                        'conceptorecaudo' => $datos['usuarios'][0]['servicios']['procedimientos'][0]['conceptoRecaudo'],
                        'consecutivo' => $datos['usuarios'][0]['servicios']['procedimientos'][0]['consecutivo'],
                        'gruposervicios' => $datos['usuarios'][0]['servicios']['procedimientos'][0]['grupoServicios'],
                        'modalidadgruposerviciotecsal' => $datos['usuarios'][0]['servicios']['procedimientos'][0]['modalidadGrupoServicioTecSal'],
                        'numfevpagomoderador' => $datos['usuarios'][0]['servicios']['procedimientos'][0]['numFEVPagoModerador'],
                        'valorpagomoderador' => $datos['usuarios'][0]['servicios']['procedimientos'][0]['valorPagoModerador'],
                        'tipo_documento_afiliado' => $datos['usuarios'][0]['tipoDocumentoIdentificacion'],
                        'numero_documento_afiliado' => $datos['usuarios'][0]['numDocumentoIdentificacion'],
                    ]);
                } catch (\Throwable $th) {
                }
                try {
                    $am = Am::where('numero_factura', $llaveActualizar)->firstOrFail();
                    $am->update([
                        'coddiagnosticoprincipal' => $datos['usuarios'][0]['servicios']['medicamentos'][0]['codDiagnosticoPrincipal'],
                        'coddiagnosticorelacionado' => $datos['usuarios'][0]['servicios']['medicamentos'][0]['codDiagnosticoRelacionado'],
                        'consecutivo' => $datos['usuarios'][0]['servicios']['medicamentos'][0]['consecutivo'],
                        'conceptorecaudo' => $datos['usuarios'][0]['servicios']['medicamentos'][0]['conceptoRecaudo'],
                        'diastratamiento' => $datos['usuarios'][0]['servicios']['medicamentos'][0]['diasTratamiento'],
                        'idmipres' => $datos['usuarios'][0]['servicios']['medicamentos'][0]['idMIPRES'],
                        'numfevpagomoderador' => $datos['usuarios'][0]['servicios']['medicamentos'][0]['numFEVPagoModerador'],
                        'unidadmindispensa' => $datos['usuarios'][0]['servicios']['medicamentos'][0]['unidadMinDispensa'],
                        'valorpagomoderador' => $datos['usuarios'][0]['servicios']['medicamentos'][0]['valorPagoModerador'],
                        'tipo_documento_afiliado' => $datos['usuarios'][0]['tipoDocumentoIdentificacion'],
                        'numero_documento_afiliado' => $datos['usuarios'][0]['numDocumentoIdentificacion'],
                    ]);
                } catch (\Throwable $th) {
                    //throw $th;
                }
                try {
                    $at = At::where('numero_factura', $llaveActualizar)->firstOrFail();
                    $at->update([
                        'conceptorecaudo' => $datos['usuarios'][0]['servicios']['otrosServicios'][0]['conceptoRecaudo'],
                        'consecutivo' => $datos['usuarios'][0]['servicios']['otrosServicios'][0]['consecutivo'],
                        'fechasuministrotecnologia' => $datos['usuarios'][0]['servicios']['otrosServicios'][0]['fechaSuministroTecnologia'],
                        'idmipres' => $datos['usuarios'][0]['servicios']['otrosServicios'][0]['idMIPRES'],
                        'numfevpagomoderador' => $datos['usuarios'][0]['servicios']['otrosServicios'][0]['numFEVPagoModerador'],
                        'valorpagomoderador' => $datos['usuarios'][0]['servicios']['otrosServicios'][0]['valorPagoModerador'],
                        'tipo_documento_afiliado' => $datos['usuarios'][0]['tipoDocumentoIdentificacion'],
                        'numero_documento_afiliado' => $datos['usuarios'][0]['numDocumentoIdentificacion'],
                    ]);
                } catch (\Throwable $th) {
                    //throw $th;
                }
                try {
                    $ah = Ah::where('numero_factura', $llaveActualizar)->firstOrFail();
                    $ah->update([
                        'coddiagnosticoprincipal' => $datos['usuarios'][0]['servicios']['hospitalizacion'][0]['codDiagnosticoPrincipal'],
                        'consecutivo' => $datos['usuarios'][0]['servicios']['hospitalizacion'][0]['consecutivo'],
                        'tipo_documento_afiliado' => $datos['usuarios'][0]['tipoDocumentoIdentificacion'],
                        'numero_documento_afiliado' => $datos['usuarios'][0]['numDocumentoIdentificacion'],
                    ]);
                } catch (\Throwable $th) {
                    //throw $th;
                }
                try {
                    $an = An::where('numero_factura', $llaveActualizar)->firstOrFail();
                    $an->update([
                        'condiciondestinousuarioegreso' => $datos['usuarios'][0]['servicios']['recienNacidos'][0]['codDiagnosticoPrincipal'],
                        'consecutivo' => $datos['usuarios'][0]['servicios']['recienNacidos'][0]['consecutivo'],
                        'fechaegreso' => $datos['usuarios'][0]['servicios']['recienNacidos'][0]['fechaEgreso'],
                        'tipo_documento_afiliado' => $datos['usuarios'][0]['tipoDocumentoIdentificacion'],
                        'numero_documento_afiliado' => $datos['usuarios'][0]['numDocumentoIdentificacion'],
                    ]);
                } catch (\Throwable $th) {
                    //throw $th;
                }
                try {
                    $au = Au::where('numero_factura', $llaveActualizar)->firstOrFail();
                    $au->update([
                        'coddiagnosticoprincipal' => $datos['usuarios'][0]['servicios']['urgencias'][0]['codDiagnosticoPrincipal'],
                        'consecutivo' => $datos['usuarios'][0]['servicios']['urgencias'][0]['consecutivo'],
                        'tipo_documento_afiliado' => $datos['usuarios'][0]['tipoDocumentoIdentificacion'],
                        'numero_documento_afiliado' => $datos['usuarios'][0]['numDocumentoIdentificacion'],
                    ]);
                } catch (\Throwable $th) {
                    //throw $th;
                }
            } else {
                // Opcional: manejar el caso donde no existe el archivo
                echo "Archivo no encontrado: " . $rutaArchivoCompleta . "\n";
            }
        }

        // return "Proceso completado. Se crearon $contador carpetas.";
    }

    private function leerArchivoJsonNormalizado(string $path): array
    {
        $content = file_get_contents($path);

        $content = preg_replace('/^b"""/', '', $content);
        $content = preg_replace('/"""$/', '', $content);
        $content = trim($content);

        if (!mb_detect_encoding($content, 'UTF-8', true)) {
            $content = mb_convert_encoding($content, 'UTF-8', 'ISO-8859-1');
        }

        $content = preg_replace('/[\x00-\x1F\x80-\xFF]/', '', $content);

        $data = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new \RuntimeException("JSON inválido: " . json_last_error_msg());
        }

        return $data;
    }

    /**
     * Proceso para actualizar el valor en la tabla AF ya que se debe tomar de la validacion CUV-SISPRO
     *
     * @return void
     */
    public function actualizarValorAF()
    {
        $consultaCuv = Adjuntorip::select('adjuntorips.url_cuv', 'adjuntorips.paquete_rip_id')
            ->join('afs', 'afs.paquete_rip_id', 'adjuntorips.paquete_rip_id')
            ->where('afs.valor_neto', 0)
            ->whereNotNull('adjuntorips.url_cuv')
            ->get();

        $conexion = Storage::disk('server37');
        $contadorTotal = 0;
        $errores = []; // Guardar errores para revisarlos después

        foreach ($consultaCuv as $cuv) {
            try {
                $rutaArchivo = $cuv->url_cuv;

                if ($conexion->exists($rutaArchivo)) {
                    $contenidoJson = $conexion->get($rutaArchivo);
                    $array = json_decode($contenidoJson, true);

                    $validarCuvSispro = $this->validarCuv($array);
                    $totalFactura = $validarCuvSispro['TotalFactura'] ?? null;

                    if ($totalFactura) {
                        $filas = Af::where('paquete_rip_id', $cuv->paquete_rip_id)
                            ->update(['valor_neto' => $totalFactura]);

                        $contadorTotal += $filas;
                    }
                } else {
                    // Guardar cuando no existe archivo
                    $errores[] = "Archivo no encontrado: {$rutaArchivo}";
                }
            } catch (\Throwable $e) {
                // Guardar error pero continuar con las siguientes iteraciones
                $errores[] = "Error en paquete_rip_id {$cuv->paquete_rip_id}: " . $e->getMessage();
                continue;
            }
        }

        // Puedes devolver tanto el total como los errores
        return [
            'actualizados' => $contadorTotal,
            'errores'      => $errores
        ];
    }
}
