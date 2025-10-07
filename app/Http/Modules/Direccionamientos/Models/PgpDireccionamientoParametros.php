<?php

namespace App\Http\Modules\Direccionamientos\Models;

use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PgpDireccionamientoParametros extends Model
{
    use HasFactory;

    protected $fillable = [
        'rep_id',
        'posicion',
        'user_id'
        ];

    protected $casts = [
        'posicion' => 'integer'
    ];

    public function rep(){
        return $this->belongsTo(Rep::class,'rep_id');
    }

}
