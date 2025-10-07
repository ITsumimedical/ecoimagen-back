<?php

namespace App\Http\Modules\SucesionEvolutiva\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class SucesionEvolutiva extends Model
{
    use HasFactory;

    protected $fillable = [
        'sucesion_evolutiva_conducta',
        'sucesion_evolutiva_lenguaje',
        'sucesion_evolutiva_area',
        'sucesion_evolutiva_conducta_personal',
        'consulta_id',
        'creado_por'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->creado_por = Auth::id();
            }
        });
    }


    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
