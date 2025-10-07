<?php

namespace App\Http\Modules\Afiliados\Models;

use App\Http\Modules\CondicionesRiesgoCaracterizacion\Models\CondicionesRiesgoCaracterizacion;
use App\Http\Modules\PracticaIntervieneSalud\Models\PracticaIntervieneSalud;
use App\Http\Modules\RutaPromocionCaracterizacion\Models\RutaPromocionCaracterizacion;
use App\Http\Modules\TipoCancerCaracterizacion\Models\TipoCancerCaracterizacion;
use App\Http\Modules\TipoInmunodeficienciasCaracterizacion\Models\TipoInmunodeficienciasCaracterizacion;
use App\Http\Modules\TipoMetabolicasCaracterizacion\Models\TipoMetabolicasCaracterizacion;
use App\Http\Modules\TipoRCVCaracterizacion\Models\TipoRCVCaracterizacion;
use App\Http\Modules\TipoRespiratoriasCaracterizacion\Models\TipoRespiratoriasCaracterizacion;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaracterizacionAfiliado extends Model
{
    use HasFactory;

    protected $fillable = [
        'afiliado_id',
        'reaccion_alergica',
        'vacunado_covid',
        'ocupacion',
        'nivel_escolar',
        'orientacion_sexual',
        'tipo_vivienda',
        'cantidad_personas_vive',
        'estrato_socioeconomico',
        'agua_alcantarillado',
        'metodo_cocina',
        'energia_electrica',
        'accesibilidad_vivienda',
        'seguridad_orden',
        'etnia',
        'tamizaje_prostata',
        'metodo_planificacion',
        'planeado_embarazo',
        'citologia_ultimo_ano',
        'tamizaje_mamografia',
        'tipo_violencia_id',
        'discapacidad',
        'estratificacion_riesgo',
        'grupo_riesgo',
        'user_gestor_id',
        'user_enfermeria_id'
    ];

    protected $casts = [
        'estrato_socioeconomico' => 'integer',
    ];

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class, 'afiliado_id');
    }

    public function practica()
    {
        return $this->belongsToMany(PracticaIntervieneSalud::class, 'caracterizacion_practica', 'caracterizacion_id', 'practica_id');
    }

    public function tipoCancerPropio()
    {
        return $this->belongsToMany(TipoCancerCaracterizacion::class,'caracterizacion_cancer_propio','caracterizacion_id','tipo_cancer_id' );
    }

    public function tipoCancerFamilia()
    {
        return $this->belongsToMany(TipoCancerCaracterizacion::class,'caracterizacion_cancer_familia','caracterizacion_id','tipo_cancer_id' );
    }

    public function tipoMetabolicaPropio()
    {
        return $this->belongsToMany(TipoMetabolicasCaracterizacion::class,'caracterizacion_metabolicas_propio','caracterizacion_id','tipo_metabolica_id' );
    }

    public function tipoMetabolicaFamilia()
    {
        return $this->belongsToMany(TipoMetabolicasCaracterizacion::class,'caracterizacion_metabolicas_familia','caracterizacion_id','tipo_metabolica_id' );
    }

    public function tipoRCV()
    {
        return $this->belongsToMany(TipoRCVCaracterizacion::class,'caracterizacion_rcv','caracterizacion_id','tipo_rcv_id' );
    }

    public function tipoRespiratoria()
    {
        return $this->belongsToMany(TipoRespiratoriasCaracterizacion::class,'caracterizacion_respiratorias','caracterizacion_id','tipo_respiratoria_id' );
    }

    public function tipoInmunodeficiencia()
    {
        return $this->belongsToMany(TipoInmunodeficienciasCaracterizacion::class,'caracterizacion_inmunodeficiencias','caracterizacion_id','tipo_inmunodeficiencia_id' );
    }

    public function condicionRiesgo()
    {
        return $this->belongsToMany(CondicionesRiesgoCaracterizacion::class,'caracterizacion_riesgos','caracterizacion_id','condicion_riesgo_id' );
    }

    public function rutaPromocion()
    {
        return $this->belongsToMany(RutaPromocionCaracterizacion::class, 'caracterizacion_rutas', 'caracterizacion_id', 'ruta_promocion_id');
    }

    public function usuarioGestor()
    {
        return $this->belongsTo(user::class, 'user_gestor_id');
    }

    public function usuarioEnfermeria()
    {
        return $this->belongsTo(User::class, 'user_enfermeria_id');
    }
}
