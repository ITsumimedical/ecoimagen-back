<?php

namespace App\Http\Modules\AdjuntosContratosEmpleados\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AdjuntoContratoEmpleado extends Model
{
    use SoftDeletes;

    protected $guarded = [];

}
