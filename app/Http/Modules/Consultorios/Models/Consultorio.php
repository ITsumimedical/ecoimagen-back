<?php

namespace App\Http\Modules\Consultorios\Models;

use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultorio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre', 'cantidad_paciente','estado_id','rep_id'
    ];

    protected $casts = [
        'rep_id' => 'integer'
    ];

    public function rep(){
        return $this->belongsTo(Rep::class);
    }

    public function estado(){
        return $this->belongsTo(Estado::class, 'estado_id');
    }
}
