<?php

namespace App\Http\Modules\Direccionamientos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CodigoPropios\Models\CodigoPropio;
use App\Http\Modules\Contratos\Models\Contrato;
use App\Http\Modules\CupTarifas\Models\CupTarifa;
use App\Http\Modules\Direccionamientos\Models\direccionamiento;
use App\Http\Modules\Direccionamientos\Models\ParametrosDireccionamiento;
use App\Http\Modules\Direccionamientos\Models\PgpDireccionamientoParametros;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Tarifas\Models\Tarifa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;


class DireccionamientoRepository extends RepositoryBase
{
    public function __construct(protected direccionamiento $direccionamientoModel, protected ParametrosDireccionamiento $parametrosDireccionamiento)
    {
        parent::__construct($direccionamientoModel,$parametrosDireccionamiento);
    }

    public function crearDireccionamiento($data)
    {
        $data['user_id'] = Auth::id();
        $this->direccionamientoModel->create($data);

        return true;
    }

    public function listarDireccionamiento($data)
    {
        $consulta = $this->direccionamientoModel
        ->with('rep:id,nombre',
        'georeferenciacion.zona:id,nombre',
        'georeferenciacion.entidad:id,nombre',
        'georeferenciacion.municipio:id,nombre,departamento_id',
        'georeferenciacion.municipio.departamento:id,nombre');

        return $consulta->get();

    }

    public function crearParametros($data)
    {
        $consultas = $this->parametrosDireccionamiento->where('direccionamiento_id',$data['direccionamiento_id'])->get();
        $validacion = $consultas->where('rep_id', $data['rep_id'])->first();
        if ($validacion != null) {
            return ['error' => true, 'mensaje' => 'La sede a ingresar ya esta en los parametros de direccionamiento'];
        }
        if($consultas->count() > 0) {
            $posiciones = $consultas->where('posicion','>=',$data['posicion']);
            foreach ($posiciones as $posicion){
                    $posicion->update([
                        'posicion' => $posicion->posicion + 1,
                        'user_id' => Auth::id()
                    ]);
            }

        }
        $data['user_id'] = Auth::id();
        $this->parametrosDireccionamiento->create($data);
        return true;
    }


    public function crearParametrosPGP($data)
    {
        $validacion = PgpDireccionamientoParametros::where('rep_id', $data['rep_id'])->first();
        if ($validacion != null) {
            return ['error' => true, 'mensaje' => 'La sede a ingresar ya esta en los parametros de direccionamiento'];
        }
        $posiciones = PgpDireccionamientoParametros::where('posicion','>=',$data['posicion'])->get();
            foreach ($posiciones as $posicion){
                    $posicion->update([
                        'posicion' => $posicion->posicion + 1,
                        'user_id' => Auth::id()
                    ]);
            }
        $data['user_id'] = Auth::id();
        PgpDireccionamientoParametros::create([
            'rep_id' => $data['rep_id'],
            'posicion' => $data['posicion'],
            'user_id' =>  $data['user_id']
        ]);
        return true;
    }



    public function listarParametro($data)
    {
        $consulta = $this->parametrosDireccionamiento->with('rep')->where('direccionamiento_id',$data['direccionamiento_id'])->orderBy('posicion', 'asc');

        return $consulta->get();
    }

    public function listarParametroPGP($data)
    {
        $consulta = PgpDireccionamientoParametros::with('rep')->orderBy('posicion', 'asc');

        return $consulta->get();
    }

    public function actualizarParametros($data){
        $posicionInicial = $this->parametrosDireccionamiento->find($data['id']);

        $direccionamiento = $this->parametrosDireccionamiento
            ->where('direccionamiento_id',$data['direccionamiento_id'])
            ->where('posicion',$data['posicion'])
            ->first();

        $direccionamiento->update([
            'posicion' => $posicionInicial->posicion,
            'user_id' => Auth::id()
        ]);

        $posicionInicial ->update([
            'posicion' => $data['posicion'],
            'user_id' => Auth::id()
        ]);

        return true;
    }

    public function eliminarParametros($data)
    {
        $consultas = $this->parametrosDireccionamiento
            ->where('direccionamiento_id',$data['direccionamiento_id'])
            ->where('posicion','>=',$data['posicion'])
            ->get();

        if($consultas) {
            foreach ($consultas as $consulta){
                $consulta->update([
                    'posicion' => $consulta->posicion - 1,
                    'user_id' => Auth::id()
                ]);
            }
        }
        $delete = $this->parametrosDireccionamiento->find($data['id']);
        $delete->delete();
        return true;
    }

    public function eliminarParametrosPGP($data){

        $consultas = PgpDireccionamientoParametros::where('posicion','>=',$data['posicion'])
        ->get();

        if($consultas) {
            foreach ($consultas as $consulta){
                $consulta->update([
                    'posicion' => $consulta->posicion - 1,
                    'user_id' => Auth::id()
                ]);
            }
        }
    $delete = PgpDireccionamientoParametros::find($data['id']);
    $delete->delete();
    return true;
    }

