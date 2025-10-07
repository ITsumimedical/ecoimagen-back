<?php

namespace App\Http\Modules\Cums\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Cums\Models\Cum;
use App\Http\Modules\Medicamentos\Models\Medicamento;

class CumRepository extends RepositoryBase
{
    protected $model;

    public function __construct()
    {
        $this->model = new Cum();
        parent::__construct($this->model);
    }

    /**
     * lista los cums
     * @param $data
     * @return Collection
     */
    public function listar($data)
    {
        $orden = isset($data->orden) ? $data->orden : 'desc';
        $filas = $data->filas ? $data->filas : 10;

        $consulta = $this->model
            ->orderBy('created_at', $orden);

        return $data->page ? $consulta->paginate($filas) : $consulta->get();
    }
    public function getCums($expediente)
    {
        $cums = Cum::select(['id', 'cum_validacion', 'producto', 'titular', 'registro_sanitario', 'estado_registro', 'fecha_vencimiento', 'descripcion_comercial', 'muestra_medica'])
            ->where('expediente', 'ILIKE', "%" . $expediente . "%")
            ->orWhere('producto', 'ILIKE', "%" . $expediente . "%")
            ->get()
            ->toArray();

        return response()->json($cums);
    }
    public function EncontrarCum($cumValidacion)
    {
        $cum = Cum::select([
            "cums.titular",
            "cums.principio_activo",
            "cums.registro_sanitario",
            "cums.expediente",
            "cums.cum_validacion",
            "cums.fecha_vencimiento",
            "cums.descripcion_comercial",
            "cums.estado_cum",
            "cums.muestra_medica",
            "cums.estado_registro",
            "cums.producto"
        ])->where('cum_validacion', $cumValidacion)->first();

        return $cum;
    }


    //     public function Buscarcodesumi($nombre) {
    //         return Codesumi::where('codigo', 'ILIKE', "%{$nombre}%")
    //                  ->orWhere('nombre', 'ILIKE', "%{$nombre}%")
    //                  ->get();
    //    }
    public function listarPrincipios($principio_activo)
    {
        return Cum::where('principio_activo', 'ILIKE', "%{$principio_activo}%")
            ->where('estado_cum', 'Activo')
            ->get();
    }

    public function crearCum($data)
    {

        if ($data->consecutivo_cum == null) {
            $consecutivo = 0;
        } else {
            $consecutivo = $data->consecutivo_cum;
        }
        $cum_validacion =  $data->expediente . '-' . $consecutivo;

        $cum = Cum::create([
            'expediente' => $data->expediente,
            'producto' => $data->producto,
            'titular' => $data->titular,
            'registro_sanitario' => $data->registro_sanitario,
            'fecha_expedicion' => $data->fecha_expedicion,
            'fecha_vencimiento' => $data->fecha_vencimiento,
            'estado_registro' => 'Vigente',
            'expediente_cum' => $data->expediente_cum,
            'consecutivo_cum' => $consecutivo,
            'cantidad_cum' => $data->cantidad_cum,
            'descripcion_comercial' => $data->descripcion_comercial,
            'estado_cum' => 'Activo',
            'fecha_activo' => $data->fecha_activo,
            'fecha_inactivo' => $data->fecha_inactivo,
            'muestra_medica' => $data->muestra_medica,
            'unidad' => $data->unidad,
            'atc' => $data->atc,
            'descripcion_atc' => $data->descripcion_atc,
            'via_administracion' => $data->via_administracion,
            'concentracion' => $data->concentracion,
            'principio_activo' => $data->principio_activo,
            'unidad_medida' => $data->unidad_medida,
            'cantidad' => $data->cantidad,
            'unidad_referencia' => $data->unidad_referencia,
            'forma_farmaceutica' => $data->forma_farmaceutica,
            'nombre_rol' => $data->nombre_rol,
            'tipo_rol' => $data->tipo_rol,
            'modalidad' => $data->modalidad,
            'cum_validacion' => $cum_validacion,
        ]);
        return true;
    }

    public function getmedicamentos($expediente)
    {
        $cums = Medicamento::select(
                ['medicamentos.id',
                 'cums.cum_validacion',
                  'cums.producto',
                   'cums.titular',
                    'cums.registro_sanitario', 
                    'cums.estado_registro', 
                    'cums.fecha_vencimiento', 
                    'cums.descripcion_comercial', 
                    'cums.muestra_medica']
            )
        ->join('cums', 'cums.cum_validacion', '=', 'medicamentos.cum')
        ->where('cums.estado_registro', 'Vigente')
        ->where('cums.expediente', 'ILIKE', "%" . $expediente . "%")
        ->orWhere('cums.producto', 'ILIKE', "%" . $expediente . "%")
        ->get()
        ->toArray();

        return response()->json($cums);
    }
}
