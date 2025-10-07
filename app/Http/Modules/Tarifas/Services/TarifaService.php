<?php

namespace App\Http\Modules\Tarifas\Services;

use App\Http\Modules\CumTarifaContratos\Models\cum_tarifa_contrato;
use App\Http\Modules\Ambitos\Models\Ambito;
use App\Http\Modules\CodigoPropios\Models\CodigoPropio;
use App\Http\Modules\CumTarifaContratos\Models\diagnostico_tarifa_contrato;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\CupTarifas\Models\CupTarifa;
use App\Http\Modules\Familias\Models\Familia;
use App\Http\Modules\Homologo\Models\Homologo;
use App\Http\Modules\PaqueteServicios\Models\PaqueteServicio;
use App\Http\Modules\Tarifas\Models\Tarifa;
use App\Http\Modules\Tarifas\Repositories\TarifaRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Traits\ArchivosTrait;
use Maatwebsite\Excel\Facades\Excel;
use Rap2hpoutre\FastExcel\FastExcel;

class TarifaService
{
    private $model;
    use ArchivosTrait;

    public function __construct()
    {
        $this->model = new Tarifa();
    }

    public function capitado($tarifa, $data)
    {
        // Calcular el valor de la capita
        $valor = ($tarifa->valor / $tarifa->cantiad_personas);

        if ($data->cup_id != null) {
            CupTarifa::create([
                'tarifa_id' => $tarifa->id,
                'cup_id' => $data->cup_id,
                'valor' => $valor,
                'user_id' => Auth::id()
            ]);
        } else {
            // Obtener todos los cups asociados a la familia
            $cups = Familia::select('cups.id as cup_id')
                ->join('cup_familia', 'cup_familia.familia_id', 'familias.id')
                ->join('cups', 'cups.id', 'cup_familia.cup_id')
                ->where('familias.id', $data->familia_id)
                ->get();

            // Crear un registro CupTarifa para cada cup de la familia
            foreach ($cups as $cup) {
                CupTarifa::create([
                    'tarifa_id' => $tarifa->id,
                    'cup_id' => $cup['cup_id'],
                    'valor' => $valor,
                    'user_id' => Auth::id()
                ]);
            }
        }

        return true;
    }


    public function evento($tarifa, $data)
    {
        if ($data->cup_id != null) {
            // Crear un registro CupTarifa para un cup específico
            CupTarifa::create([
                'tarifa_id' => $tarifa->id,
                'cup_id' => $data->cup_id,
                'valor' => 0,
                'user_id' => Auth::id()
            ]);
        } else {
            // Obtener todos los cups asociados a la familia
            $cups = Familia::select('cups.id as cup_id')
                ->join('cup_familia', 'cup_familia.familia_id', 'familias.id')
                ->join('cups', 'cups.id', 'cup_familia.cup_id')
                ->where('familias.id', $data->familia_id)
                ->get();

            // Crear un registro CupTarifa para cada cup de la familia
            foreach ($cups as $cup) {
                CupTarifa::create([
                    'tarifa_id' => $tarifa->id,
                    'cup_id' => $cup['cup_id'],
                    'valor' => 0,
                    'user_id' => Auth::id()
                ]);
            }
        }

        return true;
    }

