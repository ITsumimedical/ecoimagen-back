<?php

namespace App\Http\Modules\Farmacovigilancia\Models;

use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajesAlerta extends Model
{
    use HasFactory;

    protected $fillable =[
        'titulo',
        'mensaje',
        'usuario_id',
        'estado_id'
    ];

    public function usuario(){
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function estado(){
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function scopeWhereTitulo($query, $titulo){
        if($titulo){
            return $query->where('titulo','ILIKE','%'. $titulo .'%');
        }
    }

    public function scopeWhereMensaje($query, $Mensaje){
        if($Mensaje){
            return $query->where('mensaje','ILIKE','%'. $Mensaje .'%');
        }
    }
}
