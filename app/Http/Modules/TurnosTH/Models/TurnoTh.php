<?php

namespace App\Http\Modules\TurnosTH\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TurnoTh extends Model
{
    use SoftDeletes;

    protected $guarded = [];    

}
