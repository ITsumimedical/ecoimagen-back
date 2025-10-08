<?php
namespace App\Formats;

use App\User;
use App\Modelos\Paise;
use App\Modelos\Paciente;
use App\Modelos\Municipio;
use App\Modelos\Ocupacione;
use App\Modelos\citapaciente;
use App\Modelos\Departamento;
use App\Modelos\Registrocovi;
use App\Modelos\Seguimientocovid;
use Illuminate\Support\Carbon;
use App\Modelos\Sedeproveedore;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Codedge\Fpdf\Fpdf\Fpdf;


class FichaCovid extends Fpdf
{
    public static $paciente;
    public static $citaPaciente;
    public static $registroCovid;
    public static $data;
    public static $municipio;
    public static $departamento;
    public static $sedeproveedores;
    public static $pais;
    public static $municipioprocedencia;
    public static $deparprocedencia;
    public static $ocupacionpaciente;
    public static $medicoatiende;
    public static $territorionacional;
    //public static $departamentonacionalterritorio;
    public static $viajeinternacional;
    public static $anteAlergicos;
    public static $antFamiliares;
    public static $estilosVida;
    public static $ordenamientoMedica;
    public static $ordenamientoServ;
    public static $seguimientoCovid;
    public static $medicoatiendeSeguimiento;

    public function generar()
    {
        // if(''/*$data["tipo"]!='seguimiento'*/)
        // {
        //     self::$data = $data;
        //     self::$registroCovid = Registrocovi::find(self::$data["id"]);
        //     self::$citaPaciente = citapaciente::find(self::$registroCovid->cita_paciente_id);
        //     self::$medicoatiende = User::find(self::$citaPaciente->Usuario_id);
        //     self::$paciente = Paciente::find(self::$citaPaciente->Paciente_id);
        //     self::$municipio = Municipio::find(self::$paciente->Mpio_Atencion);
        //     self::$departamento = Departamento::find(self::$municipio->Departamento_id);
        //     self::$sedeproveedores = Sedeproveedore::find(self::$municipio->id);
        //     self::$pais = Paise::find(self::$registroCovid->pais_ocurrencia_id);
        //     self::$municipioprocedencia = Municipio::find(self::$registroCovid->municipio_procedencia_id);
        //     self::$deparprocedencia = Departamento::find(self::$municipioprocedencia->Departamento_id);
        //     self::$ocupacionpaciente = Ocupacione::find(self::$registroCovid->ocupacion_id);
        //     self::$territorionacional = Municipio::find(self::$registroCovid->municipio_viajo_id);
        //     //self::$departamentonacionalterritorio = Departamento::find(self::$territorionacional->Departamento_id);
        //     self::$viajeinternacional = Paise::find(self::$registroCovid->pais_viajo_id);
        //     self::$anteAlergicos = Paciente::select('pacienteantecedentes.Descripcion', 'pacienteantecedentes.created_at')
        //         ->join('cita_paciente', 'cita_paciente.Paciente_id', 'pacientes.id')
        //         ->join('pacienteantecedentes', 'pacienteantecedentes.citapaciente_id', 'cita_paciente.id')
        //         ->where('pacienteantecedentes.Antecedente_id', 37)
        //         ->where('pacientes.id', self::$citaPaciente->Paciente_id)->get();
        //     self::$antFamiliares = Paciente::select('parentescoantecedentes.Descripcion', 'parentescoantecedentes.created_at as fechaRegistro', 'antecedentes.Nombre', 'parentescos.Nombre as parentesco')
        //         ->join('cita_paciente', 'cita_paciente.Paciente_id', 'pacientes.id')
        //         ->join('parentescoantecedentes', 'parentescoantecedentes.Citapaciente_id', 'cita_paciente.id')
        //         ->join('antecedentes', 'antecedentes.id', 'parentescoantecedentes.Antecedente_id')
        //         ->join('parentescos', 'parentescos.id', 'parentescoantecedentes.parentesco_id')
        //         ->where('pacientes.id', self::$citaPaciente->Paciente_id)->get();
        //     self::$estilosVida = Paciente::select('estilovidas.*', 'examenfisicos.*')
        //         ->join('cita_paciente', 'cita_paciente.Paciente_id', 'pacientes.id')
        //         ->leftjoin('examenfisicos', 'examenfisicos.Citapaciente_id', 'cita_paciente.id')
        //         ->join('estilovidas', 'estilovidas.Citapaciente_id', 'cita_paciente.id')
        //         ->wherein('cita_paciente.Tipocita_id',[8,2])
        //         ->where('pacientes.id', self::$citaPaciente->Paciente_id)
        //         ->orderBy('estilovidas.id', 'DESC')->first();
        //     self::$ordenamientoMedica = citapaciente::Select('detaarticulordens.Cantidadpormedico', 'detaarticulordens.Observacion', 'estadoMedicamento.Nombre as EstadoMedi', 'codesumis.Nombre as Medicamento')
        //         ->join('ordens', 'ordens.Cita_id', 'cita_paciente.id')
        //         ->leftjoin('detaarticulordens', 'detaarticulordens.Orden_id', 'ordens.id')
        //         ->leftjoin('codesumis', 'codesumis.id', 'detaarticulordens.codesumi_id')
        //         ->leftjoin('estados as estadoMedicamento', 'estadoMedicamento.id', 'detaarticulordens.Estado_id')
        //         ->where('ordens.Tiporden_id', 3)
        //         ->where('cita_paciente.id', self::$registroCovid->cita_paciente_id)->get();
        //     self::$ordenamientoServ = citapaciente::Select('cups.Nombre as Servicio', 'estadoCups.Nombre as EstadoServi', 'cupordens.Cantidad as CantidadServi')
        //         ->join('ordens', 'ordens.Cita_id', 'cita_paciente.id')
        //         ->leftjoin('cupordens', 'cupordens.Orden_id', 'ordens.id')
        //         ->leftjoin('cups', 'cups.id', 'cupordens.Cup_id')
        //         ->leftjoin('estados as estadoCups', 'estadoCups.id', 'cupordens.Estado_id')
        //         ->whereIn('ordens.Tiporden_id', [2, 4])
        //         ->where('cita_paciente.id', self::$registroCovid->cita_paciente_id)->get();
        // }
        // if($data["tipo"] == 'seguimiento')
        // {
        //     //seguimiento
        //     self::$data = $data;
        //     self::$seguimientoCovid = Seguimientocovid::find(self::$data["id"]);
        //     self::$registroCovid = Registrocovi::find(self::$seguimientoCovid->registrocovi_id);
        //     self::$citaPaciente = citapaciente::find(self::$registroCovid->cita_paciente_id);
        //     self::$medicoatiende = User::find(self::$citaPaciente->Usuario_id);
        //     self::$medicoatiendeSeguimiento = User::find(self::$seguimientoCovid->realizado_por);
        //     self::$paciente = Paciente::find(self::$citaPaciente->Paciente_id);
        //     self::$ocupacionpaciente = Ocupacione::find(self::$registroCovid->ocupacion_id);
        //     self::$municipio = Municipio::find(self::$paciente->Mpio_Atencion);
        //     self::$departamento = Departamento::find(self::$municipio->Departamento_id);
        //     self::$sedeproveedores = Sedeproveedore::find(self::$municipio->id);
        //     self::$anteAlergicos = Paciente::select('pacienteantecedentes.Descripcion', 'pacienteantecedentes.created_at')
        //         ->join('cita_paciente', 'cita_paciente.Paciente_id', 'pacientes.id')
        //         ->join('pacienteantecedentes', 'pacienteantecedentes.citapaciente_id', 'cita_paciente.id')
        //         ->where('pacienteantecedentes.Antecedente_id', 37)
        //         ->where('pacientes.id', self::$citaPaciente->Paciente_id)->get();
        //     self::$antFamiliares = Paciente::select('parentescoantecedentes.Descripcion', 'parentescoantecedentes.created_at as fechaRegistro', 'antecedentes.Nombre', 'parentescos.Nombre as parentesco')
        //         ->join('cita_paciente', 'cita_paciente.Paciente_id', 'pacientes.id')
        //         ->join('parentescoantecedentes', 'parentescoantecedentes.Citapaciente_id', 'cita_paciente.id')
        //         ->join('antecedentes', 'antecedentes.id', 'parentescoantecedentes.Antecedente_id')
        //         ->join('parentescos', 'parentescos.id', 'parentescoantecedentes.parentesco_id')
        //         ->where('pacientes.id', self::$citaPaciente->Paciente_id)->get();
        //     self::$estilosVida = Paciente::select('estilovidas.*', 'examenfisicos.*')
        //         ->join('cita_paciente', 'cita_paciente.Paciente_id', 'pacientes.id')
        //         ->leftjoin('examenfisicos', 'examenfisicos.Citapaciente_id', 'cita_paciente.id')
        //         ->join('estilovidas', 'estilovidas.Citapaciente_id', 'cita_paciente.id')
        //         ->wherein('cita_paciente.Tipocita_id',[8,2])
        //         ->where('pacientes.id', self::$citaPaciente->Paciente_id)
        //         ->orderBy('estilovidas.id', 'DESC')->first();
        //     self::$ordenamientoMedica = citapaciente::Select('detaarticulordens.Cantidadpormedico', 'detaarticulordens.Observacion', 'estadoMedicamento.Nombre as EstadoMedi', 'codesumis.Nombre as Medicamento')
        //         ->join('ordens', 'ordens.Cita_id', 'cita_paciente.id')
        //         ->leftjoin('detaarticulordens', 'detaarticulordens.Orden_id', 'ordens.id')
        //         ->leftjoin('codesumis', 'codesumis.id', 'detaarticulordens.codesumi_id')
        //         ->leftjoin('estados as estadoMedicamento', 'estadoMedicamento.id', 'detaarticulordens.Estado_id')
        //         ->where('ordens.Tiporden_id', 3)
        //         ->where('cita_paciente.id', self::$registroCovid->cita_paciente_id)->get();
        //     self::$ordenamientoServ = citapaciente::Select('cups.Nombre as Servicio', 'estadoCups.Nombre as EstadoServi', 'cupordens.Cantidad as CantidadServi')
        //         ->join('ordens', 'ordens.Cita_id', 'cita_paciente.id')
        //         ->leftjoin('cupordens', 'cupordens.Orden_id', 'ordens.id')
        //         ->leftjoin('cups', 'cups.id', 'cupordens.Cup_id')
        //         ->leftjoin('estados as estadoCups', 'estadoCups.id', 'cupordens.Estado_id')
        //         ->whereIn('ordens.Tiporden_id', [2, 4])
        //         ->where('cita_paciente.id', self::$registroCovid->cita_paciente_id)->get();
        // }

        $pdf = new FichaCovid('P','mm','A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',16);
        $this->body($pdf);
        $pdf->Output();
    }

    public function header()
    {
        //this
        //image
    }

    public function footer()
    {
        $this->SetXY(190, 287);
        $this->Cell(10, 4, utf8_decode('Página ').$this->PageNo().' de {nb}', 0, 0, 'C');
    }

