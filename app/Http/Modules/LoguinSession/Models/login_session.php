<?php

namespace App\Http\Modules\LoguinSession\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class login_session extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'ip_address',
        'logged_in_at',
        'logged_out_at',
        'activo',
    ];

}
