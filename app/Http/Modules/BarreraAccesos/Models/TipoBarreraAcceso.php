<?php

namespace App\Http\Modules\BarreraAccesos\Models;

use App\Http\Modules\Estados\Models\Estado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoBarreraAcceso extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'estado_id',
    ];

    protected $attributes = [
        'estado_id' => 1
    ];

    public function estadoBarreraAcceso()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
