<?php

namespace App\Http\Modules\Caracterizacion\Models;

use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EncuestaUser extends Model
{
    use HasFactory;

    protected $table = 'caracterizacion_encuesta_user';

    protected $fillable = [
        'encuesta_id',
        'user_id'];


    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function encuesta(): BelongsTo
    {
        return $this->belongsTo(Encuesta::class, 'encuesta_id');
    }
}

