<?php

namespace App\Http\Modules\EtiquetasTH\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EtiquetaTh extends Model
{
    use SoftDeletes;

    protected $guarded = [];    

}
