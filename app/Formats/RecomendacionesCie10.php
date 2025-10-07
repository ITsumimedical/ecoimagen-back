<?php

namespace App\Formats;

// use DNS1D;
// use DNS2D;
use Traversable;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;
// use Illuminate\Support\Facades\Auth;
// use App\Http\Modules\Usuarios\Models\User;
// use App\Http\Modules\Afiliados\Models\Afiliado;
// use App\Http\Modules\Consultas\Models\Consulta;
// use App\Http\Modules\Operadores\Models\Operadore;
// use App\Http\Modules\Historia\Models\HistoriaClinica;
use App\Traits\PdfTrait;

class RecomendacionesCie10 extends Fpdf
{
    use PdfTrait;

    public static $consulta;
    public static $recomendaciones;
    public static $funcionario;

    public function generar($recomendaciones)
    {
        self::$consulta = $recomendaciones->consulta;
        self::$funcionario = $recomendaciones->funcionario;

        self::$recomendaciones = self::$consulta->HistoriaClinica->recomendaciones ?? null;

        if (empty($recomendaciones) && self::$consulta->HistoriaClinica) {
            $recomendaciones = self::$consulta->historia->recomendaciones ?? '';
        }

        $this->generarPDF('I');
    }

    public function body()
    {
        // Encabezado con líneas divisorias
        $this->SetXY(10, 10);
        $this->SetFont('Arial', 'B', 9);

        $this->Cell(40, 25, '', 1, 0, 'C');
        $this->SetXY(10, 10);

        // Logo
        $logo = public_path() . "/images/logo.png";
        $this->Image($logo, 17, 13, -370);

        // Info SUMIMEDICAL
        $this->Cell(130, 25, '', 1, 0, 'C');
        $this->SetXY(40, 15);
        $this->SetFont('Arial', 'B', 10);
        $this->MultiCell(100, 5, utf8_decode("SUMIMEDICAL S.A.S\nNIT: 900033371\n" . (self::$consulta->rep->nombre ?? 'N/A')), 0, 'C');

        // Fecha y radicado con "Recomendaciones"
        $this->SetXY(140, 10);
        $this->Cell(60, 25, '', 1, 0, 'C');
        $this->SetXY(140, 12);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(60, 5, utf8_decode('Recomendaciones'), 0, 1, 'C');
        $this->SetXY(140, 16);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(60, 5, utf8_decode("Fecha: " . Carbon::now()->format('d/m/Y') . "\nConsulta N°: " . (self::$consulta->id ?? 'N/A')), 0, 'C');
        $this->SetXY(140, 25);
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(60, 5, utf8_decode("Entidad: " . self::$consulta->afiliado->entidad->nombre), 0, 'C');

        $this->Ln(10);

        // Tabla de datos del paciente
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(245, 245, 245);
        $this->SetTextColor(0, 0, 0);

        // Nombre del paciente e Identificación

        $this->MultiCell(190, 7, utf8_decode('Nombre del paciente: ' . $this->nombreCompleto(self::$consulta->afiliado)), 1, 0, 'L', true);
        $this->MultiCell(190, 7, utf8_decode('Identificación: ' . (self::$consulta->afiliado->numero_documento ?? 'N/A')), 1, 1, 'L', true);

        // Teléfono, Fecha de nacimiento y Edad
        $this->Cell(63, 7, utf8_decode('Teléfono: ' . (self::$consulta->afiliado->telefono ?? 'N/A')), 1, 0, 'L', true);
        $this->Cell(79, 7, utf8_decode('Fecha de nacimiento: ' . Carbon::parse(self::$consulta->afiliado->fecha_nacimiento)->translatedFormat('j \d\e F \d\e Y')), 1, 0, 'L', true);
        $this->Cell(48, 7, utf8_decode('Edad: ' . (self::$consulta->afiliado->edad_cumplida)), 1, 1, 'L', true);

        $this->Ln(5);

        // Plan de Manejo y Recomendaciones
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(230, 230, 230);
        $this->Cell(190, 7, utf8_decode('Recomendaciones'), 1, 1, 'C', true);

        $this->SetFont('Arial', '', 9);
        // $plan_manejo = utf8_decode(self::$historia->plan_manejo ?? 'Aún no se han registrado plan de manejo');
        $descripcion = !empty(self::$recomendaciones)
            ? (is_array(self::$recomendaciones) || self::$recomendaciones instanceof Traversable
                ? (implode("\n", array_map(function ($recomendacion) {
                    return $recomendacion['descripcion'];
                }, self::$recomendaciones)))
                : utf8_decode(self::$recomendaciones))
            : utf8_decode('Sin recomendaciones adicionales para el diagnóstico.');

        $contenido =  $descripcion;

        $this->MultiCell(190, 5, $contenido, 1, 'L');

        // Firma del médico
        $this->Ln(30);

                // dd((storage_path(substr(self::$consulta->medicoOrdena->firma, 9))));

        if (self::$consulta->medicoOrdena->firma && file_exists(storage_path(substr(self::$consulta->medicoOrdena->firma, 9)))) {
            $this->SetFont('Arial', 'I', 8);

            // tres columnas
            $columnWidth = 50;
            $xLeft = 10;
            $xCenter = 75;
            $xRight = 150;

            $imageY = $this->GetY();
            $this->Image(storage_path(substr(self::$consulta->medicoOrdena->firma, 9)), $xLeft, $imageY - 20, 50);

            // línea debajo de la imagen
            $this->SetY($imageY + 3);
            $this->SetLineWidth(0.5);
            $this->Line($xLeft, $this->GetY(), $xLeft + $columnWidth, $this->GetY());

            // nombre y número del médico
            $this->SetXY($xLeft, $this->GetY() + 5);
            $this->SetFont('Arial', '', 8);
            $this->Cell($columnWidth, 5, utf8_decode(self::$consulta->medicoOrdena->operador->nombre . ' ' . self::$consulta->medicoOrdena->operador->apellido), 0, 0, 'L');

            $this->SetXY($xLeft, $this->GetY() + 5);
            $this->Cell($columnWidth, 5, utf8_decode(self::$consulta->medicoOrdena->operador->tipo_doc . ' ' . self::$consulta->medicoOrdena->operador->documento), 0, 0, 'L');

            // eslogan
            $this->SetXY($xCenter, $imageY);
            $this->SetFont('Arial', 'I', 10);
            $this->MultiCell($columnWidth, 5, utf8_decode("¡Cuidamos tu salud,\ncuidamos tu vida!"), 0, 'C');

            $this->SetXY($xRight, $imageY);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell($columnWidth, 5, utf8_decode('Funcionario Imprime: ' . ($funcionario->nombre ?? '') . ' ' . ($funcionario->apellido ?? '')), 0, 0, 'R');

            // Fecha de impresión
            $this->SetXY($xRight, $this->GetY() + 5);
            $this->SetFont('Arial', '', 8);
            $this->Cell($columnWidth, 5, utf8_decode('Fecha de Impresión: ' . Carbon::now()->format('d/m/Y H:i')), 0, 0, 'R');
        }
    }

    private function nombreCompleto($afiliado)
    {
        return trim(
            ($afiliado->primer_apellido ?? '') . ' ' .
                ($afiliado->segundo_apellido ?? '') . ' ' .
                ($afiliado->primer_nombre ?? '') . ' ' .
                ($afiliado->segundo_nombre ?? '')
        ) ?: 'N/A';
    }
}
