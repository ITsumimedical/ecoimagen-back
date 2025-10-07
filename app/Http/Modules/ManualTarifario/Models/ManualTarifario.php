<?php

namespace App\Http\Modules\ManualTarifario\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ManualTarifario extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $table = 'manual_tarifarios';

    /** Relaciones */

    /** Scopes */

    /** Sets y Gets */

}
