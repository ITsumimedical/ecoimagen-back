<?php

namespace App\Http\Modules\Cups\Repositories;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Entidad\Models\Entidad;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use InvalidArgumentException;

class CupRepository extends RepositoryBase
{
    public function __construct(protected Cup $cupModel)
    {
        parent::__construct($cupModel);
    }

    public function listarCups($request)
    {
        $consulta = $this->cupModel->with('ambito:id,nombre')
            ->WhereCodigo($request->codigo)
            ->WhereNombre($request->nombre)
            ->WhereNivel($request->nivel)
            ->WhereAmbito($request->ambito)
            ->whereCodigoNombre($request->cups)
            ->whereTodos($request->todos)
            ->orderBy('id');

        return $request->page ? $consulta->paginate() : $consulta->get();
    }

    public function consultarCupsId(int $cup_id)
    {
        return $this->cupModel
            ->with('modalidadGrupo')
            ->Where('id', $cup_id)
            ->get();
    }

    public function actualizarEstado(int $cup_id)
    {
        $consulta = $this->cupModel->find($cup_id);

        if ($consulta->activo == 1) {
            $consulta->update([
                'activo' => 0
            ]);
        } else {
            $consulta->update([
                'activo' => 1
            ]);
        }
        return true;
    }

    public function tarifaPrestadores(int $cup_id)
    {
        $consulta = $this->cupModel::select(
            'tarifas.valor as valorTarifa',
            'cup_tarifas.valor',
            'manual_tarifarios.nombre as tarifa',
            'reps.nombre as prestador',
            'entidades.nombre as entidad'
        )
            ->join('cup_tarifas', 'cups.id', 'cup_tarifas.cup_id')
            ->join('tarifas', 'cup_tarifas.tarifa_id', 'tarifas.id')
            ->join('contratos', 'tarifas.contrato_id', 'contratos.id')
            ->join('entidades', 'contratos.entidad_id', 'entidades.id')
            ->join('manual_tarifarios', 'tarifas.manual_tarifario_id', 'manual_tarifarios.id')
            ->join('reps', 'tarifas.rep_id', 'reps.id')
            ->Where('cups.id', $cup_id)->get();
        return $consulta;
    }

    public function buscarCupNombreCodigo($request)
    {
        $usuario = auth()->user();
        $afiliado = Afiliado::find($request->idAfiliado);

        $niveles = Cache::rememberForever("usuario:$usuario->id", function () use ($usuario) {
            return $usuario->permissions->filter(function ($permission) {
                return strpos($permission['name'], 'nivel.ordenamiento') !== false;
            })->map(function ($permission) {
                return explode('.', $permission['name'])[2];
            })->prepend(0)->toArray();
        });

        $key = 'busqueda-servicio:'.$request->nombre;
        $cupCachado = Cache::remember($key, 7200, function () use ($request) {
            return $this->cupModel->select('id', 'codigo', 'nombre', 'requiere_auditoria', 'ambito_id', 'nivel_ordenamiento', 'cantidad_max_ordenamiento')
                ->with('familias')
                ->selectRaw("CONCAT(codigo,' - ',nombre) as cups")
                ->WhereCodigoNombre($request->nombre)
                ->where('activo', true)
                ->get();
        });

        // Filtra por genero
        $cupCachado->whereIn('genero', ['A', $afiliado->sexo]);
 
        // Verificar si se envió una familia y filtrar por ella
        if ($request->has('familia_id')) {
            $cupCachado = $cupCachado->filter(function ($cup) use ($request) {
                return $cup->familias->whereIn('id', $request->familia_id)->isNotEmpty();
            })->values();
        }

        // Añadir condición de nivel de ordenamiento si no es 4
        if (!in_array(4, $niveles)) {
            $cupCachado->where('nivel_ordenamiento', '!=', 4);
        }

        return $cupCachado;
    }

    public function getCups($nombre)
    {
        $cups = $this->cupModel->select(['id', 'codigo', 'nombre', 'requiere_auditoria', 'ambito_id', 'nivel_ordenamiento'])
            ->selectRaw("CONCAT(codigo,' - ',nombre) as cups")
            ->where('nombre', 'ILIKE', "%" . $nombre . "%")
            ->orWhere('codigo', 'ILIKE', "%" . $nombre . "%")
            ->get()
            ->toArray();

        return response()->json($cups);
    }

    public function listarCupsTiposEducacion()
    {
        $cups = Cup::select('cups.*')
            ->whereIn('cups.id', [
                9290,
                9293,
                9288,
                9296,
                9573,
                9291,
                9292,
                9287,
                9289,
                9295,
                9297,
                9294,
                9286,
                9298,
                9299,
                9302,
                9304,
                9306,
                9307,
                9308,
                9300,
                9301,
                9303,
                9305,
                9309,
                9310,
                9311,
                9312,
                9313,
                9314,
                9315,
            ])->get();

        return $cups;
    }

