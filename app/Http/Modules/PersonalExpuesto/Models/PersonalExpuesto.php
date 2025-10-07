<?php

namespace App\Http\Modules\PersonalExpuesto\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonalExpuesto extends Model
{
    use HasFactory;

    protected $fillable = ['razon_social','nacionalidad','relacion','entidad','cargo','estado_id','sarlaft_id'];
}
