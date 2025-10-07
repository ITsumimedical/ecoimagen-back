<?php
namespace App\Formats;
use DNS1D;
use DNS2D;
use App\User;
use App\Modelos\Orden;
use App\Modelos\Paciente;
use App\Modelos\citapaciente;
use App\Modelos\RecomendacionesClinicas;
use Codedge\Fpdf\Fpdf\Fpdf;


class Recomendaciones extends Fpdf
{
    public static $paciente;
    public static $recomendacion;
    public static $orden;
    public static $citaPaciente;
    public static $medico;
    public static $TEMPIMGLOC;

    public function generar()
    {
        // self::$orden = Orden::find($id);
        // self::$citaPaciente = citapaciente::find(self::$orden->Cita_id);
        // self::$paciente = Paciente::find(self::$citaPaciente->Paciente_id);
        // self::$recomendacion = RecomendacionesClinicas::where('Orden_id',$id)->first();
        // self::$medico = User::find(self::$orden->Usuario_id);
        $pdf = new Recomendaciones('p', 'mm', 'A4');
        $pdf->AddPage();
        if(''/*self::$recomendacion["fecha_aislamiento"] == null*/)
        {
            $this->bodyrecomendaciones($pdf);
        }
        else
        {
            $this->bodyAislamiento($pdf);
        }
        $pdf->SetFont('Arial','B',16);
        $pdf->Output();
    }

