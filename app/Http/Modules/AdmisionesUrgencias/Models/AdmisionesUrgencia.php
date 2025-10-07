<?php

namespace App\Http\Modules\AdmisionesUrgencias\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Contratos\Models\Contrato;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Evoluciones\Models\Evolucion;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Urgencias\NotaEnfermeria\Models\NotasEnfermeriaUrgencia;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmisionesUrgencia extends Model
{
    use HasFactory;

    protected $table = 'admisiones_urgencias';

    protected $fillable = [
        'causa_muerte',
        'causa_externa',
        'estado_urgencia',
        'estado_salida',
        'estado_id',
        'afiliado_id',
        'fecha_salida',
        'destino_usuario',
        'nombre_acompanante',
        'telefono_acompanante',
        'direccion_acompanante',
        'user_id',
        'via_ingreso',
        'observacion',
        'contrato_id',
        'firma_afiliado',
        'firma_acompanante',
        'observacion_inasistencia',
        'especialidad',
        'codigo_centro_regulador',
        'adjunto'
    ];

    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class, 'afiliado_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function reps(){
        return $this->belongsTo(Rep::class, 'sede_id');
    }

    public function contratos(){
        return $this->belongsTo(Contrato::class, 'contrato_id');
    }

    public function consulta()
    {
        return $this->hasOne(Consulta::class,'admision_urgencia_id');
    }

    public function evolucion()
    {
        return $this->hasMany(Evolucion::class,'admision_urgencia_id');
    }

    public function notaEnfermeria()
    {
        return $this->hasMany(NotasEnfermeriaUrgencia::class,'admision_urgencia_id');
    }

}
