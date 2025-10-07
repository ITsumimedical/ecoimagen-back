<?php

namespace App\Http\Modules\TipoCampo\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoCampo extends Model
{
    use SoftDeletes;

    protected $guarded = [];

}
