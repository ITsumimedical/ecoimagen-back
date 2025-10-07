<?php

namespace App\Http\Modules\Solicitudes\GestionRadicacionOnline\Models;

use App\Http\Modules\Solicitudes\AdjuntosRadicacionOnline\Models\AdjuntosRadicacionOnline;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GestionRadicacionOnline extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at'=> 'date:Y-m-d',
        ];

    protected $fillable = ['motivo','user_id','tipo_id','radicacion_online_id','area_solicitudes_id'];

    public function adjuntosGestion()
    {
        return $this->hasMany(AdjuntosRadicacionOnline::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
