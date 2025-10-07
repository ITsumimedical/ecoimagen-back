<?php

namespace App\Http\Modules\CapacitacionEmpleados\Models;

use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Municipios\Models\Municipio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CapacitacionEmpleado extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function municipio()
    {
        return $this->belongsTo(Municipio::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
}
