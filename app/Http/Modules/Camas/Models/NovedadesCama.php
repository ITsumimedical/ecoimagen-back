<?php

namespace App\Http\Modules\Camas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NovedadesCama extends Model
{
    use HasFactory;

    protected $fillable = ['descripcion','cama_id','tipo_id','created_by'];
}
