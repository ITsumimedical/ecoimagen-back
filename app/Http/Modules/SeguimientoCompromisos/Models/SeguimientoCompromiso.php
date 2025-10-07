<?php

namespace App\Http\Modules\SeguimientoCompromisos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Usuarios\Models\user;

class SeguimientoCompromiso extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function usuario()
    {
        return $this->belongsTo(user::class,'user_id');
    }
}
