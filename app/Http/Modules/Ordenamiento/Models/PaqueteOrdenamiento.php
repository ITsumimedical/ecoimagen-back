<?php

namespace App\Http\Modules\Ordenamiento\Models;

use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaqueteOrdenamiento extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'activo'
    ];

    public function cups()
    {
        return $this->belongsToMany(Cup::class, 'cup_paquete_ordenamientos');
    }

    public function codesumis()
    {
        return $this->belongsToMany(Codesumi::class, 'codesumi_paquete_ordenamientos');
    }
}
