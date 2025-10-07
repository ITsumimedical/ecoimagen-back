<?php

namespace App\Http\Modules\Patologia\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AntecedentesPatologias extends Model
{
    use HasFactory;

    protected $fillable = ['consulta_id', 'patologia_cancer_actual', 'fdx_cancer_actual', 'flaboratorio_patologia', 'tumor_segunda_biopsia', 'localizacion_cancer', 'dukes', 'gleason', 'her2', 'estadificacion_clinica', 'estadificacion_inicial', 'fecha_estadificacion'];
}
