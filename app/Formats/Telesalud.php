<?php

namespace App\Formats;

use App\Http\Modules\Telesalud\Models\Telesalud as ModelsTelesalud;
use App\Traits\PdfTrait;
use Carbon\Carbon;
use Codedge\Fpdf\Fpdf\Fpdf;

class Telesalud extends FPDF
{
    use PdfTrait;

    private static $telesalud;

    public function generar($telesalud)
    {
        self::$telesalud = $telesalud;
        $this->generarPDF('I');
    }

    public function header()
    {
        $x = $this->GetX();
        $firmaY = $this->GetY();

        // Reducir el tamaño del rectángulo
        $this->SetDrawColor(140, 190, 56);
        $this->Rect(5, 5, 200, 287); // Ajustar las coordenadas y el tamaño para hacerlo más pequeño

        // Cambiar el tamaño del logo
        $this->SetDrawColor(0, 0, 0);
        $this->SetFont('Arial', 'B', 8);
        $logo = public_path() . "/logo.png";
        $this->Image($logo, 14, 10.5, 30); // Cambiar el tamaño del logo a 30 (antes estaba en -220)

        // Reducir el tamaño de la fuente del texto de encabezado
        $this->SetFont('Arial', '', 6); // Cambiar el tamaño de la fuente a 6
        $this->SetXY(0, 30.5); // Ajustar la posición Y más hacia arriba
        $this->Cell(60, 2, utf8_decode('NIT:900033371-4 Res: 004'), 0, 0, 'C');
    }

