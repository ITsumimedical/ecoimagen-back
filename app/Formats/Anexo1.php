<?php

namespace App\Formats;

use App\Traits\PdfTrait;
use Codedge\Fpdf\Fpdf\Fpdf;


class Anexo1 extends Fpdf
{
    use PdfTrait;

    protected static $anexo;
    protected static $ordenProcedimiento;
    protected static $afiliado;
    protected static $consulta;
    protected static $historiaClinica;
    protected static $cie10;
    protected static $cie10Relacionado;

    protected static int $tipo;


    public function generar($anexo3Servicios, int $tipo)
    {

        self::$ordenProcedimiento = $anexo3Servicios->ordenProcedimiento;
        self::$afiliado = $anexo3Servicios->afiliado;
        self::$consulta = $anexo3Servicios->consulta;
        self::$historiaClinica = $anexo3Servicios->historiaClinica;
        self::$cie10 = $anexo3Servicios->cie10;
        self::$cie10Relacionado =  $anexo3Servicios->cie10Relacionado;
        self::$tipo = $tipo;

        $this->generarPDF('I');
    }

    public function header()
    {


        $this->Rect(15, 10, 180, 25);
        $this->Rect(16, 11, 30, h: 23);
        $this->Rect(47, 11, 110, h: 23);

        $this->SetFont('Arial', 'B', 9);

        #negrilla
        #texto fila 1 cuadros
        $this->Text(159, 16, utf8_decode("Código:"));
        $this->Rect(158, 11, 16, h: 7);
        $this->Rect(175, 11, 19, h: 7);

        #texto fila 2 cuadros
        $this->Text(159, 24, utf8_decode("Versión:"));
        $this->Rect(158, 19, 16, h: 7);
        $this->Rect(175, 19, 19, h: 7);

        #texto fila 3 cuadros
        $this->Text(159, 32, utf8_decode("Fecha:"));
        $this->Rect(158, 27, 16, h: 7);
        $this->Rect(175, 27, 19, h: 7);

        #sin negrilla
        $this->SetFont('Arial', '', 9);
        $this->Text(176, 16, utf8_decode("FO-PS-120"));
        $this->Text(176, 24, utf8_decode("01"));
        $this->Text(176, 32, utf8_decode("04-04-2025"));



        $this->SetFont('Arial', 'B', 9);
        $logo = public_path() . "/images/logoEcoimagen.png";
        $this->Image($logo, 18, 12, 25);



        $this->SetFont('Arial', 'B', 14);
        $this->Text(77, 17, utf8_decode("ANEXO TÉCNICO N° 1"));
        $this->SetY(19);
        $this->SetX(x: 65);

        $this->SetFont('Arial', '', 7);
        $this->Cell(80, 4, utf8_decode('SUMIMEDICAL S.A.S'), 0, 0.5, 'C');
        $this->SetX(x: 65);
        $this->Cell(80, 4, utf8_decode('NIT. 900033371-4'), 0, 0.5, 'C');

        $this->SetX(x: 65);
        $this->Cell(80, 4, utf8_decode('CALLE 37 SUR # 37 - 23 ENVIGADO'), 0, 0.5, 'C');

        $this->SetX(x: 65);
        $this->Cell(80, 4, utf8_decode('Telefono: 6044114488'), 0, 0, 'C');
    }

