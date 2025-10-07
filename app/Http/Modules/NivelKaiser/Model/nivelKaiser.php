<?php

namespace App\Http\Modules\NivelKaiser\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nivelKaiser extends Model
{
    use HasFactory;
    protected $fillable = ['consulta_id', 'nivel_kaiser', 'descripcion_kaiser', 'afiliado_id'];
}
