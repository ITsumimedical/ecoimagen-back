<?php

namespace App\Http\Modules\Historia\Neuropsicologia\Models;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Neuropsicologia extends Model
{
    use HasFactory;

    protected $table = 'neuropsicologias';

    protected $fillable = [
        'estado_animo_comportamiento',
        'actividades_basicas_instrumentales',
        'nivel_pre_morbido',
        'composicion_familiar',
        'evolucion_pruebas',
        'consulta_id',
        'created_by',
    ];

    protected static function boot()
    {
        parent::boot();
        // este metodo lo que hace es agregar el usuario que creo la agenda, cada que se creee un nuevo registro
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });
    }

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
