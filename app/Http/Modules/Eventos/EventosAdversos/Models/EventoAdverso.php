<?php

namespace App\Http\Modules\Eventos\EventosAdversos\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Eventos\Adjunto\Models\AdjuntoEventoAdverso;
use App\Http\Modules\Eventos\Analisis\Models\AnalisisEvento;
use App\Http\Modules\Eventos\Analisis\Models\MotivoAnulacionEvento;
use App\Http\Modules\Eventos\ClasificacionAreas\Models\ClasificacionArea;
use App\Http\Modules\Eventos\Sucesos\Models\Suceso;
use App\Http\Modules\Eventos\TipoEventos\Models\TipoEvento;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use App\Http\Modules\Medicamentos\Models\Medicamento;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventoAdverso extends Model
{
    use HasFactory;

    protected $casts = [
        'voluntariedad' => 'boolean',
        'afiliado_id' => 'integer',
        'estado_id' => 'integer',
        'suceso_id' => 'integer',
        'analisis_evento_id' => 'integer',
        'sede_ocurrencia_id' => 'integer',
    ];

    protected $fillable = [
        // REPORTE
        'suceso_id',
        'clasificacion_area_id',
        'tipo_evento_id',
        'profesional_id',
        'fecha_ocurrencia',
        'dosis',
        'frecuencia_administracion',
        'servicio_ocurrencia',
        'tiempo_infusion',
        'medicamento_id',
        'descripcion_hechos',
        'accion_tomada',
        'sede_ocurrencia_id',
        'sede_reportante_id',
        'estado_id',
        'afiliado_id',
        'relacion',
        'dispositivo_id',
        'referencia_dispositivo',
        'marca_dispositivo',
        'lote_dispositivo',
        'invima_dispositivo',
        'fabricante_dispositivo',
        'invima_equipo_biomedico',
        'nombre_equipo_biomedico',
        'marca_equipo_biomedico',
        'modelo_equipo_biomedico',
        'serie_equipo_biomedico',
        'fabricante_biomedico',
        'user_id',
        'clasif_tecnovigilancia',
        // ASIGNACIÓN
        'empleado_asignado',
        'priorizacion',
        'voluntariedad',
        'identificacion_riesgo',
        // ANULACIÓN
        'otros_motivo_anulacion',
        'motivo_anulacion_id',
        'clasificacion_anulacion',
        'servicio_reportante'

    ];

    public function tipoEvento()
    {
        return $this->belongsTo(TipoEvento::class);
    }

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function rep()
    {
        return $this->belongsTo(Rep::class);
    }

    public function clasificacionArea()
    {
        return $this->belongsTo(ClasificacionArea::class);
    }

    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class, 'medicamento_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

    public function motivoAnulacion()
    {
        return $this->belongsTo(MotivoAnulacionEvento::class);
    }

    public function suceso()
    {
        return $this->belongsTo(Suceso::class,);
    }

    public function adjuntos()
    {
        return $this->hasMany(AdjuntoEventoAdverso::class, 'evento_id');
    }

    public function sedeOcurrencia()
    {
        return $this->belongsTo(Rep::class, 'sede_ocurrencia_id');
    }

    public function sedeReporta()
    {
        return $this->belongsTo(Rep::class, 'sede_reportante_id');
    }

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class, 'afiliado_id');
    }

    public function analisisEvento(){
        return $this->hasOne(AnalisisEvento::class);
    }

    public function userRegistra()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function dipositivo()
    {
        return $this->belongsTo(Codesumi::class, 'dispositivo_id');
    }
}
