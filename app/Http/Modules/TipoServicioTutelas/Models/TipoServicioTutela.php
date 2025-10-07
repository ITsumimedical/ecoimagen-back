<?php

namespace App\Http\Modules\TipoServicioTutelas\Models;

use App\Http\Modules\Tutelas\Models\Tutela;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoServicioTutela extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'nombre', 'tutela_id'
    ];

    public function tutela(){
        return $this->hasMany(Tutela::class, 'tutela_id');
    }
}
