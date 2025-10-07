<?php

namespace App\http\Modules\Referencia\Models;

use App\Http\Modules\Chat\Models\canal;
use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Cie10\Models\Cie10;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\http\Modules\Referencia\AdjuntosReferencia\Models\AdjuntoReferencia;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Departamentos\Models\Departamento;
use App\Http\Modules\Ordenamiento\Models\Orden;

class Referencia extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'tipo_anexo',
        'especialidad_remision',
        'tipo_solicitud',
        'codigo_remision',
        'afiliado_id',
        'rep_id',
        'descripcion',
        'cie10_id',
        'estado_id',
        'user_id',
        'fecha_cierre'
    ];

    public function cie10s()
    {
        return $this->belongsToMany(Cie10::class, 'cie10_referencias')->withTimestamps();
    }

    public function adjuntoReferencia()
    {
        return $this->hasMany(AdjuntoReferencia::class);
    }

    public function afiliados()
    {
        return $this->belongsTo(afiliado::class, 'afiliado_id');
    }

    public function canal()
    {
        return $this->hasOne(canal::class);
    }


    public function rep()
    {
        return $this->belongsTo(Rep::class, 'rep_id');
    }

    public function orden()
    {
        return $this->belongsTo(Orden::class, 'codigo_remision');
    }

    public function scopeWhereListarPendientes($query, $anexo, $documento, $id, $departamento, $fechaFin, $fechaInicio)
    {

        $consulta = $query->select(
            'referencias.id',
            'referencias.afiliado_id',
            'referencias.tipo_anexo',
            'referencias.tipo_solicitud',
            'referencias.created_at',
            'reps.nombre as rep_nombre',
            'reps.correo1 as rep_correo1',
            'reps.correo2 as rep_correo2',
            'reps.telefono1 as rep_telefono1',
            'reps.telefono2 as rep_telefono2',
            'reps.direccion as rep_direccion',
            'municipios.nombre as municipio_nombre',
            'departamentos.nombre as departamento_nombre',
            'estados.nombre as estado',
            'referencias.especialidad_remision',
            'referencias.descripcion'
        )
            ->join('estados', 'estados.id', 'referencias.estado_id')
            ->join('reps', 'reps.id', 'referencias.rep_id')
            ->join('municipios', 'municipios.id', 'reps.municipio_id')
            ->join('departamentos', 'departamentos.id', 'municipios.departamento_id')
            ->orderBy('referencias.created_at', 'asc')
            ->with([
                'afiliados.entidad',
                'afiliados.tipoDocumento',
                'afiliados.TipoAfiliado',
                'afiliados.EstadoAfiliado',
                'afiliados.municipio_afiliacion',
                'afiliados.departamento_afiliacion',
                'cie10s',
                'canal.mensajes.user.operador',
                'adjuntoReferencia'
            ])
            ->whereIn('referencias.tipo_anexo', $anexo)
            ->where('referencias.estado_id', 10);

        if ($documento) {
            $consulta->whereHas('afiliados', function ($query) use ($documento) {
                $query->where('numero_documento', $documento);
            });
        }

        if ($id) {
            $consulta->where('referencias.id', $id);
        }

        if ($departamento) {
            $departamentoSelect = Departamento::where('nombre', 'LIKE', '%' . $departamento . '%')->first();
            $consulta->whereHas('afiliados', function ($query) use ($departamentoSelect) {
                $query->where('departamento_afiliacion_id', $departamentoSelect->id);
            });
        }

        if ($fechaInicio && $fechaFin) {
            $consulta->whereBetween('referencias.created_at', [$fechaInicio . ' 00:00:00.000', $fechaFin . ' 23:59:59.999']);
        }

        return $consulta;
    }

    public function scopeWhereListarSegumiento($query, $anexo, $documento, $id, $departamento, $fechaFin, $fechaInicio)
    {
        $consulta = $query->select(
            'referencias.id',
            'referencias.afiliado_id',
            'referencias.tipo_anexo',
            'referencias.codigo_remision',
            'referencias.tipo_solicitud',
            'referencias.created_at',
            'reps.nombre as rep_nombre',
            'reps.correo1 as rep_correo1',
            'reps.correo2 as rep_correo2',
            'reps.telefono1 as rep_telefono1',
            'reps.telefono2 as rep_telefono2',
            'reps.direccion as rep_direccion',
            'municipios.nombre as municipio_nombre',
            'departamentos.nombre as departamento_nombre',
            'estados.nombre as estado',
            'referencias.especialidad_remision',
            'referencias.descripcion'
        )
            ->join('estados', 'estados.id', 'referencias.estado_id')
            ->join('reps', 'reps.id', 'referencias.rep_id')
            ->join('municipios', 'municipios.id', 'reps.municipio_id')
            ->join('departamentos', 'departamentos.id', 'municipios.departamento_id')
            ->with([
                'afiliados.entidad',
                'afiliados.tipoDocumento',
                'afiliados.TipoAfiliado',
                'afiliados.EstadoAfiliado',
                'afiliados.municipio_afiliacion',
                'afiliados.departamento_afiliacion',
                'cie10s',
                'canal.mensajes' => function ($query) {
                    $query->orderBy('created_at', 'asc')->with('user.operador');
                },
                'adjuntoReferencia'
            ])
            ->whereIn('referencias.tipo_anexo', $anexo)
            ->where('referencias.estado_id', 19)
            ->orderBy('referencias.created_at', 'asc');

        if ($documento) {
            $consulta->whereHas('afiliados', function ($query) use ($documento) {
                $query->where('numero_documento', $documento);
            });
        }

        if ($id) {
            $consulta->where('referencias.id', $id);
        }

        if ($departamento) {
            $departamentoSelect = Departamento::where('nombre', 'LIKE', '%' . $departamento . '%')->first();
            $consulta->whereHas('afiliados', function ($query) use ($departamentoSelect) {
                $query->where('departamento_afiliacion_id', $departamentoSelect->id);
            });
        }

        if ($fechaInicio && $fechaFin) {
            $consulta->whereBetween('referencias.created_at', [$fechaInicio . ' 00:00:00.000', $fechaFin . ' 23:59:59.999']);
        }

        return $consulta;
    }



    public function scopeWhereListarProcesados($query, $anexo, $documento, $id, $departamento, $fechaFin, $fechaInicio)
    {

        $consulta =  $query->select(
            'referencias.id',
            'referencias.afiliado_id',
            'referencias.tipo_anexo',
            'referencias.tipo_solicitud',
            'referencias.codigo_remision',
            'referencias.created_at',
            'reps.nombre as rep_nombre',
            'reps.correo1 as rep_correo1',
            'reps.correo2 as rep_correo2',
            'reps.telefono1 as rep_telefono1',
            'reps.telefono2 as rep_telefono2',
            'reps.direccion as rep_direccion',
            'municipios.nombre as municipio_nombre',
            'departamentos.nombre as departamento_nombre',
            'estados.nombre as estado',
            'referencias.especialidad_remision',
            'referencias.descripcion'
        )
            ->join('estados', 'estados.id', 'referencias.estado_id')
            ->join('reps', 'reps.id', 'referencias.rep_id')
            ->join('municipios', 'municipios.id', 'reps.municipio_id')
            ->join('departamentos', 'departamentos.id', 'municipios.departamento_id')
            ->orderBy('referencias.created_at', 'asc')
            ->with([
                'orden',
                'orden.procedimientos',
                'afiliados.entidad',
                'afiliados.tipoDocumento',
                'afiliados.TipoAfiliado',
                'afiliados.EstadoAfiliado',
                'afiliados.municipio_afiliacion',
                'afiliados.departamento_afiliacion',
                'cie10s',
                 'canal.mensajes' => function ($query) {
                    $query->orderBy('created_at', 'asc')->with('user.operador');
                },
                'adjuntoReferencia'
            ])
            ->where('referencias.tipo_anexo', $anexo)
            ->where('referencias.estado_id', 17);

        if ($documento) {
            $consulta->whereHas('afiliados', function ($query) use ($documento) {
                $query->where('numero_documento', $documento);
            });
        }

        if ($id) {
            $consulta->where('referencias.id', $id);
        }

        if ($departamento) {
            $departamentoSelect = Departamento::where('nombre', 'LIKE', '%' . $departamento . '%')->first();
            $consulta->whereHas('afiliados', function ($query) use ($departamentoSelect) {
                $query->where('departamento_afiliacion_id', $departamentoSelect->id);
            });
        }

        if ($fechaInicio && $fechaFin) {
            $consulta->whereBetween('referencias.created_at', [$fechaInicio . ' 00:00:00.000', $fechaFin . ' 23:59:59.999']);
        }


        return $query;
    }


    public function scopeWhereListarProcesadorPrestador($query, $anexo, $rep_id, $documento)
    {

        $consulta = $query->select(
            'referencias.id',
            'referencias.afiliado_id',
            'referencias.tipo_anexo',
            'referencias.tipo_solicitud',
            'referencias.codigo_remision',
            'referencias.created_at',
            'reps.nombre as rep_nombre',
            'reps.correo1 as rep_correo1',
            'reps.correo2 as rep_correo2',
            'reps.telefono1 as rep_telefono1',
            'reps.telefono2 as rep_telefono2',
            'reps.direccion as rep_direccion',
            'municipios.nombre as municipio_nombre',
            'departamentos.nombre as departamento_nombre',
            'estados.nombre as estado',
            'referencias.especialidad_remision',
            'referencias.descripcion'
        )
            ->join('estados', 'estados.id', 'referencias.estado_id')
            ->join('reps', 'reps.id', 'referencias.rep_id')
            ->join('municipios', 'municipios.id', 'reps.municipio_id')
            ->join('departamentos', 'departamentos.id', 'municipios.departamento_id')
            ->with([
                'afiliados.entidad',
                'afiliados.tipoDocumento',
                'afiliados.TipoAfiliado',
                'afiliados.EstadoAfiliado',
                'afiliados.municipio_afiliacion',
                'afiliados.departamento_afiliacion',
                'cie10s',
                'canal.mensajes.user.operador',
                'adjuntoReferencia'
            ])
            ->whereIn('referencias.tipo_anexo', $anexo)
            ->where('referencias.rep_id', $rep_id)
            ->where('referencias.estado_id', 17);

        if ($documento) {
            $consulta->whereHas('afiliados', function ($query) use ($documento) {
                $query->where('numero_documento', $documento);
            });
        }

        return $consulta;
    }

    public function scopeWhereRep($query, $rep_id, $datos)
    {
        $consulta = $query->select(
            'referencias.id',
            'referencias.afiliado_id',
            'referencias.tipo_anexo',
            'referencias.tipo_solicitud',
            'referencias.created_at',
            'reps.nombre as rep_nombre',
            'reps.correo1 as rep_correo1',
            'reps.correo2 as rep_correo2',
            'reps.telefono1 as rep_telefono1',
            'reps.telefono2 as rep_telefono2',
            'reps.direccion as rep_direccion',
            'municipios.nombre as municipio_nombre',
            'departamentos.nombre as departamento_nombre',
            'estados.nombre as estado',
            'referencias.especialidad_remision',
            'referencias.descripcion'
        )
            ->join('estados', 'estados.id', 'referencias.estado_id')
            ->join('reps', 'reps.id', 'referencias.rep_id')
            ->join('municipios', 'municipios.id', 'reps.municipio_id')
            ->join('departamentos', 'departamentos.id', 'municipios.departamento_id')
            ->with([
                'afiliados.entidad',
                'afiliados.tipoDocumento',
                'afiliados.TipoAfiliado',
                'afiliados.EstadoAfiliado',
                'afiliados.municipio_afiliacion',
                'afiliados.departamento_afiliacion',
                'cie10s',
                'canal.mensajes.user.operador',
                'adjuntoReferencia'
            ])
            ->whereIn('referencias.estado_id', [19, 10])
            ->where('referencias.rep_id', $rep_id);

        if ($datos->anexo) {
            $consulta->whereIn('referencias.tipo_anexo', $datos->anexo);
        }
        if ($datos->estado) {
            $consulta->where('referencias.estado_id', $datos->estado);
        }
        if ($datos->cedula) {
            $consulta->whereHas('afiliados', function ($query) use ($datos) {
                $query->where('numero_documento', $datos->cedula);
            });
        }
        if ($datos->idReferencia) {
            $query->where('referencias.id', $datos->idReferencia);
        }
        return $consulta;
    }

    protected $casts = [
        'created_at' => 'date:Y-m-d',
    ];
}
