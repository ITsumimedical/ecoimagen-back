<?php

namespace App\Http\Modules\Tanner\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscalaTanner extends Model
{
    use HasFactory;
    protected $fillable = ['mamario_mujeres', 'pubiano_mujeres', 'genital_hombres', 'pubiano_hombres', 'consulta_id'];
    public function consulta() {
        return $this->belongsTo(Consulta::class);
    }
}
