<?php

namespace App\Http\Modules\AreaClinica\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AreaClinica extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'areas_clinica';
    /** Relaciones */

    /** Scopes */

    /** Sets y Gets */

}
