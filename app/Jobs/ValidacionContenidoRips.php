<?php

namespace App\Jobs;

use Throwable;
use Illuminate\Bus\Queueable;
use App\Events\EstadoRips;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\Cums\Models\Cum;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Departamentos\Models\Departamento;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\Prestadores\Models\Prestador;
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
use Illuminate\Support\Facades\File;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Http\Modules\Rips\Models\RipErrore;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use App\Http\Modules\Rips\PaquetesRips\Models\PaqueteRip;
use App\Http\Modules\Rips\Us\Models\Us;

class ValidacionContenidoRips implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $id;
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
    private $prestador = null;
    private $redPaciente;
    private $codigoPaciente = "";
    private $errorMessages = [];
    private $waningMessages = [];
    private $fechaDesde;
    private $fechaHasta;

    private function setFechaDesde($desde)
    {
        $this->fechaDesde = $desde;
    }

    private function setFechaHasta($hasta)
    {
        $this->fechaHasta = $hasta;
    }

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

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $paqueteRip = PaqueteRip::find($this->id);
        $this->setFechaDesde(date("Y-m", strtotime($paqueteRip->created_at)) . '-01');
        $this->setFechaHasta(date("Y-m-t", strtotime($paqueteRip->created_at)));
        $this->codigoPaciente = $paqueteRip->entidad;
        switch ($paqueteRip->entidad) {
            case '1':
                $this->redPaciente = 1;
                break;
            case 'EAS027':
                $this->redPaciente = 3;
                break;
            case 'EAS027-1':
                $this->redPaciente = 8;
                break;
        }
        $path = storage_path("app/public/temporalesrips/" . $paqueteRip->id);
        $files = File::allFiles($path);
        $this->fillFileNames($files);
        $this->checkCTFileContent();
