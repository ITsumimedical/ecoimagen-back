<?php

namespace App\Http\Modules\Ecomapa\Models;

use App\Http\Modules\Consultas\Models\Consulta;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FiguraEcomapa extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'edad', 'pos_x', 'pos_y', 'class', 'consulta_id', 'principal'];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class, 'consulta_id');
    }
}
