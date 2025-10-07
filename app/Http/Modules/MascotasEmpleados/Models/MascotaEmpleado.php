<?php

namespace App\Http\Modules\MascotasEmpleados\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MascotaEmpleado extends Model
{
    use SoftDeletes;

    protected $guarded = [];

}
