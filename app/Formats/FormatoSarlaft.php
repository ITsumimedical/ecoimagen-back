<?php
namespace App\Formats;

use App\Http\Modules\ActividadInternacional\Models\ActividadInternacional;
use App\Http\Modules\DeclaracionFondos\Models\DeclaracionFondo;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Http\Modules\Usuarios\Models\User;

use App\Http\Modules\Sarlaft\Models\Sarlaft;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\Departamentos\Models\Departamento;
use App\Http\Modules\InformacionFinanciera\Models\InformacionFinanciera;
use App\Http\Modules\PersonalExpuesto\Models\PersonalExpuesto;
use App\Http\Modules\RepresentanteLegal\Models\RepresentanteLegal;
use App\Http\Modules\Socios\Models\Socios;

class FormatoSarlaft extends FPDF
{
    public static $sarlaf;
    public static $usuario;
    public static $departamento;
    public static $representanteLegal;
    public static $municipioReprelegal;
    public static $municipioReprelegalLugarNacimiento;
    public static $municipioReprelegalciudadReci;
    public static $departamentoRecidencia;
    public static $socios;
    public static $personaExpuesta;
    public static $informacionFinanciera;
    public static $actividadesInternacionales;
    public static $declaracionFondos;

    public function generar($id)
    {
        self::$sarlaf = Sarlaft::find($id);
        self::$usuario = User::find(self::$sarlaf->user_id);
        self::$departamento = Departamento::find(self::$sarlaf->departamento_id);
        self::$representanteLegal = RepresentanteLegal::where('sarlaft_id',self::$sarlaf->id)->first();
        self::$municipioReprelegal = Municipio::find(self::$representanteLegal->lugar_expedicion_id);
        self::$municipioReprelegalLugarNacimiento = Municipio::find(self::$representanteLegal->lugar_nacimiento_id);
        self::$municipioReprelegalciudadReci = Municipio::find(self::$representanteLegal->ciudad_recidencia_id);
        self::$departamentoRecidencia = Departamento::find(self::$representanteLegal->deparamento_recidencia_id);
        self::$socios = Socios::where('sarlaft_id',self::$sarlaf->id)->get();
        self::$personaExpuesta = PersonalExpuesto::where('sarlaft_id',self::$sarlaf->id)->get();
        self::$informacionFinanciera = InformacionFinanciera::where('sarlaft_id',self::$sarlaf->id)->first();
        self::$actividadesInternacionales = ActividadInternacional::where('sarlaft_id',self::$sarlaf->id)->first();
        self::$declaracionFondos = DeclaracionFondo::where('sarlaft_id',self::$sarlaf->id)->first();

        $pdf= new FormatoSarlaft('p', 'mm', 'A4');
        $pdf->AliasNbPages();
        $pdf->AddPage();
        $this->body($pdf);
        $pdf->Output();
    }

