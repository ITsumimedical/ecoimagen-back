<?php

namespace App\Http\Modules\Historia\Odontograma\Services;

use App\Http\Modules\Historia\Odontograma\Models\OdontogramaIndicadores;
use App\Http\Modules\Historia\Odontograma\Models\OdontogramaParametrizacion;
use App\Http\Modules\Historia\Odontograma\Repositories\OdontogramaRepository;

class OdontogramaServices
{

    protected OdontogramaRepository $odontogramaRepository;

    public function __construct(OdontogramaRepository $odontogramaRepository)
    {
        $this->odontogramaRepository = $odontogramaRepository;
    }

    /**
     * Actualiza una parametrización del odontograma.
     */
    public function actualizarParametrizacion(int $id, array $data)
    {
        return OdontogramaParametrizacion::findOrFail($id)->update($data);
    }

    /**
     * Calcula los índices COP y CEO de un afiliado según su último odontograma.
     */
    public function calcularCopCeo(int $afiliadoId): array
    {
        return $this->guardarResultadosOdontograma($afiliadoId);
    }

    /**
     * Cuenta los diagnósticos del informe 202 agrupados por tipo.
     */
    public function contarDiagnosticoInforme202(int $afiliadoId): array
    {
        return $this->guardarResultadosOdontograma($afiliadoId);
    }



    /**
     * Devuelve una respuesta vacía para el cálculo COP/CEO.
     */
    private function respuestaVaciaCopCeo(string $mensaje): array
    {
        return [
            'COP' => ['C' => 0, 'O' => 0, 'P' => 0],
            'CEO' => ['C' => 0, 'E' => 0, 'O' => 0],
            'mensaje' => $mensaje,
        ];
    }

    /**
     * Devuelve una respuesta vacía para el informe 202.
     */
    private function respuestaVaciaDiagnostico202(string $mensaje): array
    {
        return [
            'SANO' => 0,
            'CARIES NO CAVITACIONAL' => 0,
            'CARIES CAVITACIONAL' => 0,
            'OBTURADO POR CARIES' => 0,
            'PERDIDO POR CARIES' => 0,
            'mensaje' => $mensaje,
        ];
    }

    /**
     * Procesa los odontogramas para contar COP y CEO por tipo de diente.
     */
    private function procesarCopCeo($odontogramas): array
    {
        $cop = ['C' => 0, 'O' => 0, 'P' => 0];
        $ceo = ['C' => 0, 'E' => 0, 'O' => 0];
        $dientesContadosCop = [];
        $dientesContadosCeo = [];

        foreach ($odontogramas as $odontograma) {
            $diente = $this->extraerNumeroDiente($odontograma->cara);
            $tipoCopCeo = $odontograma->parametrizacion->clasificacion_cop_ceo ?? null;
            if (!$tipoCopCeo) continue;

            if ($this->esDienteTemporal($diente)) {
                // Si el diente es temporal, se usa CEO
                $tipoCeo = $tipoCopCeo === 'P' ? 'E' : $tipoCopCeo;
                $this->contarDiente($ceo, $dientesContadosCeo, $diente, $tipoCeo);
            } else {
                // Si el diente es permanente, se usa COP
                $this->contarDiente($cop, $dientesContadosCop, $diente, $tipoCopCeo);
            }
        }

        return ['COP' => $cop, 'CEO' => $ceo];
    }

    /**
     * Procesa los odontogramas para contar diagnósticos del informe 202.
     */
    private function procesarDiagnosticos202($odontogramas): array
    {
        $conteo = [
            'SANO' => 0,
            'CARIES NO CAVITACIONAL' => 0,
            'CARIES CAVITACIONAL' => 0,
            'OBTURADO POR CARIES' => 0,
            'PERDIDO POR CARIES' => 0,
        ];

        $dientesContados = [];

        foreach ($odontogramas as $odontograma) {
            $diente = $this->extraerNumeroDiente($odontograma->cara);
            $diagnostico = $odontograma->parametrizacion->informe_202 ?? null;

            if ($diagnostico && isset($conteo[$diagnostico]) && !isset($dientesContados[$diente])) {
                $conteo[$diagnostico]++;
                $dientesContados[$diente] = true;
            }
        }

        return $conteo;
    }

