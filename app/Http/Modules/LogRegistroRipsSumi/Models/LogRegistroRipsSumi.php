<?php

namespace App\Http\Modules\LogRegistroRipsSumi\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogRegistroRipsSumi extends Model
{
    use HasFactory;

    protected $table = 'log_registro_rips_sumi';

    protected $fillable = [
        'codigo_http_respuesta',
        'mensaje_http_respuesta',
        'user_id',
        'payload'
    ];
}