    public function body($pdf)
    {
        $Y = 40;
        #IMAGEN Y DATOS EMPRESARIALES
        $pdf->SetFont('Arial', 'B', 9);
        $logo = public_path() . "/images/logo.png";
        $pdf->Image($logo, 13, 10, -235);
        #NIT
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(12, 37);
        $pdf->Cell(35, 3, utf8_decode('NIT:900033371-4 Res: 004'), 0, 0, 'L');
        $pdf->Ln();
        $pdf->Cell(45, 3, utf8_decode('FO-SA-001'), 0, 0, 'C');
        #LOGO FINAL HOJA 1
        $logo = "fpdf\Imag\LOGO FINAL.jpg";
        // $pdf->Image($logo, 0, 291, -95);

        #MARGENES HOJA 1
        $pdf->Line(5, 65, 5, 279);
        $pdf->Line(205, 65, 205, 279);
        $pdf->Line(5, 279, 205, 279);

        $pdf->SetXY(115, 18);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(30, 4, utf8_decode('FORMULARIO DE CONOCIMIENTO'), 0, 0, 'C');
        $pdf->SetXY(115, 24);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->Cell(30, 4, utf8_decode('DEL'), 0, 0, 'C');
        $pdf->SetXY(100, 30);
        $pdf->SetFont('Arial', 'B', 15);
        $pdf->MultiCell(60, 4, utf8_decode(self::$sarlaf->tipo_cliente === 'Proveedor'?'PROVEEDOR':'CLIENTE'), 0, 'C');
        $pdf->SetXY(100, 30);
        $pdf->MultiCell(60, 4, utf8_decode(self::$sarlaf->tipo_cliente === 'Cliente Usuario Particular'?'CLIENTE USUARIO PARTICULAR':''), 0, 'C');
        $pdf->Ln();

        $pdf->SetXY(6,56);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(53, 4, utf8_decode('Fecha y hora de diligenciamiento:'), 0, 0, 'L');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(30, 4, utf8_decode(self::$sarlaf->created_at), 0, 'l');
        $pdf->Ln();

        $pdf->SetXY(96,56);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(44, 4, utf8_decode('Nombre de quien Diligencia:'), 0, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(80, 4, utf8_decode(self::$sarlaf->nombre_diligencia), 0, 'l');

        $pdf->SetXY(6,60);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(45, 4, utf8_decode('Numero de Identificacion:'), 0, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(20, 4, utf8_decode(self::$sarlaf->cedula_diligencia), 0, 'l');

        $pdf->SetXY(96,60);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(12, 4, utf8_decode('Cargo:'), 0, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->MultiCell(80, 4, utf8_decode(self::$sarlaf->cargo_diligencia), 0, 'l');

        $pdf->SetX(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(200, 4, utf8_decode('1. INFORMACIÓN GENERAL'), 1, 0, 'C',1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0,0,0);
        $pdf->Ln();

        $pdf->SetX(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(200, 4, utf8_decode('PERSONA JURÍDICA / NATURAL'), 1, 0, 'C',1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0,0,0);
        $pdf->Ln();

        // $pdf->SetX(5);
        // $pdf->SetFont('Arial', 'B', 8);
        // $pdf->Cell(40, 4, utf8_decode('Tipo de documento:'), 1, 0, 'l');
        // $pdf->SetFont('Arial', '', 8);
        // $pdf->Cell(62, 4, utf8_decode(self::$usuario->nit), 1, 'l');
        // $pdf->SetFont('Arial', 'B', 8);
        // $pdf->Cell(20, 4, utf8_decode('Número:'), 1, 0, 'l');
        // $pdf->SetFont('Arial', '', 8);
        // $pdf->Cell(78, 4, utf8_decode(self::$usuario->cedula), 1, 'l');
        // $pdf->Ln();

        // $pdf->SetX(5);
        // $pdf->SetFont('Arial', 'B', 8);
        // $pdf->Cell(40, 4, utf8_decode('Nombre / Razón social:'), 1, 0, 'l');
        // $pdf->SetFont('Arial', '', 8);
        // $pdf->Cell(160, 4, utf8_decode(self::$usuario->name.' '.self::$usuario->apellido),1, 'l');
        // $pdf->Ln();

        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 4, utf8_decode('Clase:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(62, 4, utf8_decode(self::$sarlaf->clase), 1, 'l');
        $pdf->SetXY(107,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(20, 4, utf8_decode('Sector:'), 1, 0, 'l');
        $pdf->SetXY(127,$y);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(78, 4, utf8_decode(self::$sarlaf->sector), 1, 'l');

        $pdf->SetX(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(15, 4, utf8_decode('¿Cual?'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(185, 4, utf8_decode(self::$sarlaf->cual_descripcion), 1, 'l');

        $pdf->SetX(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(55, 4, utf8_decode('Tipo bien/servicio a adquirir o proveer:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(145, 4, utf8_decode(self::$sarlaf->tipo_bienservicio),1, 'l');


        $pdf->SetX(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 4, utf8_decode('Dirección principal: '), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(160, 4, utf8_decode(self::$sarlaf->direccion),1, 'l');

        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 4, utf8_decode('Departamento:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(62, 4, utf8_decode(self::$departamento->nombre), 1, 'l');
        $pdf->SetXY(107,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 4, utf8_decode('Correo Electrónico:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(68, 4, utf8_decode(self::$sarlaf->email_empresa), 1, 'l');


        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 4, utf8_decode('Teléfono de la empresa:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(62, 4, utf8_decode(self::$sarlaf->telefono_empresa), 1, 'l');
        $pdf->SetXY(107,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 4, utf8_decode('FAX:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(68, 4, utf8_decode(self::$sarlaf->fax), 1, 'l');


        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 4, utf8_decode('Numero de contacto:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(160, 4, utf8_decode(self::$sarlaf->numero_contacto),1, 'l');



         if(self::$sarlaf->tipo_cliente === 'Cliente Usuario Particular'){
            $pdf->SetX(5);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(200, 4, utf8_decode('REPRESENTANTE LEGAL'), 1, 0, 'C',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
          } else {
            $pdf->SetX(5);
            $pdf->SetFont('Arial', 'B', 9);
            $pdf->SetDrawColor(0,0,0);
            $pdf->SetFillColor(214, 214, 214);
            $pdf->SetTextColor(0,0,0);
            $pdf->Cell(200, 4, utf8_decode('PERSONA NATURAL'), 1, 0, 'C',1);
            $pdf->SetTextColor(0,0,0);
            $pdf->SetDrawColor(0,0,0);
            $pdf->Ln();
         }

        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(32, 4, utf8_decode('Nombre completo:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(70, 4, utf8_decode(self::$representanteLegal->nombre), 1, 'l');
        $pdf->SetXY(107,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 4, utf8_decode('Tipo de documento:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(68, 4, utf8_decode(self::$representanteLegal->tipo_doc), 1, 'l');


        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(32, 4, utf8_decode('Número:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(33, 4, utf8_decode(self::$representanteLegal->num_doc), 1, 'l');
        $pdf->SetXY(70,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(32, 4, utf8_decode('Fecha de Expedición:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(33, 4, utf8_decode(self::$representanteLegal->fecha_exp), 1, 'l');
        $pdf->SetXY(135,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(32, 4, utf8_decode('Lugar de Expedición:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(38, 4, utf8_decode(self::$municipioReprelegal->nombre), 1, 'l');


        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(32, 4, utf8_decode('Fecha de nacimiento:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(33, 4, utf8_decode(self::$representanteLegal->fecha_nac), 1, 'l');
        $pdf->SetXY(70,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(32, 4, utf8_decode('Lugar de nacimiento:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(33, 4, utf8_decode(self::$municipioReprelegalLugarNacimiento->nombre), 1, 'l');
        $pdf->SetXY(135,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(32, 4, utf8_decode('Otra nacionalidad:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(38, 4, utf8_decode(self::$representanteLegal->otra_nacionalidad), 1, 'l');


        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(40, 4, utf8_decode('Correo electrónico:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(62, 4, utf8_decode(self::$representanteLegal->emali), 1, 'l');
        $pdf->SetXY(107,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(32, 4, utf8_decode('Ciudad de residencia:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(66, 4, utf8_decode(self::$municipioReprelegalciudadReci->nombre), 1, 'l');


        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(32, 4, utf8_decode('Depar. de residencia:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(33, 4, utf8_decode(self::$departamentoRecidencia->nombre), 1, 'l');
        $pdf->SetXY(70,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(32, 4, utf8_decode('País de residencia:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(33, 4, utf8_decode(self::$representanteLegal->pais_reci), 1, 'l');
        $pdf->SetXY(135,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(32, 4, utf8_decode('Número de contacto:'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(38, 4, utf8_decode(self::$representanteLegal->telefono), 1, 'l');
        $pdf->Ln();
        $pdf->Ln();

        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(150, 4, utf8_decode('¿Por su cargo o actividad maneja recursos públicos?'), 0, 0, 'l');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 4, utf8_decode('SI'), 0, 0, 'l');
        $pdf->Cell(5, 4, utf8_decode(self::$representanteLegal->cargo_publico == 1?'X':''),1, 'C');
        $pdf->SetXY(170,$y);
        $pdf->Cell(7, 4, utf8_decode('NO'), 0, 0, 'l');
        $pdf->Cell(5, 4, utf8_decode(self::$representanteLegal->cargo_publico == 0?'X':''),1, 'C');
        $pdf->Ln();

        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(150, 4, utf8_decode('¿Por su cargo o actividad ejerce algún poder público?'), 0, 0, 'l');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 4, utf8_decode('SI'), 0, 0, 'l');
        $pdf->Cell(5, 4, utf8_decode(self::$representanteLegal->poder_publico == 1?'X':''),1, 'C');
        $pdf->SetXY(170,$y);
        $pdf->Cell(7, 4, utf8_decode('NO'), 0, 0, 'l');
        $pdf->Cell(5, 4, utf8_decode(self::$representanteLegal->poder_publico == 0?'X':''),1, 'C');
        $pdf->Ln();

        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(150, 4, utf8_decode('¿Por su actividad u oficio, goza usted de reconocimiento público general?'), 0, 0, 'l');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 4, utf8_decode('SI'), 0, 0, 'l');
        $pdf->Cell(5, 4, utf8_decode(self::$representanteLegal->reconocimento_publico == 1?'X':''),1, 'C');
        $pdf->SetXY(170,$y);
        $pdf->Cell(7, 4, utf8_decode('NO'), 0, 0, 'l');
        $pdf->Cell(5, 4, utf8_decode(self::$representanteLegal->reconocimento_publico == 0?'X':''),1, 'C');
        $pdf->Ln();

        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(150, 4, utf8_decode('¿Es usted sujeto de obligaciones tributarias en otro país o grupo de países?'), 0, 0, 'l');
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(5, 4, utf8_decode('SI'), 0, 0, 'l');
        $pdf->Cell(5, 4, utf8_decode(self::$representanteLegal->obli_tibutarias == 1?'X':''),1, 'C');
        $pdf->SetXY(170,$y);
        $pdf->Cell(7, 4, utf8_decode('NO'), 0, 0, 'l');
        $pdf->Cell(5, 4, utf8_decode(self::$representanteLegal->obli_tibutarias == 0?'X':''),1, 'C');
        $pdf->Ln();

        $pdf->SetX(5);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(30, 4, utf8_decode('Indique el país:'), 0, 0, 'l');
        $pdf->Cell(145, 4, utf8_decode(self::$representanteLegal->descripcion_obliga), 0, 'l');
        $pdf->Ln();

        $pdf->SetX(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(200, 4, utf8_decode('2. IDENTIFICACIÓN DE LOS SOCIOS, ACCIONISTAS O ASOCIADOS'), 1, 0, 'C',1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0,0,0);
        $pdf->Ln();

        $pdf->SetX(5);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(200, 4, utf8_decode('Solo para aquellos que posean una participación mayor del 5%'), 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(45, 4, utf8_decode('Razón social o Nombre completo'), 1, 'C');
        $pdf->SetXY(50,$y);
        $pdf->Cell(30, 4, utf8_decode('Tipo de identificación'), 1, 'C');
        $pdf->SetXY(80,$y);
        $pdf->Cell(20, 4, utf8_decode('Número'), 1, 'C');
        $pdf->SetXY(100,$y);
        $pdf->Cell(20, 4, utf8_decode('% Participación'), 1, 'C');
        $pdf->SetXY(120,$y);
        $pdf->SetFont('Arial', 'B', 7);
        $pdf->Cell(85, 4, utf8_decode('¿Es persona públicamente expuesta, o vinculado con una de ellas?'), 1, 'C');


        if(self::$socios){
            foreach(self::$socios as $socio){
                $pdf->SetX(5);
                $y = $pdf->GetY();
                $pdf->SetFont('Arial', '', 8);
                $pdf->Cell(45, 4, utf8_decode(($socio->razon_social)), 1, 'l');
                $pdf->SetXY(50,$y);
                $pdf->Cell(30, 4, utf8_decode($socio->tipo_doc), 1, 'l');
                $pdf->SetXY(80,$y);
                $pdf->Cell(20, 4, utf8_decode($socio->num_doc), 1, 'l');
                $pdf->SetXY(100,$y);
                $pdf->Cell(20, 4, utf8_decode($socio->participacion.'%'), 1, 'l');
                // $pdf->SetXY(120,$y);
                // $pdf->Cell(85, 4, utf8_decode($socio->descripcion_expuevincula), 1, 'l');

                }
        }else{
            $pdf->SetX(5);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(45, 4, utf8_decode('N/A'), 1, 'l');
            $pdf->Cell(30, 4, utf8_decode('N/A'), 1, 'l');
            $pdf->Cell(20, 4, utf8_decode('N/A'), 1, 'l');
            $pdf->Cell(20, 4, utf8_decode('N/A'), 1, 'l');
            $pdf->Ln();
            }

        $pdf->SetX(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(200, 4, utf8_decode('Conocimiento mejorado de Personas Expuestas Públicamente'), 1, 0, 'C',1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0,0,0);
        $pdf->Ln();

        $pdf->SetX(5);
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(200, 4, utf8_decode('Teniendo en cuenta lo anterior, complete la siguiente información si aplica'), 1, 0, 'C');
        $pdf->Ln();

        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(60, 4, utf8_decode('Razón social o Nombre completo'), 1, 'C');
        $pdf->SetXY(65,$y);
        $pdf->Cell(35, 4, utf8_decode('Nacionalidad'), 1, 'C');
        $pdf->SetXY(100,$y);
        $pdf->Cell(40, 4, utf8_decode('Vinculo/Relación'), 1, 'C');
        $pdf->SetXY(140,$y);
        $pdf->Cell(30, 4, utf8_decode('Entidad'), 1,0, 'C');
        $pdf->SetXY(170,$y);
        $pdf->Cell(35, 4, utf8_decode('Cargo'), 1, 'C');
        // $pdf->Ln();

        if(self::$personaExpuesta){
            foreach(self::$personaExpuesta as $personaExpuesta){
            $pdf->SetX(5);
            $y = $pdf->GetY();
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(60, 4, utf8_decode($personaExpuesta->razon_social), 1, 'l');
            $pdf->SetXY(65,$y);
            $pdf->Cell(35, 4, utf8_decode($personaExpuesta->nacionalidad), 1, 'l');
            $pdf->SetXY(100,$y);
            $pdf->Cell(40, 4, utf8_decode($personaExpuesta->relacion), 1, 'l');
            $pdf->SetXY(140,$y);
            $pdf->Cell(30, 4, utf8_decode($personaExpuesta->entidad), 1, 'l');
            $pdf->SetXY(170,$y);
            $pdf->Cell(35, 4, utf8_decode($personaExpuesta->cargo), 1, 'l');

        }
        }else{
            $pdf->SetX(5);
            $pdf->SetFont('Arial', '', 8);
            $pdf->Cell(60, 4, utf8_decode('N/A'), 1, 'l');
            $pdf->Cell(35, 4, utf8_decode('N/A'), 1, 'l');
            $pdf->Cell(35, 4, utf8_decode('N/A'), 1, 'l');
            $pdf->Cell(35, 4, utf8_decode('N/A'), 1, 'l');
            $pdf->Cell(35, 4, utf8_decode('N/A'), 1, 'l');
            $pdf->Ln();
        }
        $pdf->SetX(5);

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(200, 4, utf8_decode('3. INFORMACIÓN FINACIERA'), 1, 0, 'C',1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0,0,0);
        $pdf->Ln();

        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(43, 4, utf8_decode('Total Activos (último balance)'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(57, 4, utf8_decode('$'.self::$informacionFinanciera->total_activos), 1, 'l');
        $pdf->SetXY(105,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(43, 4, utf8_decode('Total Pasivos (último balance)'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(57, 4, utf8_decode('$'.self::$informacionFinanciera->total_pasivos), 1, 'l');


        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(58, 4, utf8_decode('Ingresos Mensuales (promedio mensual)'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(42, 4, utf8_decode('$'.self::$informacionFinanciera->ingreso_mensual), 1, 'l');
        $pdf->SetXY(105,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(43, 4, utf8_decode('Otros ingresos'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(57, 4, utf8_decode('$'.self::$informacionFinanciera->otros_ingresos), 1, 'l');
        $pdf->Ln();

        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(43, 4, utf8_decode('Concepto'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(57, 4, utf8_decode(self::$informacionFinanciera->concepto_ingreso), 1, 'l');
        $pdf->SetXY(105,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(56, 4, utf8_decode('Egresos Mensuales (promedio mensual)'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(44, 4, utf8_decode('$'.self::$informacionFinanciera->egresos_mensuales), 1, 'l');


        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(43, 4, utf8_decode('Otros egresos'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(57, 4, utf8_decode('$'.self::$informacionFinanciera->otros_egresos), 1, 'l');
        $pdf->SetXY(105,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(43, 4, utf8_decode('Concepto'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(57, 4, utf8_decode(self::$informacionFinanciera->concepto_egreso), 1, 'l');

        $pdf->SetX(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(200, 4, utf8_decode('ACTIVIDADES EN OPERACIONALES INTERNACIONALES'), 1, 0, 'C',1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0,0,0);
        $pdf->Ln();

        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(65, 4, utf8_decode('¿Realiza transacciones en moneda extranjera?'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(35, 4, utf8_decode(self::$actividadesInternacionales->transa_monedaextr), 1, 'l');
        $pdf->SetXY(105,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(36, 4, utf8_decode('¿Cuál?'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(64, 4, utf8_decode(self::$actividadesInternacionales->cual_moneda), 1, 'l');

        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(65, 4, utf8_decode('Indique otras'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(35, 4, utf8_decode(self::$actividadesInternacionales->otra_moneda), 1, 'l');
        $pdf->SetXY(105,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(66, 4, utf8_decode('¿Posee productos financieros en el exterior?'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(34, 4, utf8_decode(self::$actividadesInternacionales->produc_extranjeros), 1, 'l');


        $pdf->SetX(5);
        $y = $pdf->GetY();
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(65, 4, utf8_decode('¿Posee cuentas en moneda extranjera?'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(35, 4, utf8_decode(self::$actividadesInternacionales->cual_prodc), 1, 'l');
        $pdf->SetXY(105,$y);
        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(47, 4, utf8_decode('País de operaciones extranjeras?'), 1, 0, 'l');
        $pdf->SetFont('Arial', '', 8);
        $pdf->Cell(53, 4, utf8_decode(self::$actividadesInternacionales->pais_operaciones), 1, 'l');

        $pdf->SetX(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(200, 4, utf8_decode('4. DECLARACIÓN DE ORIGEN DE FONDOS'), 1, 0, 'C',1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0,0,0);
        $pdf->Ln();

        $pdf->SetX(5);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(200, 4, utf8_decode('1. Los recursos que poseo provienen de las siguientes fuentes: (Detalle ocupación, oficio, actividad económica o negocio).'), 0, 'l');


        $pdf->SetX(7);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(196, 4, utf8_decode(self::$declaracionFondos->declaracion), 0, 'l');
        $pdf->Ln();

        $pdf->SetX(5);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(200, 4, utf8_decode('2. Tanto mi actividad, profesión u oficio es licita y la ejerzo dentro del marco legal y los recursos que poseo no provienen de actividades ilícitas de las contempladas en el Código Penal Colombiano.'), 0, 'J');
        $pdf->SetX(5);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(200, 4, utf8_decode('3. La información que he suministrado en la solicitud y en este documento es veraz y verificable y me obligo a actualizarla anualmente.'), 0, 'J');
        $pdf->SetX(5);
        $pdf->SetFont('Arial', '', 10);
        $pdf->MultiCell(200, 4, utf8_decode('4. Autorizo a Sumimedical SAS para solicitar, consultar, procesar, suministrar, reportar o divulgar a cualquier entidad con la que mantenga una relación comercial vigente o que se encuentre debidamente autorizada para manejar o administrar bases de datos, incluidas las entidades gubernamentales, la información contenida en este Formulario. De igual forma, autorizo a Sumimedical SAS a realizar la debida validación en listas restrictivas tanto nacionales como internacionales.'), 0, 'J');
        $pdf->Ln();

        $pdf->SetX(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(200, 4, utf8_decode('5. AUTORIZACIÓN TRATAMIENTO DE DATOS PERSONALES'), 1, 0, 'C',1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0,0,0);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetX(5);
        $pdf->MultiCell(200, 4, utf8_decode('"Declaro de manera libre, expresa, inequívoca e informada, que AUTORIZO a SUMIMEDICAL SAS para que, en los términos del literal a) del artículo 6 de la Ley 1581 de 2012, realice la recolección, almacenamiento, uso, circulación, supresión, y en general, tratamiento de mis datos personales, incluyendo datos sensibles, de conformidad con la Ley y que se obtengan en la ejecución de la relación contractual.'), 0, 'J');
        $pdf->SetX(5);
        $pdf->MultiCell(200, 4, utf8_decode('Así mismo conozco que estoy facultado para conocer, actualizar y rectificar los datos personales recolectados por Sumimedical SAS de conformidad con lo establecido en la Política de Tratamiento y Protección de Datos Personales de Sumimedical SAS."'), 0, 'J');
        $pdf->Ln();
        $pdf->SetX(5);
        $pdf->SetFont('Arial', 'B', 9);
        $pdf->SetDrawColor(0,0,0);
        $pdf->SetFillColor(214, 214, 214);
        $pdf->SetTextColor(0,0,0);
        $pdf->Cell(200, 4, utf8_decode('6. FIRMA Y HUELLA'), 1, 0, 'C',1);
        $pdf->SetTextColor(0,0,0);
        $pdf->SetDrawColor(0,0,0);
        $pdf->Ln();

        $pdf->SetFont('Arial', '', 10);
        $pdf->SetX(5);
        $pdf->MultiCell(200, 4, utf8_decode('Como constancia de haber leído, entendido y aceptado lo anterior, declaro que la información que he suministrado es exacta en todas sus partes y firmo el siguiente documento:'), 0, 'J');
        $pdf->Ln();

        $pdf->Line(40, 160, 105, 160);
        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(41,161);
        $pdf->MultiCell(175, 4, utf8_decode('FIRMA DEL REPRESENTANTE LEGAL'), 0, 'J');

        $pdf->Line(140, 110, 172, 110);
        $pdf->Line(140, 110, 140, 145);
        $pdf->Line(172, 110, 172, 145);
        $pdf->Line(140, 145, 172, 145);

        #MARGENES HOJA 2
        $pdf->Line(5, 8, 205, 8);
        $pdf->Line(5, 8, 5, 279);
        $pdf->Line(205, 8, 205, 279);
        $pdf->Line(5, 279, 205, 279);


        $pdf->SetFont('Arial', '', 9);
        $pdf->SetXY(149,145);
        $pdf->MultiCell(175, 4, utf8_decode('HUELLA'), 0, 'J');
    }
}
