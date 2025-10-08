<?php

namespace App\Formats;

use App\Http\Modules\DetalleSolicitudBodegas\Models\DetalleSolicitudBodega;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Traits\PdfTrait;
use Codedge\Fpdf\Fpdf\Fpdf;

use Illuminate\Support\Facades\DB;

class ActaRecepcion extends FPDF
{
    use PdfTrait;

    public static $ordenesCompra;

    public function generar($actaRecepcion)
    {
        self::$ordenesCompra = $actaRecepcion->toArray();
        $this->generarPDF('I');
    }


    public function Header()
    {

        $this->SetXY(0, 15.6);
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(297, 6.6, utf8_decode('ACTA DE RECEPCIÓN TÉCNICA'), 0, 0, 'C');
        $logo = public_path() . "/images/logoEcoimagen.png";
        $this->Image($logo, 55, 7, -350);
        $this->Line(0, 30, 297, 30);
        $this->SetXY(60, 31);
        $this->SetFont('Arial', '', 10);
        $this->Cell(60, 6, utf8_decode('Fecha de ingreso: ' . self::$ordenesCompra[0]["FECHA DE RECEPCION"]), 0, 0, 'L');
        $this->Cell(140, 6, utf8_decode('Página ') . $this->PageNo() . '/{nb}', 0, 0, 'R');
        $this->SetFillColor(216, 216, 216);
        $this->SetXY(0, 40);
        $this->Cell(297, 20, '', 1, 0, 'R', 1);
        $this->SetXY(0, 40);
        $x = 0;
        $this->Line(0, 40, 297, 40);
        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(216, 216, 216);
        $this->MultiCell(15, 4, utf8_decode('FECHA DE RECEPCION'), 0, 'C', 1);
        $this->SetXY($x = $x + 15, 40);
        $this->MultiCell(15, 4, utf8_decode('NUMERO DE FACTURA'), 0, 'C', 1);
        $this->SetXY($x = $x + 15, 40);
        $this->MultiCell(16, 4, utf8_decode('PROVEEDOR'), 0, 'C', 1);
        $this->SetXY($x = $x + 16, 40);
        $this->MultiCell(15, 4, utf8_decode('FECHA FACTURA'), 0, 'C', 1);
        $this->SetXY($x = $x + 15, 40);
        $this->MultiCell(20, 4, utf8_decode('DESCRIPCION'), 0, 'C', 1);
        $this->SetXY($x = $x + 19, 40);
        $this->MultiCell(20, 4, utf8_decode('DESCRIPCION COMERCIAL'), 0, 'C', 1);
        $this->SetXY($x = $x + 20, 40);
        $this->MultiCell(20, 4, utf8_decode('LABORATORIO'), 0, 'C', 1);
        $this->SetXY($x = $x + 19, 40);
        $this->MultiCell(15, 4, utf8_decode('REGISTRO SANITARIO'), 0, 'C', 1);
        $this->SetXY($x = $x + 16, 40);
        $this->MultiCell(15, 4, utf8_decode('T °C'), 0, 'C', 1);
        $this->SetXY($x = $x + 17, 40);
        $this->MultiCell(20, 4, utf8_decode('PRESENTACION'), 0, 'C', 1);
        $this->SetXY($x = $x + 20, 40);
        $this->MultiCell(20, 4, utf8_decode('FORMA FARMACEUTICA'), 0, 'C', 1);
        $this->SetXY($x = $x + 20, 40);
        $this->MultiCell(15, 4, utf8_decode('LOTE'), 0, 'C', 1);
        $this->SetXY($x = $x + 15, 40);
        $this->MultiCell(20, 4, utf8_decode('FECHA VENCIMIENTO'), 0, 'C', 1);
        $this->SetXY($x = $x + 20, 40);
        $this->MultiCell(15, 4, utf8_decode('CANTIDAD'), 0, 'C', 1);
        $this->SetXY($x = $x + 15, 40);
        $this->MultiCell(20, 4, utf8_decode('NUMERO EXPEDIENTE'), 0, 'C', 1);
        $this->SetXY($x = $x + 20, 40);
        $this->MultiCell(15, 4, utf8_decode('ALMACEN'), 0, 'C', 1);
        $this->SetXY($x = $x + 15, 40);
        $this->Cell(10, 4, utf8_decode('OBSERVACIONES'), 0, 'C', 1);
    }

