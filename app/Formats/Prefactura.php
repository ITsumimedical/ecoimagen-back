<?php

namespace App\Formats;


use App\Traits\PdfTrait;
use Codedge\Fpdf\Fpdf\Fpdf;


class Prefactura extends Fpdf
{
    use PdfTrait;
    protected static $data;
    protected static $valorTotal;

    public function generar($data)
    {
        self::$data = $data;
        self::$valorTotal = self::$data['valor_cup']* self::$data['cantidad_cup'];
        $this->generarPDF('I');
    }

    public function header()
    {
        $logo = public_path() . "/images/v-logo.png";
        $this->Image($logo, 10, 10, 30);

        // Encabezado
        $this->SetFont('Arial', 'B', 9);
        $this->MultiCell(0, 5, utf8_decode("SUMIMEDICAL SAS\nCodigo Habilitacion: 234567890\nDiagonal 75B # 2A - 120 OF 206\nTel: 3046502663\nNIT: 9000333714\nwww.sumimedical.com"), 0, 'C');
        $this->Ln(5);


        // Encabezado derecho
        $this->SetXY(145, 11);
        $this->SetFont('Arial', 'B', 7);
        $this->MultiCell(60, 4, utf8_decode("FACTURA ELECTRÓNICA DE VENTA\nNo. ESP 990000421\nFecha de Generación: 2025-04-14\nHora de Generación: 09:44:01\nFecha de Expedición: 2025-04-14\nHora de Expedición: 09:44:01\n\nPágina: 1 / 1"), 0, 'C');
        $this->Ln(2);
    }

    public function body()
    {
        $this->SetFont('Arial', 'B', 8);

        // CUADRO DATOS PACIENTE
        $this->SetTextColor(46,44,126);
        $this->Cell(190, 8, 'Cliente', 0, 1, 'L', 0);
        $this->SetTextColor(0);

        $this->SetFont('Arial', '', 7);

        $this->MultiCell(190, 5, utf8_decode("PIJAOS SALUD E.P.S.I. Nit: 809008362\nTipo Contrato: Evento                                                     Contrato:PROCEDIMIENTOS NO EMPAQUETADOS (73201288)        Nivel: NIVEL UNO\nEmail: facturaelectronica@pijaossalud.com.co\nTipo de Usuario: Subsidiado POS                        Tipo de Afiliación: NO APLICA\nPaciente: CC-5983178 JUAN VILLAREAL OSPINA                                                     No. Carné/Sisben:                           Edad: 75 AÑOS\nLiquidación No: 979270                                         Ingreso: 2025-04-07                       Egreso: 2025-04-07\nDirección: CR 9 N4- 140 SANTA BARBARA PURIFICACION TOLIMA                       Teléfono: 3134940693"), 1);

        $this->Ln(1);
        $this->SetTextColor(46,44,126);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(190, 6, utf8_decode("Referencia"), 0, 1);
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 7);

        $this->Cell(190, 6, utf8_decode("Periodo Facturado: 2025-04-07 AL 2025-04-07                           No Autorización: 68786                                                No Póliza: NA"), 1, 1);
        $this->Cell(190, 6, utf8_decode("Forma de Pago: Crédito                                                         Método de Pago: Transferencia Débito Bancaria"), 1, 1);
        $this->Ln(3);

        $this->SetFillColor(46,44,126);
        $this->SetTextColor(255,255,255);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(190,6,utf8_decode('Concepto'),1,1,1,1);

        $this->SetFont('Arial', '', 7);

        $this->SetTextColor(0);
        $this->MultiCell(190, 6, utf8_decode("Venta según liquidación No. 979270 del 2025-04-07. Admisión: 202504070123"), 1);
        $this->SetTextColor(0);
        $this->Ln(3);
        // TABLA DETALLE
        $this->SetFont('Arial', 'B', 7);
        $this->SetFillColor(46,44,126);
        $this->SetTextColor(255,255,255);
        $this->Cell(10, 7, 'Item', 1, 0, 'C', true);
        $this->Cell(16, 7, utf8_decode('Código'), 1, 0, 'C', true);
        $this->Cell(124, 7, 'Nombre', 1, 0, 'C', true);
        // $this->Cell(10, 7, 'Und', 1, 0, 'C', true);
        $this->Cell(8, 7, 'Cant.', 1, 0, 'C', true);
        $this->Cell(16, 7, 'Vr Unit.', 1, 0, 'C', true);
        $this->Cell(16, 7, 'Total', 1, 1, 'C', true);
        $this->SetTextColor(0);

