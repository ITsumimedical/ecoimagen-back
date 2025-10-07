<?php
namespace App\Formats;

use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Especialidades\Models\Especialidade;
use App\Http\Modules\EvaluacionDesempeño\evaluaciones_desempeños\Models\EvaluacionesDesempeno;
use App\Http\Modules\Operadores\Models\Operadore;
use Codedge\Fpdf\Fpdf\Fpdf;

class CertificadoEvaluacionDesempeno extends Fpdf
{
    public static $empleado;
    public static $evaluacion;
    public static $datos;
    public static $jefe;
    public static $cargo;

    public function generate($id)
    {
        self::$datos = $id;
        self::$evaluacion = EvaluacionesDesempeno::where('id',self::$datos)->first();
        self::$empleado = Empleado::where('id',self::$evaluacion->empleado_id)->first();
        self::$jefe = Operadore::where('user_id',self::$empleado->jefe_inmediato_id)->first();
        self::$cargo = Especialidade::where('id',self::$empleado->especialidad_id)->first();
        $pdf = new CertificadoEvaluacionDesempeno('L','mm','A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $this->body($pdf);
        $pdf->Output();
    }

    public function header(){
        $fondo = public_path(). "/certificadodesempeno.png";
        $this->Image($fondo, 0, 0, 297);
        // return $fondo;
    }

    public function body($pdf)
    {

        $y = 60;
        $pdf->SetTextColor(27, 40, 151);

        $pdf->SetXY(50, $y);
        $pdf->SetFont('Arial', 'B', 24);
        $pdf->cell(200, 4, utf8_decode('OTORGADO A: '), 0, 0, 'C');
        $pdf->ln();

        $nombreEmpleado = isset(self::$empleado->nombre_completo) ? self::$empleado->nombre_completo : '';
        $pdf->SetFont('Arial', 'B', 20);
        $pdf->SetXY(50, $y + 20);
        $pdf->cell(200, 6, utf8_decode(strtoupper($nombreEmpleado)), 'B', 0, 'C');
        $pdf->ln();

        $calificacion = isset(self::$evaluacion->resultado) ? self::$evaluacion->resultado : '';
        $y1 = $pdf->GetY();
        $pdf->SetXY(50, $y1 + 10);
        $pdf->cell(200, 4, utf8_decode('CON UNA CALIFICACIÓN: ' . $calificacion . '%'), 0, 0, 'L');
        $pdf->ln();

        $fechaInicial = isset(self::$evaluacion->fecha_inicial_periodo) ? self::$evaluacion->fecha_inicial_periodo : '';
        $fechaFinal = isset(self::$evaluacion->fecha_final_periodo) ? self::$evaluacion->fecha_final_periodo : '';
        $y2 = $pdf->GetY();
        $pdf->SetXY(50, $y2 + 8);
        $pdf->cell(200, 4, utf8_decode('PERIODO EVALUADO: ' . $fechaInicial . ' a ' . $fechaFinal), 0, 0, 'L');
        $pdf->ln();

        $jefeNombre = isset(self::$jefe->nombre) ? self::$jefe->nombre : '';
        $jefeApellido = isset(self::$jefe->apellido) ? self::$jefe->apellido : '';
        $y3 = $pdf->GetY();
        $pdf->SetFont('Times', 'I', 12);
        $pdf->SetXY(65, $y3 + 25);
        $pdf->MultiCell(75, 6, utf8_decode(strtoupper($jefeNombre . ' ' . $jefeApellido)), 'B', 'C');

        $yAfterJefe = $pdf->GetY();
        $pdf->SetXY(65, $yAfterJefe + 2);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(62, 6, utf8_decode('Jefe inmediato'), 0, 1, 'C');

        $pdf->SetFont('Times', 'I', 12);
        $pdf->SetXY(162, $y3 + 25);
        $pdf->Cell(68, 6, utf8_decode('PAOLA ISABEL FONSECA DIAZ'), 'B', 1, 'C');
        $pdf->SetXY(162, $y3 + 32);
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(68, 6, utf8_decode('Subdirectora talento humano'), 0, 0, 'C');


    }
}
