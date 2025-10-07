<?php

namespace App\Http\Modules\Inicio\Models;

use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Boletines extends Model
{
    use HasFactory;

    protected $table = 'boletines';

    protected $cast = [
        'activo' => 'boolean',
    ];

    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'url',
        'activo',
        'cargado_por',
        'created_at',
        'updated_at'
    ];

    public function cargadoPor()
    {
        return $this->belongsTo(User::class, 'cargado_por');
    }

    // Accessor para asegurar que 'activo' sea un booleano
    public function getActivoAttribute($value)
    {
        return (bool) $value;
    }
}
