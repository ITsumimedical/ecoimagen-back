<?php

namespace App\Http\Modules\Chat\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class canal extends Model
{
    use HasFactory;

    protected $fillable = ['user_crea_id','user_recibe_id','referencia_id'];

    public function mensajes()
    {
        return $this->hasMany(mensaje::class);
    }
}
