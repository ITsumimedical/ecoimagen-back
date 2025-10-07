<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Rap2hpoutre\FastExcel\SheetCollection;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;
use Throwable;
use ZipArchive;

class ConversorRips implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $email;
    private $tipo;
    private $rutaArchivo;
    private $archivo;
    private $idUnico;
    /**
     * Create a new job instance.
     */
    public function __construct($email, $tipo, $rutaArchivo)
    {
        $this->idUnico = date('YmdHis');
        $this->email = $email;
        $this->tipo = $tipo;
        $this->rutaArchivo = $rutaArchivo;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {

        $r3=  Storage::disk('server37')->temporaryUrl(
            'conversor',
            now()->addMinutes(5)
        );

        // $r2 = Storage::disk('local')->get(storage_path('app').'/'.'20250527115254.xlsx');
        // $r = Storage::disk('server37')->put('conversor/archivo.xlsx', Storage::disk('local')->get(storage_path('app').'/'.'20250527115254.xlsx'));
        dd($r3);

        $datos = [];
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', '-1');
        switch (intval($this->tipo)) {
            case 1:
                $datos =$this->excelJson();
                break;
            case 2:
                $datos = $this->jsonExcel();
                break;
        }
        // $this->enviarCorreo($datos);
    }

    private function jsonExcel()
    {
        $json = file_get_contents($this->rutaArchivo);
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
        if (count($arrFinal['af']) > 0) $hojas['AF'] = $arrFinal['af'];
        if (count($arrFinal['ac']) > 0) $hojas['AC'] = $arrFinal['ac'];
        if (count($arrFinal['at']) > 0) $hojas['AT'] = $arrFinal['at'];
        if (count($arrFinal['an']) > 0) $hojas['AN'] = $arrFinal['an'];
        if (count($arrFinal['ap']) > 0) $hojas['AP'] = $arrFinal['ap'];
        if (count($arrFinal['am']) > 0) $hojas['AM'] = $arrFinal['am'];
        if (count($arrFinal['au']) > 0) $hojas['AU'] = $arrFinal['au'];
        if (count($arrFinal['ah']) > 0) $hojas['AH'] = $arrFinal['ah'];
        if (count($arrFinal['us']) > 0) $hojas['US'] = $arrFinal['us'];
        $sheets = new SheetCollection($hojas);
        (new FastExcel($sheets))->export(storage_path('app') . '/' . $this->idUnico . '.xlsx');
        return ['tipo' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', 'nombre' => $this->idUnico . '.xlsx', 'ruta' => storage_path('app'), 'extension' => 'xlsx'];
    }

    private function excelJson()
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
        $inputFileName = $this->rutaArchivo;

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

        // return $arrFinal;
        Storage::disk('local')->put($this->idUnico . '.json', json_encode($arrFinal));
        return ['tipo' => 'application/json', 'nombre' => $this->idUnico . '.json', 'ruta' => storage_path('app'), 'extension' => 'json'];
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

    private function enviarCorreo($datos)
    {
        Mail::send('enviar_archivo_conversor', ['email' => 'julicarto@hotmail.com'], function ($message) use ($datos) {
            $message->to(['julicarto@hotmail.com']);
            $message->subject('hola');
            $message->attach($datos['ruta'] . '/' . $datos['nombre'], [
                'mime' => $datos['tipo'],
                'as' => 'ArchivGenerado' . $datos['extension']
            ]);
        });
    }

    /**
     * Handle a job failure.
     *
     * @param \Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception) {}
}
