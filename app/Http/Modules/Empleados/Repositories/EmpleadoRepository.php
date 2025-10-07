<?php

namespace App\Http\Modules\Empleados\Repositories;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\ContratosEmpleados\Models\ContratoEmpleado;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\EvaluacionDesempeño\evaluaciones_desempeños\Models\EvaluacionesDesempeno;
use App\Http\Modules\EvaluacionDesempeño\Calificacion_Competencia\Models\CalificacionCompetencia;
use Carbon\Carbon;

class EmpleadoRepository extends RepositoryBase
{
    protected $empleadoModel;

    public function __construct(Empleado $empleadoModel){
    //    $empleadoModel = new Empleado();
       parent::__construct($empleadoModel);
       $this->empleadoModel = $empleadoModel;
    }

    public function informacionEmpleadoCedula($documento)
    {
        $empleado = Empleado::select('empleados.id', 'empleados.documento', 'empleados.primer_nombre',
        'empleados.segundo_nombre', 'empleados.primer_apellido', 'empleados.segundo_apellido', 'empleados.genero',
        'empleados.identidad_genero', 'empleados.fecha_nacimiento', 'empleados.fecha_expedicion_documento',
        'empleados.rh', 'empleados.estado_civil', 'empleados.grupo_etnico', 'empleados.cabeza_hogar', 'empleados.peso',
        'empleados.altura', 'empleados.direccion_residencia', 'empleados.barrio', 'empleados.area_residencia', 'empleados.telefono',
        'empleados.celular', 'empleados.celular2', 'empleados.email_personal', 'empleados.email_corporativo',
        'empleados.descripcion', 'empleados.nivel_estudio', 'empleados.victima', 'empleados.discapacidad',
        'descripcion_discapacidad', 'empleados.ajuste_puesto', 'empleados.edad', 'empleados.indice_masa_corporal',
        'empleados.medico', 'empleados.registro_medico', 'empleados.tipo_documento_id', 'empleados.orientacion_sexual_id',
        'empleados.municipio_expedicion_id', 'empleados.municipio_nacimiento_id', 'empleados.municipio_residencia_id',
        'empleados.areath_id', 'empleados.user_id', 'empleados.sede_id', 'empleados.jefe_inmediato_id',
        'empleados.th_tipo_plantilla_id', 'empleados.estado_id', 'cargos.nombre as cargo', 'contrato_empleados.fecha_ingreso', 'contrato_empleados.fecha_retiro',
        'contrato_empleados.tipo_contrato_id')
        ->leftjoin('contrato_empleados', 'empleados.id', 'contrato_empleados.empleado_id')
        ->leftjoin('cargos', 'contrato_empleados.cargo_id', 'cargos.id')
        ->where('contrato_empleados.activo', 1 )
        ->where('empleados.documento', $documento)->first();
        return $empleado;
    }

    public function informacionEmpleado($documento)
    {
        return Empleado::select(
            'empleados.documento','empleados.primer_apellido',
            'empleados.segundo_apellido','empleados.primer_nombre','empleados.segundo_nombre',
            'empleados.genero','empleados.identidad_genero','empleados.fecha_nacimiento',
            'empleados.fecha_expedicion_documento','empleados.rh','empleados.estado_civil',
            'empleados.grupo_etnico','empleados.cabeza_hogar','empleados.peso',
            'empleados.altura','empleados.direccion_residencia','empleados.barrio',
            'empleados.area_residencia','empleados.telefono','empleados.celular','empleados.celular2',
            'empleados.email_personal','empleados.email_corporativo','empleados.descripcion',
            'empleados.nivel_estudio','empleados.victima','empleados.discapacidad',
            'empleados.descripcion_discapacidad','empleados.ajuste_puesto','empleados.edad',
            'empleados.indice_masa_corporal','empleados.medico','empleados.registro_medico' ,
            'evaluaciones_desempenos.fecha_inicial_periodo',
            'evaluaciones_desempenos.fecha_final_periodo', 'cargos.nombre as cargo',
            'tipo_documentos.nombre as tipoDocumento')
        ->selectRaw("CONCAT(empleados.primer_nombre,' ',empleados.segundo_nombre,' ',empleados.primer_apellido,' ',empleados.segundo_apellido) as nombre_completo")
        ->leftjoin('evaluaciones_desempenos', 'evaluaciones_desempenos.empleado_id', 'empleados.id')
        ->leftjoin('cargos', 'empleados.areath_id', 'cargos.id')
        ->leftjoin('tipo_documentos', 'empleados.tipo_documento_id', 'tipo_documentos.id')
        ->where('empleados.documento', $documento)
        ->first();

    }

