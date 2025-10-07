<?php

namespace App\Http\Modules\GestionPqrsf\Models;

use App\Http\Modules\AreaResponsablePqrsf\Models\AreaResponsablePqrsf;
use App\Http\Modules\GestionPqrsf\AdjuntosPqrsf\Models\AdjuntoPqrsf;
use App\Http\Modules\GestionPqrsf\Formulario\Models\Formulariopqrsf;
use App\Http\Modules\Tipos\Models\Tipo;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionPqrsf extends Model
{
    use HasFactory;

    protected $fillable = ['motivo','responsable','fecha','medio','aquien_not','parentesco','formulario_pqrsf_id','user_id','afiliado_id','tipo_id','area_responsable_id'];

    public function adjuntos()
    {
        return $this->hasMany(AdjuntoPqrsf::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function formulario_pqrsf()
    {
        return $this->belongsTo(Formulariopqrsf::class, 'formulario_pqrsf_id');
    }

    public function areaResponsable()
    {
        return $this->belongsTo(AreaResponsablePqrsf::class, 'area_responsable_id');
    }

    public function tipo()
    {
        return $this->belongsTo(Tipo::class, 'tipo_id');
    }

    // retorna cual es la gestión con base en su created_at y su formulario_pqrsf_id
    public function gestionesPosteriores()
    {
        return $this->hasMany(GestionPqrsf::class, 'formulario_pqrsf_id', 'formulario_pqrsf_id')
            ->where('created_at', '>', $this->created_at);
    }

}