    public function body($pdf)
    {
        $pdf->SetFont('Arial', 'B', 9);
        $logo ="/images/logo_instituto_salud.png";
        $pdf->Image($logo, 10, 12, -99);

        $pdf->SetFont('Arial', 'B', 9);
        $logo ="/images/logo_republica_colombia.png";
        $pdf->Image($logo, 185, 9, -190);

        $pdf->SetXY(10, 13);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(192, 4, utf8_decode('SISTEMA NACIONAL DE VIGILANCIA EN SALUD PÚBLICA'), 0, 0, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(10, 18);
        $pdf->Cell(192, 4, utf8_decode('Subsistema de información SIVIGILA'), 0, 0, 'C');
        $pdf->SetXY(10, 23);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(192, 4, utf8_decode('Ficha de notificación individual'), 0, 0, 'C');


        $pdf->SetXY(10, 31);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(192, 4, utf8_decode('Datos básicos'), 0, 0, 'C');

        $pdf->SetXY(5, 37);
        $pdf->SetFont('Arial', '', 6.5);
        $pdf->Cell(192, 4, utf8_decode('La ficha de notificación es para fines de vigilancia en salud pública y todas las entidades que participen en el proceso deben garantizar la confidencialidad de la información LEY 1273/09 y 1266/09'), 0, 0, 'l');

        $pdf->SetXY(5,41);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(200, 4, utf8_decode('1. INFORMACIÓN GENERAL'), 1, 0, 'C',1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetXY(5, 46);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(40, 4, utf8_decode('1.1 Código de la UPGD'), 0, 0, 'l');

        $pdf->SetXY(14,50);
        $pdf->SetFont('Arial', '', 7);
        //despues del 4,:substr(substr(self::$departamento->codigo_Dane?self::$departamento->codigo_Dane:'',0,2),0,1),
        $pdf->MultiCell(5, 4, 1, 'C');
        $pdf->SetXY(19,50);
        $pdf->SetFont('Arial', '', 7);
        //despues del 4,substr(substr(self::$departamento->codigo_Dane?self::$departamento->codigo_Dane:'',0,2),1,1),
        $pdf->MultiCell(5, 4, 1, 'C');
        $pdf->SetXY(11, 54);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(40, 4, utf8_decode('Departamento'), 0, 0, 'l');

        $pdf->SetXY(30,50);
        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell(5, 4, 1, 'C');
        //despues del 4,:substr(substr(self::$municipio->codigo_Dane?self::$municipio->codigo_Dane:'',0,2),0,1),
        $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
        $pdf->SetXY(35,50);
        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell(5, 4, 1, 'C');
        //despues del 4,:substr(substr(self::$municipio->codigo_Dane?self::$municipio->codigo_Dane:'',0,2),1,1),
        $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
        $pdf->SetXY(40,50);
        $pdf->SetFont('Arial', '', 7);
        //despues del 4,:substr(substr(self::$municipio->codigo_Dane?self::$municipio->codigo_Dane:'',0,3),2,1),
        $pdf->MultiCell(5, 4, 1, 'C');
        $pdf->SetXY(31, 54);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(40, 4, utf8_decode('Municipio'), 0, 0, 'l');

        $pdf->SetXY(50,50);
        $pdf->SetFont('Arial', '', 7);
        //despues del 4,: substr(substr(self::$sedeproveedores->Codigo_habilitacion?self::$sedeproveedores->Codigo_habilitacion:'',0,14),0,1),
        $pdf->MultiCell(5, 4, 1, 'C');
        $pdf->SetXY(55,50);
        $pdf->SetFont('Arial', '', 7);
        //despues del 4,:substr(substr(self::$sedeproveedores->Codigo_habilitacion?self::$sedeproveedores->Codigo_habilitacion:'',0,14),1,1),
        $pdf->MultiCell(5, 4, 1, 'C');
        $pdf->SetXY(60,50);
        $pdf->SetFont('Arial', '', 7);
        //despues del 4,:substr(substr(self::$sedeproveedores->Codigo_habilitacion?self::$sedeproveedores->Codigo_habilitacion:'',0,14),2,1),
        $pdf->MultiCell(5, 4, 1, 'C');
        $pdf->SetXY(65,50);
        $pdf->SetFont('Arial', '', 7);
        //despues del 4,:substr(substr(self::$sedeproveedores->Codigo_habilitacion?self::$sedeproveedores->Codigo_habilitacion:'',0,14),3,1),
        $pdf->MultiCell(5, 4, 1, 'C');
        $pdf->SetXY(70,50);
        $pdf->SetFont('Arial', '', 4);
        //despues del 4,:substr(substr(self::$sedeproveedores->Codigo_habilitacion?self::$sedeproveedores->Codigo_habilitacion:'',0,14),4,1),
        $pdf->MultiCell(5, 4, 1, 'C');
        $pdf->SetXY(48, 54);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(30, 4, utf8_decode('Código'), 0, 0, 'C');

        $pdf->SetXY(80,50);
        $pdf->SetFont('Arial', '', 7);
        //despues del 4,:substr(substr(self::$sedeproveedores->Codigo_habilitacion?self::$sedeproveedores->Codigo_habilitacion:'',0,14),11,1),
        $pdf->MultiCell(5, 4, 1, 'C');
        $pdf->SetXY(85,50);
        $pdf->SetFont('Arial', '', 7);
        //despues del 4,:substr(substr(self::$sedeproveedores->Codigo_habilitacion?self::$sedeproveedores->Codigo_habilitacion:'',0,14),12,1),
        $pdf->MultiCell(5, 4, 1, 'C');
        $pdf->SetXY(78, 54);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(40, 4, utf8_decode('Sub-Índice'), 0, 0, 'l');

        $pdf->SetXY(115, 46);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Razón social de la unidad primaria generadora del dato'), 0, 0, 'C');
        $pdf->SetXY(97,50);
        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell(104, 4, utf8_decode('SUMIMEDICAL'), 0, 'l');


        $pdf->SetXY(4, 58);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('1.2 Nombre del evento'), 0, 0, 'C');
        $pdf->SetXY(6,62);
        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell(105, 4, utf8_decode('Caso sospechoso covid-19'), 0, 'l');
        $pdf->SetXY(124, 58);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(16, 4, utf8_decode('Código del evento'), 0, 0, 'C');
        $pdf->SetXY(125,62);
        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell(5, 4, utf8_decode('3'), 1, 'C');
        $pdf->SetXY(130,62);
        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell(5, 4, utf8_decode('4'), 1, 'C');
        $pdf->SetXY(135,62);
        $pdf->SetFont('Arial', '', 7);
        $pdf->MultiCell(5, 4, utf8_decode('6'), 1, 'C');


        $pdf->SetXY(160, 58);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('1.3 Fecha de la notificación (dd/mm/aaaa)'), 0, 0, 'C');
        $pdf->SetXY(153,62);
        $pdf->SetFont('Arial', '', 7);
        //despues del 4,:substr(substr(self::$registroCovid->created_at?self::$registroCovid->created_at:'',0,20),8,1),
        $pdf->MultiCell(5, 4, 1, 'C');
        $pdf->SetXY(158,62);
        $pdf->SetFont('Arial', '', 7);
        //despues del 4,:substr(substr(self::$registroCovid->created_at?self::$registroCovid->created_at:'',0,20),9,1),
        $pdf->MultiCell(5, 4, 1, 'C');
        $pdf->SetXY(162, 61);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(5, 6, utf8_decode('/'), 0, 0, 'C');
        $pdf->SetXY(166,62);
        $pdf->SetFont('Arial', '', 7);
        //despues del 4,:substr(substr(self::$registroCovid->created_at?self::$registroCovid->created_at:'',0,20),5,1),
        $pdf->MultiCell(5, 4, 1, 'C');
        $pdf->SetXY(171,62);
        $pdf->SetFont('Arial', '', 7);
        //despues del 4,:substr(substr(self::$registroCovid->created_at?self::$registroCovid->created_at:'',0,20),6,1),
        $pdf->MultiCell(5, 4, 1, 'C');
        $pdf->SetXY(175, 61);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(5, 6, utf8_decode('/'), 0, 0, 'C');
        $pdf->SetXY(179,62);
        $pdf->SetFont('Arial', '', 7);
        //despues del 4,:substr(substr(self::$registroCovid->created_at?self::$registroCovid->created_at:'',0,20),0,1),
        $pdf->MultiCell(5, 4, 1, 'C');
        $pdf->SetXY(184,62);
        $pdf->SetFont('Arial', '', 7);
        //despues del 4,:substr(substr(self::$registroCovid->created_at?self::$registroCovid->created_at:'',0,20),1,1),
        $pdf->MultiCell(5, 4, 1, 'C');
        $pdf->SetXY(189,62);
        $pdf->SetFont('Arial', '', 7);
        //despues del 4,:substr(substr(self::$registroCovid->created_at?self::$registroCovid->created_at:'',0,20),2,1),
        $pdf->MultiCell(5, 4, 1, 'C');
        $pdf->SetXY(194,62);
        $pdf->SetFont('Arial', '', 7);
        //despues del 4,:substr(substr(self::$registroCovid->created_at?self::$registroCovid->created_at:'',0,20),3,1),
        $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->Line(5, 46, 5, 67); #LINEA VERTICAL IZQUIERDA
            $pdf->Line(205, 46, 205, 67); #LINEA VERTICAL DERECHA
            $pdf->Line(5, 67, 205, 67); #LIENA HORIZONTAL ABAJO
            $pdf->Line(5, 46, 205, 46); #lINEA HORIZONTAL ARRIBA
            $pdf->Line(5, 58, 205, 58); #LINEA HORIZONTAL MEDIA
            $pdf->Line(95, 46, 95, 58); #LINEA VERTICAL DENTRO 1
            $pdf->Line(149, 58, 149, 67);#LINEA VERTICAL DENTRO 2

            #MARGENES HOJA 2
            $pdf->SetXY(5,68);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(200, 4, utf8_decode('2. IDENTIFICACIÓN DEL PACIENTE'), 1, 0, 'C',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);

            $pdf->SetXY(5, 73);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.1 Tipo de documento'), 0, 0, 'C');

            $pdf->SetXY(7,77);
            $pdf->SetFont('Arial', '', 6);
            //despues del 3,:(self::$paciente->Tipo_Doc === 'RC'?'X':''),
            $pdf->MultiCell(4, 3, 1, 'C');
            $pdf->SetXY(12, 77);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(4, 3, utf8_decode('RC'), 0, 0, 'C');
            $pdf->SetXY(17,77);
            $pdf->SetFont('Arial', '', 7);
            //despues del 3, (self::$paciente->Tipo_Doc === 'TI'?'X':''),
            $pdf->MultiCell(4, 3, 1, 'C');
            $pdf->SetXY(21, 77);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(4, 3, utf8_decode('TI'), 0, 0, 'C');
            $pdf->SetXY(25,77);
            $pdf->SetFont('Arial', '', 7);
            //despues del 3,: (self::$paciente->Tipo_Doc === 'CC'?'X':''),
            $pdf->MultiCell(4, 3, 1, 'C');
            $pdf->SetXY(30, 77);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(4, 3, utf8_decode('CC'), 0, 0, 'C');
            $pdf->SetXY(35,77);
            $pdf->SetFont('Arial', '', 7);
            //despues del 3,: (self::$paciente->Tipo_Doc === 'CE'?'X':''),
            $pdf->MultiCell(4, 3, 1, 'C');
            $pdf->SetXY(40, 77);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(4, 3, utf8_decode('CE'), 0, 0, 'C');
            $pdf->SetXY(45,77);
            $pdf->SetFont('Arial', '', 7);
            //despues del 3,: (self::$paciente->Tipo_Doc === 'PA'?'X':''),
            $pdf->MultiCell(4, 3, 1, 'C');
            $pdf->SetXY(50, 77);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(4, 3, utf8_decode('PA'), 0, 0, 'C');
            $pdf->SetXY(55,77);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(4, 3, utf8_decode(''), 1, 'C');
            $pdf->SetXY(60, 77);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(4, 3, utf8_decode('MS'), 0, 0, 'C');
            $pdf->SetXY(65,77);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(4, 3, utf8_decode(''), 1, 'C');
            $pdf->SetXY(70, 77);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(4, 3, utf8_decode('AS'), 0, 0, 'C');
            $pdf->SetXY(75,77);
            $pdf->SetFont('Arial', '', 7);
            //despues del 3,: (self::$paciente->Tipo_Doc === 'PE'?'X':''),
            $pdf->MultiCell(4, 3, 1, 'C');
            $pdf->SetXY(80, 77);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(4, 3, utf8_decode('PE'), 0, 0, 'C');
            $pdf->SetXY(85,77);
            $pdf->SetFont('Arial', '', 7);
            //despues del 3,: (self::$paciente->Tipo_Doc === 'CN'?'X':''),
            $pdf->MultiCell(4, 3, 1, 'C');
            $pdf->SetXY(90, 77);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(4, 3, utf8_decode('CN'), 0, 0, 'C');

            $pdf->SetXY(100, 73);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.2 Número de identificación'), 0, 0, 'C');
            $pdf->SetXY(98,77);
            $pdf->SetFont('Arial', '', 7);
            //despues del 3,: self::$paciente->Num_Doc, 1,
            $pdf->MultiCell(92, 4, 'l');

            $pdf->SetXY(5, 82);
            $pdf->SetFont('Arial', 'B', 4.5);
            $pdf->Cell(200, 4, utf8_decode('*RC : REGISTRO CIVIL | TI : TARJETA IDENTIDAD | CC : CÉDULA CIUDADANÍA | CE : CÉDULA EXTRANJERÍA |- PA : PASAPORTE | MS : MENOR SIN ID | AS : ADULTO SIN ID | PE : PERMISO ESPECIAL DE PERMANENCIA | CN : CERTIFICADO DE NACIDO VIVO'), 1, 0, 'l');

            $pdf->SetXY(5, 87);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.3 Nombres y apellidos del paciente'), 0, 0, 'l');
            $pdf->SetXY(6,91);
            $pdf->SetFont('Arial', '', 7);
            // $pdf->MultiCell(140, 4, self::$paciente->Primer_Nom.(self::$paciente->SegundoNom?' '.self::$paciente->SegundoNom:'').' '.self::$paciente->Primer_Ape.' '.self::$paciente->Segundo_Ape, 1, 'l');
            $pdf->SetXY(150, 87);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.4 Teléfono'), 0, 0, 'C');
            $pdf->SetXY(160,91);
            $pdf->SetFont('Arial', '', 7);
            // $pdf->MultiCell(40, 4, self::$paciente->Telefono?self::$paciente->Telefono:'', 1, 'l');
            $pdf->SetXY(5, 96);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.5 Fecha de nacimiento (dd/mm/aaaa)'), 0, 0, 'l');
            $pdf->SetXY(7,100);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$paciente->Fecha_Naci?self::$paciente->Fecha_Naci:'',0,10),0,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(12,100);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$paciente->Fecha_Naci?self::$paciente->Fecha_Naci:'',0,10),1,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(16, 99);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('/'), 0, 0, 'C');
            $pdf->SetXY(20,100);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$paciente->Fecha_Naci?self::$paciente->Fecha_Naci:'',0,10),3,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(25,100);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$paciente->Fecha_Naci?self::$paciente->Fecha_Naci:'',0,10),4,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(29, 99);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('/'), 0, 0, 'C');
            $pdf->SetXY(33,100);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$paciente->Fecha_Naci?self::$paciente->Fecha_Naci:'',0,10),6,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(38,100);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$paciente->Fecha_Naci?self::$paciente->Fecha_Naci:'',0,10),7,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(43,100);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$paciente->Fecha_Naci?self::$paciente->Fecha_Naci:'',0,10),8,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(48,100);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$paciente->Fecha_Naci?self::$paciente->Fecha_Naci:'',0,10),9,1),
            $pdf->MultiCell(5, 4, 1, 'C');

            $pdf->SetXY(46, 96);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.6 Edad'), 0, 0, 'C');
            $pdf->SetXY(56,100);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(10, 4, self::$paciente->Edad_Cumplida?self::$paciente->Edad_Cumplida:'', 1, 'C');

            $pdf->SetXY(67, 96);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.7 Unidad de medida de la edad'), 0, 0, 'l');
            $pdf->SetXY(68,100);
            $pdf->SetFont('Arial', '', 4);
            //despues del 2do 3,: (self::$registroCovid->medida_edad === 'Años'?'X':''),
            $pdf->MultiCell(3, 3, 1, 'C');
            $pdf->SetXY(71, 100);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('1. Años'), 0, 0, 'l');

            $pdf->SetXY(68,104);
            $pdf->SetFont('Arial', '', 4);
            //despues del 2do 3,: (self::$registroCovid->medida_edad === 'Meses'?'X':''),
            $pdf->MultiCell(3, 3, 1, 'C');
            $pdf->SetXY(71, 104);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2. Meses'), 0, 0, 'l');

            $pdf->SetXY(83,100);
            $pdf->SetFont('Arial', '', 4);
            //despues del 2do 3,: (self::$registroCovid->medida_edad === 'Días'?'X':''),
            $pdf->MultiCell(3, 3, 1, 'C');
            $pdf->SetXY(86, 100);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('3. Días'), 0, 0, 'l');

            $pdf->SetXY(83,104);
            $pdf->SetFont('Arial', '', 4);
            //despues del 2do 3,: (self::$registroCovid->medida_edad === 'Horas'?'X':''),
            $pdf->MultiCell(3, 3, 1, 'C');
            $pdf->SetXY(86, 104);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('4. Horas'), 0, 0, 'l');

            $pdf->SetXY(98,100);
            $pdf->SetFont('Arial', '', 4);
            //despues del 2do 3,: (self::$registroCovid->medida_edad === 'Minutos'?'X':''),
            $pdf->MultiCell(3, 3, 1, 'C');
            $pdf->SetXY(101, 100);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('5. Minutos'), 0, 0, 'l');

            $pdf->SetXY(98,104);
            $pdf->SetFont('Arial', '', 4);
            //despues del 2do 3,: (self::$registroCovid->medida_edad === 'No aplica'?'X':''),
            $pdf->MultiCell(3, 3, 1, 'C');
            $pdf->SetXY(101, 104);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('0. No aplica'), 0, 0, 'l');

            $pdf->SetXY(118, 96);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.8 Sexo'), 0, 0, 'l');
            $pdf->SetXY(119,100);
            $pdf->SetFont('Arial', '', 4);
            //despues del 2do 3,: (substr(self::$paciente->Sexo,0,1) === 'M'?'X':''),
            $pdf->MultiCell(3, 3, 1, 'C');
            $pdf->SetXY(122, 100);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('M. Masculino'), 0, 0, 'l');

            $pdf->SetXY(119,104);
            $pdf->SetFont('Arial', '', 4);
            //despues del 2do 3,: (substr(self::$paciente->Sexo,0,1) === 'F'?'X':''),
            $pdf->MultiCell(3, 3, 1, 'C');
            $pdf->SetXY(122, 104);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('F. Femenino'), 0, 0, 'l');

            $pdf->SetXY(138,100);
            $pdf->SetFont('Arial', '', 4);
            $pdf->MultiCell(3, 3, utf8_decode(''), 1, 'C');
            $pdf->SetXY(141, 100);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('I. Indeterminado'), 0, 0, 'l');

            $pdf->SetXY(161, 96);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.9 Nacionalidad'), 0, 0, 'l');

            //$nacionalidad = Paise::find(self::$registroCovid->pais_nacionalidad_id);
            $pdf->SetXY(162,100);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(23, 4, utf8_decode($nacionalidad->nombre?$nacionalidad->nombre:''), 1, 'l');

            $pdf->SetXY(189,100);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode('1'), 1, 'C');
            $pdf->SetXY(194,100);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode('7'), 1, 'C');
            $pdf->SetXY(199,100);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode('0'), 1, 'C');

            $pdf->SetXY(5, 108);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.10 País de ocurrencia del caso'), 0, 0, 'l');

            //$ocurrencia = Paise::find(self::$registroCovid->pais_ocurrencia_id);

            $pdf->SetXY(7,112);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(25, 4, utf8_decode($ocurrencia->nombre?$ocurrencia->nombre:''), 1, 'l');
            $pdf->SetXY(35,112);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$pais->codigo?self::$pais->codigo:'',0,3),0,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(40,112);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$pais->codigo?self::$pais->codigo:'',0,3),1,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(45,112);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$pais->codigo?self::$pais->codigo:'',0,3),2,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(38, 116);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(40, 4, utf8_decode('Codigo'), 0, 0, 'l');

            $pdf->SetXY(51, 108);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.11 Departamento y municipio de procedencia/ocurrencia'), 0, 0, 'l');

            //$municipioProcedencia = Municipio::find(self::$registroCovid->municipio_procedencia_id);
            $pdf->SetXY(52,112);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(47, 4, utf8_decode($municipioProcedencia->Nombre?$municipioProcedencia->Nombre:''), 1, 'l');
            $pdf->SetXY(103,112);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$deparprocedencia->codigo_Dane?self::$deparprocedencia->codigo_Dane:'',0,3),0,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(108,112);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$deparprocedencia->codigo_Dane?self::$deparprocedencia->codigo_Dane:'',0,3),1,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(100, 116);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(40, 4, utf8_decode('Departamento'), 0, 0, 'l');

            $pdf->SetXY(116,112);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$municipioprocedencia->codigo_Dane?self::$municipioprocedencia->codigo_Dane:'',0,3),0,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(121,112);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$municipioprocedencia->codigo_Dane?self::$municipioprocedencia->codigo_Dane:'',0,3),1,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(126,112);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$municipioprocedencia->codigo_Dane?self::$municipioprocedencia->codigo_Dane:'',0,3),2,1),
            $pdf->MultiCell(5, 4, 1, 'C');;
            $pdf->SetXY(118, 116);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(40, 4, utf8_decode('Municipio'), 0, 0, 'l');

            $pdf->SetXY(135, 108);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.12 Área de ocurrencia del caso'), 0, 0, 'l');

            $pdf->SetXY(141,112);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->area_ocurrencia_caso === 'Cabecera municipal'?'X':'')), 1, 'C');
            $pdf->SetXY(144, 112);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('1. Cabecera municipal'), 0, 0, 'l');

            $pdf->SetXY(141,116);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->area_ocurrencia_caso === 'Centro poblado'?'X':'')), 1, 'C');
            $pdf->SetXY(144, 116);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('2. Centro poblado'), 0, 0, 'l');

            $pdf->SetXY(175,112);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->area_ocurrencia_caso === 'Rural disperso'?'X':'')), 1, 'C');
            $pdf->SetXY(178, 112);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('3. Rural disperso'), 0, 0, 'l');

            $pdf->SetXY(5, 120);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.13 Localidad de ocurrencia del caso'), 0, 0, 'l');

            $pdf->SetXY(7,124);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(45, 4, utf8_decode(self::$registroCovid->localidad_ocurrencia_caso?self::$registroCovid->localidad_ocurrencia_caso:''), 1, 'L');

            $pdf->SetXY(55, 120);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.14 Barrio de ocurrencia del caso'), 0, 0, 'l');

            $pdf->SetXY(56,124);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(42, 4, utf8_decode(self::$registroCovid->barrio_ocurrencia_caso?self::$registroCovid->barrio_ocurrencia_caso:''), 1, 'C');

            $pdf->SetXY(100, 120);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.15 Cabecera municipal/centro poblado/rural disperso'), 0, 0, 'l');

            $pdf->SetXY(101,124);
            $pdf->SetFont('Arial', '', 4);
            $pdf->MultiCell(65, 4, utf8_decode(''), 1, 'C');

            $pdf->SetXY(168, 120);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.16 Vereda/zona'), 0, 0, 'l');

            $pdf->SetXY(169,124);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(35, 4, utf8_decode(self::$registroCovid->zona?self::$registroCovid->zona:''), 1, 'C');

            $pdf->SetXY(5, 129);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.17 Ocupación del paciente'), 0, 0, 'l');

            $pdf->SetXY(7,133);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(26, 4, utf8_decode(self::$ocupacionpaciente->ocupacion ? self::$ocupacionpaciente->ocupacion:''), 1, 'l');
            $pdf->SetXY(35,133);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(5, 4,substr(substr(self::$ocupacionpaciente->codigo ? self::$ocupacionpaciente->codigo:'',0,5),0,1), 1, 'C');
            $pdf->SetXY(40,133);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(5, 4,substr(substr(self::$ocupacionpaciente->codigo ? self::$ocupacionpaciente->codigo:'',0,5),1,1), 1, 'C');
            $pdf->SetXY(45,133);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(5, 4,substr(substr(self::$ocupacionpaciente->codigo ? self::$ocupacionpaciente->codigo:'',0,5),2,1), 1, 'C');
            $pdf->SetXY(50,133);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(5, 4,substr(substr(self::$ocupacionpaciente->codigo ? self::$ocupacionpaciente->codigo:'',0,5),3,1), 1, 'C');
            $pdf->SetXY(34, 137);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(24, 4, utf8_decode('Código'), 0, 0, 'C');

            $pdf->SetXY(58, 129);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.18 Tipo de régimen en salud'), 0, 0, 'l');

            $pdf->SetXY(59,133);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->tipo_regimen_salud==='P. Excepción'?'X':'')), 1, 'C');
            $pdf->SetXY(62, 133);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('P. Excepción'), 0, 0, 'l');

            $pdf->SetXY(59,137);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->tipo_regimen_salud==='E. Especial'?'X':'')), 1, 'C');
            $pdf->SetXY(62, 137);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('E. Especial'), 0, 0, 'l');

            $pdf->SetXY(78,133);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->tipo_regimen_salud==='C. Contributivo'?'X':'')), 1, 'C');
            $pdf->SetXY(81, 133);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('C. Contributivo'), 0, 0, 'l');

            $pdf->SetXY(78,137);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->tipo_regimen_salud==='S. Subsidiado'?'X':'')), 1, 'C');
            $pdf->SetXY(81, 137);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('S. Subsidiado'), 0, 0, 'l');

            $pdf->SetXY(99,133);
            $pdf->SetFont('Arial', '', 4);
            //s$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->tipo_regimen_salud==='N. No Asegurado'?'X':'')), 1, 'C');
            $pdf->SetXY(102, 133);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('N. No Asegurado'), 0, 0, 'l');

            $pdf->SetXY(99,137);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->tipo_regimen_salud==='I. Indeterminado/ pendiente'?'X':'')), 1, 'C');
            $pdf->SetXY(102, 137);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('I. Indeterminado/ pendiente'), 0, 0, 'l');

            $pdf->SetXY(132, 129);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.19 Nombre de la administradora de Planes de beneficios'), 0, 0, 'l');

            $pdf->SetXY(133,133);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(37, 4, utf8_decode(self::$paciente->Ut?self::$paciente->Ut:''), 1, 'l');
            // EAS027
            // if (self::$paciente->Ut == 'REDVITAL UT') {
            //     $pdf->SetXY(173,133);
            //     $pdf->SetFont('Arial', '', 7);
            //     $pdf->MultiCell(5, 4, utf8_decode('R'), 1, 'l');
            //     $pdf->SetXY(178,133);
            //     $pdf->SetFont('Arial', '', 7);
            //     $pdf->MultiCell(5, 4, utf8_decode('E'), 1, 'l');
            //     $pdf->SetXY(183,133);
            //     $pdf->SetFont('Arial', '', 7);
            //     $pdf->MultiCell(5, 4, utf8_decode('S'), 1, 'l');
            //     $pdf->SetXY(188,133);
            //     $pdf->SetFont('Arial', '', 7);
            //     $pdf->MultiCell(5, 4, utf8_decode('0'), 1, 'l');
            //     $pdf->SetXY(193,133);
            //     $pdf->SetFont('Arial', '', 7);
            //     $pdf->MultiCell(5, 4, utf8_decode('0'), 1, 'l');
            //     $pdf->SetXY(198,133);
            //     $pdf->SetFont('Arial', '', 7);
            //     $pdf->MultiCell(5, 4, utf8_decode('4'), 1, 'l');
            //     $pdf->SetXY(170, 137);
            //     $pdf->SetFont('Arial', '', 7);
            //     $pdf->Cell(36, 4, utf8_decode('Código'), 0, 0, 'C');
            // }elseif (self::$paciente->Ut == 'MEDIMAS') {
            //     $pdf->SetXY(173,133);
            //     $pdf->SetFont('Arial', 'E', 7);
            //     $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');
            //     $pdf->SetXY(178,133);
            //     $pdf->SetFont('Arial', 'A', 7);
            //     $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');
            //     $pdf->SetXY(183,133);
            //     $pdf->SetFont('Arial', 'S', 7);
            //     $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');
            //     $pdf->SetXY(188,133);
            //     $pdf->SetFont('Arial', '0', 7);
            //     $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');
            //     $pdf->SetXY(193,133);
            //     $pdf->SetFont('Arial', '2', 7);
            //     $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');
            //     $pdf->SetXY(198,133);
            //     $pdf->SetFont('Arial', '7', 7);
            //     $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');
            //     $pdf->SetXY(170, 137);
            //     $pdf->SetFont('Arial', '', 7);
            //     $pdf->Cell(36, 4, utf8_decode('Código'), 0, 0, 'C');
            // }


            $pdf->SetXY(5, 141);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.20 Pertenencia étnica'), 0, 0, 'l');

            $pdf->SetXY(7,145);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->pertenencia_etnica === 'Indígena'?'X':'')), 1, 'C');
            $pdf->SetXY(10, 145);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('1. Indígena'), 0, 0, 'l');

            $pdf->SetXY(27, 143);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('Grupo ètnico'), 0, 0, 'l');
            $pdf->SetXY(27,146);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(15, 3, utf8_decode('indigena'), 0, 'C');

            $pdf->SetXY(48,145);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->pertenencia_etnica === 'Rom, Gitano'?'X':'')), 1, 'C');
            $pdf->SetXY(51, 145);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2. Rom, Gitano'), 0, 0, 'l');

            $pdf->SetXY(71,145);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->pertenencia_etnica === 'Raiza'?'X':'')), 1, 'C');
            $pdf->SetXY(74, 145);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('3. Raiza'), 0, 0, 'l');

            $pdf->SetXY(86,145);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->pertenencia_etnica === 'Palenquero'?'X':'')), 1, 'C');
            $pdf->SetXY(89, 145);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('4. Palenquero'), 0, 0, 'l');

            $pdf->SetXY(108,145);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->pertenencia_etnica === 'Negro, mulato afro colombiano'?'X':'')), 1, 'C');
            $pdf->SetXY(111, 145);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('5. Negro, mulato afro colombiano'), 0, 0, 'l');

            $pdf->SetXY(153,145);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->pertenencia_etnica === 'Otro'?'X':'')), 1, 'C');
            $pdf->SetXY(156, 145);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode(' 6. Otro'), 0, 0, 'l');

            $pdf->SetXY(175, 141);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.21 Estrato'), 0, 0, 'l');

            $pdf->SetXY(175,145);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(25, 4, utf8_decode(self::$registroCovid->estrato?self::$registroCovid->estrato:''), 1, 'C');

            $pdf->SetXY(5, 150);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2.22 Seleccione los grupos poblacionales a los que pertenece el paciente'), 0, 0, 'l');

            $pdf->SetXY(12,154);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->discapacitados?'X':'')), 1, 'C');
            $pdf->SetXY(15, 154);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('Discapacitados'), 0, 0, 'l');

            $pdf->SetXY(12,158);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->desplazados?'X':'')), 1, 'C');
            $pdf->SetXY(15, 158);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('Desplazados'), 0, 0, 'l');

            $pdf->SetXY(34,154);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->Migrantes?'X':'')), 1, 'C');
            $pdf->SetXY(37, 154);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('Migrantes'), 0, 0, 'l');

            $pdf->SetXY(34,158);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->carcelarios?'X':'')), 1, 'C');
            $pdf->SetXY(37, 158);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('Carcelario'), 0, 0, 'l');

            $pdf->SetXY(51,154);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->Gestantes?'X':'')), 1, 'C');
            $pdf->SetXY(54, 154);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('Gestantes'), 0, 0, 'l');

            $pdf->SetXY(51,158);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->indigentes?'X':'')), 1, 'C');
            $pdf->SetXY(54, 158);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('Indigentes'), 0, 0, 'l');

            $pdf->SetXY(68,154);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(7, 7, utf8_decode((self::$registroCovid->Sem_de_gestacion?'X':'')), 1, 'C');
            $pdf->SetXY(75, 156);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('Sem.de gestaciòn'), 0, 0, 'l');

            $pdf->SetXY(96,154);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->poblacion_infantil_ICBF?'X':'')), 1, 'C');
            $pdf->SetXY(99, 154);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('Población infantil a cargo del ICBF'), 0, 0, 'l');

            $pdf->SetXY(96,158);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->madres_comunitarias?'X':'')), 1, 'C');
            $pdf->SetXY(99, 158);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('Madres comunitarias'), 0, 0, 'l');

            $pdf->SetXY(136,154);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->desmovilizados?'X':'')), 1, 'C');
            $pdf->SetXY(139, 154);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('Desmovilizados'), 0, 0, 'l');

            $pdf->SetXY(136,158);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->centros_psiquiatricos?'X':'')), 1, 'C');
            $pdf->SetXY(139, 158);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('Centros psiquiátricos'), 0, 0, 'l');

            $pdf->SetXY(165,154);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->victimas_violencia_armada?'X':'')), 1, 'C');
            $pdf->SetXY(168, 154);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('Víctimas de violencia armada'), 0, 0, 'l');

            $pdf->SetXY(165,158);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->otros_grupos_poblacionales?'X':'')), 1, 'C');
            $pdf->SetXY(168, 158);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('Otros grupos poblacionales'), 0, 0, 'l');

