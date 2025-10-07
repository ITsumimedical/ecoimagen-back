<?php
namespace App\Formats;



use App\Modelos\DetailsPackages_202;
use App\Modelos\Packages_202;
use App\Modelos\Sedeproveedore;
use Codedge\Fpdf\Fpdf\Fpdf;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Certificate202 extends FPDF
{
    public static $package;
    public static $provider;
    public static $type;


    public function generate($id,$type)
    {
        // self::$package = Packages_202::find($id);
        // self::$provider = Sedeproveedore::find(self::$package->sedeproveedor_id);
        // self::$type = $type;

        $pdf = new Certificate202('P','mm','A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $this->body($pdf);
        $pdf->Output();
    }

    public function header()
    {
       $logo = public_path(). "images/logotipo_fps.jpg";
       $this->Image($logo, 100, 7, -350);

        //$type = 1;
        $type = 5;
        //$package = null;
        $package = 'package';


        if($type != 1){
            $this->SetXY(20,55);
            $this->SetFont('Arial','',10);
            $this->Cell(170,5,(utf8_decode("Fecha de Validación: ").''),0,0,'R',false,'');
        }
        $this->SetFont('Arial','B',20);
        $this->SetXY(20,60);
        $this->Cell(120,10,("INFORME DE RADICADO".(' (Parcial)')),0,0,'L',false,'');
        $this->Ln();
        $this->SetX(20);
        $this->SetFont('Arial','B',15);
        $this->Cell(120,10,utf8_decode("N° "),0,0,'L',false,'');
        $this->Ln();
        $this->Ln();
        if($type != 1){
            $this->SetX(20);
            $this->SetFont('Arial','',10);
            $this->Cell(170,5,utf8_decode("Este Reporte no es válido como radicado, las facturas relacionadas serán revisadas, una vez superen "),0,0,'L',false,'');
            $this->Ln();
            $this->SetX(20);
            $this->Cell(170,5,utf8_decode("esa revisión pueden descargar el Informe de Radicado."),0,0,'L',false,'');
        }
        $this->Ln();
        $this->SetFont('Arial','B',20);
        $this->SetX(20);
        $this->Cell(150,10,utf8_decode(''),0,0,'L',false,'');
        $this->Ln();
        $this->Ln();
        $this->SetX(20);
        $this->SetFont('Arial','B',10);
        if(strtolower('') === 'eas027'){
            $this->Cell(150,5,utf8_decode(strtoupper('fondo pasivo social de los ferrocarriles nacionales ')),0,0,'L',false,'');
        }else{
            $this->Cell(150,5,utf8_decode(strtoupper('sumimedical SAS ')),0,0,'L',false,'');
        }
        $this->Ln();
        $this->SetX(20);
        $this->SetFont('Arial','',10);
        $this->Cell(150,5,utf8_decode("Cód. Hab. ".''."- NI ".''),0,0,'L',false,'');
        $this->Ln();
        $this->SetX(20);
        $this->SetFont('Arial','B',10);
        $this->Cell(32,5,utf8_decode('Fecha radicacion: '),0,0,'L',false,'');
        $this->SetFont('Arial','',10);
        $this->Cell(118,5,utf8_decode(''),0,0,'L',false,'');
        $this->Ln();

        $this->SetX(20);
        $this->SetFont('Arial','B',10);
        $this->Cell(30,5,utf8_decode('Nombre Archivo: '),0,0,'L',false,'');
        $this->SetFont('Arial','',10);
        $this->Cell(120,5,utf8_decode(''),0,0,'L',false,'');
        $this->Ln();
        $this->SetX(20);
        // $this->SetFont('Arial','B',10);
        // $this->Cell(27,5,utf8_decode('Total registros: '),0,0,'L',false,'');
        // $this->SetFont('Arial','',10);
        // $this->Cell(122,5,utf8_decode(self::$package->number_records),0,0,'L',false,'');
        $this->Ln();
        $this->Ln();
        $this->Ln();
        $this->Ln();

        if($type == 1){
            $this->Ln();
            $this->SetX(20);
            $this->SetFont('Arial','B',10);
            $this->Cell(150,5,utf8_decode("ARCHIVOS RECIBIDOS"),0,0,'L',false,'');
            $this->Ln();
        }

        if($package != null ){
            $this->Ln();
            $this->SetX(27.25);
            $this->Cell(18,5,utf8_decode('Entidad'),1,0,'C',false,'');
            $this->Cell(37.125,5,utf8_decode('Fecha Inicial Periodo'),1,0,'C',false,'');
            $this->Cell(37.125,5,utf8_decode('Fecha Final Periodo'),1,0,'C',false,'');
            $this->Cell(30.75,5,utf8_decode('Numero Registro'),1,0,'C',false,'');
            $this->Cell(34.75,5,utf8_decode('Registro Existosos'),1,0,'C',false,'');
        }else{
            $this->Ln();
            $this->SetX(41.25);
            $this->Cell(22,5,utf8_decode('Entidad'),1,0,'C',false,'');
            $this->Cell(37.125,5,utf8_decode('Fecha Inicial Periodo'),1,0,'C',false,'');
            $this->Cell(37.125,5,utf8_decode('Fecha Final Periodo'),1,0,'C',false,'');
            $this->Cell(30.75,5,utf8_decode('Numero Registro'),1,0,'C',false,'');
        }


        $this->SetFont('Arial','',10);
        $this->Ln();
    }

    public function footer(){

    }

    public function body($pdf)
    {
        if(self::$package->partial){
            //$details = DetailsPackages_202::where('package_202_id',self::$package->id)->get();
            $pdf->Ln();
            $pdf->SetX(27.25);
            $pdf->Cell(18,5,utf8_decode(self::$package->eapba),0,0,'C',false,'');
            $pdf->Cell(37.125,5,utf8_decode(self::$package->start_date),0,0,'C',false,'');
            $pdf->Cell(37.125,5,utf8_decode(self::$package->final_date),0,0,'C',false,'');
            $pdf->Cell(30.75,5,utf8_decode(self::$package->number_records),0,0,'C',false,'');
            $pdf->Cell(34.75,5,utf8_decode('$details->count()'),0,0,'C',false,'');

        }else{
            $pdf->Ln();
            $pdf->SetX(41.25);
            $pdf->Cell(22,5,utf8_decode(self::$package->eapba),0,0,'C',false,'');
            $pdf->Cell(37.125,5,utf8_decode(self::$package->start_date),0,0,'C',false,'');
            $pdf->Cell(37.125,5,utf8_decode(self::$package->final_date),0,0,'C',false,'');
            $pdf->Cell(30.75,5,utf8_decode(self::$package->number_records),0,0,'C',false,'');
        }

    }
}

