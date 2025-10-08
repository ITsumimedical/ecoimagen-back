<?php

namespace App\Formats;

use App\Traits\PdfTrait;
use Codedge\Fpdf\Fpdf\Fpdf;


class RecomendacionesConsultas extends Fpdf
{
    use PdfTrait;

    protected static $consulta;

    public function generar($consulta)
    {
        self::$consulta = $consulta;
        $this->generarPDF('I');
    }

    public function header()
    {
        // Solo mostrar el encabezado en la primera página
        if ($this->PageNo() == 1) {
            $this->SetFont('Arial', 'I', 10);
            $Y = 15;
            $this->SetFont('Arial', 'B', 9);
            if (self::$consulta['afiliado']["entidad_id"] == 1) {
                $logo = public_path() . "/images/logoFomag.png";
            } else {
                $logo = public_path() . "/images/logoEcoimagen.png";
            }
            $this->Image($logo, 8, 7, -470);
            $this->Rect(5, 5, 30, 22);
            $this->Rect(35, 5, 60, 22);

            // Centrando verticalmente el contenido de SUMIMEDICAL S.A.S y NIT
            if (self::$consulta['afiliado']["entidad_id"] == 1) {
                $this->SetXY(35, 9);
                $this->Cell(60, 4, utf8_decode('Fondo Nacional de'), 0, 0, 'C');
                $this->SetXY(35, 12);
                $this->Cell(60, 4, utf8_decode('Prestaciones Sociales del Magisterio '), 0, 0, 'C');
                $this->SetXY(35, 15);
                $this->Cell(60, 4, utf8_decode('FOMAG  FIDUPREVISORA S.A'), 0, 0, 'C');
                $this->SetXY(35, $Y + 6);
                $this->Cell(60, 4, utf8_decode('NIT: 830.053.105-3 '), 0, 0, 'C');
                $this->SetXY(35, $Y + 4);
                $this->SetFont('Arial', 'B', 5);
            } else {
                $this->SetXY(35, 10);
                $this->Cell(60, 6, utf8_decode('SUMIMEDICAL S.A.S'), 0, 1, 'C');
                $this->SetXY(35, 16);
                $this->Cell(60, 6, utf8_decode('NIT: 900033371 Res: 004'), 0, 1, 'C');

                $this->SetFont('Arial', 'B', 5);
            }

            $Y = 12;
            $this->SetFont('Arial', 'B', 8);
            $this->Rect(95, 5, 70, 22);
            $this->SetXY(95, $Y);
            $fechaRecomendacion = self::$consulta['recomendacionConsulta']->first()->created_at ?? 'Fecha no disponible';
            $this->Cell(70, 0, utf8_decode('Fecha de orden: ' . $fechaRecomendacion), 0, 0, 'C');
            $this->SetXY(95, $Y + 3);
            $this->SetFont('Arial', 'B', 8);
            $ordenId = self::$consulta['ordenes']->first()->id ?? 'N/A';
            $this->Cell(70, 0, utf8_decode("Régimen: Especial / Número de Orden: " . $ordenId), 0, 0, 'C');

            $this->SetXY(98, $Y + 12);
            $this->SetFont('Arial', 'B', 8);
            if (self::$consulta['afiliado']["entidad_id"] == 3) {
                $this->Cell(70, 0, utf8_decode('Contrato Ferrocarriles'), 0, 0, 'C');
            }
            $this->Image($logo = public_path() . "/images/qrMedicamentos.jpeg", 170, 6, 30, 20);
            $this->Rect(165, 5, 38, 22);
            $this->SetFillColor(216, 216, 216);

            $this->SetFont('Arial', 'B', 8);
            $this->SetXY(5, 28);
            $this->Cell(98, 4, utf8_decode('Nombre Paciente'), 1, 0, 'C', 1);
            $this->Cell(10, 4, utf8_decode('Sexo'), 1, 0, 'C', 1);
            $this->Cell(60, 4, utf8_decode('Identificación'), 1, 0, 'C', 1);
            $this->Cell(10, 4, 'Edad', 1, 0, 'C', 1);
            $this->Cell(20, 4, 'Nacimiento', 1, 0, 'C', 1);
            $this->Ln();
            $this->SetX(5);
            $this->SetFont('Arial', '', 8);
            $this->Cell(98, 4, utf8_decode(self::$consulta["afiliado"]["nombre_completo"]), 1, 0, 'C');
            $this->SetFont('Arial', '', 7.5);
            $this->Cell(10, 4, utf8_decode(self::$consulta["afiliado"]["sexo"]), 1, 0, 'C');
            $this->Cell(60, 4, utf8_decode(self::$consulta["afiliado"]["tipoDocumento"]["sigla"] . " - " . self::$consulta["afiliado"]["numero_documento"]), 1, 0, 'C');
            $this->Cell(10, 4, self::$consulta["afiliado"]["edad_cumplida"], 1, 0, 'C');
            $this->Cell(20, 4, self::$consulta["afiliado"]["fecha_nacimiento"], 1, 0, 'C');
            $this->Ln();
            $this->SetX(5);
            $this->SetFont('Arial', '', 8);
            $this->Cell(198, 4, utf8_decode('IPS primaria: ' . self::$consulta["afiliado"]["ips"]["nombre"]), 1, 0, 'L');
            $this->Ln();
            $this->SetX(5);
            $this->SetFont('Arial', '', 8);
            $this->Cell(198, 4, utf8_decode('Dirección: ' . self::$consulta["afiliado"]["direccion_residencia_cargue"]), 1, 0, 'L');
            $this->Ln();

            $this->SetX(5);
            $this->Cell(65, 4, 'Telefono', 1, 0, 'C', 1);
            $this->Cell(75, 4, 'Correo', 1, 0, 'C', 1);
            $this->Cell(58, 4, 'Municipio', 1, 0, 'C', 1);
            $this->Ln();
            $this->SetX(5);
            $this->SetFont('Arial', '', 7.5);
            $this->Cell(65, 4, utf8_decode(self::$consulta["afiliado"]["telefono"]) . " - " . utf8_decode(self::$consulta["afiliado"]["celular1"]), 1, 0, 'C');
            $this->Cell(75, 4, utf8_decode(self::$consulta["afiliado"]["correo1"]), 1, 0, 'C');
            $this->Cell(58, 4, utf8_decode(self::$consulta["afiliado"]["departamento_atencion"]["nombre"] . "-" . self::$consulta["afiliado"]["municipio_atencion"]["nombre"]), 1, 0, 'C');
            $this->Ln();
        }
        $this->Ln();
        $this->Ln();
        $this->Ln();
    }


    public function body()
    {
        // Ajustar el margen inicial de la celda del título
        $this->SetX(5);  // Establecer el margen izquierdo

        // Configuración del título
        $this->SetFont('Arial', 'B', 9);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFillColor(214, 214, 214);
        $this->SetTextColor(0, 0, 0);

        $this->Cell(200, 6, utf8_decode('RECOMENDACIONES'), 1, 1, 'C', 1);

        $this->Ln(5);

        $recomendaciones = self::$consulta->recomendacionConsulta;

        if ($recomendaciones->isEmpty()) {
            return;
        }

        $this->SetFont('Arial', '', 10);
        foreach ($recomendaciones as $index => $recomendacion) {
            $this->SetX(5);
            $this->SetFont('Arial', 'B', 10);
            $this->Cell(10, 10, utf8_decode(($index + 1) . "."), 0, 0, 'L');

            $this->SetFont('Arial', '', 10);
            $this->MultiCell(190, 10, utf8_decode($recomendacion->recomendaciones), 1, 'L');

            $this->Ln(5);
        }
    }



}
