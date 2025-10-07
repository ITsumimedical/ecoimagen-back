<?php

namespace App\Http\Modules\Historia\AntecedentesGinecologicos;

use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CupGinecologico extends Model
{
    use HasFactory;

    protected $table = 'cup_ginecologicos';

    protected $fillable = [
        'estado_ginecologia',
        'descripcion_citologia',
        'cup_citologia_id',
        'resultados',
        'fecha_realizacion',
        'consulta_id',
        'created_by',
        'afiliado_id'
    ];

    public function consultas()
    {
        return $this->belongsTo(Consulta::class, 'consulta_id');
    }

    public function cup()
    {
        return $this->belongsTo(Cup::class, 'cup_citologia_id');
    }

    public function usuarioCrea()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

}
