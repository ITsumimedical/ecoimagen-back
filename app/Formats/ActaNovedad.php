<?php
namespace App\Formats;

use App\Http\Modules\DetalleSolicitudBodegas\Models\DetalleSolicitudBodega;
use Codedge\Fpdf\Fpdf\Fpdf;

use Illuminate\Support\Facades\DB;

class ActaNovedad extends FPDF
{

    public static $ordenesCompra;

    public function generar($data){

        self::$ordenesCompra = DetalleSolicitudBodega::select('detalle_solicitud_bodegas.updated_at as FECHA DE RECEPCION',
        'detalle_solicitud_bodegas.id as NUMERO DE FACTURA','reps.nombre as PROVEEDOR','detalle_solicitud_bodegas.updated_at as FECHA FACTURA','codesumis.codigo as CODIGO MEDICAMENTO',
        'codesumis.nombre as DESCRIPCION','cums.producto as DESCRIPCION COMERCIAL','cums.titular as LABORATORIO','cums.registro_sanitario as REGISTRO SANITARIO',
        'cums.expediente as NUMERO EXPEDIENTE','detalle_solicitud_bodegas.solicitud_bodega_id as CONSECUTIVO FACTURA',
        'bodegas.nombre as ALMACEN','operadores.nombre as INGRESO LA FACTURA',
        'cums.fecha_vencimiento as FECHA DE VENCIMIENTO REGISTRO SANITARIO','cums.descripcion_comercial as PRESENTACION','cums.forma_farmaceutica as FORMA FARMACEUTICA',
            'lotes.codigo as LOTE','detalle_solicitud_lotes.cantidad as CANTIDAD','lotes.fecha_vencimiento as FECHA VENCIMIENTO',

            )
        ->join('solicitud_bodegas','detalle_solicitud_bodegas.solicitud_bodega_id','solicitud_bodegas.id')
        ->join('reps','reps.id','solicitud_bodegas.rep_id')
        ->join('medicamentos','medicamentos.id','detalle_solicitud_bodegas.medicamento_id')
        ->join('codesumis','codesumis.id','medicamentos.codesumi_id')
        ->join('cums','cums.cum_validacion','medicamentos.cum')
        ->join('bodegas','bodegas.id','solicitud_bodegas.bodega_origen_id')
        ->leftjoin('users','users.id','solicitud_bodegas.usuario_solicita_id')
        ->leftjoin('operadores','operadores.user_id','users.id')
        ->leftjoin('detalle_solicitud_lotes','detalle_solicitud_lotes.detalle_solicitud_bodega_id','detalle_solicitud_bodegas.id')
        ->leftjoin('lotes','lotes.id','detalle_solicitud_lotes.lote_id')
        ->where('detalle_solicitud_bodegas.numero_factura',$data['numeroFactura'])
        // ->where('solicitud_bodegas.rep_id',$data['proveedor_id'])
        ->where('detalle_solicitud_bodegas.estado_id',17)
        ->where('solicitud_bodegas.tipo_solicitud_bodega_id',1)
        ->distinct('detalle_solicitud_bodegas.id')
        ->get();

        // return self::$ordenesCompra;

        $pdf= new ActaRecepcion('p', 'mm', 'A3');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $this->body($pdf);
        $pdf->Output();

    }


