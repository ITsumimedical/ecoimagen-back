<?php

namespace App\Http\Modules\Bodegas\Models;

use App\Http\Modules\Medicamentos\Models\Medicamento;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\ProgramasFarmacia\Models\ProgramasFarmacia;
use App\Http\Modules\ProgramasFarmacia\Models\ProgramasFarmaciaBodegas;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\SolicitudBodegas\Models\SolicitudBodega;
use App\Http\Modules\TipoBodega\Models\TipoBodegas;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bodega extends Model
{
    use HasFactory;

    protected $guarded = [];



    public function profile() {
        return $this->hasOne(SolicitudBodega::class,'bodega_destino_id','id');
      }

      public function user()
      {
          return $this->belongsToMany(User::class)->withTimestamps();
      }

      public function operador()
      {
          return $this->belongsToMany(Operadore::class,'user_id','user_id')->withTimestamps();
      }

      public function programasFarmacias()
      {
          return $this->belongsToMany(ProgramasFarmacia::class, 'programas_farmacia_bodegas', 'bodega_id', 'programa_farmacia_id');
      }
      public function reps()
      {
          return $this->belongsToMany(Rep::class, 'bodegas_reps', 'bodega_id', 'rep_id');
      }
      
      public function tipoBodega()
      {
          return $this->hasOne(TipoBodegas::class,'id','tipo_bodega_id');
      }

      public function municipio()
      {
          return $this->hasOne(Municipio::class,'id','municipio_id');
      }

    public function medicamentos()
    {
        return $this->belongsToMany(Medicamento::class, 'bodega_medicamentos', 'bodega_id', 'medicamento_id');
    }
}
