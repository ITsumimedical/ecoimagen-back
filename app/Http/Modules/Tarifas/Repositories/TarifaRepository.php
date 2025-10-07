<?php

namespace App\Http\Modules\Tarifas\Repositories;

use App\Http\Modules\CodigoPropios\Models\CodigoPropio;
use App\Http\Modules\CupTarifas\Models\CupTarifa;
use App\Http\Modules\Tarifas\Models\Tarifa;
use App\Http\Modules\Tarifas\Services\TarifaService;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\PaqueteServicios\Models\PaqueteServicio;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TarifaRepository extends RepositoryBase
{

    protected $model;
    protected $servicio;

    public function __construct()
    {
        $this->model = new Tarifa();
        $this->servicio = new TarifaService();
        parent::__construct($this->model);
    }

    public function crear($data)
    {
        $data['user_id'] = Auth::id();
        $this->model::create($data);
    }

    public function listarTarifas($request)
    {
        $consulta = $this->model
            ->with('manualTarifario')
            ->where('rep_id', $request->rep_id)
            ->where('contrato_id', $request->contrato_id);

        return $request->page ? $consulta->paginate($request->cant) : $consulta->get();
    }

    public function consultarTarifas($request)
    {
        $consulta = $this->model::select('tarifas.*', 'reps.prestador_id')
            ->with('manualTarifario')
            ->join('reps', 'reps.id', 'tarifas.rep_id')
            ->where('tarifas.id', $request->tarifa_id);

        return $consulta->first();
    }

    public function listarCupTarifas($request)
    {
        $consulta = CupTarifa::select(
            'cups.codigo',
            'cups.nombre',
            // 'familias.nombre as familiaNombre',
            // 'familias.id as familia_id',
            'cup_tarifas.id as cup_tarifas_id',
            'cups.archivo',
            'cup_tarifas.valor',
            'ambitos.id as ambito_id',
            'ambitos.nombre as ambitoNombre',
            'cups.nivel_ordenamiento',
            'cups.periodicidad'
        )
            ->join('cups', 'cups.id', 'cup_tarifas.cup_id')
            ->join('ambitos', 'ambitos.id', 'cups.ambito_id')
            // ->join('cup_familia', 'cup_familia.cup_id', 'cups.id')
            // ->join('familias', 'familias.id', 'cup_familia.familia_id')
            ->where('tarifa_id', $request->tarifa_id);

        if ($request->codigo) {
            $consulta->where('cups.codigo', 'ILIKE', '%' . $request->codigo . '%');
        }
        if ($request->nombre) {
            $consulta->where('cups.nombre', 'ILIKE', '%' . $request->nombre . '%');
        }
        // if ($request->familia) {
        //     $consulta->where('familia_id', $request->familia);
        // }
        if ($request->ambito) {
            $consulta->where('ambito_id', $request->ambito);
        }
        if ($request->valor) {
            $consulta->where('cup_tarifas.valor', $request->valor);
        }

        return $request->page ? $consulta->paginate($request->cant) : $consulta->get();
    }

    public function eliminarCupTarifa($datos)
    {
        $consulta = CupTarifa::find($datos->cup_tarifas_id);
        $consulta->delete();
        return true;
    }

    public function editarValor($datos)
    {
        $consulta = CupTarifa::find($datos->cup_tarifas_id);
        $consulta->update([
            'valor' => $datos->valor
        ]);
        return true;
    }

    public function tarifaPropia($datos)
    {
        $consulta = Tarifa::find($datos->tarifa_id);
        $consulta->propio()->attach($datos->codigoPropio_id, ['user_id' => auth()->user()->id]);
        return $consulta;
    }

    public function tarifaPaquete($datos, int $tarifa_id)
    {
        // Encuentra la tarifa usando el ID proporcionado
        $consulta = Tarifa::find($tarifa_id);

        // Adjunta el paquete de servicio con los datos adicionales, incluyendo el valor del precio
        $consulta->paqueteServicio()->attach($datos->paquete_id, [
            'user_id' => auth()->user()->id,
            'valor' => $datos->precio, // Añadir el campo valor con el precio enviado desde el frontend
        ]);

        return $consulta;
    }

    public function listarTarifaPaquete($datos)
    {

        $consulta = Tarifa::select('paquete_tarifas.id as paquete_tarfia_id', 'paquete_servicios.codigo', 'paquete_servicios.descripcion', 'paquete_servicios.nombre', 'paquete_servicios.precio', 'cups.codigo as cups_codigo')
            ->join('paquete_tarifas', 'paquete_tarifas.tarifa_id', 'tarifas.id')
            ->join('paquete_servicios', 'paquete_servicios.id', 'paquete_tarifas.paquete_servicio_id')
            ->join('cups', 'cups.id', 'paquete_servicios.cup_id')
            ->where('paquete_tarifas.tarifa_id', $datos->tarifa_id);

        return $consulta->get();
    }

    public function actualizarTarifa($data)
    {

         $actualizacion = $this->model::find($data->id)->update([
            'manual_tarifario_id' => $data->manual_tarifario_id,
            'etiqueta' => $data->etiqueta,
            'valor' => $data->valor,
            'pleno' => $data->pleno == false ? 0 : 1,
            'user_id' => auth()->user()->id,
            'cantiad_personas' => $data->cantiad_personas
        ]);

        //$actualizacion = $this->servicio->actualizacionCupTarifas($data);

        return $actualizacion;
    }

    public function plantilla()
    {
        $consulta = [
            ['codigo' => '', 'valor' => '', 'estado' => ''],
        ];
        $appointments = Collect($consulta);
        $array = json_decode($appointments, true);
        return $array;
    }

    public function plantillaMultiplesTarifas()
    {
        $consulta = [
            ['codigo' => '', 'valor' => '', 'tarifa' => ''],
        ];
        $appointments = Collect($consulta);
        $array = json_decode($appointments, true);
        return $array;
    }


    public function plantillaTarifaCup()
    {
        $consulta = [
            ['codigo' => '', 'valor' => ''],
        ];
        $appointments = Collect($consulta);
        $array = json_decode($appointments, true);
        return $array;
    }

    public function listarCodigosPropiosTarifas($tarifa_id)
    {
        $consulta = CodigoPropio::with(['tarifa'])->whereHas('tarifa', function ($query) use ($tarifa_id) {
            $query->where('tarifa_id', $tarifa_id);
        })->get();

        return $consulta;
    }

    public function eliminarCodigoPropioTarifa($tarifa_id, $codigo_propio_id)
    {
        $tarifa = Tarifa::findOrFail($tarifa_id);


        $tarifa->propio()->detach($codigo_propio_id);

        return response()->json(['message' => 'Relación eliminada exitosamente'], 200);
    }

    public function listarPaqueteTarifa($tarifa_id)
    {
        $consulta = PaqueteServicio::with(['cups', 'tarifa'])->whereHas('tarifa', function ($query) use ($tarifa_id) {
            $query->where('tarifa_id', $tarifa_id);
        })->get();

        return $consulta;
    }

    public function eliminarPaqueteTarifa($tarifa_id, $paquete_id)
    {

        $tarifa = Tarifa::findOrFail($tarifa_id);

        $tarifa->paqueteServicio()->detach($paquete_id);

        return response()->json(['message' => 'Relación eliminada exitosamente'], 200);
    }

    public function actualizarPrecioPaquete($tarifa_id, $paquete_id, $precio)
    {
        $tarifa = Tarifa::findOrFail($tarifa_id);

        $tarifa->paqueteServicio()->updateExistingPivot($paquete_id, ['valor' => $precio]);
        return response()->json(['message' => ''], 200);
    }

    public function actualizarPrecioCodigoPropio($tarifa_id, $codigo_propio_id, $precio)
    {
        $tarifa = Tarifa::findOrFail($tarifa_id);

        $tarifa->propio()->updateExistingPivot($codigo_propio_id, ['valor' => $precio]);
        return response()->json(['message' => ''], 200);
    }

    public function actualizarPrecioCupsTarifa($cup_tarifas_id, $valor)
    {
        $cup_tarifa = CupTarifa::findOrFail($cup_tarifas_id);
        $cup_tarifa->update(['valor' => $valor]);
        return response()->json(['message' => ''], 200);
    }

    /**
     * Lista las tarifas segun el contrato
     * @param int $contrato_id
     * @return Collection
     */
    public function listarPorContrato($contrato_id)
    {
        return $this->model
            ->where('contrato_id', $contrato_id)
            ->with('manualTarifario', 'rep:id,nombre')
            ->get();
    }

    public function listarCupsPorTarifa($tarifa_id)
    {
        return CupTarifa::with('cup:id,codigo,nombre,periodicidad')
            ->where('tarifa_id', $tarifa_id)
            ->get();
    }

    public function eliminarMunicipioTarifa($data)
    {
        // Buscar el registro en la tabla intermedia por su ID
        $registro = DB::table('municipio_tarifas')->where('id', $data['municipio_tarifas_id'])->first();

        // Verificar si el registro existe
        if ($registro) {
            // Eliminar el registro
            DB::table('municipio_tarifas')->where('id', $data['municipio_tarifas_id'])->delete();

            return response()->json(['message' => 'Registro eliminado correctamente.']);
        } else {
            return response()->json(['message' => 'Registro no encontrado.'], 404);
        }
    }

    /**
     * Lista las tarifas por un array de ids
     * @param array $idsTarifas
     * @return Collection
     * @author Thomas
     */
    public function listarTarifasPorIds(array $idsTarifas): Collection
    {
        return $this->model->whereIn('id', $idsTarifas)->get();
    }

}