//        $this->checkUSFileContent();
        $this->checkAFFileContent();
        $this->checkACFileContent();
        $this->checkAPFileContent();
        $this->checkAMFileContent();
        $this->checkATFileContent();
        $this->checkAUFileContent();
        $this->checkAHFileContent();
        $this->checkANFileContent();
        if (!$this->areThereAnyInconsistencyMessages()) $this->checkBillNumberOfServiceFilesInAF();
        if (!$this->areThereAnyInconsistencyMessages()) $this->checkServiceValueSumatoryInAF();
        if (count($this->errorMessages) > 0) {
            $errores = [];
            foreach ($this->errorMessages as $archivo => $mensajes) {
                foreach ($mensajes as $mensaje => $lineas) {
                    $errores[] = ['archivo' => $archivo, 'mensaje' => $mensaje, 'lineas' => implode(",", $lineas), 'paquete_rip_id' => $paqueteRip->id];
                }
            }
            RipErrore::insert($errores);
            $paqueteRip->estado_id = 27;
            $paqueteRip->save();
            broadcast(new EstadoRips());
        } else {
            $this->guardarRipsCt($paqueteRip->id);
            $this->guardarRipsUs($paqueteRip->id);
            $this->guardarRipsAf($paqueteRip->id);
            $this->guardarRipsAc($paqueteRip->id);
            $this->guardarRipsAp($paqueteRip->id);
            $this->guardarRipsAn($paqueteRip->id);
            $this->guardarRipsAh($paqueteRip->id);
            $this->guardarRipsAu($paqueteRip->id);
            $this->guardarRipsAt($paqueteRip->id);
            $this->guardarRipsAm($paqueteRip->id);
            $paqueteRip->estado_id = 13;
            $paqueteRip->save();
            broadcast(new EstadoRips());
            if (file_exists($path)) {
                foreach (scandir($path) as $file) {
                    if ($file !== '.' && $file !== '..') {
                        unlink($path . '/' . $file);
                    }
                }
                rmdir($path);
            }
        }

    }

    /**
     * Handle a job failure.
     *
     * @param \Throwable $exception
     * @return void
     */
    public function failed(Throwable $exception)
    {
        $paqueteRip = PaqueteRip::find($this->id);
        $paqueteRip->estado_id = 28;
        $paqueteRip->save();
        broadcast(new EstadoRips());
    }

    private function fillFileNames($files)
    {
        $currentFile = [];
        foreach ($files as $file) {
            list($fileName, $ext) = explode('.', $file->getFilename());
            $open_file = fopen($file, 'r');
            $content = fread($open_file, filesize($file));
            $rows = preg_split('/\r\n/', $content);
            $i = 0;
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
        }
    }

    private function checkCTFileContent()
    {
        $line = 1;
        $fileName = $this->CT['fileName'];
        foreach ($this->CT['content'] as $row) {
            if ($this->isThereAny('letter', $row[0]) || $this->isThereAny('char', $row[0])) {
                $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Código del Prestador”.', $fileName, $line, 'Error A124');
            } else {
                $reps = Rep::where('codigo', $row[0])->first();
                if (!$reps) {
                    $this->pushInconsistencyMessage('El “Código del REPS” no se encuentra en la red cargada.', $fileName, $line, 'Error B');
                }
            }
            if (!$this->checkValidDateFormat($row[1])) {
                $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Fecha de Remisión”.', $fileName, $line, 'Error A125');
            } elseif (!$this->checkFirstDateIsLessThanSecondDate($row[1], date('d/m/Y'))) {
                $this->pushInconsistencyMessage('la fecha de remisión no puede ser mayor actual.', $fileName, $line, 'Error B110');
            }

            if (strlen($row[2]) != 8 || $this->isThereAny('char', $row[2])) {
                $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Código del Archivo”.', $fileName, $line, 'Error A126');
            } else {
                $exist_file = false;
                $fileRows = [];
                if (isset($this->item[$row[2]])) {
                    $exist_file = true;
                    $fileRows = $this->item[$row[2]];
                    $totalRows = array_column($fileRows, (strtoupper(substr($row[2], 0, 2)) == 'AF' ? 0 : 1));
                    $count = 0;
                    foreach ($totalRows as $r) {
                        $count++;
                    }
                }
                if ($this->isThereAny('char', $row[3]) || $this->isThereAny('letter', $row[3])) {
                    $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Total de Registros”.', $fileName, $line, 'Error A127');
                }
                if (strtoupper(substr($row[2], 0, 2)) != 'AF' && strtoupper(substr($row[2], 0, 2)) != 'US') {
                    if (!$exist_file) {
                        $this->pushInconsistencyMessage('el nombre "' . $row[2] . '" no coincide con alguno de los archivos cargados ', $fileName, $line, 'Error A');
                    } else {
                        if ($this->isThereAny('char', $row[3]) || $this->isThereAny('letter', $row[3])) {
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Total de Registros”.', $fileName, $line, 'Error A127');
                        } else {
                            if (intval($row[3]) != $count) {
                                switch (strtoupper(substr($row[2], 0, 2))) {
                                    case 'AC':
                                        $this->pushInconsistencyMessage('El número de registros no coincide con el total de registros en el AC.', $fileName, $line, 'Error C57');
                                        break;
                                    case 'AP':
                                        $this->pushInconsistencyMessage('El número de registros no coincide con el total de registros en el AP.', $fileName, $line, 'Error C58');
                                        break;
                                    case 'AM':
                                        $this->pushInconsistencyMessage('El número de registros no coincide con el total de registros en el AM.', $fileName, $line, 'Error C59');
                                        break;
                                    case 'AT':
                                        $this->pushInconsistencyMessage('El número de registros no coincide con el total de registros en el AT.', $fileName, $line, 'Error C60');
                                        break;
                                    case 'AU':
                                        $this->pushInconsistencyMessage('El número de registros no coincide con el total de registros en el AU.', $fileName, $line, 'Error C61');
                                        break;
                                    case 'AH':
                                        $this->pushInconsistencyMessage('El número de registros no coincide con el total de registros en el AH.', $fileName, $line, 'Error C62');
                                        break;
                                    case 'AN':
                                        $this->pushInconsistencyMessage('El número de registros no coincide con el total de registros en el AN.', $fileName, $line, 'Error C63');
                                        break;
                                }
                            }
                        }
                    }
                }

            }

            $nameCount = 0;
            foreach ($this->CT['content'] as $ctRow) {
                if ($ctRow[2] == $row[2] and $ctRow[0] == $row[0]) {
                    $nameCount += 1;
                }
            }
            if ($nameCount > 1) {
                $this->pushInconsistencyMessage('el nombre de archivo "' . $row[2] . '" esta repetido', $fileName, $line, 'Error A1');
            }
            $line++;
        }

        if (count($this->CT['content']) + 1 !== count($this->item)) {
            $this->pushInconsistencyMessage('La cantidad de archivos cargados es diferente a la especificada en el archivo "CT"', '', '', 'Error A');
        }
    }

    private function pushInconsistencyMessage($mensaje, $archivo, $line, $codigo = '')
    {
        if (!isset($this->errorMessages[$archivo][$mensaje])) {
            $this->errorMessages[$archivo][$mensaje][] = $line;
        } else {
            if (count($this->errorMessages[$archivo][$mensaje]) < 500) {
                $this->errorMessages[$archivo][$mensaje][] = $line;
            }
        }
    }

    private function isThereAny($request, $item)
    {
        $string = $item;
        switch ($request) {
            case 'number':
                $validar = "/[0-9]+/i";
                break;
            case 'letter':
                $validar = "/[aA-zZ]+/i";
                break;
            case 'char':
                $validar = "/[\W_]+/i";
                break;
            case 'charExclude-':
                $validar = "/[^\w\-]/i";
                break;
            case 'charExclude+':
                $ignore = ['%', '.', '+', '(', ')', '/', ' ', '#', '*', ':'];
                $string = str_replace($ignore, "", $item);
                $validar = "/[^\w\-]/i";
                break;
            case 'charExclude%':
                $ignore = ['%', '.', '+', '/', '(', ')', ' ', '#', '*', ':'];
                $string = str_replace($ignore, "", $item);
                $validar = "/[^\w\-]/i";
                break;
            case 'charExclude#':
                $ignore = ['%', '.', '#', '(', ')', ' ', '/', ':'];
                $string = str_replace($ignore, "", $item);
                $validar = "/[^\w\-]/i";
                break;
        }

        if (preg_match($validar, $string)) {
            return true;
        }
        return false;
    }

    private function checkValidDateFormat($date)
    {
        $valores = explode('/', $date);
        if(!is_array($valores)){
            return false;
        }
        if (strlen($valores[0]) != 2 || !is_numeric($valores[0]) || strlen($valores[1]) != 2 || !is_numeric($valores[1]) || strlen($valores[2]) != 4 || !is_numeric($valores[2])) {
            return false;
        }
        if (count($valores) != 3 || !checkdate($valores[1], $valores[0], $valores[2])) {
            return false;
        }
        list($day, $month, $year) = explode('/', $date);
        if (!isset($month) || !isset($year) || strlen($year) != 4) {
            return false;
        }
        if (checkdate($month, $day, $year)) {
            if (strtotime('-3 year', strtotime(date('d-m-Y'))) < strtotime('23-11-2017')) {
                if (strtotime($day . '-' . $month . '-' . $year) >= strtotime('23-11-2017')) {
                    return true;
                }
                return false;
            } else {
                if (strtotime($day . '-' . $month . '-' . $year) >= strtotime('-3 year', strtotime(date('d-m-Y')))) {
                    return true;
                }
                return false;
            }
        }
        return false;
    }

    private function checkFirstDateIsLessThanSecondDate($date1, $date2)
    {
        $date_1 = explode('/', $date1);
        $date_2 = explode('/', $date2);
        if (strtotime($date_1[0] . '-' . $date_1[1] . '-' . $date_1[2]) <= strtotime($date_2[0] . '-' . $date_2[1] . '-' . $date_2[2])) {
            return true;
        }
        return false;
    }

    private function checkUSFileContent()
    {
        if (isset($this->US['content'])) {
            $line = 1;
            $fileName = $this->US['fileName'];
            $department = null;
            foreach ($this->US['content'] as $row) {

                if ($row[0] == '') {
                    $this->pushInconsistencyMessage('el tipo de documento es requerido', $fileName, $line);
                } elseif (!$this->checkValidDocumentType($row[0])) {
                    $this->pushInconsistencyMessage('el tipo de documento no es válido', $fileName, $line);
                }

                if ($row[1] == '') {
                    $this->pushInconsistencyMessage('el número de documento es requerido', $fileName, $line);
                } elseif (!$this->checkValidDocumentNumberByDocumentType($row[0], $row[1])) {
                    $this->pushInconsistencyMessage('el número de documento no es válido', $fileName, $line);
                } else {
                    $documentNumberPatient = $row[1];
                    $patient = $this->findPatientByDocumentNumber($documentNumberPatient);
                    if (!$patient) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('El campo ”Numero de Identificación “no existe en la base de afiliados.', $fileName, $line, 'Error B4');
                    } else {
                        if (intval($patient->entidad_id) !== intval($this->redPaciente)) {
                            $this->pushInconsistencyMessage('La entidad seleccionada no coincide con la del paciente', $fileName, $line, 'Error B3');
                        }

                        $tipoDocumentoMap = [
                            'CC'  => 1,
                            'TI'  => 2,
                            'RC'  => 3,
                            'TE'  => 4,
                            'CE'  => 5,
                            'NIT' => 6,
                            'PA'  => 7,
                            'PE'  => 9,
                            'PT'  => 10,
                            'SC'  => 11,
                            'CN'  => 12,
                        ];

                        if (isset($tipoDocumentoMap[$row[0]])) {
                            $row[0] = $tipoDocumentoMap[$row[0]];
                        }

                        if ($patient->tipo_documento != $row[0]) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('El campo ”Tipo de Identificación “no coincide el registro en la base de afiliados.', $fileName, $line, 'Error B3');
                        }
                    }


                }

                // if ($row[2] != $this->codigoPaciente) {
                //     $this->pushInconsistencyMessage('el código entidad administradora no es válido', $fileName, $line);
                // }
                if ($row[3] != '5') {
                    $this->pushInconsistencyMessage('el tipo usuario no es válido', $fileName, $line);
                }
                if ($row[4] == '') {
                    $this->pushInconsistencyMessage('el primer apellido es campo obligatorio', $fileName, $line);

                } elseif (!(strlen($row[4]) >= 3 && strlen($row[4]) <= 30) || $this->isThereAny('number', $row[4])) {

                    $this->pushInconsistencyMessage('el primer apellido no cumple con las normas', $fileName, $line);
                }
                if ($row[6] == '') {
                    $this->pushInconsistencyMessage('el primer nombre es campo obligatorio', $fileName, $line);

                } elseif (!(strlen($row[6]) >= 3 && strlen($row[6]) <= 30) || $this->isThereAny('number', $row[6])) {

                    $this->pushInconsistencyMessage('el primer nombre no cumple con las normas', $fileName, $line);
                }

                if (!(strlen($row[8]) >= 1 && strlen($row[8]) <= 3) || $this->isThereAny('letter', $row[8]) || $this->isThereAny('char', $row[8])) {
                    $this->pushInconsistencyMessage('la edad no cumple con las normas', $fileName, $line);
                }

                ///// NO BORRAR ESTA VALIDACION /////
//            switch ($row[9]) {
//                case 1:
//                    switch ($row[0]) {
//                        case 'AS':
//                            if (!$this->haveAgeBetween($row[8], ...[17, 120])) {
//                                $this->pushInconsistencyMessage('la edad no esta entre el rango permitido de años', $fileName, $line);
//                            }
//                            break;
//                        case 'TI':
//                            if (!$this->haveAgeBetween($row[8], ...[7, 17])) {
//                                $this->pushInconsistencyMessage('la edad no corresponde al tipo de documento', $fileName, $line);
//                            }
//                            break;
//                        case 'CN':
//                            $this->pushInconsistencyMessage('la edad no corresponde al tipo de documento', $fileName, $line);
//                            break;
//                        case 'RC':
//                            if (!$this->haveAgeBetween($row[8], ...[1, 8])) {
//                                $this->pushInconsistencyMessage('la edad no corresponde al tipo de documento', $fileName, $line);
//                            }
//                            break;
//                        default:
//                            if (!$this->haveAgeBetween($row[8], ...[1, 120])) {
//                                $this->pushInconsistencyMessage('la edad no esta entre el rango permitido de años', $fileName, $line);
//                            }
//                            break;
//                    }
//                    break;
//                case 2:
//                    if ($row[0] == 'RC') {
//                        if (!$this->haveAgeBetween($row[8], ...[1, 11])) {
//                            $this->pushInconsistencyMessage('la edad no esta entre el rango permitido de meses', $fileName, $line);
//                        }
//                    } else {
//                        $this->pushInconsistencyMessage('tipo de documento no corresponde con la edad', $fileName, $line);
//                    }
//                    break;
//                case 3:
//                    switch ($row[0]) {
//                        case 'RC':
//                        case 'CN':
//                        case 'MS':
//                            if (!$this->haveAgeBetween($row[8], ...[1, 29])) {
//                                $this->pushInconsistencyMessage('la edad no esta entre el rango permitido de días', $fileName, $line);
//                            }
//                            break;
//                        default:
//                            $this->pushInconsistencyMessage('tipo de documento no corresponde con la edad', $fileName, $line);
//                            break;
//                    }
//                    break;
//                default:
//                    $this->pushInconsistencyMessage('Unidad de medida de la edad no valida', $fileName, $line);
//                    break;
//            }

                if (($row[10] != 'M' && $row[10] != 'F')) {
                    $this->pushInconsistencyMessage('el sexo no cumple con las normas', $fileName, $line);
                }

                if (!(strlen($row[11]) == 2) || $this->isThereAny('letter', $row[11]) || $this->isThereAny('char', $row[11])) {
                    $this->pushInconsistencyMessage('el código del departamento no es válido', $fileName, $line);
                } else {
                    $department = $this->findDepartmentByDANECode($row[11]);
                    if (!isset($department)) {
                        $this->pushInconsistencyMessage('el código del departamento no se encontró', $fileName, $line);
                    }
                }


                if ($department) {
                    if (!(strlen($row[12]) == 3) || $this->isThereAny('letter', $row[12]) || $this->isThereAny('char', $row[12])) {
                        $this->pushInconsistencyMessage('El código del municipio no válido', $fileName, $line);
                    } else {
                        $township = $this->findTownshipByDANECode($row[12], $department);
                        if (!isset($township)) {
                            $this->pushInconsistencyMessage('El codigo del municipio no valido', $fileName, $line);
                        } else {
                            if ($row[11] != '') {
                                if ($township->departamento_id != $department->id) {
                                    $this->pushInconsistencyMessage('El código del municipio no coincide con el código del departamento', $fileName, $line);
                                }
                            }
                        }
                    }
                } else {
                    $this->pushInconsistencyMessage('el código del departamento no se encontró', $fileName, $line);
                }

                if (($row[13] != 'U' && $row[13] != 'R')) {
                    $this->pushInconsistencyMessage('La zona no es válida', $fileName, $line);
                }
                $line++;
            }
        }
    }

    private function checkAFFileContent()
    {
        if (isset($this->AF['content'])) {
            $line = 1;
            $fileName = $this->AF['fileName'];
            foreach ($this->AF['content'] as $row) {
                if (count($this->errorMessages) < 500) {
                    $valor = 0;
                    if (strlen($row[0]) != 12 || $this->isThereAny('letter', $row[0]) || $this->isThereAny('char', $row[0])) {
                        $this->pushInconsistencyMessage('número de habilitación tiene caracteres especiales', $fileName, $line);
                    } else {
                        $billCounter = 0;
                        foreach ($this->CT['content'] as $r) {
                            if ($r[0] == $row[0] || $r[2] == $this->CT['fileName']) {
                                $billCounter++;
                            }
                        }
                        if ($billCounter < 1) {
                            $this->pushInconsistencyMessage('número de habilitación no se encuentra registrado en el archivo CT', $fileName, $line);
                        }
                    }
                    if (strlen($row[1]) > 60 || $this->isThereAny('number', $row[1])) {
                        $this->pushInconsistencyMessage('razón social tiene caracteres especiales', $fileName, $line);
                    }
                    if (!$this->checkValidDocumentNumberByDocumentType($row[2], $row[3])) {
                        $this->pushInconsistencyMessage('el número de documento del prestador no válido', $fileName, $line);
                    }
                    $this->prestador = Prestador::select('prestadores.tipo_prestador_id', 'contratos.capitado')
                        ->join('contratos', 'prestadores.id', 'contratos.prestador_id')
                        ->where('prestadores.nit', $row[3])->first();
                    if (!$this->prestador) {
                        $this->pushInconsistencyMessage('el número de documento del prestador no se encuentra registrado en la base de datos.', $fileName, $line);
                    }
                    $billCounter = 0;
                    foreach ($this->AF['content'] as $r) {
                        if ($r[4] == $row[4] and $r[0] == $row[0]) {
                            $billCounter++;
                        }
                    }
                    if ($billCounter > 1) {
                        $this->pushInconsistencyMessage('el número de factura está repetido ' . $billCounter . ' veces', $fileName, $line);
                    }

                    $factura = Af::join('paquete_rips as pr', 'afs.paquete_rip_id', 'pr.id')
                        ->where('numero_factura', $row[4])
                        ->where('numero_identificacion', $row[3])
                        ->where('tipo_identificacion', $row[2])
                        ->whereIn('pr.estado_id', [13, 14])
                        ->first();
                    if ($factura) {
                        $this->pushInconsistencyMessage('este número de factura ya esta radicado con el mismo prestador', $fileName, $line);
                    }

                    if (!$this->checkValidDateFormat($row[5])) {
                        $this->pushInconsistencyMessage('error en el formato fecha ', $fileName, $line);
                    } else {
                        if (!$this->checkFirstDateIsLessThanSecondDate($row[5], date('d/m/Y'))) {
                            $this->pushInconsistencyMessage('fecha expedición del archivo es mayor a la actual ', $fileName, $line);
                        } elseif (!$this->checkFirstDateIsLessThanSecondDate(date('d/m/Y', strtotime(date('01-m-Y') . '- 12 month')), $row[5])) {
                            $this->pushInconsistencyMessage('fecha de expedición de la factura no debe ser inferior a un año', $fileName, $line);
                        }
                    }

                    if (!$this->checkValidDateFormat($row[6])) {
                        $this->pushInconsistencyMessage('error en la fecha inicio', $fileName, $line);
                    } elseif (!$this->checkFirstDateIsLessThanSecondDate($row[6], date('d/m/Y'))) {
                        $this->pushInconsistencyMessage('fecha inicio es mayor a la actual', $fileName, $line);
                    }
                    if (!$this->checkValidDateFormat($row[7])) {
                        $this->pushInconsistencyMessage('error en la fecha fin', $fileName, $line);
                    } else {
                        if (!$this->checkFirstDateIsLessThanSecondDate($row[7], date('d/m/Y'))) {
                            $this->pushInconsistencyMessage('fecha fin del archivo es mayor a la actual', $fileName, $line);
                        }
                        if (!$this->checkFirstDateIsLessThanSecondDate($row[6], $row[7])) {
                            $this->pushInconsistencyMessage('fecha inicio es mayor a la fecha final', $fileName, $line);
                        }
                    }
                    // if ($row[8] != $this->codigoPaciente) {
                    //     $this->pushInconsistencyMessage('código entidad registrador es diferente de ' . $this->codigoPaciente, $fileName, $line);
                    // }
                    if ($row[9] == '') {
                        $this->pushInconsistencyMessage('nombre entidad registrador tiene que estar diligenciado', $fileName, $line);
                    }
                    if ($this->isThereAny('char', $row[12])) {
                        $this->pushInconsistencyMessage('número de póliza contiene caracteres especiales', $fileName, $line);
                    }
                    if ($row[13] == '') {
                        $this->pushInconsistencyMessage('valor copago no puede estar vacío', $fileName, $line);
                    } elseif ($row[13] != '0') {
                        $this->pushInconsistencyMessage('regimen especial no permite copago', $fileName, $line);
                    }
                    if ($row[14] == '') {
                        $this->pushInconsistencyMessage('valor comisión no puede estar vacío', $fileName, $line);
                    } elseif ($row[14] != '0') {
                        $this->pushInconsistencyMessage('régimen especial no permite comisión', $fileName, $line);
                    }
                    if ($row[15] == '') {
                        $this->pushInconsistencyMessage('valor descuento no puede estar vacío', $fileName, $line);
                    } elseif ($row[15] != '0') {
                        $this->pushInconsistencyMessage('régimen especial no permite descuento', $fileName, $line);
                    }
                    if ($row[16] == '') {
                        $this->pushInconsistencyMessage('el valor neto a pagar no puede estar vacío', $fileName, $line);
                    } elseif ($this->isThereAny('letter', $row[16]) || $this->isThereAny('char', $row[16])) {
                        $this->pushInconsistencyMessage('valor total no válido', $fileName, $line);
                    }
                    $line++;
                }
            }
        }
    }

    private function checkACFileContent()
    {
        if (isset($this->AC['content'])) {
            $line = 1;
            $fileName = $this->AC['fileName'];
            foreach ($this->AC['content'] as $index => $row) {
                $flagSuccess = 1;
                if (count($this->errorMessages) < 500) {
                    $patient = null;
                    if (!$row[0] || strlen($row[0]) > 20 || $this->isThereAny('charExclude-', $row[0])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Número de la factura”.', $fileName, $line, 'Error A22');
                    }

                    if (strlen($row[1]) != 12 || $this->isThereAny('letter', $row[1]) || $this->isThereAny('char', $row[1])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Código del Prestador”.', $fileName, $line, 'Error A23');
                    } else {
                        if ($this->CT['content'][0][0] != $row[1]) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('El código de habilitación no existe en la red actual', $fileName, $line, 'Error B2');
                        }
                    }

                    if (strlen($row[2]) != 2 || $this->isThereAny('char', $row[2]) || $this->isThereAny('number', $row[2]) || !$this->validarDocumentos($row[2])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Tipo de Identificación”.', $fileName, $line, 'Error A24');
                    }

                    if (strlen($row[3]) > 16 || $this->isThereAny('char', $row[3])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Número de Identificación”.', $fileName, $line, 'Error A25');
                    }
                    $errorPaciente = $this->validarPacienteEnUs($row[3], $row[2]);
                    if ($errorPaciente) {
                        $this->pushInconsistencyMessage($errorPaciente, $fileName, $line, 'Error B4');
                    }
                    if (!$this->checkValidDateFormat($row[4])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Fecha de Consulta”.', $fileName, $line, 'Error A26');
                    } else {
                        $valores = explode('/', $row[4]);
                        $fechaFormateada = $valores[2] . '-' . $valores[1] . '-' . $valores[0];
                        if ($fechaFormateada >= date('Y-m-d')) {
                            $this->pushInconsistencyMessage('La “Fecha de Consulta” no puede ser superior e igual a la fecha actual.', $fileName, $line, 'Error A2');
                        }
                    }

                    if ($row[5] != '') {
                        if (strlen($row[5]) > 15 || $this->isThereAny('charExclude-', $row[5])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Nro de Autorización”.', $fileName, $line, 'Error A27');
                        }
                    }

                    if (strlen($row[6]) != 6 || $this->isThereAny('letter', $row[6]) || $this->isThereAny('char', $row[6])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Código de la consulta”.', $fileName, $line, 'Error A28');
                    } else {
                        if (count(Cup::where('codigo', $row[6])->where('archivo', 'AC')->get()) == 0) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('El código registrado en el campo “código de consulta” no existe en la tabla CUPS de normatividad vigente.', $fileName, $line, 'Error B5');
                        }
                    }

                    if ($row[7] != '') {
                        if (strlen($row[7]) != 2 || !($row[7] >= 01 && $row[7] <= 10) || $this->isThereAny('letter', $row[7]) || $this->isThereAny('char', $row[7])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Finalidad de la consulta”', $fileName, $line, 'Error A29');
                        }
                        if (intval($row[7]) <= 8 && strtolower(substr($row[9], 0, 1)) !== 'z') {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('La finalidad registrada en el campo “Finalidad de la consulta” no es válido para un diagnóstico Z', $fileName, $line, 'Error C3');
                        }
                        if (intval($row[7]) > 8 && strtolower(substr($row[9], 0, 1)) === 'z') {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('La finalidad registrada en el campo “Finalidad de la consulta” no es válido para un diagnóstico Z', $fileName, $line, 'Error C3');
                        }
                    } else {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Finalidad de la consulta”', $fileName, $line, 'Error A29');
                    }

//                elseif ($row[7] == '05') {
//                    if (!$this->checkPurposeInUSFileByAge($row[2], $row[3])) {
//                        $this->pushInconsistencyMessage('finalidad es 05 y la edad del usuario no esta en el rango válido', $fileName, $line);
//                    }
//                }
                    if (strlen($row[8]) != 2 || !($row[8] >= 01 && $row[8] <= 15) || $this->isThereAny('letter', $row[8]) || $this->isThereAny('char', $row[8])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Causa externa”.', $fileName, $line, 'Error A30');
                    }
                    if ((($row[7] >= 01 && $row[7] <= 6) && $row[8] != 15) || ($row[7] == 8 && $row[8] != 15) || ($row[8] >= 1 && $row[8] <= 12 && $row[7] != 10) || ($row[8] == 14 && $row[7] != 10)) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('El valor registrado campo “finalidad de la consulta” no es coherente con la Causa externa. ', $fileName, $line, 'Error C6');
                    }

                    if (strlen($row[9]) != 4 || $this->isThereAny('char', $row[9])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Diagnóstico Principal”.', $fileName, $line, 'Error A31');
                    } else {
                        $cie10 = Cie10::where('codigo_cie10', $row[9])->where('estado', 1)->first();
                        if (!$cie10) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico principal” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'Error B6');
                        } else {
                            if ($patient) {
                                if ($this->verifyGender($patient, $cie10)) {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico principal” no es válido para el sexo.', $fileName, $line, 'Error B8');
                                }
                                if ($this->checkValidDateFormat($row[4])) {
                                    if ($this->verifyAge($patient, $cie10, $row[4])) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico principal” no es válido para la edad.', $fileName, $line, 'Error B7');
                                    }
                                }
                            }
                        }
                    }
//                if (strtolower(substr($row[9], 0, 1)) == 'z' && intval($row[7]) > 8) {
//                    $this->pushInconsistencyMessage('La finalidad registrada en el campo “Finalidad de la consulta” no es válido para un diagnóstico Z', $fileName, $line, 'Error C3');
//                }

                    if ($row[10] != '') {
                        if (strlen($row[10]) != 4 || $this->isThereAny('char', $row[10])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Diagnóstico relacionado 1”.', $fileName, $line, 'Error A32');
                        } else {
                            $cie10_1 = Cie10::where('codigo_cie10', $row[10])->where('estado', 1)->first();
                            if (!$cie10_1) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 1” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'Error B9');
                            } else {
                                if ($patient) {
                                    if ($this->verifyGender($patient, $cie10_1)) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado1” no es válido para el sexo.', $fileName, $line, 'Error B10');
                                    }
                                    if ($this->checkValidDateFormat($row[4])) {
                                        if ($this->verifyAge($patient, $cie10_1, $row[4])) {
                                            $flagSuccess = 0;
                                            $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado2” no es válido para la edad', $fileName, $line, 'Error B11');
                                        }
                                    }
                                }
                            }
                        }
