<?php

namespace App\Http\Modules\ConfiguracionReportes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfiguracionReporte extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'url', 'funcion_sql', 'permiso','created_by'];

    public function camposReporte()
    {
        return $this->hasMany(CampoReporte::class);
    }
}