    public function body()
    {
        $this->SetXY(47, 10);
        $this->SetFont('Arial', 'B', 9);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFillColor(214, 214, 214);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(151, 6, utf8_decode('DATOS DEL AFILIADO'), 1, 0, 'C', 1);
        $this->SetTextColor(0, 0, 0);
        $this->SetDrawColor(0, 0, 0);

        // Id Junta
        $this->SetXY(47, 16);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(4.5, 6, utf8_decode('ID'), 1, 0, 'L');
        $this->SetFont('Arial', '', 8);
        $this->cell(14, 6, utf8_decode(self::$telesalud->id ?? ''), 1, 0, 'J');

        // Nombre
        $this->SetXY(65.5, 16);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(14.5, 6, utf8_decode('NOMBRE'), 1, 0, 'L');
        $this->SetFont('Arial', '', 8);
        $this->cell(118, 6, utf8_decode(self::$telesalud->afiliado->nombre_completo ?? ''), 1, 0, 'J');

        $this->Ln();

        // Tipo de Documento
        $this->SetXY(47, 22);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(33, 6, utf8_decode('TIPO DE DOCUMENTO'), 1, 0, 'L');
        $this->SetFont('Arial', '', 8);
        $this->cell(46.5, 6, utf8_decode(self::$telesalud->afiliado->tipoDocumento->nombre ?? ''), 1, 0, 'J');

        // Numero de Documento
        $this->SetXY(126.5, 22);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(38.5, 6, utf8_decode('NÚMERO DE DOCUMENTO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(33, 6, utf8_decode(self::$telesalud->afiliado->numero_documento ?? ''), 1, 0, 'l');

        $this->Ln();

        // Edad
        $this->SetXY(47, 28);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(10, 6, utf8_decode('EDAD'), 1, 0, 'L');
        $this->SetFont('Arial', '', 8);
        $this->cell(9, 6, utf8_decode(self::$telesalud->afiliado->edad_cumplida ?? ''), 1, 0, 'J');

        // Telefono
        $this->SetXY(66, 28);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(17.5, 6, utf8_decode('TELÉFONO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(43, 6, utf8_decode(self::$telesalud->afiliado->telefono ?? ''), 1, 0, 'J');

        // Celular
        $this->SetXY(126.5, 28);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(16, 6, utf8_decode('CELULAR'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(55.5, 6, utf8_decode(self::$telesalud->afiliado->celular1 ?? ''), 1, 0, 'J');

        $this->Ln();

        // Correo Electronico
        $this->SetX(12, 34);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(35, 6, utf8_decode('CORREO ELECTRÓNICO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(151, 6, utf8_decode(self::$telesalud->afiliado->correo1 ?? ''), 1, 0, 'J');

        $this->Ln();

        // IPS
        $this->SetXY(12, 40);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(35, 6, utf8_decode('IPS'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(151, 6, utf8_decode(self::$telesalud->afiliado->ips->nombre ?? ''), 1, 0, 'J');

        $this->Ln();
        $this->Ln();

        // Detalles
        $this->SetX(12, 46);
        $this->SetFont('Arial', 'B', 9);
        $this->SetFillColor(214, 214, 214);
        $this->Cell(186, 6, utf8_decode('DETALLES DE LA TELESALUD'), 1, 1, 'C', 1);


        // Fecha de Registro
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 6, utf8_decode('FECHA DE REGISTRO'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 6, utf8_decode(Carbon::parse(self::$telesalud->created_at)->format('d/m/Y') ?? ''), 1, 0, 'J');

        // Especialidad
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(25, 6, utf8_decode('ESPECIALIDAD'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(68, 6, utf8_decode(self::$telesalud->especialidad->nombre ?? ''), 1, 1, 'J');


        // Tipo de Estrategia
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(186, 6, utf8_decode('TIPO DE ESTRATEGIA'), 1, 0, 'C', 1);

        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(186, 6, utf8_decode(self::$telesalud->tipoEstrategia->nombre ?? ''), 1, 'C');

        // Servicio
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(186, 6, utf8_decode('SERVICIO'), 1, 0, 'C', 1);
        $this->Ln();

        $this->SetX(12, 83);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(186, 6, utf8_decode(self::$telesalud->servicio->nombre ?? ''), 1, 'C');

        // Motivo
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 9);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFillColor(214, 214, 214);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(186, 6, utf8_decode('MOTIVO'), 1, 0, 'C', 1);
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(186, 6, utf8_decode(self::$telesalud->motivo ?? ''), 1, 'J');

        // Resumen Historia Clinica
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 9);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFillColor(214, 214, 214);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(186, 6, utf8_decode('RESUMEN DE LA HISTORIA CLÍNICA'), 1, 0, 'C', 1);
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(186, 6, utf8_decode(self::$telesalud->resumen_hc ?? ''), 1, 'J');

        // Diagnósticos
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 9);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFillColor(214, 214, 214);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(186, 6, utf8_decode('DIAGNÓSTICOS'), 1, 0, 'C', 1);
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', '', 8);

        // Verificar si hay CIE10 disponibles
        if (!empty(self::$telesalud->consulta->cie10Afiliado)) {
            $listaCIE10 = "";
            foreach (self::$telesalud->consulta->cie10Afiliado as $cie10) {
                $listaCIE10 .= " - " . utf8_decode($cie10->cie10->codigo_cie10 . ' - ' . $cie10->cie10->nombre) . "\n";
            }
            $this->MultiCell(186, 6, utf8_decode($listaCIE10), 1, 'J');
        } else {
            $this->MultiCell(186, 6, utf8_decode('No se encontraron diagnósticos asociados'), 1, 'J');
        }

        $textoRespuesta = in_array(self::$telesalud->tipoEstrategia->id, [1, 2])
            ? 'RESPUESTA DE LA JUNTA DE PROFESIONALES'
            : 'RESPUESTA DEL ESPECIALISTA';

        // Respuesta del Especialista o de la Junta
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 9);
        $this->SetDrawColor(0, 0, 0);
        $this->SetFillColor(214, 214, 214);
        $this->SetTextColor(0, 0, 0);
        $this->Cell(186, 6, utf8_decode($textoRespuesta), 1, 0, 'C', 1);
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', '', 8);

        // Obtener la gestion
        $gestion = self::$telesalud->gestiones->first();

        // Prioridad
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 6, utf8_decode('PRIORIDAD'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 6, utf8_decode($gestion->prioridad ?? ''), 1, 0, 'J');

        // Pertinencia de la solicitud
        $this->SetX(105);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(46.5, 6, utf8_decode('PERTINENCIA DE LA SOLICITUD'), 1, 0, 'l');
        $this->SetFont('Arial', '', 8);
        $this->Cell(46.5, 6, utf8_decode($gestion->pertinencia_solicitud ?? ''), 1, 0, 'J');
        $this->Ln();

        // Observación
        $this->SetX(12);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(186, 6, utf8_decode('OBSERVACIÓN'), 1, 0, 'C', 1);
        $this->Ln();

        $this->SetX(12);
        $this->SetFont('Arial', '', 8);
        $this->MultiCell(186, 6, utf8_decode($gestion->observacion ?? ''), 1, 'J');

        if (in_array(self::$telesalud->tipoEstrategia->id, [1, 2])) {
            // Institución Prestadora
            $this->SetX(12);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(46.5, 6, utf8_decode('INSTITUCIÓN PRESTADORA'), 1, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->Cell(139.5, 6, utf8_decode($gestion->institucionPrestadora->nombre ?? ''), 1, 0, 'J');

            $this->Ln();

            // EAPB
            $this->SetX(12);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(20, 6, utf8_decode('EAPB'), 1, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->Cell(166, 6, utf8_decode($gestion->eapb->nombre ?? ''), 1, 0, 'J');
            $this->Ln();

            // Evaluación Junta
            $this->SetX(12);
            $this->SetFont('Arial', 'B', 9);
            $this->Cell(186, 6, utf8_decode('EVALUACIÓN DE LA JUNTA DE PROFESIONALES'), 1, 0, 'C', 1);
            $this->Ln();

            $this->SetX(12);
            $this->SetFont('Arial', '', 8);
            $this->MultiCell(186, 6, utf8_decode($gestion->evaluacion_junta ?? ''), 1, 'J');

            // Prioridad
            $this->SetX(12);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(93, 6, utf8_decode('¿LA JUNTA DE PROFESIONALES DE SALUD APRUEBA?'), 1, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->Cell(93, 6, utf8_decode($gestion->junta_aprueba ?? ''), 1, 0, 'J');
            $this->Ln();

            // Pertinencia de la solicitud
            $this->SetX(12);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(93, 6, utf8_decode('CLASIFICACIÓN DE PRIORIDAD DE SERVICIO AMBULATORIOD'), 1, 0, 'l');
            $this->SetFont('Arial', '', 8);
            $this->Cell(93, 6, utf8_decode($gestion->clasificacion_prioridad ?? ''), 1, 0, 'J');
            $this->Ln();
        }

        switch (self::$telesalud->tipoEstrategia->id) {
            case 1:
            case 2:
                // Obtener las coordenadas iniciales
                $xInicial = 12;
                $y = $this->GetY();
                $anchoFirma = 46.5; // Ancho de cada celda de firma
                $altoFirma = 25; // Altura de cada celda de firma
                $espacioHorizontal = 0; // Sin espacio entre firmas horizontalmente
                $espacioVertical = 0; // Sin espacio entre filas de firmas
                $contadorFirmas = 0;

                // Verificar si hay suficiente espacio para las firmas en la página actual
                if ($y + $altoFirma + 20 > $this->GetPageHeight() - 20) {
                    $this->AddPage(); // Añadir una nueva página si no hay espacio suficiente
                    $y = 20; // Restablecer la posición Y al inicio de la nueva página
                }

                // Iterar sobre cada integrante (hasta 4 por fila)
                foreach (self::$telesalud->integrantes as $integrante) {
                    // Definir la posición X para cada firma
                    $x = $xInicial + ($contadorFirmas * ($anchoFirma + $espacioHorizontal));

                    // Dibujar la celda con bordes alrededor de la firma
                    $this->Rect($x, $y, $anchoFirma, $altoFirma);

                    // Verificar si el integrante tiene una firma asociada
                    if (!empty($integrante->firma)) {
                        $rutaFirma = storage_path(substr($integrante->firma, 9)) ?? '';

                        // Verificar si la imagen de la firma existe en la ruta especificada
                        if (file_exists($rutaFirma)) {
                            // Agregar la imagen de la firma dentro de la celda
                            $margenIzquierdo = $x + 5; // Margen izquierdo dentro de la celda
                            $margenSuperior = $y + 2; // Margen superior dentro de la celda
                            $this->Image($rutaFirma, $margenIzquierdo, $margenSuperior, 35, 15); // Ajustar la posición y tamaño de la firma
                        } else {
                            $this->SetXY($x, $y + 5);
                            $this->SetFont('Arial', '', 6);
                            $this->MultiCell($anchoFirma, 6, utf8_decode('No se encontró la firma.'), 0, 'C');
                        }
                    } else {
                        $this->SetXY($x, $y + 5);
                        $this->SetFont('Arial', '', 6);
                        $this->MultiCell($anchoFirma, 6, utf8_decode('No se encontró la firma.'), 0, 'C');
                    }

                    // Agregar el nombre del integrante debajo de la firma o del texto de aviso
                    $nombreIntegrante = $integrante->operador->nombre_completo ?? 'Nombre no disponible';
                    $this->SetXY($x, $y + 17);
                    $this->SetFont('Arial', 'B', 6);
                    $this->Cell($anchoFirma, 6, utf8_decode($nombreIntegrante), 0, 0, 'C');

                    // Agregar el registro médico debajo del nombre completo
                    $registroMedico = $integrante->operador->registro_medico ?? 'Registro no disponible';
                    $this->SetXY($x, $y + 20); // Ajusta la posición Y para colocar el registro médico debajo
                    $this->SetFont('Arial', 'B', 6);
                    $this->Cell($anchoFirma, 6, utf8_decode($registroMedico), 0, 0, 'C');

                    // Incrementar el contador de firmas
                    $contadorFirmas++;

                    // Si llegamos a 4 firmas en una fila, movernos a la siguiente fila
                    if ($contadorFirmas == 4) {
                        $contadorFirmas = 0;
                        $y += $altoFirma + $espacioVertical; // Mover hacia abajo para la siguiente fila

                        // Verificar si hay suficiente espacio para la siguiente fila
                        if ($y + $altoFirma > $this->GetPageHeight() - 20) {
                            $this->AddPage(); // Añadir una nueva página si no hay espacio suficiente
                            $y = 20; // Restablecer la posición Y al inicio de la nueva página
                        }
                    }
                }

                // Ajustar la posición después de todas las firmas
                $this->SetY($y + $altoFirma + $espacioVertical);
                break;


            case 3:
            case 4:
            case 5:
            case 6:
                // Firma y Registro Médico para estrategia 3, 4, 5, 6
                $x = 12;
                $y = $this->GetY();
                $ancho = 186;
                $alto = 35;

                // Dibujar la celda con bordes alrededor de la firma y el registro médico
                $this->Rect($x, $y, $ancho, $alto);

                // Verificar si hay información del médico y si tiene una firma asociada
                if ($gestion && !empty($gestion->funcionarioGestiona->firma)) {
                    $rutaFirma = storage_path(substr($gestion->funcionarioGestiona->firma, 9)) ?? '';

                    // Verificar si la imagen de la firma existe en la ruta especificada
                    if (file_exists($rutaFirma)) {
                        // Obtener las coordenadas para centrar la firma dentro de la celda
                        $margenIzquierdo = $x + ($ancho / 2) - 25;
                        $margenSuperior = $y + 5;

                        // Agregar la imagen de la firma dentro de la celda
                        $this->Image($rutaFirma, $margenIzquierdo, $margenSuperior, 50, 20);
                    } else {
                        $this->SetXY($x, $y + 6);
                        $this->MultiCell(186, 6, utf8_decode('No se encontró la firma del médico.'), 0, 'C');
                    }
                } else {
                    $this->SetXY($x, $y + 6);
                    $this->MultiCell(186, 6, utf8_decode('No se encontraron datos del médico o firma asociada.'), 0, 'C');
                }

                $nombreCompleto = $gestion->funcionarioGestiona->operador->nombre_completo ?? 'Nombre no disponible';
                $this->SetXY($x, $y + 24);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell($ancho, 6, utf8_decode($nombreCompleto), 0, 0, 'C');

                // Agregar el registro médico debajo de la firma o del texto de aviso
                $registroMedico = $gestion->funcionarioGestiona->operador->registro_medico ?? 'No disponible';
                $this->SetXY($x, $y + 28);
                $this->SetFont('Arial', 'B', 8);
                $this->Cell($ancho, 6, utf8_decode("REGISTRO MÉDICO: " . $registroMedico), 0, 0, 'C');

                // Ajustar la posición después de la celda
                $this->SetY($y + $alto);
                break;
        }
    }


    public function footer()
    {
        $this->SetXY(177, 285);
        $this->Cell(18, 2, utf8_decode('Página ') . $this->PageNo() . ' de {nb}', 0, 0, 'C');
    }
}
