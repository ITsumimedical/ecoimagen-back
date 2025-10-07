<?php

namespace App\Http\Modules\Cie10Afiliado\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cie10Afiliado extends Model
{
    use HasFactory;

    protected $fillable = ['cie10_id','consulta_id','esprimario','tipo_diagnostico'];

    public function cie10()
    {
        return $this->belongsTo(Cie10::class);
    }

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
