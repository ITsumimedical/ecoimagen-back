<?php

namespace App\Http\Modules\RegistroBiopsias\Services;

use App\Http\Modules\RegistroBiopsias\Models\BiopsiaCancerMama;
use App\Http\Modules\RegistroBiopsias\Models\RegistroBiopsiasPatologias;
use App\Http\Modules\RegistroBiopsias\Models\RegistroCancerColon;
use App\Http\Modules\RegistroBiopsias\Models\RegistroCancerGastrico;
use App\Http\Modules\RegistroBiopsias\Models\RegistroCancerOvarios;
use App\Http\Modules\RegistroBiopsias\Models\RegistroCancerProstata;
use App\Http\Modules\RegistroBiopsias\Models\RegistroCancerPulmon;
use Exception;
use Illuminate\Support\Facades\DB;

class RegistroBiopsiaPatologiasServices
{

    /**
     * Registra una biopsia con un tipo específico.
     *
     * @param array $data Los datos de la biopsia a registrar.
     * @param string $tipo El tipo de biopsia a registrar.
     * @return mixed El resultado del registro de la biopsia.
     */
    public function registrarBiopsiaConTipo(array $data, string $tipo)
    {
        DB::beginTransaction();
        try {
            $criterio = [];

            if (!empty($data['id'])) {
                $criterio['id'] = $data['id'];
            } elseif (!empty($data['consulta_id'])) {
                $criterio['consulta_id'] = $data['consulta_id'];
            }

            if (empty($criterio)) {
                //No hay criterio entonces creamos un registro nuevo
                $registro = RegistroBiopsiasPatologias::create($data);
            } else {
                // Buscar por criterio y actualizar o crear si no existe
                $registro = RegistroBiopsiasPatologias::updateOrCreate($criterio, $data);
            }

            $data['registro_biopsias_patologia_id'] = $registro->id;

            // Guardar el registro específico según tipo
            $modelos = [
                'mama'     => BiopsiaCancerMama::class,
                'prostata' => RegistroCancerProstata::class,
                'ovario'   => RegistroCancerOvarios::class,
                'pulmon'   => RegistroCancerPulmon::class,
                'gastrico' => RegistroCancerGastrico::class,
                'colon' => RegistroCancerColon::class
            ];

            if (!isset($modelos[$tipo])) {
                throw new Exception("Tipo de biopsia desconocido: {$tipo}");
            }

            $modelos[$tipo]::updateOrCreate(
                ['registro_biopsias_patologia_id' => $registro->id],
                $data
            );

            DB::commit();
            return $registro;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
