<?php

namespace App\Http\Modules\Socios\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Socios extends Model
{
    use HasFactory;

    protected $fillable = ['razon_social','tipo_doc','num_doc','participacion','descripcion_expuevincula','estado_id','sarlaft_id'];
}
