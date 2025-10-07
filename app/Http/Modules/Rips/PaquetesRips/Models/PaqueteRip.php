<?php

namespace App\Http\Modules\Rips\PaquetesRips\Models;


use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Rips\Af\Models\Af;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaqueteRip extends Model
{
    use HasFactory;

    protected $table = 'paquete_rips';

    protected $fillable = ['nombre','parcial','motivo','nombre_rep','codigo','entidad','ac_size','af_size',
    'ah_size','am_size','ap_size','at_size','au_size','ct_size','us_size','mes','anio','ruta','user_id','rep_id','estado_id', 'url_adjunto_rips_txt'];

    public function afs()
    {
        return $this->hasMany(Af::class);
    }

    public function estado(){
        return  $this->belongsTo(Estado::class);
    }

    public function rep()
    {
        return $this->belongsTo(Rep::class);
    }
}
