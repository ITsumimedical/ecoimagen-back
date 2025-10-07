<?php

namespace App\Http\Modules\ProgramasFarmacia\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramasFarmaciaBodegas extends Model
{
    use HasFactory;

    protected $fillable = ['bodega_id', 'programa_farmacia_id'];
}
