<?php

namespace App\Formats;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Mail;
use App\Http\Modules\Consultas\Models\Consulta;
use DateTime;

class HistoriaClinica extends Fpdf
{
    protected static $consulta;
    protected static $resultados;

    public function generar($id, $correo)
    {
        self::$consulta = Consulta::with([
            'agenda',
            'afiliado.tipoDocumento',
            'cita',
            'cita.categorias',
            'cita.categorias.campos',
            'historia',
            'agenda.consultorio.rep',
            'antecedentePersonales',
            'medicoOrdena.especialidades',
            'HistoriaClinica.NotaAclaratoria',
            'antecedentesFarmacologicos',
            'antecedentesFarmacologicos.medicamento.codesumi',
            'antecedentesFamiliares',
            'antecedenteTransfucionales',
            'vacunacion',
            'antecedenteQuirurgicos',
            'antecedenteHospitalarios',
            'antecedentesSexuales',
            'antecedenteEcomapa',
            'antecedenteFamiliograma',
            'resultadoLaboratorios',
            'cie10Afiliado.cie10',
            'planCuidado',
            'informacionSalud',
            'PracticaCrianza',
            'ordenes.procedimientos' => function ($query) {
                $query->whereIn('estado_id', [1, 4]);
            },
            'ordenes.articulos' => function ($query) {
                $query->whereIn('estado_id', [1, 4]);
            },
            'especialidad',
            'rep',
            'insumos',
            'patologias',
            'antecedentesOdontologicos',
            'examenFisicoOdontologicos',
            'examenTejidoOdontologicos',
            'odontograma',
            'paraclinicosOdontologicos',
            'planTramientoOdontologia',
            'adherenciaFarmaceutica',
            'cupGinecologicos',
            'cupMamografias'
        ])->find($id);
        // dd(self::$consulta->medicoOrdena->especialidades) ;
        //        ->whereHas('HistoriaClinica',function($query) use ($id){
        //            $query->where('id',$id);
        //        })->first();
        // dd(self::$consulta["medicoOrdena"]["Firma"]);
        //dd(self::$consulta['antecedentesFarmacologicos']);
        $pdf = new HistoriaClinica('p', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $this->body($pdf);
        if ($correo) {
            $data = [];
            $nombre = self::$consulta["afiliado"]["nombre_completo"];
            $cedula = self::$consulta["afiliado"]["numero_documento"];
            Mail::send('enviar_historia', $data, function ($message) use ($correo, $nombre, $cedula, $pdf) {
                $message->to($correo);
                $message->subject($cedula . " " . $nombre);
                $message->attachData($pdf->Output("S"), 'Historia Integral' . ' ' . $cedula . ' ' . $nombre . '.pdf', [
                    'mime' => 'application/pdf',
                ]);
            });
        }
        if (self::$consulta["cita"]["tipo_historia_id"] == 16) {
            $this->odontograma($pdf);
        }
        $pdf->Output();
    }


    private function drawTeethSection($pdf, $x, $y, $teeth, $width, $height, $spacing)
    {
        foreach ($teeth as $index => $toothNumber) {
            $currentX = $x + $index * ($width + $spacing);
            $this->drawTooth($pdf, $currentX, $y, $width, $height, $toothNumber);
        }
    }

    private function drawTooth($pdf, $x, $y, $width, $height, $toothNumber)
    {
        // Dibujar la cruz del diente hecha de cuadros
        $pdf->SetTextColor(0, 0, 0);
        // Inicializar variables
        $caras = [];

        // Obtener todas las instancias del diente
        foreach (self::$consulta["odontograma"] as $diente) {
            if ($diente['diente'] == $toothNumber) {
                $caras[] = $diente;
            }
        }
        $pdf->Rect($x, $y, $width, $height); // Cuadro central
        $pdf->Rect($x - $width, $y, $width, $height); // Cuadro izquierda
        $pdf->Rect($x + $width, $y, $width, $height); // Cuadro derecha
        $pdf->Rect($x, $y - $height, $width, $height); // Cuadro superior
        $pdf->Rect($x, $y + $height, $width, $height); // Cuadro inferior

        // Dibujar el número del diente
        $pdf->Text($x - 2, $y - $height - 2, (string)$toothNumber);

        // Aplicar los estados del diente y las marcas en las caras
        foreach ($caras as $cara) {
            $state = $cara['diente_tipo'];
            switch ($state) {
                case 'DIENTE SANO':
                    $pdf->SetTextColor(0, 0, 0); // Negro
                    $pdf->SetFont('Arial', '', 40);
                    $pdf->Text($x - 2, $y + 7, 'S');
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                case 'REQUIERE RADIOGRAFIA':
                    $pdf->SetTextColor(255, 0, 0); // Negro
                    $pdf->SetFont('Arial', '', 12);
                    $pdf->Text($x - 2, $y - 10, 'RX');
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                case 'ANODONCIA':
                    $pdf->SetDrawColor(0, 0, 255); // Azul
                    $pdf->SetLineWidth(1);
                    $pdf->Line($x - $width + 1, $y + 2, $x + $width + 3, $y + 2); // Raya horizontal
                    $pdf->SetLineWidth(0);
                    $pdf->SetDrawColor(0, 0, 0);
                    break;
                case 'EXFOLIACION DE LOS DIENTES DEBIDA A CAUSAS SISTEMICAS':
                case 'DIENTE PERDIDO POR CARIES':
                case 'PERDIDA DE DIENTES DEBIDA A ACCIDENTE, EXTRACCION O ENFERMEDAD PERIODONTAL LOCAL':
                    $pdf->SetDrawColor(255, 0, 0); // Rojo
                    $pdf->SetLineWidth(1);
                    $pdf->Line($x + 2, $y - $height + 1, $x + 2, $y + $height + 3); // Raya vertical
                    $pdf->SetLineWidth(0);
                    $pdf->SetDrawColor(0, 0, 0);
                    break;
                case 'DIENTE NO ERUPCIONADO':
                    $pdf->SetDrawColor(0, 0, 255); // Azul
                    $pdf->SetLineWidth(1);
                    $pdf->Line($x - $width + 1, $y + 2, $x + $width + 3, $y + 2); // Raya horizontal
                    $pdf->SetLineWidth(0);
                    $pdf->SetDrawColor(0, 0, 0);
                    break;
                case 'RAIZ DENTAL RETENIDA':
                    $pdf->SetDrawColor(255, 0, 0); // Rojo
                    $pdf->SetLineWidth(1);
                    $pdf->Line($x + 2 - $width, $y + 2 - $height, $x + 2 + $width, $y + 2 + $height); // Diagonal \
                    $pdf->Line($x + 2 + $width, $y + 2 - $height, $x + 2 - $width, $y + 2 + $height); // Diagonal /
                    $pdf->SetLineWidth(0);
                    $pdf->SetDrawColor(0, 0, 0);
                    break;
                case 'DIENTE INCLUIDO':
                case 'DIENTE IMPACTADO':
                    $pdf->SetTextColor(255, 0, 0); // Rojo
                    $pdf->SetFont('Arial', '', 90);
                    $pdf->SetLineWidth(1);
                    $pdf->Text($x - 4, $y + 20, '*');
                    $pdf->SetLineWidth(0);
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                case 'CORONA EN MAL ESTADO':
                case 'PROVISIONAL EN MAL ESTADO':
                    $pdf->SetDrawColor(255, 0, 0); // Rojo
                    $pdf->SetLineWidth(1); // Ajusta el grosor del contorno
                    $pdf->Ellipse($x + 2, $y + 2, $width, $height); // Círculo
                    $pdf->SetLineWidth(0); // Ajusta el grosor del contorno
                    $pdf->SetDrawColor(0, 0, 0);
                    break;
                case 'CORONA EN BUEN ESTADO':
                case 'PROVISIONAL EN BUEN ESTADO':
                    $pdf->SetDrawColor(0, 0, 255); // Azul
                    $pdf->SetLineWidth(1); // Ajusta el grosor del contorno
                    $pdf->Ellipse($x + 2, $y + 2, $width, $height); // Círculo
                    $pdf->SetLineWidth(0); // Ajusta el grosor del contorno
                    $pdf->SetDrawColor(0, 0, 0);
                    break;
                default:
                    // DIENTE PRESENTE y otras condiciones
                    if ($cara['diente_tipo'] == 'DIENTE PRESENTE') {
                        $this->subDiagnosticos($pdf, $x, $y, $width, $height, $cara);
                    }
                    break;
            }
        }
    }

    private function odontograma($pdf)
    {

        $pdf->AddPage('L'); // Orientación horizontal
        #odontograma
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(270, 6, utf8_decode('ODONTOGRAMA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);

        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();


        $xStart = 18;
        $yStart = $pdf->GetY();
        $width = 4;
        $height = 4;
        $spacing = 12;


        // Dientes superiores derecho
        // Dientes superiores derecho
        $this->drawTeethSection($pdf, $xStart, $yStart, [18, 17, 16, 15, 14, 13, 12, 11], $width, $height, $spacing);

        // Dientes de leche superiores derecho
        $this->drawTeethSection($pdf, $xStart + 30, $yStart + 1.5 * ($height + $spacing), [55, 54, 53, 52, 51], $width, $height, $spacing);

        // Dientes superiores izquierdo
        $this->drawTeethSection($pdf, $xStart + 9 * ($width + $spacing), $yStart, [21, 22, 23, 24, 25, 26, 27, 28], $width, $height, $spacing);
        $this->drawTeethSection($pdf, $xStart + 9 * ($width + $spacing), $yStart + 1.5 * ($height + $spacing), [61, 62, 63, 64, 65], $width, $height, $spacing);

        // Dientes de leche inferiores derecho
        $this->drawTeethSection($pdf, $xStart + 30, $yStart + 3.0 * ($height + $spacing), [85, 84, 83, 82, 81], $width, $height, $spacing);

        // Dientes inferiores derecho
        $this->drawTeethSection($pdf, $xStart, $yStart + 4.5 * ($height + $spacing), [48, 47, 46, 45, 44, 43, 42, 41], $width, $height, $spacing);


        // Dientes inferiores izquierdo
        $this->drawTeethSection($pdf, $xStart + 9 * ($width + $spacing), $yStart + 3.0 * ($height + $spacing), [71, 72, 73, 74, 75], $width, $height, $spacing);

        $this->drawTeethSection($pdf, $xStart + 9 * ($width + $spacing), $yStart + 4.5 * ($height + $spacing), [31, 32, 33, 34, 35, 36, 37, 38], $width, $height, $spacing);

        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Ln();



        $pdf->SetX(12);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(270, 6, utf8_decode('DIAGNOSTICOS'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFont('Arial', '', 12);
        if (count(self::$consulta["odontograma"]) > 0) {
            foreach (self::$consulta["odontograma"] as $odontograma) {
                $textoOdontograma = "Diente: " . utf8_decode($odontograma->diente) . ", Estado: " . utf8_decode($odontograma->diente_tipo);
                $dxDiente = ", oclusal: " . utf8_decode($odontograma->oclusal ? $odontograma->oclusal : 'Sano') .
                    ", mesial: " . utf8_decode($odontograma->mesial ? $odontograma->mesial : 'Sano') .
                    ", distal: " . utf8_decode($odontograma->distal ? $odontograma->distal : 'Sano') .
                    ", vestibular: " . utf8_decode($odontograma->vestibular ? $odontograma->vestibular : 'Sano') .
                    ", palatino: " . utf8_decode($odontograma->palatino ? $odontograma->palatino : 'Sano') .
                    ", requiere endodoncia: " . utf8_decode($odontograma->requiere_endodoncia ? $odontograma->requiere_endodoncia : 'No') .
                    ", requiere sellante: " . utf8_decode($odontograma->requiere_sellante ? $odontograma->requiere_sellante : 'No') .
                    ", endodocia presente: " . utf8_decode($odontograma->endodocia_presente ? $odontograma->endodocia_presente : 'No');
                if ($odontograma->diente_tipo == 'DIENTE PRESENTE') {
                    $texto = $textoOdontograma . ' ' . $dxDiente;
                    $pdf->SetX(12);
                    $pdf->MultiCell(270, 6, utf8_decode($texto), 1, 'L');
                } else {
                    $pdf->SetX(12);
                    $pdf->MultiCell(270, 6, utf8_decode($textoOdontograma), 1, 'L');
                }
            }
        } else {
            $textoOdontograma = utf8_decode('No Refiere');
            $pdf->SetX(12);
            $pdf->MultiCell(270, 6, utf8_decode($textoOdontograma), 1, 'L');
        }
        $pdf->SetTextColor(0, 0, 0);
        $pdf->SetDrawColor(0, 0, 0);
    }

    private function subDiagnosticos($pdf, $x, $y, $width, $height, $caras)
    {
        //centro
        switch ($caras['oclusal']) {
            case 'CARIES DE LA DENTINA':
                $pdf->SetTextColor(255, 0, 0); // rojo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA DESADAPTADA':
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA DESADAPTADA':
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'SELLANTE EN BUEN ESTADO':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 40);
                $pdf->Text($x - 2, $y + 7, 'S');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
                break;
            default:
                $pdf->SetTextColor(0, 0, 0);
                // DIENTE PRESENTE (sin color específico)
                break;
        }

        //derecha
        switch ($caras['mesial']) {
            case 'CARIES DE LA DENTINA':
                $pdf->SetTextColor(255, 0, 0); // rojo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x - 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x - 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x - 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA DESADAPTADA':
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x - 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA DESADAPTADA':
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x - 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            default:
                $pdf->SetTextColor(0, 0, 0);
                // DIENTE PRESENTE (sin color específico)
                break;
        }

        switch ($caras['requiere_endodoncia']) {
            case 'Si':
                $pdf->SetFillColor(255, 0, 0); // Rojo
                $pdf->SetLineWidth(1); // Ajusta el grosor del contorno
                $pdf->drawTriangleNomral($pdf, $x + 6, $y + 6, $width, $height); // Dibujar triángulo
                $pdf->SetLineWidth(0); // Ajusta el grosor del contorno
                $pdf->SetFillColor(0, 0, 0);
                break;
        }

        switch ($caras['requiere_sellante']) {
            case 'Si':
                $pdf->SetTextColor(255, 0, 0); // rojo
                $pdf->SetFont('Arial', '', 40);
                $pdf->Text($x - 2, $y + 7, 'S');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
        }

        switch ($caras['endodocia_presente']) {
            case 'Si':
                $pdf->SetFillColor(0, 0, 0); // negro
                $pdf->SetLineWidth(1); // Ajusta el grosor del contorno
                $pdf->drawTriangle($pdf, $x + 5, $y + 5, $width, $height); // Dibujar triángulo
                $pdf->SetLineWidth(0); // Ajusta el grosor del contorno
                $pdf->SetFillColor(0, 0, 0);
                break;
        }

        //izquierda
        switch ($caras['distal']) {
            case 'CARIES DE LA DENTINA':
                $pdf->SetTextColor(255, 0, 0); // rojo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x + 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x + 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x + 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA DESADAPTADA':
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x + 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA DESADAPTADA':
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x + 4, $y + 5, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            default:
                $pdf->SetTextColor(0, 0, 0);
                // DIENTE PRESENTE (sin color específico)
                break;
        }

        //afuera
        switch ($caras['vestibular']) {
            case 'CARIES DE LA DENTINA':
                if (
                    $caras['diente'] == 11 ||
                    $caras['diente'] == 12 ||
                    $caras['diente'] == 13 ||
                    $caras['diente'] == 14 ||
                    $caras['diente'] == 15 ||
                    $caras['diente'] == 16 ||
                    $caras['diente'] == 17 ||
                    $caras['diente'] == 18 ||
                    $caras['diente'] == 21 ||
                    $caras['diente'] == 22 ||
                    $caras['diente'] == 23 ||
                    $caras['diente'] == 24 ||
                    $caras['diente'] == 25 ||
                    $caras['diente'] == 26 ||
                    $caras['diente'] == 27 ||
                    $caras['diente'] == 28 ||
                    $caras['diente'] == 51 ||
                    $caras['diente'] == 52 ||
                    $caras['diente'] == 53 ||
                    $caras['diente'] == 54 ||
                    $caras['diente'] == 61 ||
                    $caras['diente'] == 62 ||
                    $caras['diente'] == 63 ||
                    $caras['diente'] == 64 ||
                    $caras['diente'] == 65
                ) {
                    $pdf->SetTextColor(255, 0, 0); // rojo
                    $pdf->SetFont('Arial', '', 23);
                    $pdf->Text($x, $y + 1, '+');
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                }
                $pdf->SetTextColor(255, 0, 0); // rojo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;

            case 'OBTURACION EN RESINA':
                if (
                    $caras['diente'] == 11 ||
                    $caras['diente'] == 12 ||
                    $caras['diente'] == 13 ||
                    $caras['diente'] == 14 ||
                    $caras['diente'] == 15 ||
                    $caras['diente'] == 16 ||
                    $caras['diente'] == 17 ||
                    $caras['diente'] == 18 ||
                    $caras['diente'] == 21 ||
                    $caras['diente'] == 22 ||
                    $caras['diente'] == 23 ||
                    $caras['diente'] == 24 ||
                    $caras['diente'] == 25 ||
                    $caras['diente'] == 26 ||
                    $caras['diente'] == 27 ||
                    $caras['diente'] == 28 ||
                    $caras['diente'] == 51 ||
                    $caras['diente'] == 52 ||
                    $caras['diente'] == 53 ||
                    $caras['diente'] == 54 ||
                    $caras['diente'] == 61 ||
                    $caras['diente'] == 62 ||
                    $caras['diente'] == 63 ||
                    $caras['diente'] == 64 ||
                    $caras['diente'] == 65
                ) {
                    $pdf->SetTextColor(0, 0, 255); // azul
                    $pdf->SetFont('Arial', '', 23);
                    $pdf->Text($x, $y + 1, '+');
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                }
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA':
                if (
                    $caras['diente'] == 11 ||
                    $caras['diente'] == 12 ||
                    $caras['diente'] == 13 ||
                    $caras['diente'] == 14 ||
                    $caras['diente'] == 15 ||
                    $caras['diente'] == 16 ||
                    $caras['diente'] == 17 ||
                    $caras['diente'] == 18 ||
                    $caras['diente'] == 21 ||
                    $caras['diente'] == 22 ||
                    $caras['diente'] == 23 ||
                    $caras['diente'] == 24 ||
                    $caras['diente'] == 25 ||
                    $caras['diente'] == 26 ||
                    $caras['diente'] == 27 ||
                    $caras['diente'] == 28 ||
                    $caras['diente'] == 51 ||
                    $caras['diente'] == 52 ||
                    $caras['diente'] == 53 ||
                    $caras['diente'] == 54 ||
                    $caras['diente'] == 61 ||
                    $caras['diente'] == 62 ||
                    $caras['diente'] == 63 ||
                    $caras['diente'] == 64 ||
                    $caras['diente'] == 65
                ) {
                    $pdf->SetTextColor(0, 0, 255); // azul
                    $pdf->SetFont('Arial', '', 23);
                    $pdf->Text($x, $y + 1, '+');
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                }
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA DESADAPTADA':
                if (
                    $caras['diente'] == 11 ||
                    $caras['diente'] == 12 ||
                    $caras['diente'] == 13 ||
                    $caras['diente'] == 14 ||
                    $caras['diente'] == 15 ||
                    $caras['diente'] == 16 ||
                    $caras['diente'] == 17 ||
                    $caras['diente'] == 18 ||
                    $caras['diente'] == 21 ||
                    $caras['diente'] == 22 ||
                    $caras['diente'] == 23 ||
                    $caras['diente'] == 24 ||
                    $caras['diente'] == 25 ||
                    $caras['diente'] == 26 ||
                    $caras['diente'] == 27 ||
                    $caras['diente'] == 28 ||
                    $caras['diente'] == 51 ||
                    $caras['diente'] == 52 ||
                    $caras['diente'] == 53 ||
                    $caras['diente'] == 54 ||
                    $caras['diente'] == 61 ||
                    $caras['diente'] == 62 ||
                    $caras['diente'] == 63 ||
                    $caras['diente'] == 64 ||
                    $caras['diente'] == 65
                ) {
                    $pdf->SetTextColor(255, 165, 0); // amarillo
                    $pdf->SetFont('Arial', '', 23);
                    $pdf->Text($x, $y + 1, '+');
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                }
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA DESADAPTADA':
                if (
                    $caras['diente'] == 11 ||
                    $caras['diente'] == 12 ||
                    $caras['diente'] == 13 ||
                    $caras['diente'] == 14 ||
                    $caras['diente'] == 15 ||
                    $caras['diente'] == 16 ||
                    $caras['diente'] == 17 ||
                    $caras['diente'] == 18 ||
                    $caras['diente'] == 21 ||
                    $caras['diente'] == 22 ||
                    $caras['diente'] == 23 ||
                    $caras['diente'] == 24 ||
                    $caras['diente'] == 25 ||
                    $caras['diente'] == 26 ||
                    $caras['diente'] == 27 ||
                    $caras['diente'] == 28 ||
                    $caras['diente'] == 51 ||
                    $caras['diente'] == 52 ||
                    $caras['diente'] == 53 ||
                    $caras['diente'] == 54 ||
                    $caras['diente'] == 61 ||
                    $caras['diente'] == 62 ||
                    $caras['diente'] == 63 ||
                    $caras['diente'] == 64 ||
                    $caras['diente'] == 65
                ) {
                    $pdf->SetTextColor(255, 165, 0); // amarillo
                    $pdf->SetFont('Arial', '', 23);
                    $pdf->Text($x, $y + 1, '+');
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                }
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'ABRASION DE LOS DIENTES':
                if (
                    $caras['diente'] == 11 ||
                    $caras['diente'] == 12 ||
                    $caras['diente'] == 13 ||
                    $caras['diente'] == 14 ||
                    $caras['diente'] == 15 ||
                    $caras['diente'] == 16 ||
                    $caras['diente'] == 17 ||
                    $caras['diente'] == 18 ||
                    $caras['diente'] == 21 ||
                    $caras['diente'] == 22 ||
                    $caras['diente'] == 23 ||
                    $caras['diente'] == 24 ||
                    $caras['diente'] == 25 ||
                    $caras['diente'] == 26 ||
                    $caras['diente'] == 27 ||
                    $caras['diente'] == 28 ||
                    $caras['diente'] == 51 ||
                    $caras['diente'] == 52 ||
                    $caras['diente'] == 53 ||
                    $caras['diente'] == 54 ||
                    $caras['diente'] == 61 ||
                    $caras['diente'] == 62 ||
                    $caras['diente'] == 63 ||
                    $caras['diente'] == 64 ||
                    $caras['diente'] == 65
                ) {
                    $pdf->SetTextColor(255, 0, 0); // rojo
                    $pdf->SetFont('Arial', '', 15);
                    $pdf->TextWithDirection($x + 1, $y - 6, '(', 'D'); // 180 grados para dibujar una paréntesis boca abajo
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                }
                $pdf->SetTextColor(255, 0, 0); // rojo
                $pdf->SetFont('Arial', '', 15);
                $pdf->TextWithDirection($x + 4, $y + 10, '(', 'U'); // 180 grados para dibujar una paréntesis boca abajo
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'EROSION DE LOS DIENTES':
                if (
                    $caras['diente'] == 11 ||
                    $caras['diente'] == 12 ||
                    $caras['diente'] == 13 ||
                    $caras['diente'] == 14 ||
                    $caras['diente'] == 15 ||
                    $caras['diente'] == 16 ||
                    $caras['diente'] == 17 ||
                    $caras['diente'] == 18 ||
                    $caras['diente'] == 21 ||
                    $caras['diente'] == 22 ||
                    $caras['diente'] == 23 ||
                    $caras['diente'] == 24 ||
                    $caras['diente'] == 25 ||
                    $caras['diente'] == 26 ||
                    $caras['diente'] == 27 ||
                    $caras['diente'] == 28 ||
                    $caras['diente'] == 51 ||
                    $caras['diente'] == 52 ||
                    $caras['diente'] == 53 ||
                    $caras['diente'] == 54 ||
                    $caras['diente'] == 61 ||
                    $caras['diente'] == 62 ||
                    $caras['diente'] == 63 ||
                    $caras['diente'] == 64 ||
                    $caras['diente'] == 65
                ) {
                    $pdf->SetTextColor(255, 0, 0); // rojo
                    $pdf->SetFont('Arial', '', 15);
                    $pdf->TextWithDirection($x + 1, $y - 6, '(', 'D'); // 180 grados para dibujar una paréntesis boca abajo
                    $pdf->SetFont('Arial', '', 9);
                    $pdf->SetTextColor(0, 0, 0);
                    break;
                }
                $pdf->SetTextColor(255, 0, 0); // rojo
                $pdf->SetFont('Arial', '', 15);
                $pdf->TextWithDirection($x + 4, $y + 10, '(', 'U'); // 180 grados para dibujar una paréntesis boca abajo
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;

            default:
                $pdf->SetTextColor(0, 0, 0);
                // DIENTE PRESENTE (sin color específico)
                break;
        }

        //adentro
        switch ($caras['palatino']) {
            case 'CARIES DE LA DENTINA':
                $pdf->SetTextColor(255, 0, 0); // rojo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA':
                $pdf->SetTextColor(0, 0, 255); // azul
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN RESINA DESADAPTADA':
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            case 'OBTURACION EN AMALGAMA DESADAPTADA':
                $pdf->SetTextColor(255, 165, 0); // amarillo
                $pdf->SetFont('Arial', '', 23);
                $pdf->Text($x, $y + 9, '+');
                $pdf->SetFont('Arial', '', 9);
                $pdf->SetTextColor(0, 0, 0);
                break;
            default:
                $pdf->SetTextColor(0, 0, 0);
                // DIENTE PRESENTE (sin color específico)
                break;
        }
    }

    // Función para dibujar texto rotado
    function TextWithDirection($x, $y, $txt, $direction = 'R')
    {
        if ($direction == 'R')
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 1, 0, 0, 1, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        elseif ($direction == 'L')
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', -1, 0, 0, -1, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        elseif ($direction == 'U')
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, 1, -1, 0, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        elseif ($direction == 'D')
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, -1, 1, 0, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        else
            $s = sprintf('BT %.2F %.2F Td (%s) Tj ET', $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        if ($this->ColorFlag)
            $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
        $this->_out($s);
    }

    private function drawTriangle($pdf, $x, $y, $width, $height)
    {
        // Dibujar un triángulo
        $points = [
            $x,
            $y + 7, // Punto superior
            $x - $width / 2,
            $y + $height, // Punto inferior izquierdo
            $x + $width / 2,
            $y + $height // Punto inferior derecho
        ];
        $pdf->Polygon($points);
    }

    private function drawTriangleNomral($pdf, $x, $y, $width, $height)
    {
        // Dibujar un triángulo
        $points = [
            $x,
            $y, // Punto superior
            $x - $width / 2,
            $y + $height, // Punto inferior izquierdo
            $x + $width / 2,
            $y + $height // Punto inferior derecho
        ];
        $pdf->Polygon($points);
    }

    function Polygon($points, $style = 'F')
    {
        // Draw a polygon
        $n = count($points) / 2;
        $op = 'h';
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'b';
        $this->_out(sprintf('%.2F %.2F m', $points[0] * $this->k, ($this->h - $points[1]) * $this->k));
        for ($i = 2; $i < $n * 2; $i += 2)
            $this->_out(sprintf('%.2F %.2F l', $points[$i] * $this->k, ($this->h - $points[$i + 1]) * $this->k));
        $this->_out($op);
    }


    function Ellipse($x, $y, $rx, $ry, $style = 'D')
    {
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $lx = 4 / 3 * (M_SQRT2 - 1) * $rx;
        $ly = 4 / 3 * (M_SQRT2 - 1) * $ry;
        $k = $this->k;
        $h = $this->h;
        $this->_out(sprintf(
            '%.2F %.2F m %.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x + $rx) * $k,
            ($h - $y) * $k,
            ($x + $rx) * $k,
            ($h - ($y - $ly)) * $k,
            ($x + $lx) * $k,
            ($h - ($y - $ry)) * $k,
            $x * $k,
            ($h - ($y - $ry)) * $k
        ));
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x - $lx) * $k,
            ($h - ($y - $ry)) * $k,
            ($x - $rx) * $k,
            ($h - ($y - $ly)) * $k,
            ($x - $rx) * $k,
            ($h - $y) * $k
        ));
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c',
            ($x - $rx) * $k,
            ($h - ($y + $ly)) * $k,
            ($x - $lx) * $k,
            ($h - ($y + $ry)) * $k,
            $x * $k,
            ($h - ($y + $ry)) * $k
        ));
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c %s',
            ($x + $lx) * $k,
            ($h - ($y + $ry)) * $k,
            ($x + $rx) * $k,
            ($h - ($y + $ly)) * $k,
            ($x + $rx) * $k,
            ($h - $y) * $k,
            $op
        ));
    }


    public function Header()
    {
        if ($this->page == 1) {
            $Y = 40;

            //if (isset(self::$consulta["afiliado"]["entidad_id"]) && self::$consulta["afiliado"]["entidad_id"] == 3) {
            $this->SetFont('Arial', 'B', 9);
            $logo = public_path() . "/images/logoEcoimagen.png";
            $this->Image($logo, 16, 9, 40, 25);
            $this->SetFont('Arial', '', 7);
            $this->SetXY(8, 37);
            $this->Cell(60, 3, utf8_decode('SUMIMEDICAL S.A.S'), 0, 0, 'C');
            $this->SetXY(8, $Y);
            $this->Cell(60, 3, utf8_decode('NIT: 900033371 Res: 004 '), 0, 0, 'C');
            $this->SetXY(8, $Y + 3);
            $this->Cell(60, 3, utf8_decode('Carrera 80 c Nùmero 32EE-65'), 0, 0, 'C');
            $this->SetXY(8, $Y + 6);
            $this->Cell(60, 3, utf8_decode('Telefono: 5201040'), 0, 0, 'C');
            //}

            // if (isset(self::$consulta["afiliado"]["entidad_id"]) && self::$consulta["afiliado"]["entidad_id"] == 1) {
            //     $this->SetFont('Arial', 'B', 9);
            //     $logo = public_path() . "/images/logoFomag.png";
            //     $this->Image($logo, 16, 9, 40, 25);
            //     $this->SetFont('Arial', '', 7);
            //     $this->SetXY(8, 37);
            //     $this->Cell(60, 3, utf8_decode('SUMIMEDICAL S.A.S'), 0, 0, 'C');
            //     $this->SetXY(8, $Y);
            //     $this->Cell(60, 3, utf8_decode('NIT: 900033371 Res: 004'), 0, 0, 'C');
            //     $this->SetXY(8, $Y + 3);
            //     $this->Cell(60, 3, utf8_decode('Carrera 80 c Nùmero 32EE-65'), 0, 0, 'C');
            //     $this->SetXY(8, $Y + 6);
            //     $this->Cell(60, 3, utf8_decode('Telefono: 5201040'), 0, 0, 'C');
            // }

            if (isset(self::$consulta["cita"]["tipo_historia_id"])) {
                $this->SetXY(33, 22);
                $this->SetFont('Arial', 'B', 25);
                switch (self::$consulta["cita"]["tipo_historia_id"]) {
                    case 1:
                        $this->Cell(192, 4, utf8_decode('HISTORIA CLÍNICA INTEGRAL'), 0, 0, 'C');
                        break;
                    case 3:
                        $this->Cell(192, 4, utf8_decode('HISTORIA CLÍNICA ONCOLOGIA'), 0, 0, 'C');
                        break;
                    case 4:
                        $this->Cell(192, 4, utf8_decode('PROCEDIMIENTOS MENORES'), 0, 0, 'C');
                        break;
                    case 5:
                        $this->Cell(192, 4, utf8_decode('HISTORIA CLINICA ADOLESCENCIA'), 0, 0, 'C');
                        break;
                    case 6:
                        $this->MultiCell(130, 4, utf8_decode('HISTORIA CLÍNICA PRIMERA'), 0, 'C');
                        $this->SetXY(62, 22);
                        $this->MultiCell(130, 4, utf8_decode('INFANCIA'), 0, 'C');
                        break;
                    case 10:
                        $this->Cell(192, 4, utf8_decode('HISTORIA CLINICA VEJEZ'), 0, 0, 'C');
                        break;
                    case 11:
                        $this->Cell(192, 4, utf8_decode('HISTORIA CLINICA OFTAMOLOGIA'), 0, 0, 'C');
                        break;
                    case 12:
                        $this->Cell(192, 4, utf8_decode('RIESGO CARDIOVASCULAR'), 0, 0, 'C');
                        break;
                    case 13:
                        $this->SetFont('Arial', 'B', 13);
                        $this->Cell(192, 4, utf8_decode('HISTORIA CLINICA GRUPALES RIESGO CARDIOVASCULAR'), 0, 0, 'C');
                        break;
                    case 14:
                        $this->SetXY(85, 13);
                        $this->Cell(130, 4, utf8_decode('HISTORIA CLÍNICA'), 0, 'C');
                        $this->SetXY(60, 22);
                        $this->Cell(130, 4, utf8_decode('ORIENTACION FARMACEUTICA'), 0, 'C');
                        break;
                    case 15:
                        $this->Cell(192, 4, utf8_decode('HISTORIA CLINICA INTEGRAL'), 0, 0, 'C');
                        break;
                    case 16:
                        $this->SetFont('Arial', 'B', 22);
                        $this->Cell(192, 4, utf8_decode('HISTORIA CLÍNICA ODONTOLOGICA'), 0, 0, 'C');
                        break;
                    case 17:
                        $this->SetXY(85, 13);
                        $this->Cell(130, 4, utf8_decode('HISTORIA CLÍNICA'), 0, 'C');
                        $this->SetXY(60, 22);
                        $this->Cell(130, 4, utf8_decode('PRIORITARIA ODONTOLÓGICA'), 0, 'C');
                        break;
                    case 18:
                        $this->SetXY(85, 13);
                        $this->Cell(130, 4, utf8_decode('HISTORIA CLÍNICA'), 0, 'C');
                        $this->SetXY(60, 22);
                        $this->Cell(130, 4, utf8_decode('CONTROL DE ODONTOLOGÍA'), 0, 'C');
                        break;
                }
            }

            $this->SetFont('Arial', 'B', 9);
            $this->SetXY(65, 30);
            $this->Cell(40, 4, utf8_decode('PUNTO DE ATENCIÓN:'), 0, 0, 'l');
            $this->SetFont('Arial', '', 8);
            if (isset(self::$consulta["cita_no_programada"]) && self::$consulta["cita_no_programada"] == 'Cita no programada') {
                $dato = utf8_decode(self::$consulta["rep"]["nombre"]);
            } else {
                $dato = isset(self::$consulta["agenda"]["consultorio"]["rep"]["nombre"]) ? utf8_decode(self::$consulta["agenda"]["consultorio"]["rep"]["nombre"]) : '';
            }
            $this->MultiCell(90, 4, $dato, 0, 'L');

            $this->SetXY(65, 34);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(40, 4, utf8_decode('CONSULTA REALIZADA:'), 0, 0, 'l');
            $this->SetFont('Arial', '', 8);
            if (isset(self::$consulta["cita_no_programada"]) && self::$consulta["cita_no_programada"] == 1) {
                $especialidad = utf8_decode(self::$consulta["cita"]["nombre"]);
            } else {
                $especialidad = isset(self::$consulta["agenda"]["cita"]["nombre"]) ? utf8_decode(self::$consulta["agenda"]["cita"]["nombre"]) : '';
            }
            $this->MultiCell(90, 4, $especialidad, 0, 'L');

            $this->SetXY(65, 38);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(40, 4, utf8_decode('FECHA DE CONSULTA:'), 0, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->MultiCell(46, 4, isset(self::$consulta["fecha_hora_inicio"]) ? utf8_decode(self::$consulta["fecha_hora_inicio"]) : '', 0, 'L');

            $this->detallesUsuario();
        }
    }

    private function calcularEdad($fechaNacimiento, $fechaConsulta)
    {
        $fechaNacimiento = new DateTime($fechaNacimiento);
        $fechaConsulta = new DateTime($fechaConsulta);
        $edad = $fechaConsulta->diff($fechaNacimiento)->y;
        return $edad;
    }


    private function detallesUsuario()
    {
        $this->SetXY(12, 53);
        $this->SetFont('Arial', 'B', 9);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFillColor(214, 214, 214);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(186, 4, utf8_decode('DATOS DEL USUARIO'), 1, 0, 'C', 1);
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0, 0, 0);
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('NOMBRE COMPLETO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 6);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["afiliado"]["nombre_completo"]), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('TIPO DE IDENTIFICACIÓN'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["afiliado"]["tipoDocumento"]["nombre"]), 1, 0, 'l');
        $this->Ln();

        $edad = $this->calcularEdad(self::$consulta["afiliado"]["fecha_nacimiento"], self::$consulta["fecha_hora_inicio"]);

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('FECHA DE NACIMIENTO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["afiliado"]["fecha_nacimiento"]), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('IDENTIFICACIÓN'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["afiliado"]["numero_documento"]), 1, 0, 'l');
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('EDAD'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode($edad . ' Años'), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('SEXO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["afiliado"]["sexo"] === 'M' ? 'Masculino' : 'Femenino'), 1, 0, 'l');
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('OCUPACIÓN'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["afiliado"]["ocupacion"] ? self::$consulta["afiliado"]["ocupacion"] : 'No Refiere'), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('DIRECCIÓN'), 1, 0, 'l');
        $this->SetFont('Arial', '', 6);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["afiliado"]["direccion_residencia_cargue"]), 1, 0, 'l');
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('TELÉFONO DEL DOMICILIO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["afiliado"]["telefono"] . "-" . self::$consulta["afiliado"]["celular1"]), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('LUGAR DE RESIDENCIA'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["afiliado"]["municipio_afiliacion"]["nombre"]), 1, 0, 'l');

        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('NOMBRE DEL ACOMPAÑANTE'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode("No Reporta"), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('TELÉFONO DEL ACOMPAÑANTE'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode("No Reporta"), 1, 0, 'l');
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('NOMBRE DEL RESPONSABLE'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode("No Reporta"), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('TELÉFONO DEL RESPONSABLE'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode("No Reporta"), 1, 0, 'l');
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('PARENTESCO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["afiliado"]["parentesco"]), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('ASEGURADORA'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["afiliado"]["entidad"]["nombre"]), 1, 0, 'l');
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('TIPO DE VINCULACIÓN'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["afiliado"]["tipo_afiliado"]["nombre"]), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('N° ATENCIÓN'), 1, 0, 'l');
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["id"]), 1, 0, 'l');
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('ESTADO CIVIL'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["afiliado"]["estado_civil"] == null ? 'No Reporta' : self::$consulta["afiliado"]["estado_civil"]), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('ETNIA'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["afiliado"]["etnia"] == null ? 'No Reporta' : self::$consulta["afiliado"]["etnia"]), 1, 0, 'l');
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('NIVEL EDUCATIVO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["afiliado"]["nivel_educativo"] == null ? 'No Reporta' : self::$consulta["afiliado"]["nivel_educativo"]), 1, 0, 'l');
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 4, utf8_decode('DISCAPACIDAD'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 4, utf8_decode(self::$consulta["afiliado"]["discapacidad"]), 1, 0, 'l');
        $this->Ln();

        $y = $this->GetY();
    }

    private function body($pdf)
    {
        $y = $pdf->GetY();

        /////////////////////////////////// HISTORIA ///////////////////////////////////
        if (
            isset(self::$consulta["cita"]["tipo_historia_id"]) &&
            !in_array(self::$consulta["cita"]["tipo_historia_id"], [4, 18])
        ) {
            $pdf->SetXY(12, $y + 8);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('ANAMNESIS'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('MOTIVO DE CONSULTA'), 1, 0, 'C', 1);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->Ln();


            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $motivoConsulta = 'No Refiere';
            if (isset(self::$consulta["HistoriaClinica"])) {
                $motivoConsulta = self::$consulta["HistoriaClinica"]["motivo_consulta"] ?? 'No Refiere';
            }
            $pdf->MultiCell(186, 4, utf8_decode($motivoConsulta), 1, "L", 0);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('ENFERMEDAD ACTUAL'), 1, 0, 'C', 1);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $enfermedadActual = 'No especificado';
            if (isset(self::$consulta["HistoriaClinica"])) {
                $enfermedadActual = self::$consulta["HistoriaClinica"]["enfermedad_actual"] ?? 'No especificado';
            }
            $pdf->MultiCell(186, 4, utf8_decode($enfermedadActual), 1, "L", 0);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('RESULTADOS AYUDAS DIAGNOSTICAS'), 1, 0, 'C', 1);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $resultadoAyudaDiagnostica = 'No Refiere';
            if (isset(self::$consulta["HistoriaClinica"])) {
                $resultadoAyudaDiagnostica = self::$consulta["HistoriaClinica"]["resultado_ayuda_diagnostica"] ?? 'No Refiere';
            }
            $pdf->MultiCell(186, 4, utf8_decode($resultadoAyudaDiagnostica), 1, "L", 0);
            $pdf->Ln();
        }


        if (isset(self::$consulta["cita"]["tipo_historia_id"]) && self::$consulta["cita"]["tipo_historia_id"] == 3) {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(186, 4, utf8_decode('TRATAMIENTO ONCOLÓGICO'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $tratamientoOncologico = 'No especificado';
            if (isset(self::$consulta["HistoriaClinica"])) {
                $tratamientoOncologico = self::$consulta["HistoriaClinica"]["tratamiento_oncologico"] ?? 'No especificado';
            }
            $pdf->MultiCell(186, 4, utf8_decode($tratamientoOncologico), 1, "L", 0);
            $pdf->Ln();


            if (isset(self::$consulta["HistoriaClinica"]["recibio_radioterapia"]) && self::$consulta["HistoriaClinica"]["recibio_radioterapia"] == 1) {
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode('RADIOTERAPIA'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(62, 4, utf8_decode('NUMERO SESIONES'), 1, 0, 'C', 1);
                $pdf->Cell(62, 4, utf8_decode('FECHA INICIO'), 1, 0, 'C', 1);
                $pdf->Cell(62, 4, utf8_decode('FECHA FINAL'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["numero_sesiones"]) ? self::$consulta["HistoriaClinica"]["numero_sesiones"] : ''), 1, 0, 'C');
                $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["inicio_radioterapia"]) ? self::$consulta["HistoriaClinica"]["inicio_radioterapia"] : ''), 1, 0, 'C');
                $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["fin_radioterapia"]) ? self::$consulta["HistoriaClinica"]["fin_radioterapia"] : ''), 1, 0, 'C');
                $pdf->Ln();
                $pdf->Ln();
            }

            if (isset(self::$consulta["HistoriaClinica"]["cirujia_oncologica"]) && self::$consulta["HistoriaClinica"]["cirujia_oncologica"] == 1) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(186, 4, utf8_decode('CIRUGIA ONCOLOGICA'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode('CIRUGIAS'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(62, 4, utf8_decode('NUMERO CIRUGIAS'), 1, 0, 'C', 1);
                $pdf->Cell(62, 4, utf8_decode('FECHA INICIO'), 1, 0, 'C', 1);
                $pdf->Cell(62, 4, utf8_decode('FECHA FINAL'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["numero_cirugias"]) ? self::$consulta["HistoriaClinica"]["numero_cirugias"] : ''), 1, 0, 'C');
                $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["inicio_cirujia"]) ? self::$consulta["HistoriaClinica"]["inicio_cirujia"] : ''), 1, 0, 'C');
                $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["fin_cirujia"]) ? self::$consulta["HistoriaClinica"]["fin_cirujia"] : ''), 1, 0, 'C');
                $pdf->Ln();
            }
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(186, 4, utf8_decode('INTENCION TRATAMIENTO ONCOLOGICO'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["intencion"]) ? self::$consulta["HistoriaClinica"]["intencion"] : ''), 1, "C", 0);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(186, 4, utf8_decode('DESCRIPCIÓN PATOLOGÍA ACTUAL'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode(isset(self::$consulta["patologias"]["patologia_cancer_actual"]) ? self::$consulta["patologias"]["patologia_cancer_actual"] : ''), 1, "L", 0);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(93, 4, utf8_decode('FECHA INGRESO LABORATORIO PATOLOGIA'), 1, 0, 'C', 1);
            $pdf->Cell(93, 4, utf8_decode('FECHA REPORTE LABORATORIO PATOLOGIA'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(93, 4, utf8_decode(isset(self::$consulta["patologias"]["fdx_cancer_actual"]) ? self::$consulta["patologias"]["fdx_cancer_actual"] : ''), 1, 0, 'C', 0);
            $pdf->Cell(93, 4, utf8_decode(isset(self::$consulta["patologias"]["flaboratorio_patologia"]) ? self::$consulta["patologias"]["flaboratorio_patologia"] : ''), 1, 0, 'C', 0);
            $pdf->Ln();
            $pdf->Ln();

            if (isset(self::$consulta["patologias"]["localizacion_cancer"])) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(186, 4, utf8_decode('TIPO TUMOR'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(42, 4, utf8_decode('LOCALIZACIÓN CANCER:'), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(144, 4, utf8_decode(self::$consulta["patologias"]["localizacion_cancer"]), 0, "L", 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(14, 4, utf8_decode('DUKES:'), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(172, 4, utf8_decode(self::$consulta["patologias"]["Dukes"]), 0, "L", 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(18, 4, utf8_decode('GLEASON:'), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(168, 4, utf8_decode(self::$consulta["patologias"]["gleason"]), 0, "L", 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(12, 4, utf8_decode('HER2:'), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(174, 4, utf8_decode(self::$consulta["patologias"]["Her2"]), 0, "L", 0);

                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(186, 4, utf8_decode('ESTADISTICA TUMOR'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, utf8_decode(isset(self::$consulta["patologias"]["estadificacion_inicial"]) ? self::$consulta["patologias"]["estadificacion_inicial"] : ''), 1, "L", 0);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(33, 4, utf8_decode('F.ESTADIFICACIÓN:'), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(153, 4, utf8_decode(isset(self::$consulta["patologias"]["gleason"]) ? self::$consulta["patologias"]["gleason"] : ''), 0, "L", 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(46, 4, utf8_decode('F. REPORTE LABORATORIO:'), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(140, 4, utf8_decode(isset(self::$consulta["patologias"]["gleason"]) ? self::$consulta["patologias"]["gleason"] : ''), 0, "L", 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(43, 4, utf8_decode('DIFERENCIACIÓN TUMOR:'), 0, 0, 'L', 0);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(143, 4, utf8_decode(isset(self::$consulta["patologias"]["gleason"]) ? self::$consulta["patologias"]["gleason"] : ''), 0, "L", 0);
            }
        }

        if (isset(self::$consulta["cita"]["tipo_historia_id"]) && self::$consulta["cita"]["tipo_historia_id"] == 4) {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('PROCEDIMIENTOS MENORES'), 1, 0, 'C', 1);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->Ln();
            $pdf->SetFont('Arial', '', 9);
            $pdf->SetX(12);
            $pdf->MultiCell(186, 4, utf8_decode(self::$consulta["HistoriaClinica"]['procedimiento_menor']), 1, 'r');
            $pdf->Ln();
        }

        if (
            isset(self::$consulta["cita"]["tipo_historia_id"]) &&
            (self::$consulta["cita"]["tipo_historia_id"] == 1 ||
                self::$consulta["cita"]["tipo_historia_id"] == 5 ||
                self::$consulta["cita"]["tipo_historia_id"] == 6 ||
                self::$consulta["cita"]["tipo_historia_id"] == 10 ||
                self::$consulta["cita"]["tipo_historia_id"] == 11 ||
                self::$consulta["cita"]["tipo_historia_id"] == 13 ||
                self::$consulta["cita"]["tipo_historia_id"] == 14)
        ) {
            if (isset(self::$consulta["cita"]["tipo_historia_id"]) && self::$consulta["cita"]["tipo_historia_id"] != 14) {
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFillColor(214, 214, 214);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetX(12);
                $pdf->Cell(186, 4, utf8_decode('REVISIÓN POR SISTEMAS'), 1, 0, 'C', 1);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->Ln();

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $oftalmologico = !empty(self::$consulta["HistoriaClinica"]["oftalmologico"]) ? self::$consulta["HistoriaClinica"]["oftalmologico"] : 'No Refiere';
                $pdf->MultiCell(186, 4, utf8_decode("Oftalmológico: ") . utf8_decode($oftalmologico), 1, "L", 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $genitourinario = !empty(self::$consulta["HistoriaClinica"]["genitourinario"]) ? self::$consulta["HistoriaClinica"]["genitourinario"] : 'No Refiere';
                $pdf->MultiCell(186, 4, "Genitourinario: " . utf8_decode($genitourinario), 1, "L", 0);

                if (self::$consulta["Sexo"] == 'F') {
                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(186, 4, "Flujo vaginal: " . utf8_decode(self::$consulta["tacto_vag"] == NULL ? 'No Refiere' : self::$consulta["tacto_vag"]), 1, "L", 0);
                }

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $hematopoyetico = !empty(self::$consulta["HistoriaClinica"]["linfatico"]) ? self::$consulta["HistoriaClinica"]["linfatico"] : 'No Refiere';
                $pdf->MultiCell(186, 4, utf8_decode("Hematopoyético: ") . utf8_decode($hematopoyetico), 1, "L", 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $osteomioarticular = !empty(self::$consulta["HistoriaClinica"]["osteomioarticular"]) ? self::$consulta["HistoriaClinica"]["osteomioarticular"] : 'No Refiere';
                $pdf->MultiCell(186, 4, "Osteomioarticular: " . utf8_decode($osteomioarticular), 1, "L", 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $sistema_nervioso = !empty(self::$consulta["HistoriaClinica"]["sistema_nervioso"]) ? self::$consulta["HistoriaClinica"]["sistema_nervioso"] : 'No Refiere';
                $pdf->MultiCell(186, 4, "Sistema Nervioso: " . utf8_decode($sistema_nervioso), 1, "L", 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $cardiovascular = !empty(self::$consulta["HistoriaClinica"]["cardiovascular"]) ? self::$consulta["HistoriaClinica"]["cardiovascular"] : 'No Refiere';
                $pdf->MultiCell(186, 4, "Cardiovascular: " . utf8_decode($cardiovascular), 1, "L", 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $tegumentario = !empty(self::$consulta["HistoriaClinica"]["tegumentario"]) ? self::$consulta["HistoriaClinica"]["tegumentario"] : 'No Refiere';
                $pdf->MultiCell(186, 4, "Tegumentario: " . utf8_decode($tegumentario), 1, "L", 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $respiratorio = !empty(self::$consulta["HistoriaClinica"]["respiratorio"]) ? self::$consulta["HistoriaClinica"]["respiratorio"] : 'No Refiere';
                $pdf->MultiCell(186, 4, "Respiratorio: " . utf8_decode($respiratorio), 1, "L", 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $endocrinologico = !empty(self::$consulta["HistoriaClinica"]["endocrinologico"]) ? self::$consulta["HistoriaClinica"]["endocrinologico"] : 'No Refiere';
                $pdf->MultiCell(186, 4, utf8_decode("Endocrinología: ") . utf8_decode($endocrinologico), 1, "L", 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $gastrointestinal = !empty(self::$consulta["HistoriaClinica"]["gastrointestinal"]) ? self::$consulta["HistoriaClinica"]["gastrointestinal"] : 'No Refiere';
                $pdf->MultiCell(186, 4, "Gastrointestinal: " . utf8_decode($gastrointestinal), 1, "L", 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $otros = !empty(self::$consulta["HistoriaClinica"]["no_refiere"]) ? self::$consulta["HistoriaClinica"]["no_refiere"] : 'No Refiere';
                $pdf->MultiCell(186, 4, "Otros: " . utf8_decode($otros), 1, "L", 0);
            }
            $pdf->Ln();

            //antecedentes personales

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES PERSONALES'), 1, 0, 'C', 1);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->Ln();
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $y = $pdf->GetY();

            if (!empty(self::$consulta['antecedentePersonales'])) {
                foreach (self::$consulta['antecedentePersonales'] as $antecedentes) {
                    $nombreCompletoMedico = utf8_decode(self::$consulta["medicoOrdena"]["operador"]["nombre"]) . " " . utf8_decode(self::$consulta["medicoOrdena"]["operador"]["apellido"]);
                    // Asignar "N/A" si $antecedentes->tipo está vacío
                    $tipoPatologia = !empty($antecedentes->tipo) ? utf8_decode($antecedentes->tipo) : "N/A";
                    $textoAntecedentes = "FECHA: " . utf8_decode(substr($antecedentes->fecha_diagnostico, 0, 10)) . ", MEDICO: " . utf8_decode($nombreCompletoMedico) .
                        ", PATOLOGIA: " . utf8_decode($antecedentes->patologias) . ", TIPO: " . $tipoPatologia;
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, $textoAntecedentes, 1, "L", 0);
                }
            }
            $pdf->Ln();
            #antecedentes familiares
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES FAMILIARES'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            if (count(self::$consulta["antecedentesFamiliares"]) > 0) {
                foreach (self::$consulta["antecedentesFamiliares"] as $familiares) {
                    $nombreCompletoMedico = utf8_decode(self::$consulta["medicoOrdena"]["operador"]["nombre"]) . " " . utf8_decode(self::$consulta["medicoOrdena"]["operador"]["apellido"]);
                    $textoAntecedentesFamiliares = "FECHA: " . utf8_decode((new DateTime($familiares->created_at))->format('Y-m-d')) . ", MÉDICO: " . utf8_decode($nombreCompletoMedico) .
                        ", PARENTESCO: " . utf8_decode($familiares->parentesco) .
                        $fallecio = ($familiares->fallecido == 1) ? 'Sí' : 'No';
                    ", FALLECIO: " . utf8_decode($fallecio);
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesFamiliares), 1, 'L');
                }
            } else {
                $textoAntecedentesFamiliares = utf8_decode('No Refiere');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesFamiliares), 1, 'L');
            }

            $pdf->Ln();

            if (isset(self::$consulta["cita"]["tipo_historia_id"]) && self::$consulta["cita"]["tipo_historia_id"] == 11) {

                // historia oftalmologica
                $posicionFamiliares = $pdf->GetY();
                $pdf->SetXY(12, $posicionFamiliares);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(186, 4, utf8_decode('AGUDEZA VISUAL'), 1, 0, 'C', 1);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(62, 4, utf8_decode(''), 1, 0, 'C');
                $pdf->Cell(62, 4, utf8_decode('OJO DERECHO'), 1, 0, 'C');
                $pdf->Cell(62, 4, utf8_decode('OJO IZQUIERDO'), 1, 0, 'C');
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->Cell(62, 4, utf8_decode('AVSC (CON CORRECCION)'), 1, 0, 'C');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(62, 4, utf8_decode(self::$consulta["historiaClinica"]['avcc_ojoderecho']), 1, 0, 'C');
                $pdf->Cell(62, 4, utf8_decode(self::$consulta["historiaClinica"]['avcc_ojoizquierdo']), 1, 0, 'C');
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(62, 4, utf8_decode('AVSC (SIN CORRECCION)'), 1, 0, 'C');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(62, 4, utf8_decode(self::$consulta["historiaClinica"]['avsc_ojoderecho']), 1, 0, 'C');
                $pdf->Cell(62, 4, utf8_decode(self::$consulta["historiaClinica"]['avsc_ojoizquierdo']), 1, 0, 'C');
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(62, 4, utf8_decode('PH (PINHOLE)'), 1, 0, 'C');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(62, 4, utf8_decode(self::$consulta["historiaClinica"]['ph_ojoderecho']), 1, 0, 'C');
                $pdf->Cell(62, 4, utf8_decode(self::$consulta["historiaClinica"]['ph_ojoizquierdo']), 1, 0, 'C');
                $pdf->Ln();
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->MultiCell(62, 8, utf8_decode('MOTILIDAD OCULAR'), 1, 'C');
                $pdf->SetXY(74, $posicionFamiliares + 24);
                $pdf->Cell(30, 4, utf8_decode('OJO DERECHO'), 1, 0, 'C');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(32, 4, utf8_decode(self::$consulta["historiaClinica"]['motilidad_ojoderecho']), 1, 0, 'C');
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(30, 4, utf8_decode('CONVERT TEST'), 1, 0, 'C');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(32, 4, utf8_decode(self::$consulta["historiaClinica"]['covert_ojoderecho']), 1, 0, 'C');
                $pdf->Ln();
                $pdf->SetX(74);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(30, 4, utf8_decode('OJO IZQUIERDO'), 1, 0, 'C');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(32, 4, utf8_decode(self::$consulta["historiaClinica"]['motilidad_ojoizquierdo']), 1, 0, 'C');
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(30, 4, utf8_decode('CONVERT TEST'), 1, 0, 'C');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(32, 4, utf8_decode(self::$consulta["historiaClinica"]['covert_ojoizquierdo']), 1, 0, 'C');
                $pdf->Ln();
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->MultiCell(62, 8, utf8_decode('BIOMICROSCOPIA'), 1, 'C');
                $pdf->SetXY(74, $posicionFamiliares + 36);
                $pdf->Cell(30, 4, utf8_decode('OJO DERECHO'), 1, 0, 'C');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(94, 4, utf8_decode(self::$consulta["historiaClinica"]['biomicros_ojoderecho']), 1, 0, 'C');
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Ln();
                $pdf->SetX(74);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(30, 4, utf8_decode('OJO IZQUIERDO'), 1, 0, 'C');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(94, 4, utf8_decode(self::$consulta["historiaClinica"]['biomicros_ojoizquierdo']), 1, 0, 'C');
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Ln();
                $pdf->Ln();

                $posicionFamiliares = $pdf->GetY();

                // $y = max($y1,$posicionFamiliares);
                $pdf->Ln();
                #cuadrado
                $pdf->Line(12, $y, 198, $y);


                if ($posicionFamiliares > 250) {
                    $pdf->AddPage();
                    $posicionFamiliares = 10;
                }

                $pdf->SetXY(12, $posicionFamiliares + 4);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->MultiCell(30, 8, 'PRESION INTRAOCULAR', 1, 'C');
                $pdf->SetXY(42, $posicionFamiliares + 4);
                $pdf->MultiCell(20, 4, 'OJO DERECHO', 1, 'C');
                $pdf->SetXY(42, $posicionFamiliares + 12);
                $pdf->MultiCell(20, 4, 'OJO IZQUIERDO', 1, 'C');
                $pdf->SetXY(62, $posicionFamiliares + 4);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(25, 8, utf8_decode(self::$consulta["historiaClinica"]['presionintra_ojoderecho']), 1, 'C');
                $pdf->SetXY(62, $posicionFamiliares + 12);
                $pdf->MultiCell(25, 8, utf8_decode(self::$consulta["historiaClinica"]['presionintra_ojoizquierdo']), 1, 'C');

                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetXY(100, $posicionFamiliares + 4);
                $pdf->MultiCell(30, 16, 'GINIOSCOPIA', 1, 'C');
                $pdf->SetXY(130, $posicionFamiliares + 4);
                $pdf->MultiCell(30, 8, 'OJO DERECHO', 1, 'C');
                $pdf->SetXY(130, $posicionFamiliares + 12);
                $pdf->MultiCell(30, 8, 'OJO IZQUIERDO', 1, 'C');
                $pdf->SetXY(160, $posicionFamiliares + 4);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(38, 8, utf8_decode(self::$consulta["historiaClinica"]['gionios_ojoderecho']), 1, 'C');
                $pdf->SetXY(160, $posicionFamiliares + 12);
                $pdf->MultiCell(38, 8, utf8_decode(self::$consulta["historiaClinica"]['gionios_ojoizquierdo']), 1, 'C');

                $posicionFamiliares = $pdf->GetY();

                if ($posicionFamiliares > 250) {
                    $pdf->AddPage();
                    $posicionFamiliares = 10;
                }

                $pdf->SetXY(12, $posicionFamiliares + 4);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->MultiCell(50, 8, 'FONDO DE OJO', 1, 'C');
                $pdf->SetXY(62, $posicionFamiliares + 4);
                $pdf->Cell(30, 4, utf8_decode('OJO DERECHO'), 1, 0, 'C');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(106, 4, utf8_decode(self::$consulta["historiaClinica"]['fondo_ojoderecho']), 1, 0, 'L');
                $pdf->SetXY(62, $posicionFamiliares + 8);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(30, 4, utf8_decode('OJO IZQUIERDO'), 1, 0, 'C');
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(106, 4, utf8_decode(self::$consulta["historiaClinica"]['fondo_ojoizquierdo']), 1, 0, 'L');
                $pdf->Ln();
            }

            #antecedentes transfusionales
            if (isset(self::$consulta["cita"]["tipo_historia_id"]) && self::$consulta["cita"]["tipo_historia_id"] != 14) {
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES TRANSFUSIONALES'), 1, 0, 'C', 1);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 8);
                if (count(self::$consulta["antecedenteTransfucionales"]) > 0) {
                    foreach (self::$consulta["antecedenteTransfucionales"] as $transfusionales) {

                        $textoAntecedentesTransfucionales = 'FECHA TRANSFUSIÓN: ' . utf8_decode($transfusionales->fecha_transfusion) . ", MÉDICO: " . utf8_decode(self::$consulta["medicoOrdena"]["operador"]["nombre_completo"]) . ", CAUSA: " . utf8_decode($transfusionales->causa) .
                            ", FECHA REGISTRO: " . utf8_decode((new DateTime($transfusionales->created_at))->format('Y-m-d'));
                        $pdf->SetX(12);
                        $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesTransfucionales), 1, 'L');
                    }
                } else {
                    $textoAntecedentesTransfucionales = 'FECHA TRANSFUSIÓN: ' . utf8_decode('No Aplica') . ", MÉDICO: " . utf8_decode('No Aplica') . ", CAUSA: " . utf8_decode('No Aplica') .
                        ", FECHA REGISTRO: " . utf8_decode('No Aplica');
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesTransfucionales), 1, 'L');
                }
                #antecedentes vacunales
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES VACUNALES'), 1, 0, 'C', 1);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 7);
                if (count(self::$consulta["vacunacion"]) > 0) {
                    foreach (self::$consulta["vacunacion"] as $vacunales) {
                        $nombreCompletoMedico = utf8_decode(self::$consulta["medicoOrdena"]["operador"]["nombre"]) . " " . utf8_decode(self::$consulta["medicoOrdena"]["operador"]["apellido"]);
                        $textoAntecedentesVacunales = 'FECHA DOSIS: ' . utf8_decode($vacunales->fecha_dosis) . ", MÉDICO: " . utf8_decode($nombreCompletoMedico) . ", VACUNA: " . utf8_decode($vacunales->vacuna) .
                            ", DOSIS: " . utf8_decode($vacunales->dosis) . ", LABORATORIO: " . utf8_decode($vacunales->laboratorio);
                        $pdf->SetX(12);
                        $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesVacunales), 1, 'L');
                    }
                } else {
                    $textoAntecedentesVacunales = 'FECHA DOSIS: ' . utf8_decode('No Aplica') . ", MÉDICO: " . utf8_decode('No Aplica') . ", VACUNA: " . utf8_decode('No Aplica') .
                        ", DOSIS: " . utf8_decode('No Aplica') . ", LABORATORIO: " . utf8_decode('No Aplica');
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesVacunales), 1, 'L');
                }
                $pdf->Ln();

                #ANTECEDENTES QUIRURJICOS
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFillColor(214, 214, 214);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES QUIRURGICOS'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 7);
                if (count(self::$consulta["antecedenteQuirurgicos"]) > 0) {
                    foreach (self::$consulta["antecedenteQuirurgicos"] as $quirurgicos) {
                        $nombreCompletoMedico = utf8_decode(self::$consulta["medicoOrdena"]["operador"]["nombre"]) . " " . utf8_decode(self::$consulta["medicoOrdena"]["operador"]["apellido"]);
                        $textoAntecedentesQuirurgicos = "CIRUGIA: " . utf8_decode($quirurgicos->cirugia) . ", EDAD: " . utf8_decode($quirurgicos->a_que_edad) . "años" .
                            ", MEDICO: " . utf8_decode($nombreCompletoMedico);
                        $pdf->SetX(12);
                        $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesQuirurgicos), 1, 'l',);
                    }
                } else {
                    $textoAntecedentesQuirurgicos = "CUAL: " . utf8_decode('No Refiere') . ", EDAD: " . utf8_decode('No Refiere') .
                        ", MEDICO: " . utf8_decode('No Refiere');
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesQuirurgicos), 1, 'l',);
                }
                $pdf->Ln();
            }

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 6, utf8_decode('ANTECEDENTES ALÉRGICOS A MEDICAMENTOS'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 7);

            $informacionDisponible = false; // Variable para rastrear si hay información disponible
            foreach (self::$consulta["antecedentesFarmacologicos"] as $farmacologicos) {
                if ($farmacologicos->medicamento) {
                    $nombreMedicamento = $farmacologicos->medicamento->codesumi->nombre;
                } else {
                    $nombreMedicamento = 'No Refiere';
                }
                if (!empty($farmacologicos->observacion_medicamento)) {
                    $observacion = utf8_decode($farmacologicos->observacion_medicamento);
                } else {
                    $observacion = 'N/A';
                }
                $textoAntecedentesFarmacologicos = "FECHA: " . utf8_decode($farmacologicos->created_at) .
                    ", MÉDICO: " . utf8_decode(self::$consulta["medicoOrdena"]["operador"]["nombre_completo"]) .
                    ", MEDICAMENTO: " . utf8_decode($nombreMedicamento) .
                    ", OBSERVACIÓN: " . $observacion;

                $pdf->SetX(12);
                $pdf->MultiCell(186, 6, utf8_decode($textoAntecedentesFarmacologicos), 1, 'L');

                $informacionDisponible = true;
            }
            if (!$informacionDisponible) {
                $textoAntecedentesFarmacologicos = "FECHA: " . utf8_decode('No Refiere') .
                    ", MÉDICO: " . utf8_decode('No Refiere') .
                    ", MEDICAMENTO: " . utf8_decode('No Refiere') .
                    ", OBSERVACIÓN: " . utf8_decode('No Refiere');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 6, utf8_decode($textoAntecedentesFarmacologicos), 1, 'L');
            }
            $pdf->Ln();

            //Alergicos Alimentarios
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 6, utf8_decode('ANTECEDENTES ALERGICOS ALIMENTARIOS'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 7);

            if (count(self::$consulta["antecedentesFarmacologicos"]) > 0) {
                foreach (self::$consulta["antecedentesFarmacologicos"] as $alimentarios) {
                    $nombreCompletoMedico = utf8_decode(self::$consulta["medicoOrdena"]["operador"]["nombre"]) . " " . utf8_decode(self::$consulta["medicoOrdena"]["operador"]["apellido"]);
                    $fecha = !empty($alimentarios->created_at) ? utf8_decode($alimentarios->created_at) : 'No Refiere';
                    $alimento = !empty($alimentarios->alimento) ? utf8_decode($alimentarios->alimento) : 'No Refiere';
                    $observacion_alimento = !empty($alimentarios->observacion_alimento) ? utf8_decode($alimentarios->observacion_alimento) : 'No Refiere';

                    $textoAntecedentesAlimentos = "FECHA: " . $fecha . ", MÉDICO: " . $nombreCompletoMedico .
                        ", ALIMENTO: " . $alimento . ", OBSERVACIÓN: " . $observacion_alimento;

                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 6, utf8_decode($textoAntecedentesAlimentos), 1, 'L');
                }
            } else {
                $textoAntecedentesAlimentos = "FECHA: No Refiere, MÉDICO: No Refiere, ALIMENTO: No Refiere, OBSERVACIÓN: No Refiere";
                $pdf->SetX(12);
                $pdf->MultiCell(186, 6, utf8_decode($textoAntecedentesAlimentos), 1, 'L');
            }
            $pdf->Ln();

            //antecedentes alergicos ambientales
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 6, utf8_decode('ANTECEDENTES ALERGICOS AMBIENTALES'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 7);

            if (count(self::$consulta["antecedentesFarmacologicos"]) > 0) {
                foreach (self::$consulta["antecedentesFarmacologicos"] as $ambientales) {
                    $nombreCompletoMedico = utf8_decode(self::$consulta["medicoOrdena"]["operador"]["nombre"]) . " " . utf8_decode(self::$consulta["medicoOrdena"]["operador"]["apellido"]);
                    $fecha = !empty($ambientales->created_at) ? utf8_decode($ambientales->created_at) : 'No Refiere';
                    $ambiental = !empty($ambientales->ambiental) ? utf8_decode($ambientales->ambiental) : 'No Refiere';
                    $observacion_ambiental = !empty($ambientales->observacion_ambiental) ? utf8_decode($ambientales->observacion_ambiental) : 'No Refiere';

                    $textoAntecedentesAlimentos = "FECHA: " . $fecha . ", MÉDICO: " . $nombreCompletoMedico .
                        ", AMBIENTAL: " . $ambiental . ", OBSERVACIÓN: " . $observacion_ambiental;

                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 6, utf8_decode($textoAntecedentesAlimentos), 1, 'L');
                }
            } else {
                $textoAntecedentesAmbientales = "FECHA: No Refiere, MÉDICO: No Refiere, AMBIENTAL: No Refiere, OBSERVACIÓN: No Refiere";
                $pdf->SetX(12);
                $pdf->MultiCell(186, 6, utf8_decode($textoAntecedentesAmbientales), 1, 'L');
            }
            $pdf->Ln();

            //antecedentes otras alergias
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 6, utf8_decode('ANTECEDENTES OTRAS ALERGIAS'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 7);

            if (count(self::$consulta["antecedentesFarmacologicos"]) > 0) {
                foreach (self::$consulta["antecedentesFarmacologicos"] as $alergias) {
                    $nombreCompletoMedico = utf8_decode(self::$consulta["medicoOrdena"]["operador"]["nombre"]) . " " . utf8_decode(self::$consulta["medicoOrdena"]["operador"]["apellido"]);
                    $fecha = !empty($alergias->created_at) ? utf8_decode($alergias->created_at) : 'No Refiere';
                    $otras = !empty($alergias->otras) ? utf8_decode($alergias->otras) : 'No Refiere';
                    $observacion_otro = !empty($alergias->observacion_otro) ? utf8_decode($alergias->observacion_otro) : 'No Refiere';

                    $textoAntecedentesAlimentos = "FECHA: " . $fecha . ", MÉDICO: " . $nombreCompletoMedico .
                        ", OTRAS ALERGIAS: " . $otras . ", OBSERVACIÓN: " . $observacion_otro;

                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 6, utf8_decode($textoAntecedentesAlimentos), 1, 'L');
                }
            } else {
                $textoAntecedentesAmbientales = "FECHA: No Refiere, MÉDICO: No Refiere, OTRAS ALERGIAS: No Refiere, OBSERVACIÓN: No Refiere";
                $pdf->SetX(12);
                $pdf->MultiCell(186, 6, utf8_decode($textoAntecedentesAmbientales), 1, 'L');
            }
            $pdf->Ln();

            #antecedentes hospitalarios
            if (isset(self::$consulta["cita"]["tipo_historia_id"]) && self::$consulta["cita"]["tipo_historia_id"] != 14) {
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFillColor(214, 214, 214);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES HOSPITALARIOS'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 7);

                $hospitalarios = self::$consulta->antecedenteHospitalarios;

                if ($hospitalarios) {
                    $nombreCompletoMedico = utf8_decode(self::$consulta->medicoOrdena->operador->nombre) . " " . utf8_decode(self::$consulta->medicoOrdena->operador->apellido);
                    $consulta_urgencias = !empty($hospitalarios->consulta_urgencias) ? utf8_decode($hospitalarios->consulta_urgencias) : 'No Refiere';
                    $descripcion_urgencias_mas_tres = !empty($hospitalarios->descripcion_urgencias_mas_tres) ? utf8_decode($hospitalarios->descripcion_urgencias_mas_tres) : 'No Refiere';
                    $descripcion_urgencias_mas_tres_semanas = !empty($hospitalarios->descripcion_urgencias_mas_tres_semanas) ? utf8_decode($hospitalarios->descripcion_urgencias_mas_tres_semanas) : 'No Refiere';
                    $hospitalizacion_ultimo_anio = !empty($hospitalarios->hospitalizacion_ultimo_anio) ? utf8_decode($hospitalarios->hospitalizacion_ultimo_anio) : 'No Refiere';
                    $hospitalizacion_uci_anio = !empty($hospitalarios->hospitalizacion_uci_anio) ? utf8_decode($hospitalarios->hospitalizacion_uci_anio) : 'No Refiere';
                    $descripcion_hospi_uci = !empty($hospitalarios->descripcion_hospi_uci) ? utf8_decode($hospitalarios->descripcion_hospi_uci) : 'No Refiere';

                    $textoAntecedentesAlimentos = "CONSULTAS A URGENCIAS: " . $consulta_urgencias .
                        ", MÁS DE 3 HOSPITALIZACIONES ÚLTIMO AÑO: " . $descripcion_urgencias_mas_tres .
                        ", HOSPITALIZACIONES MAYORES A 2 SEMANAS EL ÚLTIMO AÑO: " . $descripcion_urgencias_mas_tres_semanas .
                        ", HOSPITALIZACIONES ULTIMO AÑO: " . $hospitalizacion_ultimo_anio;
                    ", HOSPITALIZACIONES UCI ULTIMO AÑO: " . $hospitalizacion_uci_anio;
                    ", DESCRIPCION HOSPITALIZACION UCI: " . $descripcion_hospi_uci;

                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesAlimentos), 1, 'L');
                } else {
                    $textoAntecedentesAmbientales = "FECHA: No Refiere, MÉDICO: No Refiere, OTRAS ALERGIAS: No Refiere, OBSERVACIÓN: No Refiere";
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesAmbientales), 1, 'L');
                }
            }
            $pdf->Ln();


            //#antecedentes ginecostetricos
            if (self::$consulta["afiliado"]["sexo"] == 'F') {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFillColor(214, 214, 214);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES GINECO OBSTETRICOS'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 7);

                $textoAntecedentesGineco = isset(self::$consulta["HistoriaClinica"]["presente_menarquia"]) ? self::$consulta["HistoriaClinica"]["presente_menarquia"] : 'No Evaluado';
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesGineco), 1, 'l',);
                $pdf->Ln();

                //Ciclos menstruales
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetX(12);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFillColor(214, 214, 214);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(186, 4, utf8_decode('CICLOS MENSTRUALES'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 7);

                $textoAntecedentesCiclos = "CLASIFICACIÓN: " . (isset(self::$consulta["HistoriaClinica"]["clasificacion_ciclos"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["clasificacion_ciclos"]) : 'No Evaluado') .
                    ", FRECUENCIA: " . (isset(self::$consulta["HistoriaClinica"]["frecuencia_ciclos"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["frecuencia_ciclos"]) : 'No Evaluado') .
                    ", DURACIÓN: " . (isset(self::$consulta["HistoriaClinica"]["duracion_ciclos"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["duracion_ciclos"]) : 'No Evaluado') .
                    ", FECHA ÚLTIMA MENSTRUACIÓN: " . (isset(self::$consulta["HistoriaClinica"]["fecha_ultima_menstruacion"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["fecha_ultima_menstruacion"]) : 'No Evaluado') .
                    ", INFECCIONES DE TRANSMISIÓN SEXUAL: " . (isset(self::$consulta["HistoriaClinica"]["presente_transmisionsexual"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["presente_transmisionsexual"]) . " - " . utf8_decode(self::$consulta["HistoriaClinica"]["descripcion_transmision_sexual"]) : 'No Evaluado') .
                    ", EDAD PRIMERA RELACIÓN SEXUAL: " . (isset(self::$consulta["HistoriaClinica"]["edad_primera"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["edad_primera"]) . " años" : 'No Evaluado');

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesCiclos), 1, 'L');
                $pdf->Ln();

                //Metódo anticonceptivo
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(186, 4, utf8_decode('METODO ANTICOCEPTIVO'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 7);
                $textoAntecedentesMetodo = "PRESENTE: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["presente_metodo_anticonceptivo"]) ? self::$consulta["HistoriaClinica"]["presente_metodo_anticonceptivo"] : 'No Evaluado') .
                    ", DESCRIPCIÓN: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["descripcion_metodo_anticonceptivo"]) ? self::$consulta["HistoriaClinica"]["descripcion_metodo_anticonceptivo"] : 'No Evaluado') .
                    ", DESCRIPCIÓN: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["descripcion_metodo_anticonceptivo"]) ? self::$consulta["HistoriaClinica"]["descripcion_metodo_anticonceptivo"] : 'No Evaluado') .
                    ", TIPO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["tipo_metodo_anticonceptivo"]) ? self::$consulta["HistoriaClinica"]["tipo_metodo_anticonceptivo"] : 'No Evaluado') .
                    ", TRATAMIENTO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["tratamiento_metodo_anticonceptivo"]) ? self::$consulta["HistoriaClinica"]["tratamiento_metodo_anticonceptivo"] : 'No Evaluado') .
                    ", FECHA DIAGNOSTICO: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["fecha_metodo_anticonceptivo"]) ? self::$consulta["HistoriaClinica"]["fecha_metodo_anticonceptivo"] : 'No Evaluado');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesMetodo), 1, 'l',);
                $pdf->Ln();
                // Antecedentes de infertilidad
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES DE TRATAMIENTO INFERTILIDAD'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 7);

                if (
                    isset(self::$consulta["HistoriaClinica"]["presente_tratamiento_infertilidad"]) &&
                    isset(self::$consulta["HistoriaClinica"]["tratamiento_tratamiento_infertilidad"]) &&
                    isset(self::$consulta["HistoriaClinica"]["fecha_tratamiento_infertilidad"])
                ) {

                    $textoAntecedentesInfertil = "PRESENTE: " . utf8_decode(self::$consulta["HistoriaClinica"]["presente_tratamiento_infertilidad"]) .
                        ", TRATAMIENTO: " . utf8_decode(self::$consulta["HistoriaClinica"]["tratamiento_tratamiento_infertilidad"]) .
                        ", FECHA DIAGNÓSTICO: " . utf8_decode(self::$consulta["HistoriaClinica"]["fecha_tratamiento_infertilidad"]);
                } else {
                    $textoAntecedentesInfertil = "No Evaluado";
                }

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesInfertil), 1, 'l');
                $pdf->Ln();

                // Autocuidado de senos
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(186, 4, utf8_decode('¿PRACTICA EL AUTOEXAMEN DE SENOS?'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 7);

                if (
                    isset(self::$consulta["HistoriaClinica"]["presente_auto_examen_senos"]) &&
                    isset(self::$consulta["HistoriaClinica"]["frecuencia_auto_examen_senos"])
                ) {

                    $textoAntecedentesAuto = "PRESENTA: " . utf8_decode(self::$consulta["HistoriaClinica"]["presente_auto_examen_senos"]) .
                        ", FRECUENCIA: " . utf8_decode(self::$consulta["HistoriaClinica"]["frecuencia_auto_examen_senos"]);
                } else {
                    $textoAntecedentesAuto = "No Evaluado";
                }

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesAuto), 1, 'l');
                $pdf->Ln();

                // Citología cervicouterina
                $textoAntecedentesCervicouterino = "No Evaluado";

                if (self::$consulta->cupGinecologicos->isNotEmpty()) {
                    $detalles = [];
                    foreach (self::$consulta->cupGinecologicos as $cup) {
                        if (!empty($cup->estado_ginecologia) && !empty($cup->descripcion_citologia)) {
                            $detalles[] = "ESTADO: " . utf8_decode($cup->estado_ginecologia) .
                                ", DESCRIPCIÓN: " . utf8_decode($cup->descripcion_citologia);
                        }
                    }

                    if (!empty($detalles)) {
                        $textoAntecedentesCervicouterino = implode("\n", $detalles);
                    }
                }

                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(186, 4, utf8_decode('CITOLOGÍA CERVICOUTERINA'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 7);
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesCervicouterino), 1, 'L');
                $pdf->Ln();

                // Mamografía
                $textoAntecedentesMamografia = "No Evaluado";

                if (self::$consulta->cupMamografias->isNotEmpty()) {
                    $detalles = [];
                    foreach (self::$consulta->cupMamografias as $cup) {
                        if (!empty($cup->estado_mamografia) && !empty($cup->descripcion_mamografia)) {
                            $detalles[] = "ESTADO: " . utf8_decode($cup->estado_mamografia) .
                                ", DESCRIPCIÓN: " . utf8_decode($cup->descripcion_mamografia);
                        }
                    }

                    if (!empty($detalles)) {
                        $textoAntecedentesMamografia = implode("\n", $detalles);
                    }
                }

                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(186, 4, utf8_decode('MAMOGRAFÍA'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 7);
                $pdf->SetX(12);

                if (!empty($textoAntecedentesMamografia)) {
                    $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesMamografia), 1, 'L');
                } else {
                    $pdf->MultiCell(186, 4, utf8_decode("No Evaluado"), 1, 'L');
                }

                $pdf->Ln();

                // Procedimientos anteriores realizados en el cuello uterino
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(186, 4, utf8_decode('PROCEDIMIENTOS ANTERIORES EN EL CUELLO UTERINO'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 7);

                if (
                    isset(self::$consulta["HistoriaClinica"]["presente_procedimiento_cuello_uterino"]) &&
                    isset(self::$consulta["HistoriaClinica"]["tratamiento_procedimiento_cuello_uterino"]) &&
                    isset(self::$consulta["HistoriaClinica"]["fecha_procedimiento_cuello_uterino"])
                ) {

                    $textoAntecedentesCuelloUterino = "PRESENTE: " . utf8_decode(self::$consulta["HistoriaClinica"]["presente_procedimiento_cuello_uterino"]) .
                        ", TRATAMIENTO: " . utf8_decode(self::$consulta["HistoriaClinica"]["tratamiento_procedimiento_cuello_uterino"]) .
                        ", FECHA DIAGNÓSTICO: " . utf8_decode(self::$consulta["HistoriaClinica"]["fecha_procedimiento_cuello_uterino"]);
                } else {
                    $textoAntecedentesCuelloUterino = "No Evaluado";
                }

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesCuelloUterino), 1, 'l');
                $pdf->Ln();

                // Otro tipo de tratamiento
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(186, 4, utf8_decode('OTRO TIPO DE TRATAMIENTO'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 7);

                $textoAntecedentesOtrosTratamientos = "OTRO: " . (isset(self::$consulta["HistoriaClinica"]["tratamiento_otro_tipo_tratamiento"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["tratamiento_otro_tipo_tratamiento"]) : 'No Evaluado');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesOtrosTratamientos), 1, 'l');
                $pdf->Ln();

                // Planeación de embarazo y datos de embarazo
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(186, 4, utf8_decode('PLANEA EMBARAZO'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 7);

                $textoAntecedentesEmbarazo = "FECHA ÚLTIMO PARTO: " . (isset(self::$consulta["fecha_ultimoparto"]) ? utf8_decode(self::$consulta["fecha_ultimoparto"]) : 'No Evaluado') .
                    ", PLANEA EMBARAZO ANTES DE UN AÑO: " . (isset(self::$consulta["planea_embarazo"]) ? utf8_decode(self::$consulta["planea_embarazo"]) : 'No Evaluado') .
                    ", GESTA: " . (isset(self::$consulta["HistoriaClinica"]["gesta"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["gesta"]) : 'No Evaluado') .
                    ", PARTOS: " . (isset(self::$consulta["HistoriaClinica"]["parto"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["parto"]) : 'No Evaluado') .
                    ", ABORTO: " . (isset(self::$consulta["HistoriaClinica"]["aborto"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["aborto"]) : 'No Evaluado') .
                    ", VIVOS: " . (isset(self::$consulta["HistoriaClinica"]["vivos"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["vivos"]) : 'No Evaluado') .
                    ", CESÁREA: " . (isset(self::$consulta["HistoriaClinica"]["cesarea"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["cesarea"]) : 'No Evaluado') .
                    ", MORTINATO: " . (isset(self::$consulta["HistoriaClinica"]["mortinato"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["mortinato"]) : 'No Evaluado') .
                    ", ECTÓPICOS: " . (isset(self::$consulta["HistoriaClinica"]["ectopicos"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["ectopicos"]) : 'No Evaluado') .
                    ", MOLAS: " . (isset(self::$consulta["HistoriaClinica"]["molas"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["molas"]) : 'No Evaluado') .
                    ", GEMELOS: " . (isset(self::$consulta["HistoriaClinica"]["gemelos"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["gemelos"]) : 'No Evaluado');

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesEmbarazo), 1, 'l');
                $pdf->Ln();

                // FALTA LA TABLA DE ANTECEDENTES GINECOLOGICOS

                //     if (self::$citapaciente["checkbox_gestante"] == true) {
                //         $pdf->Ln();
                //         $pdf->SetTextColor(0,0,0);
                //         $pdf->SetDrawColor(0,0,0);
                //         $pdf->SetX(12);
                //         $pdf->SetFont('Arial', 'B', 8);
                //         $pdf->Cell(186, 4, utf8_decode('GESTANTES'), 1, 0, 'C',1);
                //         $pdf->Ln();
                //         $pdf->SetTextColor(0,0,0);
                //         $pdf->SetDrawColor(0,0,0);
                //         $pdf->SetFont('Arial', '', 7);

                //         $textoAntecedentesGestante = "FECHA ÚLTIMA MENSTRUACIÓN: ". utf8_decode(self::$citapaciente["fecha_ultimaMenstruacion"] == null?'No Evaluado':self::$citapaciente["fecha_ultimaMenstruacion"]) .
                //         ", EDAD GESTACIONAL POR FUM: ". utf8_decode(self::$citapaciente["gestacionalfum"] == null?'No Evaluado':self::$citapaciente["gestacionalfum"]) .
                //         ", FECHA PROBABLE DE PARTO: ". utf8_decode(self::$citapaciente["fecha_probable"] == null?'No Evaluado':self::$citapaciente["fecha_probable"]) .
                //         ", EMBARAZO DESEADO: ". utf8_decode(self::$citapaciente["embarazodeseado"] == null?'No Evaluado':self::$citapaciente["embarazodeseado"]).
                //         ", EMBARAZO PLANEADO: ". utf8_decode(self::$citapaciente["embarazoplaneado"] == null?'No Evaluado':self::$citapaciente["embarazoplaneado"]).
                //         ", EMBARAZO ACEPTADO: ". utf8_decode(self::$citapaciente["embarazoaceptado"] == null?'No Evaluado':self::$citapaciente["embarazoaceptado"]).
                //         ", FECHA ECOGRAFÍA 1ER TRIMESTRE: ". utf8_decode(self::$citapaciente["fecha_pimeraeco"] == null?'No Evaluado':self::$citapaciente["fecha_pimeraeco"]) .
                //         ", EDAD GESTACIONAL ECO 1ER TRIMESTRE: ". utf8_decode(self::$citapaciente["gestacionaleco1"] == null?'No Evaluado':self::$citapaciente["gestacionaleco1"]) .
                //         ", DESCRIPCIÓN ECOGRAFÍA 1ER TRIMESTRE: ". utf8_decode(self::$citapaciente["descripcioneco1"] == null?'No Evaluado':self::$citapaciente["descripcioneco1"]) .
                //         ", FECHA ECOGRAFÍA 2ER TRIMESTRE: ". utf8_decode(self::$citapaciente["fecha_segundaeco"] == null?'No Evaluado':self::$citapaciente["fecha_segundaeco"]) .
                //         ", EDAD GESTACIONAL ECO 2ER TRIMESTRE: ". utf8_decode(self::$citapaciente["gestacionaleco2"] == null?'No Evaluado':self::$citapaciente["gestacionaleco2"]) .
                //         ", DESCRIPCIÓN ECOGRAFÍA 2ER TRIMESTRE: ". utf8_decode(self::$citapaciente["descripcioneco2"] == null?'No Evaluado':self::$citapaciente["descripcioneco2"]) .
                //         ", FECHA ECOGRAFÍA 3ER TRIMESTRE: ". utf8_decode(self::$citapaciente["fecha_terceraeco"] == null?'No Evaluado':self::$citapaciente["fecha_terceraeco"]) .
                //         ", EDAD GESTACIONAL ECO 3ER TRIMESTRE: ". utf8_decode(self::$citapaciente["gestacionaleco3"] == null?'No Evaluado':self::$citapaciente["gestacionaleco3"]) .
                //         ", DESCRIPCIÓN ECOGRAFÍA 3ER TRIMESTRE: ". utf8_decode(self::$citapaciente["descripcioneco3"] == null?'No Evaluado':self::$citapaciente["descripcioneco3"]).
                //         ", SEMANAS GESTANTES A LA CAPACITACIÓN: ". utf8_decode(self::$citapaciente["gestacionalcaptacion"] == null?'No Evaluado':self::$citapaciente["gestacionalcaptacion"]);

                //         $pdf->SetX(12);
                //         $pdf->MultiCell(186, 4,utf8_decode($textoAntecedentesGestante) , 1, 'l',);
                //         $pdf->Ln();

                //         $pdf->SetTextColor(0,0,0);
                //         $pdf->SetDrawColor(0,0,0);
                //         $pdf->SetX(12);
                //         $pdf->SetFont('Arial', 'B', 8);
                //         $pdf->Cell(186, 4, utf8_decode('PERIODO INTERGENESICO'), 1, 0, 'C',1);
                //         $pdf->Ln();
                //         $pdf->SetTextColor(0,0,0);
                //         $pdf->SetDrawColor(0,0,0);
                //         $pdf->SetFont('Arial', '', 7);
                //         $textoAntecedentesIntergensico = "PERIODO: ". utf8_decode(self::$citapaciente["periodo_interginesico"] == null?'No Evaluado':self::$citapaciente["periodo_interginesico"]) .
                //         ", DESCRIPCIÓN: ". utf8_decode(self::$citapaciente["descripcion_interginesico_corto"] == null?'No Evaluado':self::$citapaciente["descripcion_interginesico_corto"]);
                //         $pdf->SetX(12);
                //         $pdf->MultiCell(186, 4,utf8_decode($textoAntecedentesIntergensico) , 1, 'l',);
                //         $pdf->Ln();

                // $pdf->SetX(12);
                //         $pdf->SetFont('Arial', 'B', 9);
                //         $pdf->SetDrawColor(0,0,0);
                //         $pdf->SetFillColor(214, 214, 214);
                //         $pdf->SetTextColor(0,0,0);
                //         $pdf->Cell(186, 4, utf8_decode('EVALUACIÓN EXPOSICIÓN A VIOLENCIAS'), 1, 0, 'C',1);
                //         $pdf->Ln();
                //         $pdf->SetTextColor(0,0,0);
                //         $pdf->SetDrawColor(0,0,0);
                //         $pdf->SetFont('Arial', '', 7);

                //         $textoEvaluacionExposicion = "¿Durante el último año, ha sido humillada, menospreciada, insultada o amenazada por su pareja?: ". utf8_decode(self::$citapaciente["violencia1"] == null?'No Evaluado':self::$citapaciente["violencia1"]) .
                //         ", ¿Durante el último año, fue golpeada, bofeteada, pateada, o lastimada físicamente de otra manera?: ". utf8_decode(self::$citapaciente["violencia2"] == null?'No Evaluado':self::$citapaciente["violencia2"]) .
                //         ", ¿Durante el último año, fue forzada a tener relaciones sexuales?: ". utf8_decode(self::$citapaciente["violencia3"] == null?'No Evaluado':self::$citapaciente["violencia3"]);

                //         $pdf->SetX(12);
                //         $pdf->MultiCell(186, 4,utf8_decode($textoEvaluacionExposicion) , 1, 'l',);
                //     }
                //     $pdf->Ln();
            }

            #estilo de vida
            if (isset(self::$consulta["cita"]["tipo_historia_id"]) && self::$consulta["cita"]["tipo_historia_id"] != 14) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFillColor(214, 214, 214);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(186, 4, utf8_decode('ESTILOS DE VIDA'), 1, 0, 'C', 1);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 7);

                $dieta_saludable = isset(self::$consulta["HistoriaClinica"]["dieta_saludable"]) && self::$consulta["HistoriaClinica"]["dieta_saludable"] !== null ? self::$consulta["HistoriaClinica"]["dieta_saludable"] : 'No Evaluado';
                $frecuencia_dieta_saludable = isset(self::$consulta["HistoriaClinica"]["frecuencia_dieta_saludable"]) && self::$consulta["HistoriaClinica"]["frecuencia_dieta_saludable"] !== null ? self::$consulta["HistoriaClinica"]["frecuencia_dieta_saludable"] : 'No Evaluado';
                $dieta_balanceada = isset(self::$consulta["HistoriaClinica"]["dieta_balanceada"]) && self::$consulta["HistoriaClinica"]["dieta_balanceada"] !== null ? self::$consulta["HistoriaClinica"]["dieta_balanceada"] : 'No Evaluado';
                $cuantas_comidas = isset(self::$consulta["HistoriaClinica"]["cuantas_comidas"]) && self::$consulta["HistoriaClinica"]["cuantas_comidas"] !== null ? self::$consulta["HistoriaClinica"]["cuantas_comidas"] : 'No Evaluado';

                $textoDieta = "CONSUME FRUTAS Y VERDURAS: " . utf8_decode($dieta_saludable) .
                    ", FRECUENCIA: " . utf8_decode($frecuencia_dieta_saludable) .
                    ", DIETA BALANCEADA: " . utf8_decode($dieta_balanceada) .
                    ", VECES QUE COME AL DÍA: " . utf8_decode($cuantas_comidas);

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoDieta), 1, 'L');

                if (self::$consulta["ciclo_vida_atencion"] == '1ra Infancia' || self::$consulta["ciclo_vida_atencion"] == 'Infancia') {
                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(186, 4, "Durante el dia de ayer recibio leche (vaca, cabra) liquida, polvo, fresca o en bolsa: " . utf8_decode(self::$consulta["HistoriaClinica"]["leche"] == null ? 'No Refiere' : self::$consulta["HistoriaClinica"]["leche"]), 1, 'l', 0);

                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(186, 4, "Durante el dia de ayer o anoche recibio algun alimento como sopa espesa, pure, papilla, o seco: " . utf8_decode(self::$consulta["HistoriaClinica"]["alimento"] == null ? 'No Refiere' : self::$consulta["HistoriaClinica"]["alimento"]), 1, 'l', 0);

                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(186, 4, "Edad en meses de introduccion de los diferentes alimentos: " . utf8_decode(self::$consulta["HistoriaClinica"]["introduccion_alimentos"] == null ? 'No Refiere' : self::$consulta["HistoriaClinica"]["introduccion_alimentos"]) . " meses", 1, 'l', 0);
                }

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $suenoReparador = isset(self::$consulta["HistoriaClinica"]["sueno_reparador"]) && self::$consulta["HistoriaClinica"]["sueno_reparador"] !== null ? self::$consulta["HistoriaClinica"]["sueno_reparador"] : 'No Evaluado';
                $tipoSueno = isset(self::$consulta["HistoriaClinica"]["tipo_sueno"]) && self::$consulta["HistoriaClinica"]["tipo_sueno"] !== null ? self::$consulta["HistoriaClinica"]["tipo_sueno"] : 'No Evaluado';
                $duracionSueno = isset(self::$consulta["HistoriaClinica"]["duracion_sueno"]) && self::$consulta["HistoriaClinica"]["duracion_sueno"] !== null ? self::$consulta["HistoriaClinica"]["duracion_sueno"] . " horas" : 'No Evaluado';

                $textoAlteracionSueño = "Sueño reparador: " . utf8_decode($suenoReparador) .
                    ", Tipo de sueño: " . utf8_decode($tipoSueno) .
                    ", Duración del sueño: " . utf8_decode($duracionSueno);

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoAlteracionSueño), 1, 'L');


                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $altoNivelEstres = isset(self::$consulta["HistoriaClinica"]["alto_nivel_estres"]) && self::$consulta["HistoriaClinica"]["alto_nivel_estres"] !== null ? self::$consulta["HistoriaClinica"]["alto_nivel_estres"] : 'No Evaluado';

                $textoEstres = "Maneja altos niveles de estrés: " . utf8_decode($altoNivelEstres);

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoEstres), 1, 'L');

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $actividadFisica = utf8_decode("Actividad física: ");
                $actividadFisica .= isset(self::$consulta["HistoriaClinica"]["actividad_fisica"]) && self::$consulta["HistoriaClinica"]["actividad_fisica"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["actividad_fisica"]) : 'No Evaluado';
                $actividadFisica .= utf8_decode(", Duración: ");
                $actividadFisica .= isset(self::$consulta["HistoriaClinica"]["duracion_actividad_fisica"]) && self::$consulta["HistoriaClinica"]["duracion_actividad_fisica"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["duracion_actividad_fisica"]) : 'No Evaluado';
                $actividadFisica .= ", Frecuencia: ";
                $actividadFisica .= isset(self::$consulta["HistoriaClinica"]["frecuencia_actividad_fisica"]) && self::$consulta["HistoriaClinica"]["frecuencia_actividad_fisica"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["frecuencia_actividad_fisica"]) : 'No Evaluado';
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, $actividadFisica, 1, 'L');

                if (self::$consulta["ciclo_vida_atencion"] == '1ra Infancia' || self::$consulta["ciclo_vida_atencion"] == 'Infancia') {
                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(186, 4, "Tiempo en minutos de juego: " . utf8_decode(self::$consulta["HistoriaClinica"]["juego"] == null ? 'No Refiere' : self::$consulta["HistoriaClinica"]["juego"]), 1, 'L', 0);

                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(186, 4, "Cuantas veces se bana al dia: " . utf8_decode(self::$consulta["HistoriaClinica"]["bano"] == null ? 'No Refiere' : self::$consulta["HistoriaClinica"]["bano"]), 1, 'L', 0);

                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(186, 4, "Cuidado bucal adecuado: " . utf8_decode(self::$consulta["HistoriaClinica"]["bucal"] == null ? 'No Refiere' : self::$consulta["HistoriaClinica"]["bucal"]), 1, 'L', 0);

                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', '', 8);

                    $anchoDisponible = $pdf->GetPageWidth() - $pdf->GetX() - $pdf->rMargin;

                    $pdf->MultiCell($anchoDisponible,4,"Frecuencia y características de las deposiciones: " . utf8_decode(self::$consulta["HistoriaClinica"]["posiciones"] == null ? 'No Refiere' : self::$consulta["HistoriaClinica"]["posiciones"]),1,'L',0);
                }

                if (self::$consulta["ciclo_vida_atencion"] == '1ra Infancia' || self::$consulta["ciclo_vida_atencion"] == 'Infancia' || self::$consulta["ciclo_vida_atencion"] == 'Vejez') {
                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(186, 4, "Control esfinter vesical: " . utf8_decode(self::$consulta["HistoriaClinica"]["esfinter"] == null ? 'No Refiere' : self::$consulta["HistoriaClinica"]["esfinter"]), 1, 'L', 0);

                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(186, 4, "Control esfinter rectal: " . utf8_decode(self::$consulta["HistoriaClinica"]["esfinter_rectal"] == null ? 'No Refiere' : self::$consulta["HistoriaClinica"]["esfinter_rectal"]), 1, 'L', 0);

                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(186, 4, "Frecuencia y caracteristicas de la orina: " . utf8_decode(self::$consulta["HistoriaClinica"]["caracteristicas_orina"] == null ? 'No Refiere' : self::$consulta["HistoriaClinica"]["caracteristicas_orina"]), 1, 'L', 0);
                }

                $pdf->SetFont('Arial', '', 8);
                $textoHumo = "Expuesto al Humo: ";
                $textoHumo .= isset(self::$consulta["HistoriaClinica"]["expuesto_humo"]) && self::$consulta["HistoriaClinica"]["expuesto_humo"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["expuesto_humo"]) : 'No Evaluado';
                $textoHumo .= utf8_decode(", Años expuesto: ");
                $textoHumo .= isset(self::$consulta["HistoriaClinica"]["anios_expuesto"]) && self::$consulta["HistoriaClinica"]["anios_expuesto"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["anios_expuesto"]) : 'No Evaluado';

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, $textoHumo, 1, 'L');

                $pdf->SetFont('Arial', '', 8);
                $textoPsicoactivas = "Expuesto a sustancias psicoactivas: ";
                $textoPsicoactivas .= isset(self::$consulta["HistoriaClinica"]["expuesto_psicoactivos"]) && self::$consulta["HistoriaClinica"]["expuesto_psicoactivos"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["expuesto_psicoactivos"]) : 'No Evaluado';
                $textoPsicoactivas .= utf8_decode(", Años expuesto: ");
                $textoPsicoactivas .= isset(self::$consulta["HistoriaClinica"]["anios_expuesto_sustancias"]) && self::$consulta["HistoriaClinica"]["anios_expuesto_sustancias"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["anios_expuesto_sustancias"]) : 'No Evaluado';

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, $textoPsicoactivas, 1, 'L');


                if (self::$consulta["ciclo_vida_atencion"] != '1ra Infancia') {

                    $pdf->SetFont('Arial', '', 8);
                    // Texto sobre el consumo de tabaco
                    $textoFuma = utf8_decode("Cuantos Cigarrillos al día: ");
                    $textoFuma .= isset(self::$consulta["HistoriaClinica"]["fuma_cantidad"]) && self::$consulta["HistoriaClinica"]["fuma_cantidad"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["fuma_cantidad"]) : 'No Evaluado';
                    $textoFuma .= utf8_decode(", Años que fuma: ");
                    $textoFuma .= isset(self::$consulta["HistoriaClinica"]["fumamos"]) && self::$consulta["HistoriaClinica"]["fumamos"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["fumamos"]) : 'No Evaluado';
                    $textoFuma .= utf8_decode(", Índice tabáquico: ");
                    $textoFuma .= isset(self::$consulta["HistoriaClinica"]["tabaquico"]) && self::$consulta["HistoriaClinica"]["tabaquico"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["tabaquico"]) : 'No Evaluado';
                    $textoFuma .= ", Riesgo EPOC: ";
                    $textoFuma .= isset(self::$consulta["HistoriaClinica"]["riesgo_epoc"]) && self::$consulta["HistoriaClinica"]["riesgo_epoc"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["riesgo_epoc"]) : 'No Evaluado';

                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, $textoFuma, 1, 'L');

                    // Texto sobre el consumo de psicoactivos
                    $pdf->SetFont('Arial', '', 8);
                    $textoConsumoPsicoactivo = "Fecha de inicio: ";
                    $textoConsumoPsicoactivo .= isset(self::$consulta["HistoriaClinica"]["consumo_psicoactivo"]) && self::$consulta["HistoriaClinica"]["consumo_psicoactivo"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["consumo_psicoactivo"]) : 'No Evaluado';
                    $textoConsumoPsicoactivo .= ", Cantidad: ";
                    $textoConsumoPsicoactivo .= isset(self::$consulta["HistoriaClinica"]["psicoactivo_cantidad"]) && self::$consulta["HistoriaClinica"]["psicoactivo_cantidad"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["psicoactivo_cantidad"]) : 'No Evaluado';

                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, $textoConsumoPsicoactivo, 1, 'L');

                    // Texto sobre el consumo de licor
                    $textoLicor = "Cantidad de tragos: ";
                    $textoLicor .= isset(self::$consulta["HistoriaClinica"]["cantidad_licor"]) && self::$consulta["HistoriaClinica"]["cantidad_licor"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["cantidad_licor"]) : 'No Evaluado';
                    $textoLicor .= ", Frecuencia: ";
                    $textoLicor .= isset(self::$consulta["HistoriaClinica"]["licor_frecuencia"]) && self::$consulta["HistoriaClinica"]["licor_frecuencia"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["licor_frecuencia"]) : 'No Evaluado';

                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, $textoLicor, 1, 'L');

                    // Texto de observaciones sobre el estilo de vida
                    $pdf->SetFont('Arial', '', 8);
                    $textoObservacionesEstilovida = "Observaciones: ";
                    $textoObservacionesEstilovida .= isset(self::$consulta["HistoriaClinica"]["estilo_vida_observaciones"]) && self::$consulta["HistoriaClinica"]["estilo_vida_observaciones"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["estilo_vida_observaciones"]) : 'No Evaluado';

                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, $textoObservacionesEstilovida, 1, 'L');
                }

                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES SEXUALES Y REPRODUCTIVOS'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 8);

                // Verificación de la clave 'tipo_orientacion_sexual'
                $orientacionSexual = isset(self::$consulta["antecedentesSexuales"]["tipo_orientacion_sexual"]) ? self::$consulta["antecedentesSexuales"]["tipo_orientacion_sexual"] : 'No Evaluado';
                $textoOrientacionSexual = "Orientación sexual: " . utf8_decode($orientacionSexual);
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoOrientacionSexual), 1, 'L');

                $pdf->SetFont('Arial', '', 8);

                // Verificación de la clave 'tipo_identidad_genero'
                $identidadGenero = isset(self::$consulta["antecedentesSexuales"]["tipo_identidad_genero"]) ? self::$consulta["antecedentesSexuales"]["tipo_identidad_genero"] : 'No Evaluado';
                $textoIdentidadGenero = "Identidad de género: " . utf8_decode($identidadGenero);
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoIdentidadGenero), 1, 'L');
                if (self::$consulta["afiliado"]["Sexo"] == 'M') {

                    $pdf->SetFont('Arial', '', 8);
                    $textoEspermaquia = "Espermaquia: " . utf8_decode(self::$consulta["antecedentesSexuales"]["tipo_antecedentes_sexuales"] == null ? 'No Evaluado' : (self::$consulta["antecedentesSexuales"]["tipo_antecedentes_sexuales"] == null ? 'No Evaluado' : self::$consulta["antecedentesSexuales"]["tipo_antecedentes_sexuales"])) .
                        ", Edad Esperma: " . utf8_decode(self::$consulta == null ? 'No Evaluado' : (self::$consulta["antecedentesSexuales"]["edad"] == null ? 'No Evaluado' : self::$consulta["antecedentesSexuales"]["edad"] . " anos"));
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, utf8_decode($textoEspermaquia), 1, 'l',);
                }

                if (isset(self::$consulta["afiliado"]["Sexo"]) && self::$consulta["afiliado"]["Sexo"] == 'F') {
                    $pdf->SetFont('Arial', '', 8);

                    // Verificación de la clave 'tipo_antecedentes_sexuales'
                    $tipoAntecedentesSexuales = isset(self::$consulta["antecedentesSexuales"]["tipo_antecedentes_sexuales"]) ? self::$consulta["antecedentesSexuales"]["tipo_antecedentes_sexuales"] : 'No Evaluado';

                    // Verificación de la clave 'edad' para 'Edad menarquia'
                    $edadMenarquia = isset(self::$consulta["antecedentesSexuales"]["edad"]) ? self::$consulta["antecedentesSexuales"]["edad"] . " años" : 'No Evaluado';

                    $textoMenarquia = "Menarquia: " . utf8_decode($tipoAntecedentesSexuales) . ", Edad menarquia: " . utf8_decode($edadMenarquia);
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, utf8_decode($textoMenarquia), 1, 'L');
                }

                $pdf->SetFont('Arial', '', 8);

                // Verificación de la clave 'edad' para 'Inicio de relaciones sexuales'
                $edadRelaciones = isset(self::$consulta["antecedentesSexuales"]["edad"]) ? self::$consulta["antecedentesSexuales"]["edad"] . " años" : 'No Evaluado';

                // Verificación de la clave 'resultados' para 'Numero de compañeros sexuales'
                $numCompanerosSexuales = isset(self::$consulta["antecedentesSexuales"]["resultados"]) ? self::$consulta["antecedentesSexuales"]["resultados"] : 'No Evaluado';

                $textoRelacionesSexuales = "Inicio de relaciones sexuales: " . utf8_decode($edadRelaciones) . ", Numero de compañeros sexuales: " . utf8_decode($numCompanerosSexuales);
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoRelacionesSexuales), 1, 'L');

                $textoMetodosAnticonceptivos = utf8_decode("Uso de algún método anticonceptivo: ");
                $textoMetodosAnticonceptivos .= isset(self::$consulta["HistoriaClinica"]["presente_metodo_anticonceptivo"]) && self::$consulta["HistoriaClinica"]["presente_metodo_anticonceptivo"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["presente_metodo_anticonceptivo"]) : 'No Evaluado';
                $textoMetodosAnticonceptivos .= ", Tipo: ";
                $textoMetodosAnticonceptivos .= isset(self::$consulta["HistoriaClinica"]["tipo_metodo_anticonceptivo"]) && self::$consulta["HistoriaClinica"]["tipo_metodo_anticonceptivo"] !== null ? utf8_decode(self::$consulta["HistoriaClinica"]["tipo_metodo_anticonceptivo"]) : 'No Evaluado';
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, $textoMetodosAnticonceptivos, 1, 'L');

                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(186, 4, utf8_decode('ECOMAPA'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $trabaja = isset(self::$consulta["antecedenteEcomapa"]["trabaja"]) ? self::$consulta["antecedenteEcomapa"]["trabaja"] : 'No Evaluado';
                $asisteIglesia = isset(self::$consulta["antecedenteEcomapa"]["asiste_iglesia"]) ? self::$consulta["antecedenteEcomapa"]["asiste_iglesia"] : 'No Evaluado';
                $perteneceClubDeportivo = isset(self::$consulta["antecedenteEcomapa"]["pertenece_club_deportivo"]) ? self::$consulta["antecedenteEcomapa"]["pertenece_club_deportivo"] : 'No Evaluado';
                $textoEcomapa = "Trabaja: " . utf8_decode($trabaja) .
                    ", Asiste a la iglesia: " . utf8_decode($asisteIglesia) .
                    ", Pertenece a algun club deportivo: " . utf8_decode($perteneceClubDeportivo);
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoEcomapa), 1, 'L');
                // Verificación de las claves en el array 'antecedenteEcomapa'
                $comparteAmigos = isset(self::$consulta["antecedenteEcomapa"]["comparte_amigos"]) ? self::$consulta["antecedenteEcomapa"]["comparte_amigos"] : 'No Evaluado';
                $asisteColegio = isset(self::$consulta["antecedenteEcomapa"]["asiste_colegio"]) ? self::$consulta["antecedenteEcomapa"]["asiste_colegio"] : 'No Evaluado';
                $comparteVecinos = isset(self::$consulta["antecedenteEcomapa"]["comparte_vecinos"]) ? self::$consulta["antecedenteEcomapa"]["comparte_vecinos"] : 'No Evaluado';
                $perteneceClub = isset(self::$consulta["antecedenteEcomapa"]["pertenece_club_social_cultural"]) ? self::$consulta["antecedenteEcomapa"]["pertenece_club_social_cultural"] : 'No Evaluado';
                $textoEcomapa2 = "Comparte con sus amigos: " . utf8_decode($comparteAmigos) .
                    ", Asiste a la colegio: " . utf8_decode($asisteColegio) .
                    ", Comparte con sus vecinos: " . utf8_decode($comparteVecinos) .
                    ", Pertenece a algún club: " . utf8_decode($perteneceClub);

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoEcomapa2), 1, 'L');
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                // Verificación y generación del texto para 'ayuda_familia'
                $ayudaFamilia = isset(self::$consulta["apgarFamiliar"]["ayuda_familia"]) ? self::$consulta["apgarFamiliar"]["ayuda_familia"] : null;
                $ayudaFamiliaTexto = $ayudaFamilia === null ? 'No Evaluado' : ($ayudaFamilia == 1 ? 'ALGUNAS VECES' : ($ayudaFamilia == 2 ? 'CASI SIEMPRE' : ($ayudaFamilia == 4 ? 'SIEMPRE' : 'CASI NUNCA')));
                $pdf->MultiCell(186, 4, utf8_decode('ESTOY CONTENTO DE PENSAR QUE PUEDO RECURRIR A MI FAMILIA EN BUSCA DE AYUDA CUANDO ALGO ME PREOCUPA: ' . $ayudaFamiliaTexto), 1, 'L', 0);
                $pdf->SetX(12);
                // Verificación y generación del texto para 'familia_habla_con_usted'
                $familiaHabla = isset(self::$consulta["apgarFamiliar"]["familia_habla_con_usted"]) ? self::$consulta["apgarFamiliar"]["familia_habla_con_usted"] : null;
                $familiaHablaTexto = $familiaHabla === null ? 'No Evaluado' : ($familiaHabla == 1 ? 'ALGUNAS VECES' : ($familiaHabla == 2 ? 'CASI SIEMPRE' : ($familiaHabla == 4 ? 'SIEMPRE' : 'CASI NUNCA')));
                $pdf->MultiCell(186, 4, utf8_decode('ESTOY SATISFECHO CON EL MODO QUE TIENE MI FAMILIA DE HABLAR LAS COSAS CONMIGO Y DE CÓMO COMPARTIMOS LOS PROBLEMAS: ' . $familiaHablaTexto), 1, 'L', 0);
                $pdf->SetX(12);
                // Verificación y generación del texto para 'cosas_nuevas'
                $cosasNuevas = isset(self::$consulta["apgarFamiliar"]["cosas_nuevas"]) ? self::$consulta["apgarFamiliar"]["cosas_nuevas"] : null;
                $cosasNuevasTexto = $cosasNuevas === null ? 'No Evaluado' : ($cosasNuevas == 1 ? 'ALGUNAS VECES' : ($cosasNuevas == 2 ? 'CASI SIEMPRE' : ($cosasNuevas == 4 ? 'SIEMPRE' : 'CASI NUNCA')));
                $pdf->MultiCell(186, 4, utf8_decode('ME AGRADA PENSAR QUE MI FAMILIA ACEPTA Y APOYA MIS DESEOS DE LLEVAR A CABO NUEVAS ACTIVIDADES O SEGUIR UNA NUEVA DIRECCIÓN: ' . $cosasNuevasTexto), 1, 'L', 0);
                $pdf->SetX(12);
                // Reutilización de 'ayuda_familia' para 'APOYO FAMILIAR'
                $pdf->MultiCell(186, 4, utf8_decode('APOYO FAMILIAR: ' . $ayudaFamiliaTexto), 1, 'L', 0);
                $pdf->SetX(12);
                // Verificación y generación del texto para 'le_gusta_familia_comparte'
                $leGustaFamiliaComparte = isset(self::$consulta["apgarFamiliar"]["le_gusta_familia_comparte"]) ? self::$consulta["apgarFamiliar"]["le_gusta_familia_comparte"] : null;
                $leGustaFamiliaComparteTexto = $leGustaFamiliaComparte === null ? 'No Evaluado' : ($leGustaFamiliaComparte == 1 ? 'ALGUNAS VECES' : ($leGustaFamiliaComparte == 2 ? 'CASI SIEMPRE' : ($leGustaFamiliaComparte == 4 ? 'SIEMPRE' : 'CASI NUNCA')));
                $pdf->MultiCell(186, 4, utf8_decode('TIEMPO FAMILIAR: ' . $leGustaFamiliaComparteTexto), 1, 'L', 0);
                $pdf->SetX(12);
                // Verificación y generación del texto para 'resultado'
                $resultado = isset(self::$consulta["apgarFamiliar"]["resultado"]) ? self::$consulta["apgarFamiliar"]["resultado"] : 'No Evaluado';
                $pdf->MultiCell(186, 4, utf8_decode('RESULTADO: ' . $resultado), 1, 'L', 0);
                $pdf->Ln();

                //Familiorgramas
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(186, 4, utf8_decode('FAMILIOGRAMA'), 1, 0, 'C', 1);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Ln();

                // Verificación de las claves en el array 'familiograma'
                $vinculos = isset(self::$consulta["antecedenteFamiliograma"]["vinculos"]) ? utf8_decode(self::$consulta["antecedenteFamiliograma"]["vinculos"]) : 'No Evaluado';
                $tipo_familia = isset(self::$consulta["antecedenteFamiliograma"]["tipo_familia"]) ? self::$consulta["antecedenteFamiliograma"]["tipo_familia"] : 'No Evaluado';
                $relacionAfectiva = isset(self::$consulta["antecedenteFamiliograma"]["relacion"]) ? self::$consulta["antecedenteFamiliograma"]["relacion"] : 'No Evaluado';
                $problemasSalud = isset(self::$consulta["antecedenteFamiliograma"]["problemas_de_salud"]) ? self::$consulta["antecedenteFamiliograma"]["problemas_de_salud"] : 'No Evaluado';
                $cualFamiliograma = isset(self::$consulta["antecedenteFamiliograma"]["cual_salud"]) ? self::$consulta["antecedenteFamiliograma"]["cual_salud"] : 'No Evaluado';
                $responsable_ingreso = isset(self::$consulta["antecedenteFamiliograma"]["responsable_ingreso"]) ? self::$consulta["antecedenteFamiliograma"]["responsable_ingreso"] : 'No Evaluado';
                $observacionesFamiliograma = isset(self::$consulta["antecedenteFamiliograma"]["observacion_salud"]) ? self::$consulta["antecedenteFamiliograma"]["observacion_salud"] : 'No Evaluado';

                $textoFamiliograma = "Vinculos: " . $vinculos .
                    ", Tipo familia: " . utf8_decode($tipo_familia) .
                    ", Relacion afectiva: " . utf8_decode($relacionAfectiva) .
                    ", Problemas salud/enfermedad: " . utf8_decode($problemasSalud) .
                    ", Cual: " . utf8_decode($cualFamiliograma) .
                    ", Responsable: " . utf8_decode($responsable_ingreso) .
                    ", Observacion: " . utf8_decode($observacionesFamiliograma);

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoFamiliograma), 1, 'L');

                //Actividad economica
                $pdf->Ln();
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(186, 4, utf8_decode('ACTIVIDAD ECONÓMICA'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetFont('Arial', '', 8);

                // Verificación de las claves en el array 'familiograma'
                $actividadLaboral = isset(self::$consulta["antecedenteFamiliograma"]["actividad_laboral"]) ? self::$consulta["antecedenteFamiliograma"]["actividad_laboral"] : 'No Evaluado';
                $alteraciones = isset(self::$consulta["antecedenteFamiliograma"]["alteraciones"]) ? self::$consulta["antecedenteFamiliograma"]["alteraciones"] : 'No Evaluado';
                $descripcionActividad = isset(self::$consulta["antecedenteFamiliograma"]["descripcion_actividad"]) ? self::$consulta["antecedenteFamiliograma"]["descripcion_actividad"] : 'No Evaluado';

                $textoActividadEconomica = "Edad de inicio de su actividad laboral: " . utf8_decode($actividadLaboral === 'No Evaluado' ? 'No Evaluado' : $actividadLaboral . " años") .
                    ", sufre usted alteraciones temporales, permanentes o agravadas del estado de salud, ocasionadas por la labor o por la exposición al medio ambiente de trabajo: " . utf8_decode($alteraciones) .
                    ", descripción: " . utf8_decode($descripcionActividad);

                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoActividadEconomica), 1, 'L');

                if (count(self::$consulta["resultadoLaboratorios"]) > 0) {
                    $pdf->Ln();
                    # LABORATORIO
                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', 'B', 9);
                    $pdf->Cell(186, 4, utf8_decode('RESULTADOS LABORATORIOS'), 1, 0, 'C', 1);
                    $pdf->Ln();
                    $pdf->SetFont('Arial', '', 8);
                    $y = $pdf->GetY();

                    foreach (self::$consulta["resultadoLaboratorios"] as $resultadoLaboratorio) {
                        // Verificación de cada campo en $resultadoLaboratorio
                        $fechaLaboratorio = !empty($resultadoLaboratorio->fecha_laboratorio) ? substr($resultadoLaboratorio->fecha_laboratorio, 0, 10) : 'No Aplica';
                        $medicoRegistra = !empty($resultadoLaboratorio->medico_registra) ? $resultadoLaboratorio->medico_registra : 'No Aplica';
                        $laboratorio = !empty($resultadoLaboratorio->laboratorio) ? $resultadoLaboratorio->laboratorio : 'No Aplica';
                        $resultadoLab = !empty($resultadoLaboratorio->resultado_lab) ? $resultadoLaboratorio->resultado_lab : 'No Aplica';
                        $factorRh = !empty($resultadoLaboratorio->factor_rh) ? $resultadoLaboratorio->factor_rh : 'No Aplica';

                        $textoAntecedentes = "FECHA LABORATORIO: " . utf8_decode($fechaLaboratorio) .
                            ", MEDICO: " . utf8_decode($medicoRegistra) .
                            ", LABORATORIO: " . utf8_decode($laboratorio) .
                            ", RESULTADO: " . utf8_decode($resultadoLab) .
                            ", FACTOR RH: " . utf8_decode($factorRh);

                        $pdf->SetX(12);
                        $pdf->MultiCell(186, 4, $textoAntecedentes, 1, "L", 0);
                    }
                }
            }
            $pdf->Ln();
        }

        if (isset(self::$consulta["cita"]["tipo_historia_id"]) && self::$consulta["cita"]["tipo_historia_id"] == 16) {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES ODONTOLOGICOS'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Ultima consulta: " . utf8_decode(self::$consulta["antecedentesOdontologicos"] !== null ? self::$consulta["antecedentesOdontologicos"]["ultima_consulta_odontologo"] : 'No Evaluado')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Descripción ultima consulta: " . utf8_decode(self::$consulta["antecedentesOdontologicos"] !== null ? self::$consulta["antecedentesOdontologicos"]["descripcion_ultima_consulta"] : 'No Evaluado')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Aplicacion de fluor y sellantes: " . utf8_decode(self::$consulta["antecedentesOdontologicos"] !== null ? self::$consulta["antecedentesOdontologicos"]["aplicacion_fluor_sellantes"] == true ? 'SI - Descripcion: ' . self::$consulta["antecedentesOdontologicos"]["descripcion_aplicacion_fl_sellante"] : 'NO' : 'NO')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Exodoncias: " . utf8_decode(self::$consulta["antecedentesOdontologicos"] !== null ? self::$consulta["antecedentesOdontologicos"]["descripcion_exodoncia"] == true ? 'SI - Descripcion: ' . self::$consulta["antecedentesOdontologicos"]["descripcion_exodoncia"] : 'NO' : 'NO')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Traumas: " . utf8_decode(self::$consulta["antecedentesOdontologicos"] !== null ? self::$consulta["antecedentesOdontologicos"]["traumas"] == true ? 'SI - Descripcion: ' . self::$consulta["antecedentesOdontologicos"]["descripcion_trauma"] : 'NO' : 'NO')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Aparatologia: " . utf8_decode(self::$consulta["antecedentesOdontologicos"] !== null ? self::$consulta["antecedentesOdontologicos"]["aparatologia"] == true ? 'SI - Descripcion: ' . self::$consulta["antecedentesOdontologicos"]["descripcion_aparatologia"] : 'NO' : 'NO')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Biopsias: " . utf8_decode(self::$consulta["antecedentesOdontologicos"] !== null ? self::$consulta["antecedentesOdontologicos"]["biopsias"] == true ? 'SI - Descripcion: ' . self::$consulta["antecedentesOdontologicos"]["descripcion_biopsia"] : 'NO' : 'NO')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Cirugias orales: " . utf8_decode(self::$consulta["antecedentesOdontologicos"] !== null ? self::$consulta["antecedentesOdontologicos"]["cirugias_orales"] == true ? 'SI - Descripcion: ' . self::$consulta["antecedentesOdontologicos"]["descripcion_cirugia_oral"] : 'NO' : 'NO')), 1, 'L', 0);

            $pdf->Ln();
            #antecedentes familiares
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(186, 4, utf8_decode('ANTECEDENTES FAMILIARES'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            if (count(self::$consulta["antecedentesFamiliares"]) > 0) {
                foreach (self::$consulta["antecedentesFamiliares"] as $familiares) {
                    $nombreCompletoMedico = utf8_decode(self::$consulta["medicoOrdena"]["operador"]["nombre"]) . " " . utf8_decode(self::$consulta["medicoOrdena"]["operador"]["apellido"]);
                    $textoAntecedentesFamiliares = "FECHA: " . utf8_decode((new DateTime($familiares->created_at))->format('Y-m-d')) . ", MÉDICO: " . utf8_decode($nombreCompletoMedico) .
                        ", PARENTESCO: " . utf8_decode($familiares->parentesco) .
                        $fallecio = ($familiares->fallecido == 1) ? ' ,FALLECIO: Sí' : ' ,FALLECIO: No';
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesFamiliares), 1, 'L');
                }
            } else {
                $textoAntecedentesFamiliares = utf8_decode('No Refiere');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoAntecedentesFamiliares), 1, 'L');
            }

            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('HÁBITOS HIGIENE ORAL'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Frecuencia de cepillado: " . utf8_decode(self::$consulta["HistoriaClinica"] !== null ? self::$consulta["HistoriaClinica"]["frecuencia_cepillado"] : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Quien realiza la higiene: " . utf8_decode(self::$consulta["HistoriaClinica"] !== null ? self::$consulta["HistoriaClinica"]["realiza_higiene"] : ' ')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Uso de crema dental: " . utf8_decode(self::$consulta["HistoriaClinica"] !== null ? self::$consulta["HistoriaClinica"]["uso_crema_dental"] !== null ? self::$consulta["HistoriaClinica"]["uso_crema_dental"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Uso de seda dental: " . utf8_decode(self::$consulta["HistoriaClinica"] !== null ? self::$consulta["HistoriaClinica"]["uso_seda_dental"] !== null ? self::$consulta["HistoriaClinica"]["uso_seda_dental"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Uso de enjuague bucal: " . utf8_decode(self::$consulta["HistoriaClinica"] !== null ? self::$consulta["HistoriaClinica"]["uso_enjuague_bucal"] !== null ? self::$consulta["HistoriaClinica"]["uso_enjuague_bucal"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Uso de aparatología ortopédica: " . utf8_decode(self::$consulta["HistoriaClinica"] !== null ? self::$consulta["HistoriaClinica"]["uso_aparatologia_ortopedica"] !== null ? self::$consulta["HistoriaClinica"]["uso_aparatologia_ortopedica"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Uso de aditamentos protésicos removibles: " . utf8_decode(self::$consulta["HistoriaClinica"] !== null ? self::$consulta["HistoriaClinica"]["uso_adimentos_protesicos_removibles"] !== null ? self::$consulta["HistoriaClinica"]["uso_adimentos_protesicos_removibles"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Higiene de los aparatos o prótesis: " . utf8_decode(self::$consulta["HistoriaClinica"] !== null ? self::$consulta["HistoriaClinica"]["higiene_aparatos_protesis"] !== null ? self::$consulta["HistoriaClinica"]["higiene_aparatos_protesis"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('HÁBITOS CAVIDAD ORAL'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Respiración bucal:	" . utf8_decode(self::$consulta["HistoriaClinica"] !== null ? self::$consulta["HistoriaClinica"]["respiracion_bucal"] !== null ? self::$consulta["HistoriaClinica"]["respiracion_bucal"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Succión digital: " . utf8_decode(self::$consulta["HistoriaClinica"] !== null ? self::$consulta["HistoriaClinica"]["succion_digital"] !== null ? self::$consulta["HistoriaClinica"]["succion_digital"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Lengua protactil: " . utf8_decode(self::$consulta["HistoriaClinica"] !== null ? self::$consulta["HistoriaClinica"]["lengua_protactil"] !== null ? self::$consulta["HistoriaClinica"]["lengua_protactil"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Onicofagia: " . utf8_decode(self::$consulta["HistoriaClinica"] !== null ? self::$consulta["HistoriaClinica"]["onicofagia"] !== null ? self::$consulta["HistoriaClinica"]["onicofagia"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Queilofagia: " . utf8_decode(self::$consulta["HistoriaClinica"] !== null ? self::$consulta["HistoriaClinica"]["queilofagia"] !== null ? self::$consulta["HistoriaClinica"]["queilofagia"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Mordisqueo: " . utf8_decode(self::$consulta["HistoriaClinica"] !== null ? self::$consulta["HistoriaClinica"]["mordisqueo"] !== null ? self::$consulta["HistoriaClinica"]["mordisqueo"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Biberón: " . utf8_decode(self::$consulta["HistoriaClinica"] !== null ? self::$consulta["HistoriaClinica"]["biberon"] !== null ? self::$consulta["HistoriaClinica"]["biberon"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Chupos: " . utf8_decode(self::$consulta["HistoriaClinica"] !== null ? self::$consulta["HistoriaClinica"]["chupos"] !== null ? self::$consulta["HistoriaClinica"]["chupos"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Otros: " . utf8_decode(self::$consulta["HistoriaClinica"] !== null ? self::$consulta["HistoriaClinica"]["otros"] !== null ? self::$consulta["HistoriaClinica"]["otros"] : 'No' : 'No')), 1, 'L', 0);


            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('EXAMÉN FISICO'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('CARA Y CUELLO'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Asimetrías: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["asimetria"] !== null ? self::$consulta["examenFisicoOdontologicos"]["asimetria"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Lunares, manchas, tatuajes: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["lunares_manchas_tatuajes"] !== null ? self::$consulta["examenFisicoOdontologicos"]["lunares_manchas_tatuajes"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Aumento de volúmen: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["aumento_volumen"] !== null ? self::$consulta["examenFisicoOdontologicos"]["aumento_volumen"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Ganglios linfáticos: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["ganglios_linfaticos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["ganglios_linfaticos"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Senos maxilares: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["senos_maxilares"] !== null ? self::$consulta["examenFisicoOdontologicos"]["senos_maxilares"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('EXAMÉN DE ARTICULACIÓN TEMPOROMANDIBULAR'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Ruidos: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["ruidos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["ruidos"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Chasquidos: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["chasquidos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["chasquidos"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Crepitaciones: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["crepitaciones"] !== null ? self::$consulta["examenFisicoOdontologicos"]["crepitaciones"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Bloqueo mandibular: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["bloqueo_mandibular"] !== null ? self::$consulta["examenFisicoOdontologicos"]["bloqueo_mandibular"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Dolor: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["dolor"] !== null ? self::$consulta["examenFisicoOdontologicos"]["dolor"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Apertura y cierre:	" . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["apertura_cierre"] !== null ? self::$consulta["examenFisicoOdontologicos"]["apertura_cierre"] : 'No' : 'No')), 1, 'L', 0);


            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('EXÁMEN ESTOMATOLÓGICO'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Labio inferior: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["labio_inferior"] !== null ? self::$consulta["examenFisicoOdontologicos"]["labio_inferior"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Labio superior: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["labio_superior"] !== null ? self::$consulta["examenFisicoOdontologicos"]["labio_superior"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Comisuras: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["comisuras"] !== null ? self::$consulta["examenFisicoOdontologicos"]["comisuras"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Mucosa oral: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["mucosa_oral"] !== null ? self::$consulta["examenFisicoOdontologicos"]["mucosa_oral"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Carrillos: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["carrillos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["carrillos"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Surcos yugales: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["surcos_yugales"] !== null ? self::$consulta["examenFisicoOdontologicos"]["surcos_yugales"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Frenillos: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["frenillos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["frenillos"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Orofaringe: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["orofaringe"] !== null ? self::$consulta["examenFisicoOdontologicos"]["orofaringe"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Paladar: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["paladar"] !== null ? self::$consulta["examenFisicoOdontologicos"]["paladar"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Glándulas salivares: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["glandulas_salivares"] !== null ? self::$consulta["examenFisicoOdontologicos"]["glandulas_salivares"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Piso de boca: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["piso_boca"] !== null ? self::$consulta["examenFisicoOdontologicos"]["piso_boca"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Dorso de lengua: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["dorso_lengua"] !== null ? self::$consulta["examenFisicoOdontologicos"]["dorso_lengua"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Vientre de lengua:	" . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["vientre_lengua"] !== null ? self::$consulta["examenFisicoOdontologicos"]["vientre_lengua"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Músculos masticadores: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["musculos_masticadores"] !== null ? self::$consulta["examenFisicoOdontologicos"]["musculos_masticadores"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Riesgo de caídas: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["riesgo_caidas"] !== null ? self::$consulta["examenFisicoOdontologicos"]["riesgo_caidas"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Otros:	" . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["otros"] !== null ? self::$consulta["examenFisicoOdontologicos"]["otros"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('EXÁMEN FUNCIONAL'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Masticación: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["masticacion"] !== null ? self::$consulta["examenFisicoOdontologicos"]["masticacion"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Deglución:	" . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["deglucion"] !== null ? self::$consulta["examenFisicoOdontologicos"]["deglucion"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Habla: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["habla"] !== null ? self::$consulta["examenFisicoOdontologicos"]["habla"] : 'Normal' : 'Normal')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Fonación: " . utf8_decode(self::$consulta["examenFisicoOdontologicos"] !== null ? self::$consulta["examenFisicoOdontologicos"]["fonacion"] !== null ? self::$consulta["examenFisicoOdontologicos"]["fonacion"] : 'Normal' : 'Normal')), 1, 'L', 0);


            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('OCLUSIÓN'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Relaciones molares: " . utf8_decode(isset(self::$consulta["examenFisicoOdontologicos"]["relaciones_molares"]) ? self::$consulta["examenFisicoOdontologicos"]["relaciones_molares"] : 'No se puede determinar')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Relaciones caninas: " . utf8_decode(isset(self::$consulta["examenFisicoOdontologicos"]["relaciones_caninas"]) ? self::$consulta["examenFisicoOdontologicos"]["relaciones_caninas"] : 'No se puede determinar')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Relación interdental: " . utf8_decode(isset(self::$consulta["examenFisicoOdontologicos"]["relacion_interdental"]) ? self::$consulta["examenFisicoOdontologicos"]["relacion_interdental"] : 'No se puede determinar')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Tipo de oclusión: " . utf8_decode(isset(self::$consulta["examenFisicoOdontologicos"]["tipo_oclusion"]) ? self::$consulta["examenFisicoOdontologicos"]["tipo_oclusion"] : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Apiñamiento: " . utf8_decode(isset(self::$consulta["examenFisicoOdontologicos"]["apiñamiento"]) ? self::$consulta["examenFisicoOdontologicos"]["apiñamiento"] : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Mordida abierta: " . utf8_decode(isset(self::$consulta["examenFisicoOdontologicos"]["mordida_abierta"]) ? self::$consulta["examenFisicoOdontologicos"]["mordida_abierta"] : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Mordida profunda: " . utf8_decode(isset(self::$consulta["examenFisicoOdontologicos"]["mordida_profunda"]) ? self::$consulta["examenFisicoOdontologicos"]["mordida_profunda"] : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Mordida cruzada: " . utf8_decode(isset(self::$consulta["examenFisicoOdontologicos"]["mordida_cruzada"]) ? self::$consulta["examenFisicoOdontologicos"]["mordida_cruzada"] : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Discrepancias óseas: " . utf8_decode(isset(self::$consulta["examenFisicoOdontologicos"]["discrepancias_oseas"]) ? self::$consulta["examenFisicoOdontologicos"]["discrepancias_oseas"] : 'No')), 1, 'L', 0);


            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('EXÁMEN DE TEJIDOS DUROS'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('EXÁMEN PULPAR'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Sensibilidad al frio: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["sensibilidad_frio"] !== null ? self::$consulta["examenTejidoOdontologicos"]["sensibilidad_frio"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Sensibilidad al calor: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["sensibilidad_calor"] !== null ? self::$consulta["examenTejidoOdontologicos"]["sensibilidad_calor"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Cambio de color: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["cambio_de_color"] !== null ? self::$consulta["examenTejidoOdontologicos"]["cambio_de_color"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Percusión positiva: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["percusion_positiva"] !== null ? self::$consulta["examenTejidoOdontologicos"]["percusion_positiva"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Exposición pulpar: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["exposicion_pulpar"] !== null ? self::$consulta["examenTejidoOdontologicos"]["exposicion_pulpar"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Otros: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["otros"] !== null ? self::$consulta["examenTejidoOdontologicos"]["otros"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('EXÁMEN DE TEJIDOS DENTARIOS'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Supernumerarios: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["supernumerarios"] !== null ? self::$consulta["examenTejidoOdontologicos"]["supernumerarios"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Agenesia: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["agenesia"] !== null ? self::$consulta["examenTejidoOdontologicos"]["agenesia"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Anodoncia: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["anodoncia"] !== null ? self::$consulta["examenTejidoOdontologicos"]["anodoncia"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Decoloración: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["decoloracion"] !== null ? self::$consulta["examenTejidoOdontologicos"]["decoloracion"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Descalcificación: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["descalcificacion"] !== null ? self::$consulta["examenTejidoOdontologicos"]["descalcificacion"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Facetas de desgaste: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["facetas_desgaste"] !== null ? self::$consulta["examenTejidoOdontologicos"]["facetas_desgaste"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Atrición: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["atricion"] !== null ? self::$consulta["examenTejidoOdontologicos"]["atricion"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Abrasión, abfracción y/o erosión: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["abrasion"] !== null ? self::$consulta["examenTejidoOdontologicos"]["abrasion"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Fluorosis: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["fluorosis"] !== null ? self::$consulta["examenTejidoOdontologicos"]["fluorosis"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Prótesis fija: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["protesis_fija"] !== null ? self::$consulta["examenTejidoOdontologicos"]["protesis_fija"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Prótesis removible: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["protesis_removible"] !== null ? self::$consulta["examenTejidoOdontologicos"]["protesis_removible"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Prótesis total: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["protesis_total"] !== null ? self::$consulta["examenTejidoOdontologicos"]["protesis_total"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Implantes dentales: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["implantes_dentales"] !== null ? self::$consulta["examenTejidoOdontologicos"]["implantes_dentales"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Aparatología ortopédica u ortodoncia: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["aparatologia_ortopedica"] !== null ? self::$consulta["examenTejidoOdontologicos"]["aparatologia_ortopedica"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('ALTERACIONES PERIODONTALES'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Inflamación: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["inflamacion"] !== null ? self::$consulta["examenTejidoOdontologicos"]["inflamacion"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Sangrado: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["sangrado"] !== null ? self::$consulta["examenTejidoOdontologicos"]["sangrado"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Exudado: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["exudado"] !== null ? self::$consulta["examenTejidoOdontologicos"]["exudado"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Supuración: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["supuracion"] !== null ? self::$consulta["examenTejidoOdontologicos"]["supuracion"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Placa blanda: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["placa_blanda"] !== null ? self::$consulta["examenTejidoOdontologicos"]["placa_blanda"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Placa calcificada: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["placa_calcificada"] !== null ? self::$consulta["examenTejidoOdontologicos"]["placa_calcificada"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Retracciones: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["retracciones"] !== null ? self::$consulta["examenTejidoOdontologicos"]["retracciones"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Presencia de bolsas: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["presencia_bolsas"] !== null ? self::$consulta["examenTejidoOdontologicos"]["presencia_bolsas"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Cuellos sensibles: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["cuellos_sensibles"] !== null ? self::$consulta["examenTejidoOdontologicos"]["cuellos_sensibles"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Movilidad: " . utf8_decode(self::$consulta["examenTejidoOdontologicos"] !== null ? self::$consulta["examenTejidoOdontologicos"]["movilidad"] !== null ? self::$consulta["examenTejidoOdontologicos"]["movilidad"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('PARACLINICOS'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            if (count(self::$consulta["paraclinicosOdontologicos"]) > 0) {
                foreach (self::$consulta["paraclinicosOdontologicos"] as $odontograma) {
                    $textoOdontograma = "Laboratorio: " . utf8_decode($odontograma->laboratorio) . ", Lectura Radiografica: " . utf8_decode($odontograma->lectura_radiografica) .
                        ", otros: " . utf8_decode($odontograma->oclusal ? $odontograma->otros : 'No Refiere');
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, utf8_decode($textoOdontograma), 1, 'L');
                }
            } else {
                $textoOdontograma = utf8_decode('No Refiere');
                $pdf->SetX(12);
                $pdf->MultiCell(186, 4, utf8_decode($textoOdontograma), 1, 'L');
            }

            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('DIAGNÓSTICOS'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('DIAGNÓSTICO PRINCIPAL'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);

            // Obtener el primer diagnóstico como principal
            $diagnosticoPrincipal = self::$consulta->cie10Afiliado->first();
            $codigoCie10 = isset($diagnosticoPrincipal->cie10->codigo_cie10) ? $diagnosticoPrincipal->cie10->codigo_cie10 : '';
            $descripcionDiagnostico = isset($diagnosticoPrincipal->cie10->nombre) ? $diagnosticoPrincipal->cie10->nombre : '';
            $tipoDiagnostico = isset($diagnosticoPrincipal->tipo_diagnostico) ? $diagnosticoPrincipal->tipo_diagnostico : '';

            $textoDXprincipal = "CODIGO CIE10: " . utf8_decode($codigoCie10) .
                ", DESCRIPCION DEL DIAGNOSTICO: " . utf8_decode($descripcionDiagnostico) .
                ", TIPO DEL DIAGNOSTICO: " . utf8_decode($tipoDiagnostico);

            $pdf->SetX(12);
            $pdf->MultiCell(186, 4, $textoDXprincipal, 1, "L", 0);
            // Filtrar diagnósticos secundarios
            $diagnosticosSecundarios = self::$consulta->cie10Afiliado->slice(1);
            if ($diagnosticosSecundarios->isNotEmpty()) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFillColor(214, 214, 214);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(186, 4, utf8_decode('DIAGNÓSTICOS SECUNDARIOS'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 8);

                foreach ($diagnosticosSecundarios as $diagnostico) {
                    $codigoCie10 = isset($diagnostico->cie10->codigo_cie10) ? $diagnostico->cie10->codigo_cie10 : '';
                    $descripcion = isset($diagnostico->cie10->nombre) ? $diagnostico->cie10->nombre : '';
                    $tipoDiagnostico = isset($diagnostico->tipo_diagnostico) ? $diagnostico->tipo_diagnostico : '';

                    $textoDXSecundario = "CODIGO CIE10: " . utf8_decode($codigoCie10) .
                        ", DESCRIPCION DEL DIAGNOSTICO: " . utf8_decode($descripcion) .
                        ", TIPO DEL DIAGNOSTICO: " . utf8_decode($tipoDiagnostico);

                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, $textoDXSecundario, 1, "L", 0);
                }
                $pdf->Ln();
            }

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('PLAN DE TRATAMIENTO'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Operatoria: " . utf8_decode(self::$consulta["planTramientoOdontologia"] !== null ? self::$consulta["planTramientoOdontologia"]["operatoria"] !== null ? self::$consulta["planTramientoOdontologia"]["operatoria"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Periodancia: " . utf8_decode(self::$consulta["planTramientoOdontologia"] !== null ? self::$consulta["planTramientoOdontologia"]["periodancia"] !== null ? self::$consulta["planTramientoOdontologia"]["periodancia"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Endodoncia: " . utf8_decode(self::$consulta["planTramientoOdontologia"] !== null ? self::$consulta["planTramientoOdontologia"]["endodoncia"] !== null ? self::$consulta["planTramientoOdontologia"]["endodoncia"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Cirugia oral: " . utf8_decode(self::$consulta["planTramientoOdontologia"] !== null ? self::$consulta["planTramientoOdontologia"]["cirugia_oral"] !== null ? self::$consulta["planTramientoOdontologia"]["cirugia_oral"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Remision: " . utf8_decode(self::$consulta["planTramientoOdontologia"] !== null ? self::$consulta["planTramientoOdontologia"]["remision"] !== null ? self::$consulta["planTramientoOdontologia"]["remision"] : 'No' : 'No')), 1, 'L', 0);
            $pdf->Ln();


            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('PROMOCIÓN Y PREVENCIÓN'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Educacion higiene oral: " . utf8_decode(self::$consulta["planTramientoOdontologia"] !== null ? self::$consulta["planTramientoOdontologia"]["educacion_higiene_oral"] !== null ? self::$consulta["planTramientoOdontologia"]["educacion_higiene_oral"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Control de placa: " . utf8_decode(self::$consulta["planTramientoOdontologia"] !== null ? self::$consulta["planTramientoOdontologia"]["control_de_placa"] !== null ? self::$consulta["planTramientoOdontologia"]["control_de_placa"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Profilaxis: " . utf8_decode(self::$consulta["planTramientoOdontologia"] !== null ? self::$consulta["planTramientoOdontologia"]["profilaxis"] !== null ? self::$consulta["planTramientoOdontologia"]["profilaxis"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Detrartraje: " . utf8_decode(self::$consulta["planTramientoOdontologia"] !== null ? self::$consulta["planTramientoOdontologia"]["detrartraje"] !== null ? self::$consulta["planTramientoOdontologia"]["detrartraje"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Topización barniz de fluor: " . utf8_decode(self::$consulta["planTramientoOdontologia"] !== null ? self::$consulta["planTramientoOdontologia"]["topizacion_barniz_fluor"] !== null ? self::$consulta["planTramientoOdontologia"]["topizacion_barniz_fluor"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Sellantes: " . utf8_decode(self::$consulta["planTramientoOdontologia"] !== null ? self::$consulta["planTramientoOdontologia"]["sellantes"] !== null ? self::$consulta["planTramientoOdontologia"]["sellantes"] : 'No' : 'No')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Remision RIAS: " . utf8_decode(self::$consulta["planTramientoOdontologia"] !== null ? self::$consulta["planTramientoOdontologia"]["remision_rias"] !== null ? self::$consulta["planTramientoOdontologia"]["remision_rias"] : 'No' : 'No')), 1, 'L', 0);
            $pdf->Ln();
        }

        if (
            isset(self::$consulta["cita"]["tipo_historia_id"]) &&
            (self::$consulta["cita"]["tipo_historia_id"] == 1 ||
                self::$consulta["cita"]["tipo_historia_id"] == 3)
        ) {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('MEDIDAS ANTROPOMETICAS'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(23, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["peso"]) && self::$consulta["HistoriaClinica"]["peso"] !== null ? "Peso: " . self::$consulta["HistoriaClinica"]["peso"] . " kg" : "Peso: 0"), 1, 0, 'L', 0);
            $pdf->Cell(23, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["talla"]) && self::$consulta["HistoriaClinica"]["talla"] !== null ? "Talla: " . self::$consulta["HistoriaClinica"]["talla"] . " CM" : "Talla: 0"), 1, 0, 'L', 0);
            $pdf->Cell(70, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["imc"]) && self::$consulta["HistoriaClinica"]["imc"] !== null ? "Índice de masa corporal: " . self::$consulta["HistoriaClinica"]["imc"] : "Índice de masa corporal: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Cell(70, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["isc"]) && self::$consulta["HistoriaClinica"]["isc"] !== null ? "Índice de superficie corporal: " . self::$consulta["HistoriaClinica"]["isc"] : "Índice de superficie corporal: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["clasificacion"]) && self::$consulta["HistoriaClinica"]["clasificacion"] !== null ? "Clasificación: " . self::$consulta["HistoriaClinica"]["clasificacion"] : "Clasificación: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["perimetro_abdominal"]) && self::$consulta["HistoriaClinica"]["perimetro_abdominal"] !== null ? "Perímetro abdominal: " . self::$consulta["HistoriaClinica"]["perimetro_abdominal"] : "Perímetro abdominal: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["perimetro_cefalico"]) && self::$consulta["HistoriaClinica"]["perimetro_cefalico"] !== null ? "Perímetro cefálico: " . self::$consulta["HistoriaClinica"]["perimetro_cefalico"] : "Perímetro cefálico: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Ln();


            if (self::$consulta["ciclo_vida_atencion"] == '1ra Infancia') {
                $pdf->SetX(12);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["peso_talla"] == null ? "Peso para la talla: " . 'No Evaluado' : "Peso para la talla: " . self::$consulta["HistoriaClinica"]["peso_talla"]), 1, 0, 'l', 0);
                $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["clasificacion_peso_talla"] == null ? "Clasificación peso para la talla: " . 'No Evaluado' : "Clasificación peso para la talla: " . self::$consulta["HistoriaClinica"]["clasificacion_peso_talla"]), 1, 0, 'l', 0);
                $pdf->Ln();

                $pdf->SetX(12);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["cefalico_edad"] == null ? "Perímetro cefálico para la edad: " . 'No Evaluado' : "Perímetro cefálico para la edad: " . self::$consulta["HistoriaClinica"]["cefalico_edad"]), 1, 0, 'l', 0);
                $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClincia"]["clasificacion_cefalico_edad"] == null ? "Clasificación perímetro cefálico para la edad: " . 'No Evaluado' : "Clasificación perímetro cefálico para la edad: " . self::$consulta["HistoriaClinica"]["clasificacion_cefalico_edad"]), 1, 0, 'l', 0);
                $pdf->Ln();

                $pdf->SetX(12);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["imc_edad"] == null ? "IMC para la edad: " . 'No Evaluado' : "IMC para la edad: " . self::$consulta["HistoriaClinica"]["imc_edad"]), 1, 0, 'l', 0);
                $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["clasificacion_imc_edad"] == null ? "Clasificación IMC para la edad: " . 'No Evaluado' : "Clasificación IMC para la edad: " . self::$consulta["HistoriaClinica"]["clasificacion_imc_edad"]), 1, 0, 'l', 0);
                $pdf->Ln();

                $pdf->SetX(12);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["peso_edad"] == null ? "Peso para la edad: " . 'No Evaluado' : "Peso para la edad: " . self::$consulta["HistoriaClinica"]["peso_edad"]), 1, 0, 'l', 0);
                $pdf->Cell(93, 4, utf8_decode(self::$consulta["clasificacion_peso_edad"] == null ? "Clasificación peso para la edad: " . 'No Evaluado' : "Clasificación peso para la edad: " . self::$consulta["clasificacion_peso_edad"]), 1, 0, 'l', 0);
                $pdf->Ln();
            }

            if (self::$consulta["ciclo_vida_atencion"] == '1ra Infancia' || self::$consulta["ciclo_vida_atencion"] == 'Infancia' || self::$consulta["ciclo_vida_atencion"] == 'Adolescencia') {
                $pdf->SetX(12);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["talla_edad"] == null ? "Talla para la edad: " . 'No Evaluado' : "Talla para la edad: " . self::$consulta["HistoriaClinica"]["talla_edad"]), 1, 0, 'l', 0);
                $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["clasificacion_talla_edad"] == null ? "Clasificación talla para la edad: " . 'No Evaluado' : "Clasificación talla para la edad: " . self::$consulta["HistoriaClinica"]["clasificacion_talla_edad"]), 1, 0, 'l', 0);
                $pdf->Ln();
            }

            if (self::$consulta["ciclo_vida_atencion"] == '1ra Infancia' || self::$consulta["ciclo_vida_atencion"] == 'Infancia' || self::$consulta["ciclo_vida_atencion"] == 'Vejez') {
                $pdf->SetX(12);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["circunferencia_brazo"] == null ? "Circunferencia brazo: " . 'No Evaluado' : "Circunferencia brazo: " . self::$consulta["HistoriaClinica"]["circunferencia_brazo"]), 1, 0, 'l', 0);
                $pdf->Cell(93, 4, utf8_decode(self::$consulta["HistoriaClinica"]["circunferencia_pantorrilla"] == null ? "Circunferencia pantorrilla: " . 'No Evaluado' : "Circunferencia pantorrilla: " . self::$consulta["HistoriaClinica"]["circunferencia_pantorrilla"]), 1, 0, 'l', 0);
                $pdf->Ln();
            }

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('SIGNOS VITALES'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(93, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["posicion"]) && self::$consulta["HistoriaClinica"]["posicion"] !== null ? "Posición: " . self::$consulta["HistoriaClinica"]["posicion"] : "Posición: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Cell(93, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["lateralidad"]) && self::$consulta["HistoriaClinica"]["lateralidad"] !== null ? "Lateralidad: " . self::$consulta["HistoriaClinica"]["lateralidad"] : "Lateralidad: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["presion_sistolica"]) && self::$consulta["HistoriaClinica"]["presion_sistolica"] !== null ? "Presión sistólica: " . self::$consulta["HistoriaClinica"]["presion_sistolica"] : "Presión sistólica: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["presion_diastolica"]) && self::$consulta["HistoriaClinica"]["presion_diastolica"] !== null ? "Presión Diastólica: " . self::$consulta["HistoriaClinica"]["presion_diastolica"] : "Presión Diastólica: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["presion_arterial_media"]) && self::$consulta["HistoriaClinica"]["presion_arterial_media"] !== null ? "Presión arterial media: " . self::$consulta["HistoriaClinica"]["presion_arterial_media"] : "Presión arterial media: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["frecuencia_cardiaca"]) && self::$consulta["HistoriaClinica"]["frecuencia_cardiaca"] !== null ? "Frecuencia cardiaca: " . self::$consulta["HistoriaClinica"]["frecuencia_cardiaca"] : "Frecuencia cardiaca: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["pulsos"]) && self::$consulta["HistoriaClinica"]["pulsos"] !== null ? "Pulsos: " . self::$consulta["HistoriaClinica"]["pulsos"] : "Pulsos: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["frecuencia_respiratoria"]) && self::$consulta["HistoriaClinica"]["frecuencia_respiratoria"] !== null ? "Frecuencia Respiratoria: " . self::$consulta["HistoriaClinica"]["frecuencia_respiratoria"] : "Frecuencia Respiratoria: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["temperatura"]) && self::$consulta["HistoriaClinica"]["temperatura"] !== null ? "Temperatura: " . self::$consulta["HistoriaClinica"]["temperatura"] : "Temperatura: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["saturacion_oxigeno"]) && self::$consulta["HistoriaClinica"]["saturacion_oxigeno"] !== null ? "Saturación de oxígeno: " . self::$consulta["HistoriaClinica"]["saturacion_oxigeno"] : "Saturación de oxígeno: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Cell(62, 4, utf8_decode(isset(self::$consulta["HistoriaClinica"]["fio"]) && self::$consulta["HistoriaClinica"]["fio"] !== null ? "Fracción inspiratoria de oxígeno: " . self::$consulta["HistoriaClinica"]["fio"] : "Fracción inspiratoria de oxígeno: No Evaluado"), 1, 0, 'L', 0);
            $pdf->Ln();
            $pdf->Ln();
        }

        if (
            isset(self::$consulta["cita"]["tipo_historia_id"]) &&
            (self::$consulta["cita"]["tipo_historia_id"] == 1 ||
                self::$consulta["cita"]["tipo_historia_id"] == 5 ||
                self::$consulta["cita"]["tipo_historia_id"] == 6 ||
                self::$consulta["cita"]["tipo_historia_id"] == 10 ||
                self::$consulta["cita"]["tipo_historia_id"] == 12 ||
                self::$consulta["cita"]["tipo_historia_id"] == 13)
        ) {
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('EXAMEN FÍSICO'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Aspecto General: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["aspecto_general"]) && self::$consulta["HistoriaClinica"]["aspecto_general"] !== null ? self::$consulta["HistoriaClinica"]["aspecto_general"] : (self::$consulta["HistoriaClinica"]["condicion_general"] !== null ? self::$consulta["HistoriaClinica"]["condicion_general"] : 'No Evaluado')), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Cabeza: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["cabeza"]) && self::$consulta["HistoriaClinica"]["cabeza"] !== null ? self::$consulta["HistoriaClinica"]["cabeza"] : 'No Evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Cara: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["cara"]) && self::$consulta["HistoriaClinica"]["cara"] !== null ? self::$consulta["HistoriaClinica"]["cara"] : 'No Evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Ojos: " . utf8_decode(isset(self::$consulta["HistoriaClinica"]["ojos"]) && self::$consulta["HistoriaClinica"]["ojos"] !== null ? self::$consulta["HistoriaClinica"]["ojos"] : 'No Evaluado'), 1, 'L', 0);

            if (isset(self::$consulta["HistoriaClinica"]["ciclo_vida_atencion"]) && (self::$consulta["HistoriaClinica"]["ciclo_vida_atencion"] == '1ra Infancia' || self::$consulta["HistoriaClinica"]["ciclo_vida_atencion"] == 'Infancia')) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Preocupaciones de los cuidadores sobre problemas visuales del niño: " . utf8_decode(self::$consulta["HistoriaClinica"]["visual_nino"] ?? 'No Evaluado'), 1, 'L', 0);
            }

            $detalles = [
                "Agudeza visual ambos ojos" => "agudeza_visual_ambos",
                "Conjuntiva" => "conjuntiva",
                "Esclera" => "esclera",
                "Fondo de ojos (Descripcion de camara anterior)" => "ojos_fondo_ojos_ant",
                "Fondo de ojos (Descripcion de camara posterior)" => "ojos_fondo_ojos_post",
                "Nariz" => "nariz",
                "Tabique" => "tabique",
                "Cornetes" => "cornetes",
                "Oidos" => "oidos",
                "Tiene usted o ha tenido algún problema en el oído" => "problema_oido",
                "Usted cree que escucha bien" => "escucha_bien",
                "Descripción pabellón auricular derecho" => "auricular_der",
                "Descripción pabellón auricular izquierdo" => "auricular_izq",
                "Conducto auditivo derecho" => "conducto_der",
                "Membrana timpánica" => "membrana_tim",
                "Integra" => "integra",
                "Perforación" => "perforacion",
                "Presencia de tubos de ventilación" => "tubos_ven",
                "Maxilar" => "maxilar",
                "Labios y Comisura labial" => "labios_comisura",
                "Mejilla y carrillos" => "mejilla_carrillo",
                "Cavidad oral" => "cavidad_oral",
                "Articulación Temporomandibular" => "articulacion_temporo",
                "Estructuras dentales" => "estructuras_dentales",
                "Cuello" => "cuello",
                "Tórax" => "torax",
                "Mamas" => "mamas",
                "Pectorales" => "pectorales",
                "Reja costal anterior" => "reja_costal",
                "Reja costal posterior" => "reja_costal_pos",
                "Desviaciones de la columna" => "desv_col",
                "Pulmones" => "pulmones",
                "Cardíacos" => "cardiacos",
                "Abdomen" => "abdomen"
            ];

            foreach ($detalles as $detalleAmigable => $detalleDB) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, utf8_decode($detalleAmigable) . ": " . utf8_decode(self::$consulta["HistoriaClinica"][$detalleDB] ?? 'No Evaluado'), 1, 'L', 0);
            }

            if (self::$consulta["afiliado"]["sexo"] == 'M') {

                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFillColor(214, 214, 214);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(186, 4, utf8_decode('GENITO URINARIO'), 1, 0, 'C', 1);
                $pdf->Ln();

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Masculino: " . utf8_decode(self::$consulta["HistoriaClinica"]["masculino"] ?? 'No Evaluado'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Presencia de alteraciones en genitales internos: " . utf8_decode(self::$consulta["HistoriaClinica"]["alteraciones_genitales"] ?? 'No Evaluado'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Presencia de alteraciones en genitales externos: " . utf8_decode(self::$consulta["HistoriaClinica"]["alteraciones_genitales_externos"] ?? 'No Evaluado'), 1, 'L', 0);

                if (isset(self::$consulta["HistoriaClinica"]["ciclo_vida_atencion"]) && (self::$consulta["HistoriaClinica"]["ciclo_vida_atencion"] == 'Adolescencia' || self::$consulta["HistoriaClinica"]["ciclo_vida_atencion"] == 'Infancia')) {
                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(186, 4, "Clasifiacion de tanner vello pubico: " . utf8_decode(self::$consulta["HistoriaClinica"]["tanner_vello"] ?? 'No Evaluado'), 1, 'L', 0);
                }

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, utf8_decode("Testículos: ") . utf8_decode(self::$consulta["HistoriaClinica"]["testiculos"] ?? 'No Evaluado'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Escroto: " . utf8_decode(self::$consulta["HistoriaClinica"]["escroto"] ?? 'No Evaluado'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Prepucio: " . utf8_decode(self::$consulta["HistoriaClinica"]["prepucio"] ?? 'No Evaluado'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, utf8_decode("Cordón Espermático: ") . utf8_decode(self::$consulta["HistoriaClinica"]["cordon"] ?? 'No Evaluado'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Tacto rectal: " . utf8_decode(self::$consulta["HistoriaClinica"]["tacto_rectal_hom"] ?? 'No Evaluado'), 1, 'L', 0);

                if (isset(self::$consulta["HistoriaClinica"]["ciclo_vida_atencion"]) && (self::$consulta["HistoriaClinica"]["ciclo_vida_atencion"] == 'Adolescencia' || self::$consulta["HistoriaClinica"]["ciclo_vida_atencion"] == 'Infancia')) {
                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(186, 4, utf8_decode("Clasificación de tanner genitales masculinos: ") . utf8_decode(self::$consulta["HistoriaClinica"]["tanner_masculino"] ?? 'No Evaluado'), 1, 'L', 0);
                }
            }

            if (self::$consulta["afiliado"]["sexo"] == 'F') {
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFillColor(214, 214, 214);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(186, 4, utf8_decode('GENITO URINARIO'), 1, 0, 'C', 1);
                $pdf->Ln();

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Femenino: " . (isset(self::$consulta["HistoriaClinica"]["femenino"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["femenino"]) : 'No Evaluado'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Presencia de alteraciones en genitales internos: " . (isset(self::$consulta["HistoriaClinica"]["alteraciones_genitales"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["alteraciones_genitales"]) : 'No Evaluado'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Presencia de alteraciones en genitales externos: " . (isset(self::$consulta["alteracionesGenitalesExternos"]) ? utf8_decode(self::$consulta["alteracionesGenitalesExternos"]) : 'No Evaluado'), 1, 'L', 0);

                if (isset(self::$consulta["ciclo_vida_atencion"]) && (self::$consulta["ciclo_vida_atencion"] == 'Adolescencia' || self::$consulta["ciclo_vida_atencion"] == 'Infancia')) {
                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(186, 4, "Clasificacion de tanner vello pubico: " . (isset(self::$consulta["HistoriaClinica"]["tanner_vello"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["tanner_vello"]) : 'No Evaluado'), 1, 'L', 0);
                }

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Especuloscopia: " . (isset(self::$consulta["HistoriaClinica"]["especuloscopia"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["especuloscopia"]) : 'No Evaluado'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Tacto Vaginal: " . (isset(self::$consulta["HistoriaClinica"]["tacto_vag"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["tacto_vag"]) : 'No Evaluado'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Sangrado uterino: " . (isset(self::$consulta["HistoriaClinica"]["sangrado_uterino"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["sangrado_uterino"]) : 'No Evaluado'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Tacto rectal: " . (isset(self::$consulta["HistoriaClinica"]["tactorec_fem"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["tactorec_fem"]) : 'No Evaluado'), 1, 'L', 0);

                if (isset(self::$consulta["ciclo_vida_atencion"]) && (self::$consulta["ciclo_vida_atencion"] == 'Adolescencia' || self::$consulta["ciclo_vida_atencion"] == 'Infancia')) {
                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(186, 4, "Clasificacion de tenner mamas y pubis femenino: " . (isset(self::$consulta["HistoriaClinica"]["tanner_femenino"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["tanner_femenino"]) : 'No Evaluado'), 1, 'L', 0);
                }
            }

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Desgarro del perine: " . (isset(self::$consulta["HistoriaClinica"]["desgarro_perine"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["desgarro_perine"]) : 'No Evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Episiorrafia: " . (isset(self::$consulta["HistoriaClinica"]["episiorragia"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["episiorragia"]) : 'No Evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Extremidades: " . (isset(self::$consulta["HistoriaClinica"]["extremidades"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["extremidades"]) : 'No Evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Sistema nervioso central: " . (isset(self::$consulta["HistoriaClinica"]["sistema_nervioso"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["sistema_nervioso"]) : 'No Evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Evaluacion pares craneales: " . (isset(self::$consulta["HistoriaClinica"]["pares_craneales"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["pares_craneales"]) : 'No Evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Evaluacion marcha: " . (isset(self::$consulta["HistoriaClinica"]["evaluacion_marcha"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["evaluacion_marcha"]) : 'No Evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Evaluacion tono muscular: " . (isset(self::$consulta["HistoriaClinica"]["evaluacion_tono_muscular"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["evaluacion_tono_muscular"]) : 'No Evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Evaluacion fuerza: " . (isset(self::$consulta["HistoriaClinica"]["evaluacion_fuerza"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["evaluacion_fuerza"]) : 'No Evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Piel y faneras: " . (isset(self::$consulta["HistoriaClinica"]["piel_faneras"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["piel_faneras"]) : 'No Evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Descripción sistema osteomuscular: ") . (isset(self::$consulta["HistoriaClinica"]["sistema_osteo"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["sistema_osteo"]) : 'No Evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Columna vertebral: " . (isset(self::$consulta["HistoriaClinica"]["columna_vertebral"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["columna_vertebral"]) : 'No Evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Examen Mental: " . (isset(self::$consulta["HistoriaClinica"]["examen_mental"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["examen_mental"]) : 'No Evaluado'), 1, 'L', 0);

            if (self::$consulta["ciclo_vida_atencion"] == '1ra Infancia' || self::$consulta["ciclo_vida_atencion"] == 'Infancia') {
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFillColor(214, 214, 214);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(186, 4, utf8_decode('VALORACIÓN DEL DESARROLLO'), 1, 0, 'C', 1);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Motricidad gruesa: " . (isset(self::$consulta["HistoriaClinica"]["motricidad_gruesa"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["motricidad_gruesa"]) : 'No Refiere'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Motricidad fina: " . (isset(self::$consulta["HistoriaClinica"]["motricidad_fina"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["motricidad_fina"]) : 'NORMAL'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Audición y lenguaje: " . (isset(self::$consulta["HistoriaClinica"]["audicion_lenguaje"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["audicion_lenguaje"]) : 'NORMAL'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Personal-social: " . (isset(self::$consulta["HistoriaClinica"]["personal_social"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["personal_social"]) : 'NORMAL'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Percepción de los cuidadores del desarrollo del niño: " . (isset(self::$consulta["HistoriaClinica"]["cuidado"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["cuidado"]) : 'NORMAL'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Resultado escala abreviada del desarrollo: " . (isset(self::$consulta["HistoriaClinica"]["escala_desarrollo"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["escala_desarrollo"]) : 'NORMAL'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Resultado test tamizaje de autismo: " . (isset(self::$consulta["HistoriaClinica"]["autismo"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["autismo"]) : 'NORMAL'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Demuestran que sus actividades tienen un propósito: " . (isset(self::$consulta["HistoriaClinica"]["actividades"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["actividades"]) : 'NORMAL'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Ejercen autocontrol: " . (isset(self::$consulta["HistoriaClinica"]["autocontrol"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["autocontrol"]) : 'NORMAL'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Exhiben comportamientos fiables, consistentes y pensados: " . (isset(self::$consulta["HistoriaClinica"]["comportamientos"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["comportamientos"]) : 'NORMAL'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Expresan autoeficacia positiva: " . (isset(self::$consulta["HistoriaClinica"]["auto_eficacia"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["auto_eficacia"]) : 'NORMAL'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Demuestran independencia: " . (isset(self::$consulta["HistoriaClinica"]["independencia"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["independencia"]) : 'NORMAL'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Demuestran capacidad de resolución de problemas: " . (isset(self::$consulta["HistoriaClinica"]["actividades_proposito"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["actividades_proposito"]) : 'NORMAL'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Exhiben un foco de control interno: " . (isset(self::$consulta["HistoriaClinica"]["actividades_proposito"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["actividades_proposito"]) : 'NORMAL'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Funciones ejecutivas: " . (isset(self::$consulta["HistoriaClinica"]["funciones_ejecutivas"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["funciones_ejecutivas"]) : 'NORMAL'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Identidad: " . (isset(self::$consulta["HistoriaClinica"]["Identidad"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["Identidad"]) : 'NORMAL'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Resultado de instrumento valoración de la identidad: " . (isset(self::$consulta["HistoriaClinica"]["valoracion_identidad"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["valoracion_identidad"]) : 'NORMAL'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Autonomía: " . (isset(self::$consulta["HistoriaClinica"]["autonomia"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["autonomia"]) : 'NORMAL'), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Resultado de instrumento valoración de la autonomía: " . (isset(self::$consulta["HistoriaClinica"]["valoracion_autonomia"]) ? utf8_decode(self::$consulta["HistoriaClinica"]["valoracion_autonomia"]) : 'NORMAL'), 1, 'L', 0);
            }

            if (self::$consulta["ciclo_vida_atencion"] == 'Adolescencia') {
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFillColor(214, 214, 214);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(186, 4, utf8_decode('VALORACIÓN DEL DESARROLLO'), 1, 0, 'C', 1);
                $pdf->Ln();

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Percepcion de los cuidadores del desarrollo del nino: " . utf8_decode(self::$consulta["HistoriaClinica"]["cuidado"] == null ? 'NORMAL' : self::$consulta["HistoriaClinica"]["cuidado"]), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Resultado escala abreviada del desarrollo: " . utf8_decode(self::$consulta["HistoriaClinica"]["escala_desarrollo"] == null ? 'NORMAL' : self::$consulta["HistoriaClinica"]["escala_desarrollo"]), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Resultado test tamizaje de autismo: " . utf8_decode(self::$consulta["HistoriaClinica"]["autismo"] == null ? 'NORMAL' : self::$consulta["HistoriaClinica"]["autismo"]), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Demuestran que sus actividades tienen un proposito: " . utf8_decode(self::$consulta["HistoriaClinica"]["actividades"] == null ? 'NORMAL' : self::$consulta["HistoriaClinica"]["actividades"]), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Ejercen autocontrol: " . utf8_decode(self::$consulta["HistoriaClinica"]["autocontrol"] == null ? 'NORMAL' : self::$consulta["HistoriaClinica"]["autocontrol"]), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Exhiben comportamientos fiables, consistentes y pensados :" . utf8_decode(self::$consulta["HistoriaClinica"]["comportamientos"] == null ? 'NORMAL' : self::$consulta["HistoriaClinica"]["comportamientos"]), 1, 'L', 0);
                $y2 = $pdf->GetY();

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Expresan autoeficacia positiva: " . utf8_decode(self::$consulta["HistoriaClinica"]["auto_eficacia"] == null ? 'NORMAL' : self::$consulta["HistoriaClinica"]["auto_eficacia"]), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Demuestran independencia: " . utf8_decode(self::$consulta["HistoriaClinica"]["independencia"] == null ? 'NORMAL' : self::$consulta["HistoriaClinica"]["independencia"]), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "demuestran capacidad de resolución de problemas: " . utf8_decode(self::$consulta["HistoriaClinica"]["actividades_proposito"] == null ? 'NORMAL' : self::$consulta["HistoriaClinica"]["actividades_proposito"]), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Exhiben un locus de control interno: " . utf8_decode(self::$consulta["HistoriaClinica"]["actividades_proposito"] == null ? 'NORMAL' : self::$consulta["HistoriaClinica"]["actividades_proposito"]), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Funciones ejecutivas: " . utf8_decode(self::$consulta["HistoriaClinica"]["funciones_ejecutivas"] == null ? 'NORMAL' : self::$consulta["HistoriaClinica"]["funciones_ejecutivas"]), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Identidad: " . utf8_decode(self::$consulta["HistoriaClinica"]["identidad"] == null ? 'NORMAL' : self::$consulta["HistoriaClinica"]["identidad"]), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Resultado de instrumento valoracion de la identidad: " . utf8_decode(self::$consulta["HistoriaClinica"]["valoracion_identidad"] == null ? 'NORMAL' : self::$consulta["HistoriaClinica"]["valoracion_identidad"]), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Autonomia: " . utf8_decode(self::$consulta["HistoriaClinica"]["autonomia"] == null ? 'NORMAL' : self::$consulta["HistoriaClinica"]["autonomia"]), 1, 'L', 0);

                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $pdf->MultiCell(186, 4, "Resultado de instrumento valoracion de la autonomia: " . utf8_decode(self::$consulta["HistoriaClinica"]["valoracion_autonomia"] == null ? 'NORMAL' : self::$consulta["HistoriaClinica"]["valoracion_autonomia"]), 1, 'L', 0);
            }

            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('VALORACIÓN SALUD AUDITIVA Y COMUNICATIVA'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Funciones de la articulación, voz y habla: ") . utf8_decode(self::$consulta["HistoriaClinica"]["funciones"] ?? 'No evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Desempeño comunicativo: ") . utf8_decode(self::$consulta["HistoriaClinica"]["desempenio_comunicativo"] ?? 'No evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Resultado cuestionario: " . utf8_decode(self::$consulta["HistoriaClinica"]["resultado_vale"] ?? 'No evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, utf8_decode("Lista de chequeo de factores de riesgo de las enfermedades del oído: ") . utf8_decode(self::$consulta["HistoriaClinica"]["factores_oido"] ?? 'No evaluado'), 1, 'L', 0);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('VALORACIÓN SALUD MENTAL'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Violencia: " . utf8_decode(self::$consulta["HistoriaClinica"]["violencia_mental"] ?? 'No evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Violencia conflicto armado: " . utf8_decode(self::$consulta["HistoriaClinica"]["violencia_conflicto"] ?? 'No evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Violencia sexual: " . utf8_decode(self::$consulta["HistoriaClinica"]["violencia_sexual"] ?? 'No evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Tamizaje Reporting Questionnaire for Children (RQC) riesgos mentales en niños: " . utf8_decode(self::$consulta["HistoriaClinica"]["riesgos_mentales_ninos"] ?? 'No evaluado'), 1, 'L', 0);

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(186, 4, "Lesiones autoinflingidas: " . utf8_decode(self::$consulta["HistoriaClinica"]["lesiones_auto_inflingidas"] ?? 'No evaluado'), 1, 'L', 0);
            $pdf->Ln();
        }

        if (isset(self::$consulta["cita"]["tipo_historia_id"]) && self::$consulta["cita"]["tipo_historia_id"] == 14) {


            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('ADHERENCIA FARMACOTERAPEUTICA'), 1, 0, 'C', 1);
            $pdf->Ln();
            $y = $pdf->GetY();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->MultiCell(186, 4, utf8_decode("¿TOMA SIEMPRE LA MEDICACIÓN A LA HORA INDICADA?:") . utf8_decode(self::$consulta["adherenciaFarmaceutica"]["hora_indicada"] ?? 'No Aplica'), 1, 'L', 0);
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->MultiCell(186, 4, utf8_decode("¿EN CASO DE SENTIRSE MAL HA DEJADO DE TOMAR LA MEDICACIÓN ALGUNA VEZ?:") . utf8_decode(self::$consulta["adherenciaFarmaceutica"]["dejado_medicamento"] ?? 'No Aplica'), 1, 'L', 0);
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->MultiCell(186, 4, utf8_decode("EN ALGUNA OCASIÓN ¿SE HA OLVIDADO DE TOMAR LA MEDICACIÓN?:") . utf8_decode(self::$consulta["adherenciaFarmaceutica"]["dejado_medicamento"] ?? 'No Aplica'), 1, 'L', 0);
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->MultiCell(186, 4, utf8_decode("DURANTE EL FIN DE SEMANA ¿SE HA OLVIDADO DE ALGUNA TOMA DE MEDICACIÓN?:") . utf8_decode(self::$consulta["adherenciaFarmaceutica"]["finsemana_olvidomedicamento"] ?? 'No Aplica'), 1, 'L', 0);
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->MultiCell(186, 4, utf8_decode("EN LA ÚLTIMA SEMANA ¿CÚANTAS VECES NO TOMÓ ALGUNA DOSIS?: ") . utf8_decode(self::$consulta["adherenciaFarmaceutica"]["finsemana_notomomedicamento"] ?? 'No Aplica'), 1, 'L', 0);
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->MultiCell(186, 4, utf8_decode("DESDE LA ÚLTIMA VISITA ¿CÚANTAS DÍAS COMPLETOS NO TOMÓ LA MEDICACIÓN?:") . utf8_decode(self::$consulta["adherenciaFarmaceutica"]["dias_notomomedicamento"] ?? 'No Aplica'), 1, 'L', 0);
            $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
            $y = $pdf->GetY();

            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('PORCENTAJE DE ADHERENCIA'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->MultiCell(186, 4, utf8_decode("PORCENTAJE:  ") . utf8_decode(self::$consulta["adherenciaFarmaceutica"]["porcentaje"] ?? 'No Aplica'), 1, 'L', 0);
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->MultiCell(186, 4, utf8_decode("ADHERENCIA CRITERIO DEL QUIMICO:  ") . utf8_decode(self::$consulta["adherenciaFarmaceutica"]["criterio_quimico"] ?? 'No Aplica'), 1, 'L', 0);

            $pdf->Ln();


            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('PERFIL FARMACOTERAPEUTICO'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('Otro problema'), 1, 0, 'C', 1);
            $pdf->Ln();

            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(186, 4, utf8_decode('No aplica'), 1, 'L', 0);
        }


        if (
            isset(self::$consulta["cita"]["tipo_historia_id"]) &&
            (self::$consulta["cita"]["tipo_historia_id"] == 1 ||
                self::$consulta["cita"]["tipo_historia_id"] == 3 ||
                self::$consulta["cita"]["tipo_historia_id"] == 4 ||
                self::$consulta["cita"]["tipo_historia_id"] == 5 ||
                self::$consulta["cita"]["tipo_historia_id"] == 11 ||
                self::$consulta["cita"]["tipo_historia_id"] == 15 ||
                self::$consulta["cita"]["tipo_historia_id"] == 12 ||
                self::$consulta["cita"]["tipo_historia_id"] == 13 || self::$consulta["cita"]["tipo_historia_id"] == 14)
        ) {
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('DIAGNÓSTICOS'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode('DIAGNÓSTICO PRINCIPAL'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFont('Arial', '', 8);

            // Obtener el primer diagnóstico como principal
            $diagnosticoPrincipal = self::$consulta->cie10Afiliado->first();
            $codigoCie10 = isset($diagnosticoPrincipal->cie10->codigo_cie10) ? $diagnosticoPrincipal->cie10->codigo_cie10 : '';
            $descripcionDiagnostico = isset($diagnosticoPrincipal->cie10->nombre) ? $diagnosticoPrincipal->cie10->nombre : '';
            $tipoDiagnostico = isset($diagnosticoPrincipal->tipo_diagnostico) ? $diagnosticoPrincipal->tipo_diagnostico : '';

            $textoDXprincipal = "CODIGO CIE10: " . utf8_decode($codigoCie10) .
                ", DESCRIPCION DEL DIAGNOSTICO: " . utf8_decode($descripcionDiagnostico) .
                ", TIPO DEL DIAGNOSTICO: " . utf8_decode($tipoDiagnostico);

            $pdf->SetX(12);
            $pdf->MultiCell(186, 4, $textoDXprincipal, 1, "L", 0);
            // Filtrar diagnósticos secundarios
            $diagnosticosSecundarios = self::$consulta->cie10Afiliado->slice(1);
            if ($diagnosticosSecundarios->isNotEmpty()) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFillColor(214, 214, 214);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(186, 4, utf8_decode('DIAGNÓSTICOS SECUNDARIOS'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 8);

                foreach ($diagnosticosSecundarios as $diagnostico) {
                    $codigoCie10 = isset($diagnostico->cie10->codigo_cie10) ? $diagnostico->cie10->codigo_cie10 : '';
                    $descripcion = isset($diagnostico->cie10->nombre) ? $diagnostico->cie10->nombre : '';
                    $tipoDiagnostico = isset($diagnostico->tipo_diagnostico) ? $diagnostico->tipo_diagnostico : '';

                    $textoDXSecundario = "CODIGO CIE10: " . utf8_decode($codigoCie10) .
                        ", DESCRIPCION DEL DIAGNOSTICO: " . utf8_decode($descripcion) .
                        ", TIPO DEL DIAGNOSTICO: " . utf8_decode($tipoDiagnostico);

                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, $textoDXSecundario, 1, "L", 0);
                }
                $pdf->Ln();
            }
        }

        if (
            isset(self::$consulta["cita"]["tipo_historia_id"]) &&
            (self::$consulta["cita"]["tipo_historia_id"] == 1 ||
                self::$consulta["cita"]["tipo_historia_id"] == 10)
        ) {
            # Plan de cuidado
            if (count(self::$consulta["planCuidado"])) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(186, 4, utf8_decode('PLAN DE CUIDADO'), 1, 0, 'C', 1);
                $pdf->Ln();
                $y = $pdf->GetY();
                $pdf->SetX(12);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFillColor(214, 214, 214);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 9);

                $planCuidado = self::$consulta->planCuidado;
                if (!is_null($planCuidado) && count($planCuidado) > 0) {
                    foreach ($planCuidado as $plan) {
                        $fechaRegistro = isset($plan->created_at) ? substr($plan->created_at, 0, 10) : 'No Aplica';
                        $medico = utf8_decode(self::$consulta["medicoOrdena"]["operador"]["nombre"]) . " " . utf8_decode(self::$consulta["medicoOrdena"]["operador"]["apellido"]);
                        $planYcuidado = isset($plan->plan) ? $plan->plan : 'No Aplica';
                        $aplica = isset($plan->tipo) ? $plan->tipo : 'No Aplica';

                        $textoAntecedentes = "FECHA REGISTRO: " . utf8_decode($fechaRegistro) .
                            ", MEDICO: " . utf8_decode($medico) .
                            ", PLAN Y CUIDADO: " . utf8_decode($planYcuidado) .
                            ", APLICA: " . utf8_decode($aplica);
                        $pdf->SetX(12);
                        $pdf->MultiCell(186, 4, $textoAntecedentes, 1, "L", 0);
                    }
                } else {
                    $textoAntecedentes = "FECHA REGISTRO: " . utf8_decode('No Aplica') .
                        ", MEDICO: " . utf8_decode('No Aplica') .
                        ", PLAN Y CUIDADO: " . utf8_decode('No Aplica') .
                        ", APLICA: " . utf8_decode('No Aplica');
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, $textoAntecedentes, 1, "L", 0);
                }
            }
            $pdf->Ln();


            # Plan de cuidado
            if (count(self::$consulta["informacionSalud"])) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(186, 4, utf8_decode('INFORMACION SALUD'), 1, 0, 'C', 1);
                $pdf->Ln();
                $y = $pdf->GetY();
                $pdf->SetX(12);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFillColor(214, 214, 214);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetFont('Arial', '', 9);

                $informacionSalud = self::$consulta->informacionSalud;
                if (!is_null($informacionSalud) && count($informacionSalud) > 0) {
                    foreach ($informacionSalud as $infoSalud) {
                        $fechaRegistro = isset($infoSalud->created_at) ? substr($infoSalud->created_at, 0, 10) : 'No Aplica';
                        $medico = utf8_decode(self::$consulta["medicoOrdena"]["operador"]["nombre"]) . " " . utf8_decode(self::$consulta["medicoOrdena"]["operador"]["apellido"]);
                        $info = isset($infoSalud->informacion) ? $infoSalud->informacion : 'No Aplica';
                        $aplica = isset($infoSalud->tipo) ? $infoSalud->tipo : 'No Aplica';

                        $textoAntecedentes = "FECHA REGISTRO: " . utf8_decode($fechaRegistro) .
                            ", MEDICO: " . utf8_decode($medico) .
                            ", INFORMACION SALUD: " . utf8_decode($info) .
                            ", APLICA: " . utf8_decode($aplica);
                        $pdf->SetX(12);
                        $pdf->MultiCell(186, 4, $textoAntecedentes, 1, "L", 0);
                    }
                } else {
                    $textoAntecedentes = "FECHA REGISTRO: " . utf8_decode('No Aplica') .
                        ", MEDICO: " . utf8_decode('No Aplica') .
                        ", INFORMACION SALUD: " . utf8_decode('No Aplica') .
                        ", APLICA: " . utf8_decode('No Aplica');
                    $pdf->SetX(12);
                    $pdf->MultiCell(186, 4, $textoAntecedentes, 1, "L", 0);
                }
            }
            $pdf->Ln();

            if (self::$consulta["ciclo_vida_atencion"] == '1ra Infancia') {
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->Cell(186, 4, utf8_decode('PRÁCTICAS DE CRIANZA Y CUIDADO'), 1, 0, 'C', 1);
                $pdf->Ln();
                $y = $pdf->GetY();

                $pdf->SetX(12);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFillColor(214, 214, 214);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(40, 4, utf8_decode('FECHA REGISTRO'), 1, 0, 'C', 1);
                $pdf->Cell(44, 4, utf8_decode('MÉDICO'), 1, 0, 'C', 1);
                $pdf->Cell(65, 4, utf8_decode('PRÁCTICA CUIDADO'), 1, 0, 'C', 1);
                $pdf->Cell(37, 4, utf8_decode('APLICA'), 1, 0, 'C', 1);
                $pdf->Ln();

                $pdf->SetTextColor(0, 0, 0);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);
                $y10 = $pdf->GetY();
                $y = $pdf->GetY();
                if (count(self::$consulta["PracticaCrianza"]) > 0) {
                    foreach (self::$consulta["PracticaCrianza"] as $crianza) {
                        $medico = utf8_decode(self::$consulta["medicoOrdena"]["operador"]["nombre"]) . " " . utf8_decode(self::$consulta["medicoOrdena"]["operador"]["apellido"]);

                        $pdf->SetXY(12, $y);
                        $pdf->MultiCell(40, 4, utf8_decode($crianza->created_at), 0, 'C');
                        $y1 = $pdf->GetY();
                        $pdf->SetXY(52, $y);
                        $pdf->MultiCell(44, 4, utf8_decode($crianza->medico), 0, 'C');
                        $y2 = $pdf->GetY();
                        $pdf->SetXY(96, $y);
                        $pdf->MultiCell(65, 4, utf8_decode($crianza->practica), 0, 'C');
                        $y3 = $pdf->GetY();
                        $pdf->SetXY(161, $y);
                        $pdf->Cell(37, 4, utf8_decode($crianza->tipo), 0, 0, 'C', 0);
                        $y4 = $pdf->GetY();
                        $conteo = max($y1, $y2, $y3, $y4);
                        $pdf->Line(12, $conteo, 198, $conteo);
                        $pdf->Line(12, $y, 12, $conteo);
                        $pdf->Line(198, $y, 198, $conteo);
                        $pdf->Line(52, $y, 52, $conteo);
                        $pdf->Line(96, $y, 96, $conteo);
                        $pdf->Line(161, $y, 161, $conteo);

                        $y = $conteo;
                    }
                    $y = $pdf->GetY();
                    $pdf->Ln();
                } else {
                    $pdf->SetXY(12, $y);
                    $pdf->MultiCell(40, 4, utf8_decode('No aplica'), 0, 'C');
                    $y1 = $pdf->GetY();
                    $pdf->SetXY(52, $y);
                    $pdf->MultiCell(44, 4, utf8_decode('No aplica'), 0, 'C');
                    $y2 = $pdf->GetY();
                    $pdf->SetXY(96, $y);
                    $pdf->MultiCell(65, 4, utf8_decode('No aplica'), 0, 'C');
                    $y3 = $pdf->GetY();
                    $pdf->SetXY(161, $y);
                    $pdf->Cell(37, 4, utf8_decode('No aplica'), 0, 0, 'C', 0);
                    $y4 = $pdf->GetY();

                    $conteo = max($y1, $y2, $y3, $y4);

                    #cuadrado
                    $pdf->Line(12, $conteo, 198, $conteo);
                    $pdf->Line(12, $y, 12, $conteo);
                    $pdf->Line(198, $y, 198, $conteo);
                    #lineas verticales
                    $pdf->Line(52, $y, 52, $conteo);
                    $pdf->Line(96, $y, 96, $conteo);
                    $pdf->Line(161, $y, 161, $conteo);

                    $y = $conteo;
                    $y = $pdf->GetY();
                    $pdf->Ln();
                }
            }
        }

        //proxima consulta
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('PROXIMA CONSULTA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y = $pdf->GetY();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 9);
        $pdf->MultiCell(186, 4, utf8_decode("Fecha próxima consulta: ") . utf8_decode(self::$consulta["HistoriaClinica"]["proximo_control"] ?? 'No Aplica'), 1, 'L', 0);
        $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
        $y = $pdf->GetY();

        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0, 0, 0);
        $pdf->Cell(186, 4, utf8_decode('CONDUCTA'), 1, 0, 'C', 1);
        $pdf->Ln();
        $y = $pdf->GetY();



        // Verificar el valor de tipo_historia_id
        if (isset(self::$consulta["cita"]["tipo_historia_id"]) && !in_array(self::$consulta["cita"]["tipo_historia_id"], [16, 17, 18])) {
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->Cell(186, 4, utf8_decode("PLAN DE MANEJO:"), 0, 0, 'L', 0);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);

            $planManejo = isset(self::$consulta["HistoriaClinica"]["plan_manejo"]) ? self::$consulta["HistoriaClinica"]["plan_manejo"] : 'No Aplica';
            $pdf->SetX(12);
            $pdf->MultiCell(186, 4, utf8_decode($planManejo), 0, 'L');
            $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
            $y = $pdf->GetY();

            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode("RECOMENDACIONES:"), 0, 0, 'L', 0);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);

            $recomendaciones = isset(self::$consulta["HistoriaClinica"]["recomendaciones"]) ? self::$consulta["HistoriaClinica"]["recomendaciones"] : 'No Aplica';
            $pdf->SetX(12);
            $pdf->MultiCell(186, 4, utf8_decode($recomendaciones), 0, 'L');
            $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
            $y = $pdf->GetY();
        }

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode("DESTINO DEL PACIENTE:"), 0, 0, 'L', 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);

        $destino = isset(self::$consulta["HistoriaClinica"]["destino_paciente"]) ? self::$consulta["HistoriaClinica"]["destino_paciente"] : 'No Aplica';
        $pdf->SetX(12);
        $pdf->MultiCell(186, 4, utf8_decode($destino), 0, 'L');
        $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
        $y = $pdf->GetY();

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetX(12);
        $pdf->Cell(186, 4, utf8_decode("FINALIDAD:"), 0, 0, 'L', 0);
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', '', 8);

        $nota_evolucion = isset(self::$consulta["HistoriaClinica"]["finalidad"]) ? self::$consulta["HistoriaClinica"]["finalidad"] : 'No Aplica';
        $pdf->SetX(12);
        $pdf->MultiCell(186, 4, utf8_decode($nota_evolucion), 0, 'L');
        $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
        $y = $pdf->GetY();

        if (
            isset(self::$consulta["cita"]["tipo_historia_id"]) &&
            (self::$consulta["cita"]["tipo_historia_id"] == 16 ||
                self::$consulta["cita"]["tipo_historia_id"] == 17 ||
                self::$consulta["cita"]["tipo_historia_id"] == 18)
        ) {
            $pdf->SetFont('Arial', 'B', 8);
            $pdf->SetX(12);
            $pdf->Cell(186, 4, utf8_decode("Nota de evolución:"), 0, 0, 'L', 0);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);

            $nota_evolucion = isset(self::$consulta["HistoriaClinica"]["nota_evolucion"]) ? self::$consulta["HistoriaClinica"]["nota_evolucion"] : 'No Aplica';
            $pdf->SetX(12);
            $pdf->MultiCell(186, 4, utf8_decode($nota_evolucion), 0, 'L');
            $pdf->Line(12, $pdf->GetY(), 198, $pdf->GetY());
            $y = $pdf->GetY();
        }


        ///////////////////////////////////////////////////// PROCEDIMIENTO REALIZADO ///////////////////////////////////////////////
        if (isset(self::$consulta["cita"]["tipo_historia_id"]) && in_array(self::$consulta["cita"]["tipo_historia_id"], [17, 18])) {
            $pdf->SetXY(12, $y + 6);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('PROCEDIMIENTO REALIZADO'), 1, 0, 'C', 1);
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', '', 8);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(255, 255, 255);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->MultiCell(186, 4, utf8_decode(self::$consulta["HistoriaClinica"]["procedimiento_realizado_odontologia"]), 1, 0, 'L');
            $pdf->Ln();

            if (isset(self::$consulta["cita"]["tipo_historia_id"]) && in_array(self::$consulta["cita"]["tipo_historia_id"], [18])) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 9);
                $pdf->SetDrawColor(0, 0, 0);
                $pdf->SetFillColor(214, 214, 214);
                $pdf->SetTextColor(0, 0, 0);
                $pdf->Cell(186, 4, utf8_decode('PACIENTE CONTROLADO'), 1, 0, 'C', 1);
                $pdf->Ln();
                $pdf->SetX(12);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(46.5, 4, utf8_decode('SI'), 1, 0, 'C');

                // Verificar si el campo es true o false y dibujar la X en la celda correspondiente
                $pdf->SetX(58.5);
                $pdf->SetFont('Arial', '', 8);
                if (self::$consulta["HistoriaClinica"]["paciente_controlado_odontologia"] == true) {
                    $pdf->Cell(46.5, 4, 'X', 1, 0, 'C');
                } else {
                    $pdf->Cell(46.5, 4, '', 1, 0, 'C');
                }

                $pdf->SetX(105);
                $pdf->SetFont('Arial', 'B', 8);
                $pdf->Cell(46.5, 4, utf8_decode('NO'), 1, 0, 'C');

                $pdf->SetX(151.5);
                $pdf->SetFont('Arial', '', 8);
                if (self::$consulta["HistoriaClinica"]["paciente_controlado_odontologia"] == false) {
                    $pdf->Cell(46.5, 4, 'X', 1, 0, 'C');
                } else {
                    $pdf->Cell(46.5, 4, '', 1, 0, 'C');
                }

                $pdf->Ln();
                $y = $pdf->GetY();
            }
        }



        $pdf->Ln();
        $pdf->Cell(56, 11, "", 0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(12);
        $pdf->Cell(60, 4, utf8_decode('ATENDIDO POR: ' . (isset(self::$consulta["medicoOrdena"]["operador"]["nombre_completo"]) ? self::$consulta["medicoOrdena"]["operador"]["nombre_completo"] : 'No disponible')), 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $especialidad = isset(self::$consulta["medicoOrdena"]["especialidades"]) && count(self::$consulta["medicoOrdena"]["especialidades"]) > 0
            ? self::$consulta["medicoOrdena"]["especialidades"][0]["nombre"]
            : 'No disponible';

        $pdf->Cell(60, 4, utf8_decode('ESPECIALIDAD: ' . $especialidad), 0, 0, 'L');
        $pdf->Ln();
        $pdf->SetX(12);
        $pdf->Cell(32, 4, utf8_decode('REGISTRO: ' . (isset(self::$consulta["medicoOrdena"]["operador"]["registro_medico"]) ? self::$consulta["medicoOrdena"]["operador"]["registro_medico"] : self::$consulta["medicoOrdena"]["operador"]["documento"])), 0, 0, 'L');
        $pdf->Cell(56, 11, "", 0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->SetX(125);

        $yDinamica = $pdf->GetY();

        if (isset(self::$consulta["medicoOrdena"]["firma"])) {
            if (file_exists(storage_path(substr(self::$consulta["medicoOrdena"]["firma"], 9)))) {
                $pdf->Image(storage_path(substr(self::$consulta["medicoOrdena"]["firma"], 9)), 125, $yDinamica, 56, 11);
            }
        }
        $pdf->Ln();
        $notaAclaratoria = isset(self::$consulta["HistoriaClinica"]["NotaAclaratoria"]) ? self::$consulta["HistoriaClinica"]["NotaAclaratoria"] : null;
        if ($notaAclaratoria && count($notaAclaratoria) > 0) {
            $pdf->Ln();
            $pdf->SetX(12);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0, 0, 0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0, 0, 0);
            $pdf->Cell(186, 4, utf8_decode('NOTAS ACLARATORIAS'), 1, 0, 'C', 1);
            $pdf->Ln();

            foreach ($notaAclaratoria as $index => $nota) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 9);
                $pdf->MultiCell(186, 4, utf8_decode('Nota ' . ($index + 1) . ': ' . $nota->descripcion), 1, 'L', 0);
            }
        }

        // Verificar si hay órdenes en la consulta
        if (self::$consulta->ordenes->isNotEmpty()) {
            // Iterar sobre las órdenes
            foreach (self::$consulta->ordenes as $orden) {
                $pdf->SetX(12);
                $pdf->SetFont('Arial', '', 8);

                // Mostrar el ID de la orden


                // Iterar sobre los procedimientos de cada orden
                foreach ($orden->procedimientos as $procedimiento) {
                    $estadoProcedimiento = $procedimiento->estado ? $procedimiento->estado->nombre : 'No asociado';
                    $cupNombre = $procedimiento->cup ? $procedimiento->cup->nombre : 'No asociado';
                    $cupCodigo = $procedimiento->cup ? $procedimiento->cup->codigo : 'No asociado';
                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', '', 8);

                    // Mostrar el estado y el código del procedimiento y el nombre
                    $pdf->Cell(62, 4, utf8_decode('Orden#: ' . $orden->id . ' | Código: ' . $cupCodigo), 1, 0, 'L');
                    $pdf->SetX(12 + 62);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(124, 4, utf8_decode('Nombre del Procedimiento: ' . $cupNombre), 1, 'L');
                    $pdf->Ln();
                }

                // Iterar sobre los medicamentos de cada orden
                foreach ($orden->articulos as $articulo) {
                    $estadoArticulo = $articulo->estado ? $articulo->estado->nombre : 'No asociado';
                    $codesumiNombre = $articulo->codesumi ? $articulo->codesumi->nombre : 'No asociado';
                    $codesumiCodigo = $articulo->codesumi ? $articulo->codesumi->codigo : 'No asociado';

                    $pdf->SetX(12);
                    $pdf->SetFont('Arial', '', 8);

                    // Mostrar el estado, el código y el nombre del codesumi
                    $pdf->Cell(62, 4, utf8_decode('Orden#: ' . $orden->id . ' | Código: ' . $codesumiCodigo), 1, 0, 'L');
                    $pdf->SetX(12 + 62);
                    $pdf->SetFont('Arial', '', 8);
                    $pdf->MultiCell(124, 4, utf8_decode('Nombre del Medicamento: ' . $codesumiNombre), 1, 'L');
                    $pdf->Ln();
                }
            }
        }
    }
    function Footer()
    {
        // Posición a 1.5 cm del final
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        // Número de página
        $this->Cell(0, 10, 'Pagina ' . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }
}
