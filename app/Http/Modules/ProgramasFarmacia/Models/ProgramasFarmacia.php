<?php

namespace App\Http\Modules\ProgramasFarmacia\Models;

use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\Cie10\Models\Cie10;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ProgramasFarmacia extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'activo'];

    public function codeSumi()
    {
        return $this->belongsToMany(Codesumi::class)->withTimestamps();
    }

    public function bodegas(): BelongsToMany
    {
        return $this->belongsToMany(Bodega::class, 'programas_farmacia_bodegas', 'programa_farmacia_id', 'bodega_id');
    }

    public function diagnosticos(): BelongsToMany
    {
        return $this->belongsToMany(Cie10::class, 'diagnosticos_programa_farmacias', 'programa_farmacia_id', 'cie10_id');
    }
}
