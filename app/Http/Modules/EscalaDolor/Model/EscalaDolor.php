<?php

namespace App\Http\Modules\EscalaDolor\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscalaDolor extends Model
{
    use HasFactory;

    protected $fillable = ['color_escala', 'descripcion', 'consulta_id'];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
