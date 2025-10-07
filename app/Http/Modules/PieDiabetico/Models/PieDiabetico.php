<?php

namespace App\Http\Modules\PieDiabetico\Models;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PieDiabetico extends Model
{
    use HasFactory;

    protected $fillable = ['grado', 'presencia', 'estadio', 'descripcion', 'consulta_id'];
    protected $table = "pie_diabetico";
    
    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}