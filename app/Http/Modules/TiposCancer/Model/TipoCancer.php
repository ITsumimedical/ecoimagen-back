<?php

namespace App\Http\Modules\TiposCancer\Model;

use App\Http\Modules\Cie10\Models\Cie10;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoCancer extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
    ];

    public function cie10s()
    {
        return $this->belongsToMany(Cie10::class, 'diagnosticos_tipo_cancer', 'tipo_cancer_id', 'cie10_id')->withTimestamps();
    }
}
