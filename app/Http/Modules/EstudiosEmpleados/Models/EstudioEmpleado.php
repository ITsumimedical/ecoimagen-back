<?php

namespace App\Http\Modules\EstudiosEmpleados\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EstudioEmpleado extends Model
{
    use SoftDeletes;

    protected $guarded = [];


}
