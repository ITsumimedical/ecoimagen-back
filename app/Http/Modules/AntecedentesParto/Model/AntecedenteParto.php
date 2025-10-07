<?php

namespace App\Http\Modules\AntecedentesParto\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AntecedenteParto extends Model
{
    use HasFactory;

    protected $fillable = [
        'edad_gestacional',
        'tipo_parto',
        'presentacion_cefalica',
        'inducido_pitocin',
        'forceps',
        'cesarea',
        'descipricion_cesarea',
        'peso',
        'talla',
        'anoxia',
        'reanimacion',
        'incubadora',
        'descripcion_incubadora',
        'tiempo_incubadora',
        'succion',
        'malformaciones',
        'descripcion_malformaciones',
        'desnutricion',
        'ictericia',
        'descripcion_ictericia',
        'convulsiones',
        'descripcion_convulsiones',
        'alta_hospitalaria',
        'hipoglucemia',
        'consulta_id',
        'creador_por'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->creador_por = Auth::id();
            }
        });
    }


    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function creadoPor()
    {
        return $this->belongsTo(User::class, 'creador_por');
    }
}