#MARGENES IDENTIFICACION PACIENTE
            $pdf->Line(5, 73, 5, 162); #LINA VERTICAL IZQUIERDA
            $pdf->Line(205, 73, 205, 162); #LINEA VERTICAL DERECHA
            $pdf->Line(5, 73, 205, 73); #LINEA HORIZONTAL ARRIBA
            $pdf->Line(5, 162, 205, 162); #LINEA HORIZONTAL ABAJO
#LINEA 1
            $pdf->Line(95, 73, 95, 82); #LINEA VERTICAL 1
#LIENA 2
            $pdf->Line(155, 86, 155, 96);#LIENA VERTICAL 1
            $pdf->Line(5, 96, 205, 96);#LINEA HORIZONTAL ABAJO
#LINEA 3
            $pdf->Line(5, 108, 205, 108);
            $pdf->Line(55, 96, 55, 108); #LINEA VERTICAL 1
            $pdf->Line(67, 96, 67, 108); #LINEA VERTICAL 2
            $pdf->Line(117, 96, 117, 108); #LINEA VERTICAL 3
            $pdf->Line(160, 96, 160,108); #LINEA VERTICAL 4
#linea 4
            $pdf->Line(5, 120, 205, 120);
            $pdf->Line(51, 108, 51,120); #lINEA VERTICAL 1
            $pdf->Line(134, 108, 134,120); #LINEA VERTICAL 2
#Linea 5
            $pdf->Line(5, 129, 205, 129);
            $pdf->Line(54, 120, 54,129); #LINEA VERTICAL 1
            $pdf->Line(100, 120, 100,129); #LINEA VERTICAL 2
            $pdf->Line(168, 120, 168,129); #LINEA VERTICAL 3
#linea 6
            $pdf->Line(5, 141, 205, 141);
            $pdf->Line(57, 129, 57,141);
            $pdf->Line(132, 129, 132,141);
#linea 7
            $pdf->Line(5, 150, 205, 150);
            $pdf->Line(170, 141, 170,150);

            $pdf->SetXY(5,163);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(200, 4, utf8_decode('3. NOTIFICACIÓN'), 1, 0, 'C',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);

            $pdf->SetXY(5, 168);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('3.1 Fuente'), 0, 0, 'l');
            $pdf->SetXY(7,172);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->fuente==='Notificación rutinaria'?'X':'')), 1, 'C');
            $pdf->SetXY(10, 172);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('1. Notificación rutinaria'), 0, 0, 'l');

            $pdf->SetXY(7,176);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->fuente==='Búsqueda activa Inst.'?'X':'')), 1, 'C');
            $pdf->SetXY(10, 176);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('2. Búsqueda activa Inst.'), 0, 0, 'l');

            $pdf->SetXY(36,172);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->fuente==='Vigilancia Intensificada'?'X':'')), 1, 'C');
            $pdf->SetXY(39, 172);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('3. Vigilancia Intensificada'), 0, 0, 'l');

            $pdf->SetXY(36,176);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->fuente==='Búsqueda activa com.'?'X':'')), 1, 'C');
            $pdf->SetXY(39, 176);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('4. Búsqueda activa com.'), 0, 0, 'l');

            $pdf->SetXY(67,172);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->fuente==='Investigaciones'?'X':'')), 1, 'C');
            $pdf->SetXY(70, 172);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('5. Investigaciones'), 0, 0, 'l');

            $pdf->SetXY(91, 168);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('3.2 País, departamento y municipio de residencia del paciente'), 0, 0, 'l');

            $pdf->SetXY(92,172);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(61, 4, utf8_decode(self::$paciente->Mpio_Residencia?self::$paciente->Mpio_Residencia:''), 1, 'l');

            $pdf->SetXY(157,172);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode('1'), 1, 'C');
            $pdf->SetXY(162,172);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode('7'), 1, 'C');
            $pdf->SetXY(167,172);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode('0'), 1, 'C');
            $pdf->SetXY(161, 176);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(40, 4, utf8_decode('Pais'), 0, 0, 'l');

            $pdf->SetXY(175,172);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$deparprocedencia->codigo_Dane?self::$deparprocedencia->codigo_Dane:'',0,3),0,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(180,172);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$deparprocedencia->codigo_Dane?self::$deparprocedencia->codigo_Dane:'',0,3),1,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(171, 176);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(40, 4, utf8_decode('Departamento'), 0, 0, 'l');

            $pdf->SetXY(188,172);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$municipioprocedencia->codigo_Dane?self::$municipioprocedencia->codigo_Dane:'',0,3),0,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(193,172);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$municipioprocedencia->codigo_Dane?self::$municipioprocedencia->codigo_Dane:'',0,3),1,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(198,172);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(substr(self::$municipioprocedencia->codigo_Dane?self::$municipioprocedencia->codigo_Dane:'',0,3),2,1),
            $pdf->MultiCell(5, 4, 1, 'C');
            $pdf->SetXY(190, 176);
            $pdf->SetFont('Arial', '', 7);
            $pdf->Cell(40, 4, utf8_decode('Municipio'), 0, 0, 'l');

            $pdf->SetXY(5, 180);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(34, 4, utf8_decode('3.3 Dirección de residencia'), 0, 0, 'l');
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(162, 4, utf8_decode(self::$paciente->Direccion_Residencia?self::$paciente->Direccion_Residencia:''), 1, 'l');

            $pdf->SetXY(5, 184);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('3.4 Fecha de consulta (dd/mm/aaaa)'), 0, 0, 'l');
            $pdf->SetXY(7,188);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_consulta,-2,1), 1,
            $pdf->MultiCell(5, 4, 'l');
            $pdf->SetXY(12,188);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_consulta,-1,1),
            $pdf->MultiCell(5, 4,  1, 'l');
            $pdf->SetXY(16, 187);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('/'), 0, 0, 'C');
            $pdf->SetXY(20,188);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_consulta,-5,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(25,188);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_consulta,-4,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(29, 187);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('/'), 0, 0, 'C');
            $pdf->SetXY(33,188);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_consulta,-10,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(38,188);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_consulta,-9,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(43,188);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_consulta,-8,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(48,188);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_consulta,-7,1)
            $pdf->MultiCell(5, 4, 1, 'l');

            $pdf->SetXY(55, 184);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('3.5 Fecha de inicio de síntomas (dd/mm/aaaa)'), 0, 0, 'l');
            $pdf->SetXY(56,188);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_inicio_sintomas,-2,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(61,188);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_inicio_sintomas,-1,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(65, 187);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('/'), 0, 0, 'C');
            $pdf->SetXY(69,188);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_inicio_sintomas,-5,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(74,188);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_inicio_sintomas,-4,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(78, 187);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('/'), 0, 0, 'C');
            $pdf->SetXY(82,188);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_inicio_sintomas,-10,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(87,188);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_inicio_sintomas,-9,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(92,188);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_inicio_sintomas,-8,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(97,188);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_inicio_sintomas,-7,1),
            $pdf->MultiCell(5, 4, 1, 'l');

            $pdf->SetXY(111, 184);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('3.6 Clasificación inicial de caso'), 0, 0, 'l');

            $pdf->SetXY(113,188);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->clasificacion === 'Sospechoso'?'X':'')), 1, 'C');
            $pdf->SetXY(116, 188);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('1. Sospechoso'), 0, 0, 'l');

            $pdf->SetXY(113,192);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->clasificacion === 'Probable'?'X':'')), 1, 'C');
            $pdf->SetXY(116, 192);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('2. Probable'), 0, 0, 'l');

            $pdf->SetXY(133,188);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->clasificacion === 'Conf. por laboratorio'?'X':'')), 1, 'C');
            $pdf->SetXY(136, 188);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('3. Conf. por laboratorio'), 0, 0, 'l');

            $pdf->SetXY(133,192);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->clasificacion === 'Conf. Clínica'?'X':'')), 1, 'C');
            $pdf->SetXY(136, 192);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('4. Conf. Clínica'), 0, 0, 'l');

            $pdf->SetXY(113,196);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->clasificacion === 'Conf. nexo epidemiológico'?'X':'')), 1, 'C');
            $pdf->SetXY(116, 196);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('5. Conf. nexo epidemiológico'), 0, 0, 'l');

            $pdf->SetXY(164, 184);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('3.7 Hospitalizado'), 0, 0, 'l');

            $pdf->SetXY(165,188);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->hospitalizado === 'SI'?'X':'')), 1, 'C');
            $pdf->SetXY(168, 188);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('Si'), 0, 0, 'l');

            $pdf->SetXY(172,188);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->hospitalizado === 'NO'?'X':'')), 1, 'C');
            $pdf->SetXY(175, 188);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('No'), 0, 0, 'l');

            $pdf->SetXY(5, 200);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('3.8 Fecha de hospitalización (dd/mm/aaaa)'), 0, 0, 'l');
            $pdf->SetXY(7,204);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_hospitalizacion?self::$registroCovid->fecha_hospitalizacion:'',-2,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(12,204);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_hospitalizacion?self::$registroCovid->fecha_hospitalizacion:'',-1,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(16, 203);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('/'), 0, 0, 'C');
            $pdf->SetXY(20,204);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_hospitalizacion?self::$registroCovid->fecha_hospitalizacion:'',-5,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(25,204);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_hospitalizacion?self::$registroCovid->fecha_hospitalizacion:'',-4,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(29, 203);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('/'), 0, 0, 'C');
            $pdf->SetXY(33,204);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_hospitalizacion?self::$registroCovid->fecha_hospitalizacion:'',-10,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(38,204);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_hospitalizacion?self::$registroCovid->fecha_hospitalizacion:'',-10,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(43,204);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_hospitalizacion?self::$registroCovid->fecha_hospitalizacion:'',-8,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(48,204);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_hospitalizacion?self::$registroCovid->fecha_hospitalizacion:'',-7,1),
            $pdf->MultiCell(5, 4, 1, 'l');

            $pdf->SetXY(57, 200);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('3.9 Condición final'), 0, 0, 'l');

            $pdf->SetXY(58,204);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->condicion_final==='Vivo'?'X':'')), 1, 'C');
            $pdf->SetXY(61, 204);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('1. Vivo'), 0, 0, 'l');

            $pdf->SetXY(58,208);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->condicion_final==='Muerto'?'X':'')), 1, 'C');
            $pdf->SetXY(61, 208);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('2. Muerto'), 0, 0, 'l');

            $pdf->SetXY(72,204);
            $pdf->SetFont('Arial', '', 4);
            //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->condicion_final==='No sabe, no responde'?'X':'')), 1, 'C');
            $pdf->SetXY(74, 204);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode(' 0. No sabe, no responde'), 0, 0, 'l');

            $pdf->SetXY(102, 200);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('3.10 Fecha de defunción (dd/mm/aaaa)'), 0, 0, 'l');

            $pdf->SetXY(103,204);
            $pdf->SetFont('Arial', '', 7);
            //despues del 4,: substr(self::$registroCovid->fecha_defuncion?self::$registroCovid->fecha_defuncion:'',-2,1),
            $pdf->MultiCell(5, 4, 1, 'l');
            $pdf->SetXY(108,204);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(5, 4, substr(self::$registroCovid->fecha_defuncion?self::$registroCovid->fecha_defuncion:'',-1,1), 1, 'l');
            $pdf->SetXY(112, 203);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('/'), 0, 0, 'C');
            $pdf->SetXY(116,204);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(5, 4, substr(self::$registroCovid->fecha_defuncion?self::$registroCovid->fecha_defuncion:'',-5,1), 1, 'l');
            $pdf->SetXY(121,204);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(5, 4, substr(self::$registroCovid->fecha_defuncion?self::$registroCovid->fecha_defuncion:'',-4,1), 1, 'l');
            $pdf->SetXY(125, 203);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('/'), 0, 0, 'C');
            $pdf->SetXY(129,204);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(5, 4, substr(self::$registroCovid->fecha_defuncion?self::$registroCovid->fecha_defuncion:'',-10,1), 1, 'l');
            $pdf->SetXY(134,204);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(5, 4, substr(self::$registroCovid->fecha_defuncion?self::$registroCovid->fecha_defuncion:'',-9,1), 1, 'l');
            $pdf->SetXY(139,204);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(5, 4, substr(self::$registroCovid->fecha_defuncion?self::$registroCovid->fecha_defuncion:'',-8,1), 1, 'l');
            $pdf->SetXY(144,204);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(5, 4, substr(self::$registroCovid->fecha_defuncion?self::$registroCovid->fecha_defuncion:'',-7,1), 1, 'l');

            $pdf->SetXY(150, 200);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('3.11 Número certificado de defunción'), 0, 0, 'l');

            $pdf->SetXY(151,204);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(50, 4, self::$registroCovid->numero_certificado_defuncion?self::$registroCovid->numero_certificado_defuncion:'', 1, 'l');

            $pdf->SetXY(5, 212);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('3.12 Causa básica de muerte '), 0, 0, 'l');

            $pdf->SetXY(7,216);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(64, 4, utf8_decode(self::$registroCovid->causa_basica_muerte?self::$registroCovid->causa_basica_muerte:''), 1, 'l');
            $pdf->SetXY(73,216);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');
            $pdf->SetXY(78,216);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');
            $pdf->SetXY(83,216);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');
            $pdf->SetXY(88,216);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');

            $pdf->SetXY(95, 212);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('3.13 Nombre del profesional que diligenció la ficha'), 0, 0, 'l');

            $pdf->SetXY(97,216);
            $pdf->SetFont('Arial', '', 7);
            //$pdf->MultiCell(66, 4, utf8_decode(self::$medicoatiende->name.' '.self::$medicoatiende->apellido), 1, 'l');

            $pdf->SetXY(167, 212);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('3.14 Teléfono'), 0, 0, 'l');

            $pdf->SetXY(169,216);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(32, 4, utf8_decode('520-10-44'), 1, 'l');

            $pdf->Line(5, 168, 5, 221); #LINA VERTICAL IZQUIERDA
            $pdf->Line(205, 168, 205, 221); #LINEA VERTICAL DERECHA
            $pdf->Line(5, 168, 205, 168); #LINEA HORIZONTAL ARRIBA
            $pdf->Line(5, 221, 205, 221); #LINEA HORIZONTAL ABAJO
#linea 1
            $pdf->Line(91, 168, 91, 180); #LINA VERTICAL 1
            $pdf->Line(5, 180, 205, 180); #LINA HORIZONTAL 1
#LINEA 2
            $pdf->Line(5, 184, 205, 184); #LINA VERTICAL 1
#LINEA 3
            $pdf->Line(55, 184, 55, 200); #LINA VERTICAL 1
            $pdf->Line(111, 184, 111, 200); #LINA VERTICAL 2
            $pdf->Line(163, 184, 163, 200); #LINA VERTICAL 3
            $pdf->Line(5, 200, 205, 200); #LINA HORIZONTAL 1
#LINEA 4
            $pdf->Line(57, 200, 57, 212); #LINA VERTICAL 1
            $pdf->Line(102, 200, 102, 212); #LINA VERTICAL 2
            $pdf->Line(150, 200, 150, 212); #LINA VERTICAL 3
            $pdf->Line(5, 212, 205, 212); #LINA HORIZONTAL 1
#linea 5
            $pdf->Line(95, 212, 95, 221); #LINA VERTICAL 1
            $pdf->Line(166, 212, 166, 221); #LINA VERTICAL 2

            $pdf->SetXY(5,222);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(200, 4, utf8_decode('4. ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES'), 1, 0, 'C',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);

            $pdf->SetXY(5, 227);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('4.1 Seguimiento y clasificación final del caso'), 0, 0, 'l');

            $pdf->SetXY(7,231);
            $pdf->SetFont('Arial', '', 4);
            $pdf->MultiCell(3, 3, utf8_decode(''), 1, 'C');
            $pdf->SetXY(10, 231);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('0. No aplica'), 0, 0, 'l');

            $pdf->SetXY(7,235);
            $pdf->SetFont('Arial', '', 4);
            $pdf->MultiCell(3, 3, utf8_decode(''), 1, 'C');
            $pdf->SetXY(10, 235);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('3. Conf. por laboratorio'), 0, 0, 'l');

            $pdf->SetXY(37,231);
            $pdf->SetFont('Arial', '', 4);
            $pdf->MultiCell(3, 3, utf8_decode(''), 1, 'C');
            $pdf->SetXY(40, 231);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('4. Conf. Clínica'), 0, 0, 'l');

            $pdf->SetXY(37,235);
            $pdf->SetFont('Arial', '', 4);
            $pdf->MultiCell(3, 3, utf8_decode(''), 1, 'C');
            $pdf->SetXY(40, 235);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('5. Conf. nexo epidemiológico'), 0, 0, 'l');

            $pdf->SetXY(73,231);
            $pdf->SetFont('Arial', '', 4);
            $pdf->MultiCell(3, 3, utf8_decode(''), 1, 'C');
            $pdf->SetXY(76, 231);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('6. Descartado'), 0, 0, 'l');

            $pdf->SetXY(73,235);
            $pdf->SetFont('Arial', '', 4);
            $pdf->MultiCell(3, 3, utf8_decode(''), 1, 'C');
            $pdf->SetXY(76, 235);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('7. Otra actualización'), 0, 0, 'l');

            $pdf->SetXY(99,231);
            $pdf->SetFont('Arial', '', 4);
            $pdf->MultiCell(3, 3, utf8_decode(''), 1, 'C');
            $pdf->SetXY(102, 231);
            $pdf->SetFont('Arial', 'B', 6);
            $pdf->Cell(30, 4, utf8_decode('D. Descartado por error de digitación'), 0, 0, 'l');

            $pdf->SetXY(150, 227);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('4.2 Fecha de ajuste (dd/mm/aaaa)'), 0, 0, 'l');
            $pdf->SetXY(150,231);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(155,231);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(159, 230);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('/'), 0, 0, 'C');
            $pdf->SetXY(163,231);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(168,231);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(172, 230);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('/'), 0, 0, 'C');
            $pdf->SetXY(176,231);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(181,231);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(186,231);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(191,231);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');


            $pdf->Line(5, 227, 5, 240); #LINA VERTICAL IZQUIERDA
            $pdf->Line(205, 227, 205, 240); #LINEA VERTICAL DERECHA
            $pdf->Line(5, 227, 205, 227); #LINEA HORIZONTAL ARRIBA
            $pdf->Line(5, 240, 205, 240); #LINEA HORIZONTAL ABAJO
            $pdf->AddPage();


        $pdf->SetXY(10, 13);
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(192, 4, utf8_decode('SISTEMA NACIONAL DE VIGILANCIA EN SALUD PÚBLICA'), 0, 0, 'C');
        $pdf->SetFont('Arial', '', 12);
        $pdf->SetXY(10, 18);
        $pdf->Cell(192, 4, utf8_decode('Subsistema de información SIVIGILA'), 0, 0, 'C');
        $pdf->SetXY(10, 23);
        $pdf->Cell(192, 4, utf8_decode('Ficha de notificación individual - Datos complementarios'), 0, 0, 'C');

