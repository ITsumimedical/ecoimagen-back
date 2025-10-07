<?php

namespace App\Http\Modules\TipoPrestador\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPrestador extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'tipo_prestadores';
}
