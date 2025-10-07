<?php

namespace App\Http\Modules\Camas\Models;

use App\Http\Modules\AsignacionCamas\Models\AsignacionCama;
use App\Http\Modules\Pabellones\Models\Pabellon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cama extends Model
{
    use HasFactory;
    protected $fillable = ['nombre','descripcion','precio','pabellon_id','estado_id','created_by','updated_by'];

    public function pabellon()
    {
        return $this->hasOne(Pabellon::class);
    }

    public function asignacionCama()
    {
        return $this->hasMany(AsignacionCama::class);
    }
}
