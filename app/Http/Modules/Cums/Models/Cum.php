<?php

namespace App\Http\Modules\Cums\Models;

use App\Http\Modules\PaqueteServicios\Models\PaqueteServicio;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cum extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function paquetes(){
        return $this->belongsToMany(PaqueteServicio::class, 'cum_paquete');
    }

}