    public function agregarCupsTarifa($data, $tarifa_id)
    {

        // Encontrar la tarifa por ID
        $tarifa = Tarifa::find($tarifa_id);

        // Verificar si la tarifa existe
        if (!$tarifa) {
            throw new \Exception('Tarifa no encontrada', 404);
        }

        // Determinar el valor a insertar basado en el manual tarifario
        $valor = 0; // Valor predeterminado

        switch ($tarifa->manual_tarifario_id) {
            case 4:
            case 5:
                $valor = ((int) $tarifa->valor / (int) $tarifa->cantiad_personas);
                break;
            case 6:
                $valor = 0; // Valor específico para manual tarifario 6
                break;
            case 1:
            case 2:
            case 3:
                $homologo = Homologo::select('valor')
                    ->where('cup_codigo', $data['cup_id'])
                    ->where('tipo_manual_id', $tarifa->manual_tarifario_id)
                    ->first();

                if ($homologo) {
                    $valor = $tarifa->pleno ? (int) $homologo->valor : (int) $homologo->valor * ((int) $tarifa->valor / 100);
                } else {
                    $valor = 0;
                }
                break;
            default:
                throw new \Exception('Manual tarifario no válido', 400);
        }

        // Verificar si ya existe el registro antes de insertar
        $exists = CupTarifa::where('tarifa_id', $tarifa_id)
            ->where('cup_id', $data['cup_id'])
            ->exists();

        if ($exists) {
            throw new \Exception('El CUPS ya existe en esta tarifa', 409);
        }

        // Crear el registro
        $cupTarifa = CupTarifa::create([
            'tarifa_id' => $tarifa_id,
            'cup_id' => $data['cup_id'],
            'valor' => $valor,
            'user_id' => Auth::id()
        ]);

        return $cupTarifa;
    }

    
    public function cargarMultipleTarifas($file)
    {
        // Importamos los datos del archivo Excel utilizando FastExcel
        $excel = (new FastExcel)->import($file->getRealPath());
    
        // Inicializamos variables para recopilar errores y datos a insertar
        $errores = []; // Lista para almacenar los mensajes de errores
        $cupsConErrores = []; // Datos para generar el Excel de errores
        $cupsValidos = []; // Datos válidos a insertar en CupTarifa
        $codigoPropioValidos = []; // Datos válidos de código propio
        $paqueteValidos = []; // Datos válidos de paquetes
        $cupsProcesadosPorTarifa = []; // Para evitar procesar duplicados por tarifa
        $i = 2; // Contador de líneas, asumiendo que la primera es el encabezado
    
        // Función para agregar errores
        $agregarError = function ($codigo, $linea, $mensaje, &$row) use (&$errores, &$cupsConErrores) {
            $errores[] = "Línea $linea: $mensaje";
            $row['errors'] = $mensaje;
            $cupsConErrores[] = $row;
        };
    
        // Recorremos cada fila del Excel
        foreach ($excel as $linea => $row) {
            $tarifa = Tarifa::find($row['tarifa']);
            
            // Verificación de tarifa existente
            if (!$tarifa) {
                $mensaje = "La tarifa con ID " . $row['tarifa'] . " no existe, por favor revisar.";
                $agregarError(null, $linea + 2, $mensaje, $row);
                continue;
            }
    
            // Obtenemos y validamos el código CUPS
            $codigo = str_pad(strval($row['codigo']), 6, '0', STR_PAD_LEFT);
    
            // Inicializamos el array para esta tarifa si no existe
            if (!isset($cupsProcesadosPorTarifa[$tarifa->id])) {
                $cupsProcesadosPorTarifa[$tarifa->id] = [];
            }
    
            // Verificamos si el código ya fue procesado para esta tarifa
            if (isset($cupsProcesadosPorTarifa[$tarifa->id][$codigo])) {
                $mensaje = "El código CUPS $codigo está duplicado para la tarifa ID " . $tarifa->id . ". Solo se procesó la primera aparición.";
                $agregarError($codigo, $linea + 2, $mensaje, $row);
                continue;
            }
    
            // Marcamos este código como procesado para esta tarifa
            $cupsProcesadosPorTarifa[$tarifa->id][$codigo] = true;
    
            // Validamos que el código no tenga más de 8 dígitos
            if (strlen($codigo) > 8) {
                $mensaje = "El código $codigo tiene más de 8 dígitos y debe ser menor o igual a 8 dígitos.";
                $agregarError($codigo, $linea + 2, $mensaje, $row);
                continue;
            }
    
            // Buscamos el CUPS, Código Propio o Paquete en la base de datos
            $cup = Cup::where('codigo', $codigo)->first();
            $codigoPropio = CodigoPropio::where('codigo', $codigo)->first();
            $paquete = PaqueteServicio::where('codigo', $codigo)->first();
    
            // Si no se encuentra en ninguna de las tablas
            if (!$cup && !$codigoPropio && !$paquete) {
                $mensaje = "El CUPS / CÓDIGO PROPIO / PAQUETE con código $codigo no se encuentra en la base de datos.";
                $agregarError($codigo, $linea + 2, $mensaje, $row);
                continue;
            }
    
            // Si es válido, agregamos a su respectivo array para inserción
            if ($cup) {
                         // Verificamos si este cup ya está en otra tarifa similar para la misma sede
                $buscarTarifas = $this->model->select('cup_tarifas.id')
                ->join('cup_tarifas', 'cup_tarifas.tarifa_id', 'tarifas.id')
                ->where('rep_id', $tarifa->rep_id)
                ->where('contrato_id', $tarifa->contrato_id)
                ->where('cup_id', $cup->id)
                ->whereIn('manual_tarifario_id', [1, 2, 3, 6])
                ->get();
                if ($buscarTarifas->isNotEmpty()) {
                    foreach ($buscarTarifas as $bucarTarifa){
                        // Eliminar registros de la tabla intermedia cup_tarifa
                        CupTarifa::where('id', $bucarTarifa['id'])->delete();
                    }
                    $mensaje = "El CUPS con código $codigo ya está cargado en otra tarifa de la misma sede.";
                    $agregarError($codigo, $linea + 2, $mensaje, $row);
                }
                $cupsValidos[] = [
                    'tarifa_id' => $tarifa->id,
                    'cup_id' => $cup->id,
                    'valor' => $this->calcularValor($tarifa, $cup, $row),
                    'user_id' => Auth::id(),
                ];
            } elseif ($codigoPropio) {
                $codigoPropioValidos[] = [
                    'tarifa_id' => $tarifa->id,
                    'codigo_propio_id' => $codigoPropio->id,
                    'valor' => is_numeric($row['valor']) ? (float) $row['valor'] : 0,
                    'user_id' => Auth::id(),
                ];
            } else {
                $paqueteValidos[] = [
                    'tarifa_id' => $tarifa->id,
                    'paquete_id' => $paquete->id,
                    'valor' => is_numeric($row['valor']) ? (float) $row['valor'] : 0,
                    'user_id' => Auth::id(),
                ];
            }
    
            $i++;
        }
    
        // Realizamos las inserciones masivas para los registros válidos
        if (!empty($cupsValidos)) {
            $this->insertarEnLotes($cupsValidos, new CupTarifa()); // Inserción masiva de cups
        }
    
        if (!empty($codigoPropioValidos)) {
            $this->insertarEnLotes($codigoPropioValidos, $tarifa, 'propio'); // Inserción masiva de códigos propios
        }
    
        if (!empty($paqueteValidos)) {
            $this->insertarEnLotes($paqueteValidos, $tarifa, 'paqueteServicio'); // Inserción masiva de paquetes
        }
    
        // Si hay errores, generamos el archivo Excel con los registros erróneos
        if (count($errores) > 0) {
            $excelEnBase64 = $this->generarExcelBase64($cupsConErrores);
    
            // Preparamos la respuesta con los errores y el archivo Excel
            $response = [
                'errores' => $errores,
                'excel' => [
                    'archivo' => $excelEnBase64,
                    'nombre' => "errores.xlsx",
                    'extension' => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                ],
            ];
    
            // Lanzamos una excepción con los detalles
            throw new \Exception(json_encode($response), 422);
        }
    
        // Retornamos un mensaje de éxito si no hubo errores
        return ['mensaje' => 'Códigos cargados correctamente'];
    }
    


