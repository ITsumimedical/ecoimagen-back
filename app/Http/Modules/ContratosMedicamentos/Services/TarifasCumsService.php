<?php

namespace App\Http\Modules\ContratosMedicamentos\Services;

use App\Http\Modules\ContratosMedicamentos\Models\TarifasCums;
use App\Http\Modules\ContratosMedicamentos\Repositories\TarifasCumsRepository;
use Illuminate\Support\Facades\Auth;
use Rap2hpoutre\FastExcel\FastExcel;
use DB;
use Exception;

class TarifasCumsService
{

    public function __construct(
        private readonly TarifasCumsRepository $tarifasCumsRepository
    )
    {
    }

    /**
     * @param array $data
     * @return TarifasCums|null
     * @throws Exception
     * @author Thomas
     */
    public function crearCumTarifa(array $data): ?TarifasCums
    {

        // Validar si ya existe una relación con ese cum_validacion
        $cum = $this->tarifasCumsRepository->buscarPorCumValidacion($data['cum_validacion']);
        if ($cum) {
            throw new Exception('Ya existe una relación con ese CUM');
        }

        $datos = $data + [
                'creado_por' => Auth::id(),
            ];

        return $this->tarifasCumsRepository->crear($datos);
    }

    /**
     * Carga masiva de CUMs a una tarifa
     * @param array $data
     * @return array
     * @throws Exception
     * @author Thomas
     */
    public function cargueMasivoCumsTarifa(array $data)
    {
        try {
            DB::beginTransaction();

            // Obtener el archivo cargado y la tarifa
            $archivo = $data['adjunto'];
            $tarifaId = $data['tarifa_id'];

            // Inicializar FastExcel
            $fastExcel = new FastExcel();

            // Cargar el archivo y obtener una colección
            $coleccion = $fastExcel->import($archivo->getRealPath());

            // Inicializar el archivo de errores
            $errores = [];

            // Verificar que solo tenga las columnas esperadas
            $columnasEsperadas = ['cum_validacion', 'precio'];
            $columnasArchivo = array_keys((array) $coleccion->first()); // Obtener las claves de la primera fila

            if (array_diff($columnasArchivo, $columnasEsperadas)) {
                throw new \Exception(json_encode([
                    ['fila' => 0, 'mensaje' => "El archivo contiene columnas no permitidas"]
                ]));
            }

            // Extraer todos los CUMs del archivo
            $cumsArchivo = $coleccion->pluck('cum_validacion')->filter()->toArray();

            // Consultar los CUMs que ya existen en la BD para la misma tarifa
            $cumsExistentes = $this->tarifasCumsRepository->validarExistencias($cumsArchivo, $tarifaId);

            // Consultar los CUMs que existen en la tabla `cums` y están activos
            $cumsActivos = $this->tarifasCumsRepository->validarCumsActivos($cumsArchivo);

            // Lista para rastrear duplicados dentro del archivo
            $cumsEnArchivo = [];

            // Lista de registros que pasarán la inserción
            $registrosValidos = [];

            $coleccion->map(function ($item, $index) use (&$errores, &$cumsEnArchivo, $cumsExistentes, $cumsActivos, &$registrosValidos, $tarifaId) {
                $fila = $index + 1;

                // Validar Campos
                if (empty($item['cum_validacion'])) {
                    $errores[] = ['fila' => $fila, 'mensaje' => "El campo 'cum_validacion' es obligatorio."];
                    return null;
                }

                if (!isset($item['precio'])) {
                    $errores[] = ['fila' => $fila, 'mensaje' => "El campo 'precio' es obligatorio."];
                    return null;
                }

                if (!is_numeric($item['precio'])) {
                    $errores[] = ['fila' => $fila, 'mensaje' => "El precio debe ser un número válido."];
                    return null;
                }

                // Validar que el precio no sea negativo (0 es válido)
                if ($item['precio'] < 0) {
                    $errores[] = ['fila' => $fila, 'mensaje' => "El precio no puede ser negativo."];
                    return null;
                }

                // Validar que no esté 2 veces en el archivo
                if (in_array($item['cum_validacion'], $cumsEnArchivo)) {
                    $errores[] = ['fila' => $fila, 'mensaje' => "El cum_validacion ya está repetido en el archivo."];
                    return null;
                }

                $cumsEnArchivo[] = $item['cum_validacion'];

                // Validar que no exista ya en tarifas_cum para la misma tarifa
                if (in_array($item['cum_validacion'], $cumsExistentes)) {
                    $errores[] = ['fila' => $fila, 'mensaje' => "El cum_validacion ya existe en la tabla tarifas_cum para la tarifa seleccionada."];
                    return null;
                }

                // Validar que el CUM exista en la tabla cums y esté activo
                if (!in_array($item['cum_validacion'], $cumsActivos)) {
                    $errores[] = ['fila' => $fila, 'mensaje' => "El cum_validacion no existe en la tabla cums o no está activo."];
                    return null;
                }

                // Si pasa todas las validaciones, guardamos el registro en la lista de inserción
                $registrosValidos[] = [
                    'tarifa_id' => $tarifaId,
                    'cum_validacion' => $item['cum_validacion'],
                    'precio' => $item['precio'],
                    'creado_por' => Auth::id(),
                    'created_at' => now(),
                    'updated_at' => now()
                ];
            });

            // Si hay errores, lanzar una excepción con el array de errores
            if (!empty($errores)) {
                DB::rollBack();
                throw new Exception(json_encode($errores));
            }

            // Insertar los registros validados en la base de datos
            if (!empty($registrosValidos)) {
                $this->tarifasCumsRepository->insertarRegistros($registrosValidos);
            }

            DB::commit();

            return [
                'mensaje' => 'Carga masiva completada exitosamente.',
                'registros_insertados' => count($registrosValidos)
            ];

        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

}
