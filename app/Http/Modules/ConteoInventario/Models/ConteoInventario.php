<?php

namespace App\Http\Modules\ConteoInventario\Models;

use App\Http\Modules\Medicamentos\Models\Lote;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConteoInventario extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function lote()
    {
        return $this->belongsTo(Lote::class);
    }

}
