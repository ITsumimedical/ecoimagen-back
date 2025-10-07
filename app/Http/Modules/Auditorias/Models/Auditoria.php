<?php

namespace App\Http\Modules\Auditorias\Models;

use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use App\Http\Modules\Usuarios\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Auditoria extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $table = "auditorias";

    public function ordenArticulo()
    {
        return $this->belongsTo(OrdenArticulo::class);
    }

    public function getCreatedAtAttribute($value)
    {
        return Carbon::parse($value)->setTimezone('America/Bogota')->toDateTimeString();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