    public function asignarEntidades($cupId, $entidades)
    {
        $cup = Cup::findOrFail($cupId); //Encuentra o falla por id del cup
        $cup->entidades()->sync($entidades); //asigna las entidades al cup por medio de un sync

        return $cup->entidades;
    }

    /**
     * Obtiene las entidades asignadas a un cup, solo las que tiene asociadas el usuario loggeado
     * @param int $cupId
     * @return Entidad[]|Collection
     * @author Thomas
     */
    public function obtenerEntidadesAsignadas(int $cupId)
    {
        $userId = Auth::id();

        $cup = $this->cupModel->where('id', $cupId)
            ->whereHas('entidades.usuarios', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->with(['entidades' => function ($query) use ($userId) {
                $query->whereHas('usuarios', function ($query) use ($userId) {
                    $query->where('users.id', $userId);
                });
            }])
            ->with('entidades.pivot')
            ->first();

        return $cup ? $cup->entidades : collect();
    }

    /**
     * Obitene el cup por especialidad
     * @param int $especialidadId
     * @return Cup|null
     * @throws InvalidArgumentException
     */
    public function obtenerCupPorEspecialidad($especialidad)
    {
        if ($especialidad->cup_id) {
            return $this->cupModel->where('id', $especialidad->cup_id)->first();
        } else {

            throw new InvalidArgumentException("Especialidad no válida");
        }
    }

    public function actualizarCupEntidad($data)
    {
        // Verifica si existe el registro en la tabla intermedia con el ID proporcionado
        $exists = DB::table('cup_entidad')->where('id', $data['cup_entidad_id'])->exists();

        if ($exists) {
            // Actualiza los campos de la tabla intermedia usando el id (cup_entidad_id)
            DB::table('cup_entidad')
                ->where('id', $data['cup_entidad_id'])
                ->update([
                    'diagnostico_requerido' => $data['diagnostico_requerido'],
                    'nivel_ordenamiento' => $data['nivel_ordenamiento'],
                    'nivel_portabilidad' => $data['nivel_portabilidad'],
                    'requiere_auditoria' => $data['requiere_auditoria'],
                    'periodicidad' => $data['periodicidad'],
                    'cantidad_max_ordenamiento' => $data['cantidad_max_ordenamiento'],
                    'copago' => $data['copago'],
                    'moderadora' => $data['moderadora'],
                    'updated_at' => now(), // Actualiza la fecha de actualización
                ]);

            return response()->json(['message' => 'Datos actualizados correctamente.']);
        }

        return response()->json(['message' => 'Registro no encontrado.'], 404);
    }

    public function listarCupsPorCita($cita_id)
    {
        return $this->cupModel::select('cups.id', 'cups.nombre', 'cups.codigo')
            ->join('cita_cup', 'cita_cup.cup_id', 'cups.id')
            ->join('citas', 'citas.id', 'cita_cup.cita_id')
            ->where('citas.id', $cita_id)
            ->get();
    }

    /**
     * Lista las entidades asignadas a un cup
     * @param int $cupId
     * @return Collection
     * @author Thomas
     */
    public function listarEntidadesCup(int $cupId): Collection
    {
        return $this->cupModel::find($cupId)->entidades()->get();
    }

    /**
     * Agrega entidades a un cup
     * @param array $data
     * @return array
     * @author Thomas
     */
    public function agregarEntidadesCup(array $data): array
    {
        $cup = $this->cupModel->findOrFail($data['cup_id']);
        return $cup->entidades()->syncWithoutDetaching($data['entidades']);
    }

    /**
     * Remueve entidades de un cup
     * @param array $data
     * @return int
     * @author Thomas
     */
    public function removerEntidadesCup(array $data): int
    {
        $cup = $this->cupModel->findOrFail($data['cup_id']);
        return $cup->entidades()->detach($data['entidades']);
    }

    /**
     * Lista los detalles de un cup
     * @param int $cupId
     * @return Cup|null
     * @author Thomas
     */
    public function listarDetallesCup(int $cupId): ?Cup
    {
        return $this->cupModel->findOrFail($cupId);
    }

    /**
     * Lista las familias de un cup
     * @param int $cupId
     * @return Collection
     * @author Thomas
     */
    public function listarFamiliaCups(int $cupId): Collection
    {
        return $this->cupModel->findOrFail($cupId)->familias()->get();
    }

    /**
     * Busca un cup por su código
     * @param string $codigoCup
     * @return Cup
     * @author Thomas
     */
    public function buscarCupPorCodigo(string $codigoCup): ?Cup
    {
        return $this->cupModel->where('codigo', $codigoCup)->first();
    }

    public function consultarCupEntidad(int $procedimiento_id,$afiliado_entidad_id)
    {
        $cupEntidad = DB::table('cup_entidad')
        ->where('cup_id', $procedimiento_id)
        ->where('entidad_id', $afiliado_entidad_id)
        ->first();

        return $cupEntidad;
    }

}
