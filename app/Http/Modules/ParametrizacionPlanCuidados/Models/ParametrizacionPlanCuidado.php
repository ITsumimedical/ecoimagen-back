<?php

namespace App\Http\Modules\ParametrizacionPlanCuidados\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParametrizacionPlanCuidado extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function articulos(){
        return $this->hasMany(ParametrizacionPlanCuidadoDetalle::class);
    }
}
