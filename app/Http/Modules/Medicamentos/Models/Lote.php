<?php

namespace App\Http\Modules\Medicamentos\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bodegaMedicamento()
    {
        return $this->belongsTo(BodegaMedicamento::class);
    }
}