    public function eliminarDireccionamiento($data)
    {
        try {
            DB::beginTransaction();

            // Buscar el registro de direccionamiento
            $direccionamiento = $this->direccionamientoModel->find($data);
            if (!$direccionamiento) {
                return ['error' => 'Direccionamiento no encontrado'];
            }

            // Eliminar los parámetros relacionados en bloque
            $this->parametrosDireccionamiento->where('direccionamiento_id', $data)->delete();

            // Eliminar el direccionamiento
            $direccionamiento->delete();

            DB::commit();
            return ['success' => 'Direccionamiento eliminado correctamente'];
        } catch (\Exception $e) {
            DB::rollBack();
            return ['error' => 'Error al eliminar el direccionamiento', 'message' => $e->getMessage()];
        }

    }

    public function plantilla()
    {
        $consulta = [
            ['codigo_habilitacion' => '', 'posicion' => '', 'eliminar' => ''],
        ];
        $appointments = Collect($consulta);
        $array = json_decode($appointments, true);
        return $array;
    }

    public function cargar($file, int $direccionamiento_id){

        $excel = (new FastExcel)->import($file->getRealPath());
        $result = [
            'Error' => [],
            'resultado' => true,
        ];

        $i = 2;
        $direccionamiento = direccionamiento::find($direccionamiento_id);

        if (!$direccionamiento) {
            return response()->json('Direccionamiento no encontrada', 404);
        }

        foreach ($excel as $row) {

            if (strlen($row['codigo_habilitacion']) <= 5) {
                $result['Error'][] = [
                    'mensaje' => 'El campo codigo de habilitación tiene menos de 5 dígitos y debe ser mayor, el error en la línea ' . $i . ' código de habilitación es: ' . $row['codigo_habilitacion'],
                ];
                $i++;
                continue;
            }

            // Buscar el REP por código de habilitación
            $rep = Rep::where('codigo', $row['codigo_habilitacion'])->first();

            // Si no encuentra el REP, agregar un '0' al inicio y volver a buscar
            if (!$rep) {
                $codigoConCero = '0' . $row['codigo_habilitacion'];
                $rep = Rep::where('codigo', $codigoConCero)->first();
            }

            // Si aún no encuentra el REP después de agregar el '0'
            if (!$rep) {
                $result['Error'][] = [
                    'mensaje' => 'El código de habilitación no se encuentra, el error en la línea ' . $i . ' código de habilitación es: ' . $row['codigo_habilitacion'],
                ];
                $i++;
                continue;
            }

            $parametros = ParametrosDireccionamiento::where('direccionamiento_id',$direccionamiento->id)->get();

            if($parametros->count() > 0) {
            $posiciones = $parametros->where('posicion','>=',$row['posicion']);
                foreach ($posiciones as $posicion){
                        $posicion->update([
                            'posicion' => $posicion->posicion + 1,
                            'user_id' => Auth::id()
                        ]);
                }
            }

            $this->parametrosDireccionamiento->create([
                'direccionamiento_id' => $direccionamiento->id,
                'rep_id'   => $rep->id,
                'posicion' => $row['posicion'],
                'user_id'  => Auth::id()
            ]);

            $i++;

        }

        return $result;
    }

    public function cambio($data)
    {

        // Aplicar lógica según el tipo
        switch ($data['tipo']) {
            case 2:

               $tarifaIds = CupTarifa::where('cup_id', $data['cup_id'])
                ->join('tarifas', 'cup_tarifas.tarifa_id', '=', 'tarifas.id')
                ->join('contratos', 'tarifas.contrato_id', '=', 'contratos.id')
                ->where('contratos.entidad_id', $data['entidad_id'])
                ->pluck('tarifas.id'); // Solo obtenemos los IDs de las tarifas válidas

                // Obtener los reps asociados a esas tarifas, asegurándonos de que sean únicos
                $reps = Rep::whereHas('tarifas', function($query) use ($tarifaIds) {
                    $query->whereIn('id', $tarifaIds);
                })->with(['municipio', 'prestadores'])->distinct()->get();

                break;

            case 3:

                $tarifaIds = Tarifa::join('codigo_propio_tarifas', 'codigo_propio_tarifas.tarifa_id', '=', 'tarifas.id')
                ->join('contratos', 'tarifas.contrato_id', '=', 'contratos.id')
                ->where('contratos.entidad_id', $data['entidad_id'])
                ->where('codigo_propio_id', $data['codigo_propio_id'])
                ->pluck('tarifas.id'); // Solo obtenemos los IDs de las tarifas válidas

                // Obtener los reps asociados a esas tarifas, asegurándonos de que sean únicos
                $reps = Rep::whereHas('tarifas', function($query) use ($tarifaIds) {
                    $query->whereIn('id', $tarifaIds);
                })->with(['municipio', 'prestadores'])->distinct()->get();
                break;

            case 4:

                $tarifaIds = Tarifa::where('paquete_servicio_id', $data['paquete_servicio_id'])
                ->join('paquete_tarifas', 'paquete_tarifas.tarifa_id', '=', 'tarifas.id')
                ->join('contratos', 'tarifas.contrato_id', '=', 'contratos.id')
                ->where('contratos.entidad_id', $data['entidad_id'])
                ->pluck('tarifas.id'); // Solo obtenemos los IDs de las tarifas válidas

                // Obtener los reps asociados a esas tarifas, asegurándonos de que sean únicos
                $reps = Rep::whereHas('tarifas', function($query) use ($tarifaIds) {
                    $query->whereIn('id', $tarifaIds);
                })->with(['municipio', 'prestadores'])->distinct()->get();
                break;
        }

        return $reps;
    }

}
