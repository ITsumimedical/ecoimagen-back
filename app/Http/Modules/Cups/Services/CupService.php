<?php

namespace App\Http\Modules\Cups\Services;

use App\Http\Modules\Ambitos\Models\Ambito;
use App\Http\Modules\Cie10Afiliado\Repositories\Cie10AfiliadoRepository;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\CupTarifas\Models\CupTarifa;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Tarifas\Models\Tarifa;
use Carbon\Carbon;
use Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class CupService
{

    public function __construct(private ConsultaRepository $consultaRepository, private Cie10AfiliadoRepository $cie10AfiliadoRepository) {}

    public function cagar($file)
    {

        $excel = (new FastExcel)->import($file->getRealPath());
        $result = [
            'Error' => [],
            'resultado' => true,
        ];
        $i = 2;
        foreach ($excel as $row) { // //

            if (strlen($row['codigo']) >= 7) {
                $result['resultado'] = false;
                $result['Error'] = 'El campo codigo tiene mas de 6 digitos y debe ser menor, el error en la línea ' . $i;
                return $result;
            }

            if (empty($row['nombre'])) {
                $result['resultado'] = false;
                $result['Error'] = 'El campo nombre no puede estar vacío, el error esta en la línea ' . $i;
                return $result;
            }

            if (empty($row['genero'])) {
                $result['resultado'] = false;
                $result['Error'] = 'El campo genero no puede estar vacío, el error esta en la línea ' . $i;
                return $result;
            }

            if (($row['genero']) <> 'A' && ($row['genero']) <> 'F' && ($row['genero']) <> 'M') {
                $result['resultado'] = false;
                $result['Error'] = 'El campo genero no esta llenado correctamente, estas son las opciones [A = ambos, F = femenino, M = masculino], el error esta en la línea ' . $i;
                return $result;
            }

            if ($row['edad_inicial'] < 0) {
                $result['resultado'] = false;
                $result['Error'] = 'El campo edad_inicial debe tener un valor mayor o igual a 0, el error esta en la línea ' . $i;
                return $result;
            }

            if (empty($row['edad_final'])) {
                $result['resultado'] = false;
                $result['Error'] = 'El campo edad_final no puede estar vacío, el error esta en la línea ' . $i;
                return $result;
            }

            if (empty($row['archivo'])) {
                $result['resultado'] = false;
                $result['Error'] = 'El campo archivo no puede estar vacío, el error esta en la línea ' . $i;
                return $result;
            }

            if ($row['archivo'] <> 'AC' && $row['archivo'] <> 'AT' && $row['archivo'] <> 'AP') {
                $result['resultado'] = false;
                $result['Error'] = 'El campo genero no esta llenado correctamente, estas son las opciones [AC, AT, AP], el error esta en la línea ' . $i;
                return $result;
            }

            if ($row['quirurgico'] > 1) {
                $result['resultado'] = false;
                $result['Error'] = 'El campo quirurgico no esta llenado correctamente, estas son las opciones [1 = Si, 0 = No], el error esta en la línea ' . $i;
                return $result;
            }

            if ($row['diagnostico_requerido'] > 1) {
                $result['resultado'] = false;
                $result['Error'] = 'El campo diagnostico_requerido no esta llenado correctamente, estas son las opciones [1 = Si, 0 = No], el error esta en la línea ' . $i;
                return $result;
            }

            if ($row['periodicidad'] >= 365) {
                $result['resultado'] = false;
                $result['Error'] = 'El campo periodicidad tiene mas de 365 días y debe ser menor, el error esta en la línea ' . $i;
                return $result;
            }

            if (empty($row['ambito_id'])) {
                $result['resultado'] = false;
                $result['Error'] = 'El campo ambito_id no puede estar vacío, el error esta en la línea ' . $i;
                return $result;
            }

            $ambito = Ambito::where('id', $row['ambito_id'])->first();

            if (!$ambito) {
                $result['resultado'] = false;
                $result['Error'] = 'El campo ambito_id no se existe en nuestra base de datos, el error esta en la línea ' . $i;
                return $result;
            }

            if ($row['activo'] > 1) {
                $result['resultado'] = false;
                $result['Error'] = 'El campo activo no esta llenado correctamente, estas son las opciones [1 = activo, 0 = inactivo], el error esta en la línea ' . $i;
                return $result;
            }

            $i++;
        }

        if ($result['resultado']) {
            foreach ($excel as $key) {
                $key = Cup::updateOrCreate([
                    'codigo'                        => $key['codigo'],
                ], [
                    'codigo'                        => $key['codigo'],
                    'nombre'                        => $key['nombre'],
                    'genero'                        => $key['genero'],
                    'edad_inicial'                    => $key['edad_inicial'],
                    'edad_final'                    => $key['edad_final'],
                    'archivo'                        => $key['archivo'],
                    'quirurgico'                    => $key['quirurgico'],
                    'diagnostico_requerido'            => $key['diagnostico_requerido'],
                    'nivel_ordenamiento'            => $key['nivel_ordenamiento'],
                    'nivel_portabilidad'            => $key['nivel_portabilidad'],
                    'requiere_auditoria'            => $key['requiere_auditoria'],
                    'periodicidad'                    => $key['periodicidad'],
                    'cantidad_max_ordenamiento'        => $key['cantidad_max_ordenamiento'],
                    'ambito_id'                        => $key['ambito_id'],
                    'activo'                        => $key['activo'],
                ]);
            }
        }

        return $result;
    }

    public function evaluarRequiereDiagnostico(array $request)
    {
        // Validar los datos recibidos en el array
        if (!isset($request['consulta_id']) || !isset($request['procedimientos'])) {
            return "Datos incompletos: consulta_id o procedimientos faltantes.";
        }

        $consultaId = $request['consulta_id'];
        $procedimientos = $request['procedimientos'];

        if (empty($procedimientos)) {
            return "No se han proporcionado procedimientos.";
        }

        // Buscar el afiliado de la consulta
        $consulta = $this->consultaRepository->consulta($consultaId);
        if (!$consulta) {
            return "Consulta no encontrada.";
        }

        $afiliado = $consulta->afiliado;
        $entidadId = $afiliado->entidad->id;

        // Consultar la tabla cup_entidad y obtener nombre del CUP
        $entidadCups = DB::table('cup_entidad')
            ->join('cups', 'cup_entidad.cup_id', '=', 'cups.id')
            ->where('cup_entidad.entidad_id', $entidadId)
            ->whereIn('cup_entidad.cup_id', $procedimientos)
            ->select('cup_entidad.*', 'cups.nombre as cup_nombre')
            ->get();

        $cupsGenerales = DB::table('cups')
            ->whereIn('id', $procedimientos)
            ->get();

        foreach ($cupsGenerales as $cup) {
            // Validar edad
            if (($cup->edad_inicial && $afiliado->edad_cumplida < $cup->edad_inicial) ||
                ($cup->edad_final && $afiliado->edad_cumplida > $cup->edad_final)) {
                return "Error de edad: El procedimiento '{$cup->nombre}' requiere una edad entre {$cup->edad_inicial} y {$cup->edad_final}, pero el afiliado tiene {$afiliado->edad_cumplida} años.";
            }

            // Validar género
            if ($cup->genero !== 'A' && $cup->genero !== $afiliado->sexo) {
                $generos = [
                    'M' => 'Masculino',
                    'F' => 'Femenino',
                    'A' => 'Ambos'
                ];

                $generoRequerido = $generos[$cup->genero] ?? 'No especificado';
                $sexoAfiliado = $generos[$afiliado->sexo] ?? 'No especificado';

                return "Error de género: El procedimiento '{$cup->nombre}' requiere género {$generoRequerido}, pero el afiliado es de género {$sexoAfiliado}.";
            }

        }

        // Obtener permisos del usuario
        $user = Auth::user();
        $roleIds = DB::table('model_has_roles')
            ->where('model_id', $user->id)
            ->pluck('role_id')
            ->toArray();

        $rolePermissions = DB::table('role_has_permissions')
            ->whereIn('role_id', $roleIds)
            ->pluck('permission_id')
            ->toArray();

        $directPermissions = $user->permissions->pluck('id')->toArray();

        $nivelOrdenamientoPermisos = [
            237 => 1,  // nivel.ordenamiento.1
            238 => 2,  // nivel.ordenamiento.2
            239 => 3,  // nivel.ordenamiento.3
            240 => 4   // nivel.ordenamiento.4
        ];

        /*
        $permisosUsuario = array_merge($directPermissions, $rolePermissions);
        $nivelOrdenamientoPermisosUsuario = array_filter($permisosUsuario, function($permiso) use ($nivelOrdenamientoPermisos) {
            return isset($nivelOrdenamientoPermisos[$permiso]);
        });

        if (empty($nivelOrdenamientoPermisosUsuario)) {
            return "El usuario no tiene permisos de nivel de ordenamiento.";
        }

        $usuarioNivel = max(array_map(function($permiso) use ($nivelOrdenamientoPermisos) {
            return $nivelOrdenamientoPermisos[$permiso];
        }, $nivelOrdenamientoPermisosUsuario));
        */

        // Validar los niveles de ordenamiento para cada procedimiento
        foreach ($entidadCups as $entidadCup) {
            // COMENTADO: Validar si el nivel de ordenamiento del usuario es suficiente
            /*
            if ($entidadCup->nivel_ordenamiento > $usuarioNivel) {
                return "Permiso insuficiente: se requiere nivel de ordenamiento {$entidadCup->nivel_ordenamiento}, pero el usuario tiene nivel {$usuarioNivel}.";
            }
            */

            $tipoConsultaId = $consulta->tipo_consulta_id;

            if ($tipoConsultaId == 1) {
                $existeDx = $this->cie10AfiliadoRepository->verificarExisteDiagnostico($consultaId);
                if (!$existeDx) {
                    return "Falta diagnóstico: el procedimiento '{$entidadCup->cup_nombre}' requiere al menos un diagnóstico.";
                }
            } else {
                $existeDx = $this->cie10AfiliadoRepository->verificarDiagnosticoPrimario($consultaId);
                if (!$existeDx) {
                    return "Falta diagnóstico primario: el procedimiento '{$entidadCup->cup_nombre}' requiere diagnóstico primario.";
                }
            }

            // Validar la cantidad máxima de ordenamiento
            $cantidadSolicitada = isset($request['cantidad'][$entidadCup->cup_id]) ? (int)$request['cantidad'][$entidadCup->cup_id] : 0;

            // Comparar la cantidad enviada con la cantidad máxima permitida
            if ($cantidadSolicitada > $entidadCup->cantidad_max_ordenamiento) {
                return "Cantidad máxima superada: el procedimiento '{$entidadCup->cup_nombre}' tiene una cantidad máxima de ordenamiento de {$entidadCup->cantidad_max_ordenamiento}, pero se han ordenado {$cantidadSolicitada}.";
            }

            // Validar periodicidad
            if ($entidadCup->periodicidad) {
                $fechaLimite = now()->subDays($entidadCup->periodicidad);

                $ordenExistente = DB::table('orden_procedimientos')
                    ->join('ordenes', 'orden_procedimientos.orden_id', '=', 'ordenes.id')
                    ->join('consultas', 'ordenes.consulta_id', '=', 'consultas.id')
                    ->where('orden_procedimientos.cup_id', $entidadCup->cup_id)
                    ->where('consultas.afiliado_id', $consulta->afiliado->id)
                    ->where('orden_procedimientos.created_at', '>=', $fechaLimite)
                    ->first();

                if ($ordenExistente) {
                    $fechaOrden = Carbon::parse($ordenExistente->created_at)->format('Y-m-d');
                    return "Error de periodicidad: el CUP '{$entidadCup->cup_nombre}' ya fue ordenado para este afiliado en la fecha {$fechaOrden}. Este CUP permite ordenarse cada {$entidadCup->periodicidad} días.";
                }
            }
        }

        return true;
    }

    /**
     * verifica si un cup pertenece a un manual tarifario o varios
     * @param array|int $manualTarifario
     * @param Cup|int $cup
     * @param array|int $rep
     * @author David Peláez
     * @return bool
     */
    public function verificarManual(Cup|int $cup, array|int $manualTarifario, array|int $rep){
        if(!$cup instanceof Cup){
            $cup = Cup::where('id', $cup)->first();
            if(!$cup){
                return false;
            }
        }

        # se busca en tarifas con el rep
        $tarifasDelRep = Tarifa::whereRep($rep)
            ->whereManualTarifario($manualTarifario)
            ->get();

        if($tarifasDelRep->count() < 1){
            return false;
        }
        # si tiene mas de una tarifa, hay que buscar en cup tarifas el cup y el rep
        $cupTarifas = CupTarifa::where('cup_id', $cup->id)
            ->whereIn('tarifa_id', $tarifasDelRep->pluck('id')->toArray())
            ->get();
        if($cupTarifas->count() < 1){
            return false;
        }

        return true;
        
    }

}
