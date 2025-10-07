<?php

namespace App\Http\Modules\Ordenamiento\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DispensarPrestador extends Model
{
    use HasFactory;
    protected $table = "dispensar_prestadors";
    protected $fillable=['dispensar','pendiente','dispensado','orden_articulo_id','user_id'];
}
