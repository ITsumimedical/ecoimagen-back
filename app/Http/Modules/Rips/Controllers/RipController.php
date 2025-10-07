<?php

namespace App\Http\Modules\Rips\Controllers;

use Illuminate\Http\Request;
use App\Events\EstadoRips;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Modules\LogRegistroRipsSumi\Services\LogRegistroRipsSumiService;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Rips\Configuracion\Models\Configuracione;
use App\Http\Modules\Rips\Models\Adjuntorip;
use App\Jobs\ValidacionEstructuraRips;
use App\Http\Modules\Rips\Models\RipErrore;
use App\Http\Modules\Rips\Models\IntentosCargueRip;
use App\Http\Modules\Rips\PaquetesRips\Models\PaqueteRip;
use App\Http\Modules\Rips\Repositories\PaqueteRipRepository;
use App\Http\Modules\Rips\Request\GenerarRipsRequest;
use App\Http\Modules\Rips\Request\GuardarRipsJsonRequest;
use App\Http\Modules\Rips\Services\RipService;
use App\Jobs\ConversorRips;
use App\Jobs\GenerarRipsJob;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\Calculation\Statistical\Distributions\F;
use Illuminate\Http\JsonResponse;


class RipController extends Controller
{
    private $errorMessages = [];
    private $CT = [];
    private $US = [];
    private $AF = [];
    private $AC = [];
    private $AP = [];
    private $AM = [];
    private $AT = [];
    private $AU = [];
    private $AH = [];
    private $AN = [];
    private $item = [];

    private function setCT($CT)
    {
        $this->CT = $CT;
    }

    private function setUS($US)
    {
        $this->US = $US;
    }

    private function setAF($AF)
    {
        $this->AF = $AF;
    }

    private function setAC($AC)
    {
        $this->AC = $AC;
    }

    private function setAP($AP)
    {
        $this->AP = $AP;
    }

    private function setAM($AM)
    {
        $this->AM = $AM;
    }

    private function setAT($AT)
    {
        $this->AT = $AT;
    }

    private function setAU($AU)
    {
        $this->AU = $AU;
    }

    private function setAH($AH)
    {
        $this->AH = $AH;
    }

    private function setAN($AN)
    {
        $this->AN = $AN;
    }

    public function __construct(private RipService $ripService, protected PaqueteRipRepository $paqueteRipRepository, protected LogRegistroRipsSumiService $logRegistroRipsSumiService) {}

    public function autorizacionPeriodoRips()
    {
        $day = intval(date('d'));
        $settings = Configuracione::find(1);
        $enable = true;
        // if (!$settings->excepcion_habilitacion_validador_rips) {
        //     if ($day >= $settings->dia_inicio_habilitacion_validador_rips && $day <= $settings->dia_final_habilitacion_validador_rips) {
        //         $enable = true;
        //     }
        // } else {
        //     $enable = true;
        // }

        $result = [
            'enabled' => $enable,
            // 'ini_day' => $settings->dia_inicio_habilitacion_validador_rips,
            // 'fin_day' => $settings->dia_final_habilitacion_validador_rips
        ];
        return $result;
    }

