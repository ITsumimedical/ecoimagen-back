<?php

namespace App\Http\Modules\Historia\Models;

use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class AdherenciaFarmacoterapeutica extends Model
{
    use HasFactory;

    protected $table = 'adherencia_farmacoterapeutica';

    protected $fillable = [
        'user_id',
        'consulta_id',
        'criterio_quimico',
        'dejado_medicamento',
        'dias_notomomedicamento',
        'finsemana_notomomedicamento',
        'finsemana_olvidomedicamento',
        'hora_indicada',
        'porcentaje',
    ];
 protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->user_id = Auth::id();
            }
        });
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
