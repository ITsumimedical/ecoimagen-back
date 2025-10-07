<?php

namespace App\Http\Modules\DemandaInducida\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\DemandaInducida\Models\DemandaInducida;
use App\Http\Modules\Historia\AntecedentesPersonales\Models\AntecedentePersonale;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DemandaInducidaRepository extends RepositoryBase
{
    protected $demandaInducidaModel;

    public function __construct(DemandaInducida $demandaInducidaModel)
    {
        $this->demandaInducidaModel = $demandaInducidaModel;
        parent::__construct($demandaInducidaModel);
    }

    public function listarDemandaInducida($request)
    {
        $demanda = $this->demandaInducidaModel
            ->select(
                'demanda_inducidas.id',
                'demanda_inducidas.tipo_demanda_inducida',
                'demanda_inducidas.programa_remitido',
                'demanda_inducidas.fecha_dx_riesgo_cardiovascular',
                'demanda_inducidas.descripcion_evento_salud_publica',
                'demanda_inducidas.descripcion_otro_programa',
                'demanda_inducidas.observaciones',
                'demanda_inducidas.demanda_inducida_efectiva',
                'demanda_inducidas.fecha_registro',
                'afiliados.tipo_documento',
                'tipo_documentos.nombre as Documento',
                'afiliados.numero_documento',
                'afiliados.edad_cumplida as Edad_Afiliado',
                'afiliados.departamento_atencion_id',
                'departamentos.nombre as nombre_departamento',
                'afiliados.municipio_atencion_id',
                'municipios.nombre as municipio_atencion_nombre',
                'users.id as usuario_registra_id',
                'demanda_inducidas.consulta_1_id',
                'demanda_inducidas.consulta_2_id',
                'demanda_inducidas.consulta_3_id',
                'demanda_inducidas.afiliado_id',
                'estado1.id as estado1',
                'estado2.id as estado2',
                'estado3.id as estado3',
            )
            ->join('afiliados', 'demanda_inducidas.afiliado_id', 'afiliados.id')
            ->join('tipo_documentos','afiliados.tipo_documento', 'tipo_documentos.id')
            ->join('departamentos', 'departamentos.id', 'afiliados.departamento_atencion_id')
            ->leftjoin('municipios', 'municipios.id', 'afiliados.municipio_atencion_id')
            ->join('users', 'demanda_inducidas.usuario_registra_id', 'users.id')
            ->leftjoin('consultas as consulta1', 'consulta1.id', 'demanda_inducidas.consulta_1_id')
            ->leftjoin('estados as estado1', 'estado1.id', 'consulta1.estado_id')
            ->leftjoin('consultas as consulta2', 'consulta2.id', 'demanda_inducidas.consulta_2_id')
            ->leftjoin('estados as estado2', 'estado2.id', 'consulta2.estado_id')
            ->leftjoin('consultas as consulta3', 'consulta3.id', 'demanda_inducidas.consulta_3_id')
            ->leftjoin('estados as estado3', 'estado3.id', 'consulta3.estado_id')
            ->leftjoin('operadores', 'users.id', 'operadores.user_id')
            ->with(['afiliado' => function($afiliado) {
                $afiliado->with([
                    'tipoDocumento',
                    'ips' => function($query) {
                        $query->select('nombre', 'id');
                    }
                ]);
            }])
            ->selectRaw("CONCAT(operadores.nombre, ' ', operadores.apellido) as nombre_completo");

            if ($request['cedula']) {
                $demanda->whereHas('afiliado', function ($query) use ($request) {
                    $query->where('numero_documento', $request['cedula']);
                });
            }

        if (isset($request['page'])) {
            return $demanda->paginate($request['cantidad']);
        } else {
            return $demanda->get();
        }
    }

    public function asignarCitaDemandaInducida($id, $consulta_id)
    {
        // Encuentra la demanda inducida por su ID
        $demandaInducida = DemandaInducida::find($id);
        // Actualiza el campo correspondiente en demanda_inducidas
        if (!$demandaInducida->consulta_1_id) {
            $demandaInducida->consulta_1_id = $consulta_id;
        } elseif (!$demandaInducida->consulta_2_id) {
            $demandaInducida->consulta_2_id = $consulta_id;
        } elseif (!$demandaInducida->consulta_3_id) {
            $demandaInducida->consulta_3_id = $consulta_id;
        }

        // Guarda los cambios en demanda_inducidas
        $demandaInducida->save();
        // Encuentra todos los antecedentes personales asociados a esta demanda inducida
        $antecedentes = AntecedentePersonale::where('demanda_inducida_id', $id)->get();
        foreach ($antecedentes as $antecedente) {
            // Actualiza los campos correspondientes en antecedentes personales
            if ($demandaInducida->consulta_1_id == $consulta_id) {
                $antecedente->consulta_1_demanda = $consulta_id;
            } elseif ($demandaInducida->consulta_2_id == $consulta_id) {
                $antecedente->consulta_2_demanda = $consulta_id;
            } elseif ($demandaInducida->consulta_3_id == $consulta_id) {
                $antecedente->consulta_3_demanda = $consulta_id;
            }

            // Guarda los cambios en antecedentes personales
            $antecedente->save();
        }
        return response()->json(['mensaje' => 'Cita Registrada y Antecedentes Actualizados!']);
    }

    public function eliminarDemandaInducida($request){

        $this->demandaInducidaModel->where('demanda_inducidas.id', $request->id)->update([
            'deleted_at' => Carbon::now()
        ]);

        DB::table('antecedente_personales')
            ->where('demanda_inducida_id', $request->id)
            ->update(['deleted_at' => Carbon::now()]);

        return response()->json(['message' => 'Demanda inducida y antecedentes personales eliminados correctamente.']);
    }


}
