<?php

namespace App\Http\Modules\Consultas\Models;

use App\Http\Modules\Historia\Odontograma\Models\OdontogramaIndicadores;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Modules\rqc\model\rqc;
use PhpParser\Node\Expr\Cast\Array_;
use App\Http\Modules\Cups\Models\Cup;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Audit\Model\audit;
use App\Http\Modules\Citas\Models\Cita;
use App\Http\Modules\testSrq\Model\srq;
use App\Http\Modules\Zarit\Model\zarit;
use Illuminate\Database\Eloquent\Model;
use App\Http\Modules\Minuta\Model\Minuta;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Agendas\Models\Agenda;
use App\Http\Modules\Estados\Models\Estado;
use App\Http\Modules\RxFinal\Model\RxFinal;
use App\Http\Modules\testMchat\Model\mChat;
use App\Http\Modules\Whooley\Model\whooley;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Http\Modules\Historia\Models\Historia;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Tanner\Model\EscalaTanner;
use App\Http\Modules\Historia\Models\PlanCuidado;
use App\Http\Modules\MiniMental\Model\miniMental;
use App\Http\Modules\Historia\Models\Familiograma;
use App\Http\Modules\LogsKeiron\Models\LogsKeiron;
use App\Http\Modules\EscalaDolor\Model\EscalaDolor;
use App\Http\Modules\FiguraHumana\Model\FiguraHumana;
use App\Http\Modules\Historia\Models\HistoriaClinica;
use App\Http\Modules\Historia\Models\PracticaCrianza;
use App\Http\Modules\Historia\Models\InformacionSalud;
use App\Http\Modules\Historia\Vacunacion\Models\Vacuna;
use App\Http\Modules\TipoConsultas\Models\TipoConsulta;
use App\Http\Modules\Cie10Afiliado\Models\Cie10Afiliado;
use App\Http\Modules\Especialidades\Models\Especialidade;
use App\Http\Modules\respuestasTest\Model\RespuestasTest;
use App\Http\Modules\Historia\Models\GestanteGinecologico;
use App\Http\Modules\Epidemiologia\Models\RegistroSivigila;
use App\Http\Modules\Periodontograma\Model\periodontograma;
use App\Http\Modules\Epidemiologia\Models\RespuestaSivigila;
use App\Http\Modules\Patologia\Model\AntecedentesPatologias;
use App\Http\Modules\CuestionarioVale\Model\CuestionarioVale;
use App\Http\Modules\Historia\Odontograma\Models\Odontograma;
use App\Http\Modules\CuestionarioGad2\Model\cuestionarioGAD_2;
use App\Http\Modules\RemisionProgramas\Model\RemisionProgramas;
use App\Http\Modules\SucesionEvolutiva\Model\SucesionEvolutiva;
use App\Http\Modules\ExamenTejidosDuros\Model\examenTejidosDuros;
use App\Http\Modules\Historia\ApgarFamiliar\Models\ApgarFamiliar;
use App\Http\Modules\Historia\Models\AdherenciaFarmacoterapeutica;
use App\Http\Modules\AdmisionesUrgencias\Models\AdmisionesUrgencia;
use App\Http\Modules\HabitosAlimentarios\Model\HabitosAlimentarios;
use App\Http\Modules\Historia\Odontograma\Models\OdontogramaImagen;
use App\Http\Modules\Historia\Neuropsicologia\Models\Neuropsicologia;
use App\Http\Modules\Historia\AntecedentesGinecologicos\CupMamografia;
use App\Http\Modules\PlanTratamiento\Model\planTratamientoOdontologia;
use App\Http\Modules\SistemaRespiratorio\Models\SistemasRespiratorios;
use App\Http\Modules\ConductasInadaptativas\Model\ConductaInadaptativa;
use App\Http\Modules\Historia\AntecedentesGinecologicos\CupGinecologico;
use App\Http\Modules\PatologiaRespiratoria\Models\PatologiaRespiratoria;
use App\Http\Modules\estructuraDinamica\Model\EstructuraDinamicaFamiliar;
use App\Http\Modules\Transcripciones\Transcripcion\Models\Transcripcione;
use App\Http\Modules\Oncologia\TomaProcedimiento\Models\TomaProcedimiento;
use App\Http\Modules\Transcripciones\Adjunto\Models\AdjuntoTranscripcione;
use App\Http\Modules\ExamenFisicoOdontologia\Model\examenFisicoOdontologia;
use App\Http\Modules\ParaclinicosOdontologia\Model\paraclinicosOdontologia;
use App\Http\Modules\RecomendacionesConsulta\Model\RecomendacionesConsulta;
use App\Http\Modules\ConductasRelacionamiento\Model\ConductaRelacionamiento;
use App\Http\Modules\EvolucionSignosSintomas\Models\EvolucionSignosSintomas;
use App\Http\Modules\ExamenFisicoFisioterapia\Model\ExamenFisicoFisioterapia;
use App\Http\Modules\Historia\AntecedentesEcomapas\Models\AntecedenteEcomapa;
use App\Http\Modules\Historia\AntecedentesSexuales\Models\AntecedenteSexuale;
use App\Http\Modules\InsumosProcedimientos\Models\InsumosProcedimientosModel;
use App\Http\Modules\valoracionAntropometrica\Model\ValoracionAntropometrica;
use App\Http\Modules\AntecedentesOdontologicos\Model\antecedentesOdontologicos;
use App\Http\Modules\EstadoAnimoComportamiento\Model\EstadoAnimoComportamiento;
use App\Http\Modules\Historia\ResultadoLaboratorio\Models\ResultadoLaboratorio;
use App\Http\Modules\OrganosFonoarticulatorios\Models\OrganosFonoarticulatorios;
use App\Http\Modules\Historia\AntecedentesFamiliares\Models\AntecedenteFamiliare;
use App\Http\Modules\Historia\AntecedentesPersonales\Models\AntecedentePersonale;
use App\Http\Modules\CargueHistoriaContingencia\Models\CargueHistoriaContingencia;
use App\Http\Modules\Contratos\Models\CobroServicio;
use App\Http\Modules\FuncionRenal\Model\FuncionRenal;
use App\Http\Modules\Historia\AntecedentesQuirurgicos\Models\AntecedenteQuirurgico;
use App\Http\Modules\Historia\AntecedentesFamiliograma\Models\AntecedenteFamiliograma;
use App\Http\Modules\Historia\estratificacionFindrisks\Models\EstratificacionFindrisks;
use App\Http\Modules\Historia\AntecedentesHospitalarios\Models\AntecedentesHospitalario;
use App\Http\Modules\Historia\AntecedentesFarmacologicos\Models\AntecedentesFarmacologico;
use App\Http\Modules\Historia\estratificacionFramingham\Models\EstratificacionFraminghams;
use App\Http\Modules\Historia\AntecedentesTransfusionales\Models\AntecedenteTransfusionale;
use App\Http\Modules\Historia\EscalaAbreviadaDesarrollos\Models\RegistroEscalaAbreviadaDesarrollo;
use App\Http\Modules\PieDiabetico\Models\PieDiabetico;
use App\Http\Modules\RegistroBiopsias\Models\RegistroBiopsiasPatologias;
use App\Http\Modules\TestAssist\Models\testAssist;

