<?php

namespace App\Http\Modules\CategoriaHistorias\Models;

use App\Http\Modules\CampoHistorias\Models\CampoHistoria;
use App\Http\Modules\Citas\Models\Cita;
use App\Http\Modules\Especialidades\Models\Especialidade;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriaHistoria extends Model
{
    use SoftDeletes;

    protected $guarded = [];

   protected $cast=[
    'orden' => 'integer'
   ];

    public function campos(){
        return $this->hasMany(CampoHistoria::class,'categoria_historia_id');
    }


    public function citas()
    {
        return $this->belongsToMany(Cita::class);
    }

    public function especialidades(){
        return $this->belongsToMany(Especialidade::class);
    }

    public function CitaHistoria(){

        return $this->belongsToMany(Cita::class);
    }

    public function campoHistoria(){

        return $this->hasMany(CampoHistoria::class);
    }

}
