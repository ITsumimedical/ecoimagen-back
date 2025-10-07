<?php

namespace App\Http\Modules\FuncionRenal\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FuncionRenal extends Model
{
    use HasFactory;
    protected $fillable = ['resultado_cockcroft_gault', 'resultado_ckd_epi', 'valor_creatinina','consulta_id'];
    protected $table = "funcion_renal";
    
    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