    public function bodyRecomendaciones($pdf)
    {
        $pdf->SetFont('Arial','B',50);
        $pdf->SetTextColor(255,192,203);
        $pdf->SetTextColor(0,0,0);

        $Y = 14;
        $pdf->SetFont('Arial', 'B', 9);
        $logo ="/images/logo.png";
        $pdf->Image($logo, 8, 7, -400);
        $pdf->SetXY(50, 10);
        $pdf->Cell(80, 4, utf8_decode('SUMIMEDICAL S.A.S'), 0, 0, 'C');
        $pdf->SetXY(50, $Y);
        $pdf->Cell(80, 4, utf8_decode('NIT: 900033371 Res: 004 '), 0, 0, 'C');
        $pdf->SetXY(50, $Y + 4);
        // self::$medico->email
        $pdf->Cell(80, 4, utf8_decode('Email Medico: '.''), 0, 0, 'C');
        $pdf->SetXY(50, $Y + 12);

        $Y = 8;
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->SetXY(120, $Y);
        $pdf->Cell(88, 4, utf8_decode('Recomendaciones'), 0, 0, 'C');
        $pdf->SetXY(151, $Y + 4);
        $pdf->Cell(12, 4, utf8_decode("N°: "), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        // self::$orden->id
        $pdf->Cell(10, 4, utf8_decode(''), 0, 0, 'L');
        $pdf->SetXY(151, $Y + 8);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(12, 4, utf8_decode('Fecha: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        // self::$orden->Fechaorden
        $pdf->Cell(25, 4, '', 0, 0, 'L');
        $pdf->SetXY(151, $Y + 12);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(12, 4, utf8_decode('Entidad: '), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 7);
        // self::$paciente->Ut
        $pdf->Cell(35, 4, '', 0, 0, 'L');

        $pdf->SetFillColor(216, 216, 216);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetXY(5, 28);
        $pdf->Cell(198, 8, utf8_decode('Datos del Paciente'), 0, 0, 'L');
        $pdf->SetLineWidth(0.8);
        $pdf->Line(5,33.8,203,33.8);
        $pdf->SetLineWidth(0.2);

        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(108, 4, utf8_decode('Nombre Paciente'), 1, 0, 'C', 1);
        $pdf->Cell(25, 4, utf8_decode('Identificación'), 1, 0, 'C', 1);
        $pdf->Cell(25, 4, utf8_decode('Telefono'), 1, 0, 'C', 1);
        $pdf->Cell(30, 4, utf8_decode('Regimen'), 1, 0, 'C', 1);
        $pdf->Cell(10, 4, 'Edad', 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->SetFont('Arial', '', 8);
        //1'': self::$paciente->Edad_Cumplida
        //2'': self::$paciente->Segundo_Ape
        //3'': self::$paciente->Primer_Nom
        //4'': self::$paciente->SegundoNom
        $pdf->Cell(108, 4, utf8_decode(''." ".''." ".''." ".''), 1, 0, 'C');
        // self::$paciente->Num_Doc
        $pdf->Cell(25, 4, utf8_decode('CC '.''), 1, 0, 'C');
        //self::$paciente->Celular1
        $pdf->Cell(25, 4, utf8_decode(''), 1, 0, 'C');
        // self::$paciente->Ut
        $pdf->Cell(30, 4, utf8_decode(''), 1, 0, 'C');
        // self::$paciente->Edad_Cumplida
        $pdf->Cell(10, 4, utf8_decode(''), 1, 0, 'C');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(198, 4, utf8_decode('Recomendaciones'), 1, 0, 'C', 1);
        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->SetFont('Arial', '', 9);
        //self::$recomendacion->recomedacion
        $pdf->MultiCell(198,4, utf8_decode(''),1,'L');

        $pdf->Ln();
        $final = $pdf->GetY();
        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        #FIRMAS MEDICO
        // if(isset(self::$medico)){
        //     if (file_exists(storage_path(substr(self::$medico->Firma, 9)))) {
        //         $pdf->Image(storage_path(substr(self::$medico->Firma, 9)), 30, 250, 56, 11);
        //     }
        // }
        if($final > 250){
            $pdf->AddPage();
        }
        $y1= $pdf->GetY();
        $pdf->Line(20, $y1 +3, 90, $y1 +3);
        $pdf->SetFont('Arial', '', 8);
        $y2= $pdf->GetY();
        $pdf->SetXY(23,$y2+3);
        //1'': self::$medico->name
        //2'': self::$medico->apellido
        $pdf->Cell(60, 4, utf8_decode('Atendido por:'. ' '.''." ".''), 0, 0, 'l'); #NOMBRE COMPLETO DEL MEDICO
        $y3= $pdf->GetY();
        $pdf->SetXY(23,$y3 +4);
        //self::$medico->especialidad_medico
        $pdf->Cell(60, 4, utf8_decode('Especialidad:'. ' '.''), 0, 0, 'l'); #ESPECIALIDAD DEL MEDICO
        $y4= $pdf->GetY();
        $pdf->SetXY(23, $y4 +4);
        $pdf->Cell(32, 4, utf8_decode('REGISTRO:'), 0, 'l'); #REGISTRO MEDICO
        // self::$medico->cedula
        $pdf->MultiCell(30, 4, utf8_decode(''), 0, 'l');


        $pdf->SetFont('Arial','I',8);
        // ->TextWithDirection
        $pdf->cell(206,120,'Funcionario que Imprime:','U');
         // ->TextWithDirection
        //sin'': auth()->user()->name . " " . auth()->user()->apellido
        $pdf->cell(206, 87, utf8_decode(''), 'U');
        // ->TextWithDirection
        $pdf->cell(209,120,utf8_decode('Fecha Impresión:'),'U');
        // ->TextWithDirection
        $pdf->cell(209, 98, date('Y-m-d h:i:s a'), 'U');
    }

    public function bodyAislamiento($pdf)
    {
        $logo1 ="/images/logo-redvital-1.png";
        $logo2 ="/images/piesumi.png";
        //$TEMPIMGLOC = 'tempimg.png';
        // DNS2D::getBarcodePNG(self::$recomendacion->Orden_id,
        //$dataURI    = "data:image/png;base64," . ('QRCODE');
        //$dataPieces = explode(',', $dataURI);
        //$encodedImg = $dataPieces[1];
        //$decodedImg = base64_decode($encodedImg);
        //file_put_contents($TEMPIMGLOC, $decodedImg);
        // self::$TEMPIMGLOC = $TEMPIMGLOC;
        //$pdf->Image(self::$TEMPIMGLOC, 12, 8, 40, 40);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->SetDrawColor(255, 255, 255);
        $pdf->Rect(5, 5, 200, 287);
        $pdf->SetDrawColor(0, 0, 0);

        $pdf->Image($logo1, 140, 15, 50, 10);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetY(28);
        $pdf->Cell(180, 4, utf8_decode('Sede administrativa'), 0, 0, 'R');
        $pdf->Ln();
        $pdf->Cell(180, 4, utf8_decode('Tel: +57(4) 520 10 40'), 0, 0, 'R');
        $pdf->Ln();
        $pdf->Ln();
        $pdf->Cell(180, 4, utf8_decode('Linea Gratuita Nacional'), 0, 0, 'R');
        $pdf->Ln();
        $pdf->Cell(180, 4, utf8_decode('01 8000 423 762'), 0, 0, 'R');
        $pdf->Ln();

        $pdf->SetXY(10, 70);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(192, 4, utf8_decode('REDVITAL UT'), 0, 0, 'C');
        $pdf->Ln();

        $pdf->SetXY(10, 80);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(192, 4, utf8_decode('CERTIFICA'), 0, 0, 'C');
        $pdf->Ln();

        $pdf->SetXY(10, 100);
        $pdf->SetFont('Arial', '', 12);
        //1sin'': self::$paciente->Primer_Ape
        //2sin'': self::$paciente->Segundo_Ape
        //3sin'': self::$paciente->Primer_Nom
        //4sin'': self::$paciente->Primer_Nom
        //5sin'': self::$paciente->Tipo_Doc
        //6sin'': self::$paciente->Num_Doc
        //7sin'': self::$recomendacion->fecha_aislamiento
        $pdf->MultiCell(186, 4, utf8_decode('A quien pueda interesar, que el usuario (a) '.''." ".''." ".''." ".''
        .'- '. ''.' '.'' .' Considerando aislamiento preventivo en casa hasta terminar los días obligatorios de aislamiento '. ''.'. Considerar alta según evolución de la paciente, de acuerdo a los criterios definidos por el ministerio de salud y protección social.

        Por lo anterior se recomienda respetar las medidas preventivas generales y obligatorias que debe seguir toda la población, como los son, lavado de manos, uso de mascarilla, distanciamiento social y demás disposiciones para evitar el contagio.'),0,'J');

        $pdf->SetX(12);
        $pdf->SetFont('Arial', 'B', 8);
        #FIRMAS MEDICO
        // if(isset(self::$medico)){

        //     if (file_exists(storage_path(substr('', 9)))) {
        //         $pdf->Image(storage_path(substr(self::$medico->Firma, 9)), 85, 180, 56, 11);
        //     }
        // }
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(10,200);
        $pdf->Cell(192, 4, utf8_decode('MEDICO SUMIMEDICAL RED VITAL'), 0, 0, 'C');
        $pdf->Image($logo2, 0, 290, 218, 8);
        $pdf->Ln();
    }
}
