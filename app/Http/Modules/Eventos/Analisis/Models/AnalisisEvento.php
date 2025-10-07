<?php

namespace App\Http\Modules\Eventos\Analisis\Models;

use App\Http\Modules\Eventos\AccionesInseguras\Models\AccionesInsegura;
use App\Http\Modules\Eventos\EventosAdversos\Models\EventoAdverso;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnalisisEvento extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function eventoAdverso()
    {
        return $this->belongsTo(EventoAdverso::class);
    }

    public function accionInsegura()
    {
        return $this->hasOne(AccionesInsegura::class);
    }
}