//                    if ($row[10] == $row[9]) {
//                        $this->pushInconsistencyMessage('código diagnóstico relacionado 1 ya se encuentra registrado', $fileName, $line);
//                    }
                    }

                    if ($row[11] != '') {
                        if (strlen($row[11]) != 4 || $this->isThereAny('char', $row[11])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Diagnóstico relacionado 2”.', $fileName, $line, 'Error A33');
                        } else {
                            $cie10_2 = Cie10::where('codigo_cie10', $row[11])->where('estado', 1)->first();
                            if (!$cie10_2) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 2” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'Error B12');
                            } else {
                                if ($patient) {
                                    if ($this->verifyGender($patient, $cie10_2)) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado2” no es válido para el sexo.', $fileName, $line, 'Error B14');
                                    }
                                    if ($this->checkValidDateFormat($row[4])) {
                                        if ($this->verifyAge($patient, $cie10_2, $row[4])) {
                                            $flagSuccess = 0;
                                            $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado2” no es válido para la edad.', $fileName, $line, 'Error B13');
                                        }
                                    }
                                }
                            }
                        }
//                    if ($row[11] == $row[9] || $row[11] == $row[10]) {
//                        $this->pushInconsistencyMessage('código diagnóstico relacionado 2 ya se encuentra registrado', $fileName, $line);
//                    }
                    }

                    if ($row[12] != '') {
                        if (strlen($row[12]) != 4 || $this->isThereAny('char', $row[12])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Diagnóstico relacionado 3”.', $fileName, $line, 'Error A34');
                        } else {
                            $cie10_3 = Cie10::where('codigo_cie10', $row[12])->where('estado', 1)->first();
                            if (!$cie10_3) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 3” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'Error B15');
                            } else {
                                if ($patient) {
                                    if ($this->verifyGender($patient, $cie10_3)) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 3” no es válido para el sexo.', $fileName, $line, 'Error B17');
                                    }
                                    if ($this->checkValidDateFormat($row[4])) {
                                        if ($this->verifyAge($patient, $cie10_3, $row[4])) {
                                            $flagSuccess = 0;
                                            $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 3” no es válido para la edad. ', $fileName, $line, 'Error B16');
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if (strlen($row[13]) != 1 || !($row[13] >= 1 && $row[13] <= 3) || $this->isThereAny('char', $row[13]) || $this->isThereAny('letter', $row[13])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Tipo de Diagnóstico”.', $fileName, $line, 'Error A35');
                    }
                    if (strlen($row[14]) >= 15 || $row[14] == '' || $this->isThereAny('letter', $row[14]) || $this->isThereAny('char', $row[14])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Valor de la consulta”.', $fileName, $line, 'Error A36');
                    }
                    if (strlen($row[15]) >= 15 || $row[15] == '' || $this->isThereAny('letter', $row[15]) || $this->isThereAny('char', $row[15])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Error A35, Existe un valor no permitido en el campo “Valor cuota moderadora”. ', $fileName, $line, 'Error A37');
                    }


                    if (strlen($row[16]) >= 15 || $row[16] == '' || $this->isThereAny('letter', $row[16]) || $this->isThereAny('char', $row[16])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Valor neto a pagar”.', $fileName, $line, 'Error A38');
                    } else {
//                        if (intval($row[16]) < 5000 || intval($row[16]) > 200000) {
//                            $this->pushWarningMessage('El valor en el campo “Valor neto a pagar” es menor o mayor al rango establecido.', $fileName, $line, 'Alerta, B18');
//                        }
                        if (intval($row[16]) !== (intval($row[15]) + intval($row[14]))) {
                            $this->pushInconsistencyMessage('El valor registrado en el campo ”Valor neto a pagar" no coincide con la operación matemática del "valor de la consulta" más el “Valor cuota moderadora”.', $fileName, $line, 'Error B');
                        }
                    }

                    $columnaCedulas = array_keys(array_column($this->AC['content'], 3), $row[3]);
                    foreach ($columnaCedulas as $columnaCedula) {
                        $flag = 1;
                        if ($index != $columnaCedula) {
                            $lineaSecundaria = $this->AC['content'][$columnaCedula];
                            if ($lineaSecundaria[4] === $row[4] && $lineaSecundaria[6] === $row[6] && $lineaSecundaria[7] === $row[7] && $lineaSecundaria[8] === $row[8] && $lineaSecundaria[9] === $row[9]) {
                                $flag = 0;
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('Registo AC se encuentra duplicado dos o mas veces en el periodo.', $fileName, $line, 'Error B');
                            }
                        }
                        if (!$flag) {
                            break;
                        }
                    }

                    if ($flagSuccess) {
                        $this->AC['success'][] = $row;
                    }
                    $line++;
                }
            }
        }
    }

    private function checkAPFileContent()
    {
        if (isset($this->AP['content'])) {
            $line = 1;
            $fileName = $this->AP['fileName'];
            foreach ($this->AP['content'] as $index => $row) {
                $flagSuccess = 1;
                if (count($this->errorMessages) < 500) {
                    $patient = null;
                    if (!$row[0] || strlen($row[0]) > 20 || $this->isThereAny('charExclude-', $row[0])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Número de la factura”.', $fileName, $line, 'Error A37');
                    }
                    if (strlen($row[1]) != 12 || $this->isThereAny('letter', $row[1]) || $this->isThereAny('char', $row[1])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Código del Prestador”.', $fileName, $line, 'Error A38');
                    } else {
                        if ($this->CT['content'][0][0] != $row[1]) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('El código de habilitación no existe en la red actual', $fileName, $line, 'Error B19');
                        }
                    }
                    if (strlen($row[2]) != 2 || $this->isThereAny('char', $row[2]) || $this->isThereAny('number', $row[2]) || !$this->validarDocumentos($row[2])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Tipo de Identificación”.', $fileName, $line, 'Error A39');
                    }

                    if (strlen($row[3]) > 16 || $this->isThereAny('char', $row[3])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Número de Identificación”.', $fileName, $line, 'Error A40');
                    } else {
                        $errorPaciente = $this->validarPacienteEnUs($row[3], $row[2]);
                        if ($errorPaciente) {
                            $this->pushInconsistencyMessage($errorPaciente, $fileName, $line, 'Error B4');
                        }
                    }


                    if (!$this->checkValidDateFormat($row[4])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Fecha de procedimiento”.', $fileName, $line, 'Error A41');
                    } else {
                        $valores = explode('/', $row[4]);
                        $fechaFormateada = $valores[2] . '-' . $valores[1] . '-' . $valores[0];
                        if ($fechaFormateada >= date('Y-m-d')) {
                            $this->pushInconsistencyMessage('La “Fecha de procedimiento” no puede ser superior e igual a la fecha actual.', $fileName, $line, 'Error A2');
                        }
                    }
                    if ($row[5] != '') {
                        if (strlen($row[5]) > 15 || $this->isThereAny('charExclude-', $row[5])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Nro de Autorización”.', $fileName, $line, 'Error A42');
                        }
                    }


                    if (strlen($row[6]) != 6 || $this->isThereAny('char', $row[6])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Código del procedimiento”. ', $fileName, $line, 'Error A43');
                    } else {
                        if (count(Cup::where('codigo', $row[6])->where('archivo', 'AP')->get()) == 0) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('El código registrado en el campo “código del procedimiento” no existe en la tabla CUPS de normatividad vigente.', $fileName, $line, 'Error B23');
                        }
                        $arrParto = [721003, 732201, 735301, 735930, 735931, 740001, 740002, 740003];
                        if (in_array(intval($row[6]), $arrParto) && (intval($row[9]) < 1 || intval($row[9]) > 5 || $row[9] = '')) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('El valor registrado en el campo “código del procedimiento” requiere que exista un registro el campo Personal que atiende.', $fileName, $line, 'Error C12');
                        }
                    }
                    if (strlen($row[7]) != 1 || $row[7] < 1 || $row[7] > 3 || $this->isThereAny('char', $row[7]) || $this->isThereAny('letter', $row[7])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Ámbito de la realización del Procedimiento”.', $fileName, $line, 'Error A44');
                    } else {
                        if (intval($row[7]) === 2) {
                            if (isset($this->AH['content'])) {
                                if (!in_array($row[3], array_column($this->AH['content'], 3))) {
                                    $this->pushInconsistencyMessage('El valor registrado en el campo “Ámbito de la realización del Procedimiento” requiere que exista un registro en el AH', $fileName, $line, 'Error C9');
                                }
                            } else {
                                $this->pushInconsistencyMessage('El valor registrado en el campo “Ámbito de la realización del Procedimiento” requiere que exista un registro en el AH', $fileName, $line, 'Error C9');
                            }
                        } elseif ($row[7] === 3) {
                            if (isset($this->AU['content'])) {
                                if (!in_array($row[3], array_column($this->AU['content'], 3))) {
                                    $this->pushInconsistencyMessage('El valor registrado en el campo “Ámbito de la realización del Procedimiento” requiere que exista un registro en el AU.', $fileName, $line, 'Error C10');
                                }
                            } else {
                                $this->pushInconsistencyMessage('El valor registrado en el campo “Ámbito de la realización del Procedimiento” requiere que exista un registro en el AU.', $fileName, $line, 'Error C10');
                            }
                        }
                    }
                    if (strlen($row[8]) != 1 || $row[8] < 1 || $row[8] > 5 || $this->isThereAny('char', $row[8]) || $this->isThereAny('letter', $row[8])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Finalidad del procedimiento”.', $fileName, $line, 'Error A45');
                    }
                    if ($row[9] != '') {
                        if (!($row[9] >= 1 && $row[9] <= 5)) {
                            $this->pushInconsistencyMessage('personal que atiende incorrecto', $fileName, $line);
                        }
                    }
                    if (count(Cup::where('codigo', $row[6])->where('archivo', 'AP')->where('quirurgico', 1)->get()) > 0) {
                        if ($row[10] == '') {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Diagnóstico Principal”.', $fileName, $line, 'Error A46');
                        } else {
                            if (strlen($row[10]) != 4 || $this->isThereAny('char', $row[10])) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Diagnóstico Principal”.', $fileName, $line, 'Error A46');
                            } else {
                                $cie10 = Cie10::where('codigo_cie10', $row[10])->where('estado', 1)->first();
                                if (!$cie10) {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico principal” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'Error B24');
                                } else {
                                    if ($patient) {
                                        if ($this->verifyGender($patient, $cie10)) {
                                            $flagSuccess = 0;
                                            $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico principal” no es válido para el sexo.', $fileName, $line, 'Error B25');
                                        }
                                        if ($this->verifyAge($patient, $cie10, $row[4])) {
                                            $flagSuccess = 0;
                                            $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico principal” no es válido para la edad.', $fileName, $line, 'Error B26');
                                        }
                                    }
                                }
                            }
                        }

                        if (!($row[13] >= 1 && $row[13] <= 5)) {
                            $this->pushInconsistencyMessage('acto quirúrgico no válido', $fileName, $line);
                        }
