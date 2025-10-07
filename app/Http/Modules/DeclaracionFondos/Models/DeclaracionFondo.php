<?php

namespace App\Http\Modules\DeclaracionFondos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeclaracionFondo extends Model
{
    use HasFactory;

    protected $fillable = ['declaracion','estado_id','sarlaft_id'];
}
