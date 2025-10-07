<?php

namespace App\Http\Modules\Clientes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'oauth_clients';

    protected $fillable = [
        'user_id',
        'name',
        'correo',
        'secret',
        'provider',
        'redirect',
        'personal_access_client',
        'password_client',
        'revoked'
    ];
}
