<?php

namespace App\Http\Modules\TipoAlerta\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Estados\Models\Estado;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TipoAlerta extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','user_id','estado_id'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function estado(){
        return $this->belongsTo(Estado::class);
    }

    public function scopeWhereNombre($query, $nombre){
        if($nombre){
            return $query->where('nombre','ILIKE','%'. $nombre .'%');
        }
    }
}
