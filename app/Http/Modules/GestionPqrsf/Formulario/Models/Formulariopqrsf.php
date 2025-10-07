<?php

namespace App\Http\Modules\GestionPqrsf\Formulario\Models;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\AreaResponsablePqrsf\Models\AreaResponsablePqrsf;
use App\Http\Modules\Areas\Models\Area;
use App\Http\Modules\CodigoPropios\Models\CodigoPropio;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\GestionPqrsf\Canales\Models\Canalpqrsf;
use App\Http\Modules\GestionPqrsf\Models\GestionPqrsf;
use App\Http\Modules\GestionPqrsf\ServiciosPqrsf\Models\ServiciosPqrsfs;
use App\Http\Modules\GestionPqrsf\TipoSolicitudes\Models\TipoSolicitudpqrsf;
use App\Http\Modules\Medicamentos\Models\Codesumi;
use App\Http\Modules\Medicamentos\Models\Medicamento;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Pqrsf\AreasPqrsf\Model\AreasPqrsf;
use App\Http\Modules\Pqrsf\AsignadosPqrsf\Model\Asignado;
use App\Http\Modules\Pqrsf\EmpleadosPqrsf\Model\EmpleadosPqrsf;
use App\Http\Modules\Pqrsf\IpsPqrsf\Model\ipsPqrsf;
use App\Http\Modules\Pqrsf\MedicamentosPqrsf\Model\medicamentosPqrsfs;
use App\Http\Modules\Pqrsf\SubcategoriasPqrsf\Models\subcategoriasPqrsf;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Subcategorias\Models\Subcategorias;
use App\Http\Modules\Usuarios\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Formulariopqrsf extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'quien_genera',
        'documento_genera',
        'nombre_genera',
        'correo',
        'telefono',
        'priorizacion',
        'atributo_calidad',
        'codigo_super',
        'deber',
        'derecho',
        'reabierta',
        'descripcion',
        'canal_id',
        'tipo_solicitud_id',
        'afiliado_id',
        'usuario_registra_id',
        'estado_id'
    ];

    use HasFactory;

    public function gestionPqr()
    {
        return $this->hasMany(GestionPqrsf::class, 'formulario_pqrsf_id');
    }

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class, 'afiliado_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'usuario_registra_id');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function solicitud()
    {
        return $this->belongsTo(TipoSolicitudpqrsf::class, 'tipo_solicitud_id');
    }

    public function canal()
    {
        return $this->belongsTo(Canalpqrsf::class, 'canal_id');
    }

    public function subcategoriaPqrsf()
    {
        return $this->belongsToMany(Subcategorias::class, 'subcategorias_pqrsf', 'formulariopqrsf_id', 'subcategoria_id');
    }


    public function asignado()
    {
        return $this->hasMany(Asignado::class, 'formulario_pqrsf_id');
    }

    public function areaResponsable()
    {
        return $this->belongsToMany(AreaResponsablePqrsf::class, 'asignados', 'formulario_pqrsf_id', 'area_responsable_id');
    }

    public function medicamentoPqrsf()
    {
        return $this->belongsToMany(Medicamento::class, 'medicamentos_pqrsfs', 'formulario_pqrsf_id', 'medicamento_id');
    }

    public function codesumiPqrsf()
    {
        return $this->belongsToMany(Codesumi::class, 'medicamentos_pqrsfs', 'formulario_pqrsf_id', 'codesumi_id');
    }

    public function servicioPqrsf()
    {
        return $this->belongsToMany(Cup::class, 'servicios_pqrsf', 'formulario_pqrsf_id', 'cup_id');
    }

    public function areaPqrsf()
    {
        return $this->belongsToMany(Area::class, 'areas_pqrsf', 'formulario_pqrsf_id', 'area_id');
    }

    public function ipsPqrsf()
    {
        return $this->belongsToMany(Rep::class, 'ips_pqrsf', 'formulario_pqrsf_id', 'rep_id');
    }

    public function codigoPropioPqrsf()
    {
        return $this->belongsToMany(CodigoPropio::class, 'codigo_propio_pqrsfs', 'formulariopqrsf_id', 'codigo_propio_id');
    }

    public function operadorPqrsf()
    {
        return $this->belongsToMany(Operadore::class, 'empleados_pqrsf', 'formulario_pqrsf_id', 'operador_id');
    }

    public function empleadoPqrsf()
    {
        return $this->hasMany(EmpleadosPqrsf::class, 'formulario_pqrsf_id');
    }

}