    /**
     * Extrae el número de diente desde el string de la cara
     */
    private function extraerNumeroDiente(string $cara): int
    {
        return (int) explode('_', $cara)[0];
    }

    /**
     * Determina si el diente es temporal según el código.
     */
    private function esDienteTemporal(int $diente): bool
    {
        return in_array((int) floor($diente / 10), [5, 6, 7, 8]);
    }

    /**
     * Cuenta el tipo de diagnóstico una sola vez por diente.
     */
    private function contarDiente(array &$contador, array &$dientesContados, int $diente, string $tipo): void
    {
        if (!isset($dientesContados[$diente]) && isset($contador[$tipo])) {
            $contador[$tipo]++;
            $dientesContados[$diente] = true;
        }
    }

    /**
     * guardarResultadosOdontograma
     *
     * @param  mixed $afiliadoId
     * @return array
     */
    public function guardarResultadosOdontograma(int $afiliadoId): array
    {
        $consulta = $this->odontogramaRepository->obtenerConsultaConOdontograma($afiliadoId);

        if (!$consulta) {
            return array_merge(
                $this->respuestaVaciaCopCeo('No se encontró una consulta con odontograma para este afiliado.'),
                $this->respuestaVaciaDiagnostico202('No se encontró una consulta con odontograma para este afiliado.')
            );
        }

        $odontogramas = $this->odontogramaRepository->obtenerOdontogramasPorConsulta($consulta->id);


        $copCeo = $this->procesarCopCeo($odontogramas);
        $diagnostico202 = $this->procesarDiagnosticos202($odontogramas);
        $totalDientesPresentes = $this->calcularTotalDientesPresentes($diagnostico202);
        $resultadoInforme = $this->formatearResultadoInforme($diagnostico202, $totalDientesPresentes);

        // Guardar o actualizar los resultados por la misma consulta
        OdontogramaIndicadores::updateOrCreate(
            ['consulta_id' => $consulta->id],
            [
                'cop_c' => $copCeo['COP']['C'],
                'cop_o' => $copCeo['COP']['O'],
                'cop_p' => $copCeo['COP']['P'],
                'ceo_c' => $copCeo['CEO']['C'],
                'ceo_e' => $copCeo['CEO']['E'],
                'ceo_o' => $copCeo['CEO']['O'],
                'sano' => $diagnostico202['SANO'],
                'caries_no_cavitacional' => $diagnostico202['CARIES NO CAVITACIONAL'],
                'caries_cavitacional' => $diagnostico202['CARIES CAVITACIONAL'],
                'obturado_por_caries' => $diagnostico202['OBTURADO POR CARIES'],
                'perdido_por_caries' => $diagnostico202['PERDIDO POR CARIES'],
                'resultado_informe' => $resultadoInforme,
            ]
        );


        return array_merge($copCeo, $diagnostico202, [
            'resultado_informe' => $resultadoInforme,
            'total_dientes_presentes' => $totalDientesPresentes
        ]);
    }

    /**
     * Calcula el total de dientes presentes a partir del diagnóstico 202.
     */
    private function calcularTotalDientesPresentes(array $diagnostico): int
    {
        return ($diagnostico['SANO'] ?? 0) +
            ($diagnostico['CARIES NO CAVITACIONAL'] ?? 0) +
            ($diagnostico['CARIES CAVITACIONAL'] ?? 0) +
            ($diagnostico['OBTURADO POR CARIES'] ?? 0) +
            ($diagnostico['PERDIDO POR CARIES'] ?? 0);
    }

    /**
     * Genera el string del resultado del informe con formato de dos dígitos y espacios.
     */
    private function formatearResultadoInforme(array $diagnostico, int $total): string
    {
        $format = fn($n) => str_pad($n ?? 0, 2, '0', STR_PAD_LEFT);

        return implode(' ', [
            $format($diagnostico['SANO'] ?? 0),
            $format($diagnostico['CARIES NO CAVITACIONAL'] ?? 0),
            $format($diagnostico['CARIES CAVITACIONAL'] ?? 0),
            $format($diagnostico['OBTURADO POR CARIES'] ?? 0),
            $format($diagnostico['PERDIDO POR CARIES'] ?? 0),
            $format($total),
        ]);
    }
}