    public function Header(){

        $this->SetXY(0, 15.6);
        $this->SetFont('Arial', 'B', 20);
        $this->Cell(297, 6.6, utf8_decode('ACTA DE RECEPCIÓN TÉCNICA'), 0, 0, 'C');
        $logo = public_path() . "/images/logoEcoimagen.png";
        $this->Image($logo, 55, 7, -350);
        $this->Line(0,30,297,30);
        $this->SetXY(60, 31);
        $this->SetFont('Arial', '', 10);
        $this->Cell(60, 6, utf8_decode('Fecha de ingreso: '.self::$ordenesCompra[0]["FECHA DE RECEPCION"]), 0, 0, 'L');
        $this->Cell(140,6,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'R');
        $this->SetFillColor(216, 216, 216);
        $this->SetXY(0, 40);
        $this->Cell(297,20,'',1,0,'R',1);
        $this->SetXY(0, 40);
        $x = 0;
        $this->Line(0,40,297,40);
        $this->SetFont('Arial', 'B', 6);
        $this->SetFillColor(216, 216, 216);
        $this->MultiCell(15,4,utf8_decode('FECHA DE RECEPCION'),0,'C',1);
        $this->SetXY($x = $x+15, 40);
        $this->MultiCell(15,4,utf8_decode('NUMERO DE FACTURA'),0,'C',1);
        $this->SetXY($x = $x+15, 40);
        $this->MultiCell(16,4,utf8_decode('PROVEEDOR'),0,'C',1);
        $this->SetXY($x = $x+16, 40);
        $this->MultiCell(15,4,utf8_decode('FECHA FACTURA'),0,'C',1);
        $this->SetXY($x = $x+15, 40);
        $this->MultiCell(20,4,utf8_decode('DESCRIPCION'),0,'C',1);
        $this->SetXY($x = $x+20, 40);
        $this->MultiCell(20,4,utf8_decode('DESCRIPCION COMERCIAL'),0,'C',1);
        $this->SetXY($x = $x+20, 40);
        $this->MultiCell(18,4,utf8_decode('LABORATORIO'),0,'C',1);
        $this->SetXY($x = $x+18, 40);
        $this->MultiCell(15,4,utf8_decode('REGISTRO SANITARIO'),0,'C',1);
        $this->SetXY($x = $x+15, 40);
        $this->MultiCell(18,4,utf8_decode('FECHA DE VENCIMIENTO REGISTRO SANITARIO'),0,'C',1);
        $this->SetXY($x = $x+18, 40);
        $this->MultiCell(20,4,utf8_decode('PRESENTACION'),0,'C',1);
        $this->SetXY($x = $x+20, 40);
        $this->MultiCell(20,4,utf8_decode('FORMA FARMACEUTICA'),0,'C',1);
        $this->SetXY($x = $x+20, 40);
        $this->MultiCell(15,4,utf8_decode('LOTE'),0,'C',1);
        $this->SetXY($x = $x+15, 40);
        $this->MultiCell(20,4,utf8_decode('FECHA VENCIMIENTO'),0,'C',1);
        $this->SetXY($x = $x+20, 40);
        $this->MultiCell(15,4,utf8_decode('CANTIDAD'),0,'C',1);
        $this->SetXY($x = $x+15, 40);
        $this->MultiCell(20,4,utf8_decode('NUMERO EXPEDIENTE'),0,'C',1);
        $this->SetXY($x = $x+20, 40);
        $this->MultiCell(15,4,utf8_decode('INGRESO LA FACTURA'),0,'C',1);
        $this->SetXY($x = $x+15, 40);
        $this->MultiCell(20,4,utf8_decode('ALMACEN'),0,'C',1);
        $this->Line(0,60,297,60);
    }

