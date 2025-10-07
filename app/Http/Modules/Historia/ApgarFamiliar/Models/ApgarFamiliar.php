<?php

namespace App\Http\Modules\Historia\ApgarFamiliar\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ApgarFamiliar extends Model
{
    use HasFactory;

    protected $fillable = [
        'ayuda_familia',
        'familia_habla_con_usted',
        'cosas_nuevas',
        'le_gusta_familia_hace',
        'le_gusta_familia_comparte',
        'resultado',
        'medico_registra',
        'consulta_id',
        'interpretacion_resultado'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    protected $casts = ['created_at' => 'datetime:Y-m-d'];

    public function user()
    {
        return $this->belongsTo(User::class, 'medico_registra');
    }
}
