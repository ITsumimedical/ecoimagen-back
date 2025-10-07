<?php

namespace App\Http\Modules\CuentasMedicas\TiposCuentasMedicas\Models;

use App\Http\Modules\CuentasMedicas\CodigoGlosas\Models\CodigoGlosa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TiposCuentasMedica extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function codigoGlosa()
    {
        return $this->hasMany(CodigoGlosa::class);
    }
}
