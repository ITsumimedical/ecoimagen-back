<?php

namespace App\Http\Modules\CobroFacturas\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CobroFacturas extends Model
{
    use HasFactory;

    protected $fillable = [
        'valor',
        'medio_pago',
        'user_cobro_id',
        'afiliado_id'
    ];

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }
}

