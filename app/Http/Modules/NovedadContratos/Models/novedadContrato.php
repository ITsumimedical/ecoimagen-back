<?php

namespace App\Http\Modules\NovedadContratos\Models;

use App\Http\Modules\AdjuntoNovedadContratos\Models\adjuntoNovedadContrato;
use App\Http\Modules\Contratos\Models\Contrato;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class novedadContrato extends Model
{
    use HasFactory;

    protected $fillable =['descripcion','contrato_id','user_id'];

    public  function adjuntoNovedadContratos()
    {
        return $this->hasMany(adjuntoNovedadContrato::class, 'contrato_novedad_id');
    }

    public function usuario()  {
        return $this->belongsTo(User::class,'user_id');

    }

    public function getCreatedAtAttribute($value)
    {
        // Suponiendo que el formato actual sea 'M d Y h:i:s:A'
        return Carbon::parse($value)->format('d/m/Y H:i:s');
    }
}