#IMAGEN Y DATOS EMPRESARIALES
        $pdf->SetFont('Arial', 'B', 9);
        $logo ="/images/logo_instituto_salud.png";
        $pdf->Image($logo, 10, 10, -99);

        $pdf->SetFont('Arial', 'B', 9);
        $logo ="/images/logo_republica_colombia.png";
        $pdf->Image($logo, 185, 8, -190);

        $pdf->SetXY(10, 31);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(192, 4, utf8_decode('Infección respiratoria aguda por virus nuevo. Cod INS 346'), 0, 0, 'C');

        $pdf->SetXY(5, 37);
        $pdf->SetFont('Arial', '', 6.5);
        $pdf->Cell(192, 4, utf8_decode('La ficha de notificación es para fines de vigilancia en salud pública y todas las entidades que participen en el proceso deben garantizar la confidencialidad de la información LEY 1273/09 y 1266/09'), 0, 0, 'l');

        $pdf->SetXY(5,41);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(200, 4, utf8_decode('EVENTO DE NOTIFICACIÓN INMEDIATA'), 0, 0, 'R',1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetXY(5,46);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(200, 4, utf8_decode('FOR-R02.0000-075 V:02 2021-05-23'), 0, 0, 'R',1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetXY(5,46);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(200, 4, utf8_decode('RELACIÓN CON DATOS BÁSICOS'), 0, 0, 'L',0);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetXY(5, 51);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('A. Nombres y apellidos del paciente'), 0, 0, 'l');
        $pdf->SetXY(7,55);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(107, 4, utf8_decode(self::$paciente->Primer_Nom.(self::$paciente->SegundoNom?' '.self::$paciente->SegundoNom:'').' '.self::$paciente->Primer_Ape.' '.self::$paciente->Segundo_Ape), 0, 'L');

        $pdf->SetXY(120, 51);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('B. Tipo de ID'), 0, 0, 'l');
        $pdf->SetXY(121,55);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(20, 4, utf8_decode(self::$paciente->Tipo_Doc), 0, 'L');

        $pdf->SetXY(144, 51);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('C. Número de identificación'), 0, 0, 'l');
        $pdf->SetXY(145,55);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(55, 4, utf8_decode(self::$paciente->Num_Doc), 0, 'L');

        $pdf->SetXY(5, 60);
        $pdf->SetFont('Arial', 'B', 4.5);
        $pdf->Cell(200, 4, utf8_decode('*RC : REGISTRO CIVIL | TI : TARJETA IDENTIDAD | CC : CÉDULA CIUDADANÍA | CE : CÉDULA EXTRANJERÍA |- PA : PASAPORTE | MS : MENOR SIN ID | AS : ADULTO SIN ID | PE : PERMISO ESPECIAL DE PERMANENCIA | CN : CERTIFICADO DE NACIDO VIVO'), 1, 0, 'l');

        $pdf->Line(5, 51, 5, 60); #LINA VERTICAL IZQUIERDA
        $pdf->Line(205, 51, 205, 60); #LINEA VERTICAL DERECHA
        $pdf->Line(5, 51, 205, 51); #LINEA HORIZONTAL ARRIBA

#linea 1
        $pdf->Line(119, 51, 119, 60); #LINEA VERTICAL 1
        $pdf->Line(143, 51, 143, 60); #LINEA VERTICAL 2

        $pdf->SetXY(5,65);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(200, 4, utf8_decode('5. ¿POR QUÉ SE NOTIFICA EL CASO COMO IRA POR VIRUS NUEVO?'), 1, 0, 'C',1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetXY(5, 74);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('5.1 ¿Viajó a áreas de circulación del virus?'), 0, 0, 'l');

        $pdf->SetXY(25,78);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->Viajo_circulacion_virus === 'SI'?'X':'')), 1, 'C');
        $pdf->SetXY(30, 78);
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(30, 4, utf8_decode('1. Si'), 0, 0, 'l');

        $pdf->SetXY(25,82);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->Viajo_circulacion_virus === 'NO'?'X':'')), 1, 'C');
        $pdf->SetXY(30, 82);
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(30, 4, utf8_decode('2. No'), 0, 0, 'l');

        $pdf->SetXY(60, 70);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('5.1.1¿El viaje fue en el territorio nacional?'), 0, 0, 'l');

        $pdf->SetXY(70,74);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->viajo_territorio_nacional === 'SI'?'X':'')), 1, 'C');
        $pdf->SetXY(75, 74);
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(30, 4, utf8_decode('1. Si'), 0, 0, 'l');

        $pdf->SetXY(95,74);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->viajo_territorio_nacional === 'NO'?'X':'')), 1, 'C');
        $pdf->SetXY(100, 74);
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(30, 4, utf8_decode('2. No'), 0, 0, 'l');

        $pdf->SetXY(115, 70);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('5.1.1.1¿Dónde?'), 0, 0, 'l');

        $pdf->SetXY(116,74);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(55, 4, utf8_decode(self::$territorionacional->Nombre?self::$territorionacional->Nombre:''), 0, 'C');

        $pdf->SetXY(175,71);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(5, 4,substr(substr(self::$departamentonacionalterritorio->codigo_Dane?self::$departamentonacionalterritorio->codigo_Dane:'',0,5),0,1), 1, 'C');
        $pdf->SetXY(180,71);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(5, 4,substr(substr(self::$departamentonacionalterritorio->codigo_Dane?self::$departamentonacionalterritorio->codigo_Dane:'',0,5),1,1), 1, 'C');
        $pdf->SetXY(171, 75);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(40, 4, utf8_decode('Departamento'), 0, 0, 'l');

        $pdf->SetXY(188,71);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(5, 4,substr(substr(self::$territorionacional->codigo_Dane?self::$territorionacional->codigo_Dane:'',0,5),0,1), 1, 'C');
        $pdf->SetXY(193,71);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(5, 4,substr(substr(self::$territorionacional->codigo_Dane?self::$territorionacional->codigo_Dane:'',0,5),1,1), 1, 'C');
        $pdf->SetXY(198,71);
        $pdf->SetFont('Arial', '', 9);
        ////$pdf->MultiCell(5, 4,substr(substr(self::$territorionacional->codigo_Dane?self::$territorionacional->codigo_Dane:'',0,5),2,1), 1, 'C');
        $pdf->SetXY(190, 75);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(40, 4, utf8_decode('Municipio'), 0, 0, 'l');

        $pdf->SetXY(60, 79);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('5.1.2 ¿El viaje fue Internacional?'), 0, 0, 'l');

        $pdf->SetXY(70,83);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->viajo_internacional === 'SI'?'X':'')), 1, 'C');
        $pdf->SetXY(75, 83);
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(30, 4, utf8_decode('1. Si'), 0, 0, 'l');

        $pdf->SetXY(95,83);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->viajo_internacional === 'NO'?'X':'')), 1, 'C');
        $pdf->SetXY(100, 83);
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(30, 4, utf8_decode('2. No'), 0, 0, 'l');

        $pdf->SetXY(115, 79);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('5.1.2.1 ¿Dónde?'), 0, 0, 'l');

        $pdf->SetXY(116,83);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(55, 4, utf8_decode(self::$viajeinternacional->nombre?self::$viajeinternacional->nombre:''), 0, 'C');


        $pdf->SetXY(180,80);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(5, 4,substr(substr(self::$viajeinternacional->codigo?self::$viajeinternacional->codigo:'',0,5),0,1), 1, 'C');
        $pdf->SetXY(185,80);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(5, 4,substr(substr(self::$viajeinternacional->codigo?self::$viajeinternacional->codigo:'',0,5),1,1), 1, 'C');
        $pdf->SetXY(190,80);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(5, 4,substr(substr(self::$viajeinternacional->codigo?self::$viajeinternacional->codigo:'',0,5),2,1), 1, 'C');
        $pdf->SetXY(180, 84);
        $pdf->SetFont('Arial', '', 7);
        $pdf->Cell(40, 4, utf8_decode('Código País'), 0, 0, 'l');

        $pdf->SetXY(5, 88);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('5.2 ¿Tuvo contacto estrecho en los últimos 14 días con un caso probable o confirmado con infección respiratoria aguda grave por virus nuevo?'), 0, 0, 'l');

        $pdf->SetXY(178,89);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->tuvo_contacto_estrecho === 'SI'?'X':'')), 1, 'C');
        $pdf->SetXY(182, 89);
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(30, 4, utf8_decode('1. Si'), 0, 0, 'l');

        $pdf->SetXY(190,89);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->tuvo_contacto_estrecho === 'NO'?'X':'')), 1, 'C');
        $pdf->SetXY(194, 89);
        $pdf->SetFont('Arial', 'B', 6);
        $pdf->Cell(30, 4, utf8_decode('2. No'), 0, 0, 'l');

        $pdf->SetXY(5, 93);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('5.3 ¿Reporta alguno de los siguientes síntomas?'), 0, 0, 'l');

        $pdf->SetXY(7,98);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->tos === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(10, 98);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Tos'), 0, 0, 'l');

        $pdf->SetXY(22,98);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->fiebre === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(25, 98);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Fiebre'), 0, 0, 'l');

        $pdf->SetXY(39,98);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->dolor_garganta === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(42, 98);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Dolor de garganta (Odinofagia)'), 0, 0, 'l');

        $pdf->SetXY(88,98);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->dificultad_respiratoria === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(91, 98);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Dificultad respiratoria'), 0, 0, 'l');

        $pdf->SetXY(126,98);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->fatiga_adinamia === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(129, 98);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Fatiga o adinamia'), 0, 0, 'l');

        $pdf->SetXY(159,98);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->rinorrea === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(162, 98);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Rinorrea'), 0, 0, 'l');

        $pdf->SetXY(182,98);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->conjuntivitis === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(185, 98);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Conjuntivitis'), 0, 0, 'l');

        $pdf->SetXY(7,103);
        $pdf->SetFont('Arial', 'B', 4.2);
        ////$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->cefalea === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(10, 103);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Cefalea'), 0, 0, 'l');

        $pdf->SetXY(37,103);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->diarrea === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(40, 103);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Diarrea'), 0, 0, 'l');

        $pdf->SetXY(62,103);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->perdida_de_olfato === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(65, 103);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Pérdida de olfato y/o gusto'), 0, 0, 'l');

        $pdf->SetXY(107,103);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->otros_sintomas === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(110, 103);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Otros'), 0, 0, 'l');

        $pdf->SetXY(126, 102);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('5.3.1 ¿Cuáles otros?'), 0, 0, 'l');
        $pdf->SetXY(126,105);
        $pdf->SetFont('Arial', '', 8);
        //$pdf->MultiCell(75, 4, utf8_decode((self::$registroCovid->cuales_otros ?self::$registroCovid->cuales_otros: '')), 0, 'L');


        $pdf->Line(5, 70, 5, 110); #LINA VERTICAL IZQUIERDA
        $pdf->Line(205, 70, 205, 110); #LINEA VERTICAL DERECHA
        $pdf->Line(5, 70, 205, 70); #LINEA HORIZONTAL ARRIBA
        $pdf->Line(5, 110, 205, 110); #LINEA HORIZONTAL ABAJO

#linea 1
        $pdf->Line(58, 70, 58, 88); #LINEA VERTICAL 1
        $pdf->Line(58, 79, 205, 79); #LINEA HORIZONTAL 1
        $pdf->Line(5, 88, 205, 88); #LINEA HORIZONTAL 2

#linea 2
        $pdf->Line(5, 93, 205, 93); #LINEA HORIZONTAL 1

        $pdf->SetXY(5,111);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(200, 4, utf8_decode('6. ANTECEDENTES CLÍNICOS'), 1, 0, 'C',1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetXY(5, 116);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('6.1 ¿Reporta alguno de los siguientes antecedentes clínicos?'), 0, 0, 'l');

        $pdf->SetXY(7,121);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->asma === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(10, 121);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Asma'), 0, 0, 'l');

        $pdf->SetXY(21,121);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->epoc === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(24, 121);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('EPOC'), 0, 0, 'l');

        $pdf->SetXY(35,121);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->diabetes === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(38, 121);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Diabetes'), 0, 0, 'l');

        $pdf->SetXY(55,121);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->vih === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(58, 121);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('VIH'), 0, 0, 'l');

        $pdf->SetXY(70,121);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->enfermedad_cardiaca === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(73, 121);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Enfermedad cardiaca'), 0, 0, 'l');

        $pdf->SetXY(107,121);
        $pdf->SetFont('Arial', 'B', 4.2);
       //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->cancer === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(110, 121);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Cancer'), 0, 0, 'l');

        $pdf->SetXY(127,121);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->malnutricion === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(130, 121);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Malnutrición'), 0, 0, 'l');

        $pdf->SetXY(153,121);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->obesidad === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(156, 121);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Obesidad'), 0, 0, 'l');

        $pdf->SetXY(175,121);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->insuficiencia_renal === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(178, 121);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Insuficiencia renal'), 0, 0, 'l');

        $pdf->SetXY(7,125);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->medicamentos_inmunosupresores === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(10, 125);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Toma medicamentos inmunosupresores'), 0, 0, 'l');

        $pdf->SetXY(66,125);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->fumador === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(69, 125);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Fumador'), 0, 0, 'l');

        $pdf->SetXY(86,125);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->hipertensión === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(89, 125);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Hipertensión'), 0, 0, 'l');

        $pdf->SetXY(113,125);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->tuberculosis === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(116, 125);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Tuberculosis'), 0, 0, 'l');

        $pdf->SetXY(139,125);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->otros === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(142, 125);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('Otros'), 0, 0, 'l');

        $pdf->SetXY(153, 124);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('5.3.1 ¿Cuáles otros?'), 0, 0, 'l');
        $pdf->SetXY(155,127);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(47, 4, utf8_decode((self::$registroCovid->otros_antecedentes ? self::$registroCovid->otros_antecedentes:'')), 0, 'L');

        $pdf->Line(5, 116, 5, 131); #LINA VERTICAL IZQUIERDA
        $pdf->Line(205, 116, 205, 131); #LINEA VERTICAL DERECHA
        $pdf->Line(5, 116, 205, 116); #LINEA HORIZONTAL ARRIBA
        $pdf->Line(5, 131, 205, 131); #LINEA HORIZONTAL ABAJO

        $pdf->SetXY(5,132);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(200, 4, utf8_decode('7. DIAGNÓSTICO Y TRATAMIENTO'), 1, 0, 'C',1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0,0,0);

        $pdf->SetXY(5, 137);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->MultiCell(54, 4, utf8_decode('7.1 Si se tomó de radiografía de tórax     ¿Qué hallazgos se presentaron?'), 0, 'L');

        $pdf->SetXY(60,138);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->infiltrado_alveolar_neumonia === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(63, 138);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('1. Infiltrado alveolar o neumonía'), 0, 0, 'l');

        $pdf->SetXY(110,138);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->infiltrados_intesticiales === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(113, 138);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('2. Infiltrados intersticiales'), 0, 0, 'l');

        $pdf->SetXY(150,138);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->infiltrados_basales_vidrio_esmerilado === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(153, 138);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('4. Infiltrados basales en vidrio esmerilado'), 0, 0, 'l');

        $pdf->SetXY(60,142);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->ninguno === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(63, 142);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('3. Ninguno'), 0, 0, 'l');

        $pdf->SetXY(5, 146);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->MultiCell(54, 4, utf8_decode('7.2 Servicio en el que se hospitalizó'), 0, 'L');

        $pdf->SetXY(60,147);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->servicio_hospitalizo === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(63, 147);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('1. Hospitalización general'), 0, 0, 'l');

        $pdf->SetXY(110,147);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->uci === 'SI'?'X':'')), 1, 'C');
        $pdf->SetXY(113, 147);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('3. UCI'), 0, 0, 'l');

        $pdf->SetXY(143, 146);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('7.2.1 Fecha de ingreso a UCI (dd/mm/aaaa)'), 0, 0, 'l');

        $pdf->SetXY(143,150);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(5, 4, substr(self::$registroCovid->fecha_ingreso_uci?self::$registroCovid->fecha_ingreso_uci:'',-2,1), 1, 'l');
        $pdf->SetXY(148,150);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(5, 4, substr(self::$registroCovid->fecha_ingreso_uci?self::$registroCovid->fecha_ingreso_uci:'',-1,1), 1, 'l');
        $pdf->SetXY(153, 149);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(5, 6, utf8_decode('-'), 0, 0, 'C');
        $pdf->SetXY(158,150);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(5, 4, substr(self::$registroCovid->fecha_ingreso_uci?self::$registroCovid->fecha_ingreso_uci:'',-5,1), 1, 'l');
        $pdf->SetXY(163,150);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(5, 4, substr(self::$registroCovid->fecha_ingreso_uci?self::$registroCovid->fecha_ingreso_uci:'',-4,1), 1, 'l');
        $pdf->SetXY(168, 149);
        $pdf->SetFont('Arial', '', 14);
        $pdf->Cell(5, 6, utf8_decode('-'), 0, 0, 'C');
        $pdf->SetXY(173,150);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(5, 4, substr(self::$registroCovid->fecha_ingreso_uci?self::$registroCovid->fecha_ingreso_uci:'',-10,1), 1, 'l');
        $pdf->SetXY(178,150);
        $pdf->SetFont('Arial', '', 7);
        //$pdf->MultiCell(5, 4, substr(self::$registroCovid->fecha_ingreso_uci?self::$registroCovid->fecha_ingreso_uci:'',-9,1), 1, 'l');
        $pdf->SetXY(183,150);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(5, 4, substr(self::$registroCovid->fecha_ingreso_uci?self::$registroCovid->fecha_ingreso_uci:'',-8,1), 1, 'l');
        $pdf->SetXY(188,150);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(5, 4, substr(self::$registroCovid->fecha_ingreso_uci?self::$registroCovid->fecha_ingreso_uci:'',-7,1), 1, 'l');


        $pdf->SetXY(5, 155);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('7.3 Si hubo complicaciones, ¿Cuáles se presentaron?'), 0, 0, 'l');

        $pdf->SetXY(7,159);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->derrame_pleural === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(12, 159);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('1. Derrame pleural'), 0, 0, 'l');

        $pdf->SetXY(7,163);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->derrame_pericardico === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(12, 163);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('2. Derrame pericárdico'), 0, 0, 'l');

        $pdf->SetXY(7,167);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->miocarditis === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(12, 167);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('3. Miocarditis'), 0, 0, 'l');

        $pdf->SetXY(50,159);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->septicemia === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(53, 159);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('4. Septicemia'), 0, 0, 'l');

        $pdf->SetXY(50,163);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->falla_respiratoria === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(53, 163);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('5. Falla respiratoria'), 0, 0, 'l');

        $pdf->SetXY(50,167);
        $pdf->SetFont('Arial', 'B', 4.2);
        //$pdf->MultiCell(3, 3, utf8_decode((self::$registroCovid->otro === 'x'?'X':'')), 1, 'C');
        $pdf->SetXY(53, 167);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('6. Otro'), 0, 0, 'l');

        $pdf->SetXY(110, 155);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(30, 4, utf8_decode('7.3.1 Otros cuáles?'), 0, 0, 'l');
        $pdf->SetXY(110,159);
        $pdf->SetFont('Arial', '', 9);
        //$pdf->MultiCell(90, 4, utf8_decode((self::$registroCovid->otra_complicacion ? self::$registroCovid->otra_complicacion:'')), 0, 'C');

        $pdf->Line(5, 137, 5, 171); #LINA VERTICAL IZQUIERDA
        $pdf->Line(205, 137, 205, 171); #LINEA VERTICAL DERECHA
        $pdf->Line(5, 137, 205, 137); #LINEA HORIZONTAL ARRIBA
        $pdf->Line(5, 131, 205, 131); #LINEA HORIZONTAL ABAJO

#LINEA 1
        $pdf->Line(5, 146, 205, 146); #LINEA HORIZONTAL ABAJO
#LINEA 2
        $pdf->Line(5, 155, 205, 155); #LINEA HORIZONTAL ABAJO