        $this->SetFont('Arial', 'B', 7);
        $this->Cell(10, 7, '1', 1,0,'C');
        $this->Cell(16, 7, utf8_decode(self::$data['codigo_cup']), 1,0,'C');
        $this->Cell(124, 7, utf8_decode(self::$data['descripcion_cup']), 1);
        // $this->Cell(10, 7, '94', 1,0,'C');
        $this->Cell(8, 7, utf8_decode(self::$data['cantidad_cup']), 1,0,'C');
        $this->Cell(16, 7, '$'.utf8_decode(self::$data['valor_cup']), 1, 0, 'C');
        $this->Cell(16, 7, '$'.utf8_decode(self::$valorTotal), 1, 1, 'C');

        $this->SetFont('Arial', 'I', 7);
        $this->SetFillColor(220,230,249);



        // Totales
        // $this->Ln(2);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(150, 4, 'Subtotal', 1, 0, 'R',);
        $this->Cell(40, 4, '$'.utf8_decode(self::$valorTotal), 1, 1, 'R');
        $this->Cell(150, 4, 'IVA', 1, 0, 'R');
        $this->Cell(40, 4, '$0', 1, 1, 'R');
        $this->Cell(150, 4, 'Copagos y Cuotas', 1, 0, 'R');
        $this->Cell(40, 4, '$0,00', 1, 1, 'R');
        $this->Cell(150, 4, 'Descuento', 1, 0, 'R');
        $this->Cell(40, 4, '$0,00', 1, 1, 'R');
        $this->Cell(150, 4, 'TOTAL', 1, 0, 'R');
        $this->Cell(40, 4, '$'.utf8_decode(self::$valorTotal), 1, 1, 'R');

        // Total en letras
        $this->Ln(1);
        $this->SetFont('Arial', 'B', 7);
        $this->SetTextColor(46,44,126);
        $this->Cell(40, 7, 'SON', 0, 1, 'L');
        $this->SetTextColor(0);
        $this->SetFont('Arial', '', 7);
        $this->Cell(190, 6, utf8_decode("UN MILLÓN OCHOCIENTOS CINCUENTA Y OCHO MIL CIENTO DOS PESOS MTCE"),1,1,'L');

        // Firma
        $this->Ln(2);
        $this->Cell(0, 5, utf8_decode('Elaboró'), 0, 1, 'C');
        $this->Cell(0, 4, '_______________________________________________', 0, 1,'C');
        $this->Cell(0, 4, 'CINDY KATHERINE GALINDO PEÑA', 0, 1,'C');
        $this->Cell(0, 4, 'ADMINISTRATIVO', 0, 1,'C');
    }

    public function footer()
    {
        // $this->Ln();
        $this->SetFont('Arial', '', 7);
        $this->Cell(95,5,utf8_decode('CUFE : null'),0,1);
        $this->Cell(95,5,utf8_decode('Numero de Autorización: 18764089065244'),0,0);
        $this->Cell(95,5,utf8_decode('Prefijo: FE'),0,1);
        $this->Cell(95,5,utf8_decode('Rango Autorizado: 697 - 1000'),0,0);
        $this->Cell(95,5,utf8_decode('Vigencia: 2026-02-18'),0,1);
        $this->MultiCell(0, 3, utf8_decode("Aceptada: Declaramos haber recibido de conformidad real y material los servicios prestados por el Instituto Prestador de Salud (IPS), de acuerdo a las órdenes que se anexan en la presente factura,obligándonos a la cancelacion de la forma aqui pactada. La presente factura se asimila en todos sus efectos a la Letra de Cambio. (Art. 774 del código de Comercio), causa intereses de mora a la tasa maxima legal permitida a partir de la fecha de vencimiento. No somos agentes retenedores del Impuestos sobre las Ventas,No somos Auto retenedores del impuesto sobre la renta y complementarios,No Somos Gran Contribuyentes,No Pertenecemos al regimen simple Responsables de IVA"));
        $this->Ln();
        $this->Cell(0, 4, 'Impreso por Divergente Soluciones Inteligentes', 0, 1, 'C');
        $this->Cell(0, 4, 'Nit 901677542', 0, 1, 'C');
    }
}