    public function cargar($file, int $tarifa_id)
    {
        // Importamos los datos del archivo Excel utilizando FastExcel
        $excel = (new FastExcel)->import($file->getRealPath());

        // Inicializamos variables para recopilar errores y datos a insertar
        $errores = []; // Lista para almacenar los mensajes de errores
        $cupsConErrores = []; // Datos para generar el Excel de errores
        $cupsValidos = []; // Datos válidos a insertar
        $codigoPropioValidos = []; // Datos válidos de código propio
        $paqueteValidos = []; // Datos válidos de paquetes
        $cupsProcesados = []; // Para evitar procesar duplicados
        $i = 2; // Contador de líneas, asumiendo que la primera es el encabezado

        // Obtenemos la tarifa correspondiente al ID proporcionado
        $tarifa = Tarifa::find($tarifa_id);
        if (!$tarifa) {
            throw new \Exception('Tarifa no encontrada', 404);
        }

        // Función para agregar errores
        $agregarError = function($codigo, $linea, $mensaje, &$row) use (&$errores, &$cupsConErrores) {
            $errores[] = "Línea $linea: $mensaje";
            $row['errors'] = $mensaje;
            $cupsConErrores[] = $row;
        };

        // Validamos y recolectamos los datos
        foreach ($excel as $linea => $row) {
            $errorMessages = []; // Lista para almacenar los errores de la fila actual

            // Obtenemos y validamos el código CUPS
            $codigo = str_pad(strval($row['codigo']), 6, '0', STR_PAD_LEFT);

            // Verificamos si el código ya fue procesado (para evitar duplicados)
            if (isset($cupsProcesados[$codigo])) {
                $mensaje = "El código CUPS $codigo está duplicado en el archivo. Solo se procesó la primera aparición.";
                $agregarError($codigo, $linea + 2, $mensaje, $row);
                continue;
            }

            // Marcamos este código como procesado
            $cupsProcesados[$codigo] = true;

            // Validamos que el código no tenga más de 8 dígitos
            if (strlen($codigo) > 8) {
                $mensaje = "El código $codigo tiene más de 8 dígitos y debe ser menor o igual a 8 dígitos.";
                $agregarError($codigo, $linea + 2, $mensaje, $row);
                continue;
            }

            // Buscamos el CUPS o Código Propio o Paquete en la base de datos
            $cup = Cup::where('codigo', $codigo)->first();
            $codigoPropio = CodigoPropio::where('codigo', $codigo)->first();
            $paquete = PaqueteServicio::where('codigo', $codigo)->first();

            // Si no se encuentra en ninguna de las tablas
            if (!$cup && !$codigoPropio && !$paquete) {
                $mensaje = "El CUPS / CÓDIGO PROPIO / PAQUETE con código $codigo no se encuentra en la base de datos.";
                $agregarError($codigo, $linea + 2, $mensaje, $row);
                continue;
            }

            // Verificamos si ya está cargado el cup en esa tarifa
            if ($cup && CupTarifa::where('cup_id', $cup->id)->where('tarifa_id', $tarifa->id)->exists()) {
                $mensaje = "El CUPS con código $codigo ya está cargado en la tarifa.";
                $agregarError($codigo, $linea + 2, $mensaje, $row);
                continue;
            }

            // Verificamos si ya está cargado el código propio en esa tarifa
            if ($codigoPropio && $tarifa->propio()->where('codigo_propio_id', $codigoPropio->id)->exists()) {
                $mensaje = "El Código Propio con código $codigo ya está cargado en la tarifa.";
                $agregarError($codigo, $linea + 2, $mensaje, $row);
                continue;
            }

            // Verificamos si ya está cargado el paquete en esa tarifa
            if ($paquete && $tarifa->paqueteServicio()->where('paquete_id', $paquete->id)->exists()) {
                $mensaje = "El Paquete con código $codigo ya está cargado en la tarifa.";
                $agregarError($codigo, $linea + 2, $mensaje, $row);
                continue;
            }

            // Si es válido, agregamos a su respectivo array para inserción
            if ($cup) {
                // Verificamos si este cup ya está en otra tarifa similar para la misma sede
                $buscarTarifas = $this->model->select('cup_tarifas.id')
                ->join('cup_tarifas', 'cup_tarifas.tarifa_id', 'tarifas.id')
                ->where('rep_id', $tarifa->rep_id)
                ->where('contrato_id', $tarifa->contrato_id)
                ->where('cup_id', $cup->id)
                ->whereIn('manual_tarifario_id', [1, 2, 3, 6])
                ->get();
                if ($buscarTarifas->isNotEmpty()) {
                    foreach ($buscarTarifas as $bucarTarifa){
                        // Eliminar registros de la tabla intermedia cup_tarifa
                        CupTarifa::where('id', $bucarTarifa['id'])->delete();
                    }
                    $mensaje = "El CUPS con código $codigo ya está cargado en otra tarifa de la misma sede.";
                    $agregarError($codigo, $linea + 2, $mensaje, $row);
                }
                $cupsValidos[] = [
                    'tarifa_id' => $tarifa->id,
                    'cup_id' => $cup->id,
                    'valor' => $this->calcularValor($tarifa, $cup, $row), // Puedes ajustar esta lógica
                    'user_id' => Auth::id(),
                ];
            } elseif ($codigoPropio) {
                $codigoPropioValidos[] = [
                    'tarifa_id' => $tarifa->id,
                    'codigo_propio_id' => $codigoPropio->id,
                    'valor' => is_numeric($row['valor']) ? (float) $row['valor'] : 0,
                    'user_id' => Auth::id(),
                ];
            } else {
                $paqueteValidos[] = [
                    'tarifa_id' => $tarifa->id,
                    'paquete_id' => $paquete->id,
                    'valor' => is_numeric($row['valor']) ? (float) $row['valor'] : 0,
                    'user_id' => Auth::id(),
                ];
            }
        }

        // Realizamos las inserciones masivas para los registros válidos
        if (!empty($cupsValidos)) {
            $this->insertarEnLotes($cupsValidos, new CupTarifa()); // Inserción masiva de cups
        }

        if (!empty($codigoPropioValidos)) {
            $this->insertarEnLotes($codigoPropioValidos, $tarifa, 'propio'); // Inserción masiva de códigos propios
        }

        if (!empty($paqueteValidos)) {
            $this->insertarEnLotes($paqueteValidos, $tarifa, 'paqueteServicio'); // Inserción masiva de paquetes
        }

        // Si hay errores, generamos el archivo Excel con los registros erróneos
        if (count($errores) > 0) {
            $excelEnBase64 = $this->generarExcelBase64($cupsConErrores);

            // Preparamos la respuesta con los errores y el archivo Excel
            $response = [
                'errores' => $errores,
                'excel' => [
                    'archivo' => $excelEnBase64,
                    'nombre' => "errores.xlsx",
                    'extension' => "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
                ],
            ];

            // Lanzamos una excepción con los detalles
            throw new \Exception(json_encode($response), 422);
        }

            // Retornamos un mensaje de éxito si no hubo errores
            return ['mensaje' => 'Codigos cargados correctamente'];
    }