    public function body()
    {

        #TITULO TIPO DE SOLICITUD
        $this->SetY(40);
        $this->SetX(15);
        $this->SetFont('Arial', 'B', 8);
        $this->SetFillColor(193, 193, 193);
        $this->Cell(180, 5, utf8_encode('TIPO DE SOLICITUD'), 0, 0, 'C', 1);

        $this->SetX(15);

        #valido el tipo de formato a generar para marcar (3, solicitud de autorizacion de servicios, 9, referencia, 10 contrarreferencia, 5 Autorización de servicios y tecnologías en salud )
        switch (self::$tipo) {
            case 3:
                $this->SetFillColor(0, 0, 0);
                $this->RoundedRect(68.8, 50.8, 1.5, 1.5, 0.75, 'F');
                break;
            case 4: //medicamentos
                $this->SetFillColor(0, 0, 0);
                $this->RoundedRect(68.8, 50.8, 1.5, 1.5, 0.75, 'F');
                break;
            case 9:
                $this->SetFillColor(0, 0, 0);
                $this->RoundedRect(160.8, 50.8, 1.5, 1.5, 0.75, 'F');
                break;
            case 10:
                $this->SetFillColor(0, 0, 0);
                $this->RoundedRect(160.8, 60.8, 1.5, 1.5, 0.75, 'F');
                break;
             case 5:
                $this->SetFillColor(0, 0, 0);
                $this->RoundedRect(75.8, 60.8, 1.5, 1.5, 0.75, 'F');
                break;
        }

        #negrilla
        $this->SetFont('Arial', 'B', 8);

        #primer circulo usando funcion propia RoundedRect
        $this->RoundedRect(17, 50, 3, 3, 1.5);
        $this->Text(21, 52.5, utf8_decode("Actualización datos de contacto"));

        #segundo circulo usando la funcion propia
        $this->RoundedRect(68, 50, 3, 3, 1.5);
        $this->Text(71, 52.5, utf8_decode(" Solicitud de autorización de servicios y tecnologías en salud"));

        #tercer circulo usando funcion propia RoundedRect
        $this->RoundedRect(160, 50, 3, 3, 1.5);
        $this->Text(165, 52.5, utf8_decode("Referencia"));

        #cuarto circulo usando funcion propia RoundedRect
        $this->RoundedRect(17, 60, 3, 3, 1.5);
        $this->Text(21, 62.5, utf8_decode("Informe de la atención de urgencias"));

        #quinto circulo usando la funcion propia
        $this->RoundedRect(75, 60, 3, 3, 1.5);
        $this->Text(79, 62.5, utf8_decode("Autorización de servicios y tecnologías en salud"));

        #sexto circulo usando funcion propia RoundedRect
        $this->RoundedRect(160, 60, 3, 3, 1.5);
        $this->Text(165, 62.5, utf8_decode("Contrareferencia"));

        $this->Line(15, 67, 195, 67);

        #numero de consecutivo
        $idConsulta = self::$consulta->id;
        $fechaConsulta = date('Ymd', strtotime(self::$consulta->created_at));
        $consecutivo = $fechaConsulta . $idConsulta;
        $this->Text(17, 72, utf8_decode('N° Consecutivo: '));
        $this->SetFont('Arial', '', 8);
        $this->Text(40, 72, $consecutivo ?? '');

        #fecha y hora
        $fechaHoraOrden = self::$consulta->created_at;
        $fechaOrden = date('d/m/Y', strtotime($fechaHoraOrden));
        $horaOrden = date('H:i:s', strtotime($fechaHoraOrden));

        $this->SetFont('Arial', 'B', 8);
        $this->Text(65, 72, utf8_decode('Fecha/Hora: '));

        $this->SetFont('Arial', '', 8);
        $this->Text(82, 72, $fechaOrden ?? '');
        $this->Text(97, 72, $horaOrden ?? '');


        #Numero de solicitud de autorización/referencia
        $this->SetFont('Arial', 'B', 8);
        $this->Text(115, 72, utf8_decode('N° solicitud de autorización/referencia: '));
        $this->SetFont('Arial', '', 8);
        $this->Text(168, 72, $idConsulta ?? '');


        #NIT
        $this->SetFont('Arial', 'B', 8);
        $this->Text(17, 78, utf8_decode('Nit: '));
        $this->SetFont('Arial', '', 8);
        $this->Text(23, 78, '900033371');

        #Codigo prestador
        $this->SetFont('Arial', 'B', 8);
        $this->Text(65, 78, utf8_decode('Código: '));
        $this->SetFont('Arial', '', 8);
        $this->Text(77, 78, utf8_decode('0500109022'));

        #Codigo ERP
        $this->SetFont('Arial', 'B', 8);
        $this->Text(115, 78, utf8_decode('Código ERP: '));
        $this->SetFont('Arial', '', 8);
        if (self::$afiliado->entidad_id === 1) {
            $this->Text(134, 78, utf8_decode('RES004'));
        } else if (self::$afiliado->entidad_id === 3) {
            $this->Text(134, 78, utf8_decode('EAS027'));
        }


        #DATOS DEL PACIENTE

        #titulos negrilla
        $this->SetFillColor(193, 193, 193);
        $this->SetY(82);
        $this->SetX(15);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(180, 5, utf8_decode('DATOS DEL PACIENTE'), 0, 0, 'C', 1);
        $this->Text(15, 92, utf8_decode('1er Apellido:'));
        $this->Text(56, 92, utf8_decode('2do Apellido:'));
        $this->Text(105, 92, utf8_decode('1er Nombre:'));
        $this->Text(147, 92, utf8_decode('2do Nombre:'));

        $this->Text(15, 99, utf8_decode('N° Documento:'));
        $this->Text(56, 99, utf8_decode('Tipo Documento:'));
        $this->Text(105, 99, utf8_decode('Nacimiento:'));
        $this->Text(147, 99, utf8_decode('Teléfono:'));

        $this->Text(15, 106, utf8_decode('Dirección:'));
        $this->Text(97, 106, utf8_decode('Municipio:'));
        $this->Text(147, 106, utf8_decode('Email:'));




        #texto sin negrilla
        $this->SetFont('Arial', '', 8);
        $this->Text(33, 92, utf8_decode(self::$afiliado->primer_apellido ?? ''));
        $this->Text(75, 92, utf8_decode(self::$afiliado->segundo_apellido ?? ''));
        $this->Text(123, 92, utf8_decode(self::$afiliado->primer_nombre ?? ''));
        $this->Text(167, 92, utf8_decode(self::$afiliado->segundo_nombre ?? ''));

        $this->Text(37, 99, utf8_decode(self::$afiliado->numero_documento ?? ''));

        #valido el tipo de documento para mostrar el texto
        $tipo_documento = match (self::$afiliado->tipo_documento) {
            1 => $this->Text(80, 99, utf8_decode('CC')),
            2 => $this->Text(80, 99, utf8_decode('TI')),
            3 => $this->Text(80, 99, utf8_decode('RC')),
            4 => $this->Text(80, 99, utf8_decode('TE')),
            5 => $this->Text(80, 99, utf8_decode('CE')),
            7 => $this->Text(80, 99, utf8_decode('PA')),
            13 => $this->Text(80, 99, utf8_decode('AS')),
            14 => $this->Text(80, 99, utf8_decode('MS')),
        };
        $tipo_documento;

        $fechaNacimiento = date('d/m/Y', strtotime(self::$afiliado->fecha_nacimiento));
        $this->Text(122, 99, $fechaNacimiento);
        $this->Text(161, 99, utf8_decode(self::$afiliado->telefono ?? ''));

        $this->SetXY(30, 103.5);
        #municipio residencia
        $codigoMunicipio = self::$afiliado->municipio_residencia->codigo_dane ?? '';
        $codigoDepartamento = self::$afiliado->departamento_residencia->codigo_dane ?? '';
        $municipioResidencia = $codigoDepartamento . $codigoMunicipio;
        $this->MultiCell(65, 3.5, utf8_decode(self::$afiliado->direccion_residencia_cargue ?? ''), 0, 'J');

        $this->Text(112, 106, $municipioResidencia);
        $this->SetXY(155, 103);
        $this->MultiCell(43, 3.5, utf8_decode(self::$afiliado->correo1 ?? ''), 0, 'J');


        #DATOS ALTERNATIVOS DEL PACIENTE

        $this->SetFillColor(193, 193, 193);
        $this->SetY(115);
        $this->SetX(15);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(180, 5, utf8_decode('DATOS ALTERNATIVOS DEL PACIENTE'), 0, 1, 'C', 1);

        $this->Text(15, 128, utf8_decode('Contacto de emergencia: '));
        $this->Text(95, 128, utf8_decode('Telefono: '));
        $this->Text(140, 128, utf8_decode('Celular: '));


        $this->SetFont('Arial', '', 8);
        $this->Text(50, 128, utf8_decode(self::$afiliado->nombre_responsable ?? ''));
        $this->Text(110, 128, utf8_decode(self::$afiliado->celular1 ?? ''));
        $this->Text(155, 128, utf8_decode(self::$afiliado->celular2 ?? ''));




        #INFORMACION DE LA ATENCIÓN Y SERVICIOS
        $this->SetY(135);
        $this->SetX(15);

        #negrilla
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(180, 5, utf8_decode('INFORMACIÓN DE LA ATENCIÓN Y SERVICIOS'), 0, 1, 'C', 1);
        $this->Text(15, 145, utf8_decode('Fecha/Hora ingreso: '));
        $this->Text(72, 145, utf8_decode('Clasificación triage:'));
        $this->Text(120, 145, utf8_decode('Via de ingreso:'));


        $this->Text(15, 150, utf8_decode('Causa que motiva la atención:'));

        #texto sin negrilla
        #fecha y hora
        $fechaHoraConsulta = self::$consulta->hora_inicio_atendio_consulta;
        $fechaConsulta = date('d/m/Y', strtotime($fechaHoraConsulta));
        $horaConsulta = date('H:i:s', strtotime($fechaHoraConsulta));
        $this->SetFont('Arial', '', 8);
        $this->Text(43, 145, utf8_decode('No aplica'));

        $this->Text(100, 145, utf8_decode('No aplica'));
        $this->Text(142, 145, utf8_decode('No aplica'));

        $motivo = self::$historiaClinica?->causaConsulta?->nombre;
        $motivo = str_replace('?', '-', mb_convert_encoding($motivo, 'ISO-8859-1', 'UTF-8'));

        $this->SetXY(57, 148);

        #causa que motiva la atencion
        $this->MultiCell(138, 3, $motivo, 0, 'J');
        // $this->Text(58,150,utf8_decode($motivo.' '.$manejo));

        $y = $this->GetY();
        $salto = false;

        #se calcula el espacio necesario
        $espacioRequerido = 95; // espacio aproximado del contenido siguiente
        $alturaDisponible = $this->h - 20 - $y;

        if ($alturaDisponible < $espacioRequerido) {
            $this->AddPage();
            $y = 47; // posición inicial para nuevo contenido
            $salto = true;
        }
        #separador
        $this->Line(15, $y + 2, 195, $y + 2);


        #DIAGNOSTICOS

        #negrilla
        $y += 7;
        $this->SetFont('Arial', 'B', 8);
        $this->Text(15, $y, utf8_decode('Diagnóstico principal código:'));
        $this->Text(15, $y + 7, utf8_decode('Diagnóstico relacionado 1 código:'));
        $this->Text(15, $y + 14, utf8_decode('Diagnóstico relacionado 2 código:'));
        $this->Text(15, $y + 21, utf8_decode('Diagnóstico relacionado 3 código:'));
        $this->Text(15, $y + 30, utf8_decode('Prioridad de atención:'));
        $this->Text(15, $y + 45, utf8_decode('Tipo de atención:'));
        $this->Text(15, $y + 70, utf8_decode('Modalidad de atención:'));


        #texto sin negrilla
        $this->SetFont('Arial', '', 8);
        $this->Text(56, $y, utf8_decode(self::$cie10->codigo_cie10 ?? ''));

        $cie10Relacionado = self::$cie10Relacionado ?? null;


        if (count($cie10Relacionado) > 0) {
            if (!empty($cie10Relacionado[0])) {
                $this->Text(62, $y + 7, utf8_decode($cie10Relacionado[0]->codigo_cie10 ?? ''));
            }
            if (!empty($cie10Relacionado[1])) {
                $this->Text(62, $y + 14, utf8_decode($cie10Relacionado[1]->codigo_cie10 ?? ''));
            }
            if (!empty($cie10Relacionado[2])) {
                $this->Text(62, $y + 21, utf8_decode($cie10Relacionado[2]->codigo_cie10 ?? ''));
            }
        }

        $discapacidad = self::$afiliado->discapacidad;
        $adultoMayor = self::$afiliado->ciclo_vida_atencion;
        $gestante = self::$afiliado->clasificacion ?: '';
        if ($gestante) {
            $gestante = true;
        }

        #es prioritario si es adulto mayor, discapacitado o gestante
        if ($discapacidad !== 'Sin discapacidad' || $discapacidad !== null || $adultoMayor === 'Vejez' || $adultoMayor === 'Vejez (Mayor a 60 Años)' || $gestante !== null) {
            $this->SetFillColor(0, 0, 0);
            #prioridad de atencion
            $this->RoundedRect(78.8, $y + 28.8, 1.5, 1.5, 0.75, 'F');
            #tipo de atencion
            $this->RoundedRect(78.8, $y + 42.8, 1.5, 1.5, 0.75, 'F');
        } else {
            $this->SetFillColor(0, 0, 0);
            #prioridad de atencion
            $this->RoundedRect(112.8, $y + 28.8, 1.5, 1.5, 0.75, 'F');
            #tipo de atencion
            $this->RoundedRect(78.8, $y + 49.8, 1.5, 1.5, 0.75, 'F');
        }

        #prioritaria
        $this->RoundedRect(78, $y + 28, 3, 3, 1.5);
        $this->Text(82, $y + 30, utf8_decode('Prioritaria'));

        #no prioritaria
        $this->RoundedRect(112, $y + 28, 3, 3, 1.5);

        $this->Text(116, $y + 30, utf8_decode('No prioritaria'));

        #tipo atencion
        $this->RoundedRect(78, $y + 35, 3, 3, 1.5);
        $this->Text(82, $y + 37.8, utf8_decode('Servicios y tecnologías en casos posteriores a urgencia'));


        $this->RoundedRect(78, $y + 42, 3, 3, 1.5);
        $this->Text(82, $y + 44.8, utf8_decode('Servicios y tecnologías en atención prioritaria'));


        $this->RoundedRect(78, $y + 49, 3, 3, 1.5);
        $this->SetFillColor(0, 0, 0);
        $this->Text(82, $y + 51.8, utf8_decode('Servicios y tecnologías en atención no prioritaria'));



        #modalidad de atencion

        #primera fila
        if (self::$consulta->tipo_consulta_id === 84) {
            $this->SetFillColor(0, 0, 0);
            $this->RoundedRect(120.8, $y + 68.8, 1.5, 1.5, 0.75, 'F');
        } else {
            $this->SetFillColor(0, 0, 0);
            $this->RoundedRect(78.8, $y + 61.8, 1.5, 1.5, 0.75, 'F');
        }
        $this->RoundedRect(78, $y + 61, 3, 3, 1.5);
        $this->Text(82, $y + 63.8, utf8_decode('Intramural'));

        $this->RoundedRect(100, $y + 61, 3, 3, 1.5);
        $this->Text(104, $y + 63.8, utf8_decode('Extramural unidad móvil'));

        $this->RoundedRect(140, $y + 61, 3, 3, 1.5);
        $this->Text(144, $y + 63.8, utf8_decode('Extramural domiciliaria'));

        #segunda fila
        $this->RoundedRect(78, $y + 68, 3, 3, 1.5);
        $this->Text(82, $y + 70.8, utf8_decode('Extramural jornada de salud'));

        $this->RoundedRect(120, $y + 68, 3, 3, 1.5);
        $this->Text(124, $y + 70.8, utf8_decode('Telemedicina interactiva'));

        $this->RoundedRect(157, $y + 68, 3, 3, 1.5);
        $this->SetXY(160, $y + 68);
        $this->MultiCell(27, 3.5, utf8_decode('Telemedicina no interactiva'), 0, 'J');


        #tercera fila
        $this->RoundedRect(78, $y + 75, 3, 3, 1.5);
        $this->Text(82, $y + 77.8, utf8_decode('Telemedicina telemonitoreo'));

        $this->RoundedRect(120, $y + 75, 3, 3, 1.5);
        $this->Text(124, $y + 77.8, utf8_decode('Telemedicina telexperticia'));


        #codigo cups

        if (self::$tipo === 3) {

            $this->Rect(15, $y + 83, 140, 5);
            $this->Rect(157, $y + 83, 35, 5);
            $this->SetFont('Arial', 'B', 8);
            $this->Text(60, $y + 86, utf8_decode('Código CUPS del procedimiento requerido'));
            $this->Text(167, $y + 86, utf8_decode('Cantidad'));
            $this->SetFont('Arial', '', 8);
            $this->SetXY(32, $y + 90);
            if (isset(self::$ordenProcedimiento?->cup->codigo)) {
                $cupCodigo = self::$ordenProcedimiento?->cup->codigo ?? '';
                $cupNombre = self::$ordenProcedimiento?->cup->nombre ?? '';
                $cupCantidad = self::$ordenProcedimiento?->cantidad ?? '';
            } else {
                $cupCodigo = self::$ordenProcedimiento?->codigoPropio->cup->codigo ?? '';
                $cupNombre = self::$ordenProcedimiento?->codigoPropio->cup->nombre ?? '';
                $cupCantidad = self::$ordenProcedimiento?->cantidad ?? '';
            }

            $this->Text(18, $y + 92.5, utf8_decode($cupCodigo ?? '' . ' - '));
            $this->MultiCell(120, 3, utf8_decode($cupNombre ?? ''), 0, 'J');
        }

        if (self::$tipo === 4) {

            $this->Rect(15, $y + 83, 140, 5);
            $this->Rect(157, $y + 83, 35, 5);
            $this->SetFont('Arial', 'B', 8);
            $this->Text(60, $y + 86, utf8_decode('Código CODESUMI del procedimiento requerido'));
            $this->Text(167, $y + 86, utf8_decode('Cantidad'));
            $this->SetFont('Arial', '', 8);
            $this->SetXY(32, $y + 90);
            $cupCodigo = self::$ordenProcedimiento?->codesumi->codigo ?? '';
            $cupNombre = self::$ordenProcedimiento?->codesumi->nombre ?? '';
            $cupCantidad = self::$ordenProcedimiento?->cantidad_medico ?? '';


            $this->Text(18, $y + 92.5, utf8_decode($cupCodigo ?? '' . ' - '));
            $this->MultiCell(120, 3, utf8_decode($cupNombre ?? ''), 0, 'J');
        }



        if (self::$tipo === 9) {
            $cupNombre = self::$historiaClinica?->cup_referencia_hospitalizacion ?? '';
            $cupCantidad = 1;
            $this->SetX(15);
            $this->MultiCell(120, 3, utf8_decode($cupNombre ?? ''), 0, 'J');
        }

        $yNuevo = $this->GetY();
        $this->Text(170, $y + 92.5, utf8_decode($cupCantidad ?? ''));

        #pinto los cuadros de nombre y cantidad
        $this->Rect(15, $y + 89, 140, $yNuevo - ($y + 88));
        #cantidad
        $this->Rect(157, $y + 89, 35, $yNuevo - ($y + 88));

        #Condicion y destino
        $this->SetFont('Arial', 'B', 8);
        $this->Text(15, $y + 107, utf8_decode('Condición y destino:'));
        $this->SetFont('Arial', '', 8);

        #aplica para referencia y contrarreferencia solo cuando hay egreso de urgencias.
        $destino = self::$historiaClinica?->destino_paciente ?? '';
        $this->Text(45, $y + 107, utf8_decode('No aplica'));

        $this->SetFont('Arial', 'B', 8);
        $this->Text(15, $y + 113, utf8_decode('Finalidad del servicio o tecnología de salud:'));
        $this->SetFont('Arial', '', 8);

        #aplica para autorizacion y solicitud de servicios
        if (self::$tipo === 3) {
            $finalidad = self::$historiaClinica?->finalidadConsulta->nombre ?? '';
        } else {
            $finalidad = 'No aplica';
        }
        $this->SetXY(75, $y + 110.5);
        $this->MultiCell(118, 3.5, utf8_decode($finalidad));


        #si es necesario se agrega nueva pagina
        if (!$salto) {
            $this->AddPage();
            $this->SetY(42);
        } else {
            $yActual = $this->GetY();
            $this->SetY($yActual + 40);
        }

        #DATOS DE REFERENCIA
        $this->SetFillColor(193, 193, 193);
        $this->SetX(15);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(180, 5, utf8_decode('DATOS DE REFERENCIA'), 0, 1, 'C', 1);
        $y = $this->GetY() + 8;
        $this->Text(15, $y, utf8_decode('Código del prestador que remite:'));
        $this->Text(15, $y + 8, utf8_decode('Código del servicio por el cual se solicita la referencia:'));

        $this->SetFont('Arial', '', 8);

        $especialidad = self::$historiaClinica?->especialidad ?? '';
        if (self::$tipo === 9) {
            $this->Text(60, $y, utf8_decode('0500109022'));
            $this->Text(90, $y + 8, utf8_decode($especialidad));
        } else {
            #codigo prestador
            $this->Text(60, $y, utf8_decode(' No aplica '));

            #codigo servicio referido
            $this->Text(90, $y + 8, utf8_decode('No aplica'));
        }


        #INFORMACION DE LA PERSONA QUE SOLICITA
        $this->SetFillColor(193, 193, 193);
        $this->SetY($y + 15);
        $this->SetX(15);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(180, 5, utf8_decode('INFORMACIÓN DE LA PERSONA QUE SOLICITA'), 0, 1, 'C', 1);

        $yInfo = $this->GetY() + 5;
        $this->Text(30, $yInfo, utf8_decode('Nombre'));
        $this->Text(100, $yInfo, utf8_decode('Cargo'));
        $this->Text(150, $yInfo, utf8_decode('Contacto'));

        $this->SetFont('Arial', '', 8);
        $medicoOrdena = self::$consulta?->medicoOrdena;
        $primeraEspecialidad = $medicoOrdena?->especialidades()?->first();
        $nombreEspecialidad = $primeraEspecialidad ? $primeraEspecialidad->nombre : '';
        $nombre = self::$consulta?->medicoOrdena?->operador?->nombre_completo ?? '';
        $email = $medicoOrdena?->email;

        $this->Text(15, $yInfo + 5, utf8_decode($nombre));
        $this->Text(95, $yInfo + 5, utf8_decode($nombreEspecialidad));
        $this->Text(145, $yInfo + 5, utf8_decode($email));
    }



