<?php

namespace App\Http\Modules\TiposContratosTH\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoContratoTh extends Model
{
    use SoftDeletes;

    protected $guarded = [];

}