    public function body()
    {

        $final = 0;
        $y = 60;
        $this->SetFont('Arial', '', 6);
        foreach (self::$ordenesCompra as $articulo) {
            if ($final > 348) {
                $x2 = 0;
                for ($i = 0; $i <= 15; $i++) {
                    $this->Line($x2, 5, $x2, $final);
                    if ($i == 2) {
                        $x2 = $x2 + 16;
                    } elseif ($i == 6) {
                        $x2 = $x2 + 18;
                    } elseif ($i == 8) {
                        $x2 = $x2 + 18;
                    } elseif ($i == 18) {
                        $x2 = $x2 + 18;
                    } elseif ($i == 16) {
                        $x2 = $x2 + 20;
                    } elseif ($i == 4) {
                        $x2 = $x2 + 20;
                    } elseif ($i == 5) {
                        $x2 = $x2 + 20;
                    } elseif ($i == 9) {
                        $x2 = $x2 + 20;
                    } elseif ($i == 10) {
                        $x2 = $x2 + 20;
                    } elseif ($i == 12) {
                        $x2 = $x2 + 20;
                    } elseif ($i == 14) {
                        $x2 = $x2 + 20;
                    } else {
                        $x2 = $x2 + 15;
                    }
                }
                $y = 60;
                $final = 0;
                $this->AddPage();
            }
            $this->SetXY(0, $y);
            $x = 0;
            $this->MultiCell(15, 4, utf8_decode($articulo["FECHA DE RECEPCION"]), 0, 'C', 0);
            $final = $this->GetY() > $final ? $this->GetY() : $final;
            $this->SetXY($x = $x + 15, $y);
            $this->MultiCell(15, 4, utf8_decode($articulo["NUMERO DE FACTURA"]), 0, 'C', 0);
            $final = $this->GetY() > $final ? $this->GetY() : $final;
            $this->SetXY($x = $x + 15, $y);
            $this->MultiCell(16, 4, utf8_decode($articulo["PROVEEDOR"]??$articulo["proveedor2"]), 0, 'C', 0);
            $final = $this->GetY() > $final ? $this->GetY() : $final;
            $this->SetXY($x = $x + 16, $y);
            $this->MultiCell(15, 4, utf8_decode($articulo["FECHA FACTURA"]), 0, 'C', 0);
            $final = $this->GetY() > $final ? $this->GetY() : $final;
            $this->SetXY($x = $x + 15, $y);
            $this->MultiCell(20, 4, utf8_decode($articulo["DESCRIPCION"]), 0, 'C', 0);
            $final = $this->GetY() > $final ? $this->GetY() : $final;
            $this->SetXY($x = $x + 20, $y);
            $this->MultiCell(20, 4, utf8_decode($articulo["DESCRIPCION COMERCIAL"]), 0, 'C', 0);
            $final = $this->GetY() > $final ? $this->GetY() : $final;
            $this->SetXY($x = $x + 20, $y);
            $this->MultiCell(18, 4, utf8_decode($articulo["LABORATORIO"]), 0, 'C', 0);
            $final = $this->GetY() > $final ? $this->GetY() : $final;
            $this->SetXY($x = $x + 18, $y);
            $this->MultiCell(15, 4, utf8_decode($articulo["REGISTRO SANITARIO"]), 0, 'C', 0);
            $final = $this->GetY() > $final ? $this->GetY() : $final;
            $this->SetXY($x = $x + 15, $y);
            $this->MultiCell(15, 4, utf8_decode(intval($articulo["temperatura"]) ? $articulo["temperatura"] : '' ), 0, 'C', 0);
            $final = $this->GetY() > $final ? $this->GetY() : $final;
            $this->SetXY($x = $x + 18, $y);
            $this->MultiCell(20, 4, utf8_decode($articulo["PRESENTACION"]), 0, 'C', 0);
            $final = $this->GetY() > $final ? $this->GetY() : $final;
            $this->SetXY($x = $x + 20, $y);
            $this->MultiCell(20, 4, utf8_decode($articulo["FORMA FARMACEUTICA"]), 0, 'C', 0);
            $final = $this->GetY() > $final ? $this->GetY() : $final;
            $this->SetXY($x = $x + 20, $y);
            $this->MultiCell(15, 4, utf8_decode($articulo["LOTE"]), 0, 'C', 0);
            $final = $this->GetY() > $final ? $this->GetY() : $final;
            $this->SetXY($x = $x + 15, $y);
            $this->MultiCell(20, 4, utf8_decode($articulo["FECHA VENCIMIENTO"]), 0, 'C', 0);
            $final = $this->GetY() > $final ? $this->GetY() : $final;
            $this->SetXY($x = $x + 20, $y);
            $this->MultiCell(15, 4, utf8_decode($articulo["CANTIDAD"]), 0, 'C', 0);
            $final = $this->GetY() > $final ? $this->GetY() : $final;
            $this->SetXY($x = $x + 15, $y);
            $this->MultiCell(20, 4, utf8_decode($articulo["NUMERO EXPEDIENTE"]), 0, 'C', 0);
            $final = $this->GetY() > $final ? $this->GetY() : $final;
            $this->SetXY($x = $x + 20, $y);
            $this->MultiCell(15, 4, utf8_decode($articulo["ALMACEN"]), 0, 'C', 0);
            $final = $this->GetY() > $final ? $this->GetY() : $final;
            $this->SetXY($x = $x + 15, $y);
            $this->MultiCell(20, 4, utf8_decode(isset($articulo["observaciones"]) ? $articulo["observaciones"] : '' ), 0, 'C', 0);
            $final = $this->GetY() > $final ? $this->GetY() : $final;

            $this->Line(0, $final, 297, $final);
            $y = $final;
        }
        $this->Line(15, 40, 15, $final);
        $x2 = 0;
        for ($i = 0; $i <= 17; $i++) {
            $this->Line($x2, 40, $x2, $final);
            if ($i == 2) {
                $x2 = $x2 + 16;
            } elseif ($i == 6) {
                $x2 = $x2 + 18;
            } elseif ($i == 8) {
                $x2 = $x2 + 18;
            } elseif ($i == 18) {
                $x2 = $x2 + 18;
            } elseif ($i == 16) {
                $x2 = $x2 + 20;
            } elseif ($i == 4) {
                $x2 = $x2 + 20;
            } elseif ($i == 5) {
                $x2 = $x2 + 20;
            } elseif ($i == 9) {
                $x2 = $x2 + 20;
            } elseif ($i == 10) {
                $x2 = $x2 + 20;
            } elseif ($i == 12) {
                $x2 = $x2 + 20;
            } elseif ($i == 14) {
                $x2 = $x2 + 20;
            } else {
                $x2 = $x2 + 15;
            }
        }
        $this->setY($final);
        $this->setX(0);
        $this->Cell(20, 4, utf8_decode('RESPONSABLE:'), 1, 0, 'C', 0);
        $operador = Operadore::where('user_id',self::$ordenesCompra[0]['user_id'])->first();
        $nombreApellido = utf8_decode($operador['nombre'].' '.$operador['apellido']);
        $this->Cell(30, 4, $nombreApellido, 1, 0, 'C', 0);
    }
}