    private function calcularValor($tarifa, $cup, $row)
    {
        $valor = isset($row['valor']) && is_numeric($row['valor']) ? (float) $row['valor'] : 0;

        if (in_array($tarifa->manual_tarifario_id, [4, 6])) {
            // Para manuales tarifarios 4 y 6
            $valor = isset($row['valor']) && is_numeric($row['valor']) ? (float) $row['valor'] : 0;
        } elseif (in_array($tarifa->manual_tarifario_id, [1, 2, 3])) {
            // Para manuales tarifarios 1, 2 y 3
            $cupsHomologo = Homologo::select('cups.id as cup_id', 'homologos.valor')
                ->join('cups', 'homologos.cup_codigo', 'cups.codigo')
                ->where('homologos.cup_codigo', $cup->codigo)
                ->where('homologos.tipo_manual_id', $tarifa->manual_tarifario_id)
                ->first();

            if ($cupsHomologo) {
                // Calculamos el valor según el pleno
                $valor = $tarifa->pleno != 1
                    ? (($cupsHomologo->valor * $tarifa->valor) / 100) + $cupsHomologo->valor
                    : $cupsHomologo->valor;
            } else {
                // Si no se encuentra el homólogo, asignamos valor 0
                $valor = 0;
            }
        } elseif(in_array($tarifa->manual_tarifario_id, [7])){
            // Para manuales tarifarios 7
            $cupsHomologo = Homologo::select('cups.id as cup_id', 'homologos.valor_uvt')
            ->join('cups', 'homologos.cup_codigo', 'cups.codigo')
            ->where('homologos.cup_codigo', $cup->codigo)
            ->where('homologos.tipo_manual_id', 1)
            ->first();

            if ($cupsHomologo) {
            // Calculamos el valor según el pleno
            $valor = $tarifa->pleno != 1
                ? (($cupsHomologo->valor_uvt * $tarifa->valor) / 100) + $cupsHomologo->valor_uvt
                : $cupsHomologo->valor_uvt;
            } else {
            // Si no se encuentra el homólogo, asignamos valor 0
            $valor = 0;
            }
        }

        return $valor;
    }

