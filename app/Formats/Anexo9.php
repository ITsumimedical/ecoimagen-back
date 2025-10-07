<?php

namespace App\Formats;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Traits\PdfTrait;
use Codedge\Fpdf\Fpdf\Fpdf;

class Anexo9 extends FPDF
{
    use PdfTrait;

    public static $consulta;

    public function generar($anexo9)
    {
        self::$consulta = $anexo9;
        $this->generarPDF('I');
    }

    public function header()
    {
        $this->SetDrawColor(0, 0, 0);
        $this->Rect(4, 5, 202, 287);
        $this->SetDrawColor(0, 0, 0);
    }

    public function footer()
    {
        $this->SetXY(190, 287);
        $this->Cell(10, 4, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }

    public function body()
    {
        $logo = public_path() . "/images/logo.png";
        $this->Image($logo, 7, 9, -320);

        $this->SetFont('Arial', 'B', 9);
        $logo = public_path() . "/images/logo_colombia.png";
        $this->Image($logo, 187, 9, -1500);


        // Extraer la fecha y la hora del campo fecha_hora_inicio
        $fechaHoraInicio = self::$consulta->fecha_hora_inicio;
        $fechaConsulta = date('Y-m-d', strtotime($fechaHoraInicio));
        $horaConsulta = date('H:i:s', strtotime($fechaHoraInicio));

        $this->SetFont('Arial', 'B', 6);
        $this->SetXY(14, 8);
        $this->Cell(172, 4, utf8_decode("Resolución 00004331 19 DIC 2012"), 0, 0, 'R');

        $this->SetXY(10, 8);
        $this->SetFont('Arial', '', 10);
        $this->Cell(192, 4, utf8_decode('REPUBLICA DE COLOMBIA'), 0, 0, 'C');
        $this->SetXY(10, 16);
        $this->SetFont('Arial', '', 10);
        $this->Cell(192, 4, utf8_decode('MINISTERIO DE LA PROTECCION SOCIAL'), 0, 0, 'C');
        $this->SetXY(10, 25);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(192, 4, utf8_decode('ANEXO TECNICO No. 9'), 0, 0, 'C');
        $this->ln();
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(192, 4, utf8_decode('FORMATO ESTANDARIZADO DE REFERENCIA DE PACIENTES'), 0, 0, 'C');
        $this->ln(9);
        $this->SetX(25);
        $this->SetFont('Arial', '', 9);
        $this->Cell(35, 4, utf8_decode('NUMERO INFORME: '), 1, 0, 'l');
        $this->Cell(25, 4, utf8_decode(self::$consulta->id ?? 'N/A'), 1, 0, 'l');
        $this->Cell(25, 4, utf8_decode('Fecha: '), 1, 0, 'l');
        $this->Cell(25, 4, utf8_decode($fechaConsulta ?? 'N/A'), 1, 0, 'l');
        $this->Cell(25, 4, utf8_decode('Hora: '), 1, 0, 'l');
        $this->Cell(25, 4, utf8_decode($horaConsulta ?? 'N/A'), 1, 0, 'l');
        $this->ln(6);
        $this->SetX(4);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(202, 4, utf8_decode('I. DATOS DE LA INSTITUCION PRESTADORA DE SERVICIOS DE SALUD'), 1, 0, 'C');
        $this->ln(6);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Razón Social: '), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(155, 4, utf8_decode('SUMIMEDICAL S.A.S'), 1, 0, 'l');
        $this->ln();
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Código:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode('0500109022'), 1, 0, 'l');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Nit:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode('900033371'), 1, 0, 'l');
        $this->ln();
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Telefono:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode('6044114488'), 1, 0, 'l');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Fax:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode('PENDIENTE'), 1, 0, 'l');
        $this->ln();
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Departamento:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode('ANTIOQUIA'), 1, 0, 'l');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Codigo:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode('005'), 1, 0, 'l');
        $this->ln();
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Municipio:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode('MEDELLÍN'), 1, 0, 'l');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Codigo:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode('149'), 1, 0, 'l');
        $this->ln(6);
        $this->SetX(4);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(202, 4, utf8_decode('II. DATOS DEL PACIENTE'), 1, 0, 'C');
        $this->ln(6);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('1er Apellido'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode(self::$consulta->afiliado->primer_apellido ?? 'N/A'), 1, 0, 'l');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('2do Apellido'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode(self::$consulta->afiliado->segundo_apellido ?? 'N/A'), 1, 0, 'l');
        $this->ln();
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('1er Nombre'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode(self::$consulta->afiliado->primer_nombre ?? 'N/A'), 1, 0, 'l');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('2do Nombre'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode(self::$consulta->afiliado->segundo_nombre ?? 'N/A'), 1, 0, 'l');
        $this->ln();
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Tipo de Documento'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode(mb_strtoupper(self::$consulta->afiliado->tipoDocumento->nombre ?? 'N/A')), 1, 0, 'l');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('No. Documento'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode(self::$consulta->afiliado->numero_documento ?? 'N/A'), 1, 0, 'l');
        $this->ln();
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Fecha De Nacimiento'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(40, 4, utf8_decode(self::$consulta->afiliado->fecha_nacimiento ?? 'N/A'), 1, 0, 'l');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(25, 4, utf8_decode('Edad'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(25, 4, utf8_decode(self::$consulta->afiliado->edad_cumplida ?? 'N/A'), 1, 0, 'l');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Sexo'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(30, 4, utf8_decode((self::$consulta->afiliado->sexo === 'M') ? 'Masculino' : ((self::$consulta->afiliado->sexo === 'F') ? 'Femenino' : 'N/A')), 1, 0, 'l');
        $this->ln();
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Dirección Residencia'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode(self::$consulta->afiliado->direccion_residencia_cargue ?? 'N/A'), 1, 0, 'l');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Telefono'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode(self::$consulta->afiliado->telefono ?? 'N/A'), 1, 0, 'l');
        $this->ln();
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Departamento'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode(self::$consulta->afiliado->departamento_afiliacion->nombre ?? 'N/A'), 1, 0, 'l');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Codigo'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode(self::$consulta->afiliado->departamento_afiliacion->codigo_dane ?? 'N/A'), 1, 0, 'l');
        $this->ln();
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Municipio'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode(self::$consulta->afiliado->municipio_afiliacion->nombre ?? 'N/A'), 1, 0, 'l');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Codigo'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode(self::$consulta->afiliado->municipio_afiliacion->codigo_dane ?? 'N/A'), 1, 0, 'l');
        $this->ln();
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Cobertura en Salud'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(155, 4, utf8_decode('OTRO'), 1, 0, 'l');
        $this->ln();
        $this->SetFont('Arial', 'B', 7);
        $this->Cell(55, 4, utf8_decode('ENTIDAD RESPONSABLE DEL PAGO:'), 0, 0, 'l');
        if (self::$consulta->afiliado->entidad_id == 3) {
            $this->SetFont('Arial', '', 6);
            $this->Cell(60, 4, utf8_decode('Fondo de pasivo social de ferrocarriles nacionales de Colombia'), 1, 0, 'l');
        } else {
            $this->SetFont('Arial', '', 9);
            $this->Cell(60, 4, utf8_decode('FOMAG'), 1, 0, 'l');
        }
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(30, 4, utf8_decode('Codigo'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(45, 4, utf8_decode('RES004'), 1, 0, 'l');
        $this->ln(6);
        $this->SetX(4);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(202, 4, utf8_decode('III. DATOS DE LA PERSONA RESPONSABLE DEL PACIENTE'), 1, 0, 'C');
        $this->ln(6);

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Nombre Completo'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode(self::$consulta->afiliado->nombre_responsable ?? 'N/A'), 1, 0, 'l');
        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(35, 4, utf8_decode('1er Apellido'), 0, 0, 'l');
        // $this->SetFont('Arial', '', 9);
        // $this->Cell(60, 4, utf8_decode(''), 1, 0, 'l');
        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(35, 4, utf8_decode('2do Apellido'), 0, 0, 'l');
        // $this->SetFont('Arial', '', 9);
        // $this->Cell(60, 4, utf8_decode(''), 1, 0, 'l');
        // $this->ln();
        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(35, 4, utf8_decode('1er Nombre'), 0, 0, 'l');
        // $this->SetFont('Arial', '', 9);
        // $this->Cell(60, 4, utf8_decode(''), 1, 0, 'l');
        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(35, 4, utf8_decode('2do Nombre'), 0, 0, 'l');
        // $this->SetFont('Arial', '', 9);
        // $this->Cell(60, 4, utf8_decode(''), 1, 0, 'l');
        $this->ln();
        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(35, 4, utf8_decode('Tipo de Documento'), 0, 0, 'l');
        // $this->SetFont('Arial', '', 9);
        // $this->Cell(60, 4, utf8_decode(''), 1, 0, 'l');
        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(35, 4, utf8_decode('No. Documento'), 0, 0, 'l');
        // $this->SetFont('Arial', '', 9);
        // $this->Cell(60, 4, utf8_decode(''), 1, 0, 'l');
        // $this->ln();
        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(35, 4, utf8_decode('Dirección Residencia'), 0, 0, 'l');
        // $this->SetFont('Arial', '', 9);
        // $this->Cell(60, 4, utf8_decode(''), 1, 0, 'l');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Telefono'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode(self::$consulta->afiliado->telefono_responsable ?? 'N/A'), 1, 0, 'l');

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('PARENTESCO'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(60, 4, utf8_decode(self::$consulta->afiliado->parentesco_responsable ?? 'N/A'), 1, 0, 'l');
        $this->ln();
        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(35, 4, utf8_decode('Departamento'), 0, 0, 'l');
        // $this->SetFont('Arial', '', 9);
        // $this->Cell(60, 4, utf8_decode(''), 1, 0, 'l');
        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(35, 4, utf8_decode('Codigo'), 0, 0, 'l');
        // $this->SetFont('Arial', '', 9);
        // $this->Cell(60, 4, utf8_decode(''), 1, 0, 'l');
        // $this->ln();
        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(35, 4, utf8_decode('Municipio'), 0, 0, 'l');
        // $this->SetFont('Arial', '', 9);
        // $this->Cell(60, 4, utf8_decode(''), 1, 0, 'l');
        // $this->SetFont('Arial', 'B', 9);
        // $this->Cell(35, 4, utf8_decode('Codigo'), 0, 0, 'l');
        // $this->SetFont('Arial', '', 9);
        // $this->Cell(60, 4, utf8_decode(''), 1, 0, 'l');
        $this->ln(6);
        $this->SetX(4);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(202, 4, utf8_decode('IV. PROFESIONAL QUE SOLICITA LA REFERENCIA Y SERVICIO AL CUAL SE REMITE'), 1, 0, 'C');
        $this->ln(6);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Nombre'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(80, 4, utf8_decode(mb_strtoupper(self::$consulta->medicoOrdena->operador->nombre_completo ?? 'N/A')), 1, 0, 'l');
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(25, 4, utf8_decode('Telefono'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(50, 4, utf8_decode('N/A'), 1, 0, 'l');
        $this->ln();
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(35, 4, utf8_decode('Telefono Celular'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(155, 4, utf8_decode('N/A'), 1, 0, 'l');
        $this->ln();
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(55, 4, utf8_decode('Servicio que solicita la referencia:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(135, 4, utf8_decode(mb_strtoupper(self::$consulta->especialidad->nombre ?? 'N/A')), 1, 0, 'l');
        $this->ln();
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(72, 4, utf8_decode('Servicio para el cual se solicita la referencia:'), 0, 0, 'l');
        $this->SetFont('Arial', '', 9);
        $this->Cell(118, 4, utf8_decode(mb_strtoupper(self::$consulta->HistoriaClinica->especialidad ?? 'N/A')), 1, 0, 'l');
        $this->ln(6);
        $this->SetX(4);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(202, 4, utf8_decode('V. INFORMACION CLINICA RELEVANTE'), 1, 0, 'C');
        $this->ln(6);
        $this->Cell(35, 4, utf8_decode('Resumen de Anamnesis:'), 0, 0, 'l');
        $this->ln();
        $this->SetFont('Arial', '', 9);
        $this->MultiCell(190, 4, utf8_decode(mb_strtoupper((self::$consulta->HistoriaClinica->motivo_consulta ?? 'N/A') . ' - ' . (self::$consulta->HistoriaClinica->plan_manejo ?? 'N/A'))), 1, 'J');
        $this->ln(6);
        $this->SetX(4);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(202, 4, utf8_decode('VI.FIRMA Y REGISTRO DEL PROFESIONAL QUE REMITE'), 1, 0, 'C');
        $final = $this->GetY();

        $firma = self::$consulta->medicoOrdena->firma ?? 'N/A';
        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(4, $final + 10);

        if ($firma !== 'N/A' && file_exists(storage_path(substr($firma, 8)))) {
            $this->Image(storage_path(substr($firma, 8)), 85, $final + 30, 50);
        } else {
            $this->Cell(202, 10, utf8_decode(''), 0, 0, 'C');
        }
    }
}
