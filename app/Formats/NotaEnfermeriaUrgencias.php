<?php

namespace App\Formats;

use App\Http\Modules\AdmisionesUrgencias\Models\AdmisionesUrgencia;
use App\Http\Modules\Cie10Afiliado\Models\Cie10Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Urgencias\NotaEnfermeria\Models\NotasEnfermeriaUrgencia;
use App\Http\Modules\Usuarios\Models\User;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;

class NotaEnfermeriaUrgencias extends Fpdf
{

    public static $data;
    public static $nota;
    public static $admision;
    public static $operdaor;
    public static $entidad;
    public static $cie10;
    public static $consulta;
    public static $prestador;

    public function generar($datos)
    {
        $idNota = $datos['id'];
        self::$data = $datos;

        self::$nota = NotasEnfermeriaUrgencia::with('usuario')->find($idNota);

        self::$admision = AdmisionesUrgencia::with('afiliado')->find(self::$nota->admision_urgencia_id);

        self::$operdaor = User::find(self::$nota->created_by);

        self::$consulta = Consulta::where('admision_urgencia_id', self::$nota->admision_urgencia_id)->first();

        self::$cie10 = Cie10Afiliado::where('consulta_id', self::$consulta->id)->where('esprimario', true)->with('cie10')->get();

        $pdf = new NotaEnfermeriaUrgencias('p', 'mm', 'Letter');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $this->body($pdf, $datos);
        $pdf->Output();
    }

    public function Header()
    {
        if ($this->page == 1) {
            $Y = 40;

            $this->SetFont('helvetica', '', 7);
            $logo = public_path() . "/images/medicina_integral_Logo.jpeg";
            $this->Image($logo, 15, 25, 25);

            $this->SetXY(-380, 5);
            $fecha = Carbon::now();
            $this->Cell(0, 5, utf8_decode(' ' . $fecha->format('d/m/Y H:i:s')), 0, 1, 'C');

            $this->SetFont('helvetica', 'B', 9);
            $this->SetXY(90, 5);
            $this->Cell(0, 5, utf8_decode('Nota de Enfermería'), 0, 1, 'L');

            $this->SetXY(-284, 15);
            $this->SetFont('helvetica', '', 9);
            $this->Cell(0, 5, utf8_decode('Código del Prestador: ' . '230010092401'), 0, 1, 'C');

            $this->SetXY(-185, 15);
            $this->Cell(0, 5, utf8_decode('Nit: ' . '800250634-3'), 0, 1, 'C');


            $this->SetXY(-274, 20);
            $this->Cell(0, 5, utf8_decode('Dirección: ' . 'CALLE 44 # 14 - 282 MONTERIA '), 0, 1, 'C');

            $this->SetXY(-289, 25);
            $this->Cell(0, 5, utf8_decode('Teléfono: ' . 'Call Center 6046041571'), 0, 1, 'C');

            $this->SetXY(-287, 30);
            $this->Cell(0, 5, utf8_decode('Web: ' . 'www.medicinaintegralsa.com'), 0, 1, 'C');

            $this->SetXY(-284, 35);
            $this->Cell(0, 5, utf8_decode('Email: ' . 'info@medicinaintegralsa.com'), 0, 1, 'C');

            $this->SetXY(150, 30);
            $this->Rect(150, 30, 50, 10, 'D');
            $this->SetFont('helvetica', 'B', 7);
            $this->Cell(0, 5, utf8_decode('Fecha de Impresión: '), 0, 1, 'L');
            $this->SetXY(174, 30);
            $this->SetFont('helvetica', '', 7);
            $this->Cell(0, 5, utf8_decode(' ' . $fecha->format('d/m/Y H:i')), 0, 1, 'L');
            $this->SetXY(150, 35);
            $this->SetFont('helvetica', 'B', 9);
            $this->Cell(0, 5, utf8_decode('NOTA DE ENFERMERÍA'), 0, 1, 'L');
        }
    }
    public function body($pdf, $data)
    {
        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetXY(15, 45);
        $pdf->Cell(0, 5, utf8_decode('Nota N°: '), 0, 1, 'L');     

        $pdf->SetXY(30, 45);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, utf8_decode(self::$nota->id), 0, 1, 'L');

