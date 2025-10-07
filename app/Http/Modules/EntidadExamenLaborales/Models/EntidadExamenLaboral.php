<?php

namespace App\Http\Modules\EntidadExamenLaborales\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntidadExamenLaboral extends Model
{
    use SoftDeletes;

    protected $guarded = [];

}
