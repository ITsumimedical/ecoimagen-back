<?php

namespace App\Http\Modules\RemisionProgramas\Model;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RemisionProgramas extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'remision_programas';

    protected $fillable = ['consulta_id', 'remision_programa', 'observacion'];

    protected $dates = ['deleted_at'];

    public function Consulta()
    {
        return $this->belongsTo(Consulta::class, 'consulta_id');
    }
}
