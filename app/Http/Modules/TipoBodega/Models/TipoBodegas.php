<?php

namespace App\Http\Modules\TipoBodega\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoBodegas extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','activo'];
}
