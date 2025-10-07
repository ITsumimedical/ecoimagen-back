<?php

namespace App\Formats;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Historia\Models\HistoriaClinica;
use App\Http\Modules\Operadores\Models\Operadore;
use App\Http\Modules\Recomendaciones\Models\Recomendaciones;
use App\Http\Modules\Usuarios\Models\User;
use App\Traits\PdfTrait;
use Carbon\Carbon;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Support\Facades\Auth;

class RecomendacionesCups extends Fpdf
{
    use PdfTrait;

    public static $afiliado;
    public static $recomendacion;
    public static $consulta;
    public static $medico;
    public static $historia;
    public static $TEMPIMGLOC;

    public function generar($recomendacionesCups)
    {
        self::$consulta = $recomendacionesCups->consulta;
        self::$recomendacion = $recomendacionesCups->recomendacion;
        self::$medico = self::$consulta->medicoOrdena;
        $this->generarPDF('I');
    }

    public function body()
    {
        $this->SetFont('Arial', 'B', 50);
        $this->SetTextColor(255, 192, 203);
        $this->SetTextColor(0, 0, 0);

        $Y = 14;
        $this->SetFont('Arial', 'B', 9);
        $logo = public_path() . "/images/logo.png";
        $this->Image($logo, 8, 7, -400);
        $this->SetXY(50, 10);
        $this->Cell(80, 4, utf8_decode('SUMIMEDICAL S.A.S'), 0, 0, 'C');
        $this->SetXY(50, $Y);
        $this->Cell(80, 4, utf8_decode('NIT: 900033371'), 0, 0, 'C');
        $this->SetXY(50, $Y + 4);
        $this->Cell(80, 4, utf8_decode('Correo médico: ' . (self::$medico->email ?? 'N/A')), 0, 0, 'C');
        $this->SetXY(50, $Y + 12);

        $Y = 8;
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(120, $Y);
        $this->Cell(88, 4, utf8_decode('Recomendaciones'), 0, 0, 'C');
        $this->SetXY(151, $Y + 4);
        $this->Cell(12, 4, utf8_decode("N°: "), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(10, 4, utf8_decode(self::$consulta->id ?? 'N/A'), 0, 0, 'L');
        $this->SetXY(151, $Y + 8);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(12, 4, utf8_decode('Fecha: '), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $this->Cell(10, 4, utf8_decode(self::$consulta->created_at ?? 'N/A'), 0, 0, 'L');
        self::$consulta->Fechaorden;
        $this->Cell(25, 4, '', 0, 0, 'L');
        $this->SetXY(151, $Y + 12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(12, 4, utf8_decode('Entidad: '), 0, 0, 'L');
        $this->SetFont('Arial', '', 7);
        $entidadTexto = 'N/A';
        if (self::$consulta->afiliado->entidad_id == 1) {
            $entidadTexto = 'FOMAG';
        } elseif (self::$consulta->afiliado->entidad_id == 3) {
            $entidadTexto = 'Ferrocarriles';
        }
        $this->Cell(10, 4, utf8_decode($entidadTexto), 0, 0, 'L');

        $this->Cell(35, 4, '', 0, 0, 'L');

        $this->SetFillColor(216, 216, 216);
        $this->SetFont('Arial', 'B', 9);
        $this->SetXY(5, 28);

        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(108, 4, utf8_decode('Paciente'), 1, 0, 'C', 1);
        $this->Cell(25, 4, utf8_decode('Identificación'), 1, 0, 'C', 1);
        $this->Cell(25, 4, utf8_decode('Telefono'), 1, 0, 'C', 1);
        $this->Cell(30, 4, utf8_decode('F. nacimiento'), 1, 0, 'C', 1);
        $this->Cell(10, 4, 'Edad', 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 8);

        $nombreCompleto = (self::$consulta->afiliado->primer_apellido ?? '') . ' ' .
            (self::$consulta->afiliado->segundo_apellido ?? '') . ' ' .
            (self::$consulta->afiliado->primer_nombre ?? 'N/A');

        $this->Cell(108, 4, utf8_decode($nombreCompleto), 1, 0, 'C');
        $this->Cell(25, 4, utf8_decode(self::$consulta->afiliado->numero_documento ?? 'N/A'), 1, 0, 'C');
        $this->Cell(25, 4, utf8_decode(self::$consulta->afiliado->telefono ?? 'N/A'), 1, 0, 'C');
        $this->Cell(30, 4, utf8_decode(self::$consulta->afiliado->fecha_nacimiento ?? 'N/A'), 1, 0, 'C');
        $this->Cell(10, 4, utf8_decode(self::$consulta->afiliado->edad_cumplida ?? 'N/A'), 1, 0, 'C');

        $this->Ln();
        $this->Ln();

        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(198, 4, utf8_decode('Plan de manejo y recomendaciones'), 1, 0, 'C', 1);
        $this->Ln();

        $this->SetX(5);
        $this->SetFont('Arial', '', 9);
        $this->SetFillColor(255, 255, 255);

        $plan_manejo = utf8_decode(self::$historia->plan_manejo ?? 'Aún no se ha registrado plan de manejo');
        $descripcion = self::$recomendacion->isNotEmpty()
            ? utf8_decode(implode("\n", self::$recomendacion->pluck('descripcion')->toArray()))
            : 'Sin recomendaciones adicionales para el servicio';
        $contenido = $plan_manejo . "\n\n" . $descripcion;

        $this->MultiCell(198, 4, $contenido, 1, 'L', true);

        $this->Ln();
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFont('Arial', 'B', 6);

        if (self::$medico->firma && file_exists(storage_path(substr(self::$medico->firma, 9)))) {

            $this->Text(6, 10, utf8_decode(self::$medico->nombre . " " . self::$medico->apellido));

            $firma_x = 30;
            $firma_y = 70;

            $this->Image(storage_path(substr(self::$medico->firma, 9)), $firma_x, $firma_y, 50);
        }

        $this->SetY(-200);
        $this->SetX(5);


        $linea_y = $this->GetY() - 3;

        $this->Line(7, $linea_y, 100, $linea_y);
        $this->SetFont('Arial', '', 8);

        $operador = Operadore::where('user_id', self::$medico->id)->first();

        $this->SetFont('Arial', 'B', 8);
        $this->Cell(60, 4, utf8_decode('Profesional:' . ' ' . $operador->nombre . " " . $operador->apellido), 0, 0, 'L');
        $this->Ln();
        $this->SetFont('Arial', '', 8);
        $this->Cell(60, 4, utf8_decode($operador->tipo_doc . ' ' . $operador->documento), 0, 0, 'L');
        $this->Ln();

        $this->SetFont('Arial', 'I', 8);
        $this->SetX(150);

        $funcionario = Operadore::where('user_id', Auth::id())->first();
        $this->MultiCell(60, 4, utf8_decode('Funcionario imprime:' . ' ' . $funcionario->nombre . " " . $funcionario->apellido), 0, 0, 'L');
        $this->SetX(150);
        $this->MultiCell(60, 4, utf8_decode('Fecha impresión:' . ' ' . Carbon::now()), 0, 0, 'L');
    }
}