    private function insertarEnLotes($data, $model, $relation = null, $batchSize = 500)
    {
        $chunks = array_chunk($data, $batchSize); // Dividimos los datos en lotes

        foreach ($chunks as $chunk) {
            if ($relation) {
                // Si es una relación many-to-many (e.g., attach), usamos la relación
                $model->$relation()->attach($chunk);
            } else {
                // Si es una inserción directa (e.g., insert), usamos el método insert
                $model::insert($chunk);
            }
        }
    }
    

    public function actualizacionCupTarifas($datas)
    {

        $tarifa = Tarifa::find($datas->id);
        $cupTarifas = CupTarifa::where('tarifa_id', $tarifa->id)->get();
        $result = [
            'Error' => [],
            'resultado' => true,
        ];
        $i = 2;
        foreach ($cupTarifas as $cupTarifa) {
            //solo para manuales tarifarios soat y pgp
            if ($tarifa->manual_tarifario_id == 5 || $tarifa->manual_tarifario_id == 4) {
                $valor = ($tarifa->valor / $tarifa->cantiad_personas);
                $cupTarifa->update([
                    'valor' => $valor,
                    'user_id' => Auth::id()
                ]);
            }

            if ($tarifa->manual_tarifario_id == 1 || $tarifa->manual_tarifario_id == 2 || $tarifa->manual_tarifario_id == 3) {

                $cup = Cup::find($cupTarifa->cup_id);
                $cups = Homologo::select('cups.id as cup_id', 'homologos.valor', 'cups.codigo')
                    ->leftjoin('cups', 'homologos.cup_codigo', 'cups.codigo')
                    ->where('homologos.cup_codigo', $cup->codigo)
                    ->where('homologos.tipo_manual_id', $tarifa->manual_tarifario_id)
                    ->first();

                if ($cups == null) {
                    $result['Error'][] = [
                        'mensaje' => 'El cups no se encuentra en el homologo, no se les realizo actualizacion de tarifas, codigo cups es: ' . $cup->codigo,
                    ];
                } else {
                    //para todos los manuales tarifarios
                    if ($tarifa->pleno != 1) {
                        $cupTarifa->update([
                            'valor' => (($cups->valor * $tarifa->valor) / 100) + $cups->valor,
                            'user_id' => Auth::id()
                        ]);
                    } else {
                        $cupTarifa->update([
                            'valor' => $cups->valor,
                            'user_id' => Auth::id()
                        ]);
                    }
                }
            }

            if ($tarifa->manual_tarifario_id == 7 ) {

                $cup = Cup::find($cupTarifa->cup_id);
                $cups = Homologo::select('cups.id as cup_id', 'homologos.valor_uvt', 'cups.codigo')
                    ->leftjoin('cups', 'homologos.cup_codigo', 'cups.codigo')
                    ->where('homologos.cup_codigo', $cup->codigo)
                    ->where('homologos.tipo_manual_id', $tarifa->manual_tarifario_id)
                    ->first();

                if ($cups == null) {
                    $result['Error'][] = [
                        'mensaje' => 'El cups no se encuentra en el homologo, no se les realizo actualizacion de tarifas, codigo cups es: ' . $cup->codigo,
                    ];
                } else {
                    //para todos los manuales tarifarios
                    if ($tarifa->pleno != 1) {
                        $cupTarifa->update([
                            'valor' => (($cups->valor_uvt * $tarifa->valor) / 100) + $cups->valor_uvt,
                            'user_id' => Auth::id()
                        ]);
                    } else {
                        $cupTarifa->update([
                            'valor' => $cups->valor_uvt,
                            'user_id' => Auth::id()
                        ]);
                    }
                }
            }
            $i++;
        }
        return $result;
    }

