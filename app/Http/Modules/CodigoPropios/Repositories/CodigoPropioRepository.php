<?php

namespace App\Http\Modules\CodigoPropios\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CodigoPropios\Models\CodigoPropio;
use App\Http\Modules\Cups\Models\Cup;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Traits\ArchivosTrait;


class CodigoPropioRepository extends RepositoryBase
{

    private $Model;
    use ArchivosTrait;


    public function __construct(CodigoPropio $Model)
    {
        parent::__construct($Model);
        $this->Model = $Model;
    }

    public function listarPropio($request)
    {

        $consulta = $this->Model
            ->WhereAmbito($request->ambito_id)
            ->WhereCodigoPropio($request->codigo)
            ->WhereCodigoCups($request->codigoCups)
            ->WhereNombre($request->nombre)
            ->WhereTarifa($request->tarifa_id)
            ->with('cup:id,codigo')
            ->orderBy('id','asc');

        return $request->page ? $consulta->paginate($request->cant) : $consulta->get();
    }

    public function consultarPropio(int $id)
    {
        $consulta = $this->Model
            ->with('cup')
            ->where('id', $id);

        return $consulta->first();
    }

    public function actualizarEstado(int $codigo_propio_id)
    {
        $consulta = $this->Model->find($codigo_propio_id);
        $consulta->update([
            'activo'=> !$consulta->activo
        ]);
    }

    public function plantillaCodigoPropio() {
        $consulta = [
            ['nombre' => '', 'codigo' => '', 'codigo_cups' => '', 'genero' => '',
             'edad_inicial' => '', 'edad_final' => '', 'quirurgico' => '', 'diagnostico_requerido' => '',
             'nivel_ordenamiento' => '', 'nivel_portabilidad' => '', 'requiere_auditoria' => '',
             'periodicidad' => '', 'cantidad_max_ordenamiento' => '', 'ambito_id' => '', 'valor' => ''],
        ];
        $appointments = Collect($consulta);
        $array = json_decode($appointments, true);
        return $array;
    }

