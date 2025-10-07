<?php

namespace App\Http\Modules\HijosEmpleados\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\TipoDocumentos\Models\TipoDocumento;

class HijoEmpleado extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $appends = ['edad'];

    protected $casts = [
        'tipo_documento_id' => 'integer',
        'comparte_vivienda' => 'boolean',
        'afiliar_caja' => 'boolean',
        'afiliar_eps' => 'boolean',
        'depende_economicamente' => 'boolean',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class);
    }

    /**
     * obtiene la edad segun su fecha de nacimiento
     * @return integer
     */
    public function getEdadAttribute(){
        return Carbon::parse($this->fecha_nacimiento)->age;
    }

}
