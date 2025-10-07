<?php

namespace App\Http\Modules\Epidemiologia\Models;

use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ObservacionRegistroSivigila extends Model
{
    use HasFactory;

    protected $fillable = [
        'observacion',
        'email_medico',
        'user_id',
        'registro_id'
    ];

    public function registro(){
        return $this->bootHasEventselongsTo(RegistroSivigila::class, 'registro_id');
    }

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
