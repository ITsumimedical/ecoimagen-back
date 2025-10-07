<?php

namespace App\Http\Modules\Ordenamiento\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CupPaqueteOrdenamiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'paquete_ordenamiento_id',
        'cup_id',
    ];
}
