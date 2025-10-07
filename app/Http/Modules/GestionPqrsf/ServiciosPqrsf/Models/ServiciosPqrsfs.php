<?php

namespace App\Http\Modules\GestionPqrsf\ServiciosPqrsf\Models;

use App\Http\Modules\Cups\Models\Cup;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiciosPqrsfs extends Model
{
    use HasFactory;

    protected $table = 'servicios_pqrsf';

    protected $fillable = ['cup_id','formulario_pqrsf_id'];

    public function cup()
    {
        return $this->belongsTo(Cup::class);
    }
}