class Consulta extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'finalidad',
        'fecha_hora_inicio',
        'fecha_hora_final',
        'agenda_id',
        'afiliado_id',
        'cup_id',
        'estado_id',
        'deleted_at',
        'created_at',
        'updated_at',
        'cita_no_programada',
        'especialidad_id',
        'cita_id',
        'tipo_consulta_id',
        'medico_ordena_id',
        'firma_consentimiento',
        'firma_consentimiento_time',
        'rep_id',
        'foto',
        'firma_paciente',
        'aceptacion_consentimiento',
        'firmante',
        'numero_documento_representante',
        'declaracion_a',
        'declaracion_b',
        'declaracion_c',
        'nombre_profesional',
        'nombre_representante',
        'fecha_solicitada',
        'user_id',
        'motivo_inadecuacion',
        'segundos',
        'tiempo_consulta',
        'procedimiento_menor',
        'servicio_solicita_referencia',
        'hora_inicio_atendio_consulta',
        'hora_fin_atendio_consulta',
        'observacion_agenda',
        'firma_acompanante',
        'diagnostico_principal',
        'admision_urgencia_id',
        'estado_triage',
        'motivo_cancelacion'
    ];

    public function ordenes()
    {
        return $this->hasMany(Orden::class);
    }
    public function OrdenesCodigosPropios()
    {
        return $this->hasMany(Orden::class);
    }
    public function historia()
    {
        return $this->hasMany(Historia::class);
    }
    public function agenda()
    {
        return $this->belongsTo(Agenda::class);
    }

    public function HistoriaClinica()
    {
        return $this->hasOne(HistoriaClinica::class);
    }

    public function afiliado()
    {
        return $this->belongsTo(Afiliado::class);
    }
    public function medicoOrdena()
    {
        return $this->belongsTo(User::class, 'medico_ordena_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function funcionarioCancela()
    {
        return $this->belongsTo(User::class, 'funcionario_cancela');
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class);
    }
    public function cita()
    {
        return $this->belongsTo(Cita::class);
    }
    public function tipoConsulta()
    {
        return $this->belongsTo(TipoConsulta::class);
    }
    public function tomaProcedimiento()
    {
        return $this->hasMany(TomaProcedimiento::class);
    }
    public function especialidad()
    {
        return $this->belongsTo(Especialidade::class);
    }
    public function cargueHistoriaContingencia()
    {
        return $this->hasOne(CargueHistoriaContingencia::class);
    }

    public function insumos()
    {
        return $this->hasMany(InsumosProcedimientosModel::class);
    }

    public function scopeWhereEstado($query, $estados)
    {
        if (count($estados) > 0) {
            return $query->whereIn('estado_id', $estados);
        }
    }
    public function scopeWhereTipoDeConsulta($query, $tipo)
    {
        if ($tipo === 'telemedicina') {
            return $query->whereDate('agendas.fecha_inicio', '>=', Carbon::now()->format('Y-m-d'))
                ->whereDate('agendas.fecha_inicio', '<=', Carbon::now()->addDays(6)->format('Y-m-d'));
        }
    }
    public function scopeWhereModalidad($query, $teleconsulta)
    {
        if ($teleconsulta === 'telemedicina') {
            return $query->where('citas.modalidad_id', 2);
        } else {
            return $query->where('citas.modalidad_id', '!=', 2);
        }
    }
    public function validarPaciente($documento)
    {
        return $this->afiliado->numero_documento === $documento;
    }
    public function guardarFirma($firma)
    {
        //        $this->firma_consentimiento = DB::raw('0x'.bin2hex($firma));
        $this->firma_consentimiento = $firma;
        $this->firma_consentimiento_time = Carbon::now();
        return $this->save();
    }
    public function antecedenteFamiliares()
    {
        return $this->hasMany(AntecedenteFamiliare::class);
    }

    public function antecedentePersonales()
    {
        return $this->hasMany(AntecedentePersonale::class);
    }
    public function antecedentesFarmacologicos()
    {
        return $this->hasMany(AntecedentesFarmacologico::class);
    }

    public function antecedentesFamiliares()
    {
        return $this->hasMany(AntecedenteFamiliare::class);
    }
    public function antecedenteTransfucionales()
    {
        return $this->hasMany(AntecedenteTransfusionale::class);
    }

    public function vacunacion()
    {
        return $this->hasMany(Vacuna::class);
    }

    public function antecedenteQuirurgicos()
    {
        return $this->hasMany(AntecedenteQuirurgico::class);
    }

    public function antecedenteHospitalarios()
    {
        return $this->hasOne(AntecedentesHospitalario::class);
    }

    public function antecedentesSexuales()
    {
        return $this->hasMany(AntecedenteSexuale::class);
    }

    public function antecedenteEcomapa()
    {
        return $this->hasOne(AntecedenteEcomapa::class);
    }

    public function apgarFamiliar()
    {
        return $this->hasOne(ApgarFamiliar::class);
    }

    public function antecedenteFamiliograma()
    {
        return $this->hasOne(AntecedenteFamiliograma::class);
    }

    public function resultadoLaboratorios()
    {
        return $this->hasMany(ResultadoLaboratorio::class);
    }

    public function cie10Afiliado()
    {
        return $this->hasMany(Cie10Afiliado::class);
    }

    public function planCuidado()
    {
        return $this->hasMany(PlanCuidado::class);
    }

    public function informacionSalud()
    {
        return $this->hasMany(InformacionSalud::class);
    }

    public function PracticaCrianza()
    {
        return $this->hasMany(PracticaCrianza::class);
    }

    public function rep()
    {
        return $this->belongsTo(Rep::class);
    }
    public function patologias()
    {
        return $this->hasOne(AntecedentesPatologias::class);
    }

    public function antecedentesOdontologicos()
    {
        return $this->hasOne(antecedentesOdontologicos::class);
    }

    public function examenFisicoOdontologicos()
    {
        return $this->hasOne(examenFisicoOdontologia::class);
    }

    public function examenTejidoOdontologicos()
    {
        return $this->hasOne(examenTejidosDuros::class);
    }

    public function odontograma()
    {
        return $this->hasMany(periodontograma::class);
    }

    public function odontogramaNuevo()
    {
        return $this->hasMany(Odontograma::class);
    }

    public function paraclinicosOdontologicos()
    {
        return $this->hasMany(paraclinicosOdontologia::class);
    }

    public function planTramientoOdontologia()
    {
        return $this->hasOne(planTratamientoOdontologia::class);
    }

    public function adherenciaFarmaceutica()
    {
        return $this->hasOne(AdherenciaFarmacoterapeutica::class);
    }

    public function respuestas()
    {
        return $this->hasMany(RespuestasTest::class);
    }

    public function remision()
    {
        return $this->hasMany(RemisionProgramas::class, 'consulta_id');
    }

    public function cups()
    {
        return $this->belongsToMany(Cup::class, 'odontologia_procedimientos');
    }

    public function cup()
    {
        return $this->belongsTo(Cup::class);
    }

    public function recomendacionConsulta()
    {
        return $this->hasMany(RecomendacionesConsulta::class);
    }

    public function gestanteGinecologico()
    {
        return $this->hasOne(GestanteGinecologico::class);
    }

    public function whooley() {
        return $this->hasOne(whooley::class);
    }

    public function gad2() {
        return $this->hasOne(cuestionarioGAD_2::class);
    }

    public function audit() {
        return $this->hasOne(audit::class);
    }

    public function findrisc() {
        return $this->hasOne(EstratificacionFindrisks::class);
    }

    public function escalaZarit() {
        return $this->hasOne(zarit::class);
    }

    public function testMental() {
        return $this->hasOne(miniMental::class);
    }

    public function escalaDolor() {
        return $this->hasOne(EscalaDolor::class);
    }

    public function ExamenFisioterapia() {
        return $this->hasOne(ExamenFisicoFisioterapia::class);
    }
    public function scopeWhereFechaConsulta($query, $fecha_inicial, $fecha_final)
    {
        return $query->where(function ($query) use ($fecha_inicial, $fecha_final) {
            $query->whereBetween('hora_inicio_atendio_consulta', [$fecha_inicial, $fecha_final])
                ->orWhere(function ($subQuery) use ($fecha_inicial, $fecha_final) {
                    $subQuery->whereNull('hora_inicio_atendio_consulta')
                        ->whereBetween('fecha_hora_inicio', [$fecha_inicial, $fecha_final]);
                });
        });
    }

    public function transcripcion()
    {
        return $this->hasOne(Transcripcione::class);
    }

    public function admision()
    {
        return $this->belongsTo(AdmisionesUrgencia::class, 'admision_urgencia_id');
    }

    public function organosFonoarticulatorios()
    {
        return $this->hasOne(OrganosFonoarticulatorios::class);
    }

    public function respuestaSivigila(){
        return $this->hasMany(RespuestaSivigila::class);
    }

    public function resgistroSivigila(){
        return $this->hasMany(RegistroSivigila::class, 'consulta_id');
    }

    public function estructuraDinamica()
    {
        return $this->hasOne(EstructuraDinamicaFamiliar::class);
    }

    public function minuta()
    {
        return $this->hasOne(Minuta::class);
    }

    public function valoracionAntropometrica()
    {
        return $this->hasOne(ValoracionAntropometrica::class);
    }

    public function neuropsicologia()
    {
        return $this->hasOne(Neuropsicologia::class);
    }

    public function estadoComportamiento() {
        return $this->hasOne(EstadoAnimoComportamiento::class);
    }


    public function adjuntos()
    {
        return $this->hasMany(AdjuntoTranscripcione::class);
    }

    public function familiograma()
    {
        return $this->hasOne(Familiograma::class);
    }

    public function rxFinal()
    {
        return $this->hasOne(RxFinal::class);
    }

    public function framingham() {
        return $this->hasOne(EstratificacionFraminghams::class);
    }

    public function odontogramaImagen()
    {
        return $this->hasOne(OdontogramaImagen::class);
    }

    public function cuestionarioVale() {
        return $this->hasOne(CuestionarioVale::class);
    }

    public function TestRqc() {
        return $this->hasOne(rqc::class);
    }

    public function FiguraHumana() {
        return $this->hasOne(FiguraHumana::class);
    }

    public function testSrq()
    {
        return $this->hasOne(srq::class);
    }
    public function patologiaRespiratoria()
    {
        return $this->hasMany(PatologiaRespiratoria::class, 'consulta_id');
    }

    public function sistemaRespiratorio()
    {
        return $this->hasMany(SistemasRespiratorios::class, 'consulta_id');
    }

    public function cupGinecologicos()
    {
        return $this->hasMany(CupGinecologico::class, 'consulta_id');
    }

    public function cupMamografias()
    {
        return $this->hasMany(CupMamografia::class, 'consulta_id');
    }

    public function logsKeiron()
    {
        return $this->hasMany(LogsKeiron::class, 'consulta_id');
    }


    public function scopeWhereTipoHistoria($query, array $tipo_historias = [])
    {
        # compruebo si el arreglo no viene vacío para realizar la consulta por tipo de historia
        if (count($tipo_historias) > 0) {
            return $query->whereHas('cita', function(Builder $query) use ($tipo_historias) {
                $query->whereIn('tipo_historia_id', $tipo_historias);
            });
        }
    }

    public function scopeWhereEspecialidades($query, array $especialidades = [])
    {
        if (count($especialidades) > 0) {
            $query->whereIn('especialidad_id', $especialidades);
        }
    }


    public function scopeWhereMedicoOrdenaId($query, int|null $id)
    {
        if ($id) {
            return $query->whereHas('medicoOrdena.operador', function(Builder $query) use ($id) {
                $query->where('id', $id);
            });
        }
    }

    public function escalaTanner()
    {
        return $this->hasOne(EscalaTanner::class, 'consulta_id');
    }

    public function antecedentesPatologias()
    {
        return $this->hasOne(AntecedentesPatologias::class, 'consulta_id');
    }

    public function HabitosAlimentarios()
    {
        return $this->hasOne(HabitosAlimentarios::class, 'consulta_id');
	}
    public function escalaMchat()
    {
        return $this->hasOne(mChat::class, 'consulta_id');
    }

    public function evolucionSignos()
    {
        return $this->hasOne(EvolucionSignosSintomas::class, 'consulta_id');
    }

    public function conductaRelacionamiento()
    {
        return $this->hasOne(ConductaRelacionamiento::class, 'consulta_id');
    }

    public function conductaInadaptativa()
    {
        return $this->hasOne(ConductaInadaptativa::class, 'consulta_id');
    }

    public function sucesionEvolutiva()
    {
        return $this->hasOne(SucesionEvolutiva::class, 'consulta_id');
    }
    public function RegistroEscalaAbreviadaDesarrollo()
    {
        return $this->hasOne(RegistroEscalaAbreviadaDesarrollo::class, 'consulta_id');
    }
    public function cobro()
    {
        return $this->hasOne(CobroServicio::class, 'consulta_id');
    }

    public function consultaOrdenProcedimientos()
    {
        return $this->hasMany(ConsultaOrdenProcedimientos::class);
    }

    public function registroBiopsias() {
        return $this->hasOne(RegistroBiopsiasPatologias::class, 'consulta_id');
    }

    public function testAssist(){
        return $this->hasOne(testAssist::class, 'consulta_id');
    }

    public function funcionRenal(){
        return $this->hasOne(FuncionRenal::class, 'consulta_id');
    }

    public function pieDiabetico(){
        return $this->hasOne(PieDiabetico::class, 'consulta_id');
    }

    public function OdontogramaIndicadores() {
        return $this->hasOne(OdontogramaIndicadores::class, 'consulta_id');

    }

}