    // public function informacionEmpleadoDocumento($documento)
    // {
    //     $empleado = Empleado::select('empleados.id', 'empleados.documento', 'empleados.primer_nombre',
    //     'empleados.segundo_nombre', 'empleados.primer_apellido', 'empleados.segundo_apellido', 'empleados.genero',
    //     'empleados.identidad_genero', 'empleados.fecha_nacimiento', 'empleados.fecha_expedicion_documento',
    //     'empleados.rh', 'empleados.estado_civil', 'empleados.grupo_etnico', 'empleados.cabeza_hogar', 'empleados.peso',
    //     'empleados.altura', 'empleados.direccion_residencia', 'empleados.barrio', 'empleados.area_residencia', 'empleados.telefono',
    //     'empleados.celular', 'empleados.celular2', 'empleados.email_personal', 'empleados.email_corporativo',
    //     'empleados.descripcion', 'empleados.nivel_estudio', 'empleados.victima', 'empleados.discapacidad',
    //     'descripcion_discapacidad', 'empleados.ajuste_puesto', 'empleados.edad', 'empleados.indice_masa_corporal',
    //     'empleados.medico', 'empleados.registro_medico', 'empleados.tipo_documento_id', 'empleados.orientacion_sexual_id',
    //     'empleados.municipio_expedicion_id', 'empleados.municipio_nacimiento_id', 'empleados.municipio_residencia_id',
    //     'empleados.areath_id', 'empleados.user_id', 'empleados.especialidad_id', 'empleados.sede_id', 'empleados.jefe_inmediato_id',
    //     'empleados.th_tipo_plantilla_id', 'empleados.estado_id')
    //     ->where('empleados.documento', $documento)->first();
    //     return $empleado;
    // }

    /**
     * Consultar empleado por nombre, documento, correo
     *
     * @param  mixed $data
     * @return void
     */
    public function informacionEmpleadoDocumento($data){
        $cedula = $data->cedula;
        return User::where('email', $data->correo)->orWhereHas('empleado', function($query) use ($cedula){
            $query->where('documento', $cedula);
        })->get();
    }

    public function listarEmpleadosJefe()
    {
        $empleados = Empleado::where('empleados.jefe_inmediato_id', auth()->id())
        ->leftjoin('contrato_empleados', 'empleados.id', 'contrato_empleados.empleado_id')
        ->with(
            'contratoEmpleado',
        )->whereHas('contratoEmpleado',function ($q){
            $q->where('activo', '=', 1);
        })->whereNotIn('empleados.id', function($q) {
            $q->from('evaluaciones_desempenos')->select('evaluaciones_desempenos.empleado_id')
                                                ->where('evaluaciones_desempenos.esta_activo', 0)
                                                ;
        })->get();
        // $empleados = $this->empleadoModel->where('jefe_inmediato_id', auth()->id())->get();
        return $empleados;
    }

    public function listarColaboradoresConCompromisos()
    {
        $empleadoConCompromiso = EvaluacionesDesempeno::select(
                'empleados.documento',
                'o.documento as jefeDocumento',
                'cargos.nombre as cargoJefe',
                'c.nombre as cargoEmpleado',
                'evaluaciones_desempenos.id as idEvaluacion',
                'evaluaciones_desempenos.resultado'
            )
            ->selectRaw("CONCAT(empleados.primer_nombre,' ',empleados.primer_apellido,' ',empleados.segundo_nombre,' ',empleados.segundo_apellido) as nombre_completo")
            ->join('calificacion_competencias', 'evaluaciones_desempenos.id', 'calificacion_competencias.evaluaciones_desempeno_id')
            ->join('empleados', 'evaluaciones_desempenos.empleado_id', 'empleados.id')
            ->join('operadores as o', 'evaluaciones_desempenos.evaluador_id', 'o.user_id')
            ->leftjoin('contrato_empleados', 'o.id', 'contrato_empleados.empleado_id')
            ->leftjoin('cargos', 'contrato_empleados.cargo_id', 'cargos.id')
            ->leftjoin('contrato_empleados as ce', 'empleados.id', 'ce.empleado_id')
            ->leftjoin('cargos as c', 'ce.cargo_id', 'c.id')
            ->whereIn('calificacion_competencias.calificacion', [1,2,3])
            ->where('empleados.jefe_inmediato_id', auth()->id())
            ->distinct()
            ->get();

        return $empleadoConCompromiso;
    }

