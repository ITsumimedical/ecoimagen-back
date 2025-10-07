<?php

namespace App\Http\Modules\Chat\Models;

use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class mensaje extends Model
{
    use HasFactory;

    protected $casts = [
        'created_at' => 'date:Y-m-d H:m',
        'visto' => "boolean"
    ];

    protected $fillable = ['mensaje','adjunto','user_id','canal_id','estado_id'];
    protected $appends = [
        'nombre_adjunto',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function canales()
    {
        return $this->belongsTo(canal::class);
    }

    public function getNombreAdjuntoAttribute() {
        $nombre_archivo = explode('/',$this->adjunto);
        return  $nombre_archivo;
    }

}
