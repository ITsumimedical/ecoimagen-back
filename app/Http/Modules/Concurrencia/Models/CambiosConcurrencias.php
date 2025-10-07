<?php

namespace App\Http\Modules\Concurrencia\Models;

use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CambiosConcurrencias extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'actualizacion',
        'fecha_aplicacion',
        'concurrencia_id',
        'ingreso_concurrencia_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ingresoConcurrencia()
    {
        return $this->hasMany(IngresoConcurrencia::class, 'ingreso_concurrencia_id');
    }
}