    public function eliminarCupsTarifa($data)
    {

        // Obtener todos los cups asociados a la familia
        $cups = Familia::select('cups.id as cup_id')
            ->join('cup_familia', 'cup_familia.familia_id', 'familias.id')
            ->join('cups', 'cups.id', 'cup_familia.cup_id')
            ->where('familias.id', $data['familia_id'])
            ->get();

        // Recorrer cada cup y eliminar los registros de CupTarifa que coincidan con tarifa_id y cup_id
        foreach ($cups as $cup) {
            CupTarifa::where('tarifa_id', $data['tarifa_id'])
                ->where('cup_id', $cup->cup_id)
                ->delete();
        }

        // Eliminar los registros de FamiliaTarifa que coincidan con tarifa_id y familia_id
        DB::table('familia_tarifas')
            ->where('familia_id', $data['familia_id'])
            ->where('tarifa_id', $data['tarifa_id'])
            ->delete();


        // Retornar los cups eliminados
        return $data;
    }

    /**
     * Eliminar una tarifa
     * @param Request $request
     * @param Contrato $contrato_id
     * @return bolean
     * @author kobatime
     */
    public function eliminarTarifa($tarifa_id)
    {
        // Obtener todas las tarifas asociadas al contrato
        $tarifas = Tarifa::where('id', $tarifa_id)->first();

        // Eliminar registros de la tabla intermedia cup_tarifa
        CupTarifa::where('tarifa_id', $tarifas['id'])->delete();

        // Eliminar registros de la tabla intermedia codigo_propio_tarifas utilizando DB
        DB::table('codigo_propio_tarifas')->where('tarifa_id', $tarifas['id'])->delete();

        // Eliminar registros de la tabla intermedia paquete_tarifas utilizando DB
        DB::table('paquete_tarifas')->where('tarifa_id', $tarifas['id'])->delete();

        // Eliminar registros de la tabla intermedia familia_tarifas utilizando DB
        DB::table('familia_tarifas')->where('tarifa_id', $tarifas['id'])->delete();

        // Finalmente, eliminar la tarifa
        $tarifas->delete();

        return true;
    }

