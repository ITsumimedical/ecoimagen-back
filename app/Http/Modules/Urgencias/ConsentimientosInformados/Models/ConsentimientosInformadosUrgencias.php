<?php

namespace App\Http\Modules\Urgencias\ConsentimientosInformados\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ConsentimientosInformadosUrgencias extends Model
{
    use HasFactory;

    protected $fillable = ['tipo','fecha','servicio','canalizacion','terapias','toma_muestras','aspiracion','administracion_medicamento',
    'curaciones','sonda_oro','inmovilizacion','cateterismo','higiene_aseo','enemas','traslados','certifico','confirmacion_documento','confirmacion_paciente',
    'gases_arteriales','otro','doctor','acuerdo','retiro','observacion','firma_paciente','admision_urgencia_id','created_by'];

    public function usuario()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
