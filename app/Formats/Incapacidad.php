<?php

namespace App\Formats;

use App\Http\Modules\Transcripciones\Transcripcion\Models\Transcripcione;
use App\Traits\PdfTrait;
use Codedge\Fpdf\Fpdf\Fpdf;

class Incapacidad extends Fpdf
{
    use PdfTrait;

    public static $incapacidad;

    public function generar($incapacidades)
    {
        self::$incapacidad = $incapacidades->incapacidad;
        $this->generarPDF('I');
    }

    public function Header()
    {
        $this->SetFont('Arial', 'B', 10);
        $this->SetTextColor(0, 0, 0);

        $X = 6; // Posición X inicial
        $Y = 6; // Posición Y inicial - Ajustado para dejar espacio debajo del logo
        $width = 60; // Ancho deseado del logo (en milímetros)
        $height = 0; // Altura automática según el ancho (0)

        $logo = public_path() . "/images/sumi.png";
        $this->Image($logo, $X, $Y, $width, $height);

        // $this->SetFont('Arial', 'B', 12);
        // $this->SetXY($X + $width + 10, $Y);
        // $this->Cell(50, 8, 'Administrado por', 0, 1);

        // $segunda_imagen = public_path() . "/images/fiduPrevisora.png";
        // $this->Image($segunda_imagen, $X + $width + 10, $Y + 9, 40);
        $texto_adicional = 'CERTIFICACION DE INCAPACIDADES' . "\n" . 'DOCENTES AFILIADOS' . "\n" . 'FONDO DE PRESTACIONES SOCIALES DEL MAGISTERIO';
        $this->SetFont('Arial', '', 8);
        $ancho_disponible = $this->GetPageWidth() - ($X + $width + 20);
        $this->SetXY($X + $width + 10, $Y);
        $this->MultiCell($ancho_disponible, 8, $texto_adicional, 0, 'R');
        $this->SetY(40);
    }

    public function body()
    {
        $this->SetFont('Arial', '', 8);
        $this->SetTextColor(0, 0, 0);

        $afiliado = self::$incapacidad->consulta->afiliado ?? null;
        $operador = self::$incapacidad->users->operador ?? null;

        $medicoNombre = $operador->nombre_completo ?? 'N/A';
        $medicoDocumento = $operador->documento ?? 'N/A';

        // Se valida si la consulta proviene de una transcripción, el medico que ordena es el implicito en la transcripción más no el usuario que realiza la transcripción
        if (self::$incapacidad->consulta && self::$incapacidad->consulta->tipo_consulta_id === 1) {
            $transcripcion = Transcripcione::where('consulta_id', self::$incapacidad->consulta_id)->first();
            if ($transcripcion) {
                $medicoNombre = $transcripcion->nombre_medico_ordeno ?? $medicoNombre;
                $medicoDocumento = $transcripcion->documento_medico_ordeno ?? $medicoDocumento;
            }
        }

        $campos = [
            'DEPARTAMENTO' => utf8_decode($afiliado->departamento_atencion->nombre ?? 'N/A'),
            'CIUDAD/MUNICIPIO' => utf8_decode($afiliado->municipio_atencion->nombre ?? 'N/A'),
            'NOMBRES Y APELLIDOS' => utf8_decode($afiliado->nombre_completo ?? 'N/A'),
            'DOCUMENTO DE IDENTIFICACION' => utf8_decode($afiliado->numero_documento ?? 'N/A'),
            'EDAD' => utf8_decode($afiliado->edad_cumplida ?? 'N/A'),
            'ENTIDAD TERRITORIAL CERTIFICADA EN EDUCACION' => 'N/A',
            'INSTITUCION EDUCATIVA' => utf8_decode(self::$incapacidad->colegio->nombre ?? 'N/A'),
            'FECHA DE INICIO DE INCAPACIDAD' => utf8_decode(self::$incapacidad->fecha_inicio ?? 'N/A'),
            'FECHA DE TERMINACION DE INCAPACIDAD' => utf8_decode(self::$incapacidad->fecha_final ?? 'N/A'),
            'NUMERO DE DIAS' => utf8_decode(self::$incapacidad->dias ?? 'N/A'),
            'PRORROGA' => utf8_decode(self::$incapacidad->prorroga ?? 'N/A'),
            'DIAGNOSTICO' => utf8_decode(self::$incapacidad->cie10->nombre ?? 'N/A'),
            'CONTINGENCIA' => utf8_decode(self::$incapacidad->contingencia ?? 'N/A'),
            'MEDICO/ PROFESIONAL TRATANTE' => utf8_decode($medicoNombre),
            'REGISTRO MEDICO/No IDENTIFICACION' => utf8_decode($medicoDocumento),
            'OBSERVACIONES' => utf8_decode(self::$incapacidad->descripcion_incapacidad ?? 'N/A'),
            'FECHA DE REGISTRO' => utf8_decode(self::$incapacidad->created_at ?? 'N/A'),
        ];

        // Imprime cada campo
        foreach ($campos as $campo => $valor) {
            $this->SetFont('Arial', 'B', 8);
            $titulo = $campo . ':';
            $this->Cell($this->GetStringWidth($titulo) + 2, 5, $titulo, 0, 0);
            $this->SetFont('Arial', '', 8);
            $this->Cell(0, 5, $valor, 0, 1);
        }

        $this->Ln();
        $this->Ln();
        $imagenGobierno = public_path() . "/images/gobiernoColombia.png";
        $this->Image($imagenGobierno, 10);

        $imagenDatosFomag = public_path() . "/images/DatosFomag.png";
        $anchoImagenDatosFomag = 130;
        $this->Image($imagenDatosFomag, 70, 135, $anchoImagenDatosFomag);
    }
}
