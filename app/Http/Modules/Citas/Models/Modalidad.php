<?php

namespace App\Http\Modules\Citas\Models;

use App\Http\Modules\CategoriaHistorias\Models\CategoriaHistoria;
use App\Http\Modules\Especialidades\Models\Especialidade;
use App\Http\Modules\TipoCitas\Models\TipoCita;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modalidad extends Model
{
    use HasFactory;

    protected $table = 'modalidades';

    protected $fillable = ['nombre','estado_id'];

}
