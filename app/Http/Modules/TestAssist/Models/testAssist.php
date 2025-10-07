<?php

namespace App\Http\Modules\TestAssist\Models;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class testAssist extends Model
{
    use HasFactory;
    protected $fillable = ['resultadoItemA', 'resultadoItemB', 'resultadoItemC', 'resultadoItemD', 'resultadoItemE', 'resultadoItemF', 'resultadoItemG', 'resultadoItemH', 'resultadoItemI', 'resultadoItemJ','resultadoItemW','resultadoItemX', 'interpretacion_item8', 'consulta_id'];
    protected $table = "test_assist";
    
    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