    public function validar(Request $request)
    {
        try {
            set_time_limit(-1);
            $this->fillFileNames($request);
            $this->checkRequiredFiles();

            if (count($this->errorMessages) > 0) {
                return response()->json([
                    'errors' => $this->errorMessages,
                ], 400);
            }

            $entidad = $request->entidad;
            $paqueteRip = new PaqueteRip();
            $sedePrestador = Rep::where('codigo', $this->CT['content'][0][0])->firstOrFail();

            $paqueteRechazado = PaqueteRip::where("nombre", substr($this->CT['fileName'], 2))
                ->where('rep_id', $sedePrestador->id)
                ->where('mes', date('m'))
                ->where('anio', date('Y'))
                ->whereIn('estado_id', [25, 27])
                ->first();

            if ($paqueteRechazado) {
                $paqueteRechazado->user_id = auth()->user()->id;
                $paqueteRechazado->entidad = $entidad;
                $paqueteRechazado->save();

                $paqueteRip = $paqueteRechazado;

                RipErrore::where('paquete_rip_id', $paqueteRip->id)->delete();
                $path = storage_path("app/public/temporalesrips/" . $paqueteRip->id);
                if (file_exists($path)) {
                    foreach (scandir($path) as $file) {
                        if ($file !== '.' && $file !== '..') {
                            unlink($path . '/' . $file);
                        }
                    }
                }
            } else {
                $paqueteRip->nombre = substr($this->CT['fileName'], 2);
                $paqueteRip->nombre_rep = $sedePrestador->nombre;
                $paqueteRip->codigo = $sedePrestador->codigo;
                $paqueteRip->ac_size = $this->AC['size'] ?? null;
                $paqueteRip->af_size = $this->AF['size'] ?? null;
                $paqueteRip->ah_size = $this->AH['size'] ?? null;
                $paqueteRip->am_size = $this->AM['size'] ?? null;
                $paqueteRip->ap_size = $this->AP['size'] ?? null;
                $paqueteRip->at_size = $this->AT['size'] ?? null;
                $paqueteRip->au_size = $this->AU['size'] ?? null;
                $paqueteRip->ct_size = $this->CT['size'] ?? null;
                $paqueteRip->us_size = $this->US['size'] ?? null;
                $paqueteRip->entidad = $entidad;
                $paqueteRip->mes = date('m');
                $paqueteRip->anio = date('Y');
                $paqueteRip->rep_id = $sedePrestador->id;
                $paqueteRip->estado_id = 24;
                $paqueteRip->user_id = auth()->user()->id;
                $paqueteRip->save();

                $path = '/rips/sumimedical/' . $paqueteRip->id;
                if ($request->hasFile('soporte')){
                    $files = $request->file('soporte');
                    foreach ($files as $file) {
                        Storage::disk('server37')->putFileAs(
                            $path,
                            $file->getRealPath(),
                            preg_replace('/\s+/', '', $file->getClientOriginalName())
                        );
                    }
                }


                PaqueteRip::where('id', $paqueteRip->id)
                    ->update(['url_adjunto_rips_txt' => $path]);
            }

            IntentosCargueRip::create([
                'nombre_paquete' => substr($this->CT['fileName'], 2),
                'codigo' => $sedePrestador->codigo,
                'user_id' => auth()->user()->id
            ]);

            if ($request->hasFile('files')) {
                $files = $request->file('files');
                foreach ($files as $file) {
                    $file_name = $file->getClientOriginalName();
                    $path = storage_path('app/public/temporalesrips/' . $paqueteRip->id);
                    if (!file_exists($path)) {
                        mkdir($path, 0777, true);
                    }
                    $file->move($path, $file_name);
                    chmod($path, 0777);
                }
            }

            broadcast(new EstadoRips());
            ValidacionEstructuraRips::dispatch($paqueteRip->id)->onQueue('validacionestructurarips');

            return response()->json(['message' => 'Validando ...']);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Ocurrió un error al procesar la solicitud.',
                'detalle' => $e->getMessage()
            ], 500);
        }
    }

    private function fillFileNames($data)
    {
        $currentFile = [];
        foreach ($data["files"] as $file) {
            list($fileName, $ext) = explode('.', $file->getClientOriginalName());
            $open_file = fopen($file, 'r');
            if (filesize($file) > 0) {
                $content = fread($open_file, filesize($file));
                $content;
                $rows = preg_split('/\r\n/', $content);
                $i = 0;
                $cols = [];
                $newCols = [];
                foreach ($rows as $row) {
                    if ($row) {
                        $cols = explode(',', $row);
                        $j = 0;
                        foreach ($cols as $col) {
                            $newCols[$j] = utf8_encode(trim($col));
                            $j++;
                        }
                        $this->item[$fileName][$i] = $newCols;
                        $i++;
                    }
                    $currentFile['content'] = $this->item[$fileName];
                    $currentFile['fileName'] = $fileName;
                    $currentFile['size'] = $file->getSize();
                    $currentFile['success'] = [];
                    if (preg_match('/CT/i', $fileName)) $this->setCT($currentFile);
                    if (preg_match('/US/i', $fileName)) $this->setUS($currentFile);
                    if (preg_match('/AF/i', $fileName)) $this->setAF($currentFile);
                    if (preg_match('/AC/i', $fileName)) $this->setAC($currentFile);
                    if (preg_match('/AP/i', $fileName)) $this->setAP($currentFile);
                    if (preg_match('/AM/i', $fileName)) $this->setAM($currentFile);
                    if (preg_match('/AT/i', $fileName)) $this->setAT($currentFile);
                    if (preg_match('/AU/i', $fileName)) $this->setAU($currentFile);
                    if (preg_match('/AH/i', $fileName)) $this->setAH($currentFile);
                    if (preg_match('/AN/i', $fileName)) $this->setAN($currentFile);
                }
            } else {
                $msg = 'Archivo ' . $fileName . ' invalido';
                $this->pushErrorMessage($msg);
            }
        }
    }

    private function checkRequiredFiles()
    {
        $configuraciones = $this->autorizacionPeriodoRips();
        if (!$configuraciones['enabled']) {
            $msg = 'La radicación solo es funcional en los dias ' . $configuraciones['ini_day'] . ' al ' . $configuraciones['fin_day'] . ' de cada mes.';
            $this->pushErrorMessage($msg);
        }
        if (count($this->item) < 3) {
            $msg = 'Para la validación RIPS se deben cargar minimo 3 archivos';
            $this->pushErrorMessage($msg);
        }
        if (!isset($this->AF['content'])) {
            $msg = 'El archivo AF es requerido. (Error A)';
            $this->pushErrorMessage($msg);
        }
        if (isset($this->AC['content']) && !isset($this->CT['content'])) {
            $msg = 'No se tiene el número archivos mínimos para hacer el cargue, si carga el AC debe tener CT. (Error A17)';
            $this->pushErrorMessage($msg);
        }

        if (isset($this->AP['content']) && !isset($this->CT['content'])) {
            $msg = 'No se tiene el número archivos mínimos para hacer el cargue, si carga el AP debe existir un archivo CT. (Error A18)';
            $this->pushErrorMessage($msg);
        }

        if (isset($this->AM['content']) && !isset($this->CT['content'])) {
            $msg = 'No se tiene el número archivos mínimos para hacer el cargue, si carga el AM debe existir un archivo CT. (Error A19)';
            $this->pushErrorMessage($msg);
        }

        if (isset($this->AU['content']) && (!isset($this->CT['content']) || !isset($this->AC['content']) || !isset($this->AT['content']))) {
            $msg = 'No se tiene el número archivos mínimos para hacer el cargue, si carga el AU debe existir archivo CT, AC, AT. (Error A20)';
            $this->pushErrorMessage($msg);
        }

        if (isset($this->AH['content']) && (!isset($this->CT['content'])  || !isset($this->AT['content']))) {
            $msg = 'No se tiene el número archivos mínimos para hacer el cargue, si carga el AH debe existir archivo CT, AT. (Error A21)';
            $this->pushErrorMessage($msg);
        }

        if (isset($this->AN['content']) && !isset($this->CT['content'])) {
            $msg = 'No se tiene el número archivos mínimos para hacer el cargue, si carga el AN debe existir archivo CT. (Error A22)';
            $this->pushErrorMessage($msg);
        }

        if (isset($this->CT['content'])) {
            if (strlen($this->CT['fileName']) != 8) {
                $this->pushErrorMessage('El nombre del archivo CT no cumple especificaciones para el nombre del archivo.');
            }
        }

        if (isset($this->US['content'])) {
            if (strlen($this->US['fileName']) != 8) {
                $this->pushErrorMessage('El nombre del archivo US no cumple especificaciones para el nombre del archivo.');
            }
        }

        if (isset($this->AC['content'])) {
            if (strlen($this->AC['fileName']) != 8) {
                $this->pushErrorMessage('El nombre del archivo AC no cumple especificaciones para el nombre del archivo.');
            }
        }

        if (isset($this->AP['content'])) {
            if (strlen($this->AP['fileName']) != 8) {
                $this->pushErrorMessage('El nombre del archivo AP no cumple especificaciones para el nombre del archivo.');
            }
        }

        if (isset($this->AM['content'])) {
            if (strlen($this->AM['fileName']) != 8) {
                $this->pushErrorMessage('El nombre del archivo AM no cumple especificaciones para el nombre del archivo.');
            }
        }

        if (isset($this->AT['content'])) {
            if (strlen($this->AT['fileName']) != 8) {
                $this->pushErrorMessage('El nombre del archivo AT no cumple especificaciones para el nombre del archivo.');
            }
        }

        if (isset($this->AU['content'])) {
            if (strlen($this->AU['fileName']) != 8) {
                $this->pushErrorMessage('El nombre del archivo AU no cumple especificaciones para el nombre del archivo.');
            }
        }

        if (isset($this->AH['content'])) {
            if (strlen($this->AH['fileName']) != 8) {
                $this->pushErrorMessage('El nombre del archivo AH no cumple especificaciones para el nombre del archivo.');
            }
        }

        if (isset($this->AN['content'])) {
            if (strlen($this->AN['fileName']) != 8) {
                $this->pushErrorMessage('El nombre del archivo AN no cumple especificaciones para el nombre del archivo.');
            }
        }

        $reps = Rep::where('codigo', $this->CT['content'][0][0])->first();
        if ($reps) {
            $cargueReps = PaqueteRip::where('rep_id', $reps->id)->whereIn('estado_id', [24, 26, 25, 27, 28])->first();
            if ($cargueReps) {
                if ($cargueReps->nombre != substr($this->CT['fileName'], 2)) {
                    $this->pushErrorMessage('El prestador tiene un cargue pendiente por definir.');
                }
            }

            $packages = PaqueteRip::where('nombre', substr($this->CT['fileName'], 2))
                ->where('rep_id', $reps->id)
                ->where('mes', date('m'))
                ->where('anio', date('Y'))
                ->whereIn('estado_id', [14, 13])
                ->first();
            if ($packages) {
                $this->pushErrorMessage('El codigo del paquete "' . substr($this->CT['fileName'], 2) . '" ya esta radicado con el mismo prestador.');
            }

            $paqueteProceso = PaqueteRip::where("nombre", substr($this->CT['fileName'], 2))
                ->where('rep_id', $reps->id)
                ->where('mes', date('m'))
                ->where('anio', date('Y'))
                ->whereIn('estado_id', [24, 26])
                ->first();
            if ($paqueteProceso) {
                $this->pushErrorMessage('El codigo del paquete "' . substr($this->CT['fileName'], 2) . '" esta en un proceso de validacion');
            }

            $paqueteError = PaqueteRip::where("nombre", substr($this->CT['fileName'], 2))
                ->where('rep_id', $reps->id)
                ->where('mes', date('m'))
                ->where('anio', date('Y'))
                ->where('estado_id', 28)
                ->first();
            if ($paqueteError) {
                $this->pushErrorMessage('El sistema encontro un error inesperado en la validación, comuníquese con el area de desarrollo para su solucion');
            }
        } else {
            $this->pushErrorMessage('El prestador del Archivo CT no registra en la base de datos.');
        }
    }

    private function pushErrorMessage($msg)
    {
        $this->errorMessages[] = ['linea' => '', 'tipo_archivo' => '', 'mensaje' => $msg];
    }

    public function enProcesoValidacion()
    {
        return response()->json(
            PaqueteRip::where('user_id', auth()->user()->id)
                ->whereIn('estado_id', [24, 25, 26, 27, 28])->get()
        );
    }

    public function descargarErrores($id)
    {
        $errores = collect(RipErrore::select(
            'archivo',
            'mensaje',
            'lineas'
        )
            ->where('paquete_rip_id', $id)
            ->get()->toArray());
        return (new FastExcel($errores))->download('file.xls');
    }

    /**
     * obtener radicados de los prestadores
     * busca por params del front
     * @param Request $request
     * @return JsonResponse
     * @author Jose vasquez
     */
    public function getRadicados(Request $request): JsonResponse
    {
        try {
            $radicados = $this->ripService->getRadicados($request->all());
            return response()->json($radicados, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json([
                $th->getMessage(),
                'mensaje' => 'Ha ocurrido un error al obtener los radicados'
            ],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    public function aceptarRips(Request $request)
    {
        PaqueteRip::where('id', $request->id)
            ->update(['estado_id' => 14]);
        return response()->json(['message' => 'RIPS aceptado con exito']);
    }

    public function rechazarRips(Request $request)
    {
        PaqueteRip::where('id', $request->id)
            ->update(['estado_id' => 30, 'motivo' => $request->motivo]);
        return response()->json(['message' => 'RIPS rechazado con exito']);
    }

    public function reporteRips(Request $request)
    {
        $appointments = Collect(DB::select("exec dbo.RIPS ?,?,?", [$request->startDate, $request->finishDate, $request->financiero]));
        $array = json_decode($appointments, true);
        return (new FastExcel($array))->download('file.xls');
    }

    public function ripsHorus(Request $request)
    {
        $appointments = Collect(DB::select("exec dbo.RipsHorus ?,?,?", [$request->archivo12, $request->startDate1, $request->finishDate1]));
        $array = json_decode($appointments, true);
        return (new FastExcel($array))->download('file.xls');
    }

    public function consolidadoRips(Request $request)
    {
        set_time_limit(300);
        ini_set('max_execution_time', 300);
        ini_set('memory_limit', '-1');
        if ($request->archivos1 === 'CT') {
            $archivos = ['AF', 'AT', 'AC', 'AP', 'AU', 'AN', 'AM', 'AH', 'US'];
            $txt = "";
            foreach ($archivos as $archivo) {
                $consulta = json_decode(Collect(DB::select("exec dbo.Consolidado ?,?,?,?", [$archivo, $request->fechainicio . ' 00:00:00.000', $request->fechafin . ' 23:59:00.000', $request->consolidado])), true);
                $reps = array_unique(array_column($consulta, 'prestador'));
                if (count($consulta) > 0) {
                    $txt .= implode("|", $reps) . "," . date("d/m/Y", strtotime($request->fechainicio)) . "," . $archivo . date("mY", strtotime($request->fechainicio)) . "," . count($consulta) . "\r" . PHP_EOL;
                }
            }
            return Response()->make($txt);
        }

        $appointments = Collect(DB::select("exec dbo.Consolidado ?,?,?,?", [$request->archivos1, $request->fechainicio, $request->fechafin, $request->consolidado]));
        $array = json_decode($appointments, true);
        return (new FastExcel($array))->download('file.xls');
    }




    public function eliminarProcesoValidacion(PaqueteRip $paqRip)
    {
        try {

            $path = storage_path("app/public/temporalesrips/" . $paqRip->id);
            if (file_exists($path)) {
                foreach (scandir($path) as $file) {
                    if ($file !== '.' && $file !== '..') {
                        unlink($path . '/' . $file);
                    }
                }
                rmdir($path);
            }
            RipErrore::where('paquete_rip_id', $paqRip->id)->delete();
            $paqRip->delete();
            return response()->json(["message" => "Registro eliminado con exito"]);
        } catch (\Exception $e) {
            return response()->json(["message" => "Ocurrio un error al eliminar el registro, por favor comuniquese con soporte para su corrección"], 500);
        }
    }

    public function exportErrors(Request $request)
    {
        $appointments = collect($request->all());
        $array = json_decode($appointments, true);
        return (new FastExcel($array))->download('file.xls');
    }

    public function pendienteRips(Request $request)
    {
        PaqueteRip::where('id', $request->id)
            ->update(['estado_id' => 13, 'motivo' => null]);
        return response()->json(['message' => 'RIPS en pendiente']);
    }

    public function generarRips(GenerarRipsRequest $request)
    {
        try {

            GenerarRipsJob::dispatch($request->validated());

            return response()->json(['message' => 'RIPS generados correctamente.'], Response::HTTP_OK);
        } catch (\Exception $e) {
            $logGenerado = [
                'codigo_http_respuesta' => 500,
                'mensaje_http_respuesta' => $e->getMessage(),
                'user_id' => $request['user_id'],
                'payload' => json_encode($request->all())
            ];
            $this->logRegistroRipsSumiService->crear($logGenerado);
            return response()->json(['message' => 'Error al generar los RIPS.', 'error' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function descargarArchivo($nombre)
    {
        $zipRuta = storage_path('app/tmp/' . $nombre);

        // Asegurar que la carpeta de destino existe
        if (!file_exists(dirname($zipRuta))) {
            mkdir(dirname($zipRuta), 0755, true);
        }

        if (!file_exists($zipRuta)) {
            return response()->json(['message' => 'Archivo no encontrado.'], 404);
        }

        return response()->download($zipRuta)->deleteFileAfterSend(true);
    }

    public function guardarArchivosJson(GuardarRipsJsonRequest $request)
    {
        try {
            $ripsJson = $this->ripService->guardarArchivosJson($request->validated());
            return response()->json($ripsJson, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al guardar los RIPS.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function historicoRipsEntidad($historico = null)
    {
        try {
            $historico = $this->ripService->historicoRipsEntidad($historico);
            return response()->json($historico, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => 'Error al obtener el historial de RIPS.',
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    function consultarNombreSoporte(Request $request)
    {
        try {
            $adjuntoId = $request->input('adjuntoId');
            $numeroFactura = $request->input('numeroFactura');
            $ruta = $request->input('ruta');
            $soporte = $this->paqueteRipRepository->consultarNombreSoporte($adjuntoId, $numeroFactura, $ruta);
            return response()->json($soporte, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar el soporte.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function conversor($tipo, Request $request)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        try {
            switch (intval($tipo)) {
                case 1:
                    $resultado = $this->ripService->excelJson($request->all());
                    return response()->json($resultado);
                case 2:
                    $resultado = $this->ripService->jsonExcel($request->all());
                    return (new FastExcel($resultado))->download('file.xls');
            }
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar el soporte.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function ripsJsonHorus1(Request $request)
    {
        try {
            $resultado = $this->ripService->ripsJsonHorus1($request->all());
            return response()->json($resultado);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar el soporte.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function descargarSoportesJson(Request $request)
    {
        try {
            $adjuntoId = $request->input('adjuntoId');
            $nombreArchivo = $request->input('nombreArchivo');
            $ruta = $request->input('ruta');
            $soporte = $this->paqueteRipRepository->descargarSoportesJson($adjuntoId, $nombreArchivo, $ruta);
            return response()->json($soporte, 200);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al consultar el soporte.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function generarRIPSJanier(Request $request) {
        try {
            $resultado = $this->ripService->generarRIPSJanier($request->all());
            return response()->json($resultado);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al generar RIPS Janier.',
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
