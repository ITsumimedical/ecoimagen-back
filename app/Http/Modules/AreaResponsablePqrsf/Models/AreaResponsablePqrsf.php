<?php

namespace App\Http\Modules\AreaResponsablePqrsf\Models;

use App\Http\Modules\GestionPqrsf\Models\GestionPqrsf;
use App\Http\Modules\ResponsablePqrsf\Models\ResponsablePqrsf;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaResponsablePqrsf extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','activo'];


    public function responsable()
    {
        return $this->belongsToMany(ResponsablePqrsf::class)->withTimestamps();
    }

    public function gestiones()
    {
        return $this->hasMany(GestionPqrsf::class, 'area_responsable_id');
    }



}