    public function footer() {}



    private function RoundedRect($x, $y, $w, $h, $r, $style = '')
    {
        $k = $this->k;
        $hp = $this->h;
        if ($style == 'F')
            $op = 'f';
        elseif ($style == 'FD' || $style == 'DF')
            $op = 'B';
        else
            $op = 'S';
        $MyArc = 4 / 3 * (sqrt(2) - 1);
        $this->_out(sprintf('%.2F %.2F m', ($x + $r) * $k, ($hp - $y) * $k));
        $xc = $x + $w - $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - $y) * $k));
        $this->_Arc($xc + $r * $MyArc, $yc - $r, $xc + $r, $yc - $r * $MyArc, $xc + $r, $yc);
        $xc = $x + $w - $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', ($x + $w) * $k, ($hp - $yc) * $k));
        $this->_Arc($xc + $r, $yc + $r * $MyArc, $xc + $r * $MyArc, $yc + $r, $xc, $yc + $r);
        $xc = $x + $r;
        $yc = $y + $h - $r;
        $this->_out(sprintf('%.2F %.2F l', $xc * $k, ($hp - ($y + $h)) * $k));
        $this->_Arc($xc - $r * $MyArc, $yc + $r, $xc - $r, $yc + $r * $MyArc, $xc - $r, $yc);
        $xc = $x + $r;
        $yc = $y + $r;
        $this->_out(sprintf('%.2F %.2F l', $x * $k, ($hp - $yc) * $k));
        $this->_Arc($xc - $r, $yc - $r * $MyArc, $xc - $r * $MyArc, $yc - $r, $xc, $yc - $r);
        $this->_out($op);
    }

    private function _Arc($x1, $y1, $x2, $y2, $x3, $y3)
    {
        $h = $this->h;
        $k = $this->k;
        $this->_out(sprintf(
            '%.2F %.2F %.2F %.2F %.2F %.2F c',
            $x1 * $k,
            ($h - $y1) * $k,
            $x2 * $k,
            ($h - $y2) * $k,
            $x3 * $k,
            ($h - $y3) * $k
        ));
    }
}