//                        else {
//                            $cie10Principal = Cie10::where('Codigo_CIE10', $row[10])->where('estado_id', 1)->first();
//                            if ($cie10Principal) {
//                                if ($cie10Principal->no_quirurgico) {
//                                    $flagSuccess = 0;
//                                    $this->pushInconsistencyMessage('Si registra un valor en el campo “Diagnóstico principal” entonces el código del procedimiento deberá ser quirúrgico.', $fileName, $line, 'Error C15');
//                                }
//                            } else {
//                                $this->pushInconsistencyMessage('Si registra un valor en el campo “Diagnóstico principal” entonces el código del procedimiento deberá ser quirúrgico.', $fileName, $line, 'Error C15');
//                            }
//                        }
                    }


                    if ($row[10] != '') {
                        if (strlen($row[10]) != 4 || $this->isThereAny('char', $row[10])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Diagnóstico Principal”.', $fileName, $line, 'Error A46');
                        } else {
                            $cie10 = Cie10::where('codigo_cie10', $row[10])->where('estado', 1)->first();
                            if (!$cie10) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico principal” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'Error B24');
                            } else {
                                if ($patient) {
                                    if ($this->verifyGender($patient, $cie10)) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico principal” no es válido para el sexo.', $fileName, $line, 'Error B25');
                                    }
                                    if ($this->verifyAge($patient, $cie10, $row[4])) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico principal” no es válido para la edad.', $fileName, $line, 'Error B26');
                                    }
                                }
                            }
                        }
                    }
                    if ($row[11] != '') {
                        if (strlen($row[11]) != 4 || $this->isThereAny('char', $row[11])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Código del diagnóstico relacionado”.', $fileName, $line, 'Error A47');
                        } else {
                            $cie10_1 = Cie10::where('codigo_cie10', $row[11])->where('estado', 1)->first();
                            if (!$cie10_1) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'Error B27');
                            } else {
                                if ($row[10] == '') {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('Si registra Diagnostico relacionado debe registar diagnostico principal”.', $fileName, $line, 'Error A');
                                }
                                if ($patient) {
                                    if ($this->verifyGender($patient, $cie10_1)) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado” no es válido para el sexo.', $fileName, $line, 'Error B29');
                                    }
                                    if ($this->verifyAge($patient, $cie10_1, $row[4])) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado” no es válido para la edad.', $fileName, $line, 'Error B28');
                                    }
                                }
                            }

                        }
                    }
                    if ($row[12] != '') {
                        if (strlen($row[12]) != 4 || $this->isThereAny('char', $row[12])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Diagnóstico de Complicación”.', $fileName, $line, 'Error A48');
                        } else {
                            $cie10_2 = Cie10::where('codigo_cie10', $row[12])->where('estado', 1)->first();
                            if (!$cie10_2) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico de complicación” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'Error B30');
                            } else {
                                if ($row[10] == '') {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('Si registra Diagnostico de complicación debe registar diagnostico principal”.', $fileName, $line, 'Error A');
                                }
                                if ($patient) {
                                    if ($this->verifyGender($patient, $cie10_2)) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico de complicación” no es válido para el sexo.', $fileName, $line, 'Error B32');
                                    }
                                    if ($this->verifyAge($patient, $cie10_2, $row[4])) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico de complicación” no es válido para la edad.', $fileName, $line, 'Error B31');
                                    }
                                }
                            }
                        }
                    }
                    if ($row[13] != '') {
                        if ($row[13] < 1 || $row[13] > 5 || $this->isThereAny('char', $row[13]) || $this->isThereAny('letter', $row[13])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Forma de realización del acto quirúrgico”.', $fileName, $line, 'Error A49');
                        }
                    }
                    if ($row[14] == "" || strlen($row[14]) > 15 || $this->isThereAny('char', $row[14]) || $this->isThereAny('letter', $row[14])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Valor del procedimiento”.', $fileName, $line, 'Error A50');
                    }

                    $columnaCedulas = array_keys(array_column($this->AP['content'], 3), $row[3]);
                    $flag = 1;
                    $repetidos = 0;
                    foreach ($columnaCedulas as $columnaCedula) {
                        $flag = 1;
                        if ($index != $columnaCedula) {
                            $lineaSecundaria = $this->AP['content'][$columnaCedula];
                            if ($lineaSecundaria[4] === $row[4] && $lineaSecundaria[6] === $row[6]) {
                                $repetidos++;
                            }
                        }
                    }
                    if ($repetidos > 1) {
                        $registroAH = (isset($this->AH['content']) ? array_keys(array_column($this->AH['content'], 3), $row[3]) : []);
                        $registroAC = (isset($this->AC['content']) ? array_keys(array_column($this->AC['content'], 3), $row[3]) : []);
                        if (count($registroAH) === 0 && count($registroAC) === 0) {
                            $flag = 1;
                        } elseif ($repetidos > 2) {
                            $flag = 1;
                        }
                    }
                    if (!$flag) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Registo AP se encuentra duplicado dos o mas veces en el periodo.', $fileName, $line, 'Error B');
                    }

                    if ($flagSuccess) {
                        $this->AP['success'][] = $row;
                    }
                    $line++;
                }
            }
        }

    }

    private function checkAMFileContent()
    {
        if (isset($this->AM['content'])) {
            $line = 1;
            $fileName = $this->AM['fileName'];
            foreach ($this->AM['content'] as $row) {
                $flagSuccess = 1;
                if (count($this->errorMessages) < 500) {
                    if (!$row[0] || strlen($row[0]) > 20 || $this->isThereAny('charExclude-', $row[0])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Número de la factura”.', $fileName, $line, 'Error A51');
                    }
                    if (strlen($row[1]) != 12 || $this->isThereAny('letter', $row[1]) || $this->isThereAny('char', $row[1])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Código del Prestador”.', $fileName, $line, 'Error A52');
                    } else {
                        if ($this->CT['content'][0][0] != $row[1]) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('El código de habilitación no existe en la red actual', $fileName, $line, 'Error B34');
                        }
                    }
                    if (strlen($row[2]) != 2 || $this->isThereAny('char', $row[2]) || $this->isThereAny('number', $row[2]) || !$this->validarDocumentos($row[2])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Tipo de Identificación”.', $fileName, $line, 'Error A53');
                    }

                    if (strlen($row[3]) > 16 || $this->isThereAny('char', $row[3])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Número de Identificación”.', $fileName, $line, 'Error A54');
                    } else {
                        $errorPaciente = $this->validarPacienteEnUs($row[3], $row[2]);
                        if ($errorPaciente) {
                            $this->pushInconsistencyMessage($errorPaciente, $fileName, $line, 'Error B4');
                        }
                    }

                    if (strlen($row[4]) > 15 || $this->isThereAny('charExclude-', $row[4])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Nro de Autorización”.', $fileName, $line, 'Error A55');
                    }


                    if (strlen($row[5]) > 20 || $this->isThereAny('charExclude-', $row[5])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Código Medicamento”.', $fileName, $line, 'Error A56');
                    } else {
                        if (!Cum::where('cum_validacion', $row[5])->first()) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('El valor registrado en el campo “Código Medicamento” no está en la tabla de cum vigente.', $fileName, $line, 'Error B38');
                        }
                    }
                    if ($row[6] != 1 && $row[6] != 2) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Tipo Medicamento”.', $fileName, $line, 'Error A57');
                    }
                    if ($row[7] == '' || $this->isThereAny('charExclude+', $row[7]) || strlen($row[7]) < 1 || strlen($row[7]) > 30) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Nombre Genérico Medicamento”.', $fileName, $line, 'Error A58');
                    }
                    if ($row[8] == '' || $this->isThereAny('charExclude+', $row[8]) || strlen($row[8]) > 20) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Forma farmacéutica”.', $fileName, $line, 'Error A59');
                    }
                    if ($row[9] == '' || $this->isThereAny('charExclude%', $row[9]) || strlen($row[9]) > 20) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Concentración del Medicamento”', $fileName, $line, 'Error A60');
                    }
                    if ($row[10] == '' || $this->isThereAny('charExclude%', $row[10]) || strlen($row[10]) > 20) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Unidad de la medida”. ', $fileName, $line, 'Error A61');
                    }
                    if ($row[11] == '' || $row[11] == '0' || $this->isThereAny('letter', $row[11]) || $this->isThereAny('char', $row[11])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Numero de unidades”.', $fileName, $line, 'Error A62');
                    } else {
//                        if (intval($row[11]) > 420 || intval($row[11]) < 1) {
//                            $this->pushWarningMessage('El valor registrado en el campo “Número de unidades” es menor o mayor al rango establecido”.', $fileName, $line, 'Alerta B42');
//                        }
                    }
                    if ($row[12] == '' || $row[12] == '0' || $this->isThereAny('letter', $row[12]) || $this->isThereAny('char', $row[12])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Valor unitario”.', $fileName, $line, 'Error A63');
                    } else {
//                        if (intval($row[12]) > 500000 || intval($row[12]) < 5) {
//                            $this->pushWarningMessage('El valor en el campo “Valor unitario” es menor o mayor al rango establecido.”.', $fileName, $line, 'Alerta B43');
//                        }
                    }
                    if ($this->isThereAny('letter', $row[13]) || $this->isThereAny('char', $row[13])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Valor unitario”.', $fileName, $line, 'Error A64');
                    } else {
                        if (intval($row[13]) !== (intval($row[12]) * intval($row[11]))) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('El valor registrado en el campo” Valor total no coincide con la operación matemática de cantidad multiplicada por valor unitario.', $fileName, $line, 'Error C19');
                        }
                    }
                    if ($flagSuccess) {
                        $this->AM['success'][] = $row;
                    }
                    $line++;
                }
            }
        }
    }

    private function checkATFileContent()
    {
        if (isset($this->AT['content'])) {
            $line = 1;
            $fileName = $this->AT['fileName'];
            foreach ($this->AT['content'] as $row) {
                $flagSuccess = 1;
                if (count($this->errorMessages) < 500) {
                    if (!$row[0] || strlen($row[0]) > 20 || $this->isThereAny('charExclude-', $row[0])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Número de la factura”.', $fileName, $line, 'Error A65');
                    }
                    if (strlen($row[1]) != 12 || $this->isThereAny('letter', $row[1]) || $this->isThereAny('char', $row[1])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Código del Prestador”.', $fileName, $line, 'Error A66');
                    } else {
                        if ($this->CT['content'][0][0] != $row[1]) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('El código de habilitación no existe en la red actual', $fileName, $line, 'Error B44');
                        }
                    }
                    if (strlen($row[2]) != 2 || $this->isThereAny('char', $row[2]) || $this->isThereAny('number', $row[2]) || !$this->validarDocumentos($row[2])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Tipo de Identificación”.', $fileName, $line, 'Error A67');
                    }

                    if (strlen($row[3]) > 16 || $this->isThereAny('char', $row[3])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Número de Identificación”.', $fileName, $line, 'Error A68');
                    } else {
                        $errorPaciente = $this->validarPacienteEnUs($row[3], $row[2]);
                        if ($errorPaciente) {
                            $this->pushInconsistencyMessage($errorPaciente, $fileName, $line, 'Error B4');
                        }
                    }

                    if ($row[4] != '') {
                        if (strlen($row[4]) > 15 || $this->isThereAny('charExclude-', $row[4])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Nro de Autorización”.', $fileName, $line, 'Error A42');
                        }
                    }
                    if (($row[5] !== '1' && $row[5] !== '2' && $row[5] !== '3' && $row[5] !== '4') || strlen($row[5]) !== 1) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Tipo de servicio”.', $fileName, $line, 'Error A70');
                    }


                    if ($row[5] == 1) {
                        if ($row[6] == '' || $this->isThereAny('charExclude-', $row[6])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Código del servicio ”.', $fileName, $line, 'Error A71 ');
                        }
                    } else {
                        if ($row[6] == '' || strlen($row[6]) > 20 || $this->isThereAny('charExclude-', $row[6])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Código del servicio ”.', $fileName, $line, 'Error A71 ');
                        } else {
                            if ($row[5] == 2) {
                                if (count(Cup::where('codigo', $row[6])->where('archivo', 'AT')->get()) == 0) {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('El valor registrado en el campo “Tipo de servicio” no corresponde con el código de servicio.', $fileName, $line, 'Error B47');
                                }
                            } elseif ($row[5] == 3) {
                                if (count(Cup::where('codigo', $row[6])->where('archivo', 'AT')->get()) == 0) {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('El valor registrado en el campo “Tipo de servicio” no corresponde con el código de servicio.', $fileName, $line, 'Error B48');
                                }
                                $arrEstanciasUrgencias = ['5DSM01', '5DSA01', '5DS002', '5DS003', '5DS004'];
                                if (array_search($row[6], $arrEstanciasUrgencias) !== false) {
                                    if (isset($this->AU['content'])) {
                                        if (array_search($row[3], array_column($this->AU['content'], 3)) === false) {
                                            $flagSuccess = 0;
                                            $this->pushInconsistencyMessage('El valor registrado en el campo “Código del servicio” requiere que exista un registro en el AU.', $fileName, $line, 'Error C20');
                                        }
                                    } else {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El valor registrado en el campo “Código del servicio” requiere que exista un registro en el AU.', $fileName, $line, 'Error C20');
                                    }

                                }
                            }
                        }
                    }
                    if ($row[7] == '' || $this->isThereAny('charExclude#', $row[7]) || strlen($row[7]) < 1 || strlen($row[7]) > 60) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Nombre del servicio”.', $fileName, $line, 'Error A72');
                    }

                    if ($row[8] == '' || $row[8] == '0' || $this->isThereAny('letter', $row[8]) || $this->isThereAny('char', $row[8]) || strlen($row[8]) < 1 || strlen($row[8]) > 5) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Cantidad”.', $fileName, $line, 'Error A73');
                    } else {
                        if (intval($row[8]) < 1 || intval($row[8]) > 999) {
//                            $this->pushWarningMessage('El valor en el campo “Cantidad” es menor o mayor al rango establecido.”.', $fileName, $line, 'Alerta, B49');
                        }
                    }
                    if ($row[9] == '' || $row[9] == '0' || $this->isThereAny('letter', $row[9]) || $this->isThereAny('char', $row[9])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Valor unitario del material e insumo”.', $fileName, $line, 'Error A74');
                    } else {
                        if (intval($row[9]) < 1 || intval($row[9]) > 500000) {
//                            $this->pushWarningMessage('El valor en el campo “Valor unitario del material e insumo” es menor o mayor al rango establecido.', $fileName, $line, 'Alerta, B50');
                        }
                    }
                    if ($row[10] == "" || $this->isThereAny('letter', $row[10]) || $this->isThereAny('char', $row[10])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Valor total del material e insumo”.', $fileName, $line, 'Error A75');
                    } else {
                        if (intval($row[10]) != (intval($row[9]) * intval($row[8]))) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('El valor registrado en el campo “Valor total del material e insumo” no corresponde con la cantidad multiplicada por valor unitario', $fileName, $line, 'Error C24');
                        }
                    }
                    if ($flagSuccess) {
                        $this->AT['success'][] = $row;
                    }
                    $line++;
                }
            }
        }
    }

    private function checkAUFileContent()
    {
        if (isset($this->AU['content'])) {
            $line = 1;
            $fileName = $this->AU['fileName'];
            foreach ($this->AU['content'] as $index => $row) {
                $flagSuccess = 1;
                if (count($this->errorMessages) < 500) {
                    $patient = null;
                    if (!$row[0] || strlen($row[0]) > 20 || $this->isThereAny('charExclude-', $row[0])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Número de la factura”.', $fileName, $line, 'Error A76');
                    }
                    if (strlen($row[1]) != 12 || $this->isThereAny('letter', $row[1]) || $this->isThereAny('char', $row[1])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Código del Prestador”.', $fileName, $line, 'Error A77');
                    } else {
                        if ($this->CT['content'][0][0] != $row[1]) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('El código de habilitación no existe en la red actual', $fileName, $line, 'Error B51');
                        }
                    }
                    if (strlen($row[2]) != 2 || $this->isThereAny('char', $row[2]) || $this->isThereAny('number', $row[2]) || !$this->validarDocumentos($row[2])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Tipo de Identificación”.', $fileName, $line, 'Error A78');
                    }

                    if (strlen($row[3]) > 16 || $this->isThereAny('char', $row[3])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Número de Identificación”.', $fileName, $line, 'Error A79');
                    } else {
                        $errorPaciente = $this->validarPacienteEnUs($row[3], $row[2]);
                        if ($errorPaciente) {
                            $this->pushInconsistencyMessage($errorPaciente, $fileName, $line, 'Error B4');
                        }
                    }


                    if (!$this->checkValidDateFormat($row[4])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Fecha de procedimiento”.', $fileName, $line, 'Error A80');
                    } else {
                        $fechaArr = explode("/", $row[4]);
                        $fechaString = $fechaArr[2] . '-' . $fechaArr[1] . '-' . $fechaArr[0];
                        if ($fechaString > $this->fechaHasta) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('La fecha registrada el campo Fecha de Ingreso “no puede ser una fecha futura.', $fileName, $line, 'Error B54');
                        }
                    }

                    if (!$this->checkValidHourFormat($row[5])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Hora de ingreso”', $fileName, $line, 'Error A81');
                    }
                    if ($row[6] != '') {
                        if (strlen($row[6]) > 15 || $this->isThereAny('charExclude-', $row[6])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Numero de Autorización”.', $fileName, $line, 'Error A82');
                        }
                    }
                    if (strlen($row[7]) != 2 || $this->isThereAny('char', $row[7]) || $this->isThereAny('letter', $row[7])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Causa externa”', $fileName, $line, 'Error A83');
                    }
                    if (strlen($row[8]) != 4 || $this->isThereAny('char', $row[8])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Diagnóstico a la salida”.', $fileName, $line, 'Error A84');
                    } else {
                        $cie10 = Cie10::where('codigo_cie10', $row[8])->where('estado', 1)->first();
                        if (!$cie10) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnóstico de salida” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'B55');
                        } else {
                            if ($patient) {
                                if ($this->verifyGender($patient, $cie10)) {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnóstico de salida” no es válido para el sexo.', $fileName, $line, 'Error B57');
                                }
                                if ($this->verifyAge($patient, $cie10, $row[4])) {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnóstico de salida” no es válido para la edad. ', $fileName, $line, 'Error B56');
                                }
                            }
                        }
                    }
                    if ($row[9] != '') {
                        if (strlen($row[9]) != 4 || $this->isThereAny('char', $row[9])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Diagnóstico relacionado 1 a la salida”.', $fileName, $line, 'Error A85');
                        } else {
                            $cie10_1 = Cie10::where('codigo_cie10', $row[9])->where('estado', 1)->first();
                            if (!$cie10_1) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnóstico relacionado 1 de salida” no existe en la tabla CIE 10 vigente. ', $fileName, $line, 'Error B59');
                            } else {
                                if ($patient) {
                                    if ($this->verifyGender($patient, $cie10_1)) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 1 de salida” no es válido para el sexo.', $fileName, $line, 'Error B60');
                                    }
                                    if ($this->verifyAge($patient, $cie10_1, $row[4])) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 1 de salida” no es válido para la edad. ', $fileName, $line, 'Error B61');
                                    }
                                }
                            }
                        }
                    }
                    if ($row[10] != '') {
                        if (strlen($row[10]) != 4 || $this->isThereAny('char', $row[10])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Diagnóstico relacionado 2 a la salida”.', $fileName, $line, 'Error A86');
                        } else {
                            $cie10_2 = Cie10::where('codigo_cie10', $row[10])->where('estado', 1)->first();
                            if (!$cie10_2) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 2 de salida” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'Error B62');
                            } else {
                                if ($patient) {
                                    if ($this->verifyGender($patient, $cie10_2)) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 2 de salida” no es válido para el sexo.', $fileName, $line, 'Error B64');
                                    }
                                    if ($this->verifyAge($patient, $cie10_2, $row[4])) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 2 de salida” no es válido para la edad. ', $fileName, $line, 'Error B63');
                                    }
                                }
                            }
                        }
                    }
                    if ($row[11] != '') {
                        if (strlen($row[11]) != 4 || $this->isThereAny('char', $row[11])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Diagnóstico relacionado 3 a la salida”.', $fileName, $line, 'Error A87');
                        } else {
                            $cie10_3 = Cie10::where('codigo_cie10', $row[11])->where('estado', 1)->first();
                            if (!$cie10_3) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 3 de salida” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'Error B65');
                            } else {
                                if ($patient) {
                                    if ($this->verifyGender($patient, $cie10_3)) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 3 de salida” no es válido para el sexo.', $fileName, $line, 'Error B67');
                                    }
                                    if ($this->verifyAge($patient, $cie10_3, $row[4])) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 3 de salida” no es válido para la edad. ', $fileName, $line, 'Error B66');
                                    }
                                }
                            }
                        }
                    }
                    if (!($row[12] >= 1 && $row[12] <= 3)) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Destino del Usuario”.', $fileName, $line, 'Error A88');
                    }
                    if (!($row[13] == 1 || $row[13] == 2)) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Estado a la salida”.', $fileName, $line, 'Error A89');
                    } else {
                        if (intval($row[13]) === 2) {

                            if (strlen($row[14]) != 4 || $this->isThereAny('char', $row[14])) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Causa basica de muerte ”.', $fileName, $line, 'Error A90');
                            } else {
                                if (count(Cie10::where('codigo_cie10', $row[14])->where('estado', 1)->get()) == 0) {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnóstico causa básica de muerte” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'Error B68');
                                } else {
                                    $cie10Muerte = Cie10::where('codigo_cie10', $row[14])->where('estado', 1)->first();
                                    if (!$cie10Muerte->mortalidad) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El valor registrado en el campo de “causa de básica de muerte” no coincide con el campo Estado de salida. ', $fileName, $line, 'Error C32');
                                    }
                                    if ($patient) {
                                        if ($this->verifyGender($patient, $cie10Muerte)) {
                                            $flagSuccess = 0;
                                            $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “causa básica de muerte” no es válido para el sexo.', $fileName, $line, 'Error B70');
                                        }
                                        if ($this->verifyAge($patient, $cie10Muerte, $row[4])) {
                                            $flagSuccess = 0;
                                            $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “causa básica de muerte” no es válido para la edad. ', $fileName, $line, 'Error B69');
                                        }
                                    }
                                }
                            }


                        }
                    }


                    if (!$this->checkValidDateFormat($row[15])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Fecha de salida”.', $fileName, $line, 'Error A91');
                    }
                    if (!$this->checkValidHourFormat($row[16])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Hora de salida observación”.', $fileName, $line, 'Error A92');
                    }

                    if ($this->checkValidHourFormat($row[16]) && $this->checkValidDateFormat($row[15]) && $this->checkValidHourFormat($row[5]) && $this->checkValidDateFormat($row[4])) {
                        $ingreso = \DateTime::createFromFormat("d/m/Y H:i:s", $row[4] . " " . $row[5] . ":00");
                        $salida = \DateTime::createFromFormat("d/m/Y H:i:s", $row[15] . " " . $row[16] . ":00");
                        if ($ingreso <= $salida) {
                            $diff = $ingreso->diff($salida);
                            $horas = (($diff->days * 24) + $diff->h);
                            if ($horas < 1) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('La fecha registrada el campo Fecha de Ingreso “no cumple la cantidad de tiempo permitido entre fecha de ingreso y fecha de egreso.', $fileName, $line, 'Error C28');
                            } elseif ($horas >= 48) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('La fecha registrada el campo Fecha de Ingreso “no cumple la cantidad de tiempo permitido entre fecha de ingreso y fecha de egreso.', $fileName, $line, 'Error C28');
                            }
                        } else {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('La fecha de ingreso no puede ser mayor a la fecha de salida', $fileName, $line, 'Error C');
                        }
                    }

                    $flag2 = 1;
                    $flag3 = 1;
                    $registrosAT = $registros = array_keys(array_column($this->AT['content'], 3), $row[3]);
                    foreach ($registrosAT as $registroAT) {
                        $arrEstanciasUrgencias = ['5DSM01', '5DSA01', '5DS002', '5DS003', '5DS004', '5DSB01'];
                        if (in_array($this->AT['content'][$registroAT][6], $arrEstanciasUrgencias)) {
                            $flag2 = 0;
                        }
                        if (intval($this->AT['content'][$registroAT][5]) === 3) {
                            $flag3 = 0;
                        }
                    }
                    if ($flag2 === 1) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('El valor registrado en el campo “Número de Identificación” no existe en el AT con estancia de urgencias.', $fileName, $line, 'Error C26');
                    }
                    // if ($flag3 === 1) {
                    //     $flagSuccess = 0;
                    //     $this->pushInconsistencyMessage('El valor registrado en el campo “Número de Identificación” no existe en el AT con un tipo de servicio 3.', $fileName, $line, 'Error C27');
                    // }

                    $flag = 1;
                    if (isset($this->AC['content'])) {
                        $codigosUrgencias = [890701, 890702, 890703, 890704, 890735, 890750, 890763, 890780, 890781, 890783, 890793];
                        $registros = array_keys(array_column($this->AC['content'], 3), $row[3]);
                        foreach ($registros as $registro) {
                            if ($this->AC['content'][$registro][0] === $row[0]) {
                                foreach ($codigosUrgencias as $codigo) {
                                    if ($this->AC['content'][$registro][6] == $codigo) {
                                        $flag = 0;
                                    }
                                }
                            }
                        }
                    }
                    if ($flag === 1) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('El valor registrado en el campo “Número de Identificación” no existe en el AC con consulta de urgencias.', $fileName, $line, 'Error C25');
                    }
                    if ($this->checkValidHourFormat($row[16]) && $this->checkValidDateFormat($row[15]) && $this->checkValidDateFormat($row[4]) && $this->checkValidHourFormat($row[5])) {
                        $columnaCedulas = array_keys(array_column($this->AU['content'], 3), $row[3]);
                        if (count($columnaCedulas) > 1) {
                            foreach ($columnaCedulas as $columnaCedula) {
                                if ($columnaCedula !== $index) {
                                    $columnaSecundaria = $this->AU['content'][$columnaCedula];
                                    $arrFechaPrincipalInicial = explode('/', $row[4]);
                                    $arrFechaPrincipalFinal = explode('/', $row[15]);
                                    $fechaPrincipalInicial = new \DateTime($arrFechaPrincipalInicial[2] . '-' . $arrFechaPrincipalInicial[1] . '-' . $arrFechaPrincipalInicial[0] . ' ' . $row[5]);
                                    $fechaPrincipalFinal = new \DateTime($arrFechaPrincipalFinal[2] . '-' . $arrFechaPrincipalFinal[1] . '-' . $arrFechaPrincipalFinal[0] . ' ' . $row[16]);

                                    $arrFechaSecundariaInicial = explode('/', $columnaSecundaria[4]);
                                    $arrFechaSecundariaFinal = explode('/', $columnaSecundaria[15]);
                                    $fechaSecundariaInicial = new \DateTime($arrFechaSecundariaInicial[2] . '-' . $arrFechaSecundariaInicial[1] . '-' . $arrFechaSecundariaInicial[0] . ' ' . $columnaSecundaria[5]);
                                    $fechaSecundariaFinal = new \DateTime($arrFechaSecundariaFinal[2] . '-' . $arrFechaSecundariaFinal[1] . '-' . $arrFechaSecundariaFinal[0] . ' ' . $columnaSecundaria[16]);

                                    if (($fechaSecundariaInicial > $fechaPrincipalInicial && $fechaSecundariaInicial < $fechaPrincipalFinal) || ($fechaSecundariaFinal > $fechaPrincipalInicial && $fechaSecundariaFinal < $fechaPrincipalFinal)) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('Registo AU se encuentra dos o mas veces,la fecha y hora de ingreso he egreso deben tener un orden cronologico en el tiempo', $fileName, $line, 'Error B');
                                    }
                                }
                            }
                        }
                    }

                    if ($flagSuccess) {
                        $this->AU['success'][] = $row;
                    }

                    $line++;
                }
            }
        }
    }

    private function checkAHFileContent()
    {
        if (isset($this->AH['content'])) {
            $fileName = $this->AH['fileName'];
            $line = 1;
            foreach ($this->AH['content'] as $index => $row) {
                $flagSuccess = 1;
                if (count($this->errorMessages) < 500) {
                    $patient = null;
                    if (!$row[0] || strlen($row[0]) > 20 || $this->isThereAny('charExclude-', $row[0])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Número de la factura”.', $fileName, $line, 'Error A93');
                    }
                    if (strlen($row[1]) != 12 || $this->isThereAny('letter', $row[1]) || $this->isThereAny('char', $row[1])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Código del Prestador”.', $fileName, $line, 'Error A94');
                    } else {
                        if ($this->CT['content'][0][0] != $row[1]) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('El código de habilitación no existe en la red actual', $fileName, $line, 'Error B73');
                        }
                    }
                    if (strlen($row[2]) != 2 || $this->isThereAny('char', $row[2]) || $this->isThereAny('number', $row[2]) || !$this->validarDocumentos($row[2])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Tipo de Identificación”.', $fileName, $line, 'Error A95');
                    }

                    if (strlen($row[3]) > 16 || $this->isThereAny('char', $row[3])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Número de Identificación”.', $fileName, $line, 'Error A96');
                    } else {
                        $errorPaciente = $this->validarPacienteEnUs($row[3], $row[2]);
                        if ($errorPaciente) {
                            $this->pushInconsistencyMessage($errorPaciente, $fileName, $line, 'Error B4');
                        }
                    }

                    if (!($row[4] >= 1 && $row[4] <= 4)) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Vía de Ingreso”.', $fileName, $line, 'Error A97');
                    } elseif ($row[4] == 1) {
                        if (isset($this->AU['content'])) {
                            if (!$this->checkTypeAndNumberDocumentIn('AU', $row[2], $row[3])) {
                                if (isset($this->AC['content'])) {
                                    $flag = 1;
                                    if (isset($this->AC['content'])) {
                                        $codigosUrgencias = [890701, 890702, 890703, 890704, 890735, 890750, 890763, 890780, 890781, 890783, 890793];
                                        $registros = array_keys(array_column($this->AC['content'], 3), $row[3]);
                                        foreach ($registros as $registro) {
                                            if ($this->AC['content'][$registro][0] === $row[0]) {
                                                foreach ($codigosUrgencias as $codigo) {
                                                    if ($this->AC['content'][$registro][6] == $codigo) {
                                                        $flag = 0;
                                                    }
                                                }
                                            }
                                        }
                                    }
                                    if ($flag === 1) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('usuario no registra atención de urgencia ni consulta', $fileName, $line, 'Error C');
                                    } elseif (!$this->checkExternalCauseWithTypeAndDocumentIn('AC', $row[2], $row[3], $row[8])) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('la causa externa no coincide con la causa externa en consulta', $fileName, $line, 'Error C');
                                    }
                                } else {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('usuario no registra atencion de urgencia ni consulta', $fileName, $line, 'Error C');
                                }
                            } elseif (!$this->checkExternalCauseWithTypeAndDocumentIn('AU', $row[2], $row[3], $row[8])) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('la causa externa no coincide con la causa externa en urgencia', $fileName, $line, 'Error C');
                            }
                        } elseif (isset($this->AC['content'])) {
                            $flag = 1;
                            if (isset($this->AC['content'])) {
                                $codigosUrgencias = [890701, 890702, 890703, 890704, 890735, 890750, 890763, 890780, 890781, 890783, 890793];
                                $registros = array_keys(array_column($this->AC['content'], 3), $row[3]);
                                foreach ($registros as $registro) {
                                    if ($this->AC['content'][$registro][0] === $row[0]) {
                                        foreach ($codigosUrgencias as $codigo) {
                                            if ($this->AC['content'][$registro][6] == $codigo) {
                                                $flag = 0;
                                            }
                                        }
                                    }
                                }
                            }
                            if ($flag === 1) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('usuario no registra atención de urgencia ni consulta', $fileName, $line, 'Error C');
                            } elseif (!$this->checkExternalCauseWithTypeAndDocumentIn('AC', $row[2], $row[3], $row[8])) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('la causa externa no coincide con la causa externa en hospitalización', $fileName, $line, 'Error C');
                            }
                        } else {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('usuario no registra atención de urgencia ni consulta', $fileName, $line, 'Error C');
                        }
                    } elseif ($row[4] == 2) {
                        if (!$this->checkTypeAndNumberDocumentIn('AC', $row[2], $row[3])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('usuario no registra atención de consulta programada', $fileName, $line, 'Error C');
                        }
                    } elseif ($row[4] == 4) {
                        if (!$this->checkTypeAndNumberDocumentIn('AP', $row[2], $row[3])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('usuario no registra atención de en archivo de procedimientos', $fileName, $line, 'Error C');
                        }
                    }
                    if (!$this->checkValidDateFormat($row[5])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Fecha de Ingreso”.', $fileName, $line, 'Error A98');
                    } elseif (!$this->checkFirstDateIsLessThanSecondDate($row[5], date('d/m/Y'))) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('La fecha registrada el campo Fecha de Ingreso “no puede ser una fecha futura', $fileName, $line, 'Error B76');
                    }
                    if (!$this->checkValidHourFormat($row[6])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Hora de ingreso”.', $fileName, $line, 'Error A99');
                    }
                    if ($row[7] != '') {
                        if (strlen($row[7]) > 15 || $this->isThereAny('char', $row[7])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Numero de Autorización”.', $fileName, $line, 'Error A100');
                        }
                    }
                    if (strlen($row[8]) != 2 || $row[8] < 01 || $row[8] > 15) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Causa externa”.', $fileName, $line, 'Error A101');
                    }
                    if (strlen($row[9]) != 4 || $this->isThereAny('char', $row[9])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Código Diagnostico Principal de Ingreso', $fileName, $line, 'Error A102');
                    } else {
                        if (strtolower(substr($row[9], 0, 1)) === 'z') {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Diagnostico principal de ingreso no puede empezar por la letra "Z".', $fileName, $line, 'Error B');
                        } else {
                            $cie10 = Cie10::where('codigo_cie10', $row[9])->where('estado', 1)->first();
                            if (!$cie10) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnóstico de ingreso” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'Error B77');
                            } else {
                                if ($patient) {
                                    if ($this->verifyGender($patient, $cie10)) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico principal de ingreso” no es válido para el sexo.', $fileName, $line, 'Error B79');
                                    }
                                    if ($this->verifyAge($patient, $cie10, $row[5])) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico principal de ingreso” no es válido para la edad. ', $fileName, $line, 'Error B78');
                                    }
                                }
                            }
                        }
                    }
                    if (strlen($row[10]) != 4 || $this->isThereAny('char', $row[10])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Código de Diagnósticos de egreso”.', $fileName, $line, 'Error A103');
                    } else {
                        if (strtolower(substr($row[10], 0, 1)) === 'z') {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Diagnostico principal de egreso no puede empezar por la letra "Z".', $fileName, $line, 'Error B');
                        } else {
                            $cie10_e = Cie10::where('codigo_cie10', $row[10])->where('estado', 1)->first();
                            if (!$cie10_e) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnóstico de egreso” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'Error B81');
                            } else {
                                if ($patient) {
                                    if ($this->verifyGender($patient, $cie10_e)) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico principal de egreso” no es válido para el sexo.', $fileName, $line, 'Error B83');
                                    }
                                    if ($this->verifyAge($patient, $cie10_e, $row[17])) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico principal de egreso” no es válido para la edad. ', $fileName, $line, 'Error B82');
                                    }
                                }
                            }
                        }
                    }

                    if ($row[11] != '') {
                        if (strlen($row[11]) != 4 || $this->isThereAny('char', $row[11])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Diagnóstico relacionado 1 de egreso”.', $fileName, $line, 'Error A105');
                        } else {
                            if (strtolower(substr($row[11], 0, 1)) === 'z') {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('Diagnóstico relacionado 1 de egreso no puede empezar por la letra "Z".', $fileName, $line, 'Error B');
                            } else {
                                $cie10_e_1 = Cie10::where('codigo_cie10', $row[11])->where('estado', 1)->first();
                                if (!$cie10_e_1) {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnóstico relacionado 1 de egreso” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'Error B85');
                                } else {
                                    if ($patient) {
                                        if ($this->verifyGender($patient, $cie10_e_1)) {
                                            $flagSuccess = 0;
                                            $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 1 de egreso” no es válido para el sexo.', $fileName, $line, 'Error B86');
                                        }
                                        if ($this->verifyAge($patient, $cie10_e_1, $row[17])) {
                                            $flagSuccess = 0;
                                            $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 1 de egreso” no es válido para la edad. ', $fileName, $line, 'Error B87');
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ($row[12] != '') {
                        if (strlen($row[12]) != 4 || $this->isThereAny('char', $row[12])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Diagnóstico relacionado 2 a la salida”.', $fileName, $line, 'Error A106');
                        } else {
                            if (strtolower(substr($row[12], 0, 1)) === 'z') {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('Diagnóstico relacionado 2 de egreso no puede empezar por la letra "Z".', $fileName, $line, 'Error B');
                            } else {
                                $cie10_e_2 = Cie10::where('codigo_cie10', $row[12])->where('estado', 1)->first();
                                if (!$cie10_e_2) {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 2 de egreso” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'Error B88');
                                } else {
                                    if ($patient) {
                                        if ($this->verifyGender($patient, $cie10_e_2)) {
                                            $flagSuccess = 0;
                                            $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 2 de egreso” no es válido para el sexo.', $fileName, $line, 'Error B90');
                                        }
                                        if ($this->verifyAge($patient, $cie10_e_2, $row[17])) {
                                            $flagSuccess = 0;
                                            $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 2 de egreso” no es válido para la edad. ', $fileName, $line, 'Error B89');
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ($row[13] != '') {
                        if (strlen($row[13]) != 4 || $this->isThereAny('char', $row[13])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Diagnóstico relacionado 3 de egreso”.', $fileName, $line, 'Error A107');

                        } else {
                            if (strtolower(substr($row[13], 0, 1)) === 'z') {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('Diagnóstico relacionado 3 de egreso no puede empezar por la letra "Z".', $fileName, $line, 'Error B');
                            } else {
                                $cie10_e_3 = Cie10::where('codigo_cie10', $row[13])->where('estado', 1)->first();
                                if (!$cie10_e_3) {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 3 de egreso” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'Error B91');
                                } else {
                                    if ($patient) {
                                        if ($this->verifyGender($patient, $cie10_e_3)) {
                                            $flagSuccess = 0;
                                            $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 3 de egreso” no es válido para el sexo.', $fileName, $line, 'Error B93');
                                        }
                                        if ($this->verifyAge($patient, $cie10_e_3, $row[17])) {
                                            $flagSuccess = 0;
                                            $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnostico relacionado 3 de egreso” no es válido para la edad.', $fileName, $line, 'Error B92');
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if ($row[14] != '') {
                        if (strlen($row[14]) != 4 || $this->isThereAny('char', $row[14])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Diagnóstico de Complicación”.', $fileName, $line, 'Error A108');
                        } else {
                            if (strtolower(substr($row[14], 0, 1)) === 'z') {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('Diagnóstico de Complicación no puede empezar por la letra "Z".', $fileName, $line, 'Error B');
                            } else {
                                $cie10_c = Cie10::where('codigo_cie10', $row[14])->where('estado', 1)->first();
                                if (!$cie10_c) {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnóstico de Complicación” no existe en la tabla CIE 10 vigente.', $fileName, $line, 'Error B94');
                                } else {
                                    if ($patient) {
                                        if ($this->verifyGender($patient, $cie10_c)) {
                                            $flagSuccess = 0;
                                            $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnóstico de Complicación” no es válido para el sexo.', $fileName, $line, 'Error B96');
                                        }
                                        if ($this->verifyAge($patient, $cie10_c, $row[17])) {
                                            $flagSuccess = 0;
                                            $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnóstico de Complicación” no es válido para la edad.', $fileName, $line, 'Error B95');
                                        }
                                    }
                                }
                            }
                        }
                    }
                    if (!($row[15] == 1 || $row[15] == 2)) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Estado a la salida”.', $fileName, $line, 'Error A109');
                    }
                    if(intval($row[15]) === 1){
                        if($row[16] != ''){
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Si registra 1 en estado de salida (vivo) la causa de muerte debe estar vacia.', $fileName, $line, 'Error A');
                        }
                    }
                    if (intval($row[15]) === 2) {
                        if (strlen($row[16]) != 4 || $this->isThereAny('char', $row[16])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Causa básica de muerte”.', $fileName, $line, 'Error A110');
                        }
                        if (strtolower(substr($row[16], 0, 1)) === 'z') {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('causa de básica de muerte no puede empezar por la letra "Z".', $fileName, $line, 'Error B');
                        } else {
                            $cie10Muerte = Cie10::where('codigo_cie10', $row[16])->where('estado', 1)->first();
                            if ($cie10Muerte) {
                                if (!$cie10Muerte->mortalidad) {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('el valor registrado en el campo de “causa de básica de muerte” no coincide con el campo Estado de salida.', $fileName, $line, 'Error C46');
                                }
                                if ($patient) {
                                    if ($this->verifyGender($patient, $cie10Muerte)) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Dcausa básica de muerte” no es válido para el sexo.', $fileName, $line, 'Error B99');
                                    }
                                    if ($this->verifyAge($patient, $cie10Muerte, $row[17])) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “causa básica de muerte” no es válido para la edad.', $fileName, $line, 'Error B98');
                                    }
                                }
                            } else {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “causa básica de muerte” no existe en la tabla CIE 10 vigente. ', $fileName, $line, 'Error B97');
                            }
                        }
                    }
                    if (!$this->checkValidDateFormat($row[17])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Fecha de salida”.', $fileName, $line, 'Error A111');
                    }

                    if (!$this->checkValidHourFormat($row[18])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Hora de salid observación”', $fileName, $line, 'Error A112');
                    }

                    if ($this->checkValidHourFormat($row[18]) && $this->checkValidDateFormat($row[17]) && $this->checkValidDateFormat($row[5]) && $this->checkValidHourFormat($row[6])) {
                        if ($row[5] != '' && $row[6] != '' && $row[17] != '' && $row[18] != '') {
                            $ingreso = \DateTime::createFromFormat("d/m/Y H:i:s", $row[5] . " " . $row[6] . ":00");
                            $salida = \DateTime::createFromFormat("d/m/Y H:i:s", $row[17] . " " . $row[18] . ":00");
                            if ($ingreso <= $salida) {
                                $diff = $ingreso->diff($salida);
                                $totalHoras = $diff->h + (24 * $diff->days);
                                if ($totalHoras < 6) {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('La fecha registrada el campo Fecha de Ingreso “no cumple la cantidad de tiempo permitido entre fecha de ingreso y fecha de egreso.', $fileName, $line, 'Error C43');
                                }
                            } else {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('La fecha de ingreso no puede ser mayor a la fecha de egreso', $fileName, $line, 'Error C');
                            }
                        }
                    }

                    $flag = 1;
                    if (isset($this->AT['content'])) {
                        $registros = array_keys(array_column($this->AT['content'], 3), $row[3]);
                        foreach ($registros as $registro) {
                            if ($this->AT['content'][$registro][5] == 3) {
                                $cupEstancia = Cup::where('codigo', $this->AT['content'][$registro][6])->first();
                                if ($cupEstancia) {
                                    if ($cupEstancia->estancia == "1") {
                                        $flag = 0;
                                    }
                                }
                            }
                        }
                    }
                    // if ($flag === 1) {
                    //     $flagSuccess = 0;
                    //     $this->pushInconsistencyMessage('El valor registrado en el campo “Número de Identificación” no existe en el AT con un tipo de servicio 3.', $fileName, $line, 'Error C39');
                    // }
                    if ($this->checkValidHourFormat($row[18]) && $this->checkValidDateFormat($row[17]) && $this->checkValidDateFormat($row[5]) && $this->checkValidHourFormat($row[6])) {
                        $columnaCedulas = array_keys(array_column($this->AH['content'], 3), $row[3]);
                        if (count($columnaCedulas) > 1) {
                            foreach ($columnaCedulas as $columnaCedula) {
                                if ($columnaCedula !== $index) {
                                    $columnaSecundaria = $this->AH['content'][$columnaCedula];
                                    $arrFechaPrincipalInicial = explode('/', $row[5]);
                                    $arrFechaPrincipalFinal = explode('/', $row[17]);
                                    $fechaPrincipalInicial = new \DateTime($arrFechaPrincipalInicial[2] . '-' . $arrFechaPrincipalInicial[1] . '-' . $arrFechaPrincipalInicial[0] . ' ' . $row[6]);
                                    $fechaPrincipalFinal = new \DateTime($arrFechaPrincipalFinal[2] . '-' . $arrFechaPrincipalFinal[1] . '-' . $arrFechaPrincipalFinal[0] . ' ' . $row[18]);

                                    $arrFechaSecundariaInicial = explode('/', $columnaSecundaria[5]);
                                    $arrFechaSecundariaFinal = explode('/', $columnaSecundaria[17]);
                                    $fechaSecundariaInicial = new \DateTime($arrFechaSecundariaInicial[2] . '-' . $arrFechaSecundariaInicial[1] . '-' . $arrFechaSecundariaInicial[0] . ' ' . $columnaSecundaria[6]);
                                    $fechaSecundariaFinal = new \DateTime($arrFechaSecundariaFinal[2] . '-' . $arrFechaSecundariaFinal[1] . '-' . $arrFechaSecundariaFinal[0] . ' ' . $columnaSecundaria[18]);

                                    if (($fechaSecundariaInicial >= $fechaPrincipalInicial && $fechaSecundariaInicial <= $fechaPrincipalFinal) || ($fechaSecundariaFinal >= $fechaPrincipalInicial && $fechaSecundariaFinal <= $fechaPrincipalFinal)) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('Registo AH se encuentra dos o mas veces,la fecha y hora de ingreso he egreso deben tener un orden cronologico en el tiempo', $fileName, $line, 'Error B');
                                    }
                                }
                            }
                        }
                    }
                    if ($flagSuccess) {
                        $this->AH['success'][] = $row;
                    }
                    $line++;
                }
            }
        }

    }

    private function checkANFileContent()
    {
        if (isset($this->AN['content'])) {
            $line = 1;
            $fileName = $this->AN['fileName'];
            foreach ($this->AN['content'] as $row) {
                $flagSuccess = 1;
                if (count($this->errorMessages) < 500) {
                    if (!$row[0] || strlen($row[0]) > 20 || $this->isThereAny('charExclude-', $row[0])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Número de la factura”.', $fileName, $line, 'Error A113');
                    }
                    if (strlen($row[1]) != 12 || $this->isThereAny('letter', $row[1]) || $this->isThereAny('char', $row[1])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Código del Prestador”.', $fileName, $line, 'Error A114');
                    } else {
                        if ($this->CT['content'][0][0] != $row[1]) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('El código de habilitación no existe en la red actual', $fileName, $line, 'Error B101');
                        }
                    }
                    if (strlen($row[2]) != 2 || $this->isThereAny('char', $row[2]) || $this->isThereAny('number', $row[2]) || !$this->validarDocumentos($row[2])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Tipo de Identificación”.', $fileName, $line, 'Error A115');
                    }

                    if (strlen($row[3]) > 16 || $this->isThereAny('char', $row[3])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Número de Identificación”.', $fileName, $line, 'Error A116');
                    } else {
                        $errorPaciente = $this->validarPacienteEnUs($row[3], $row[2]);
                        if ($errorPaciente) {
                            $this->pushInconsistencyMessage($errorPaciente, $fileName, $line, 'Error B4');
                        }
                    }

                    if (!$this->checkValidDateFormat($row[4])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Fecha de salida”.', $fileName, $line, 'Error A117');
                    }
                    if (!$this->checkValidHourFormat($row[5])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Hora de nacimiento”.', $fileName, $line, 'Error A118');
                    }
                    if (strlen($row[6]) > 2 || $this->isThereAny('letter', $row[6]) || $this->isThereAny('char', $row[6])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Edad Gestacional”.', $fileName, $line, 'Error A119');
                    } else {
                        if (!($row[6] >= 20 && $row[6] <= 42)) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('La fecha registrada el campo Fecha de Nacimiento del Recién Nacido “no aplica al periodo evaluado.', $fileName, $line, 'Error B105');
                        } else {
                            if ($row[6] <= 37) {
                                //$this->pushWarningMessage('El valor campo “Edad Gestacional “Corresponde a un parto pretérmino.', $fileName, $line, 'Alerta B106');
                            } else {
                                if ($row[9] < 2500) {
                                    //$this->pushWarningMessage('El valor registrado en el campo” Edad Gestacional” corresponde a un bajo peso al nacer.', $fileName, $line, 'Alerta C49');
                                }
                            }
                        }

                    }
                    if (!($row[7] == 1 || $row[7] == 2)) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Control Prenatal”.', $fileName, $line, 'Error A120');
                    }
                    if (!($row[9] >= 1000 && $row[9] <= 5000)) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Peso”.', $fileName, $line, 'Error A121');
                    }
                    if (strlen($row[10]) != 4 || $this->isThereAny('char', $row[10])) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Diagnóstico Recién Nacido”.', $fileName, $line, 'Error A122');
                    } elseif (count(Cie10::where('codigo_cie10', $row[10])->where('estado', 1)->get()) == 0) {
                        $flagSuccess = 0;
                        $this->pushInconsistencyMessage('El Diagnóstico registrado en el campo “Diagnóstico Recién Nacido” no existe en la tabla CIE 10 vigente. ', $fileName, $line, 'Error B107');
                    }

                    if ($row[11] != '') {
                        if (strlen($row[11]) != 4 || $this->isThereAny('char', $row[11])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Causa básica de muerte”.', $fileName, $line, 'Error A121');
                        } else {
                            if (count(Cie10::where('codigo_cie10', $row[11])->where('estado',1)->get()) == 0) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('código diagnóstico causa básica muerte no se encuentra en base de datos', $fileName, $line);
                            } else {
                                if (!$this->checkValidDateFormat($row[12])) {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Fecha de muerte del Recién Nacido', $fileName, $line, 'Error A122');
                                } else {
                                    if (!$this->checkFirstDateIsLessThanSecondDate($row[4], $row[12])) {
                                        $flagSuccess = 0;
                                        $this->pushInconsistencyMessage('El valor registrado en el campo “fecha de muerte” no puede ser menor a la fecha de nacimiento', $fileName, $line, 'Error B');
                                    }
                                    if ($row[9] > 500 || $row[6] >= 22) {
//                                        $this->pushWarningMessage('El registro corresponde a un caso de muerte perinatal.', $fileName, $line, 'Alerta C51');
                                    }
                                }
                                if (!$this->checkValidHourFormat($row[13])) {
                                    $flagSuccess = 0;
                                    $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Hora de muerte”.', $fileName, $line, 'Error A123');
                                }
                            }
                        }
                    }


                    if($row[12] != ''){
                        if($row[11] == '' || $row[13] == ''){
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Si registar Fecha de muerte de registar hora de muerte y causa de muerte', $fileName, $line, 'Error A122');
                        }
                        if (!$this->checkValidDateFormat($row[12])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Fecha de muerte del Recién Nacido', $fileName, $line, 'Error A122');
                        } else {
                            if (!$this->checkFirstDateIsLessThanSecondDate($row[4], $row[12])) {
                                $flagSuccess = 0;
                                $this->pushInconsistencyMessage('El valor registrado en el campo “fecha de muerte” no puede ser menor a la fecha de nacimiento', $fileName, $line, 'Error B');
                            }
                        }
                    }

                    if($row[13] != ''){
                        if($row[11] == '' || $row[12] == ''){
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Si registar hora de muerte de registar fecha de muerte y causa de muerte', $fileName, $line, 'Error A122');
                        }
                        if (!$this->checkValidHourFormat($row[13])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('Existe un valor no permitido en el campo “Hora de muerte”.', $fileName, $line, 'Error A123');
                        }
                    }

                    if($row[4] != '' && $row[12] != ''){
                        if (!$this->checkFirstDateIsLessThanSecondDate($row[4], $row[12])) {
                            $flagSuccess = 0;
                            $this->pushInconsistencyMessage('El valor registrado en el campo “fecha de muerte” no puede ser menor a la fecha de nacimiento', $fileName, $line, 'Error B');
                        }
                    }



                    if ($flagSuccess) {
                        $this->AN['success'][] = $row;
                    }
                    $line++;
                }
            }
        }
    }

    private function findTownshipByDANECode($codeDANE, $department)
    {
        return Municipio::where('codigo_dane', $codeDANE)->where('departamento_id', $department->id)->first();
    }


    private function findDepartmentByDANECode($codeDANE)
    {
        return Departamento::where('codigo_dane', $codeDANE)->first();
    }

    private function checkValidDocumentType($documentType)
    {
        switch ($documentType) {
            case 'CC':
            case 'TI':
            case 'RC':
            case 'CE':
            case 'MS':
            case 'CN':
            case 'PA':
            case 'AS':
            case 'CD':
            case 'SC':
            case 'PE':
                return true;
            default:
                return false;
        }
    }

    private function checkValidDocumentNumberByDocumentType($documentType, $documentNumber)
    {
        switch ($documentType) {
            case 'CC':
                $longitud = [1, 10];
                if ($this->isThereAny('letter', $documentNumber) || $this->isThereAny('char', $documentNumber)) {
                    //$this->pushInconsistencyMessage('número cédula no válido');
                    return false;
                }
                break;
            case 'TI':
                $longitud = [10, 11];
                if ($this->isThereAny('letter', $documentNumber) || $this->isThereAny('char', $documentNumber)) {
                    //$this->pushInconsistencyMessage('número tarjeta de identidad no válido');
                    return false;
                }
                break;
            case 'RC':
                $longitud = [8, 11];
                if ($this->isThereAny('letter', $documentNumber) || $this->isThereAny('char', $documentNumber)) {
                    //$this->pushInconsistencyMessage('número registro civíl no válido');
                    return false;
                }
                break;
            case 'CE':
                $longitud = [3, 6];
                if ($this->isThereAny('char', $documentNumber)) {
                    //$this->pushInconsistencyMessage('número cédula de extrajería no válido');
                    return false;
                }
                break;
            case 'MS':
                $longitud = [9, 12];
                if ($this->isThereAny('letter', $documentNumber) || $this->isThereAny('char', $documentNumber)) {
                    //$this->pushInconsistencyMessage('número documento menor sin identificar no válido');
                    return false;
                }
                break;
            case 'PA':
                $longitud = [5, 16];
                if ($this->isThereAny('char', $documentNumber)) {
                    //$this->pushInconsistencyMessage('número pasaporte no válido');
                    return false;
                }
                break;
            case 'CN':
                $longitud = [6, 100];
                if ($this->isThereAny('char', $documentNumber)) {
                    //$this->pushInconsistencyMessage('número documento CN no válido');
                    return false;
                }
                break;
            case 'NI':
                $longitud = [9, 9];
                if ($this->isThereAny('char', $documentNumber)) {
                    //$this->pushInconsistencyMessage('número documento "NI" no válido');
                    return false;
                }
                break;
            case 'PE':
                $longitud = [3, 15];
                if ($this->isThereAny('letter', $documentNumber) || $this->isThereAny('char', $documentNumber)) {
                    //$this->pushInconsistencyMessage('número documento "PE" no válido');
                    return false;
                }
                break;
            default:
                //$this->pushInconsistencyMessage('tipo de documento no válido');
                return false;
                break;

        }
        if (strlen($documentNumber) >= $longitud[0] && strlen($documentNumber) <= $longitud[1]) {
            return true;
        }
        return false;
    }

    private function findPatientByDocumentNumber($documentNumber)
    {
        return Afiliado::where('numero_documento', $documentNumber)->first();
    }

    private function haveAgeBetween($age, $from, $to)
    {
        if ($from <= $age && $age <= $to) {
            return true;
        }
        return false;
    }

    private function verifyGender($patient, $cie10)
    {
        $result = false;
        if ($cie10->Limitada_Sexo !== "A") {
            switch ($patient->Sexo) {
                case "M":
                    if ($cie10->Limitada_Sexo !== 'H') {
                        $result = true;
                    }
                    break;
                case "F":
                    if ($cie10->Limitada_Sexo !== 'M') {
                        $result = true;
                    }
                    break;
            }
        }
        return $result;
    }

    private function validarDocumentos($tipo)
    {
        $documentos = ['CC', 'CE', 'CD', 'PA', 'PE', 'RC', 'TI', 'CN', 'SC', 'AS', 'MS'];
        if (in_array($tipo, $documentos)) {
            return true;
        }
        return false;
    }

    private function verifyAge($patient, $cie10, $fecha)
    {
        $fechaArr = explode("/", $fecha);
        $fechaString = $fechaArr[2] . '-' . $fechaArr[1] . '-' . $fechaArr[0];
        $fechaPacienteArr = explode("/", substr($patient->Fecha_Naci, 0, 10));
        $fechaStringP = str_replace(' ', '', $fechaPacienteArr[2]) . '-' . $fechaPacienteArr[1] . '-' . (strlen($fechaPacienteArr[0]) === 1 ? '0' . $fechaPacienteArr[0] : $fechaPacienteArr[0]);
        $fechaPaciente = new \DateTime($fechaStringP);
        $fechaFuncion = new \DateTime($fechaString);
        $edadFuncion = $fechaPaciente->diff($fechaFuncion);
        $result = false;
        $limiteInferior = str_split($cie10->Inferior_edad);
        $limiteSuperior = str_split($cie10->Superior_edad);
        if ($limiteInferior[0] !== "0") {
            switch ($limiteInferior[0]) {
                case "4":
                    $anioMinimo = intval($limiteInferior[1] . $limiteInferior[2]);
                    if ($edadFuncion->y < $anioMinimo) {
                        $result = true;
                    }
                    break;
                case "3":
                    $mesMinimo = intval($limiteInferior[1] . $limiteInferior[2]);
                    if ($edadFuncion->y < 1) {
                        if ($edadFuncion->m < $mesMinimo) {
                            $result = true;
                        }
                    }
                    break;
                case "2":
                    $diaMinimo = intval($limiteInferior[1] . $limiteInferior[2]);
                    if ($edadFuncion->y < 1) {
                        if ($edadFuncion->m < 1) {
                            if ($edadFuncion->d < $diaMinimo) {
                                $result = true;
                            }
                        }
                    }
                    break;
                case "1":
                    $horaMinimo = intval($limiteInferior[1] . $limiteInferior[2]);
                    if ($edadFuncion->y < 1) {
                        if ($edadFuncion->m < 1) {
                            if ($edadFuncion->d < 1) {
                                if ($edadFuncion->h < $horaMinimo) {
                                    $result = true;
                                }
                            }
                        }
                    }
                    break;
            }
        }
        if ($limiteSuperior[0] !== "0" && $limiteSuperior[0] !== "5") {
            switch ($limiteSuperior[0]) {
                case "4":
                    $anioMaximo = intval($limiteSuperior[1] . $limiteSuperior[2]);
                    if ($edadFuncion->y > $anioMaximo) {
                        $result = true;
                    }
                    break;
                case "3":
                    $mesMaximo = intval($limiteSuperior[1] . $limiteSuperior[2]);
                    if ($edadFuncion->y > 1) {
                        $result = true;
                    } else {
                        if ($edadFuncion->m > $mesMaximo) {
                            $result = true;
                        }
                    }
                    break;
                case "2":
                    $diaMaximo = intval($limiteSuperior[1] . $limiteSuperior[2]);
                    if ($edadFuncion->y > 1) {
                        $result = true;
                    } else {
                        if ($edadFuncion->m > 1) {
                            $result = true;
                        } else {
                            if ($edadFuncion->d > $diaMaximo) {
                                $result = true;
                            }
                        }
                    }
                    break;
                case "1":
                    $horaMaximo = intval($limiteSuperior[1] . $limiteSuperior[2]);
                    if ($edadFuncion->y > 1) {
                        $result = true;
                    } else {
                        if ($edadFuncion->m > 1) {
                            $result = true;
                        } else {
                            if ($edadFuncion->d > 1) {
                                $result = true;
                            } else {
                                if ($edadFuncion->h > $horaMaximo) {
                                    $result = true;
                                }
                            }
                        }
                    }
                    break;
            }
        }
        return $result;
    }

    private function checkValidHourFormat($item)
    {
        if (count(explode(':', $item)) !== 2) {
            return false;
        }
        list($hour, $minutes) = explode(':', $item);
        if (!isset($hour) || !isset($minutes)) {
            return false;
        }
        if ($hour == '' || $minutes == '') {
            return false;
        }
        if (strlen($hour) != 2 || $hour < 0 || $hour > 23) {
            return false;
        }
        if (strlen($minutes) != 2 || $minutes < 0 && $minutes > 59) {
            return false;
        }

        return true;
    }

    private function checkTypeAndNumberDocumentIn($fileName, $documentType, $documentNumber)
    {
        $fileContent = [];
        switch ($fileName) {
            case 'AC':
                if (isset($this->AC['content'])) {
                    $fileContent = $this->AC['content'];
                }
                break;
            case 'AU':
                if (isset($this->AU['content'])) {
                    $fileContent = $this->AU['content'];
                }
                break;
            case 'AP':
                if (isset($this->AP['content'])) {
                    $fileContent = $this->AP['content'];
                }
                break;
        }
        foreach ($fileContent as $row) {
            if ($row[2] == $documentType && $row[3] == $documentNumber) {
                return true;
            }
        }

        return false;
    }

    private function validarPacienteEnUs($documento, $tipoDocumento)
    {
        $error = null;
        if (isset($this->US['content'])) {
            $key = array_search($documento, array_column($this->US['content'], 1));
            if ($key !== false) {
                $lineaUs = $this->US["content"][$key];
                if ($tipoDocumento !== $lineaUs[0]) {
                    $error = "El campo” Tipo de Identificación “no coincide el registro en el archivo de usuarios (US).";
                }
            } else {
                $error = "El campo ”Número de Identificación“no existe en el archivo de usuarios (US).";
            }
        } else {
            $error = 'El archivo "US" es requerido.';
        }

        return $error;
    }

    public function guardarRipsAc($paquete)
    {
        if (isset($this->AC["content"])) {
            $acs = array_map(
                function ($data) use ($paquete) {
                    $array = [
                        'numero_factura' => $data[0] ?? null,
                        'codigo_prestador' => $data[1] ?? null,
                        'tipo_documento' => $data[2] ?? null,
                        'numero_documento' => $data[3] ?? null,
                        'fecha_consulta' => $data[4] ?? null,
                        'numero_autorizacion' => $data[5] ?? null,
                        'consulta' => $data[6] ?? null,
                        'finalidad_consulta' => $data[7] ?? null,
                        'causa_externa' => $data[8] ?? null,
                        'diagnostico_principal' => $data[9] ?? null,
                        'codigo_relacionado1' => $data[10] ?? null,
                        'codigo_relacionado2' => $data[11] ?? null,
                        'codigo_relacionado2' => $data[12] ?? null,
                        'tipo_diagnostico_principal' => $data[13] ?? null,
                        'valor_consulta' => $data[14] ?? null,
                        'valor_cuota_moderadora' => $data[15] ?? null,
                        'valor_neto_pagar' => $data[16] ?? null,
                        'paquete_rip_id' => $paquete,
                        'af_id' => null,
                        'us_id' => null,
                        'estado_id' => null,
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                    ];
                    return $array;
                },
                $this->AC["content"]
            );
            $chunk_size = floor(2000 / count($acs[0]));
            foreach (array_chunk($acs, $chunk_size) as $chunk) {
                Ac::insert($chunk);
            }
        }
    }

    public function guardarRipsAf($paquete)
    {
        if (isset($this->AF["content"])) {
            $afs = array_map(
                function ($data) use ($paquete) {
                    $array = [
                        "codigo_prestador" => $data[0] ?? null,
                        "nombre_prestador" => $data[1] ?? null,
                        "tipo_identificacion" => $data[2] ?? null,
                        "numero_identificacion" => $data[3] ?? null,
                        "numero_factura" => $data[4] ?? null,
                        "fechaexpedicion_factura" => $data[5] ?? null,
                        "fecha_inicio" => $data[6] ?? null,
                        "fecha_final" => $data[7] ?? null,
                        "codigo_entidad" => $data[8] ?? null,
                        "nombre_admin" => $data[9] ?? null,
                        "numero_contrato" => $data[10] ?? null,
                        "plan_beneficios" => $data[11] ?? null,
                        "numero_poliza" => $data[12] ?? null,
                        "valor_copago" => $data[13] ?? null,
                        "valor_comision" => $data[14] ?? null,
                        "valor_descuento" => $data[15] ?? null,
                        "valor_neto" => $data[16] ?? null,
                        "paquete_rip_id" => $paquete,
                        "user_id" => auth()->id(),
                        "estado_id" => null,
                        "servicio" => null,
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                    ];
                    return $array;
                },
                $this->AF["content"]
            );
            $chunk_size = floor(2000 / count($afs[0]));
            foreach (array_chunk($afs, $chunk_size) as $chunk) {
                Af::insert($chunk);
            }
        }
    }

    public function guardarRipsCt($paquete)
    {
        if (isset($this->CT["content"])) {
            $cts = array_map(
                function ($data) use ($paquete) {
                    $array = [
                        "codigo_prestador" => $data[0] ?? null,
                        "fecha_radicado" => $data[1] ?? null,
                        "nombre_archivo" => $data[2] ?? null,
                        "catidad_registros" => $data[3] ?? null,
                        "paquete_rip_id" => $paquete,
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                    ];
                    return $array;
                },
                $this->CT["content"]
            );

            $chunk_size = floor(2000 / count($cts[0]));
            foreach (array_chunk($cts, $chunk_size) as $chunk) {
                Ct::insert($chunk);
            }
        }
    }

    public function guardarRipsUs($paquete)
    {
        if (isset($this->US["content"])) {
            $us = array_map(
                function ($data) use ($paquete) {
                    $array = [
                        "tipo_documento" => $data[0] ?? null,
                        "numero_documento" => $data[1] ?? null,
                        "codigo_admin" => $data[2] ?? null,
                        "tipo_usuario" => $data[3] ?? null,
                        "primer_apellido" => $data[4] ?? null,
                        "segundo_apellido" => $data[5] ?? null,
                        "primer_nombre" => $data[6] ?? null,
                        "segundo_nombre" => $data[7] ?? null,
                        "edad" => $data[8] ?? null,
                        "unidad_mediad" => $data[9] ?? null,
                        "sexo" => $data[10] ?? null,
                        "codigo_departamento_residencia" => $data[11] ?? null,
                        "codigo_municipio_residencia" => $data[12] ?? null,
                        "zona_residencia" => $data[13] ?? null,
                        "paquete_rip_id" => $paquete,
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                    ];
                    return $array;
                },
                $this->US["content"]
            );
            $chunk_size = floor(2000 / count($us[0]));
            foreach (array_chunk($us, $chunk_size) as $chunk) {
                Us::insert($chunk);
            }
        }
    }

    public function guardarRipsAp($paquete)
    {
        if (isset($this->AP["content"])) {
            $aps = array_map(
                function ($data) use ($paquete) {
                    $array = [
                        "numero_factura" => $data[0] ?? null,
                        "codigo_prestador" => $data[1] ?? null,
                        "tipo_documento" => $data[2] ?? null,
                        "numero_documento" => $data[3] ?? null,
                        "fecha_procedimiento" => $data[4] ?? null,
                        "numero_autorizacion" => $data[5] ?? null,
                        "procedimiento" => $data[6] ?? null,
                        "ambito_procedimiento" => $data[7] ?? null,
                        "finalidad_procedimiento" => $data[8] ?? null,
                        "personal_atiende" => $data[9] ?? null,
                        "diagnostico_primario" => $data[10] ?? null,
                        "diagnostico_relacionado" => $data[11] ?? null,
                        "complicacion" => $data[12] ?? null,
                        "acto_quirurgico" => $data[13] ?? null,
                        "valor_procedimiento" => $data[14] ?? null,
                        "paquete_rip_id" => $paquete,
                        "af_id" => null,
                        "us_id" => null,
                        "codigo_procedimiento" => null,
                        "diagnostico_primario" => null,
                        "estado_id" => null,
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                    ];
                    return $array;
                },
                $this->AP["content"]
            );

            $chunk_size = floor(2000 / count($aps[0]));
            foreach (array_chunk($aps, $chunk_size) as $chunk) {
                Ap::insert($chunk);
            }
        }
    }

    public function guardarRipsAn($paquete)
    {
        if (isset($this->AN["content"])) {
            $ans = array_map(
                function ($data) use ($paquete) {
                    $array = [
                        "numero_factura" => $data[0] ?? null,
                        "codigo_prestador" => $data[1] ?? null,
                        "tipo_documento" => $data[2] ?? null,
                        "numero_documento" => $data[3] ?? null,
                        "fecha_nacimiento" => $data[4] ?? null,
                        "hora_nacimiento" => $data[5] ?? null,
                        "edad_gestional" => $data[6] ?? null,
                        "gestion_prenatal" => $data[7] ?? null,
                        "sexo" => $data[8] ?? null,
                        "peso" => $data[9] ?? null,
                        "diagnostico_recien_nacido" => $data[10] ?? null,
                        "causa_muerte" => $data[11] ?? null,
                        "fecha_muerte" => $data[12] ?? null,
                        "hora_muerte" => $data[13] ?? null,
                        "paquete_rip_id" => $paquete,
                        // "Af_id" => null,
                        // "Us_id" => null,
                        "cie10_id" => null,
                        "documento_an" => null,
                        "tipo_an" => null,
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                    ];
                    return $array;
                },
                $this->AN["content"]
            );
            $chunk_size = floor(2000 / count($ans[0]));
            foreach (array_chunk($ans, $chunk_size) as $chunk) {
                An::insert($chunk);
            }
        }
    }

    public function guardarRipsAh($paquete)
    {
        if (isset($this->AH["content"])) {
            $ahs = array_map(
                function ($data) use ($paquete) {
                    $array = [
                        "numero_factura" => $data[0] ?? null,
                        "codigo_prestador" => $data[1] ?? null,
                        "tipo_documento" => $data[2] ?? null,
                        "numero_documento" => $data[3] ?? null,
                        "via_ingreso" => $data[4] ?? null,
                        "fecha_ingreso" => $data[5] ?? null,
                        "hora_ingreso" => $data[6] ?? null,
                        "numero_autorizacion" => $data[7] ?? null,
                        "causa_externa" => $data[8] ?? null,
                        "diagnostico_principal_ingreso" => $data[9] ?? null,
                        "diagnostico_principal_egreso" => $data[10] ?? null,
                        "diagnaostico_relacionado_1" => $data[11] ?? null,
                        "diagnaostico_relacionado_2" => $data[12] ?? null,
                        "diagnaostico_relacionado_3" => $data[13] ?? null,
                        "diagnostico_complicacion" => $data[14] ?? null,
                        "estado_salida" => $data[15] ?? null,
                        "diagnostico_causa_muerte" => $data[16] ?? null,
                        "fecha_egreso" => $data[17] ?? null,
                        "hora_egreso" => $data[18] ?? null,
                        "paquete_rip_id" => $paquete,
                        "af_id" => null,
                        "us_id" => null,
                        "diagnostico_ingreso" => null,
                        "diagnostico_egreso" => null,
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                    ];
                    return $array;
                },
                $this->AH["content"]
            );

            $chunk_size = floor(2000 / count($ahs[0]));
            foreach (array_chunk($ahs, $chunk_size) as $chunk) {
                Ah::insert($chunk);
            }
        }
    }

    public function guardarRipsAu($paquete)
    {
        if (isset($this->AU["content"])) {
            $aus = array_map(
                function ($data) use ($paquete) {
                    $array = [
                        "numero_factura" => $data[0] ?? null,
                        "codigo_prestador" => $data[1] ?? null,
                        "tipo_documento" => $data[2] ?? null,
                        "numero_documento" => $data[3] ?? null,
                        "fecha_ingreso" => $data[4] ?? null,
                        "hora_ingreso" => $data[5] ?? null,
                        "numero_autorizacion" => $data[6] ?? null,
                        "causa_externa" => $data[7] ?? null,
                        "diagnostico_principal_salida" => $data[8] ?? null,
                        "diagnostico_relacion_salida1" => $data[9] ?? null,
                        "diagnostico_relacion_salida2" => $data[10] ?? null,
                        "diagnostico_relacion_salida3" => $data[11] ?? null,
                        "destino_usuario_salida" => $data[12] ?? null,
                        "estado_salida" => $data[13] ?? null,
                        "causa_basica_muerte" => $data[14] ?? null,
                        "fecha_salida_usuario" => $data[15] ?? null,
                        "hora_salida_usuario" => $data[16] ?? null,
                        "paquete_rip_id" => $paquete,
                        "af_id" => null,
                        "us_id" => null,
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                    ];
                    return $array;
                },
                $this->AU["content"]
            );
            $chunk_size = floor(2000 / count($aus[0]));
            foreach (array_chunk($aus, $chunk_size) as $chunk) {
                Au::insert($chunk);
            }
        }
    }

    public function guardarRipsAt($paquete)
    {
        if (isset($this->AT["content"])) {
            $ats = array_map(
                function ($data) use ($paquete) {
                    $array = [
                        "numero_factura" => $data[0] ?? null,
                        "codigo_prestador" => $data[1] ?? null,
                        "tipo_documento" => $data[2] ?? null,
                        "numero_documento" => $data[3] ?? null,
                        "numero_autorizacion" => $data[4] ?? null,
                        "tipo_servicio" => $data[5] ?? null,
                        "codigo_servicio" => $data[6] ?? null,
                        "nombre_servicio" => $data[7] ?? null,
                        "cantidad" => $data[8] ?? null,
                        "valor_unitario" => $data[9] ?? null,
                        "valor_total" => $data[10] ?? null,
                        "paquete_rip_id" => $paquete,
                        "af_id" => null,
                        "us_id" => null,
                        "estado_id" => null,
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                    ];
                    return $array;
                },
                $this->AT["content"]
            );
            $chunk_size = floor(2000 / count($ats[0]));
            foreach (array_chunk($ats, $chunk_size) as $chunk) {
                At::insert($chunk);
            }
        }
    }

    public function guardarRipsAm($paquete)
    {
        if (isset($this->AM["content"])) {
            $ams = array_map(
                function ($data) use ($paquete) {
                    $array = [
                        "numero_factura" => $data[0] ?? null,
                        "codigo_prestador" => $data[1] ?? null,
                        "tipo_documento" => $data[2] ?? null,
                        "numero_documento" => $data[3] ?? null,
                        "numero_autorizacion" => $data[4] ?? null,
                        "codigo_medicamento" => $data[5] ?? null,
                        "tipo_medicamento" => $data[6] ?? null,
                        "nombre_generico" => $data[7] ?? null,
                        "forma_farmaceutica" => $data[8] ?? null,
                        "concentracion_medicamento" => $data[9] ?? null,
                        "unidad_medida" => $data[10] ?? null,
                        "numero_unidades" => $data[11] ?? null,
                        "valor_unitario_medicamento" => $data[12] ?? null,
                        "valor_total_medicamento" => $data[13] ?? null,
                        "paquete_rip_id" => $paquete,
                        "af_id" => null,
                        "us_id" => null,
                        "cum_id" => null,
                        "estado_id" => null,
                        "created_at" => date("Y-m-d H:i:s"),
                        "updated_at" => date("Y-m-d H:i:s"),
                    ];
                    return $array;
                },
                $this->AM["content"]
            );
            $chunk_size = floor(2000 / count($ams[0]));
            foreach (array_chunk($ams, $chunk_size) as $chunk) {
                Am::insert($chunk);
            }
        }
    }

    private function pushWarningMessage($msg, $fileName = '', $line = '', $code = '')
    {
        if (count($this->waningMessages) < 15000) {
            if ($line != '' && $fileName != '') {
                array_push($this->waningMessages, 'En la linea ' . $line . ' del archivo "' . $fileName . '" ' . $msg . '');
                if ($code != '') {
                    array_push($this->waningMessages, 'En la linea ' . $line . ' del archivo "' . $fileName . '" ' . $msg . ' (' . $code . ')');
                } else {
                    array_push($this->waningMessages, 'En la linea ' . $line . ' del archivo "' . $fileName . '" ' . $msg);
                }
            } else {
                array_push($this->waningMessages, $msg);
            }
        }

    }

    private function checkExternalCauseWithTypeAndDocumentIn($fileName, $documentType, $documentNumber, $externalCause)
    {
        switch ($fileName) {
            case 'AC':
                foreach ($this->AC['content'] as $registro) {
                    if ($registro[2] == $documentType && $registro[3] == $documentNumber && $registro[8] == $externalCause) {
                        return true;
                    }
                }
                break;
            case 'AU':
                foreach ($this->AU['content'] as $registro) {
                    if ($registro[2] == $documentType && $registro[3] == $documentNumber && $registro[7] == $externalCause) {
                        return true;
                    }
                }
                break;
            default:
                # code...
                break;
        }
    }

    private function checkBillNumberOfServiceFilesInAF()
    {
        $this->checkBillNumberOfANFileInAF();
        $this->checkBillNumberOfAHFileInAF();
        $this->checkBillNumberOfAUFileInAF();
        $this->checkBillNumberOfATFileInAF();
        $this->checkBillNumberOfAMFileInAF();
        $this->checkBillNumberOfAPFileInAF();
        $this->checkBillNumberOfACFileInAF();
    }

    private function checkBillNumberOfANFileInAF()
    {
        if (isset($this->AN['content'])) {
            $line = 1;
            $fileName = $this->AN['fileName'];
            foreach ($this->AN['content'] as $row) {

                $isBillNumber = $this->checkBillNumberInAF($row[0]);

                if (!$isBillNumber) {
                    $this->pushInconsistencyMessage('factura ' . $row[0] . ' no fue encontrada en el archivo AF', $fileName, $line, 'Error A');
                }
                $line++;
            }
        }
    }

    private function checkBillNumberInAF($billNumber)
    {
        foreach ($this->AF['content'] as $afRow) {
            if ($billNumber == $afRow[4]) {
                return true;
            }
        }
        return false;
    }

    private function checkBillNumberOfAHFileInAF()
    {
        if (isset($this->AH['content'])) {
            $line = 1;
            $fileName = $this->AH['fileName'];
            foreach ($this->AH['content'] as $row) {

                $isBillNumber = $this->checkBillNumberInAF($row[0]);

                if (!$isBillNumber) {
                    $this->pushInconsistencyMessage('factura ' . $row[0] . ' no fue encontrada en el archivo AF', $fileName, $line, 'Error A');
                }
            }
        }
    }

    private function checkBillNumberOfAUFileInAF()
    {
        if (isset($this->AU['content'])) {
            $line = 1;
            $fileName = $this->AU['fileName'];
            foreach ($this->AU['content'] as $row) {

                $isBillNumber = $this->checkBillNumberInAF($row[0]);

                if (!$isBillNumber) {
                    $this->pushInconsistencyMessage('factura ' . $row[0] . ' no fue encontrada en el archivo AF', $fileName, $line, 'Error A');
                }
            }
        }
    }

    private function checkBillNumberOfATFileInAF()
    {
        if (isset($this->AT['content'])) {
            $line = 1;
            $fileName = $this->AT['fileName'];
            foreach ($this->AT['content'] as $row) {

                $isBillNumber = $this->checkBillNumberInAF($row[0]);

                if (!$isBillNumber) {
                    $this->pushInconsistencyMessage('factura ' . $row[0] . ' no fue encontrada en el archivo AF', $fileName, $line, 'Error A');
                }
            }
        }
    }

    private function checkBillNumberOfAMFileInAF()
    {
        if (isset($this->AM['content'])) {
            $line = 1;
            $fileName = $this->AM['fileName'];
            foreach ($this->AM['content'] as $row) {

                $isBillNumber = $this->checkBillNumberInAF($row[0]);

                if (!$isBillNumber) {
                    $this->pushInconsistencyMessage('factura ' . $row[0] . ' no fue encontrada en el archivo AF', $fileName, $line, 'Error A');
                }
            }
        }
    }

    private function checkBillNumberOfAPFileInAF()
    {
        if (isset($this->AP['content'])) {
            $line = 1;
            $fileName = $this->AP['fileName'];
            foreach ($this->AP['content'] as $row) {

                $isBillNumber = $this->checkBillNumberInAF($row[0]);

                if (!$isBillNumber) {
                    $this->pushInconsistencyMessage('factura ' . $row[0] . ' no fue encontrada en el archivo AF', $fileName, $line, 'Error C');
                }
            }
        }
    }

    private function checkBillNumberOfACFileInAF()
    {
        if (isset($this->AC['content'])) {
            $line = 1;
            $fileName = $this->AC['fileName'];
            foreach ($this->AC['content'] as $row) {

                $isBillNumber = $this->checkBillNumberInAF($row[0]);

                if (!$isBillNumber) {
                    $this->pushInconsistencyMessage('factura ' . $row[0] . ' no fue encontrada en el archivo AF', $fileName, $line, 'Error C');
                }
            }
        }
    }

    private function checkServiceValueSumatoryInAF()
    {
        $line = 1;
        $fileName = $this->AF['fileName'];
        foreach ($this->AF['content'] as $row) {
            $value = 0;
            $value += $this->getACServiceValueSumatoryByBillNumber($row[4]);
            $value += $this->getAPServiceValueSumatoryByBillNumber($row[4]);
            $value += $this->getAMServiceValueSumatoryByBillNumber($row[4]);
            $value += $this->getATServiceValueSumatoryByBillNumber($row[4]);

            if ($this->prestador->Tipo == 1) {
                if ($value == 0) {
                    $this->pushInconsistencyMessage('el número de factura no tiene servicios relacionados', $fileName, $line, 'Error C');
                } elseif ($row[16] != $value) {
                    if ($this->prestador->capitado != 1) {
                        $this->pushInconsistencyMessage('hay diferencia en sumatoria de valores en los servicios prestados', $fileName, $line, 'Error C');
                    }
                }
            }
            $line++;
        }
    }

    private function getACServiceValueSumatoryByBillNumber($billNumber)
    {
        $value = 0;
        if (isset($this->AC['content'])) {
            foreach ($this->AC['content'] as $row) {
                if ($row[0] == $billNumber) {
                    $value += $row[16];
                }
            }
        }
        return $value;
    }

    private function getAPServiceValueSumatoryByBillNumber($billNumber)
    {
        $value = 0;
        if (isset($this->AP['content'])) {
            foreach ($this->AP['content'] as $row) {
                if ($row[0] == $billNumber) {
                    $value += $row[14];
                }
            }
        }
        return $value;
    }

    private function getAMServiceValueSumatoryByBillNumber($billNumber)
    {
        $value = 0;
        if (isset($this->AM['content'])) {
            foreach ($this->AM['content'] as $row) {
                if ($row[0] == $billNumber) {
                    $value += $row[13];
                }
            }
        }
        return $value;
    }

    private function getATServiceValueSumatoryByBillNumber($billNumber)
    {
        $value = 0;
        if (isset($this->AT['content'])) {
            foreach ($this->AT['content'] as $row) {
                if ($row[0] == $billNumber) {
                    $value += $row[10];
                }
            }
        }
        return $value;
    }

    private function areThereAnyInconsistencyMessages()
    {
        if (count($this->errorMessages) == 0) {
            return false;
        }
        return true;
    }
}
