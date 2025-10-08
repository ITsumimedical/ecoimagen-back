<?php
namespace App\Formats;

use App\Http\Modules\Rips\Af\Models\Af;
use App\Traits\PdfTrait;
use Codedge\Fpdf\Fpdf\Fpdf;

class CertificadoRips extends FPDF
{
    use PdfTrait;

    public static $paqueteRip;
    public static $sum;
    public static $type;
    public static $details;
    public static $total;
    public static $prestador;


    public function generar($certificadoRips)
    {
        self::$paqueteRip = $certificadoRips->paqueteRip;
        self::$type = $certificadoRips->type;
        self::$total = $certificadoRips->total;
        $this->generarPDF('I');
    }

    public function header()
    {


        $logo = public_path(). "/images/logoEcoimagen.png";
        $this->Image($logo, 85, 7, -200);
        $this->SetFont('Arial','B',20);
        $this->SetXY(20,60);
        $this->Cell(120,10,utf8_decode(self::$paqueteRip->estado_id == '14'?"CERTIFICADO DE RADICACIÓN":"CERTIFICADO DE CARGA"),0,0,'L',false,'');
        $this->Ln();
        $this->SetX(20);
        $this->SetFont('Arial','B',15);
        $this->Cell(120,10,utf8_decode("N° ".self::$paqueteRip->id),0,0,'L',false,'');
        $this->Ln();
        $this->Ln();
        // if(self::$type != 1){
        //     $this->SetX(20);
        //     $this->SetFont('Arial','',10);
        //     $this->Cell(170,5,utf8_decode("Este Reporte no es válido como radicado, las facturas relacionadas serán revisadas, una vez superen "),0,0,'L',false,'');
        //     $this->Ln();
        //     $this->SetX(20);
        //     $this->Cell(170,5,utf8_decode("esa revisión pueden descargar el Informe de Radicado."),0,0,'L',false,'');
        // }
        $this->Ln();
        $this->SetFont('Arial','B',20);
        $this->SetX(20);
        // $this->Cell(150,10,utf8_decode(self::$paqueteRip->rep->Nombre.(self::$type != 1?' (Parcial)':'')),0,0,'L',false,'');
        $this->MultiCell(150,10,utf8_decode(self::$paqueteRip->rep->nombre." (".self::$paqueteRip->afs[0]['codigo_entidad'].")"),0,'L',false);
        $this->SetX(20);
        $this->SetFont('Arial','',10);
        $this->Cell(150,5,utf8_decode("Cód. Hab. ".self::$paqueteRip->rep->codigo."- NIT".self::$paqueteRip->rep->prestadores->nit),0,0,'L',false,'');
        $this->Ln();
        $this->SetX(20);
        $this->SetFont('Arial','B',10);
        $this->Cell(32,5,utf8_decode('Fecha Radicación: '),0,0,'L',false,'');
        $this->SetFont('Arial','',10);
        $this->Cell(118,5,utf8_decode(self::$paqueteRip->created_at),0,0,'L',false,'');
        $this->Ln();
        $this->SetX(20);
        $this->SetFont('Arial','B',10);
        $this->Cell(27,5,utf8_decode('Total Facturas: '),0,0,'L',false,'');
        $this->SetFont('Arial','',10);
        //Facturas::select('numero_factura')->where('paq_id',self::$paqueteRip->id)->count();
        $totalFacturas = Af::select('numero_factura')->where('paquete_rip_id',self::$paqueteRip->id)->count();
        $this->Cell(122,5,utf8_decode($totalFacturas),0,0,'L',false,'');
        $this->Ln();
        $this->SetX(20);
        $this->SetFont('Arial','B',10);
        $this->Cell(12,5,utf8_decode('Valor: '),0,0,'L',false,'');
        $this->SetFont('Arial','',10);
        $this->Cell(122,5,'$ '.number_format(self::$total['total']),0,0,'L',false,'');
        $this->Ln();
        $this->Ln();
        $this->Ln();
        $this->Ln();

        $this->Ln();
        $this->SetX(20);
        $this->SetFont('Arial','B',10);
        $this->Cell(150,5,utf8_decode("REGISTRO FACTURAS"),0,0,'L',false,'');
        $this->Ln();

        if(self::$type == 1){
            $this->Ln();
            $this->SetX(41.25);
            $this->Cell(5,5,utf8_decode('#'),1,0,'C',false,'');
            $this->Cell(38.5,5,utf8_decode('Número Factura'),1,0,'C',false,'');
            $this->Cell(40,5,utf8_decode('Fecha Expedición'),1,0,'C',false,'');
            $this->Cell(43.5,5,utf8_decode('Valor Neto'),1,0,'C',false,'');

        }else{
            $this->Ln();
            $this->SetX(41.25);
            $this->Cell(35.75,5,utf8_decode('Prestador'),1,0,'C',false,'');
            $this->Cell(20.75,5,utf8_decode('Archivos'),1,0,'C',false,'');
            $this->Cell(24.75,5,utf8_decode('Registros'),1,0,'C',false,'');
            $this->Cell(24.75,5,utf8_decode('Exitosos'),1,0,'C',false,'');
            $this->Cell(21,5,utf8_decode('Faltantes'),1,0,'C',false,'');

        }
        $this->SetFont('Arial','',10);
        $this->Ln();

    }

