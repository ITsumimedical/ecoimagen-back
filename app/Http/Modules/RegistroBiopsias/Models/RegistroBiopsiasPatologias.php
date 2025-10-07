<?php

namespace App\Http\Modules\RegistroBiopsias\Models;

use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RegistroBiopsiasPatologias extends Model
{
    use HasFactory;

    protected $fillable = [
        'cie10_id',
        'afiliado_id',
        'consulta_id',
        'fecha_inicial_biopsia',
        'fecha_final_biopsia',
        'lateralidad',
        'fecha_inicio_patologia',
        'fecha_final_patologia',
        'created_by',
        'updated_by'
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });

        static::updating(function ($model) {
            if (Auth::check()) {
                $model->updated_by = Auth::id();
            }
        });
    }

    public function cie10()
    {
        return $this->belongsTo(Cie10::class, 'cie10_id');
    }

    public function usuarioCrea()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

     public function usuarioActualiza()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
