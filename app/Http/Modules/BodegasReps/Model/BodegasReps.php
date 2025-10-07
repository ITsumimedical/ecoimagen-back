<?php

namespace App\Http\Modules\BodegasReps\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodegasReps extends Model
{
    use HasFactory;

    protected $fillable = ['bodega_id', 'rep_id'];
}
