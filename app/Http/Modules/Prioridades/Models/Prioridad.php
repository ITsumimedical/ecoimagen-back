<?php

namespace App\Http\Modules\Prioridades\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prioridad extends Model
{
    use SoftDeletes;

    protected $table = 'prioridades';
    protected $guarded = [];

}
