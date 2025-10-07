<?php

namespace App\Http\Modules\ServiciosTH\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ServicioTh extends Model
{
    use SoftDeletes;

    protected $guarded = [];    

}
