<?php

namespace App\Http\Modules\Reportes\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EndpointRuta extends Model
{
    use HasFactory;

    protected $table = 'endpoint_rutas';

    protected $fillable = [
        'methods',
        'name',
        'action',
        'url',
    ];

    protected $casts = [
        'methods' => 'array',
    ];
}
