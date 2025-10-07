<?php

namespace App\Formats\Medicamentos;

use App\Http\Modules\Cie10Afiliado\Models\Cie10Afiliado;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;
use Illuminate\Database\Eloquent\Collection;



class Formula extends Medicamento
{

    public function __construct() {
        parent::__construct();
    }

    /**
     * genera el pdf de una formula dispensada
     * @param string $nombre
     * @return string ruta donde se guardará el pdf
     */
    public function generar(Orden|int $orden, string $nombre = 'formula.pdf'): string
    {
        if (is_int($orden)) {
            $this->orden = Orden::where('id', $orden)->first();
        } else {
            $this->orden = $orden;
        }

        $this->marcaDeAgua = 'F O R M U L A  M E D I C A';
        $this->consulta = $this->orden->consulta;
        $this->afiliado = $this->orden->consulta->afiliado;
        $this->info = "Esta orden es vigente 30 días (Resolución 4331 de 2012), Siga las recomendaciones de su médico tratante para garantizar la adecuada administración de sus medicamentos. Recuerde que la adherencia al tratamiento es primordial para los objetivos terapéuticos. En caso de presentar algún evento no deseado, consulte con su médico tratante.";
        $this->cie10s = [];

        $this->consulta->cie10Afiliado->map(function ($cie10) {
            $this->cie10s[] = $cie10->cie10->codigo_cie10;
        });

        $ordenArticulos = $this->orden->articulos;

        $this->body($ordenArticulos);
        return $this->Output('F', storage_path('app/' . $nombre));
    }

