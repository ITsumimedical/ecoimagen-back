<?php

namespace App\Http\Modules\ParametrizacionPlanCuidados\Models;

use App\Http\Modules\Medicamentos\Models\Codesumi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParametrizacionPlanCuidadoDetalle extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function codesumi(){
        return $this->belongsTo(Codesumi::class);
    }

}
