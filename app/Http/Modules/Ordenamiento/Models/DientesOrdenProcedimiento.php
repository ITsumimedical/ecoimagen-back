<?php

namespace App\Http\Modules\Ordenamiento\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DientesOrdenProcedimiento extends Model
{
    use HasFactory;
    protected $table = "dientes_orden_procedimientos";
    protected $fillable=['diente','fecha','orden_procedimiento_id'];

    public function ordenProcedimiento()
    {
        return $this->belongsTo(OrdenProcedimiento::class,'orden_procedimiento_id');
    }
}
