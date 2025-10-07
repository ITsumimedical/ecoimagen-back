<?php

namespace App\Http\Modules\Proveedores\Models;

use App\Http\Modules\Bodegas\Models\Bodega;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    use HasFactory;

    protected $table = 'proveedores';
    protected $guarded = [];
}
