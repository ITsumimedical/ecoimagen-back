<?php

namespace App\Http\Modules\AreasProveedores\Models;

use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreasProveedores extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'estado'
    ];

    public function users(){
        return $this->belongsToMany( User::class,'area_proveedor_users_compras' ,'area_id','user_id');
    }
}
