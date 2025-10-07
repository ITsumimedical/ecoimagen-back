<?php

namespace App\Http\Modules\Empalme\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\CodigoPropios\Models\CodigoPropio;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Empalme\Adjunto\Model\AdjuntoEmpalme;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empalme extends Model
{
    use HasFactory;
    protected $table = 'empalme';

    protected $fillable = [
        'acepta_represa',
        'tutela',
        'tipo_servicio',
        'cie10s_id',
        'afiliado_id',
        'empalme',
        'observaciones_contratista',
        'fecha_solicitud',
        'cup_id',
        'codesumi_id',
        'codigo_propio_id',
        'anexos'
    ];

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }

    public function cie10s()
    {
        return $this->belongsTo(Cie10::class);
    }

    public function cup()
    {
        return $this->belongsTo(Cup::class);
    }

    public function codesumi()
    {
        return $this->belongsTo(Codesumi::class);
    }

    public function codigo_propio()
    {
        return $this->belongsTo(CodigoPropio::class);
    }

    public function adjunto_empalme()
    {
        return $this->hasMany(AdjuntoEmpalme::class);
    }
}