    public function cargar($file) {
        // Importamos los datos del archivo Excel utilizando FastExcel
        $excel = (new FastExcel)->import($file->getRealPath());

        // Verificamos si el archivo Excel está vacío (sin datos)
        if (empty($excel) || count($excel) === 0) {
            // Lanzamos un error si el archivo está vacío
            throw new \Exception(json_encode([
                'mensaje' => 'El archivo está vacío. Por favor, suba un archivo con datos válidos.'
            ]), 422);
        }

        // Inicializamos variables para recopilar errores y contar filas
        $errores = []; // Lista para almacenar los mensajes de errores
        $cupsConErrores = []; // Datos para generar el Excel de errores
        $codigosPropiosProcesados = []; // Para evitar procesar duplicados
        $i = 2; // Contador de líneas, asumiendo que la primera es el encabezado

        // Función para agregar errores
        $agregarError = function ($codigo, $linea, $mensaje, &$row) use (&$errores, &$cupsConErrores) {
            $errores[] = "Línea $linea: $mensaje";
            $row['errors'] = $mensaje;
            $cupsConErrores[] = $row;
        };

        // Recorremos cada fila del Excel
        foreach ($excel as $linea => $row) {
            // Obtenemos y validamos el código CUPS
            $codigo = str_pad(strval($row['codigo_cups']), 6, '0', STR_PAD_LEFT);
            $codigoPropios = $row['codigo'];

            // Verificamos si el código ya fue procesado (para evitar duplicados)
            if (isset($codigosPropiosProcesados[$codigoPropios])) {
                $mensaje = "El código $codigoPropios está duplicado en el archivo. Solo se procesó la primera aparición.";
                $agregarError($codigo, $linea + 2, $mensaje, $row);
                continue;
            }

            // Marcamos este código como procesado
            $codigosPropiosProcesados[$codigoPropios] = true;

            // Validamos que el código CUPS no tenga más de 6 dígitos
            if (strlen($codigo) > 6) {
                $mensaje = "El código $codigo tiene más de 6 dígitos y debe ser menor o igual a 6 dígitos.";
                $agregarError($codigo, $linea + 2, $mensaje, $row);
                continue;
            }

            // Validamos que el código propio no tenga más de 12 dígitos
            if (strlen($codigoPropios) > 12) {
                $mensaje = "El código $codigoPropios tiene más de 12 dígitos y debe ser menor o igual a 12 dígitos.";
                $agregarError($codigo, $linea + 2, $mensaje, $row);
                continue;
            }

            // Verificar si el código propio ya existe en la base de datos
            $existe = CodigoPropio::where('codigo', $codigoPropios)->first();
            if ($existe) {
                $mensaje = "El código $codigoPropios ya existe en la base de datos.";
                $agregarError($codigo, $linea + 2, $mensaje, $row);
                continue;
            }

            // Validamos que los campos obligatorios estén presentes y cumplan con las restricciones adicionales
            if (!$this->validarCamposObligatorios($row, $linea, $agregarError, $codigo, $row)) {
                continue; // Si falta un campo obligatorio o no cumple las restricciones, pasamos a la siguiente fila
            }

            // Buscamos el CUPS en la base de datos
            $cup = Cup::where('codigo', $codigo)->first();
            if (!$cup) {
                $mensaje = "El CUPS con código $codigo no se encuentra en la base de datos.";
                $agregarError($codigo, $linea + 2, $mensaje, $row);
                continue;
            }

            // Creamos el registro de Código Propio
            CodigoPropio::create([
                'nombre' => $row['nombre'],
                'codigo' => $row['codigo'],
                'cup_id' => $cup->id,
                'genero' => $row['genero'],
                'edad_inicial' => $row['edad_inicial'],
                'edad_final' => $row['edad_final'],
                'quirurgico' => $row['quirurgico'],
                'diagnostico_requerido' => $row['diagnostico_requerido'],
                'nivel_ordenamiento' => $row['nivel_ordenamiento'],
                'nivel_portabilidad' => !empty($row['nivel_portabilidad']) ? $row['nivel_portabilidad'] : null,
                'requiere_auditoria' => $row['requiere_auditoria'],
                'periodicidad' => $row['periodicidad'],
                'cantidad_max_ordenamiento' => $row['cantidad_max_ordenamiento'],
                'ambito_id' => $row['ambito_id'],
                'valor' => $row['valor']
            ]);
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

    // Función para validar los campos obligatorios y aplicar las restricciones adicionales
    private function validarCamposObligatorios($row, $linea, $agregarError, $codigo, &$rowData)
    {
        $camposObligatorios = [
            'nombre', 'codigo', 'codigo_cups', 'genero', 'edad_inicial', 'edad_final',
            'quirurgico', 'diagnostico_requerido', 'nivel_ordenamiento',
            'requiere_auditoria', 'periodicidad', 'cantidad_max_ordenamiento',
            'ambito_id', 'valor'
        ];

        // Validamos que todos los campos obligatorios estén presentes
        foreach ($camposObligatorios as $campo) {
            if (!isset($row[$campo]) || $row[$campo] === null || $row[$campo] === '') {
                $mensaje = "El campo $campo es obligatorio y está vacío.";
                $agregarError($codigo, $linea + 2, $mensaje, $rowData);
                return false;
            }
        }

        // Validación del campo ambito_id (solo permite 1, 2, 3)
        if (!in_array($row['ambito_id'], [1, 2, 3])) {
            $mensaje = "El campo ambito_id debe contener solo los valores 1, 2 o 3.";
            $agregarError($codigo, $linea + 2, $mensaje, $rowData);
            return false;
        }

        // Validación del campo genero (solo permite A, F, M)
        if (!in_array($row['genero'], ['A', 'F', 'M'])) {
            $mensaje = "El campo genero debe contener solo las letras A, F o M.";
            $agregarError($codigo, $linea + 2, $mensaje, $rowData);
            return false;
        }

        // Validación de edad_inicial y edad_final (solo permite números)
        if (!is_numeric($row['edad_inicial']) || !is_numeric($row['edad_final'])) {
            $mensaje = "Los campos edad_inicial y edad_final deben contener solo números.";
            $agregarError($codigo, $linea + 2, $mensaje, $rowData);
            return false;
        }

        // Validación de quirurgico, diagnostico_requerido y requiere_auditoria (solo permite 0 y 1)
        foreach (['quirurgico', 'diagnostico_requerido', 'requiere_auditoria'] as $campo) {
            if (!in_array($row[$campo], [0, 1])) {
                $mensaje = "El campo $campo solo debe contener 0 o 1.";
                $agregarError($codigo, $linea + 2, $mensaje, $rowData);
                return false;
            }
        }

        return true;
    }

    public function consultarCodigoPropio($nombre)
    {
        $codigo_propio = $this->Model->select(['id', 'codigo', 'nombre', 'requiere_auditoria', 'ambito_id', 'cantidad_max_ordenamiento', 'nivel_ordenamiento'])
            ->selectRaw("CONCAT(codigo,' - ',nombre) as cups")
            ->where('nombre', 'ILIKE', '%' . $nombre . '%')
            ->orWhere('codigo', 'ILIKE', '%' . $nombre . '%')
            ->get()
            ->toArray();

        return response()->json($codigo_propio);
    }
}
