<?php

namespace App\Http\Modules\Tutelas\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricoCierreTutela extends Model
{
    use HasFactory;

    protected $fillable = ['tipo_cierre', 'motivo', 'user_id', 'tutela_id'];
}