    /**
     * crea una tarifa
     * @param array $data
     * @return Tarifa
     * @author David Peláez
     */
    public function crear($data)
    {
        $data['user_id'] = Auth::id();
        return $this->model->create($data);
    }

    /**
     * agrega cups a la tarifa
     * @param int $tarifa_id
     * @param array $data
     * @return Tarifa
     * @author David Peláez
     */
    public function agregarCups($tarifa_id, $data)
    {

        # consultamos la tarifa
        $tarifa = $this->model->where('id', $tarifa_id)->first();
        $valor = 0;

        # buscamos el cup, este codigo deberia de enviarse desde el front end
        $cup = Cup::where('id', $data['cups'][0])->first();
         
        # Verificamos si el CUPS ya está parametrizado en la tarifa
         $existeCupTarifa = CupTarifa::where('tarifa_id', $tarifa_id)
         ->where('cup_id', $cup->id)
         ->exists();
 
         if ($existeCupTarifa) {
         throw new \Exception("El CUPS con código {$cup->codigo} ya está registrado en esta tarifa.");
         }
        
        
        # buscamos en el homologo
        
        if (in_array($tarifa->manual_tarifario_id, [1, 2, 3])) {

            $bucarTarifas = $this->model->select('cup_tarifas.id')
            ->join('cup_tarifas','cup_tarifas.tarifa_id','tarifas.id')
            ->where('rep_id',$tarifa->rep_id)
            ->where('contrato_id',$tarifa->contrato_id)
            ->where('cup_id',$cup->id)
            ->whereIn('manual_tarifario_id',[1, 2, 3, 6])
            ->get();

            if($bucarTarifas){
                foreach ($bucarTarifas as $bucarTarifa){
                     // Eliminar registros de la tabla intermedia cup_tarifa
                    CupTarifa::where('id', $bucarTarifa['id'])->delete();
                }
            }

            $homologo = Homologo::where('tipo_manual_id', $tarifa->manual_tarifario_id)->where('cup_codigo', $cup->codigo)->first();
            
            // Asignar valor predeterminado de 0 si no existe homólogo
            $homologoValor = $homologo ? $homologo->valor : 0;

            $positivo = $tarifa->valor > 0;
            
            if ($positivo) {
                $valor = $homologoValor + (($homologoValor * $tarifa->valor) / 100);
            } else {
                $valor = $homologoValor - (($homologoValor * ($tarifa->valor * -1)) / 100);
            }
            

        } elseif (in_array($tarifa->manual_tarifario_id, [7])) {

            $homologo = Homologo::where('tipo_manual_id', 1)->where('cup_codigo', $cup->codigo)->firstOrFail();
            $positivo = $tarifa->valor > 0;
            $homologoValor = $homologo ? $homologo->valor : 0;
            if($positivo){
                $valor = $homologoValor->valor_uvt + (($homologoValor->valor_uvt * $tarifa->valor)/ 100);
            }else{
                $valor = $homologoValor->valor_uvt - (($homologoValor->valor_uvt * ($tarifa->valor * -1)) / 100);
            }
        } elseif (in_array($tarifa->manual_tarifario_id, [6])) {
            
            $bucarTarifas = $this->model->select('cup_tarifas.id')
            ->join('cup_tarifas','cup_tarifas.tarifa_id','tarifas.id')
            ->where('rep_id',$tarifa->rep_id)
            ->where('contrato_id',$tarifa->contrato_id)
            ->where('cup_id',$cup->id)
            ->whereIn('manual_tarifario_id',[1, 2, 3, 6])
            ->get();

            if($bucarTarifas){
                foreach ($bucarTarifas as $bucarTarifa){
                     // Eliminar registros de la tabla intermedia cup_tarifa
                    CupTarifa::where('id', $bucarTarifa['id'])->delete();
                }
            }
         }


        return CupTarifa::create([
            'tarifa_id' => $tarifa_id,
            'cup_id' => $cup->id,
            'valor' => $valor,
            'user_id' => Auth::id()
        ]);
    }

