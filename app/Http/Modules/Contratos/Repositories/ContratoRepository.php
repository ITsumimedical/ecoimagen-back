<?php

namespace App\Http\Modules\Contratos\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Contratos\Models\Contrato;
use App\Http\Modules\NovedadContratos\Models\novedadContrato;
use Error;
use Illuminate\Support\Facades\Auth;

class ContratoRepository extends RepositoryBase
{

    protected $model;

    public function __construct()
    {
        $this->model = new Contrato();
        parent::__construct($this->model);
    }

    /**
     * Lista los contratos
     * @param Object $data
     * @return Collection
     * @author David Peláez
     * @edit kobatime
     */
    public function listarContrato($data)
    {
        $consulta = $this->model->with(['prestador.municipio.departamento', 'ambito', 'entidad'])->WherePrestadorNit($data->nit);

        return $data->page ? $consulta->paginate($data->cant) : $consulta->get();

    }

    public function buscarContrato($contrato_id)
    {
        $consulta = $this->model->where('id', $contrato_id)
            ->with(['novedadContratos' => function ($query) {
                $query->select(
                    'novedad_contratos.id as id',
                    'novedad_contratos.descripcion',
                    'novedad_contratos.contrato_id',
                    'novedad_contratos.created_at',
                    'empleados.primer_apellido',
                    'empleados.primer_nombre',
                    'empleados.segundo_apellido',
                    'empleados.segundo_nombre'
                )
                    ->join('empleados', 'empleados.user_id', 'novedad_contratos.user_id')
                    ->orderBy('novedad_contratos.id', 'desc');
            }]);
        return $consulta->first();
    }

    public function crearContrato($data)
    {
        $consulta = Contrato::where('entidad_id', $data['entidad_id'])->where('prestador_id', $data['prestador_id'])->first();
        if ($consulta) {
            return response()->json('Una entidad no puede tener mas de un contrato', 400);
        } else {
            $consulta = $this->model->create([
                'fecha_termina' => $data['fecha_termina'],
                'descripcion' => $data['descripcion'],
                'prestador_id' => $data['prestador_id'],
                'ambito_id' => $data['ambito_id'],
                'entidad_id' => $data['entidad_id'],
                'pgp' => $data['PGP'],
                'capitado' => $data['capitado'],
                'evento' => $data['evento'],
            ]);
        }
        return $consulta;
    }

    /**
     * retorn los contratos segun el prestador
     * @param prestador_id
     */
    public function listarPorPrestador($prestador_id)
    {
        return $this->model->where('prestador_id', $prestador_id)
            ->with(['entidad', 'ambito','prestador'])
            ->get();
    }

    /**
     * consulta un contrato
     * @param contrato_id
     */
    public function consultarContrato($contrato_id){
        return $this->model->where('id', $contrato_id)
            //->with(['entidad', 'ambito', 'prestador'])
            ->with('novedades','novedades.usuario.operador','novedades.adjuntoNovedadContratos')
            ->first();
    }

    /**
     * Obtiene la plantilla para la carga masiva de contratos.
     *
     * @return array
     * @throws Exception Si ocurre un error al generar la plantilla.
     */
    public function plantilla(): array
    {
            $consulta=  [
                [
                    'codigo_habilitacion_prestador' => '',
                    'ambito_id'                     => '',
                    'fecha_inicio'                  => '',
                    'fecha_termina'                 => '',
                    'capitado'                      => '',
                    'pgp'                           => '',
                    'evento'                        => '',
                    'poliza'                        => '',
                    'renovacion'                    => '',
                    'modificacion'                  => '',
                    'descripcion'                   => '',
                    'tipo_reporte'                  => '',
                    'linea_negocio'                 => '',
                    'regimen'                       => '',
                    'documento_proveedor_id'        => '',
                    'documento_proveedor'           => '',
                    'naturaleza_juridica'           => '',
                    'componente'                    => '',
                    'tipo_servicio'                 => '',
                    'tipo_relacion'                 => '',
                    'codigo_contrato'               => '',
                    'obj_contrato'                  => '',
                    'poblacion_cubierta'            => '', // Corregido el nombre del índice
                    'modalidad_pago'                => '',
                    'otra_modalidad'                => '',
                    'tipo_modificacion'             => '',
                    'valor_contrato'                => '',
                    'valor_adicion'                 => '',
                    'valor_ejecutado'               => '',
                    'estado'                        => '',
                    'union_temporal'                => '',
                    'union_temporal_id'             => '',
                    'tipo_proveedor'                => '',
                    'tipo_red'                      => '',
                ],
            ];
            $appointments = Collect($consulta);
            $array = json_decode($appointments, true);
            return $array;
    }
}
