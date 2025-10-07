<?php

namespace App\Http\Modules\Estadistica\Models;

use App\Http\Modules\Estados\Models\Estado;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class Estadistica extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'imagen',
        'inframe',
        'permission_id',
        'estado_id',
        'usuario_registra_id'
    ];

    public function permission()
    {
        return $this->belongsTo(Permission::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
}
