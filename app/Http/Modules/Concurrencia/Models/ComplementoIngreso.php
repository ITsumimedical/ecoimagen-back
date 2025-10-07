<?php

namespace App\Http\Modules\Concurrencia\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ComplementoIngreso extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = ['peso_neonato', 'edad_gestacional', 'ingreso_concurrencia_id'];

    public function ingreso()
    {
        return $this->belongsTo(IngresoConcurrencia::class);
    }

}
