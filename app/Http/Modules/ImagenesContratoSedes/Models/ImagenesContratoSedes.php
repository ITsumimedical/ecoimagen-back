<?php

namespace App\Http\Modules\ImagenesContratoSedes\Models;

use App\Http\Modules\Reps\Models\Rep;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenesContratoSedes extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'url_imagen',
        'rep_id'
    ];

    public function reps()
    {
        return $this->hasOne(Rep::class, 'rep_id');
    }
}
