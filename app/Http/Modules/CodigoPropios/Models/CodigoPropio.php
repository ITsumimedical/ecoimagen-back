<?php

namespace App\Http\Modules\CodigoPropios\Models;

use App\Http\Modules\Ambitos\Models\Ambito;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Tarifas\Models\Tarifa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CodigoPropio extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'nombre',
        'codigo',
        'genero',
        'edad_inicial',
        'edad_final',
        'quirurgico',
        'diagnostico_requerido',
        'nivel_ordenamiento',
        'nivel_portabilidad',
        'requiere_auditoria',
        'periodicidad',
        'cantidad_max_ordenamiento',
        'ambito_id',
        'cup_id',
        'valor',
        'activo'
    ];
    protected $table = 'codigo_propios';
    protected $appends = ['CodigoNombre'];

    /** Relaciones */
    public function cup(){
        return $this->belongsTo(Cup::class);
    }

    public function ambito(){
        return $this->belongsTo(Ambito::class);
    }

    public function tarifa(){
        return $this->belongsToMany(Tarifa::class,'codigo_propio_tarifas')->withPivot('user_id','valor');
    }

    /** Funciones */

    public function getCodigoNombreAttribute(){
        return "{$this->codigo} -  {$this->nombre}";
    }

    /** Scopes */

    public function scopeWhereAmbito($query, $ambito_id){
        if($ambito_id){
            return $query->where('ambito_id',$ambito_id);
        }
    }

    public function scopeWhereCodigoPropio($query, $codigo){
        if($codigo){
            return $query->where('codigo',$codigo);
        }
    }

    public function scopeWhereCodigoCups($query, $codigo){
        if($codigo){
            return $query->join('cups','cups.id','codigo_propios.cup_id')->where('cups.codigo',$codigo);
        }
    }

    public function scopeWhereNombre($query, $nombre){
        if($nombre){
            return $query->where('nombre','ILIKE',"%{$nombre}%");
        }
    }

    public function scopeWhereTarifa($query,$tarifa_id){
        if($tarifa_id){
            return $query->with(['tarifa' => function ($q) use ($tarifa_id){
                $q->where('tarifa_id',$tarifa_id);
            } ]);
        }
    }

    /** Sets y Gets */

}