    public function municipioTarifa($tarifa_id,$data) {

        $tarifa = Tarifa::find($tarifa_id);

        $tarifa->municipioTarifas()->syncWithoutDetaching([$data['municipio_id'] => [
            'created_at' => now(),
            'updated_at' => now()
        ]]);
        
        return true;
    }

    public function getMunicipioTarifa($tarifa_id) {

        $tarifa = Tarifa::select('municipio_tarifas.id','municipios.nombre','departamentos.nombre as departamentos_nombre')
            ->join('municipio_tarifas','municipio_tarifas.tarifa_id','tarifas.id')
            ->join('municipios','municipios.id','municipio_tarifas.municipio_id')
            ->join('departamentos','departamentos.id','municipios.departamento_id')
            ->where('tarifas.id',$tarifa_id)
            ->get();
        
        return $tarifa;
    }

    /**
     * Crea un nuevo registro de CUM para una tarifa
     */
    public function cumsTarifa(int $tarifa_id, array $data) : array {
        $tarifa = Tarifa::find($tarifa_id);
        if (!$tarifa) {
            throw new \Exception('Tarifa no encontrada', 404);
        }

        $crecacionCums = cum_tarifa_contrato::updateOrCreate([
            'tarifa_id' => $tarifa->id,
            'cum_validacion' => $data['cum_id'],
        ], [
            'valor' => 0,
            'user_id' => Auth::id()
        ]);

        return $crecacionCums->toArray();
    }

    /**
     * Obtener los CUMs asociados a una tarifa
     * @return array
     * @author kobatime
     */
    public function getCumTarifas($tarifa_id) : array {
        $tarifa = cum_tarifa_contrato::select('cum_tarifa_contratos.id', 'cum_tarifa_contratos.cum_validacion','codesumis.codigo', 'cums.producto', 'cum_tarifa_contratos.valor')
            ->join('medicamentos', 'medicamentos.cum', 'cum_tarifa_contratos.cum_validacion')
            ->join('codesumis','codesumis.id', 'medicamentos.codesumi_id')
            ->join('cums', 'cums.cum_validacion', 'medicamentos.cum')
            ->where('tarifa_id', $tarifa_id)->distinct()->get();
        if ($tarifa->isEmpty()) {
            throw new \Exception('Tarifa no encontrada', 404);
        }

        return $tarifa->toArray();
    }

    /**
     * Eliminar un CUM de una tarifa
     * @param array $data
     * @return array
     * @author kobatime
     */
    public function eliminarCumTarifa($data)
    {
        // Eliminar registros de la tabla
        cum_tarifa_contrato::where('id', $data['cum_tarifas_id'])
            ->delete();

        return $data;
    }

    /**
     * Crea un nuevo registro de diagnóstico para una tarifa
     * @param int $tarifa_id
     * @param array $data
     * @return array
     * @author kobatime
     */

    public function diagnosticoTarifa(int $tarifa_id, array $data) : array {
        $tarifa = Tarifa::find($tarifa_id);
        if (!$tarifa) {
            throw new \Exception('Tarifa no encontrada', 404);
        }

        $crecacionDiagnostico = diagnostico_tarifa_contrato::updateOrCreate([
            'tarifa_id' => $tarifa->id,
            'cie10_id' => $data['cie10_id'],
        ], [
            'user_id' => Auth::id()
        ]);

        return $crecacionDiagnostico->toArray();

    }

    /**
     * Obtener los diagnósticos asociados a una tarifa
     * @return array
     * @author kobatime
     */
    public function getDiagnosticoTarifa(int $tarifa_id) : array {
        $tarifa = diagnostico_tarifa_contrato::select('diagnostico_tarifa_contratos.id','cie10s.codigo_cie10', 'cie10s.descripcion')
            ->join('cie10s','cie10s.id', 'diagnostico_tarifa_contratos.cie10_id')
            ->where('tarifa_id', $tarifa_id)->distinct()->get();

        return $tarifa->toArray();
    }

    /**
     * Eliminar un diagnóstico de una tarifa
     * @param array $data
     * @return array
     * @author kobatime
     */
    public function eliminarDiagnosticoTarifa($data)
    {
        // Eliminar registros de la tabla intermedia diagnostico_tarifa_contratos utilizando DB
        $data = diagnostico_tarifa_contrato::where('id', $data['diagnostico_tarifa_id'])
            ->delete();

        return $data;
    }
}
