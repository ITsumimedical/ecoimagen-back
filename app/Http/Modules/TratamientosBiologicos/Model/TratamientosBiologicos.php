<?php

namespace App\Http\Modules\TratamientosBiologicos\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class TratamientosBiologicos extends Model
{
    use HasFactory;

    protected $fillable = [
        'consulta_id',
        'recibe_tratamiento',
        'descripcion_tratamiento',
        'created_by',
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'consulta_id');
    }

    public function usuarioRegistra()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });
    }
}
