<?php

namespace App\Http\Modules\ResponsablePqrsf\Models;

use App\Http\Modules\AreaResponsablePqrsf\Models\AreaResponsablePqrsf;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResponsablePqrsf extends Model
{
    use HasFactory;

    protected $fillable = ['correo', 'user_id', 'activo'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function areasResponsables()
    {
        return $this->belongsToMany(
            AreaResponsablePqrsf::class,
            'area_responsable_pqrsf_responsable_pqrsf', // Nombre de la tabla pivot
            'responsable_pqrsf_id', // Clave foránea para este modelo en la tabla pivot
            'area_responsable_pqrsf_id' // Clave foránea para el modelo relacionado en la tabla pivot
        );
    }
}