    private function body(Collection $ordenArticulos)
    {
        $ordenArticulosAgrupados = $ordenArticulos->groupBy('rep_id');
        foreach ($ordenArticulosAgrupados as $rep_id => $articulos) {
            if(!$rep_id){
                $this->rep = Rep::where('id', 77526)->first(); // este ID esta pensado para produccion, pertenece a FARMACIA RAMEDICAS CENTRO 
            }else {
                $this->rep = Rep::where('id', $rep_id)->first();
            }
            $this->AddPage();
            $Y = 70;
            $countPerPage = 0; // Contador de medicamentos por página

            foreach ($articulos as $articulo) {

                if ($countPerPage >= 3) {
                    $countPerPage = 0;
                    $this->AddPage();
                    $Y = 70;
                }

                $this->SetFont('Arial', 'B', 6);
                $this->SetXY(5, $Y);
                $this->MultiCell(15, 4, $articulo->codesumi->codigo, 0, 'C', 0);
                $this->SetXY(24, $Y);
                $this->MultiCell(70, 4, utf8_decode(strtoupper($articulo->codesumi->nombre)), 0, 'L', 0);

                $YN1 = round($this->GetY(), 0, PHP_ROUND_HALF_DOWN);
                $this->SetXY(106, $Y);
                $dosificacion = is_null($articulo->dosificacion_medico) ? $articulo->formula : $articulo->dosificacion_medico;
                $palabras = explode(' ', trim($dosificacion));
                $segundoValor = isset($palabras[2]) ? $palabras[2] : '';
                $this->MultiCell(51, 4, utf8_decode($segundoValor), 0, 'L', 0);
                $this->SetXY(127, $Y);
                $this->MultiCell(51, 4, is_null($articulo->dosificacion_medico) ? utf8_decode($articulo->formula) : utf8_decode($articulo->dosificacion_medico), 0, 'L', 0);

                $YN2 = round($this->GetY(), 0, PHP_ROUND_HALF_DOWN);
                $this->SetXY(180, $Y);
                $this->MultiCell(13, 4, $articulo->duracion . ' dias', 0, 'C', 0);
                $this->SetXY(188, $Y);
                $this->MultiCell(20, 4, $articulo->cantidad_medico, 0, 'C', 0);

                $YN = max($YN1, $YN2);
                $YO = round($this->GetY(), 0, PHP_ROUND_HALF_DOWN);
                $this->SetXY(5, max($YO, $YN));
                $this->Line(5, max($YN + 0.5, $YO), 205, max($YN + 0.5, $YO));
                $this->SetFont('Arial', 'B', 7);
                $this->MultiCell(200, 4, utf8_decode('Observaciones: ' . $articulo->observacion), 0, 'L', 0);

                $YL = round($this->GetY(), 0, PHP_ROUND_HALF_DOWN);
                $this->Line(5, max($YL, $YN) + 2, 205, max($YL, $YN) + 2);

                $Y = max($YL, $YN) + 6;
                $countPerPage++;
            }

            // // Imprimo control especial en una nueva hoja
            // if (!empty($itemsControlEspecial)) {
            //     $pdf->AddPage();
            //     $Y = 76;

            //     foreach ($itemsControlEspecial as $item) {
            //         $pdf->SetFont('Arial', 'B', 6);
            //         $pdf->SetXY(5, $Y);
            //         $pdf->MultiCell(15, 4, $item->codesumi->codigo, 0, 'C', 0);
            //         $pdf->SetXY(24, $Y);
            //         $pdf->MultiCell(70, 4, utf8_decode(strtoupper($item->codesumi->nombre)), 0, 'L', 0);

            //         $YN1 = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
            //         $pdf->SetXY(106, $Y);

            //         $dosificacion = is_null($item->dosificacion_medico) ? $item->formula : $item->dosificacion_medico;
            //         $palabras = explode(' ', trim($dosificacion));
            //         $segundoValor = isset($palabras[2]) ? $palabras[2] : '';
            //         $pdf->MultiCell(51, 4, utf8_decode($segundoValor), 0, 'L', 0);

            //         $pdf->SetXY(127, $Y);
            //         $pdf->MultiCell(51, 4, is_null($item->dosificacion_medico) ? utf8_decode($item->formula) : utf8_decode($item->dosificacion_medico), 0, 'L', 0);

            //         $YN2 = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
            //         $pdf->SetXY(180, $Y);
            //         $pdf->MultiCell(13, 4, $item->duracion . ' dias', 0, 'C', 0);
            //         $pdf->SetXY(188, $Y);
            //         $pdf->MultiCell(20, 4, $item->cantidad_medico, 0, 'C', 0);
            //         $YN = max($YN1, $YN2);
            //         $YO = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
            //         $pdf->SetXY(5, max($YO, $YN));
            //         $pdf->Line(5, max($YN + 0.5, $YO), 205, max($YN + 0.5, $YO));
            //         $pdf->SetFont('Arial', 'B', 7);
            //         $pdf->MultiCell(200, 4, utf8_decode('Observaciones: ' . $item->observacion), 0, 'L', 0);

            //         $YL = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
            //         $pdf->Line(5, max($YL, $YN) + 2, 205, max($YL, $YN) + 2);

            //         $Y = max($YL, $YN) + 6;
            //     }
            // }

            // // Imprimo "NO PBS" en una nueva hoja
            // if (count($itemsEstadoNormativo) > 0) { // si hay uno o mas medicamentos que se cree una nueva pagina con el medicamento NO PBS
            //     $pdf->AddPage();
            // }

            // $Y = 76;

            // foreach ($itemsEstadoNormativo as $item) {
            //     $pdf->SetFont('Arial', 'B', 6);
            //     $pdf->SetXY(5, $Y);
            //     $pdf->MultiCell(15, 4, $item->codesumi->codigo, 0, 'C', 0);
            //     $pdf->SetXY(24, $Y);
            //     $pdf->MultiCell(70, 4, utf8_decode(strtoupper($item->codesumi->nombre)), 0, 'L', 0);

            //     $YN1 = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
            //     $pdf->SetXY(106, $Y);
            //     $dosificacion = is_null($item->dosificacion_medico) ? $item->formula : $item->dosificacion_medico;
            //     $palabras = explode(' ', trim($dosificacion));
            //     $segundoValor = isset($palabras[2]) ? $palabras[2] : '';
            //     $pdf->MultiCell(51, 4, utf8_decode($segundoValor), 0, 'L', 0);
            //     $pdf->SetXY(127, $Y);
            //     $pdf->MultiCell(51, 4, is_null($item->dosificacion_medico) ? utf8_decode($item->formula) : utf8_decode($item->dosificacion_medico), 0, 'L', 0);

            //     $YN2 = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
            //     $pdf->SetXY(180, $Y);
            //     $pdf->MultiCell(13, 4, $item->duracion . ' dias', 0, 'C', 0);
            //     $pdf->SetXY(188, $Y);
            //     $pdf->MultiCell(20, 4, $item->cantidad_medico, 0, 'C', 0);
            //     $YN = max($YN1, $YN2);
            //     $YO = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
            //     $pdf->SetXY(5, max($YO, $YN));
            //     $pdf->Line(5, max($YN + 0.5, $YO), 205, max($YN + 0.5, $YO));
            //     $pdf->SetFont('Arial', 'B', 7);
            //     $pdf->MultiCell(200, 4, utf8_decode('Observaciones: ' . $item->observacion), 0, 'L', 0);

            //     $YL = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
            //     $pdf->Line(5, max($YL, $YN) + 2, 205, max($YL, $YN) + 2);

            //     $Y = max($YL, $YN) + 6;
            // }
        }
    }
}
