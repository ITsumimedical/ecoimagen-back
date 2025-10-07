<?php

namespace App\Http\Modules\CuentasMedicas\AsignadoCuentasMedicas\Models;

use App\Http\Modules\Rips\Af\Models\Af;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AsignadoCuentasMedica extends Model
{
    use HasFactory;

    protected $fillable = ['permission_id','af_id'];

    public function af()
    {
        return $this->belongsTo(Af::class);
    }
}
