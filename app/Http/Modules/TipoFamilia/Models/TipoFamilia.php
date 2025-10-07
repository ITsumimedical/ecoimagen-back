<?php

namespace App\Http\Modules\TipoFamilia\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoFamilia extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = 'tipo_familias';
}
