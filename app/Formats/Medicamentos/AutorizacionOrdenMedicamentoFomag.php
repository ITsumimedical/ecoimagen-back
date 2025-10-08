<?php

namespace App\Formats\Medicamentos;

use Codedge\Fpdf\Fpdf\Fpdf;
use Illuminate\Http\Response;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;

class AutorizacionOrdenMedicamentoFomag extends Fpdf
{
    protected $orden;
    protected $consulta;
    protected $afiliado;

    public function __construct()
    {
        parent::__construct('P', 'mm', 'A4');
    }

    public function Header()
    {
        $logo1 = public_path("/images/logoEcoimagen.png");
        $logo2 = null;

        if (isset($this->afiliado->entidad_id)) {
            if ($this->afiliado->entidad_id === 1) {
                $logo2 = public_path("/images/logoFomag.png");
            } elseif ($this->afiliado->entidad_id === 3) {
                $logo2 = public_path("/images/logotipo_fps.jpg");
            }
        }

        $this->Image($logo1, 12, 11, 16);
        if ($logo2) {
            $this->Image($logo2, 30, 10, 15);
        }

        $this->SetFont('Arial', 'B', 12);
        $this->SetXY(55, 14);
        $this->Cell(100, 10, utf8_decode('FORMATO DE AUTORIZACIÓN DE MEDICAMENTOS'), 0, 0, 'C');

        $this->SetFont('Arial', 'B', 10);
        $this->SetXY(160, 15);
        $this->Cell(40, 6, utf8_decode('Radicado: ') . $this->orden->id, 0, 1, 'R');

        $this->Ln(16);
    }

    public function generar(OrdenArticulo $ordenArticulo, int $estadoId): Response
    {
        $this->orden = $ordenArticulo->orden;
        $this->consulta = $this->orden->consulta;
        $this->afiliado = $this->consulta->afiliado;

        $ordenArticulos = OrdenArticulo::with('codesumi')
            ->where('orden_id', $this->orden->id)
            ->where('estado_id', $estadoId)
            ->get();

        $this->AddPage();

        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 7, utf8_decode('Información de la Solicitud'), 0, 1);
        $this->SetFont('Arial', '', 10);
        $this->Cell(50, 6, utf8_decode('Fecha de solicitud:'), 0, 0);
        $this->Cell(50, 6, now()->format('d/m/Y'), 0, 1);
        $this->Cell(50, 6, utf8_decode('Entidad prestadora:'), 0, 0);
        $this->Cell(100, 6, utf8_decode('SUMIMEDICAL IPS SAS'), 0, 1);

        $operador = optional(optional($this->consulta->user)->operador);
        $profesional = trim($operador->nombre . ' ' . $operador->apellido);
        $documento = $operador->documento ?? 'N/A';
        $registro = $operador->registro_medico ?? 'N/A';

        $this->Cell(50, 6, utf8_decode('Médico tratante:'), 0, 0);
        $this->Cell(140, 6, utf8_decode("{$profesional} - CC {$documento} - RM {$registro}"), 0, 1);

        $this->Ln(5);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 7, utf8_decode('Datos del Paciente'), 0, 1, 'L');

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(40, 6, utf8_decode('Identificación: '), 0, 0, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 6, 'CC ' . ($this->afiliado->documento ?? ''), 0, 1, 'L');

        $this->SetFont('Arial', 'B', 10);
        $this->Cell(40, 6, utf8_decode('Nombre: '), 0, 0, 'L');
        $this->SetFont('Arial', '', 10);
        $this->Cell(0, 6, utf8_decode($this->afiliado->nombre_completo ?? ''), 0, 1, 'L');

        $this->Ln(5);
        $this->SetFont('Arial', 'B', 11);
        $this->Cell(0, 7, utf8_decode('Medicamentos Solicitados'), 0, 1);

        $this->SetFillColor(230, 230, 230);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(20, 8, utf8_decode('Código'), 1, 0, 'C', true);
        $this->Cell(60, 8, utf8_decode('Descripción'), 1, 0, 'C', true);
        $this->Cell(65, 8, utf8_decode('Dosificación'), 1, 0, 'C', true);
        $this->Cell(45, 8, utf8_decode('Duración (Días al mes)'), 1, 1, 'C', true);

        $this->SetFont('Arial', '', 9);
        foreach ($ordenArticulos as $item) {
            $codigo = $item->codesumi->codigo ?? 'N/A';
            $nombre = utf8_decode($item->codesumi->nombre ?? 'N/A');
            $entrega = utf8_decode($item->duracion ?? '-');
            $dosificacion = utf8_decode($item->dosificacion_medico ?? '-');

            $maxLines = max(
                $this->NbLines(60, $nombre),
                $this->NbLines(65, $dosificacion)
            );
            $height = $maxLines * 5;
            $x = $this->GetX();
            $y = $this->GetY();

            $this->MultiCell(20, $height, $codigo, 1, 'C');
            $this->SetXY($x + 20, $y);
            $this->MultiCell(60, 5, $nombre, 0);
            $this->SetXY($x + 80, $y);
            $this->MultiCell(65, 5, $dosificacion, 0);
            $this->SetXY($x + 145, $y);
            $this->MultiCell(45, $height, $entrega, 1, 'C');

            $this->SetXY($x, $y);
            $this->Cell(20, $height, '', 1);
            $this->Cell(60, $height, '', 1);
            $this->Cell(65, $height, '', 1);
            $this->Cell(45, $height, '', 1);
            $this->SetXY($x, $y + $height);

            $observacion = $item->observacion ?? 'Sin observaciones';
            $this->SetFont('Arial', 'I', 8);
            $this->MultiCell(0, 6, utf8_decode("Observación médica: {$observacion}"), 1);
            $this->Ln(2);
            $this->SetFont('Arial', '', 9);
        }

        $this->SetFont('Arial', 'B', 9);
        $this->Cell(0, 6, utf8_decode('Fecha de generación del documento: ') . now()->format('Y/m/d'), 0, 1);
        $this->Ln(5);

        $this->SetFont('Arial', '', 8);
        $this->MultiCell(0, 5, utf8_decode("Estimado usuario: su solicitud ha sido procesada. Recibirá notificación vía correo electrónico cuando se haya completado la autorización del medicamento. También puede hacer seguimiento desde el módulo de autogestión disponible en: https://horus2.horus-health.com/"));
        $this->Ln(2);

        $this->MultiCell(0, 5, utf8_decode("Recuerde mantener actualizados sus datos de contacto."));
        $this->Ln(2);

        $celular = trim($this->afiliado->celular1 ?? 'N/A');
        $correo = trim(strtolower($this->afiliado->correo1 ?? 'N/A'));
        $this->MultiCell(0, 5, utf8_decode("Celular registrado: {$celular}  |  Correo registrado: {$correo}"));

        return response($this->Output('S'), 200)
            ->header('Content-Type', 'application/pdf');
    }

    protected function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }
}
