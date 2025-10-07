<?php

namespace App\Http\Modules\RegistroBiopsias\Repositories;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\RegistroBiopsias\Models\BiopsiaCancerMama;
use App\Http\Modules\RegistroBiopsias\Models\RegistroBiopsiasPatologias;
use App\Http\Modules\RegistroBiopsias\Models\RegistroCancerColon;
use App\Http\Modules\RegistroBiopsias\Models\RegistroCancerGastrico;
use App\Http\Modules\RegistroBiopsias\Models\RegistroCancerOvarios;
use App\Http\Modules\RegistroBiopsias\Models\RegistroCancerProstata;
use App\Http\Modules\RegistroBiopsias\Models\RegistroCancerPulmon;
use Illuminate\Support\Facades\DB;

class RegistroBiopsiaPatologiasRepository extends RepositoryBase
{

    public function __construct(protected RegistroBiopsiasPatologias $registroBiopsiasPatologias)
    {
        parent::__construct($this->registroBiopsiasPatologias);
    }

    /**
     * Obtiene la información de la última biopsia registrada para un afiliado específico.
     *
     * @param int $afiliado_id El identificador único del afiliado.
     * @return mixed Información de la última biopsia del afiliado, o null si no existe.
     */
    public function listarUltimaBiopsiaAfiliado(int $afiliado_id)
    {
        return $this->registroBiopsiasPatologias::select('registro_biopsias_patologias.*', 'cie10s.codigo_cie10', 'cie10s.nombre as nombre_cie10')
            ->join('cie10s', 'registro_biopsias_patologias.cie10_id', 'cie10s.id')
            ->where('afiliado_id', $afiliado_id)
            ->latest()->first();
    }

    /**
     * Lista el historial de biopsias asociadas a un afiliado específico.
     *
     * @param string $numeroDocumento Número de documento del afiliado.
     * @param string $tipoDocumento Tipo de documento del afiliado.
     * @return mixed Retorna una colección o array con el historial de biopsias del afiliado.
     */
    public function listarHistoricoBiopsiasPorAfiliado(string $numeroDocumento, string $tipoDocumento)
    {
        // Buscar afiliado
        $afiliado = Afiliado::where('numero_documento', $numeroDocumento)
            ->where('tipo_documento', $tipoDocumento)
            ->first();

        if (!$afiliado) {
            return null;
        }

        // Buscar las biopsias por afiliado
        return $this->registroBiopsiasPatologias::where('afiliado_id', $afiliado->id)->with(
            'cie10:id,codigo_cie10,descripcion,nombre',
            'cie10.tipoCancer',
            'usuarioCrea:id',
            'usuarioCrea.operador:user_id,nombre,apellido',
            'usuarioActualiza:id',
            'usuarioActualiza.operador:user_id,nombre,apellido'
        )->get();
    }

    /**
     * Obtiene el registro de cáncer asociado a un afiliado a partir del ID de la biopsia.
     *
     * @param int $biopsia_id El identificador único de la biopsia.
     * @return mixed El registro de cáncer correspondiente al afiliado, o null si no se encuentra.
     */
    public function obtenerRegistroCancerAfiliado(int $biopsia_id)
    {
        // Obtener el registro de biopsia por ID
        $registro = RegistroBiopsiasPatologias::find($biopsia_id);
        if (!$registro) {
            return null;
        }

        $diagnostico = $this->obtenerTipoCancerPorCie10($registro->cie10_id);
        if (!$diagnostico) {
            return null;
        }

        $modelos = [
            1 => BiopsiaCancerMama::class,
            2 => RegistroCancerProstata::class,
            3 => RegistroCancerColon::class,
            4 => RegistroCancerOvarios::class,
            5 => RegistroCancerPulmon::class,
            6 => RegistroCancerGastrico::class,
        ];

        $modelo = $modelos[$diagnostico->tipo_cancer_id] ?? null;
        if (!$modelo) {
            return null;
        }

        // Retornar el detalle del tipo de cáncer
        return $modelo::where('registro_biopsias_patologia_id', $registro->id)->first();
    }

    /**
     * Obtiene el tipo de cáncer asociado a un código CIE-10 específico.
     *
     * @param int|string $cie10_id El identificador o código CIE-10 para el cual se desea obtener el tipo de cáncer.
     * @return mixed El tipo de cáncer correspondiente al código CIE-10 proporcionado, o null si no se encuentra.
     */
    public function obtenerTipoCancerPorCie10($cie10_id)
    {
        return DB::table('diagnosticos_tipo_cancer')
            ->where('cie10_id', $cie10_id)
            ->first();
    }
}