#LINEA 3
            //$consentimiento='1';

            $pdf->Line(5, 171, 205, 171); #LINEA HORIZONTAL ABAJO
            $pdf->SetXY(5,172);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(200, 4, utf8_decode('8. ANTECEDENTES VACUNALES'), 1, 0, 'C',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);

            $pdf->SetXY(5, 177);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('8.2 Vacuna'), 0, 0, 'l');

            $pdf->SetXY(5, 181);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('COVID-19'), 0, 0, 'l');

            $pdf->SetXY(20,181);
            $pdf->SetFont('Arial', 'B', 4.2);
            $pdf->MultiCell(3, 3, utf8_decode(''), 1, 'C');
            $pdf->SetXY(23, 181);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('1. SI'), 0, 0, 'l');

            $pdf->SetXY(30,181);
            $pdf->SetFont('Arial', 'B', 4.2);
            $pdf->MultiCell(3, 3, utf8_decode(''), 1, 'C');
            $pdf->SetXY(33, 181);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('2. NO'), 0, 0, 'l');

            $pdf->SetXY(42,181);
            $pdf->SetFont('Arial', 'B', 4.2);
            $pdf->MultiCell(3, 3, utf8_decode(''), 1, 'C');
            $pdf->SetXY(45, 181);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('3. DESCONOCIDO'), 0, 0, 'l');

            $pdf->SetXY(70, 177);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('8.2.1 Dosis'), 0, 0, 'l');

            $pdf->SetXY(75,181);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');

            $pdf->SetXY(91, 177);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('8.2.2 Fecha Última dosis (dd/mm/aaaa)'), 0, 0, 'l');

            $pdf->SetXY(90,181);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');
            $pdf->SetXY(95,181);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');
            $pdf->SetXY(100, 180);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('-'), 0, 0, 'C');
            $pdf->SetXY(105,181);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');
            $pdf->SetXY(110,181);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');
            $pdf->SetXY(115, 180);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('-'), 0, 0, 'C');
            $pdf->SetXY(120,181);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');
            $pdf->SetXY(125,181);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');
            $pdf->SetXY(130,181);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');
            $pdf->SetXY(135,181);
            $pdf->SetFont('Arial', '', 9);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'l');

            $pdf->SetXY(145, 177);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('8.2.3 Nombre de la vacuna'), 0, 0, 'l');
            $pdf->SetXY(145,181);
            $pdf->SetFont('Arial', '', 9);
            //$pdf->MultiCell(55, 4, utf8_decode(self::$registroCovid->tipo_vacuna), 0, 'L');

            $pdf->Line(5, 177, 5, 186); #LINA VERTICAL IZQUIERDA
            $pdf->Line(205, 177, 205, 186); #LINEA VERTICAL DERECHA
            $pdf->Line(5, 177, 205, 177); #LINEA HORIZONTAL ARRIBA
            $pdf->Line(5, 186, 205, 186); #LINEA HORIZONTAL ABAJO

            $pdf->SetXY(5,187);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(200, 4, utf8_decode('9. DATOS DE LABORATORIO'), 1, 0, 'C',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);

            $pdf->SetXY(33,191);
            $pdf->SetFont('Arial', 'U'.'B', 8);
            $pdf->Cell(144, 4, utf8_decode('La información relacionada con laboratorios debe ingresarse a través del módulo de laboratorios del aplicativo sivigila'), '0', 0, 'C');

            $pdf->SetXY(16,197);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(180, 4, utf8_decode('Tome 3 a 5 C.C. de sangre en tubo seco y una muestra para identificación viral (hisopado nasofaringeo, aspirado nasofaríngeo, aspirado bronquial)'), 1, 0, 'C',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);

            $pdf->SetXY(7, 201);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('9.1 Fecha de toma (dd/mm/aaaa)'), 0, 0, 'l');

            $pdf->SetXY(7,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(12,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(16, 204);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('-'), 0, 0, 'C');
            $pdf->SetXY(20,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(25,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(29, 204);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('-'), 0, 0, 'C');
            $pdf->SetXY(33,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(38,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(43,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(48,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');

            $pdf->SetXY(55, 201);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('Fecha de recepción (dd/mm/aaaa)'), 0, 0, 'l');

            $pdf->SetXY(55,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(60,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(64, 204);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('-'), 0, 0, 'C');
            $pdf->SetXY(68,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(73,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(77, 204);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('-'), 0, 0, 'C');
            $pdf->SetXY(81,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(86,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(91,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(96,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');

            $pdf->SetXY(102, 201);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('Muestra'), 0, 0, 'l');

            $pdf->SetXY(105,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');

            $pdf->SetXY(114, 201);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('Prueba'), 0, 0, 'l');

            $pdf->SetXY(116,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');

            $pdf->SetXY(124, 201);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('Agente'), 0, 0, 'l');

            $pdf->SetXY(127,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');

            $pdf->SetXY(134, 201);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('Resultado'), 0, 0, 'l');

            $pdf->SetXY(138,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');

            $pdf->SetXY(148, 201);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('Fecha de recepción (dd/mm/aaaa)'), 0, 0, 'l');

            $pdf->SetXY(148,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(153,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(157, 204);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('-'), 0, 0, 'C');
            $pdf->SetXY(161,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(166,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(170, 204);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('-'), 0, 0, 'C');
            $pdf->SetXY(174,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(179,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(184,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(189,205);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');

            $pdf->SetXY(7, 210);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('9.2 Fecha de toma (dd/mm/aaaa)'), 0, 0, 'l');

            $pdf->SetXY(7,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(12,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(16, 213);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('-'), 0, 0, 'C');
            $pdf->SetXY(20,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(25,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(29, 213);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('-'), 0, 0, 'C');
            $pdf->SetXY(33,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(38,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(43,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(48,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');

            $pdf->SetXY(55, 210);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('Fecha de recepción (dd/mm/aaaa)'), 0, 0, 'l');

            $pdf->SetXY(55,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(60,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(64, 213);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('-'), 0, 0, 'C');
            $pdf->SetXY(68,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(73,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(77, 213);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('-'), 0, 0, 'C');
            $pdf->SetXY(81,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(86,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(91,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(96,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');

            $pdf->SetXY(102, 210);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('Muestra'), 0, 0, 'l');

            $pdf->SetXY(105,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');

            $pdf->SetXY(114, 210);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('Prueba'), 0, 0, 'l');

            $pdf->SetXY(116,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');

            $pdf->SetXY(124, 210);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('Agente'), 0, 0, 'l');

            $pdf->SetXY(127,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');

            $pdf->SetXY(134, 210);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('Resultado'), 0, 0, 'l');

            $pdf->SetXY(138,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');


            $pdf->SetXY(148, 210);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(30, 4, utf8_decode('Fecha de recepción (dd/mm/aaaa)'), 0, 0, 'l');

            $pdf->SetXY(148,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(153,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(157, 213);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('-'), 0, 0, 'C');
            $pdf->SetXY(161,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(166,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(170, 213);
            $pdf->SetFont('Arial', '', 14);
            $pdf->Cell(5, 6, utf8_decode('-'), 0, 0, 'C');
            $pdf->SetXY(174,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(179,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(184,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');
            $pdf->SetXY(189,214);
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(5, 4, utf8_decode(''), 1, 'C');

            $pdf->SetXY(5,220);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(25, 38, utf8_decode('Marque así'), 0, 0, 'C',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);

            $pdf->SetXY(30, 221);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(13, 4, utf8_decode('Muestra'), 0, 0, 'l');
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(162, 4, utf8_decode('1. Sangre total | 3. Hisopado nasofaríngeo | 4. Tejido | 8. Aspirado nasofaríngeo | 11. Otros líquidos esteriles | 22. Lavado bronquial'), 0,  'l');

            $pdf->SetXY(30, 226);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(13, 4, utf8_decode('Prueba'), 0, 0, 'l');
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(162, 4, utf8_decode('2. IgM | 3. IgG | 4. PCR | 30. Patología | 31. Inmunohistoquímica | 46. Inhibición hemaglutinación | 55. Cultivo | 76. IFI | 92. Hemocultivo | E1. Aislamiento viral | F3. Determinación de antígeno | H9. IgG - IgM'), 0,  'l');

            $pdf->SetXY(30, 235);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(13, 4, utf8_decode('Agente'), 0, 0, 'l');
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(162, 4, utf8_decode('8. Otro | 16. Adenovirus |18. Virus sincitial respiratorio | 22. Haemophilus influenzae | 24. Streptococcus pneumoniae | 40. Influenza A | 41. Influenza | 42. Parainfluenza 1 | 43. Parainfluenza 2 | 44. Parainfluenza 3 | 56. Enterovirus| 59. Influenza A(H1N1) pdm09 | 64. Influenza A no subtipificable | 76. Bocavirus | 77. Coronavirus | 78. Metaneumovirus | 79. Rinovirus | 84. Virus respiratorios |1Q. Coronavirus causante del síndrome respiratorio de Oriente Medio (MERS-CoV) | 1R. Coronavirus subtipo 229e| 1S. Coronavirus subtipo HKU1 | 1T. Coronavirus subtipo NL63 | 1U. Coronavirus subtipo OC43 | 1V. Influenza A(H3N2) | 1W. Parainfluenza tipo 4 | 2H. Coronavirus subtipo COVID19 '), 0,  'l');

            $pdf->SetXY(30, 255);
            $pdf->SetFont('Arial', 'B', 7);
            $pdf->Cell(13, 4, utf8_decode('Resultado'), 0, 0, 'l');
            $pdf->SetFont('Arial', '', 7);
            $pdf->MultiCell(162, 4, utf8_decode('1. Positivo | 2. Negativo | 3. No procesado | 4. Inadecuado | 6. Valor registrado | 12. Contaminado con hongos | 13. Muestra escasa de células |'), 0,  'l');

        #MARGENES
            $pdf->Line(5, 195, 5, 259); #LINEA VERTICAL IZQUIERDA
            $pdf->Line(205, 195, 205, 259); #LINEA VERTICAL DERECHA
            $pdf->Line(5, 210, 205, 210); #LIENA HORIZONTAL ABAJO
            $pdf->Line(5, 195, 205, 195); #lINEA HORIZONTAL ARRIBA
            $pdf->Line(5, 219, 205, 219); #LIENA HORIZONTAL ABAJO

            $pdf->Line(30, 225, 205, 225); #LIENA HORIZONTAL ABAJO
            $pdf->Line(30, 235, 205, 235); #LIENA HORIZONTAL ABAJO
            $pdf->Line(30, 255, 205, 255); #LIENA HORIZONTAL ABAJO
            $pdf->Line(5, 259, 205, 259); #LIENA HORIZONTAL ABAJO
        // }

        // elseif (self::$data["tipo"] === 'historia')
            $Y = 40;
            $pdf->SetFont('Arial', 'B', 9);
            $logo = "/images/logoEcoimagen.png";
            $pdf->Image($logo, 155, 8, -220);
            $pdf->SetFont('Arial', '', 7);
            $pdf->SetXY(8, 37);
            $pdf->Cell(60, 3, utf8_decode('SUMIMEDICAL S.A.S'), 0, 0, 'C');
            $pdf->SetXY(8, $Y);
            $pdf->Cell(60, 3, utf8_decode('NIT: 900033371 Res: 004 '), 0, 0, 'C');
            $pdf->SetXY(8, $Y + 3);
            $pdf->Cell(60, 3, utf8_decode('Carrera 80 c Nùmero 32EE-65'), 0, 0, 'C');
            $pdf->SetXY(8, $Y + 6);
            $pdf->Cell(60, 3, utf8_decode('Telefono: 5201040'), 0, 0, 'C');
            $pdf->SetXY(5, 55);
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->Cell(200, 4, utf8_decode('HISTORIA CLINICA'), 0, 0, 'C');


            $pdf->SetXY(7,15);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(140, 20, utf8_decode(''), 0, 1, 'l',1);
            $pdf->SetDrawColor(1, 22, 137);
            $pdf->Line(8, 35, 140, 35); #LIENA HORIZONTAL ABAJO
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFont('Arial', '', 12);
            $pdf->SetXY(8,15);
            $pdf->Cell(60, 5, utf8_decode('SUMIMEDICAL S.A.S / NIT: 900033371 Res: 004 '), 0, 0, 'l');
            $pdf->ln();
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetX(8);
            $pdf->Cell(60, 5, utf8_decode('Orientacion Médico Coronavirus'), 0, 0, 'l');
            $pdf->ln();
            $pdf->SetFont('Arial', '', 12);
            $pdf->SetX(8);
            $pdf->cell(40,5,utf8_decode('Fecha de Atencion:'), 0, 0, 'l');
            //$pdf->Cell(60, 5, self::$registroCovid->created_at, 0, 0, 'l');
            $pdf->ln();
            $pdf->SetX(8);
            //$pdf->Cell(60, 5, self::$paciente->Ut, 0, 0, 'l');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(195, 6, utf8_decode('Información Básica del Paciente y la Atención'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->SetX(10);
            $pdf->SetFont('Times', 'B', 12);
            //$pdf->Cell(80, 7, self::$paciente->Primer_Nom.(self::$paciente->SegundoNom?' '.self::$paciente->SegundoNom:'').' '.self::$paciente->Primer_Ape.' '.self::$paciente->Segundo_Ape, 0, 'l');
            $pdf->SetX(105);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Identificación'), 0, 0, 'l');
            $pdf->SetX(130);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Fecha de nacimiento'), 0, 0, 'l');
            $pdf->SetX(165);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Edad'), 0, 0, 'l');
            $pdf->SetX(185);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Sexo'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(105);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$paciente->Tipo_Doc.' '.self::$paciente->Num_Doc, 0, 'l');
            $pdf->SetX(130);
            $pdf->SetFont('Arial', 'B', 8);
           // $pdf->Cell(25, 4, self::$paciente->Fecha_Naci, 0, 'l');
            $pdf->SetX(165);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$paciente->Edad_Cumplida.' '.utf8_decode('Años'), 0, 'l');
            $pdf->SetX(185);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$paciente->Sexo=== 'M'?'Masculino':'Femenino' , 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Tipo de Afiliado'), 0, 0, 'l');
            $pdf->SetX(35);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Departamento'), 0, 0, 'l');
            $pdf->SetX(65);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Municipio'), 0, 0, 'l');
            $pdf->SetX(90);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Estado Civil'), 0, 0, 'l');
            $pdf->SetX(115);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Teléfono fijo'), 0, 0, 'l');
            $pdf->SetX(140);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Otro Teléfono'), 0, 0, 'l');
            $pdf->SetX(165);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Correo electrónico'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$paciente->Tipo_Afiliado , 0, 'l');
            $pdf->SetX(35);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$departamento->Nombre , 0, 'l');
            $pdf->SetX(65);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$municipio->Nombre , 0, 'l');
            $pdf->SetX(90);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$paciente->estado_civil, 0, 'l');
            $pdf->SetX(115);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$registroCovid->telefono , 0, 'l');
            $pdf->SetX(140);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$paciente->Celular1 , 0, 'l');
            $pdf->SetX(165);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$paciente->Correo1 , 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Dirección'), 0, 0, 'l');
            $pdf->SetX(95);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Ocupacion'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$registroCovid->direccion_residencia , 0, 'l');
            $pdf->SetX(95);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$ocupacionpaciente->ocupacion , 0, 'l');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->Cell(195, 6, utf8_decode('Antecedentes Patologicos'), 0, 0, 'l');
            $pdf->SetLineWidth(0.5);
            $pdf->Line(8, 86, 203, 86);
            $pdf->SetLineWidth(0.2);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(65, 5, utf8_decode('Patología'), 0, 0, 'l',1);
            $pdf->Cell(25, 5, utf8_decode('Presenta'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetX(110);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(65, 5, utf8_decode('Patología'), 0, 0, 'l',1);
            $pdf->Cell(25, 5, utf8_decode('Presenta'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Asma'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->asma === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetX(110);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Epoc'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->epoc === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Diabetes'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->diabetes === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->SetX(110);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('VIH'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->vih === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Tuberculosis'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->tuberculosis === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetX(110);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Enfermedad Cardiaca'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->enfermedad_cardiaca === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Cancer'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->cancer === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->SetX(110);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Malnutricion'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->malnutricion === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Obesidad'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->obesidad === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetX(110);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Insuficiencia Renal'), 0, 0, 'l',1);
           // $pdf->Cell(25, 5, self::$registroCovid->insuficiencia_renal === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Medicamentos Inmunosupresores'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->medicamentos_inmunosupresores === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->SetX(110);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Fumador'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->fumador === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Hipertensión'), 0, 0, 'l',1);
           // $pdf->Cell(25, 5, self::$registroCovid->hipertensión === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetX(110);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Otros'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->otro === 'x'?self::$registroCovid->cuales_otros:'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->Cell(195, 6, utf8_decode('Antecedentes Aelergicos'), 0, 0, 'l');
            $pdf->SetLineWidth(0.5);
            $pdf->Line(8, 143, 203, 143);
            $pdf->SetLineWidth(0.2);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(130, 5, utf8_decode('Patología'), 0, 0, 'l',1);
            $pdf->Cell(65, 5, utf8_decode('Fecha De Registro'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $posicionActual = $pdf->GetY();

            // if(self::$anteAlergicos){
            //     foreach(self::$anteAlergicos as $anteAlergico){
            //         $pdf->SetX(8,$posicionActual);
            //         $pdf->SetFont('Arial', '', 9);
            //         $pdf->Cell(130, 5, utf8_decode(($anteAlergico->Descripcion)), 0, 'l');
            //         $pdf->Cell(65, 5, utf8_decode(($anteAlergico->created_at)), 0, 'l');
            //         $posicionActual = $pdf->GetY();
            //         $pdf->Ln();
            //     }
            // }else{
            //     $pdf->SetX(8);
            //     $pdf->SetFont('Arial', '', 9);
            //     $pdf->Cell(195, 4, utf8_decode('N/A'), 1, 'l');
            //     $posicionActual = $pdf->GetY();
            //     $pdf->Ln();
            // }

            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->Cell(195, 6, utf8_decode('Antecedentes Familiares'), 0, 0, 'l');
            $pdf->SetLineWidth(0.5);
            //$pdf->Line(8, $posicionActual+17, 203, $posicionActual+17);
            $pdf->SetLineWidth(0.2);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(50, 5, utf8_decode('Patología'), 0, 0, 'l',1);
            $pdf->Cell(70, 5, utf8_decode('Nota'), 0, 0, 'l',1);
            $pdf->Cell(40, 5, utf8_decode('Parentesco'), 0, 0, 'l',1);
            $pdf->Cell(35, 5, utf8_decode('Fecha de Registro'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $posicionActual = $pdf->GetY();
            // if(self::$antFamiliares){
            //     foreach(self::$antFamiliares as $antFamiliare){
            //         $pdf->SetX(8,$posicionActual);
            //         $pdf->SetFont('Arial', '', 9);
            //         $pdf->Cell(50, 5, utf8_decode(($antFamiliare->Nombre)), 0, 'l');
            //         $pdf->Cell(70, 5, utf8_decode(($antFamiliare->Descripcion)), 0, 'l');
            //         $pdf->Cell(35, 5, utf8_decode(($antFamiliare->parentesco)), 0, 'l');
            //         $pdf->Cell(35, 5, utf8_decode(($antFamiliare->fechaRegistro)), 0, 'l');
            //         $posicionActual = $pdf->GetY();
            //         $pdf->Ln();
            //     }
            // }else{
            //     $pdf->SetX(8);
            //     $pdf->SetFont('Arial', '', 9);
            //     $pdf->Cell(195, 4, utf8_decode('N/A'), 1, 'l');
            //     $posicionActual = $pdf->GetY();
            //     $pdf->Ln();
            // }
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->Cell(195, 6, utf8_decode('Estilos de Vida'), 0, 0, 'l');
            $pdf->SetLineWidth(0.5);
            $pdf->Line(8, $posicionActual+17, 203, $posicionActual+17);
            $pdf->SetLineWidth(0.2);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',10);
            $pdf->Cell(195, 6, utf8_decode('Hábitos(Cigarrillo)'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetFont('Arial', '',9);
            $pdf->SetX(8);
            $pdf->Cell(25, 5, utf8_decode('¿Es fumador?:'), 0, 0, 'l');
            $pdf->SetX(30);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(25, 5, self::$estilosVida == 'null'?self::$estilosVida->Fumacantidad:"No Refiere", 0, 0, 'l');
            $pdf->SetX(80);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(25, 5, utf8_decode('¿Es fumador Pasivo?:'), 0, 0, 'l');
            $pdf->SetX(115);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(25, 5, self::$estilosVida == 'null'?self::$estilosVida->Fumadorpasivo:"No Refiere", 0, 0, 'l');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',10);
            $pdf->Cell(195, 6, utf8_decode('Consumo de Alcohol'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetFont('Arial', '',9);
            $pdf->SetX(8);
            $pdf->Cell(25, 5, utf8_decode('¿Frecuencia consumo de licor?:'), 0, 0, 'l');
            $pdf->SetX(55);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(25, 5, self::$estilosVida =='null'?self::$estilosVida->Licorfrecuencia:"No Refiere", 0, 0, 'l');
            $pdf->SetX(100);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(25, 5, utf8_decode('¿Toma licor actualmente?:'), 0, 0, 'l');
            $pdf->SetX(140);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(25, 5, self::$estilosVida == 'null'?self::$estilosVida->Cantidadlicor:"No Refiere", 0, 0, 'l');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',10);
            $pdf->Cell(195, 6, utf8_decode('Sustancias psicoactivas'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetFont('Arial', '',9);
            $pdf->SetX(8);
            $pdf->Cell(25, 5, utf8_decode('¿Consume sustancias psicoactivas?:'), 0, 0, 'l');
            $pdf->SetX(65);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(25, 5, self::$estilosVida =='null'?self::$estilosVida->Consumopsicoactivo:"No Refiere", 0, 0, 'l');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',10);
            $pdf->Cell(195, 6, utf8_decode('Hábitos (Actividad física)'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetFont('Arial', '',9);
            $pdf->SetX(8);
            $pdf->Cell(25, 5, utf8_decode('¿Realiza actividad física?:'), 0, 0, 'l');
            $pdf->SetX(65);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(25, 5, utf8_decode(self::$estilosVida == 'null'?self::$estilosVida->Actividadfisica:"No Refiere"), 0, 0, 'l');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',10);
            $pdf->Cell(195, 6, utf8_decode('Observaciones:'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',8);
            //$pdf->MultiCell(195, 5, utf8_decode(self::$estilosVida == 'null'?self::$estilosVida->Estilovidaobservaciones:"No Refiere"),0, 'J');
            $posicionActual = $pdf->GetY();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->Cell(195, 6, utf8_decode('Examen Fisico'), 0, 0, 'l');
            $pdf->SetLineWidth(0.5);
            $pdf->Line(8, $posicionActual+12, 203, $posicionActual+12);
            $pdf->SetLineWidth(0.2);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('Arial', '',9);
            $pdf->SetX(8);
            $pdf->Cell(25, 5, utf8_decode('Medidas Antropometricas:'), 0, 0, 'l');
            $pdf->SetX(50);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(25, 5, utf8_decode(self::$estilosVida == 'null'?'Talla'.' '.self::$estilosVida->Talla.' '.'cm':"No Refiere"), 0, 0, 'l');
            $posicionActual = $pdf->GetY();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->Cell(195, 6, utf8_decode('Análisis y plan'), 0, 0, 'l');
            $pdf->SetLineWidth(0.5);
            $pdf->Line(8, $posicionActual+17, 203, $posicionActual+17);
            $pdf->SetLineWidth(0.2);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetFont('Arial', '',10);
            $pdf->SetX(8);
            $pdf->Cell(25, 5, utf8_decode('Información gestión covid'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetFont('Arial', '',9);
            $pdf->SetX(8);
            $pdf->Cell(25, 5, utf8_decode('Fecha de inicio de gestión'), 0, 0, 'l');
            $pdf->SetX(50);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(25, 5, utf8_decode(self::$registroCovid->fecha_consulta), 0, 0, 'l');
            $pdf->SetX(90);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(25, 5, utf8_decode('Estado:'), 0, 0, 'l');
            $pdf->SetX(105);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, utf8_decode(self::$registroCovid->estado_id == 1?'En Seguimiento':'Finalizado'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',10);
            $pdf->Cell(195, 6, utf8_decode('Validación COVID-19'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 6, utf8_decode('¿Aplica cuestionario COVID-19?'), 0, 0, 'l');
            $pdf->SetX(60);
            $pdf->SetFont('Arial', 'B',9);
            $pdf->Cell(20, 5, utf8_decode('SI'), 0, 0, 'l');
            $pdf->Ln();
            $posicionActual = $pdf->GetY();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->Cell(195, 6, utf8_decode('Síntomas'), 0, 0, 'l');
            $pdf->SetLineWidth(0.5);
            $pdf->Line(8, $posicionActual+13, 203, $posicionActual+13);
            $pdf->SetLineWidth(0.2);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 5, utf8_decode('Fecha de Inicio Sintomas:'), 0, 0, 'l');
            $pdf->SetX(48);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, self::$registroCovid->fecha_inicio_sintomas, 0, 0, 'l');
            $pdf->SetX(80);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 5, utf8_decode('Clasificacion:'), 0, 0, 'l');
            $pdf->SetX(102);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, self::$registroCovid->clasificacion, 0, 0, 'l');
            $pdf->SetX(130);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 5, utf8_decode('Fuente:'), 0, 0, 'l');
            $pdf->SetX(145);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, self::$registroCovid->fuente, 0, 0, 'l');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B', 10);

            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(65, 5, utf8_decode('Sintomatologia'), 0, 0, 'l',1);
            $pdf->Cell(25, 5, utf8_decode('¿Tiene?'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetX(110);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(65, 5, utf8_decode('Sintomatologia'), 0, 0, 'l',1);
            $pdf->Cell(25, 5, utf8_decode('¿Tiene?'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Tos'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->tos === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetX(110);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Fiebre'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->fiebre === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Dolor de Garganta'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->dolor_garganta === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->SetX(110);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Dificultad Respiratoria'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->dificultad_respiratoria === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Fatiga Adinamia'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->fatiga_adinamia === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetX(110);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Rinorrea'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->rinorrea === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Conjuntivitis'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->conjuntivitis === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->SetX(110);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Cefalea'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->cefalea === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Diarrea'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->diarrea === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetX(110);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Perdida de Olfato'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->perdida_de_olfato === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 6, utf8_decode('Otros Sintomas'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, self::$registroCovid->otros_sintomas === 'x'?self::$registroCovid->cuales_otros:'NO', 0, 0, 'l');
            $posicionActual = $pdf->GetY();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->Cell(195, 6, utf8_decode('Otra Informacion de Interes'), 0, 0, 'l');
            $pdf->SetLineWidth(0.5);
            $pdf->Line(8, $posicionActual+18, 203, $posicionActual+18);
            $pdf->SetLineWidth(0.2);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 5, utf8_decode('¿Hospitalizado?:'), 0, 0, 'l');
            $pdf->SetX(45);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, self::$registroCovid->hospitalizado, 0, 0, 'l');
            $pdf->SetX(110);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 5, utf8_decode('Codicion Final:'), 0, 0, 'l');
            $pdf->SetX(140);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, self::$registroCovid->condicion_final, 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 5, utf8_decode('Fecha de Defuncion:'), 0, 0, 'l');
            $pdf->SetX(45);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, utf8_decode(self::$registroCovid->condicion_final === 'Vivo'?"No Aplica":self::$registroCovid->fecha_defuncion), 0, 0, 'l');
            $pdf->SetX(110);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 5, utf8_decode('Certificado de Defuncion:'), 0, 0, 'l');
            $pdf->SetX(150);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, utf8_decode(self::$registroCovid->condicion_final === 'Vivo'?"No Aplica":self::$registroCovid->numero_certificado_defuncion), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 5, utf8_decode('Casua de Muerte:'), 0, 0, 'l');
            $pdf->SetX(45);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, utf8_decode(self::$registroCovid->condicion_final === 'Vivo'?"No Aplica":self::$registroCovid->causa_basica_muerte), 0, 0, 'l');
            $pdf->SetX(110);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 5, utf8_decode('Nombre del Profesional:'), 0, 0, 'l');
            $pdf->SetX(150);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, utf8_decode(self::$registroCovid->condicion_final === 'Vivo'?"No Aplica":self::$registroCovid->nombre_profesional), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 5, utf8_decode('Clasificacion Final:'), 0, 0, 'l');
            $pdf->SetX(45);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, self::$registroCovid->clasificacion_final_caso, 0, 0, 'l');
            $pdf->SetX(110);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 5, utf8_decode('¿Viajo?:'), 0, 0, 'l');
            $pdf->SetX(140);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, self::$registroCovid->Viajo_circulacion_virus, 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 5, utf8_decode('¿Viajo por el territorio nacional?:'), 0, 0, 'l');
            $pdf->SetX(60);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, self::$registroCovid->viajo_territorio_nacional, 0, 0, 'l');
            $pdf->SetX(110);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 5, utf8_decode('¿Cual municipio?:'), 0, 0, 'l');
            $pdf->SetX(140);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, utf8_decode(self::$territorionacional == 'null'?self::$territorionacional->Nombre:"NO"), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 5, utf8_decode('¿Realizo un viaje Internacional?:'), 0, 0, 'l');
            $pdf->SetX(60);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, self::$registroCovid->viajo_internacional, 0, 0, 'l');
            $pdf->SetX(110);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 5, utf8_decode('¿Cual pais?:'), 0, 0, 'l');
            $pdf->SetX(140);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, utf8_decode(self::$viajeinternacional == 'null'?self::$viajeinternacional->nombre:"NO"), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',9);
            $pdf->Cell(195, 5, utf8_decode('¿Tuvo Contacto Estrecho en los ultimos 14 Dias?:'), 0, 0, 'l');
            $pdf->SetX(80);
            $pdf->SetFont('Arial', 'B',9);
            //$pdf->Cell(20, 5, self::$registroCovid->tuvo_contacto_estrecho, 0, 0, 'l');
            $pdf->Ln();
            $pdf->Ln();

            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',10);
            $pdf->Cell(195, 5, utf8_decode('Grupo Poblacional'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(65, 5, utf8_decode('Grupo'), 0, 0, 'l',1);
            $pdf->Cell(25, 5, utf8_decode('Pertenece'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetX(110);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(65, 5, utf8_decode('Grupo'), 0, 0, 'l',1);
            $pdf->Cell(25, 5, utf8_decode('Pertenece'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Discapacitados'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->discapacitados === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetX(110);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Migrante'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->Migrantes === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Gestante'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->Gestantes === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->SetX(110);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Desplazados'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->desplazados === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Carcelario'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->carcelarios === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetX(110);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Indigente'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->indigentes === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Poblacion Infantil ICBF'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->poblacion_infantil_ICBF === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->SetX(110);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Madre Comunitaria'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->madres_comunitarias === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Desmovilizados'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->desmovilizados === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetX(110);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Centro Psiquiatrico'), 0, 0, 'l',1);
           // $pdf->Cell(25, 5, self::$registroCovid->centros_psiquiatricos === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Victimas de violencia armada'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->victimas_violencia_armada === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->SetX(110);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Otros'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->otros_grupos_poblacionales === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',10);
            $pdf->Cell(195, 5, utf8_decode('Servicio en el que se Hospitalizó'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Hospitalizacion:'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->servicio_hospitalizo === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Unididad de Cuidados Intensivos:'), 0, 0, 'l');
           // $pdf->Cell(25, 5, self::$registroCovid->uci === 'SI'?'SI':'NO', 0, 0, 'l');
            $pdf->SetX(110);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(40, 5, utf8_decode('Fecha de Ingreso a UCI:'), 0, 0, 'l');
            //$pdf->Cell(25, 5, utf8_decode(self::$registroCovid->uci == 'null'?"No Aplica":self::$registroCovid->fecha_ingreso_uci), 0, 0, 'l');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',10);
            $pdf->Cell(195, 5, utf8_decode('Si Hubo Complicaciones ¿Cuáles se Presentaron?'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(65, 5, utf8_decode('Complicacion'), 0, 0, 'l',1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(25, 5, utf8_decode('¿Se Presento?'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetX(110);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(65, 5, utf8_decode('Complicacion'), 0, 0, 'l',1);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->Cell(25, 5, utf8_decode('¿Se Presento?'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Derrame pleural'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->derrame_pleural === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetX(110);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Derrame pericardio'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->derrame_pericardico === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Miocarditis'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->miocarditis === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->SetX(110);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Septicemia'), 0, 0, 'l');
            //$pdf->Cell(25, 5, self::$registroCovid->septicemia === 'x'?'SI':'NO', 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Falla respiratoria'), 0, 0, 'l',1);
            //$pdf->Cell(25, 5, self::$registroCovid->falla_respiratoria === 'x'?'SI':'NO', 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(65, 5, utf8_decode('Otras Complicaciones'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            //$pdf->Cell(25, 5, self::$registroCovid->otro === 'x'?self::$registroCovid->otra_complicacion:'No Aplica', 0, 0, 'l');
            $posicionActual = $pdf->GetY();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->Cell(195, 6, utf8_decode('Observaciones'), 0, 0, 'l');
            $pdf->SetLineWidth(0.5);
            $pdf->Line(8, $posicionActual+18, 203, $posicionActual+18);
            $pdf->SetLineWidth(0.2);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 9);
            //$pdf->MultiCell(195, 5, self::$registroCovid->observacionesregistro, 0, 'J');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(30, 5, utf8_decode('¿Requiere Prueba?:'), 0, 0, 'l');
            $pdf->SetFont('Arial', 'B', 9);
            //$pdf->Cell(25, 5, self::$registroCovid->requiere_prueba, 0, 0, 'l');
            $pdf->SetX(50);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(25, 5, utf8_decode('Tipo de Prueba:'), 0, 0, 'l');
            $pdf->SetFont('Arial', 'B', 9);
            //$pdf->Cell(25, 5, self::$registroCovid->requiere_prueba ==='NO'?"No Aplica":self::$registroCovid->tipo_prueba, 0, 0, 'l');
            $pdf->SetX(100);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(18, 5, utf8_decode('Modalidad:'), 0, 0, 'l');
            $pdf->SetFont('Arial', 'B', 9);
            //$pdf->Cell(25, 5, self::$registroCovid->requiere_prueba ==='NO'?"No Aplica":self::$registroCovid->modalida_prueba, 0, 0, 'l');
            $pdf->SetX(140);
            $pdf->SetFont('Arial', '', 9);
            $pdf->Cell(32, 5, utf8_decode('Destino del Paciente:'), 0, 0, 'l');
            $pdf->SetFont('Arial', 'B', 9);
            //$pdf->Cell(25, 5, self::$registroCovid->destino_paciente, 0, 0, 'l');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(195, 6, utf8_decode('Conducta Final'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $posicionActual = $pdf->GetY();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->Cell(195, 6, utf8_decode('Prescripción de medicamentos'), 0, 0, 'l');
            $pdf->SetLineWidth(0.5);
            $pdf->Line(8, $posicionActual+13, 203, $posicionActual+13);
            $pdf->SetLineWidth(0.2);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(125, 5, utf8_decode('Medicamento'), 0, 0, 'l',1);
            $pdf->Cell(70, 5, utf8_decode('Cantidad'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $posicionActual = $pdf->GetY();
            $pdf->Ln();
            // if(self::$ordenamientoMedica){
            //     foreach(self::$ordenamientoMedica as $ordenamientoMedicamentos){
            //         $pdf->SetX(8);
            //         $pdf->SetFont('Arial', '', 8);
            //         $pdf->Cell(130, 5, utf8_decode('* '.($ordenamientoMedicamentos->Medicamento)), 0, 'l');
            //         $pdf->Cell(35, 5, utf8_decode(($ordenamientoMedicamentos->Cantidadpormedico)), 0, 'R');
            //         $pdf->Ln();
            //         $pdf->SetFont('Arial', 'B', 8);
            //         $pdf->Cell(20, 4, utf8_decode('Observacion'), 0, 'C');
            //         $pdf->SetFont('Arial', '', 8);
            //         $pdf->Cell(50, 4, utf8_decode(($ordenamientoMedicamentos->Observacion)), 0, 'L');
            //         $posicionActual = $pdf->GetY();
            //         $pdf->Ln();
            //     }
            // }else{
            //     $pdf->SetX(8);
            //     $pdf->SetFont('Arial', '', 9);
            //     $pdf->Cell(195, 4, utf8_decode(''), 1, 'l');
            //     $posicionActual = $pdf->GetY();
            //     $pdf->Ln();
            // }
            $pdf->Ln();
            $posicionActual = $pdf->GetY();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->Cell(195, 6, utf8_decode('Ayudas diagnósticas'), 0, 0, 'l');
            $pdf->SetLineWidth(0.5);
            $pdf->Line(8, $posicionActual+13, 203, $posicionActual+13);
            $pdf->SetLineWidth(0.2);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(195, 5, utf8_decode('Servicio'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $posicionActual = $pdf->GetY();
            // if(self::$ordenamientoServ){
            //     foreach(self::$ordenamientoServ as $ordenamientoServicios){
            //         $pdf->SetX(8);
            //         $pdf->SetFont('Arial', '', 9);
            //         $pdf->MultiCell(125, 5, utf8_decode('* '.($ordenamientoServicios->Servicio)), 0, 'l');
            //         $pdf->SetFont('Arial', 'B', 8);
            //         $pdf->Cell(20, 4, utf8_decode('Cantidad: '), 0, 'C');
            //         $pdf->SetFont('Arial', '', 8);
            //         $pdf->Cell(70, 5, utf8_decode(($ordenamientoServicios->CantidadServi)), 0, 'l');
            //         $posicionActual = $pdf->GetY();
            //         $pdf->Ln();
            //     }
            // }else{
            //     $pdf->SetX(8);
            //     $pdf->SetFont('Arial', '', 9);
            //     $pdf->Cell(195, 4, utf8_decode(''), 1, 'l');
            //     $posicionActual = $pdf->GetY();
            //     $pdf->Ln();
            // }
            $pdf->Ln();
            $posicionActual = $pdf->GetY();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->Cell(195, 6, utf8_decode('Recomendaciones'), 0, 0, 'l');
            $pdf->SetLineWidth(0.5);
            $pdf->Line(8, $posicionActual+13, 203, $posicionActual+13);
            $pdf->SetLineWidth(0.2);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 8);
            $pdf->MultiCell(195, 4, utf8_decode('Recuerda que el aislamiento durante 10 días desde el inicio de los síntomas es importante para evitar la propagación del virus; pasado este tiempo, si presentas mejoría de tus síntomas y no has tenido fiebre por dos días puedes reincorporarte a tu vida cotidiana y laboral. Para SUMIMEDICAL S.A.S cuidarte es nuestro propósito. Ahora que estás en proceso de diagnóstico de COVID-19, queremos acompañarte de manera oportuna y con la atención adecuada para ti y las personas de tu entorno.

            Te entregamos algunas recomendaciones que te servirán para manejar y prevenir infecciones virales como el COVID-19 y evitar su propagación:
            1. Lávate las manos frecuentemente con agua y jabon o utiliza un desinfectante de manos a base de alcohol.
            2. Adopta medidas de higiene respiratoria: Al toser o estornudar, cubrete la boca y la nariz con el codo flexionado o con un pañuelo; si usas un pañuelo descartalo inmediatamente y lavate las manos con agua y jabon o utiliza un desinfectante de manos a base de alcohol. Si al estornudar o toser te cubres con las manos puedes contaminar los objetos o las personas que toques.
            3. El distanciamiento social: Manten al menos 2 metros de distancia con las demas personas, particularmente aquellas que tosan, estornuden y tengan fiebre. Evita compartir articulos de uso personal (telefonos, computadores., llaves, lapiceros, entre otros).4. Evita tocarte los ojos, la nariz y la boca. INFORMATE en fuentes confiables: Ministerio de salud, OMS. LIMPIA Y DESCONTAMINA objetosysuperficies. VENTILA tu casa y las areas de trabajo cada vez que sea posible. RECUERDA registrarte en la aplicación CoronApp.

            En Caso de síntomas leves, puedes contactarnos por nuestros canales de atención virtual. Si tus síntomas no mejoran, empeoran o presentas síntomas de alarma (ver abajo), consulta al servicio de Urgencias más cercano. Fiebre cuantificada (mayor o igual a 38 grados) por más de dos dias Sensación de dificultad para respirar. Respiración más rápida de lo normal. Decaimiento del estado general en forma rapida. Somnolencia o dificultad para despertar. Si el pecho te suena o te duele al respirar. Si los labios o los dedos se ponen morados o azules'), 0, 'j');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(195, 6, utf8_decode('Información del profesional de la salud'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $posicionActual = $pdf->GetY();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',12);
            //$pdf->Cell(195, 6, self::$medicoatiende->name.' '.self::$medicoatiende->apellido, 0, 0, 'l');
            $pdf->SetLineWidth(0.5);
            $pdf->Line(8, $posicionActual+13, 203, $posicionActual+13);
            $pdf->SetLineWidth(0.2);
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '',9);
            //$pdf->Cell(70, 6, (self::$medicoatiende->nit.' '.self::$medicoatiende->cedula), 0, 0, 'l');
            //$pdf->Cell(70, 6, self::$medicoatiende->especialidad_medico, 0, 0, 'l');
            //$pdf->Cell(90, 6, utf8_decode('Registro: '.self::$medicoatiende->Registromedico), 0, 0, 'l');
            $posicionActual = $pdf->GetY();
            $pdf->Ln();
            // if(self::$medicoatiende->Firma){
            //     if (file_exists(storage_path(substr(self::$medicoatiende->Firma, 9)))) {
            //         $pdf->Image(storage_path(substr(self::$medicoatiende->Firma, 9)), 70, $posicionActual+13, 56, 11);
            //     }
            // }
            // if($posicionActual > 225){
            //     $pdf->AddPage();
            // }



        // elseif (self::$data["tipo"] === 'seguimiento'){

            $Y = 40;
            $pdf->SetFont('Arial', 'B', 9);
            $logo = "/images/logoEcoimagen.png";
            $pdf->Image($logo, 155, 8, -220);
            $pdf->SetXY(7,15);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(240, 240, 240);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(140, 20, utf8_decode(''), 0, 1, 'l',1);
            $pdf->SetDrawColor(1, 22, 137);
            $pdf->Line(8, 35, 140, 35); #LIENA HORIZONTAL ABAJO
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFont('Arial', '', 12);
            $pdf->SetXY(8,15);
            $pdf->Cell(60, 5, utf8_decode('SUMIMEDICAL S.A.S / NIT: 900033371 Res: 004 '), 0, 0, 'l');
            $pdf->ln();
            $pdf->SetFont('Arial', 'B', 12);
            $pdf->SetX(8);
            $pdf->Cell(60, 5, utf8_decode('Seguimiento Medico COVID'), 0, 0, 'l');
            $pdf->ln();
            $pdf->SetFont('Arial', '', 12);
            $pdf->SetX(8);
            $pdf->cell(40,5,utf8_decode('Fecha de Atencion:'), 0, 0, 'l');
            //$pdf->Cell(60, 5, self::$seguimientoCovid->created_at, 0, 0, 'l');
            $pdf->ln();
            $pdf->SetX(8);
            //$pdf->Cell(60, 5, self::$paciente->Ut, 0, 0, 'l');
            $pdf->Ln();
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(195, 6, utf8_decode('Información Básica del Paciente y la Atención'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $pdf->SetX(10);
            $pdf->SetFont('Times', 'B', 12);
            //$pdf->Cell(80, 7, self::$paciente->Primer_Nom.(self::$paciente->SegundoNom?' '.self::$paciente->SegundoNom:'').' '.self::$paciente->Primer_Ape.' '.self::$paciente->Segundo_Ape, 0, 'l');
            $pdf->SetX(105);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Identificación'), 0, 0, 'l');
            $pdf->SetX(130);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Fecha de nacimiento'), 0, 0, 'l');
            $pdf->SetX(165);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Edad'), 0, 0, 'l');
            $pdf->SetX(185);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Sexo'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(105);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$paciente->Tipo_Doc.' '.self::$paciente->Num_Doc, 0, 'l');
            $pdf->SetX(130);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$paciente->Fecha_Naci, 0, 'l');
            $pdf->SetX(165);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$paciente->Edad_Cumplida.' '.utf8_decode('Años'), 0, 'l');
            $pdf->SetX(185);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$paciente->Sexo=== 'M'?'Masculino':'Femenino' , 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Tipo de Afiliado'), 0, 0, 'l');
            $pdf->SetX(35);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Departamento'), 0, 0, 'l');
            $pdf->SetX(65);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Municipio'), 0, 0, 'l');
            $pdf->SetX(90);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Estado Civil'), 0, 0, 'l');
            $pdf->SetX(115);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Teléfono fijo'), 0, 0, 'l');
            $pdf->SetX(140);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Otro Teléfono'), 0, 0, 'l');
            $pdf->SetX(165);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Correo electrónico'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$paciente->Tipo_Afiliado , 0, 'l');
            $pdf->SetX(35);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$departamento->Nombre , 0, 'l');
            $pdf->SetX(65);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$municipio->Nombre , 0, 'l');
            $pdf->SetX(90);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$paciente->estado_civil, 0, 'l');
            $pdf->SetX(115);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$registroCovid->telefono , 0, 'l');
            $pdf->SetX(140);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$paciente->Celular1 , 0, 'l');
            $pdf->SetX(165);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$paciente->Correo1 , 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Dirección'), 0, 0, 'l');
            $pdf->SetX(95);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(25, 4, utf8_decode('Ocupacion'), 0, 0, 'l');
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$registroCovid->direccion_residencia , 0, 'l');
            $pdf->SetX(95);
            $pdf->SetFont('Arial', 'B', 8);
            //$pdf->Cell(25, 4, self::$ocupacionpaciente->ocupacion , 0, 'l');
            $pdf->Ln();
            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B',10);
//            $pdf->Cell(195, 6, utf8_decode('Antecedentes Patologicos'), 0, 0, 'l');
//            $pdf->SetLineWidth(0.5);
//            $pdf->Line(8, 86, 203, 86);
//            $pdf->SetLineWidth(0.2);
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B', 10);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(1, 22, 137);
//            $pdf->SetTextColor(255,255,255);
//            $pdf->Cell(65, 5, utf8_decode('Patología'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, utf8_decode('Presenta'), 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', 'B', 10);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(1, 22, 137);
//            $pdf->SetTextColor(255,255,255);
//            $pdf->Cell(65, 5, utf8_decode('Patología'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, utf8_decode('Presenta'), 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Asma'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->asma === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetX(110);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Epoc'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->epoc === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Diabetes'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->diabetes === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('VIH'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->vih === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Tuberculosis'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->tuberculosis === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetX(110);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Enfermedad Cardiaca'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->enfermedad_cardiaca === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Cancer'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->cancer === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Malnutricion'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->malnutricion === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Obesidad'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->obesidad === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetX(110);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Insuficiencia Renal'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->insuficiencia_renal === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Medicamentos Inmunosupresores'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->medicamentos_inmunosupresores === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Fumador'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->fumador === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Hipertensión'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->hipertensión === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetX(110);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Otros'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->otro === 'x'?self::$registroCovid->cuales_otros:'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B',10);
//            $pdf->Cell(195, 6, utf8_decode('Antecedentes Aelergicos'), 0, 0, 'l');
//            $pdf->SetLineWidth(0.5);
//            $pdf->Line(8, 143, 203, 143);
//            $pdf->SetLineWidth(0.2);
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B', 10);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(1, 22, 137);
//            $pdf->SetTextColor(255,255,255);
//            $pdf->Cell(130, 5, utf8_decode('Patología'), 0, 0, 'l',1);
//            $pdf->Cell(65, 5, utf8_decode('Fecha De Registro'), 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $posicionActual = $pdf->GetY();
//            if(self::$anteAlergicos){
//                foreach(self::$anteAlergicos as $anteAlergico){
//                    $pdf->SetX(8,$posicionActual);
//                    $pdf->SetFont('Arial', '', 9);
//                    $pdf->Cell(130, 5, utf8_decode(($anteAlergico->Descripcion)), 0, 'l');
//                    $pdf->Cell(65, 5, utf8_decode(($anteAlergico->created_at)), 0, 'l');
//                    $posicionActual = $pdf->GetY();
//                    $pdf->Ln();
//                }
//            }else{
//                $pdf->SetX(8);
//                $pdf->SetFont('Arial', '', 9);
//                $pdf->Cell(195, 4, utf8_decode('N/A'), 1, 'l');
//                $posicionActual = $pdf->GetY();
//                $pdf->Ln();
//            }
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B',10);
//            $pdf->Cell(195, 6, utf8_decode('Antecedentes Familiares'), 0, 0, 'l');
//            $pdf->SetLineWidth(0.5);
//            $pdf->Line(8, $posicionActual+17, 203, $posicionActual+17);
//            $pdf->SetLineWidth(0.2);
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B', 10);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(1, 22, 137);
//            $pdf->SetTextColor(255,255,255);
//            $pdf->Cell(50, 5, utf8_decode('Patología'), 0, 0, 'l',1);
//            $pdf->Cell(70, 5, utf8_decode('Nota'), 0, 0, 'l',1);
//            $pdf->Cell(40, 5, utf8_decode('Parentesco'), 0, 0, 'l',1);
//            $pdf->Cell(35, 5, utf8_decode('Fecha de Registro'), 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $posicionActual = $pdf->GetY();
//            if(self::$antFamiliares){
//                foreach(self::$antFamiliares as $antFamiliare){
//                    $pdf->SetX(8,$posicionActual);
//                    $pdf->SetFont('Arial', '', 9);
//                    $pdf->Cell(50, 5, utf8_decode(($antFamiliare->Nombre)), 0, 'l');
//                    $pdf->Cell(70, 5, utf8_decode(($antFamiliare->Descripcion)), 0, 'l');
//                    $pdf->Cell(35, 5, utf8_decode(($antFamiliare->parentesco)), 0, 'l');
//                    $pdf->Cell(35, 5, utf8_decode(($antFamiliare->fechaRegistro)), 0, 'l');
//                    $posicionActual = $pdf->GetY();
//                    $pdf->Ln();
//                }
//            }else{
//                $pdf->SetX(8);
//                $pdf->SetFont('Arial', '', 9);
//                $pdf->Cell(195, 4, utf8_decode('N/A'), 1, 'l');
//                $posicionActual = $pdf->GetY();
//                $pdf->Ln();
//            }
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B',10);
//            $pdf->Cell(195, 6, utf8_decode('Estilos de Vida'), 0, 0, 'l');
//            $pdf->SetLineWidth(0.5);
//            $pdf->Line(8, $posicionActual+17, 203, $posicionActual+17);
//            $pdf->SetLineWidth(0.2);
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',10);
//            $pdf->Cell(195, 6, utf8_decode('Hábitos(Cigarrillo)'), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetFont('Arial', '',9);
//            $pdf->SetX(8);
//            $pdf->Cell(25, 5, utf8_decode('¿Es fumador?:'), 0, 0, 'l');
//            $pdf->SetX(30);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(25, 5, self::$estilosVida == 'null'?self::$estilosVida->Fumacantidad:"No Refiere", 0, 0, 'l');
//            $pdf->SetX(80);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(25, 5, utf8_decode('¿Es fumador Pasivo?:'), 0, 0, 'l');
//            $pdf->SetX(115);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(25, 5, self::$estilosVida == 'null'?self::$estilosVida->Fumadorpasivo:"No Refiere", 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',10);
//            $pdf->Cell(195, 6, utf8_decode('Consumo de Alcohol'), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetFont('Arial', '',9);
//            $pdf->SetX(8);
//            $pdf->Cell(25, 5, utf8_decode('¿Frecuencia consumo de licor?:'), 0, 0, 'l');
//            $pdf->SetX(55);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(25, 5, self::$estilosVida =='null'?self::$estilosVida->Licorfrecuencia:"No Refiere", 0, 0, 'l');
//            $pdf->SetX(100);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(25, 5, utf8_decode('¿Toma licor actualmente?:'), 0, 0, 'l');
//            $pdf->SetX(140);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(25, 5, self::$estilosVida == 'null'?self::$estilosVida->Cantidadlicor:"No Refiere", 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',10);
//            $pdf->Cell(195, 6, utf8_decode('Sustancias psicoactivas'), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetFont('Arial', '',9);
//            $pdf->SetX(8);
//            $pdf->Cell(25, 5, utf8_decode('¿Consume sustancias psicoactivas?:'), 0, 0, 'l');
//            $pdf->SetX(65);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(25, 5, self::$estilosVida =='null'?self::$estilosVida->Consumopsicoactivo:"No Refiere", 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',10);
//            $pdf->Cell(195, 6, utf8_decode('Hábitos (Actividad física)'), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetFont('Arial', '',9);
//            $pdf->SetX(8);
//            $pdf->Cell(25, 5, utf8_decode('¿Realiza actividad física?:'), 0, 0, 'l');
//            $pdf->SetX(65);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(25, 5, utf8_decode(self::$estilosVida == 'null'?self::$estilosVida->Actividadfisica:"No Refiere"), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',10);
//            $pdf->Cell(195, 6, utf8_decode('Observaciones:'), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B',8);
//            $pdf->MultiCell(195, 5, utf8_decode(self::$estilosVida == 'null'?self::$estilosVida->Estilovidaobservaciones:"No Refiere"),0, 'J');
//            $posicionActual = $pdf->GetY();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B',10);
//            $pdf->Cell(195, 6, utf8_decode('Examen Fisico'), 0, 0, 'l');
//            $pdf->SetLineWidth(0.5);
//            $pdf->Line(8, $posicionActual+12, 203, $posicionActual+12);
//            $pdf->SetLineWidth(0.2);
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetFont('Arial', '',9);
//            $pdf->SetX(8);
//            $pdf->Cell(25, 5, utf8_decode('Medidas Antropometricas:'), 0, 0, 'l');
//            $pdf->SetX(50);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(25, 5, utf8_decode(self::$estilosVida == 'null'?'Talla'.' '.self::$estilosVida->Talla.' '.'cm':"No Refiere"), 0, 0, 'l');
//            $posicionActual = $pdf->GetY();
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B',10);
//            $pdf->Cell(195, 6, utf8_decode('Análisis y plan'), 0, 0, 'l');
//            $pdf->SetLineWidth(0.5);
//            $pdf->Line(8, $posicionActual+17, 203, $posicionActual+17);
//            $pdf->SetLineWidth(0.2);
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetFont('Arial', '',10);
//            $pdf->SetX(8);
//            $pdf->Cell(25, 5, utf8_decode('Información gestión covid'), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetFont('Arial', '',9);
//            $pdf->SetX(8);
//            $pdf->Cell(25, 5, utf8_decode('Fecha de inicio de gestión'), 0, 0, 'l');
//            $pdf->SetX(50);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(25, 5, utf8_decode(self::$registroCovid->fecha_consulta), 0, 0, 'l');
//            $pdf->SetX(90);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(25, 5, utf8_decode('Estado:'), 0, 0, 'l');
//            $pdf->SetX(105);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, utf8_decode(self::$registroCovid->estado_id == 43?'En Seguimiento':'Finalizado'), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',10);
//            $pdf->Cell(195, 6, utf8_decode('Validación COVID-19'), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 6, utf8_decode('¿Aplica cuestionario COVID-19?'), 0, 0, 'l');
//            $pdf->SetX(60);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, utf8_decode('SI'), 0, 0, 'l');
//            $pdf->Ln();
//            $posicionActual = $pdf->GetY();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B',10);
//            $pdf->Cell(195, 6, utf8_decode('Síntomas'), 0, 0, 'l');
//            $pdf->SetLineWidth(0.5);
//            $pdf->Line(8, $posicionActual+13, 203, $posicionActual+13);
//            $pdf->SetLineWidth(0.2);
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 5, utf8_decode('Fecha de Inicio Sintomas:'), 0, 0, 'l');
//            $pdf->SetX(48);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, self::$registroCovid->fecha_inicio_sintomas, 0, 0, 'l');
//            $pdf->SetX(80);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 5, utf8_decode('Clasificacion:'), 0, 0, 'l');
//            $pdf->SetX(102);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, self::$registroCovid->clasificacion, 0, 0, 'l');
//            $pdf->SetX(130);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 5, utf8_decode('Fuente:'), 0, 0, 'l');
//            $pdf->SetX(145);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, self::$registroCovid->fuente, 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B', 10);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(1, 22, 137);
//            $pdf->SetTextColor(255,255,255);
//            $pdf->Cell(65, 5, utf8_decode('Sintomatologia'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, utf8_decode('¿Tiene?'), 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', 'B', 10);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(1, 22, 137);
//            $pdf->SetTextColor(255,255,255);
//            $pdf->Cell(65, 5, utf8_decode('Sintomatologia'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, utf8_decode('¿Tiene?'), 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Tos'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->tos === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetX(110);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Fiebre'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->fiebre === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Dolor de Garganta'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->dolor_garganta === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Dificultad Respiratoria'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->dificultad_respiratoria === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Fatiga Adinamia'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->fatiga_adinamia === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetX(110);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Rinorrea'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->rinorrea === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Conjuntivitis'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->conjuntivitis === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Cefalea'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->cefalea === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Diarrea'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->diarrea === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetX(110);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Perdida de Olfato'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->perdida_de_olfato === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 6, utf8_decode('Otros Sintomas'), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, self::$registroCovid->otros_sintomas === 'x'?self::$registroCovid->cuales_otros:'NO', 0, 0, 'l');
//            $posicionActual = $pdf->GetY();
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B',10);
//            $pdf->Cell(195, 6, utf8_decode('Otra Informacion de Interes'), 0, 0, 'l');
//            $pdf->SetLineWidth(0.5);
//            $pdf->Line(8, $posicionActual+18, 203, $posicionActual+18);
//            $pdf->SetLineWidth(0.2);
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 5, utf8_decode('¿Hospitalizado?:'), 0, 0, 'l');
//            $pdf->SetX(45);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, self::$registroCovid->hospitalizado, 0, 0, 'l');
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 5, utf8_decode('Codicion Final:'), 0, 0, 'l');
//            $pdf->SetX(140);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, self::$registroCovid->condicion_final, 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 5, utf8_decode('Fecha de Defuncion:'), 0, 0, 'l');
//            $pdf->SetX(45);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, utf8_decode(self::$registroCovid->condicion_final === 'Vivo'?"No Aplica":self::$registroCovid->fecha_defuncion), 0, 0, 'l');
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 5, utf8_decode('Certificado de Defuncion:'), 0, 0, 'l');
//            $pdf->SetX(150);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, utf8_decode(self::$registroCovid->condicion_final === 'Vivo'?"No Aplica":self::$registroCovid->numero_certificado_defuncion), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 5, utf8_decode('Casua de Muerte:'), 0, 0, 'l');
//            $pdf->SetX(45);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, utf8_decode(self::$registroCovid->condicion_final === 'Vivo'?"No Aplica":self::$registroCovid->causa_basica_muerte), 0, 0, 'l');
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 5, utf8_decode('Nombre del Profesional:'), 0, 0, 'l');
//            $pdf->SetX(150);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, utf8_decode(self::$registroCovid->condicion_final === 'Vivo'?"No Aplica":self::$registroCovid->nombre_profesional), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 5, utf8_decode('Clasificacion Final:'), 0, 0, 'l');
//            $pdf->SetX(45);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, self::$registroCovid->clasificacion_final_caso, 0, 0, 'l');
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 5, utf8_decode('¿Viajo?:'), 0, 0, 'l');
//            $pdf->SetX(140);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, self::$registroCovid->Viajo_circulacion_virus, 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 5, utf8_decode('¿Viajo por el territorio nacional?:'), 0, 0, 'l');
//            $pdf->SetX(60);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, self::$registroCovid->viajo_territorio_nacional, 0, 0, 'l');
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 5, utf8_decode('¿Cual municipio?:'), 0, 0, 'l');
//            $pdf->SetX(140);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, utf8_decode(self::$territorionacional == 'null'?self::$territorionacional->Nombre:"NO"), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 5, utf8_decode('¿Realizo un viaje Internacional?:'), 0, 0, 'l');
//            $pdf->SetX(60);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, self::$registroCovid->viajo_internacional, 0, 0, 'l');
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 5, utf8_decode('¿Cual pais?:'), 0, 0, 'l');
//            $pdf->SetX(140);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, utf8_decode(self::$viajeinternacional == 'null'?self::$viajeinternacional->nombre:"NO"), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(195, 5, utf8_decode('¿Tuvo Contacto Estrecho en los ultimos 14 Dias?:'), 0, 0, 'l');
//            $pdf->SetX(80);
//            $pdf->SetFont('Arial', 'B',9);
//            $pdf->Cell(20, 5, self::$registroCovid->tuvo_contacto_estrecho, 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->Ln();
//
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',10);
//            $pdf->Cell(195, 5, utf8_decode('Grupo Poblacional'), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B', 10);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(1, 22, 137);
//            $pdf->SetTextColor(255,255,255);
//            $pdf->Cell(65, 5, utf8_decode('Grupo'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, utf8_decode('Pertenece'), 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', 'B', 10);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(1, 22, 137);
//            $pdf->SetTextColor(255,255,255);
//            $pdf->Cell(65, 5, utf8_decode('Grupo'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, utf8_decode('Pertenece'), 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Discapacitados'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->discapacitados === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetX(110);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Migrante'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->Migrantes === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Gestante'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->Gestantes === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Desplazados'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->desplazados === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Carcelario'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->carcelarios === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetX(110);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Indigente'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->indigentes === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Poblacion Infantil ICBF'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->poblacion_infantil_ICBF === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Madre Comunitaria'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->madres_comunitarias === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Desmovilizados'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->desmovilizados === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetX(110);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Centro Psiquiatrico'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->centros_psiquiatricos === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Victimas de violencia armada'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->victimas_violencia_armada === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Otors'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->otros_grupos_poblacionales === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',10);
//            $pdf->Cell(195, 5, utf8_decode('Servicio en el que se Hospitalizó'), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Hospitalizacion:'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->servicio_hospitalizo === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Unididad de Cuidados Intensivos:'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->uci === 'SI'?'SI':'NO', 0, 0, 'l');
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(40, 5, utf8_decode('Fecha de Ingreso a UCI:'), 0, 0, 'l');
//            $pdf->Cell(25, 5, utf8_decode(self::$registroCovid->uci == 'null'?"No Aplica":self::$registroCovid->fecha_ingreso_uci), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',10);
//            $pdf->Cell(195, 5, utf8_decode('Si Hubo Complicaciones ¿Cuáles se Presentaron?'), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B', 10);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(1, 22, 137);
//            $pdf->SetTextColor(255,255,255);
//            $pdf->Cell(65, 5, utf8_decode('Complicacion'), 0, 0, 'l',1);
//            $pdf->SetFont('Arial', 'B', 9);
//            $pdf->Cell(25, 5, utf8_decode('¿Se Presento?'), 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', 'B', 10);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(1, 22, 137);
//            $pdf->SetTextColor(255,255,255);
//            $pdf->Cell(65, 5, utf8_decode('Complicacion'), 0, 0, 'l',1);
//            $pdf->SetFont('Arial', 'B', 9);
//            $pdf->Cell(25, 5, utf8_decode('¿Se Presento?'), 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Derrame pleural'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->derrame_pleural === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetX(110);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Derrame pericardio'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->derrame_pericardico === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Miocarditis'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->miocarditis === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->SetX(110);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Septicemia'), 0, 0, 'l');
//            $pdf->Cell(25, 5, self::$registroCovid->septicemia === 'x'?'SI':'NO', 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(240, 240, 240);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Falla respiratoria'), 0, 0, 'l',1);
//            $pdf->Cell(25, 5, self::$registroCovid->falla_respiratoria === 'x'?'SI':'NO', 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(65, 5, utf8_decode('Otras Complicaciones'), 0, 0, 'l');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->Cell(25, 5, self::$registroCovid->otro === 'x'?self::$registroCovid->otra_complicacion:'No Aplica', 0, 0, 'l');
//            $posicionActual = $pdf->GetY();
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B',10);
//            $pdf->Cell(195, 6, utf8_decode('Observaciones'), 0, 0, 'l');
//            $pdf->SetLineWidth(0.5);
//            $pdf->Line(8, $posicionActual+18, 203, $posicionActual+18);
//            $pdf->SetLineWidth(0.2);
//            $pdf->Ln();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->MultiCell(195, 5, self::$registroCovid->observacionesregistro, 0, 'J');
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(30, 5, utf8_decode('¿Requiere Prueba?:'), 0, 0, 'l');
//            $pdf->SetFont('Arial', 'B', 9);
//            $pdf->Cell(25, 5, self::$registroCovid->requiere_prueba, 0, 0, 'l');
//            $pdf->SetX(50);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(25, 5, utf8_decode('Tipo de Prueba:'), 0, 0, 'l');
//            $pdf->SetFont('Arial', 'B', 9);
//            $pdf->Cell(25, 5, self::$registroCovid->requiere_prueba ==='NO'?"No Aplica":self::$registroCovid->tipo_prueba, 0, 0, 'l');
//            $pdf->SetX(100);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(18, 5, utf8_decode('Modalidad:'), 0, 0, 'l');
//            $pdf->SetFont('Arial', 'B', 9);
//            $pdf->Cell(25, 5, self::$registroCovid->requiere_prueba ==='NO'?"No Aplica":self::$registroCovid->modalida_prueba, 0, 0, 'l');
//            $pdf->SetX(140);
//            $pdf->SetFont('Arial', '', 9);
//            $pdf->Cell(32, 5, utf8_decode('Destino del Paciente:'), 0, 0, 'l');
//            $pdf->SetFont('Arial', 'B', 9);
//            $pdf->Cell(25, 5, self::$registroCovid->destino_paciente, 0, 0, 'l');
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B',10);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(1, 22, 137);
//            $pdf->SetTextColor(255,255,255);
//            $pdf->Cell(195, 6, utf8_decode('Conducta Final'), 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
            $posicionActual = $pdf->GetY();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->Cell(195, 6, utf8_decode('Prescripción de medicamentos'), 0, 0, 'l');
            $pdf->SetLineWidth(0.5);
            $pdf->Line(8, $posicionActual+13, 203, $posicionActual+13);
            $pdf->SetLineWidth(0.2);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(125, 5, utf8_decode('Medicamento'), 0, 0, 'l',1);
            $pdf->Cell(70, 5, utf8_decode('Cantidad'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $posicionActual = $pdf->GetY();
            $pdf->Ln();
            // if(self::$ordenamientoMedica){
            //     foreach(self::$ordenamientoMedica as $ordenamientoMedicamentos){
            //         $pdf->SetX(8);
            //         $pdf->SetFont('Arial', '', 8);
            //         $pdf->Cell(130, 5, utf8_decode('* '.($ordenamientoMedicamentos->Medicamento)), 0, 'l');
            //         $pdf->Cell(35, 5, utf8_decode(($ordenamientoMedicamentos->Cantidadpormedico)), 0, 'R');
            //         $pdf->Ln();
            //         $pdf->SetFont('Arial', 'B', 8);
            //         $pdf->Cell(20, 4, utf8_decode('Observacion'), 0, 'C');
            //         $pdf->SetFont('Arial', '', 8);
            //         $pdf->Cell(50, 4, utf8_decode(($ordenamientoMedicamentos->Observacion)), 0, 'L');
            //         $posicionActual = $pdf->GetY();
            //         $pdf->Ln();
            //     }
            // }else{
            //     $pdf->SetX(8);
            //     $pdf->SetFont('Arial', '', 9);
            //     $pdf->Cell(195, 4, utf8_decode(''), 1, 'l');
            //     $posicionActual = $pdf->GetY();
            //     $pdf->Ln();
            // }
            $pdf->Ln();
            $posicionActual = $pdf->GetY();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B',10);
            $pdf->Cell(195, 6, utf8_decode('Ayudas diagnósticas'), 0, 0, 'l');
            $pdf->SetLineWidth(0.5);
            $pdf->Line(8, $posicionActual+13, 203, $posicionActual+13);
            $pdf->SetLineWidth(0.2);
            $pdf->Ln();
            $pdf->Ln();
            $pdf->SetX(8);
            $pdf->SetFont('Arial', 'B', 10);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(1, 22, 137);
            $pdf->SetTextColor(255,255,255);
            $pdf->Cell(195, 5, utf8_decode('Servicio'), 0, 0, 'l',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
            $posicionActual = $pdf->GetY();
            // if(self::$ordenamientoServ){
            //     foreach(self::$ordenamientoServ as $ordenamientoServicios){
            //         $pdf->SetX(8);
            //         $pdf->SetFont('Arial', '', 9);
            //         $pdf->MultiCell(125, 5, utf8_decode('* '.($ordenamientoServicios->Servicio)), 0, 'l');
            //         $pdf->SetFont('Arial', 'B', 8);
            //         $pdf->Cell(20, 4, utf8_decode('Cantidad: '), 0, 'C');
            //         $pdf->SetFont('Arial', '', 8);
            //         $pdf->Cell(70, 5, utf8_decode(($ordenamientoServicios->CantidadServi)), 0, 'l');
            //         $posicionActual = $pdf->GetY();
            //         $pdf->Ln();
            //     }
            // }else{
            //     $pdf->SetX(8);
            //     $pdf->SetFont('Arial', '', 9);
            //     $pdf->Cell(195, 4, utf8_decode(''), 1, 'l');
            //     $posicionActual = $pdf->GetY();
            //     $pdf->Ln();
            // }
            $pdf->Ln();
//            $posicionActual = $pdf->GetY();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B',10);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->SetFillColor(1, 22, 137);
//            $pdf->SetTextColor(255,255,255);
//            $pdf->Cell(195, 6, utf8_decode('Información del profesional de la salud que realizo el ingreso'), 0, 0, 'l',1);
//            $pdf->SetTextColor(0,0,0);
//            $pdf->SetDrawColor(0,0,0);
//            $pdf->Ln();
//            $posicionActual = $pdf->GetY();
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', 'B',12);
//            $pdf->Cell(195, 6, self::$medicoatiende->name.' '.self::$medicoatiende->apellido, 0, 0, 'l');
//            $pdf->SetLineWidth(0.5);
//            $pdf->Line(8, $posicionActual+13, 203, $posicionActual+13);
//            $pdf->SetLineWidth(0.2);
//            $pdf->Ln();
//            $pdf->SetX(8);
//            $pdf->SetFont('Arial', '',9);
//            $pdf->Cell(70, 6, (self::$medicoatiende->nit.' '.self::$medicoatiende->cedula), 0, 0, 'l');
//            $pdf->Cell(70, 6, self::$medicoatiende->especialidad_medico, 0, 0, 'l');
//            $pdf->Cell(90, 6, utf8_decode('Registro: '.self::$medicoatiende->Registromedico), 0, 0, 'l');
//            $posicionActual = $pdf->GetY();
//            $pdf->Ln();
//            if(self::$medicoatiende->Firma){
//                if (file_exists(storage_path(substr(self::$medicoatiende->Firma, 9)))) {
//                    $pdf->Image(storage_path(substr(self::$medicoatiende->Firma, 9)), 70, $posicionActual+9, 56, 11);
//                    $posicionActual = $pdf->GetY();
//                    $pdf->Ln();
//                }
//            }
////            if($posicionActual > 225){
////                $pdf->AddPage();
////            }


            //if($consentimiento=='1'){
                $posicionActual = $pdf->GetY();
                $pdf->Ln();
                $pdf->SetXY(8,$posicionActual+13);
                $pdf->SetFont('Arial', 'B',10);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetFillColor(1, 22, 137);
                $pdf->SetTextColor(255,255,255);
                $pdf->Cell(195, 6, utf8_decode('Información del seguimiento '), 0, 0, 'l',1);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetDrawColor(0,0,0);
                $pdf->Ln();
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('¿El contacto fue?:'), 0, 0, 'l');
                $pdf->SetX(45);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, self::$seguimientoCovid->contacto_fue, 0, 0, 'l');
                $pdf->SetX(110);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('¿Paciente Con Sintomas?:'), 0, 0, 'l');
                $pdf->SetX(160);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, self::$seguimientoCovid->paciente_sintomas, 0, 0, 'l');
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('Saturacion:'), 0, 0, 'l');
                $pdf->SetX(45);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, utf8_decode(self::$seguimientoCovid->saturacion == 'null'?self::$seguimientoCovid->saturacion:"No Aplica"), 0, 0, 'l');
                $pdf->SetX(110);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('Pulso:'), 0, 0, 'l');
                $pdf->SetX(150);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, utf8_decode(self::$seguimientoCovid->pulso == 'null'?self::$seguimientoCovid->pulso:"No Aplica"), 0, 0, 'l');
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('Temperatura:'), 0, 0, 'l');
                $pdf->SetX(45);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, utf8_decode(self::$seguimientoCovid->temperatura == 'null'?self::$seguimientoCovid->temperatura:"No Aplica"), 0, 0, 'l');
                $pdf->SetX(110);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('Tenesion Arterial:'), 0, 0, 'l');
                $pdf->SetX(150);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, utf8_decode(self::$seguimientoCovid->tensionarterial == 'null'?self::$seguimientoCovid->tensionarterial:"No Aplica"), 0, 0, 'l');
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('Frecuencia Respiratoria:'), 0, 0, 'l');
                $pdf->SetX(45);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, utf8_decode(self::$seguimientoCovid->frecuenciarespiratoria == 'null'?self::$seguimientoCovid->frecuenciarespiratoria:"No Aplica"), 0, 0, 'l');
                $pdf->SetX(110);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('Escala News 2:'), 0, 0, 'l');
                $pdf->SetX(150);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, utf8_decode(self::$seguimientoCovid->escalanews2 == 'null'?self::$seguimientoCovid->escalanews2:"No Aplica"), 0, 0, 'l');
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('¿Ha Presentado Fiebre mayor a 30 grados en las ultimas horas?'), 0, 0, 'l');
                $pdf->SetX(99);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, self::$seguimientoCovid->ha_presentado_fiebre, 0, 0, 'l');
                $pdf->SetX(110);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('¿Ha presentado tos en las ultimas horas?'), 0, 0, 'l');
                $pdf->SetX(192);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, self::$seguimientoCovid->ha_presentado_tos, 0, 0, 'l');
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('¿Ha presentado dificultad respiratoria en las ultimas horas?'), 0, 0, 'l');
                $pdf->SetX(99);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, self::$seguimientoCovid->ha_presentado_dificultad_respiratoria, 0, 0, 'l');
                $pdf->SetX(110);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('¿Ha presentado dolor de garganta en las ultimas horas?'), 0, 0, 'l');
                $pdf->SetX(192);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, self::$seguimientoCovid->ha_presentado_dolor_garganta, 0, 0, 'l');
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('¿Ha presentado fatiga en las ultimas horas?'), 0, 0, 'l');
                $pdf->SetX(99);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, self::$seguimientoCovid->ha_presentado_fatiga, 0, 0, 'l');
                $pdf->SetX(110);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('¿Ha presentado cefalea en las ultimas horas?'), 0, 0, 'l');
                $pdf->SetX(192);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, self::$seguimientoCovid->ha_presentado_cefalea, 0, 0, 'l');
                $pdf->Ln();
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('¿Que otros sintomas ha presentado?'), 0, 0, 'l');
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, self::$seguimientoCovid->que_otros_sintomas, 0, 0, 'l');
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('¿Ha presentado signos o sintomas de alarma?'), 0, 0, 'l');
                $pdf->SetX(99);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, self::$seguimientoCovid->ha_presentado_sintomas_alarma, 0, 0, 'l');
                $pdf->Ln();
                $posicionActual = $pdf->GetY();
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', 'B',10);
                $pdf->Cell(195, 6, utf8_decode('Signos o sintomas de alarma'), 0, 0, 'l');
                $pdf->SetLineWidth(0.5);
                $pdf->Line(8, $posicionActual+13, 203, $posicionActual+13);
                $pdf->SetLineWidth(0.2);
                $pdf->Ln();
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetFillColor(1, 22, 137);
                $pdf->SetTextColor(255,255,255);
                $pdf->Cell(65, 5, utf8_decode('Signo/Sintoma'), 0, 0, 'l',1);
                $pdf->Cell(27, 5, utf8_decode('¿Se Presentó?'), 0, 0, 'l',1);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetX(110);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetFillColor(1, 22, 137);
                $pdf->SetTextColor(255,255,255);
                $pdf->Cell(65, 5, utf8_decode('Signo/Sintoma'), 0, 0, 'l',1);
                $pdf->Cell(27, 5, utf8_decode('¿Se Presentó?'), 0, 0, 'l',1);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetDrawColor(0,0,0);
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetFillColor(240, 240, 240);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(65, 5, utf8_decode('Detalles signos alarmas'), 0, 0, 'l',1);
                //$pdf->Cell(27, 5, self::$seguimientoCovid->detalles_signos_alarmas === 'x'?'SI':'NO', 0, 0, 'l',1);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetX(110);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetFillColor(240, 240, 240);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(65, 5, utf8_decode('Respiración rapida taquipnea'), 0, 0, 'l',1);
                //$pdf->Cell(27, 5, self::$seguimientoCovid->respiracion_rapida_taquipnea === 'x'?'SI':'NO', 0, 0, 'l',1);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetDrawColor(0,0,0);
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(65, 5, utf8_decode('Fiebre por mas de 2 dias'), 0, 0, 'l');
                //$pdf->Cell(27, 5, self::$seguimientoCovid->fiebre_mas_2_dias === 'x'?'SI':'NO', 0, 0, 'l');
                $pdf->SetX(110);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(65, 5, utf8_decode('Pecho con sonido sibilancias'), 0, 0, 'l');
                //$pdf->Cell(27, 5, self::$seguimientoCovid->pecho_suena_sibilancias === 'x'?'SI':'NO', 0, 0, 'l');
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetFillColor(240, 240, 240);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(65, 5, utf8_decode('Somnolencias letargia'), 0, 0, 'l',1);
                //$pdf->Cell(27, 5, self::$seguimientoCovid->somnolencia_letargia === 'x'?'SI':'NO', 0, 0, 'l',1);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetX(110);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetFillColor(240, 240, 240);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(65, 5, utf8_decode('Convulsiones'), 0, 0, 'l',1);
                //$pdf->Cell(27, 5, self::$seguimientoCovid->convulsiones === 'x'?'SI':'NO', 0, 0, 'l',1);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetDrawColor(0,0,0);
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(65, 5, utf8_decode('Deterioro rapido del estado general'), 0, 0, 'l');
                //$pdf->Cell(27, 5, self::$seguimientoCovid->deterioro_rapido_estado_general === 'x'?'SI':'NO', 0, 0, 'l');
                $posicionActual = $pdf->GetY();
                $pdf->Ln();
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', 'B',10);
                $pdf->Cell(195, 6, utf8_decode('Otra Información de Interes'), 0, 0, 'l');
                $pdf->SetLineWidth(0.5);
                //$pdf->Line(8, $posicionActual+18, 203, $posicionActual+18);
                $pdf->SetLineWidth(0.2);
                $pdf->Ln();
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('¿Se encuentra registradro en SEGCOVID?:'), 0, 0, 'l');
                $pdf->SetX(80);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, self::$seguimientoCovid->registrado_segcovid, 0, 0, 'l');
                $pdf->SetX(110);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('¿Se ha realizado pruebas para Dx COVID?:'), 0, 0, 'l');
                $pdf->SetX(170);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, self::$seguimientoCovid->pruebas_diagnostico_covid, 0, 0, 'l');
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('Tipo de prueba Dx para COVID:'), 0, 0, 'l');
                $pdf->SetX(70);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, utf8_decode(self::$seguimientoCovid->tipo_prueba_diagnostica_covid), 0, 0, 'l');
                $pdf->SetX(110);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('Resultados de la prueba COVID:'), 0, 0, 'l');
                $pdf->SetX(160);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, utf8_decode(self::$seguimientoCovid->resultado_pruebas), 0, 0, 'l');
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('Causa del seguimiento:'), 0, 0, 'l');
                $pdf->SetX(45);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, utf8_decode(self::$seguimientoCovid->causaseguimiento), 0, 0, 'l');
                $pdf->SetX(110);
                $pdf->SetFont('Arial', '',9);
                $pdf->Cell(195, 5, utf8_decode('Tipo de seguimiento:'), 0, 0, 'l');
                $pdf->SetX(150);
                $pdf->SetFont('Arial', 'B',9);
                //$pdf->Cell(20, 5, utf8_decode(self::$seguimientoCovid->tiposeguimiento), 0, 0, 'l');
                $posicionActual = $pdf->GetY();
                $pdf->Ln();
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', 'B',10);
                $pdf->Cell(195, 6, utf8_decode('Observaciones del seguimiento'), 0, 0, 'l');
                $pdf->SetLineWidth(0.5);
                $pdf->Line(8, $posicionActual+18, 203, $posicionActual+18);
                $pdf->SetLineWidth(0.2);
                $pdf->Ln();
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '',9);
                //$pdf->MultiCell(195, 5, utf8_decode(self::$seguimientoCovid->observaciones), 0, 'J');
                $pdf->Ln();
                $posicionActual = $pdf->GetY();
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', 'B',10);
                $pdf->Cell(195, 6, utf8_decode('¿Indicaciones?'), 0, 0, 'l');
                $pdf->SetLineWidth(0.5);
                //$pdf->Line(8, $posicionActual+13, 203, $posicionActual+13);
                $pdf->SetLineWidth(0.2);
                $pdf->Ln();
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', 'B', 10);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetFillColor(1, 22, 137);
                $pdf->SetTextColor(255,255,255);
                $pdf->Cell(195, 5, utf8_decode('Indicacion'), 0, 0, 'l',1);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetDrawColor(0,0,0);
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetFillColor(240, 240, 240);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(168, 5, utf8_decode('Se recomienda esperar en casa y se informa signos y sintomas de alarma'), 0, 0, 'l',1);
                //$pdf->Cell(27, 5, self::$seguimientoCovid->esperarencasa === 'x'?'SI':'NO', 0, 0, 'l',1);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetDrawColor(0,0,0);
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(168, 5, utf8_decode('Teleorientacion Salud Mental'), 0, 0, 'l');
                //$pdf->Cell(27, 5, self::$seguimientoCovid->teleorientacion === 'x'?'SI':'NO', 0, 0, 'l');
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetFillColor(240, 240, 240);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(168, 5, utf8_decode('Se asigna Consulta Medica'), 0, 0, 'l',1);
                //$pdf->Cell(27, 5, self::$seguimientoCovid->asignarconsulta === 'x'?'SI':'NO', 0, 0, 'l',1);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetDrawColor(0,0,0);
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(168, 5, utf8_decode('Concentrador de oxigeno'), 0, 0, 'l');
                //$pdf->Cell(27, 5, self::$seguimientoCovid->concentracionoxigeno === 'x'?'SI':'NO', 0, 0, 'l');
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetFillColor(240, 240, 240);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(168, 5, utf8_decode('Se requiere consulta Prioritaria'), 0, 0, 'l',1);
                //$pdf->Cell(27, 5, self::$seguimientoCovid->consultaprioritaria === 'x'?'SI':'NO', 0, 0, 'l',1);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetDrawColor(0,0,0);
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(168, 5, utf8_decode('Se realiza seguimiento telefonico para confirmacion de estado de salud'), 0, 0, 'l');
                //$pdf->Cell(27, 5, self::$seguimientoCovid->seguimientotelefonico === 'x'?'SI':'NO', 0, 0, 'l');
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetFillColor(240, 240, 240);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetFont('Arial', '', 9);
                $pdf->Cell(168, 5, utf8_decode('Otro'), 0, 0, 'l',1);
                //$pdf->Cell(27, 5, self::$seguimientoCovid->otrasindicaciones === 'x'?'SI':'NO', 0, 0, 'l',1);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetDrawColor(0,0,0);
                $pdf->Ln();
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', 'B',10);
                $pdf->SetDrawColor(0,0,0);
                $pdf->SetFillColor(1, 22, 137);
                $pdf->SetTextColor(255,255,255);
                $pdf->Cell(195, 6, utf8_decode('Información del profesional que realizo el seguimiento'), 0, 0, 'l',1);
                $pdf->SetTextColor(0,0,0);
                $pdf->SetDrawColor(0,0,0);
                $pdf->Ln();
                $posicionActual = $pdf->GetY();
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', 'B',12);
               //$pdf->Cell(195, 6, self::$medicoatiendeSeguimiento->name.' '.self::$medicoatiendeSeguimiento->apellido, 0, 0, 'l');
                $pdf->SetLineWidth(0.5);
                //$pdf->Line(8, $posicionActual+13, 203, $posicionActual+13);
                $pdf->SetLineWidth(0.2);
                $pdf->Ln();
                $pdf->SetX(8);
                $pdf->SetFont('Arial', '',9);
                //$pdf->Cell(70, 6, (self::$medicoatiendeSeguimiento->nit.' '.self::$medicoatiendeSeguimiento->cedula), 0, 0, 'l');
                //$pdf->Cell(70, 6, self::$medicoatiendeSeguimiento->especialidad_medico, 0, 0, 'l');
                //$pdf->Cell(90, 6, utf8_decode('Registro: '.self::$medicoatiendeSeguimiento->Registromedico), 0, 0, 'l');
                $posicionActual = $pdf->GetY();
                $pdf->Ln();
                // if(self::$medicoatiendeSeguimiento->Firma){
                //     if (file_exists(storage_path(substr(self::$medicoatiendeSeguimiento->Firma, 9)))) {
                //         $pdf->Image(storage_path(substr(self::$medicoatiendeSeguimiento->Firma, 9)), 70, $posicionActual+13, 56, 11);
                //     }
                // }
                // if($posicionActual > 225){
                //     $pdf->AddPage();
                // }

            //}
    }
}
