<?php

namespace App\Http\Modules\SalarioMinimo\Models;

use App\Http\Modules\ParametroSalarioMinimo\Model\parametros_salario_minimo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SalarioMinimo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function parametros()
    {
        return $this->hasOne(parametros_salario_minimo::class);
    }
}
