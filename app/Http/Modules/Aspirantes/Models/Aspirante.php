<?php

namespace App\Http\Modules\Aspirantes\Models;

use App\Http\Modules\Estados\Models\Estado;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Aspirante extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }

}