    public function footer(){
        $this->SetXY(180,280);
        $this->Cell(0,10,'Pagina '.$this->PageNo().' de {nb}',0,0,'C');
    }

    public function body(){
        $i = 1;
        foreach ($this->record_sort(self::$paqueteRip->afs,"numero_factura") as $af){
                $this->Ln();
                $this->SetX(41.25);
                $this->Cell(5,5,utf8_decode($i),0,0,'C',false,'');
                $this->Cell(38,5,utf8_decode($af->numero_factura),0,0,'C',false,'');
                $this->Cell(40,5,utf8_decode($af->fechaexpedicion_factura),0,0,'C',false,'');
                $this->Cell(43,5,utf8_decode('$ '.number_format($af->valor_neto,0,',','.')),0,0,'C',false,'');
                $i++;
        }
    }

    public function bodyPartial(){
        $i = 1;
        foreach (self::$details as $detalle){
            $this->Ln();
            $this->SetX(41.25);
            $this->Cell(35.75,5,utf8_decode(self::$paqueteRip->rep->Codigo),0,0,'C',false,'');
            $this->Cell(20.75,5,utf8_decode($detalle["file_name"]),0,0,'C',false,'');
            $this->Cell(24.75,5,utf8_decode($detalle["total"]),0,0,'C',false,'');
            $this->Cell(24.75,5,utf8_decode($detalle["success"]),0,0,'C',false,'');
            $this->Cell(21.75,5,(intval($detalle["total"])-intval($detalle["success"])),0,0,'C',false,'');
            $i++;
        }
    }

    // public function getDetalle(){
    //     $data = [];
    //     $id = self::$paqueteRip->id;
    //     foreach (self::$paqueteRip['cts'] as $file){
    //         $arr = [];
    //         $f = strtoupper(substr($file->Nombre_Archivo,0,2));
    //         $modelName = strtoupper(substr($file->Nombre_Archivo,0,1)).strtolower(substr($file->Nombre_Archivo,1,1));
    //         $model = 'App\\'.'Modelos\\'.$modelName;
    //         $arr['num_prestadores'] = 1;
    //         $arr['file_name'] = $f;
    //         $arr['total'] = $file->Cantidad_Registros;
    //         $success = $model::whereIn('Af_id',function ($q) use ($id){
    //             $q->from('afs')
    //                 ->selectRaw('id')
    //                 ->where('paq_id',$id);
    //         })->get();
    //         $arr['success'] = ($success?$success->count():0);
    //         self::$sum["total"] += ($success?$success->count():0);
    //         $data[] = $arr;
    //     }

    //     return $data;
    // }


    function record_sort($records, $field, $reverse=false)
    {
        $hash = array();

        foreach($records as $record)
        {
            $hash[$record[$field]] = $record;
        }

        ($reverse)? krsort($hash) : ksort($hash);

        $records = array();

        foreach($hash as $record)
        {
            $records []= $record;
        }

        return $records;
    }

}


