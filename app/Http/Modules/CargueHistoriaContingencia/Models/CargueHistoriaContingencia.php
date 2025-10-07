<?php

namespace App\Http\Modules\CargueHistoriaContingencia\Models;

use App\Http\Modules\TipoArchivo\Models\TipoArchivo;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CargueHistoriaContingencia extends Model
{
    use HasFactory;

    protected $fillable = ['nombre','ruta','fecha_proceso','tipo_archivo_id','consulta_id','funcionario_carga'];

    public function tipoArchivo()
    {
        return $this->belongsTo(TipoArchivo::class, 'tipo_archivo_id');
    }

    public function funcionarioCarga()
    {
        return $this->belongsTo(User::class, 'funcionario_carga');
    }
}
