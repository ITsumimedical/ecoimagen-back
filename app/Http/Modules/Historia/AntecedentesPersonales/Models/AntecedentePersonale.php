<?php

namespace App\Http\Modules\Historia\AntecedentesPersonales\Models;

use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AntecedentePersonale extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'patologias', 'otras', 'tipo', 'fecha_diagnostico', 'cual', 'descripcion', 'medico_registra', 'consulta_id','consulta_1_demanda', 'consulta_2_demanda', 'consulta_3_demanda', 'demanda_inducida_id', 'afiliado_id', 'cie10_id'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'medico_registra');
    }
}