        $pdf->SetXY(15, 50);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 5, utf8_decode('Tipo Documento: '), 0, 0, 'L');
        
        $pdf->SetXY(45, 50);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, utf8_decode(self::$admision->afiliado->tipoDocumento->sigla), 0, 1, 'L');
        
        $pdf->SetXY(65, 50);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0,5, utf8_decode('Nro. documento: '), 0, 1, 'L');

        $pdf->SetXY(95, 50);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, utf8_decode(self::$admision->afiliado->numero_documento), 0, 1, 'L');


        $pdf->SetXY(15, 55);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 5, utf8_decode('Nombre: '), 0, 1, 'L');

        $pdf->SetXY(30, 55);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, utf8_decode( self::$admision->afiliado->primer_nombre . ' ' . self::$admision->afiliado->segundo_nombre . ' ' . self::$admision->afiliado->primer_apellido . ' ' . self::$admision->afiliado->segundo_apellido), 0, 1, 'L');

        $pdf->SetXY(15, 60);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 5, utf8_decode('Sexo: '), 0, 1, 'L');

        $pdf->SetXY(25, 60);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, utf8_decode(self::$admision->afiliado->sexo ), 0, 1, 'L');

        $pdf->SetXY(15, 65);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 5, utf8_decode('Edad: '), 0, 1, 'L');

        $pdf->SetXY(25, 65);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, utf8_decode(self::$admision->afiliado->edad_cumplida), 0, 1, 'L');

        $pdf->SetXY(15, 70);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 5, utf8_decode('Dirección: '), 0, 1, 'L');

        $pdf->SetXY(32, 70);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, utf8_decode(self::$admision->afiliado->direccion_residencia_cargue . ' ' . self::$admision->afiliado->direccion_residencia_numero_exterior . ' ' . self::$admision->afiliado->direccion_residencia_via. ' ' . self::$admision->afiliado->direccion_residencia_numero_interior . ' ' . self::$admision->afiliado->direccion_residencia_interior . ' ' . self::$admision->afiliado->direccion_residencia_barrio), 0, 1, 'L');


        $pdf->SetXY(15, 75);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 5, utf8_decode('Teléfono: '), 0, 1, 'L');

        
        $pdf->SetXY(32, 75);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, utf8_decode(self::$admision->afiliado->telefono), 0, 1, 'L');


        $pdf->SetXY(15, 80);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 5, utf8_decode('Entidad: '), 0, 1, 'L');

        $pdf->SetXY(32, 80);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, utf8_decode(self::$admision->afiliado->entidad->nombre), 0, 1, 'L');


        $pdf->SetXY(15, 85);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(0, 5, utf8_decode('Diagnostico de Ingreso: '), 0, 1, 'L');

        $pdf->SetXY(53, 85);
        $pdf->SetFont('Arial', '', 9);
        if (self::$cie10->isNotEmpty()) {
            $cie10Afiliado = self::$cie10->first();
        
            if ($cie10Afiliado->cie10) { 
                $codigo = utf8_decode($cie10Afiliado->cie10->codigo_cie10);
                $descripcion = utf8_decode($cie10Afiliado->cie10->descripcion);
                
                $pdf->Cell(0, 5, " $codigo" . " - " . $descripcion, 0, 1, 'L');
            } else {
                $pdf->Cell(0, 5, " No hay información del CIE10", 0, 1, 'L');
            }
        } else {
            $pdf->Cell(0, 5, " No hay registros de CIE10Afiliado", 0, 1, 'L');
        }        

        $pdf->SetXY(32, 85);
        $pdf->SetFont('Arial', '', 9);
        $pdf->Cell(0, 5, utf8_decode(''), 0, 1, 'L');

        $pdf->SetFont('helvetica', '', 8);
        $pdf->Rect(15, 92, 30, 5, 'D');
        $pdf->SetXY(16, 92);
        $pdf->Cell(0, 5, utf8_decode('Unidad Funcional: '), 0, 1, 'L');

        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->SetXY(49, 92);
        $pdf->Rect(47, 92, 25, 5, 'D');
        $pdf->Cell(0, 5, utf8_decode('URGENCIAS '), 0, 1, 'L');

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetXY(15, 100);
        $pdf->Cell(0, 5, utf8_decode('Fecha: '), 0, 1, 'L');

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetXY(55, 100);
        $pdf->Cell(0, 5, utf8_decode(' ' . Carbon::parse(self::$nota->fecha)->format('Y/m/d')), 0, 1, 'L');

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetXY(85, 100);
        $pdf->Cell(0, 5, utf8_decode('Hora: '), 0, 1, 'L');

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetXY(125, 100);
        $pdf->Cell(0, 5, utf8_decode(' ' . Carbon::parse(self::$nota->fecha)->format('H:i')), 0, 1, 'L');

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetXY(145, 100);
        $pdf->Cell(0, 5, utf8_decode('Peso: '), 0, 1, 'L');

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetXY(165, 100);
        $pdf->Cell(0, 5, utf8_decode(' ' . self::$nota->peso . ' Kg'), 0, 1, 'L');

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetXY(15, 105);
        $pdf->Cell(0, 5, utf8_decode('Tensión Arterial: '), 0, 1, 'L');

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetXY(55, 105);
        $pdf->Cell(0, 5, utf8_decode(' ' . self::$nota->tension_arterial . ' mmHg'), 0, 1, 'L');

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetXY(85, 105);
        $pdf->Cell(0, 5, utf8_decode('Temperatura: '), 0, 1, 'L');

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetXY(125, 105);
        $pdf->Cell(0, 5, utf8_decode(' ' . self::$nota->temperatura . ' °C'), 0, 1, 'L');

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetXY(15, 110);
        $pdf->Cell(0, 5, utf8_decode('Frecuencia Respiratoria: '), 0, 1, 'L');

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetXY(55, 110);
        $pdf->Cell(0, 5, utf8_decode(' ' . self::$nota->frecuencia_respiratoria . ' Lat/min'), 0, 1, 'L');

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetXY(85, 110);
        $pdf->Cell(0, 5, utf8_decode('Frecuencia Cardiaca: '), 0, 1, 'L');

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetXY(125, 110);
        $pdf->Cell(0, 5, utf8_decode(' ' . self::$nota->frecuencia_cardiaca . ' Lat/min'), 0, 1, 'L');

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetXY(145, 110);
        $pdf->Cell(0, 5, utf8_decode('Glucometria: '), 0, 1, 'L');

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetXY(165, 110);
        $pdf->Cell(0, 5, utf8_decode(' ' . self::$nota->glucometria), 0, 1, 'L');

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetXY(15, 115);
        $pdf->Cell(0, 5, utf8_decode('Enfermera(o): '), 0, 1, 'L');

        $pdf->SetFont('helvetica', 'B', 9);
        $pdf->SetXY(55, 115);
        $pdf->Cell(0, 5, utf8_decode(' ' . self::$nota->usuario->operador->nombre_completo), 0, 1, 'L');

        $pdf->SetFont('helvetica', '', 9);
        $pdf->SetXY(15, 120);
        $pdf->Cell(0, 5, utf8_decode('Nota: '), 0, 1, 'L');

        // DEFINO EL TAMAÑO PARA QUE EL MULTICELL SE GUARDE DENTRO Y JUEGUE CON SU TAMAÑO
        $x = 15;
        $y = 125;
        $width = 180;

        $pdf->SetXY($x + 0, $y + 0);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->MultiCell($width - 4, 3, utf8_decode(' ' . self::$nota->observacion ), 0, 'L');

        $Ylogo = $pdf->GetY();
        
        $logo = str_replace('/storage', './storage', self::$operdaor->firma);

        if (!file_exists($logo)) {

            $pdf->SetXY(15, $Ylogo + 45);
            $pdf->Cell(0, 5, utf8_decode(' ' . self::$nota->usuario->operador->documento), 0, 1, 'L');
        } else {
            $pdf->Image($logo, 10, 10, 50);
        }
            
        // $pdf->Image($logo, 15, $Ylogo + 2, 55);
        $YabajoLogo = $Ylogo + 50;
        $pdf->Line(15, $YabajoLogo + 8, 85, $YabajoLogo + 8);
        

        $pdf->SetXY(39, $YabajoLogo + 10);
        $pdf->SetFont('helvetica', '', 8);
        $pdf->Cell(0, 5, utf8_decode('ATENDIDO POR'), 0, 1, 'L');
        $YUser = $pdf->GetY();
        $XUser = $pdf->GetX();

        $pdf->SetXY($XUser + 28, $YUser);
        $pdf->SetFont('helvetica', 'B', 8);
        $pdf->Cell(0, 5, utf8_decode(' ' . self::$nota->usuario->operador->nombre_completo), 0, 1, 'L');
        }

    public function footer()
    {
        $this->SetY(-15);
        $this->SetFont('helvetica', 'I', 8);
        $this->Cell(0, 10, utf8_decode('Página ' . $this->PageNo() . '/{nb}'), 0, 0, 'C');
    }
}
