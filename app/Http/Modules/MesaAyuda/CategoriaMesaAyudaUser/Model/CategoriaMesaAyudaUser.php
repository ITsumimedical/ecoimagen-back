<?php

namespace App\Http\Modules\MesaAyuda\CategoriaMesaAyudaUser\Model;

use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaMesaAyudaUser extends Model
{
    use HasFactory;

    protected $table = 'categoria_mesa_ayuda_user';
    protected $fillable = ['categoria_mesa_ayuda_id', 'user_id'];


    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
