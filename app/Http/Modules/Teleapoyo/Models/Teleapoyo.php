<?php

namespace App\Http\Modules\Teleapoyo\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Cie10\Models\Cie10;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Modules\AdjuntoTeleapoyo\Models\AdjuntoTeleapoyo;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Especialidades\Models\Especialidade;
use App\Http\Modules\IntegrantesJuntaGirs\Models\IntegrantesJuntaGirs;
use App\Http\Modules\TipoSolicitud\Models\TipoSolicitude;
use App\Http\Modules\Usuarios\Models\User;

class Teleapoyo extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function cie10s()
    {
        return $this->belongsToMany(Cie10::class);
    }

    public function adjuntos()
    {
        return $this->hasMany(AdjuntoTeleapoyo::class);
    }

    public function integrantes()
    {
        return $this->hasMany(IntegrantesJuntaGirs::class);
    }

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }

    public function especialidad()
    {
        return $this->belongsTo(Especialidade::class);
    }

    public function tipoSolicitud()
    {
        return $this->belongsTo(TipoSolicitude::class, "tipo_solicitudes_id");
    }

    public function userCrea()
    {
        return $this->belongsTo(User::class, "user_crea_id");
    }


    public function scopeWhereBuscarPermiso($query, $data)
    {
        $query->select(
            'teleapoyos.*',
            'afiliados.numero_documento',
            'afiliados.tipo_documento',
            'especialidades.nombre as especialidad',
            'tipo_solicitudes.nombre as tipo_solicitud',
            'afiliados.edad_cumplida',
            'afiliados.id as idAfiliado',
            'afiliados.telefono',
            'afiliados.celular1',
            'afiliados.celular2',
            'afiliados.correo1',
            'afiliados.region',
            'reps.nombre as sede',
            'operadores.documento as registro_medico',
            'es.nombre as especialidad_medico',
            'afiliados.correo2',
            'users.firma'
        )
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ', afiliados.primer_apellido) as nombre_afiliado")
            ->selectRaw("CONCAT(operadores.nombre, ' ', operadores.apellido) as nombre_empleado")
            ->join('users', 'teleapoyos.user_crea_id', 'users.id')
            ->leftJoin('operadores', 'users.id', 'operadores.user_id')
            ->leftJoin('especialidades as es', 'operadores.especialidad_id', 'es.id')
            ->join('afiliados', 'teleapoyos.afiliado_id', 'afiliados.id')
            ->join('reps', 'reps.id', 'afiliados.ips_id')
            ->join('especialidades', 'teleapoyos.especialidad_id', 'especialidades.id')
            ->join('tipo_solicitudes', 'teleapoyos.tipo_solicitudes_id', 'tipo_solicitudes.id')
            ->where('teleapoyos.estado_id', 10)
            ->whereNotIn('teleapoyos.tipo_estrategia', ['Junta Aseguramiento', 'Junta Profesionales'])
            ->whereNull('teleapoyos.girs_auditor')
            ->whereNull('teleapoyos.deleted_at')
            ->with(['cie10s', 'adjuntos']);

        if (isset($data['filtro']['tipo_solicitudes_id']) && $data['filtro']['tipo_solicitudes_id'] != 'Todos') {
            $query->where('teleapoyos.tipo_solicitudes_id', $data['filtro']['tipo_solicitudes_id']);
        }

        if (isset($data['filtro']['documento']) && $data['filtro']['documento'] != null) {
            $query->where('afiliados.numero_documento', $data['filtro']['documento']);
        }

        if (isset($data['filtro']['fecha_inicio']) && $data['filtro']['fecha_inicio'] != null) {
            $query->whereDate('teleapoyos.created_at', '>=', $data['filtro']['fecha_inicio']);
        }

        if (isset($data['filtro']['fecha_fin']) && $data['filtro']['fecha_fin'] != null) {
            $query->whereDate('teleapoyos.created_at', '<=', $data['filtro']['fecha_fin']);
        }

        return $query->orderBy('teleapoyos.created_at', 'asc');
    }

    public function scopeWhereBuscar($query, $data)
    {

        $query->select(
            'teleapoyos.id',
            'motivo_teleorientacion',
            'resumen_historia_clinica',
            'respuesta',
            'pertinente',
            'girs',
            'observacion_reasignacion_girs',
            'teleconcepto_pertinente',
            'observacion_teleconcepto_pertinente',
            'ordenamiento_pertinente',
            'observacion_pertinente_ordenamiento',
            'institucion_prestadora',
            'eapb',
            'evaluacion_junta',
            'junta_aprueba',
            'girs_auditor',
            'pertinencia_prioridad',
            'pertinencia_evaluacion',
            'teleapoyos.estado_id as estadoTele',
            'tipo_solicitudes_id',
            'afiliado_id',
            'user_crea_id',
            'user_responde_id',
            'teleapoyos.especialidad_id',
            'teleapoyos.created_at',
            'teleapoyos.updated_at',
            'consulta_id',
            'afiliados.tipo_documento',
            'afiliados.numero_documento',
            'afiliados.primer_nombre',
            'tipo_solicitudes.nombre as tipo_solicitud',
            'afiliados.segundo_nombre',
            'afiliados.primer_apellido',
            'afiliados.segundo_apellido',
            'afiliados.edad_cumplida',
            'reps.nombre as sede',
            'afiliados.telefono',
            'afiliados.celular1',
            'afiliados.celular2',
            'afiliados.correo1',
            'especialidades.nombre as especialidad',
            'teleapoyos.tipo_estrategia',
            'afiliados.correo2',
            'operadores.documento as registro_medico',
            'es.nombre as especialidad_medico',
            'afiliados.id as idAfiliado',
            'afiliados.region',
            'users.firma'
        )
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ',afiliados.primer_apellido) as nombre_afiliado")
            ->selectRaw("CONCAT(operadores.nombre,' ',operadores.apellido) as nombre_empleado")
            ->join('afiliados', 'teleapoyos.afiliado_id', 'afiliados.id')
            ->join('users', 'teleapoyos.user_crea_id', 'users.id')
            ->join('reps', 'reps.id', 'afiliados.ips_id')
            ->leftjoin('operadores', 'users.id', 'operadores.user_id')
            ->leftjoin('especialidades as es', 'operadores.especialidad_id', 'es.id')
            ->join('especialidades', 'teleapoyos.especialidad_id', 'especialidades.id')
            ->join('tipo_solicitudes', 'teleapoyos.tipo_solicitudes_id', 'tipo_solicitudes.id')
            ->with(['cie10s', 'adjuntos'])
            ->where('teleapoyos.estado_id', 10)
            ->where('teleapoyos.user_crea_id', auth()->user()->id)
            ->whereNotIn('teleapoyos.tipo_estrategia', ['Junta Aseguramiento', 'Junta Profesionales'])
            ->whereNull('teleapoyos.girs_auditor');
        if (isset($data['filtro']['tipo_solicitudes_id']) && $data['filtro']['tipo_solicitudes_id'] != 'Todos') {
            $query->where('teleapoyos.tipo_solicitudes_id', $data['filtro']['tipo_solicitudes_id']);
        }

        if (isset($data['filtro']['documento']) && $data['filtro']['documento'] != null) {
            $query->where('afiliados.numero_documento', $data['filtro']['documento']);
        }

        if (isset($data['filtro']['fecha_inicio']) && $data['filtro']['fecha_inicio'] != null) {
            $query->whereDate('teleapoyos.created_at', '>=', $data['filtro']['fecha_inicio']);
        }

        if (isset($data['filtro']['fecha_fin']) && $data['filtro']['fecha_fin'] != null) {
            $query->whereDate('teleapoyos.created_at', '<=', $data['filtro']['fecha_fin']);
        }
        return $query->orderBy('teleapoyos.created_at', 'asc');
    }

    public function scopeWhereListarGirs($query)
    {
        $query->select(
            'teleapoyos.id',
            'motivo_teleorientacion',
            'resumen_historia_clinica',
            'respuesta',
            'pertinente',
            'girs',
            'observacion_reasignacion_girs',
            'teleconcepto_pertinente',
            'observacion_teleconcepto_pertinente',
            'ordenamiento_pertinente',
            'observacion_pertinente_ordenamiento',
            'institucion_prestadora',
            'eapb',
            'evaluacion_junta',
            'junta_aprueba',
            'girs_auditor',
            'pertinencia_prioridad',
            'pertinencia_evaluacion',
            'teleapoyos.estado_id as estadoTele',
            'tipo_solicitudes_id',
            'afiliado_id',
            'user_crea_id',
            'user_responde_id',
            'teleapoyos.especialidad_id',
            'teleapoyos.created_at',
            'teleapoyos.updated_at',
            'consulta_id',
            'afiliados.primer_nombre',
            'afiliados.segundo_nombre',
            'afiliados.primer_apellido',
            'afiliados.segundo_apellido',
            'afiliados.edad_cumplida',
            'afiliados.tipo_documento',
            'afiliados.numero_documento',
            'afiliados.telefono',
            'afiliados.celular1',
            'afiliados.celular2',
            'afiliados.correo1',
            'afiliados.correo2',
            'operadores.documento as registro_medico',
            // 'especialidades.nombre as especialidadaMedico',
            'entidades.nombre as entidad',
            'reps.nombre as sede',
            'es.nombre as especialidad',
            'tipo_solicitudes.nombre as tipo',
            'afiliados.region',
            'tipo_solicitudes.id as idTipo',
            'teleapoyos.tipo_estrategia',
            'users.firma'
        )
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ',afiliados.primer_apellido) as nombre_afiliado")
            ->selectRaw("CONCAT(operadores.nombre,' ',operadores.apellido) as nombre_medico")
            ->join('afiliados', 'afiliados.id', 'teleapoyos.afiliado_id')
            ->join('users', 'users.id', 'teleapoyos.user_crea_id')
            ->leftjoin('operadores', 'operadores.user_id', 'users.id')
            // ->leftjoin('especialidades','especialidades.id','empleados.especialidad_id')
            ->join('entidades', 'entidades.id', 'afiliados.entidad_id')
            ->leftjoin('reps', 'reps.id', 'afiliados.ips_id')
            ->join('especialidades as es', 'teleapoyos.especialidad_id', 'es.id')
            ->join('tipo_solicitudes', 'teleapoyos.tipo_solicitudes_id', 'tipo_solicitudes.id')
            ->with(['cie10s', 'adjuntos', 'integrantes'])
            ->where('teleapoyos.estado_id', 10)
            ->where('teleapoyos.tipo_estrategia', 'Junta Aseguramiento');

        return $query;
    }

    public function scopeWhereListarSolucionados($query, $cedulaAfiliado)
    {
        $query->select(
            'teleapoyos.id',
            'motivo_teleorientacion',
            'resumen_historia_clinica',
            'respuesta',
            'pertinente',
            'girs',
            'observacion_reasignacion_girs',
            'teleconcepto_pertinente',
            'observacion_teleconcepto_pertinente',
            'ordenamiento_pertinente',
            'observacion_pertinente_ordenamiento',
            'institucion_prestadora',
            'eapb',
            'evaluacion_junta',
            'junta_aprueba',
            'girs_auditor',
            'pertinencia_prioridad',
            'pertinencia_evaluacion',
            'teleapoyos.estado_id as estadoTele',
            'tipo_solicitudes_id',
            'afiliado_id',
            'user_crea_id',
            'user_responde_id',
            'teleapoyos.especialidad_id',
            'teleapoyos.created_at',
            'teleapoyos.updated_at',
            'consulta_id',
            'afiliados.primer_nombre',
            'afiliados.segundo_nombre',
            'afiliados.primer_apellido',
            'afiliados.segundo_apellido',
            'afiliados.edad_cumplida',
            'afiliados.tipo_documento',
            'afiliados.numero_documento',
            'afiliados.telefono',
            'afiliados.celular1',
            'afiliados.celular2',
            'afiliados.correo1',
            'afiliados.correo2',
            'operadores.documento as registro_medico',
            'especialidades.nombre as especialidadaMedico',
            'entidades.nombre as entidad',
            'reps.nombre as sede',
            'es.nombre as especialidad',
            'tipo_solicitudes.nombre as tipo',
            'tipo_solicitudes.id as idTipo',
            'afiliados.region',
            'teleapoyos.tipo_estrategia',
            'users.firma'
        )
            ->selectRaw("CONCAT(operadores.nombre,' ',operadores.apellido) as nombre_medico")
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ',afiliados.primer_apellido) as nombre_afiliado")
            ->selectRaw("CONCAT(e.nombre,' ',e.apellido) as nombre_medicoRegistra")
            ->join('afiliados', 'afiliados.id', 'teleapoyos.afiliado_id')
            ->leftjoin('users', 'users.id', 'teleapoyos.user_responde_id')
            ->leftjoin('operadores', 'operadores.user_id', 'users.id')
            ->join('users as u', 'u.id', 'teleapoyos.user_crea_id')
            ->leftjoin('operadores as e', 'e.user_id', 'u.id')
            ->leftjoin('especialidades', 'especialidades.id', 'operadores.especialidad_id')
            ->join('entidades', 'entidades.id', 'afiliados.entidad_id')
            ->leftjoin('reps', 'reps.id', 'afiliados.ips_id')
            ->join('especialidades as es', 'teleapoyos.especialidad_id', 'es.id')
            ->join('tipo_solicitudes', 'teleapoyos.tipo_solicitudes_id', 'tipo_solicitudes.id')
            ->with(['cie10s', 'adjuntos', 'integrantes'])
            ->where('teleapoyos.estado_id', 9)
            ->where('afiliados.numero_documento', $cedulaAfiliado)
            ->orderBy('teleapoyos.id', 'asc');

        return $query;
    }

    protected $casts = [
        'created_at' => 'date:Y-m-d',
        'updated_at' => 'date:Y-m-d',
        'girs' => 'boolean'
    ];

    public function scopeWhereListarJuntaProfesional($query)
    {
        $query->select(
            'teleapoyos.id',
            'motivo_teleorientacion',
            'resumen_historia_clinica',
            'respuesta',
            'pertinente',
            'girs',
            'observacion_reasignacion_girs',
            'teleconcepto_pertinente',
            'observacion_teleconcepto_pertinente',
            'ordenamiento_pertinente',
            'observacion_pertinente_ordenamiento',
            'institucion_prestadora',
            'eapb',
            'evaluacion_junta',
            'junta_aprueba',
            'girs_auditor',
            'pertinencia_prioridad',
            'pertinencia_evaluacion',
            'teleapoyos.estado_id as estadoTele',
            'tipo_solicitudes_id',
            'afiliado_id',
            'user_crea_id',
            'user_responde_id',
            'teleapoyos.especialidad_id',
            'teleapoyos.created_at',
            'teleapoyos.updated_at',
            'consulta_id',
            'afiliados.primer_nombre',
            'afiliados.segundo_nombre',
            'afiliados.primer_apellido',
            'afiliados.segundo_apellido',
            'afiliados.edad_cumplida',
            'afiliados.tipo_documento',
            'afiliados.numero_documento',
            'afiliados.telefono',
            'afiliados.celular1',
            'afiliados.celular2',
            'afiliados.correo1',
            'afiliados.correo2',
            'operadores.documento as registro_medico',
            'especialidades.nombre as especialidadaMedico',
            'entidades.nombre as entidad',
            'reps.nombre as sede',
            'es.nombre as especialidad',
            'tipo_solicitudes.nombre as tipo',
            'afiliados.region',
            'tipo_solicitudes.id as idTipo',
            'teleapoyos.tipo_estrategia'
        )
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ',afiliados.primer_apellido) as nombre_afiliado")
            ->selectRaw("CONCAT(operadores.nombre,' ',operadores.apellido) as nombre_medico")
            ->join('afiliados', 'afiliados.id', 'teleapoyos.afiliado_id')
            ->join('users', 'users.id', 'teleapoyos.user_crea_id')
            ->leftjoin('operadores', 'operadores.user_id', 'users.id')
            ->leftjoin('especialidades', 'especialidades.id', 'operadores.especialidad_id')
            ->join('entidades', 'entidades.id', 'afiliados.entidad_id')
            ->leftjoin('reps', 'reps.id', 'afiliados.ips_id')
            ->join('especialidades as es', 'teleapoyos.especialidad_id', 'es.id')
            ->join('tipo_solicitudes', 'teleapoyos.tipo_solicitudes_id', 'tipo_solicitudes.id')
            ->with(['cie10s', 'adjuntos', 'integrantes'])
            ->where('teleapoyos.estado_id', 10)
            ->where('teleapoyos.tipo_estrategia', 'Junta Profesionales');

        return $query;
    }
}
