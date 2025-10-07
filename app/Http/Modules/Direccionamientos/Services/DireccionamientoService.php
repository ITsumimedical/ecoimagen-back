<?php

namespace App\Http\Modules\Direccionamientos\Services;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Direccionamientos\Models\direccionamiento;
use App\Http\Modules\Direccionamientos\Models\ParametrosDireccionamiento;
use App\Http\Modules\Direccionamientos\Models\PgpDireccionamientoParametros;
use App\Http\Modules\Direccionamientos\Repositories\DireccionamientoRepository;
use App\Http\Modules\Entidad\Repositories\EntidadRepository;
use App\Http\Modules\Georeferenciacion\Models\Georeferenciacion;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Ordenamiento\Models\OrdenProcedimiento;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Tarifas\Models\Tarifa;
use Illuminate\Support\Facades\Auth;

class DireccionamientoService
{


    public function __construct(protected DireccionamientoRepository $direccionamientoRepository)
    {
    }

    public function direccionamientoOrdenes($data, $ips_primaria)
    {
        $orden = Orden::where('id', $data->orden_id)->first();
        $consulta = Consulta::where('id', $orden->consulta_id)->first();
        $afiliado = Afiliado::where('id', $consulta->afiliado_id)->first();

        // Buscar contrato con ips_primaria
        $contrato_ips_primaria = Tarifa::select('tarifas.rep_id as direccionamiento_id')
            ->join('contratos', 'contratos.id', 'tarifas.contrato_id')
            ->join('cup_tarifas', 'cup_tarifas.tarifa_id', 'tarifas.id')
            ->where('cup_tarifas.cup_id', $data->cup_id)
            ->where('contratos.entidad_id', $afiliado->entidad_id)
            ->where('tarifas.rep_id', $ips_primaria)
            ->where('tarifas.activo', 1)
            ->where('contratos.activo', 1)
            ->first();

        if ($contrato_ips_primaria) {
            return $contrato_ips_primaria;
        } else {
            $ipsPrimaria = Rep::select('municipio_id')->where('id',$ips_primaria)->first();

            $tarifasPGP = Tarifa::join('municipio_tarifas','municipio_tarifas.tarifa_id','tarifas.id')
                ->where('manual_tarifario_id',4)
                ->where('municipio_id',$ipsPrimaria->municipio_id)
                ->get();

            if($tarifasPGP){
                $ParametrosDireccionamientos = PgpDireccionamientoParametros::orderBy('posicion', 'asc') // Ordenar por el campo de posición
                ->get();

                // Iterar sobre los parámetros en el orden especificado
                foreach ($ParametrosDireccionamientos as $ParametrosDireccionamiento) {
                    $rep = Tarifa::query()
                        ->select('reps.id as direccionamiento_id')
                        ->join('contratos', 'contratos.id', '=', 'tarifas.contrato_id')
                        ->join('cup_tarifas', 'cup_tarifas.tarifa_id', '=', 'tarifas.id')
                        ->join('reps', 'reps.id', '=', 'tarifas.rep_id')
                        ->where([
                            ['cup_tarifas.cup_id', '=', $data->cup_id],
                            ['contratos.entidad_id', '=', $afiliado->entidad_id],
                            ['tarifas.rep_id', '=', $ParametrosDireccionamiento->rep_id],
                            ['tarifas.activo', '=', 1],
                            ['contratos.activo', '=', 1]
                        ])
                        ->where('tarifas.manual_tarifario_id', '<>', 4)
                        ->first();
                    if ($rep) {
                        return $rep;
                    }
                }
            }

            $direccionamiento = Georeferenciacion::select('direccionamientos.id as direccionamiento_id')
                ->join('direccionamientos', 'direccionamientos.georeferenciacion_id', 'georeferenciacions.id')
                ->where('direccionamientos.rep_id', $ips_primaria)
                ->where('georeferenciacions.entidad_id', $afiliado->entidad_id)
                ->first();

            if ($direccionamiento) {
                // Obtener los parámetros en orden de posición
                $ParametrosDireccionamientos = ParametrosDireccionamiento::where('direccionamiento_id', $direccionamiento->direccionamiento_id)
                    ->orderBy('posicion', 'asc') // Ordenar por el campo de posición
                    ->get();

                // Iterar sobre los parámetros en el orden especificado
                foreach ($ParametrosDireccionamientos as $ParametrosDireccionamiento) {
                    $rep = Tarifa::select('reps.id as direccionamiento_id')
                        ->join('contratos', 'contratos.id', 'tarifas.contrato_id')
                        ->join('cup_tarifas', 'cup_tarifas.tarifa_id', 'tarifas.id')
                        ->join('reps', 'reps.id', 'tarifas.rep_id')
                        ->where('cup_tarifas.cup_id', $data->cup_id)
                        ->where('contratos.entidad_id', $afiliado->entidad_id)
                        ->where('tarifas.rep_id', $ParametrosDireccionamiento->rep_id)
                        ->where('tarifas.activo', 1)
                        ->where('contratos.activo', 1)
                        ->first();

                    if ($rep) {
                        return $rep;
                    }
                }
            }
        }
        return null;
    }

