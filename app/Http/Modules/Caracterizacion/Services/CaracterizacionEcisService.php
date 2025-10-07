<?php

namespace App\Http\Modules\Caracterizacion\Services;

use App\Http\Modules\Afiliados\Repositories\AfiliadoRepository;
use App\Http\Modules\Caracterizacion\Models\CaracterizacionEcis;
use App\Http\Modules\Departamentos\Models\Departamento;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\NovedadesAfiliados\Models\novedadAfiliado;
use Exception;
use Illuminate\Support\Facades\DB;

class CaracterizacionEcisService
{

    public function __construct(private readonly AfiliadoRepository $afiliadoRepository)
    {
    }

    /**
     * Guarda la caracterización ECIS de un afiliado.
     * @param array $data
     * @author Thomas
     * @return CaracterizacionEcis
     */
    public function guardarCaracterizacionEcis(array $data): CaracterizacionEcis
    {
        return DB::transaction(function () use ($data) {
            $afiliado = $this->afiliadoRepository->buscarAfiliadoPorId($data['afiliado_id']);
            if (!$afiliado) {
                throw new Exception('No se encontró el afiliado con el ID proporcionado.');
            }

            $cambios = $this->detectarCambiosAfiliado($afiliado, $data);

            if (!empty($cambios['mensaje'])) {
                novedadAfiliado::create([
                    'fecha_novedad' => now(),
                    'motivo' => $cambios['mensaje'],
                    'afiliado_id' => $afiliado->id,
                    'user_id' => auth()->id(),
                    'tipo_novedad_afiliados_id' => 4,
                ]);

                $afiliado->update($cambios['campos_actualizados']);
            }

            return CaracterizacionEcis::updateOrCreate(
                ['afiliado_id' => $data['afiliado_id']],
                $data
            );
        });
    }

    /**
     * Detecta los cambios en los campos clave del afiliado y devuelve un array con los campos actualizados y un mensaje de cambios detectados.
     * @param mixed $afiliado
     * @param array $data
     * @return array{campos_actualizados: array, mensaje: string|null}
     * @author Thomas
     */
    private function detectarCambiosAfiliado($afiliado, array $data): array
    {
        $camposClave = [
            'dpto_residencia_id',
            'mpio_residencia_id',
            'direccion_residencia_barrio',
            'direccion_residencia_cargue',
            'estrato',
        ];

        $nombreCampos = [
            'dpto_residencia_id' => 'Departamento de residencia',
            'mpio_residencia_id' => 'Municipio de residencia',
            'direccion_residencia_barrio' => 'Barrio',
            'direccion_residencia_cargue' => 'Dirección',
            'estrato' => 'Estrato',
        ];

        $cambiosTexto = [];
        $camposActualizados = [];

        foreach ($camposClave as $campo) {
            if (
                array_key_exists($campo, $data) &&
                strval($afiliado->{$campo}) !== strval($data[$campo])
            ) {
                $valorAnterior = $afiliado->{$campo};
                $valorNuevo = $data[$campo];

                if ($campo === 'dpto_residencia_id') {
                    $valorAnterior = optional($afiliado->departamento_residencia)->nombre;
                    $valorNuevo = optional(Departamento::find($data[$campo]))->nombre;
                }

                if ($campo === 'mpio_residencia_id') {
                    $valorAnterior = optional($afiliado->municipio_residencia)->nombre;
                    $valorNuevo = optional(Municipio::find($data[$campo]))->nombre;
                }

                $cambiosTexto[] = "El campo {$nombreCampos[$campo]} cambió de '{$valorAnterior}' a '{$valorNuevo}'";
                $camposActualizados[$campo] = $data[$campo];
            }
        }

        return [
            'mensaje' => !empty($cambiosTexto) ? 'Se actualizaron los siguientes campos: ' . implode(', ', $cambiosTexto) : null,
            'campos_actualizados' => $camposActualizados,
        ];
    }


    /**
     * Busca la caracterizacion ECIS de un afiliado
     * @param array $data
     * @throws Exception
     * @return array{direccion_residencia_barrio: mixed, direccion_residencia_cargue: mixed, dpto_residencia_id: mixed, estrato: mixed, id: mixed, mpio_residencia_id: mixed}
     * @author Thomas
     */
    public function buscarCaracterizacionEcisAfiliado(array $data)
    {
        $afiliado = $this->afiliadoRepository->buscarAfiliadoActivoPorDocumento(
            $data['tipo_documento'],
            $data['numero_documento']
        );

        if (!$afiliado) {
            throw new Exception('No se encontró un afiliado activo con ese tipo y número de documento. Por favor verifique los datos o su estado de afiliación.');
        }

        $respuesta = [
            'afiliado_id' => $afiliado->id,
            'dpto_residencia_id' => $afiliado->dpto_residencia_id,
            'mpio_residencia_id' => $afiliado->mpio_residencia_id,
            'direccion_residencia_barrio' => $afiliado->direccion_residencia_barrio,
            'direccion_residencia_cargue' => $afiliado->direccion_residencia_cargue,
            'estrato' => $afiliado->estrato,
        ];

        $caracterizacion = $afiliado->caracterizacionEcis;

        if ($caracterizacion) {
            $datos = $caracterizacion->toArray();
            $camposMultiples = [
                'factores_entorno_vivienda',
                'intervenciones_pendientes',
                'escenarios_riesgo'
            ];

            foreach ($camposMultiples as $campo) {
                if (!empty($caracterizacion->$campo)) {
                    $datos[$campo] = json_decode($caracterizacion->$campo, true) ?? [];
                }
            }



            $camposBooleanos = [
                'cuidador_principal',
                'familia_ninos_adolescentes',
                'gestante_familia',
                'familia_adultos_mayores',
                'familia_victima_conflicto_armado',
                'familia_convive_discapacidad',
                'familia_convive_enfermedad_cronica',
                'familia_vivencia_sucesos_vitales',
                'familia_sitacion_vulnerabilidad_social',
                'familia_practicas_cuidado_salud',
                'familia_antecedentes_enfermedades',
                'familia_antecedentes_enfermedades_tratamiento',
                'habitos_vida_saludable',
                'recursos_socioemocionales',
                'practicas_cuidado_proteccion',
                'practicas_establecimiento_relaciones',
                'recursos_sociales_comunitarios',
                'practicas_autonomia_capacidad_funcional',
                'practicas_prevencion_enfermedades',
                'practicas_cuidado_saberes_ancestrales',
                'capacidades_ejercicio_derecho_salud',
                'cumple_esquema_atenciones',
                'practica_deportiva',
                'recibe_lactancia',
                'es_menor_cinco_anios',
                'enfermedades_alergias',
                'tratamiento_enfermedad_actual',
                'pertenece_poblacion_etnica',
                'hacinamiento',
                'criaderos_transmisores_enfermedades',
                'vivienda_realiza_actividad_economica',
            ];

            foreach ($camposBooleanos as $campo) {
                if (array_key_exists($campo, $datos)) {
                    $datos[$campo] = (bool) $datos[$campo];
                }
            }

            $respuesta = array_merge($respuesta, $datos);
        }

        return $respuesta;
    }

}