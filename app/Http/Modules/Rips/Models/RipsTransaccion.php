<?php

namespace App\Http\Modules\Rips\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RipsTransaccion extends Model
{
    use HasFactory;

    protected $table = "rips_transacciones";
    protected $guarded = [];
}
