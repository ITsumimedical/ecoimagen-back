<?php

namespace App\Http\Modules\Contratos\Models;

use App\Http\Modules\Ambitos\Models\Ambito;
use App\Http\Modules\Entidad\Models\Entidad;
use App\Http\Modules\NovedadContratos\Models\novedadContrato;
use App\Http\Modules\Prestadores\Models\Prestador;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Contrato extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];
    protected $table = 'contratos';
    protected $appends = [
        'entidad_ambito'
    ];

    protected $casts = [
        'PGP' => 'boolean',
        'capitado' => 'boolean',
        'evento' => 'boolean',
        'poliza' => 'boolean',
        'renovacion' => 'boolean',
        'modificacion' => 'boolean',
        'tipo_reporte' => 'integer',
        'linea_negocio' => 'integer',
        'regimen' => 'integer',
        'componente' => 'integer',
        'tipo_servicio' => 'integer',
        'tipo_relacion' => 'integer',
        'modalidad_pago' => 'integer',
        'tipo_modificacion' => 'integer',
        'estado' => 'integer',
        'union_temporal' => 'integer',
        'tipo_proveedor' => 'integer',
        'tipo_red' => 'integer',
    ];

    /** Relaciones */
    public function novedades(){
        return $this->hasMany(novedadContrato::class);
    }

    public function entidad(){
        return $this->belongsTo(Entidad::class);
    }

    public function prestador(){
        return $this->belongsTo(Prestador::class);
    }


    public function ambito()
    {
        return $this->belongsTo(Ambito::class);
    }

    public  function novedadContratos(){
        return $this->hasMany(novedadContrato::class, 'contrato_id');
    }

    public function listarPorEntidad($entidad_id){
        return $this->where('entidad_id', $entidad_id)
            ->with(['entidad', 'ambito'])
            ->get();
    }

    /** Scopes */

    public function scopeWherePrestador($query, $prestador_id){
        if($prestador_id){
            return $query->where('prestador_id', $prestador_id);
        }
    }

    /**
     * Filtra los contratos por NIT o código de habilitación del prestador.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $busqueda El término de búsqueda para NIT o código de habilitación.
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWherePrestadorNit($query, $busqueda)
    {
        if ($busqueda) {
            return $query->whereHas('prestador', function ($q) use ($busqueda) {
                $q->where('nit', 'ILIKE', "%{$busqueda}%")
                ->orWhere('codigo_habilitacion', 'ILIKE', "%{$busqueda}%");
            });
        }

        return $query;
    }


    /**
     * Concatena para nombre del contrato
     * @return string
     */
    public function getEntidadAmbitoAttribute(){
        $entidad = substr($this->entidad()->pluck('nombre'),2,-2);
        $ambito = substr($this->ambito()->pluck('nombre'),2,-2);
        if($this->activo == true){
            return "Entidad: {$entidad} - Ambito: {$ambito} - Estado: Activo";
        }else{
            return "Entidad: {$entidad} - Ambito: {$ambito} - Estado: Inactivo";
        }

    }

}
