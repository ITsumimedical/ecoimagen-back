<?php

namespace App\Http\Modules\AdjuntoSarlaft\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdjuntoSarlaft extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','ruta','sarlaft_id'];
}
