<?php

namespace App\Http\Modules\CuentasMedicas\RadicacionGlosas\Models;

use App\Http\Modules\CuentasMedicas\Glosas\Models\Glosa;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RadicacionGlosa extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function glosa()
    {
        return $this->belongsTo(Glosa::class);
    }
}
