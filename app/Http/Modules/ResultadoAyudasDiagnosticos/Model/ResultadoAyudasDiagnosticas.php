<?php

namespace App\Http\Modules\ResultadoAyudasDiagnosticos\Model;

use App\Http\Modules\AdjuntosAyudasDiagnosticos\Models\AdjuntosAyudasDiagnosticos;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResultadoAyudasDiagnosticas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = ['consulta_id', 'cup_id', 'observaciones', 'user_registra_id', 'resultado', 'fecha_realizacion'];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
    public function cups()
    {
        return $this->belongsTo(Cup::class, 'cup_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_registra_id');
    }

    public function adjuntos()
    {
        return $this->hasMany(AdjuntosAyudasDiagnosticos::class, 'resultado_ayudas_diagnosticas_id');
    }
}