    public function listarCompromisosEvaluacion($documento)
    {
        $listarCompromisosEvaluacion = EvaluacionesDesempeno::select('calificacion_competencias.id as clasificacion_id',
        'empleados.documento', 'empleados.genero', 'empleados.email_corporativo',
        'evaluaciones_desempenos.esta_activo', 'calificacion_competencias.calificacion', 'empleados.celular', 'empleados.estado_civil',
        'th_competencias.competencia', 'th_pilars.nombre as pilar', 'cargos.nombre as cargo'
        )
        ->selectRaw("CONCAT(empleados.primer_nombre,' ',empleados.primer_apellido,' ',empleados.segundo_nombre,' ',empleados.segundo_apellido) as nombre_completo")
        ->join('calificacion_competencias', 'evaluaciones_desempenos.id', 'calificacion_competencias.evaluaciones_desempeno_id')
        ->join('th_competencias', 'calificacion_competencias.th_competencia_id', 'th_competencias.id')
        ->join('th_pilars', 'th_competencias.th_pilar_id', 'th_pilars.id')
        ->join('empleados', 'evaluaciones_desempenos.empleado_id', 'empleados.id')
        ->leftjoin('contrato_empleados', 'empleados.id', 'contrato_empleados.empleado_id')
        ->leftjoin('cargos', 'contrato_empleados.cargo_id', 'cargos.id')
        ->whereIn('calificacion_competencias.calificacion', [1,2,3])
        ->where('empleados.documento', $documento)
        ->get();

        return $listarCompromisosEvaluacion;
    }

    public function buscarEmpleado($id){

        $empleado = $this->empleadoModel::find($id);

        return $empleado;
    }
    /**
     * consultar Empleado Con Filtro de cedula, nombre, correo
     *
     * @author Calvarez
     */
    public function consultarEmpleadoConFiltro($request)
    {
        $cedula = $request->cedula;
        $nombreCompleto = $request->nombreCompleto;
        $correo = $request->correo;

        $query = Empleado::query();

        // Filtro por cédula
        if ($cedula) {
            $query->where('documento', $cedula);
        }

        // Filtro por correo institucional
        if ($correo) {
            $query->where('email_corporativo', $correo);
        }

        // Filtro por nombre completo
        if ($nombreCompleto) {
            $query->whereRaw("CONCAT_WS(' ', TRIM(primer_nombre), COALESCE(TRIM(segundo_nombre), ''), TRIM(primer_apellido), TRIM(segundo_apellido)) ILIKE ?", ["%$nombreCompleto%"]);
        }

        return $query->get();
    }

    /**
     * Crear nuevo empleado
     *
     * @param  mixed $request
     * @return void
     */
    public function crearEmpleado($request)
    {
        return $this->empleadoModel->create($request);
    }

    /**
     * lista  empleado activo
     *
     * @return void
     */
    public function informacionEmpleadoActivo()
    {
        return $this->empleadoModel
        ->where('estado_id',1)->get();
    }


    public function buscaEmpleadoPorIdUsuario($user_id)
    {
        return $this->empleadoModel->select('empleados.id','documento','primer_nombre','users.email')
        ->join('users','empleados.user_id','users.id')
        ->where('user_id',$user_id)->first();
    }

    /**
     * listarMedicoPorSede - listar medico por sede
     *
     * @param  mixed $id
     * @return void
     */
    public function listarMedicoPorSede($id){
        $medicos = Empleado::select(
           'empleados.primer_nombre', 'empleados.id', 'empleados.user_id', 'empleados.primer_apellido','empleados.segundo_nombre',
           'empleados.segundo_apellido','empleados.sede_id',
       )
       ->where('empleados.sede_id', $id)
       ->where('empleados.medico', true)
       ->get();

       return $medicos;
   }

    public function firma($data){

        $imagen = $data['firma'];


        $base64Data = preg_replace('/^data:image\/(png|jpeg|jpg);base64,/', '', $imagen);

        $base64Data = preg_replace('/[^A-Za-z0-9\/\+=]/', '', $base64Data);

        // $binaryData = base64_decode($base64Data);

// Intenta eliminar caracteres no válidos

 return (Object)[
    'consulta' => $imagen,
    'teleapoyo' => $base64Data

];


// // Decodifica la cadena base64 a datos binarios
//   return







            //  $imagenS = mb_substr($data['firma'], strpos($data['firma'], ",")+1);
            // $imagen = base64_decode($imagenS);
            // return $imagen;



        // $this->empleadoModel::where('id',$data['empleado_id'])
        // ->update([
        //     'firma' => $data['firma']
        // ]);

    }

    /**
     * inactivar
     *
     * @param  mixed $id
     * @return void
     */
    public function inactivar($id){
        return $this->empleadoModel->where('empleados.id',$id)->update([
            'deleted_at' => Carbon::today()
        ]);
    }

    /**
     * informacionEmpleadoContratado - lista los empleados con contrato activo
     *
     * @return void
     */
    public function informacionEmpleadoContratado()
    {
        return $this->empleadoModel->select('users.id as user_id','estado_id', 'contrato_empleados.activo', 'primer_nombre', 'segundo_nombre', 'primer_apellido', 'segundo_apellido')
        ->join('users','empleados.user_id','users.id')
        ->leftJoin('contrato_empleados', 'empleados.id', 'contrato_empleados.empleado_id')
        ->where('contrato_empleados.activo',1)->get();
    }


}
