<?php

namespace App\Formats;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\DB;
use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\Proveedores\Models\Proveedor;
use App\Http\Modules\SolicitudBodegas\Models\SolicitudBodega;
use App\Http\Modules\DetalleSolicitudBodegas\Models\DetalleSolicitudBodega;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;
use App\Traits\PdfTrait;

class SolicitudCompra extends FPDF
{
    use PdfTrait;

    public static $solicitudBodega;
    public static $articulos;
    public static $prestador;

    public function generar($solicitudCompra)
    {
        self::$solicitudBodega = $solicitudCompra->solicitudBodega;
        self::$articulos = $solicitudCompra->articulos;
        self::$prestador = $solicitudCompra->prestador;

        $this->generarPDF('I');

    }

    public function Header() {}

    public function Body()
    {
        $logo = public_path() . "/logo.png";
        $this->Image($logo, 15, 8, -280);
        $this->SetXY(12, 10);
        $this->SetFont('Arial', 'B', 10);
        $this->Cell(186, 4, utf8_decode('SUMIMEDICAL S.A.S'), 0, 0, 'C');
        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(186, 4, utf8_decode('CRA 80 C # 32 EE 65'), 0, 0, 'C');
        $this->SetXY(12, 23);
        $this->SetFont('Arial', 'B', 15);
        switch (self::$solicitudBodega->estado_id) {
            case 3:
                $this->Cell(186, 4, utf8_decode('SOLICITUD DE COMPRA'), 0, 0, 'C');
                break;
            case 14:
                $this->Cell(186, 4, utf8_decode('ORDEN DE COMPRA'), 0, 0, 'C');
                break;
        }
        $this->Ln(6);
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(186, 4, utf8_decode('Nº' . self::$solicitudBodega->id), 0, 0, 'C');
        $this->SetXY(12, 40);
        $this->SetFont('Arial', '', 7);
        $usuarioCrea = User::find(self::$solicitudBodega->usuario_solicita_id);
        $operador = Operadore::where('user_id', $usuarioCrea->id)->first();
        $this->Cell(93, 4, utf8_decode('Elaborá: ' . $operador->nombre . ' ' . $operador->apellido), 0, 0, 'L');
        if (self::$solicitudBodega->estado_id == 4 || self::$solicitudBodega->estado_id == 14) {
            $idAuditor = SolicitudBodega::where('id', self::$solicitudBodega->id)->whereNotNull('usuario_aprueba_id')->first();
            $auditor = User::find($idAuditor->usuario_aprueba_id);
            $operador = Operadore::where('user_id', $auditor->id)->first();
            $this->Cell(93, 4, utf8_decode('Confirma: ' . $operador->nombre . ' ' . $operador->apellido), 0, 0, 'R');
        }
        $this->Line(12, 45, 198, 45);
        $this->SetXY(12, 47);
        $this->SetFont('Arial', 'B', 7.5);
        $this->Cell(22, 4, utf8_decode('PROVEEDOR:'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(73, 4, utf8_decode(self::$prestador ? self::$prestador->nombre_prestador : ""), 1, 0, 'L');
        $this->SetFont('Arial', 'B', 7.5);
        $this->Cell(7, 4, utf8_decode('NIT:'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(29, 4, utf8_decode(self::$prestador ? self::$prestador->nit : ""), 1, 0, 'L');
        $this->SetFont('Arial', 'B', 7.5);
        $this->Cell(22, 4, utf8_decode('FECHA:'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(33, 4, utf8_decode(self::$solicitudBodega->created_at), 1, 0, 'L');
        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 7.5);
        $this->Cell(22, 4, utf8_decode('CIUDAD:'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(109, 4, utf8_decode(self::$prestador ? self::$prestador->municipio : ""), 1, 0, 'L');
        $this->SetFont('Arial', 'B', 7.5);
        $this->Cell(22, 4, utf8_decode('ENTREGA:'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(33, 4, utf8_decode((self::$solicitudBodega->estado_id == 14 ? self::$solicitudBodega->updated_at : "")), 1, 0, 'L');
        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 7.5);
        $this->Cell(22, 4, utf8_decode('DIRECCION:'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(109, 4, utf8_decode(self::$prestador ? self::$prestador->direccion : ""), 1, 0, 'L');
        $this->SetFont('Arial', 'B', 7.5);
        $this->Cell(22, 4, utf8_decode('CLASE ORDEN:'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(33, 4, utf8_decode('Orden Compra'), 1, 0, 'L');
        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 7.5);
        if (self::$prestador) {
            $this->Cell(22, 4, utf8_decode('TELEFONO:'), 1, 0, 'L');
            $this->SetFont('Arial', '', 7);
            $this->Cell(109, 4, utf8_decode(self::$prestador->telefono1 . (self::$prestador->telefono2 ? '-' . self::$prestador->telefono2 : "")), 1, 0, 'L');
        } else {
            $this->Cell(22, 4, utf8_decode('TELEFONO:'), 1, 0, 'L');
            $this->SetFont('Arial', '', 7);
            $this->Cell(109, 4, utf8_decode(""), 1, 0, 'L');
        }
        $this->SetFont('Arial', 'B', 7.5);
        $this->Cell(22, 4, utf8_decode('MONEDA:'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(33, 4, utf8_decode('Pesos'), 1, 0, 'L');
        $this->Ln();
        $this->SetX(12);
        $bodega = Bodega::find(self::$solicitudBodega->bodega_origen_id);
        $this->SetFont('Arial', 'B', 7.5);
        $this->Cell(22, 4, utf8_decode('BODEGA:'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(109, 4, utf8_decode($bodega->nombre), 1, 0, 'L');
        $this->SetFont('Arial', 'B', 7.5);
        $this->Cell(22, 4, utf8_decode('ESTADO:'), 1, 0, 'L');
        $this->SetFont('Arial', '', 7);
        switch (self::$solicitudBodega->estado_id) {
            case 3:
                $this->Cell(33, 4, utf8_decode('Por Autorizar'), 1, 0, 'L');
                break;
            case 4:
                $this->Cell(33, 4, utf8_decode('Autorizado'), 1, 0, 'L');
                break;
            case 14:
                $this->Cell(33, 4, utf8_decode('Entregado'), 1, 0, 'L');
                break;
        }
        $this->Ln(8);
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(10, 4, utf8_decode('CODIGO'), 1, 0, 'C');
        $this->Cell(45, 4, utf8_decode('NOMBRE'), 1, 0, 'C');
        $this->Cell(45, 4, utf8_decode('FABRICANTE'), 1, 0, 'C');
        $this->Cell(20, 4, utf8_decode('PRESENTACION'), 1, 0, 'C');
        $this->Cell(13, 4, utf8_decode('CANTIDAD'), 1, 0, 'C');
        $this->Cell(15, 4, utf8_decode('VALOR/U'), 1, 0, 'C');
        $this->Cell(22, 4, utf8_decode('SUBTOTAL'), 1, 0, 'C');
        $this->Cell(8, 4, utf8_decode('%DTO'), 1, 0, 'C');
        $this->Cell(8, 4, utf8_decode('%IVA'), 1, 0, 'C');
        $this->Ln();
        $this->SetFont('Arial', '', 6);
        $Y = 75;
        $YFin = 0;
        $totalCompra = 0;

        foreach (self::$articulos as $articulo) {
            if ($articulo->precio_unidad) {
                if ($articulo->estado_id == 3) {
                    $suma = round((floatval($articulo->precio_unidad) * floatval($articulo->cantidad_inicial)), 2);
                } else {
                    $suma = round((floatval($articulo->precio_unidad) * floatval($articulo->cantidad_aprobada)), 2);
                }
            }

            $this->SetXY(12, $Y);
            $this->Cell(10, 4, utf8_decode($articulo['medicamento']['codesumi']['codigo']), 0, 0, 'C');
            $this->MultiCell(45, 4, utf8_decode($articulo['medicamento']['codesumi']['nombre']), 0, 'L', 0);
            $YNombre = $this->GetY();
            $this->SetXY(67, $Y);
            $this->MultiCell(45, 4, utf8_decode($articulo['medicamento']['invima'] == null ? 'SIN EXPEDIENTE' : $articulo['medicamento']['invima']['titular']), 0, 'L', 0);
            $YFabricante = $this->GetY();
            $this->SetXY(112, $Y);
            $this->Cell(20, 4, utf8_decode(substr($articulo['medicamento']['invima'] == null ? 'SIN EXPEDIENTE' : $articulo['medicamento']['invima']['forma_farmaceutica'], 0, 20)), 0, 0, 'C');
            $this->Cell(13, 4, utf8_decode($articulo->estado_id == 3 ? $articulo->cantidad_inicial : $articulo->cantidad_aprobada), 0, 0, 'C');
            if ($articulo->precio_unidad) {
                $this->Cell(15, 4, utf8_decode("$" . number_format(round($articulo->precio_unidad, 2), 2)), 0, 0, 'C');
            }
            if ($articulo->precio_unidad) {
                $this->Cell(22, 4, utf8_decode("$" . number_format($suma, 2)), 0, 0, 'C');
            }
            $this->Ln();
            $Y = ($YNombre > $YFabricante ? $YNombre : $YFabricante);
            $YFin = $this->GetY();
            if ($articulo->precio_unidad) {
                $totalCompra = $totalCompra + $suma;
            }
        }
        $this->Line(12, $YFin + 8, 198, $YFin + 8);
        $this->SetXY(12, $YFin + 8);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(15, 4, utf8_decode('DETALLE'), 0, 0, 'L');
        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', '', 6.5);
        $this->MultiCell(100, 4, utf8_decode(''), 0, 'L', 0);
        $this->SetXY(153, $YFin + 8);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 4, utf8_decode('SUBTOTAL:'), 0, 0, 'R');
        $this->SetFont('Arial', '', 6.5);
        $this->Cell(25, 4, utf8_decode('$ ' . (number_format($totalCompra, 2))), 0, 0, 'R');
        $this->Ln();
        $this->SetX(153);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 4, utf8_decode('DESCUENTO:'), 0, 0, 'R');
        $this->SetFont('Arial', '', 6.5);
        $this->Cell(25, 4, utf8_decode('$'), 0, 0, 'R');
        $this->Ln();
        $this->SetX(153);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 4, utf8_decode('IMPUESTO:'), 0, 0, 'R');
        $this->SetFont('Arial', '', 6.5);
        $this->Cell(25, 4, utf8_decode('$'), 0, 0, 'R');
        $this->Ln();
        $this->SetX(153);
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(20, 4, utf8_decode('TOTAL ORDEN:'), 0, 0, 'R');
        $this->SetFont('Arial', '', 6.5);
        $this->Cell(25, 4, utf8_decode('$ ' . (number_format($totalCompra, 2))), 0, 0, 'R');
    }
    public function Footer()
    {
        $this->SetTextColor(120, 120, 120);
        $this->SetXY(12, 275);
        $this->SetFont('Arial', 'B', 7.5);
        $this->Cell(120, 4, utf8_decode('Nombre reporte : OrdenCompra'), 0, 0, 'L');
        $this->Cell(55, 4, utf8_decode('Usuario'), 0, 0, 'L');
        $this->Ln(8);
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(90, 4, utf8_decode('LICENCIADO A: [SUMIMEDICAL S.A.S.] NIT [900033371-4]'), 0, 0, 'L');
    }
}