    public function body($pdf){

        $final = 0;
        $y = 60;
        $pdf->SetFont('Arial', '', 6);
        foreach (self::$ordenesCompra as $articulo){
            if($final > 348){
                $x2 = 0;
                for ($i = 0;$i<=17;$i++){
                    $pdf->Line($x2,40,$x2,$final);
                    if($i == 2) {
                        $x2 = $x2 + 16;
                    } elseif($i == 6){
                        $x2 = $x2 + 18;
                    }elseif($i == 8){
                        $x2 = $x2 + 18;
                    }elseif($i == 18){
                        $x2 = $x2 + 18;
                    } elseif($i == 16){
                        $x2 = $x2 +20;
                    }elseif($i == 4){
                        $x2 = $x2 +20;
                    } elseif($i == 5){
                        $x2 = $x2 +20;
                    }elseif($i == 9){
                        $x2 = $x2 +20;
                    }elseif($i == 10){
                        $x2 = $x2 +20;
                    }elseif($i == 12){
                        $x2 = $x2 +20;
                    }
                    elseif($i == 14){
                        $x2 = $x2 +20;
                    }
                    else{
                        $x2 = $x2 +15;
                    }
                }
                $y = 60;
                $final = 0;
                $pdf->AddPage();
            }
            $pdf->SetXY(0, $y);
            $x = 0;
            $pdf->MultiCell(15,4,utf8_decode($articulo["FECHA DE RECEPCION"]),0,'C',0);
            $final = $pdf->GetY() > $final?$pdf->GetY():$final;
            $pdf->SetXY($x = $x+15, $y);
            $pdf->MultiCell(15,4,utf8_decode($articulo["NUMERO DE FACTURA"]),0,'C',0);
            $final = $pdf->GetY() > $final?$pdf->GetY():$final;
            $pdf->SetXY($x = $x+15, $y);
            $pdf->MultiCell(16,4,utf8_decode($articulo["PROVEEDOR"]),0,'C',0);
            $final = $pdf->GetY() > $final?$pdf->GetY():$final;
            $pdf->SetXY($x = $x+16, $y);
            $pdf->MultiCell(15,4,utf8_decode($articulo["FECHA FACTURA"]),0,'C',0);
            $final = $pdf->GetY() > $final?$pdf->GetY():$final;
            $pdf->SetXY($x = $x+15, $y);
            $pdf->MultiCell(20,4,utf8_decode($articulo["DESCRIPCION"]),0,'C',0);
            $final = $pdf->GetY() > $final?$pdf->GetY():$final;
            $pdf->SetXY($x = $x+20, $y);
            $pdf->MultiCell(20,4,utf8_decode($articulo["DESCRIPCION COMERCIAL"]),0,'C',0);
            $final = $pdf->GetY() > $final?$pdf->GetY():$final;
            $pdf->SetXY($x = $x+20, $y);
            $pdf->MultiCell(18,4,utf8_decode($articulo["LABORATORIO"]),0,'C',0);
            $final = $pdf->GetY() > $final?$pdf->GetY():$final;
            $pdf->SetXY($x = $x+18, $y);
            $pdf->MultiCell(15,4,utf8_decode($articulo["REGISTRO SANITARIO"]),0,'C',0);
            $final = $pdf->GetY() > $final?$pdf->GetY():$final;
            $pdf->SetXY($x = $x+15, $y);
            $pdf->MultiCell(18,4,utf8_decode($articulo["FECHA DE VENCIMIENTO REGISTRO SANITARIO"]),0,'C',0);
            $final = $pdf->GetY() > $final?$pdf->GetY():$final;
            $pdf->SetXY($x = $x+18, $y);
            $pdf->MultiCell(20,4,utf8_decode($articulo["PRESENTACION"]),0,'C',0);
            $final = $pdf->GetY() > $final?$pdf->GetY():$final;
            $pdf->SetXY($x = $x+20, $y);
            $pdf->MultiCell(20,4,utf8_decode($articulo["FORMA FARMACEUTICA"]),0,'C',0);
            $final = $pdf->GetY() > $final?$pdf->GetY():$final;
            $pdf->SetXY($x = $x+20, $y);
            $pdf->MultiCell(15,4,utf8_decode($articulo["LOTE"]),0,'C',0);
            $final = $pdf->GetY() > $final?$pdf->GetY():$final;
            $pdf->SetXY($x = $x+15, $y);
            $pdf->MultiCell(20,4,utf8_decode($articulo["FECHA VENCIMIENTO"]),0,'C',0);
            $final = $pdf->GetY() > $final?$pdf->GetY():$final;
            $pdf->SetXY($x = $x+20, $y);
            $pdf->MultiCell(15,4,utf8_decode($articulo["CANTIDAD"]),0,'C',0);
            $final = $pdf->GetY() > $final?$pdf->GetY():$final;
            $pdf->SetXY($x = $x+15, $y);
            $pdf->MultiCell(20,4,utf8_decode($articulo["NUMERO EXPEDIENTE"]),0,'C',0);
            $final = $pdf->GetY() > $final?$pdf->GetY():$final;
            $pdf->SetXY($x = $x+20, $y);
            $pdf->MultiCell(15,4,utf8_decode($articulo["INGRESO LA FACTURA"]),0,'C',0);
            $final = $pdf->GetY() > $final?$pdf->GetY():$final;
            $pdf->SetXY($x = $x+15, $y);
            $pdf->MultiCell(20,4,utf8_decode($articulo["ALMACEN"]),0,'C',0);
            $final = $pdf->GetY() > $final?$pdf->GetY():$final;
            $pdf->Line(0,$final,297,$final);
            $y = $final;
        }
        $pdf->Line(15,40,15,$final);
        $x2 = 0;
                for ($i = 0;$i<=17;$i++){
                    $pdf->Line($x2,40,$x2,$final);
                    if($i == 2) {
                        $x2 = $x2 + 16;
                    } elseif($i == 6){
                        $x2 = $x2 + 18;
                    }elseif($i == 8){
                        $x2 = $x2 + 18;
                    }elseif($i == 18){
                        $x2 = $x2 + 18;
                    } elseif($i == 16){
                        $x2 = $x2 +20;
                    }elseif($i == 4){
                        $x2 = $x2 +20;
                    } elseif($i == 5){
                        $x2 = $x2 +20;
                    }elseif($i == 9){
                        $x2 = $x2 +20;
                    }elseif($i == 10){
                        $x2 = $x2 +20;
                    }elseif($i == 12){
                        $x2 = $x2 +20;
                    }
                    elseif($i == 14){
                        $x2 = $x2 +20;
                    }
                    else{
                        $x2 = $x2 +15;
                    }
                }

    }



}

