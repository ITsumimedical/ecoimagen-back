<?php

namespace App\Http\Modules\Pqrsf\AsignadosPqrsf\Model;

use App\Http\Modules\AreaResponsablePqrsf\Models\AreaResponsablePqrsf;
use App\Http\Modules\GestionPqrsf\Formulario\Models\Formulariopqrsf;
use App\Http\Modules\GestionPqrsf\Models\GestionPqrsf;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Asignado extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'asignados';

    public function areaResponsable()
    {
        return $this->belongsTo(AreaResponsablePqrsf::class);
    }


    public function gestionPqrsf()
    {
        return $this->hasMany(GestionPqrsf::class, 'formulario_pqrsf_id', 'formulario_pqrsf_id');
    }

    public function formulario_pqrsf()
    {
        return $this->belongsTo(Formulariopqrsf::class, 'formulario_pqrsf_id');
    }


}