    public function direccionamientoOrdenesPropios($data, $ips_primaria) {
        
        $orden = Orden::where('id', $data->orden_id)->first();
        $consulta = Consulta::where('id', $orden->consulta_id)->first();
        $afiliado = Afiliado::where('id', $consulta->afiliado_id)->first();

        // Buscar contrato con ips_primaria
        $contrato_ips_primaria = Tarifa::select('tarifas.rep_id as direccionamiento_id')
            ->join('contratos', 'contratos.id', 'tarifas.contrato_id')
            ->join('codigo_propio_tarifas', 'codigo_propio_tarifas.tarifa_id', 'tarifas.id')
            ->where('codigo_propio_tarifas.codigo_propio_id', $data->codigoPropio->id)
            ->where('contratos.entidad_id', $afiliado->entidad_id)
            ->where('tarifas.rep_id', $ips_primaria)
            ->where('tarifas.activo', 1)
            ->where('contratos.activo', 1)
            ->first();

        if ($contrato_ips_primaria) {
            return $contrato_ips_primaria;
        }

        $ipsPrimariaMunicipio = Rep::select('municipio_id')->where('id',$ips_primaria)->first();

        $tarifasPGP = Tarifa::join('municipio_tarifas','municipio_tarifas.tarifa_id','tarifas.id')
                ->where('manual_tarifario_id',4)
                ->where('municipio_id',$ipsPrimariaMunicipio->municipio_id)
                ->get();

        if($tarifasPGP){
            $ParametrosDireccionamientos = PgpDireccionamientoParametros::orderBy('posicion', 'asc') // Ordenar por el campo de posición
            ->get();

            // Iterar sobre los parámetros en el orden especificado
            foreach ($ParametrosDireccionamientos as $ParametrosDireccionamiento) {
                $rep = Tarifa::select('reps.id as direccionamiento_id')
                    ->join('contratos', 'contratos.id', '=', 'tarifas.contrato_id')
                    ->join('codigo_propio_tarifas', 'codigo_propio_tarifas.tarifa_id', '=', 'tarifas.id')
                    ->join('reps', 'reps.id', '=', 'tarifas.rep_id')
                    ->where([
                        ['codigo_propio_tarifas.codigo_propio_id', '=', $data->codigoPropio->id],
                        ['contratos.entidad_id', '=', $afiliado->entidad_id],
                        ['tarifas.rep_id', '=', $ParametrosDireccionamiento->rep_id],
                        ['tarifas.activo', '=', 1],
                        ['contratos.activo', '=', 1]
                    ])
                    ->where('tarifas.manual_tarifario_id', '<>', 4)
                    ->first();
                if ($rep) {
                    return $rep;
                }
            }
        }

        $direccionamiento = Georeferenciacion::select('direccionamientos.id as direccionamiento_id')
        ->join('direccionamientos', 'direccionamientos.georeferenciacion_id', 'georeferenciacions.id')
        ->where('direccionamientos.rep_id', $ips_primaria)
        ->where('georeferenciacions.entidad_id', $afiliado->entidad_id)
        ->first();

       
        if ($direccionamiento) {
            $ParametrosDireccionamientos = ParametrosDireccionamiento::where('direccionamiento_id', $direccionamiento->direccionamiento_id)->get();
            foreach ($ParametrosDireccionamientos as $ParametrosDireccionamiento) {
                $rep = Tarifa::select('reps.id as direccionamiento_id')
                    ->join('contratos', 'contratos.id', 'tarifas.contrato_id')
                    ->join('codigo_propio_tarifas', 'codigo_propio_tarifas.tarifa_id', 'tarifas.id')
                    ->join('reps', 'reps.id', 'tarifas.rep_id')
                    ->where('codigo_propio_tarifas.codigo_propio_id', $data->codigoPropio->id)
                    ->where('contratos.entidad_id', $afiliado->entidad_id)
                    ->where('tarifas.rep_id', $ParametrosDireccionamiento->rep_id)
                    ->where('tarifas.activo', 1)
                    ->where('contratos.activo', 1)
                    ->first();

                if ($rep) {
                    return $rep;
                }
            }
        }

        return null;
    }
}
