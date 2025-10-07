<?php

namespace App\Http\Modules\Rips\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RipsHospitalizacion extends Model
{
    use HasFactory;

    protected $table = 'rips_hospitalizaciones';
    protected $guarded = [];
}
