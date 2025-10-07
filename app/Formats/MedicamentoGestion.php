<?php
namespace App\Formats;

use DNS2D;
use Codedge\Fpdf\Fpdf\Fpdf;
use Carbon\Carbon;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Bodegas\Models\Bodega;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Municipios\Models\Municipio;
use App\Http\Modules\Cie10Afiliado\Models\Cie10Afiliado;
use App\Http\Modules\Ordenamiento\Models\OrdenArticulo;

class MedicamentoGestion extends Fpdf
{
    var $angle=0;
    public static $data;
    public static $afiliado;
    public static $orden;
    public static $tipoMensaje;
    public static $qr;
    public static $consulta;
    public static $medico;


    public function generar($data,$tipoMensaje){

        $pdf = new MedicamentoGestion('p', 'mm', 'A4');
        self::$data = $data;
        self::$afiliado = Afiliado::where('numero_documento',$data["numero_documento"])->first();
        self::$orden = Orden::find($data["orden_id"]);
        self::$tipoMensaje   = ($data['mensaje'] ?''. $data['mensaje']:$tipoMensaje);
        $path = 'tempimg.png';
        $dataURI = "data:image/png;base64," . DNS2D::getBarcodePNG((string) self::$orden->id .'-'. self::$afiliado->numero_documento,'QRCODE');
        $dataPieces = explode(',', $dataURI);
        $encodedImg = $dataPieces[1];
        $decodedImg = base64_decode($encodedImg);
        file_put_contents($path, $decodedImg);
        self::$qr =$path;
        $pdf->AliasNbPages();
        $pdf->AddPage();
        if(self::$afiliado->entidad_id == 1 || self::$afiliado->entidad_id == 3 || self::$afiliado->entidad_id == 5){
            $this->Body($pdf);
        }elseif(self::$afiliado->entidad_id == 2 && isset($data["medicamentos"][0]["Estado_id"]) && $tipoMensaje == "F O R M U L A  M E D I C A"){
            $this->BodyEntidad($pdf);
        }elseif(self::$afiliado->entidad_id == 2 && isset($data["medicamentos"][0]["Estado_id"]) && $tipoMensaje == "N O  C O N V E N I O"){
            $this->BodyEntidadNoConvenio($pdf);
        }elseif(self::$afiliado->entidad_id == 2 && isset($data["medicamentos"][0]["Estado_id"]) && $tipoMensaje == "M I P R E S"){
            $this->BodyEntidadMypress($pdf);
        }
        $pdf->Output();
    }

    public function header(){
        $this->SetFont('Arial','B',50);
        $this->SetTextColor(255,192,203);
        $this->RotatedText(12,134,self::$tipoMensaje,33);
        $this->SetTextColor(0,0,0);
        self::$consulta = Consulta::find(self::$orden->consulta_id);
        $usuario = User::find(self::$orden->user_id);
        self::$medico = Empleado::where('user_id',$usuario->id)->first();
        $rep = Rep::find(self::$afiliado->ips_id);
        $tipo = "Consulta medica";
        if(self::$consulta->tipo_consulta_id == 1){
            $tipo = "Transcripcion";
        }
        $this->SetFont('Arial','I',10);
        $this->SetTextColor(251,44,0);
        $this->TextWithDirection(207, 55, utf8_decode($tipo), 'U');
        $this->SetTextColor(0,0,0);

        $this->SetFont('Arial', 'B', 7);
        $this->TextWithDirection(207, 25, 'Orden: ' .self::$orden->paginacion, 'U');

        $cie10 = Cie10Afiliado::select('cie10s.codigo_cie10')->join('cie10s','cie10s.id','cie10_afiliados.cie10_id')->where('cie10_afiliados.consulta_id',self::$consulta->id)->get()->toArray();

        // if(self::$afiliado->entidad_id == 1 || self::$afiliado->entidad_id == 3 || self::$afiliado->entidad_id == 5){
        //     if(self::$orden->rep_id){
        //         $rep[0] = Rep::find(self::$orden->rep_id);
        //     }else{

        //     }

        //     $bodega = Bodega::where('nombre',$rep[0]->nombre)->first();
        //     if($bodega){
        //         $ubicacion = Municipio::select([
        //             "municipios.nombre as Municipio",
        //             "d.nombre as Departamento"
        //         ])
        //             ->join('departamentos as d','d.id','municipios.departamento_id')
        //             ->where('municipios.id',$bodega->municipio_id)
        //             ->first();
        //     }else{
        //         $bodega = Rep::select([
        //             'reps.nombre',
        //             'reps.direccion',
        //             'reps.telefono1 as Telefono',
        //             'reps.municipio_id'
        //         ])
        //             ->where('reps.nombre',$rep[0]->nombre)
        //             ->first();
        //             $ubicacion = Municipio::select([
        //                 "municipios.nombre as Municipio",
        //                 "d.nombre as Departamento"
        //             ])
        //                 ->join('departamentos as d','d.id','municipios.departamento_id')
        //                 ->where('municipios.id',$bodega->municipio_id)
        //                 ->first();
        //     }
        // }


        $Y               = 12;
        $this->SetFont('Arial', 'B', 9);
        $logo = public_path() . "/images/logoFomag.png";
        $this->Image($logo, 8, 7, -470);
        $this->Rect(5, 5, 30, 22);
        $this->Rect(35, 5, 60, 22);
        $this->SetXY(35, 9);
        $this->Cell(60, 4, utf8_decode('Fondo Nacional de'), 0, 0, 'C');
        $this->SetXY(35, 12);
        $this->Cell(60, 4, utf8_decode('Prestaciones Sociales del Magisterio '), 0, 0, 'C');
        $this->SetXY(35, 15);
        $this->Cell(60, 4, utf8_decode('FOMAG  FIDUPREVISORA S.A'), 0, 0, 'C');
        $this->SetXY(35, $Y+6);
        $this->Cell(60, 4, utf8_decode('NIT: 830.053.105-3 '), 0, 0, 'C');
        $this->SetXY(35, $Y + 4);
        $this->SetFont('Arial','B',5);
        $Y = 12;
        $this->SetFont('Arial', 'B', 8);
        $this->Rect(95, 5, 70, 22);
        $this->SetXY(95, $Y);
        $this->Cell(88, 4, utf8_decode('Fecha de Autorizaciòn: ') . Carbon::parse(self::$data['fecha_orden'])->format("Y-m-d"), 0, 0, 'C');
        if(self::$tipoMensaje == "F O R M U L A  M E D I C A" || "M E D.  P E N D I E N T E S"){
            $this->SetXY(85, $Y + 9);
        if (self::$afiliado->entidad_id == 1) {
            $this->Cell(88, 4, utf8_decode("Régimen: Especial / Número de Prescripción: " . self::$orden->id), 0, 0, 'C');
        }else {
            $this->Cell(88, 4, utf8_decode("Régimen: ".self::$afiliado->tipo_categoria." / Número de Prescripción: " . self::$orden->id), 0, 0, 'C');
        }
        $this->Rect(165, 5, 38, 22);
            $this->SetXY(60, $Y + 6);
            // $this->Cell(88, 4, utf8_decode('Contrato: ' .self::$user->Ut), 0, 0, 'C');
            $this->Image(self::$qr, 175, 8, 21, 17);

        }else{
        $this->SetXY(115, $Y + 3);
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(88, 4, utf8_decode("Solicitud"), 0, 0, 'C');
        }
        $this->SetFillColor(216, 216, 216);
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(5, 28);
        if(self::$afiliado->entidad_id == 1){
            $this->Cell(124, 4, utf8_decode('Nombre Paciente'), 1, 0, 'C', 1);
        }else{
            $this->Cell(114, 4, utf8_decode('Nombre Paciente'), 1, 0, 'C', 1);
            $this->Cell(10, 4, utf8_decode('Nivel'), 1, 0, 'C', 1);
        }
        $this->Cell(10, 4, utf8_decode('Sexo'), 1, 0, 'C', 1);
        $this->Cell(34, 4, utf8_decode('Identificación'), 1, 0, 'C', 1);
        $this->Cell(10, 4, 'Edad', 1, 0, 'C', 1);
        $this->Cell(20, 4, 'Nacimiento', 1, 0, 'C', 1);
        $this->Ln();

        $this->SetX(5);
        $this->SetFont('Arial', '', 8);
        if(self::$afiliado->entidad_id == 1) {
            $this->Cell(124, 4, utf8_decode(self::$afiliado->primer_apellido." ".self::$afiliado->segundo_apellido." ".self::$afiliado->primer_nombre." ".self::$afiliado->segundo_nombre), 1, 0, 'C');
        }else{
            $this->Cell(114, 4, utf8_decode(self::$afiliado->primer_apellido." ".self::$afiliado->segundo_apellido." ".self::$afiliado->primer_nombre." ".self::$afiliado->segundo_nombre), 1, 0, 'C');
            $this->Cell(10, 4, utf8_decode(self::$afiliado->nivel), 1, 0, 'C');
        }
        $this->SetFont('Arial', '', 7.5);
        $this->Cell(10, 4, utf8_decode(self::$afiliado->sexo), 1, 0, 'C');
        $this->Cell(34, 4, utf8_decode(self::$afiliado->tipo_documento." ".self::$afiliado->numero_documento), 1, 0, 'C');
        $this->Cell(10, 4, self::$afiliado->edad_cumplida, 1, 0, 'C');
        $this->Cell(20, 4, substr(self::$afiliado->fecha_nacimiento,0,10), 1, 0, 'C');
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(59, 4, 'Direccion', 1, 0, 'C', 1);
        $this->Cell(59, 4, 'Telefono', 1, 0, 'C', 1);
        $this->Cell(40, 4, 'Correo', 1, 0, 'C', 1);
        $this->Cell(40, 4, 'Municipio', 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 7.5);
        $this->Cell(59, 4, utf8_decode(substr(self::$afiliado->direccion_Residencia_cargue, 0, 38)), 1, 0, 'C');
        $this->Cell(59, 4, utf8_decode(self::$afiliado->telefono) . " - " . utf8_decode(self::$afiliado->celular1), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode(self::$afiliado->correo1), 1, 0, 'C');
        $this->Cell(40, 4, 'Antioquia-Medellin', 1, 0, 'C');
        $this->Ln();

        if(self::$afiliado->entidad_id == 3){
            $this->SetX(5);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(108, 4, 'IPS Primaria', 1, 0, 'C', 1);
            $this->Cell(50, 4, 'Tipo Afiliado', 1, 0, 'C', 1);
            $this->Cell(40, 4, 'Plan', 1, 0, 'C', 1);
            $this->Ln();
            $this->SetX(5);
            $this->SetFont('Arial', '', 7.5);
            $this->Cell(108, 4, utf8_decode($rep->nombre), 1, 0, 'C');
            $this->Cell(50, 4, utf8_decode(self::$afiliado->TipoAfiliado->nombre) , 1, 0, 'C');
            $this->Cell(40, 4, utf8_decode(self::$afiliado->tipo_categoria), 1, 0, 'C');
                $this->SetXY(5,52);
            }else{
                $this->SetXY(5,44);
            }
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(59, 4, 'Punto de Entrega', 1, 0, 'C', 1);
            $this->Cell(55, 4, utf8_decode('Dirección'), 1, 0, 'C', 1);
            $this->Cell(39, 4, 'Telefono', 1, 0, 'C', 1);
            $this->Cell(45, 4, 'Municipio', 1, 0, 'C', 1);
            $this->Ln();
            $this->SetX(5);
            $this->SetFont('Arial', 'B', 7);

            if(self::$afiliado->entidad_id == 1 || self::$afiliado->entidad_id == 3 || self::$afiliado->entidad_id == 5){
                // $this->Cell(58, 4, utf8_decode($bodega->nombre), 1, 0, 'L');
                // $this->Cell(55, 4, utf8_decode($bodega->Direccion), 1, 0, 'C');
                // $this->Cell(40, 4, utf8_decode($bodega->Telefono), 1, 0, 'C');
                // $this->Cell(45, 4, utf8_decode($ubicacion->Departamento. "-" . $ubicacion->Municipio), 1, 0, 'C');
            }elseif(self::$afiliado->entidad_id == 2){
                $nombre = "";
                $direccion = "";
                $telefono = "";
                $municipio = "";
                switch (self::$afiliado->municipio_afiliacion_id){
                    case 13:
                        $nombre = "SERVICIO FARMACEUTICO COHAN";
                        $direccion = "Cll. 104 # 101 - 44 Sector Nueva Civilizacion";
                        $telefono = "6054949 ext 1";
                        $municipio = "APARTADÓ";
                        break;
                    case 27:
                        $nombre = "E.S.E. HOSPITAL SAN VICENTE DE PAUL";
                        $direccion = "Cll. 135 Sur # 48 - 19";
                        $telefono = "6054949 ext 1";
                        $municipio = "CALDAS";
                        break;
                    case 32:
                        $nombre = "HOSPITAL FRANCISCO LUIS JIMENEZ MARTINEZ";
                        $direccion = "Cll. 70 # 68 - 03 Urbanización Papagayo";
                        $telefono = "6054949 ext 1";
                        $municipio = "CAREPA";
                        break;
                    case 36:
                        $nombre = "HOSPITAL MARÍA AUXILIADORA";
                        $direccion = "Cra. 108A # 101A - 57";
                        $telefono = "6054949 ext 1";
                        $municipio = "CHIGORODO";
                        break;
                    case 22:
                        $nombre = "E.S.E. HOSPITAL LA MERCED";
                        $direccion = "Cll. 49 # 36 - 298 Barrio La Carmina";
                        $telefono = "6054949 ext 1";
                        $municipio = "CIUDAD BOLIVAR";
                        break;
                    case 48:
                        $nombre = "E.S.E. HOSPITAL SANTA LUCÍA";
                        $direccion = "Cll. 96 # 50 - 220 Vereda El Edén";
                        $telefono = "6054949 ext 1";
                        $municipio = "FREDONIA";
                        break;
                    case 49:
                        $nombre = "E.S.E. HOSPITAL MARIA ANTONIA TORO DE ELEJALDE";
                        $direccion = "Cra. 27 # 31 - 38 Barrio Juan XXIII";
                        $telefono = "6054949 ext 1";
                        $municipio = "FRONTINO";
                        break;
                    case 59:
                        $nombre = "SERVICIO FARMACEUTICO COHAN";
                        $direccion = "Cll. 73A # 52B - 25";
                        $telefono = "6054949 ext 1";
                        $municipio = "ITAGÜÍ";
                        break;
                    case 1:
                        $nombre = "SERVICIO FARMACEUTICO COHAN PUNTO ORIENTAL";
                        $direccion = "Cra. 46 # 47 - 66 C.C. Punto de la Oriental - Piso 3 - Local 3050";
                        $telefono = "6054949 ext 1";
                        $municipio = "MEDELLÍN";
                        break;
                    case 105:
                        $nombre = "E.S.E. HOSPITAL SAN JUAN DE DIOS";
                        $direccion = "Cll. Briceño # 47B - 65";
                        $telefono = "6054949 ext 1";
                        $municipio = "SEGOVIA";
                        break;
                    case 113:
                        $nombre = "I.P.S. SALUD DARIÉN";
                        $direccion = "Cll. 51 # 49 - 04";
                        $telefono = "6054949 ext 1";
                        $municipio = "TURBO";
                        break;

                }
                if(self::$tipoMensaje == "F O R M U L A  M E D I C A"){
                    $this->Cell(58, 4, utf8_decode($nombre), 1, 0, 'L');
                    $this->Cell(55, 4, utf8_decode($direccion), 1, 0, 'C');
                    $this->Cell(40, 4, utf8_decode($telefono), 1, 0, 'C');
                    $this->Cell(45, 4, utf8_decode($municipio), 1, 0, 'C');
                }else{
                    $this->Cell(58, 4, utf8_decode("COHAN"), 1, 0, 'L');
                    $this->Cell(55, 4, utf8_decode(""), 1, 0, 'C');
                    $this->Cell(40, 4, utf8_decode(""), 1, 0, 'C');
                    $this->Cell(45, 4, utf8_decode(""), 1, 0, 'C');
                }
            }
            $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(25, 4, utf8_decode('Diagnósticos'), 1, 0, 'C', 1);
        $this->SetFont('Arial', '', 7.5);
        $this->Cell(173, 4, "  ".($cie10?implode(', ', array_column($cie10, 'codigo_cie10')):""), 1, 0, 'L');
        $this->Ln();
        if(self::$afiliado->entidad_id == 3){
            $this->SetXY(5, 67);
        }else{
            $this->SetXY(5, 59);
        }
        $this->SetFont('Arial', 'B', 6);
        $this->Cell(15, 4, utf8_decode('Código'), 1, 0, 'C', 1);
        $this->Cell(52, 4, utf8_decode('Nombre'), 1, 0, 'C', 1);
        $this->Cell(15, 4, utf8_decode('Via Admin'), 1, 0, 'C', 1);
        $this->Cell(30, 4, utf8_decode('Dosificación'), 1, 0, 'C', 1);
        $this->Cell(13, 4, utf8_decode('Duración'), 1, 0, 'C', 1);
        $this->Cell(15, 4, utf8_decode('Dosis Totales'), 1, 0, 'C', 1);
        $this->Cell(23, 4, utf8_decode('No Total a Dispensar'), 1, 0, 'C', 1);
        $this->Cell(35, 4, utf8_decode('Observación'), 1, 0, 'C', 1);
}

    public function footer(){
        $this->SetFont('Arial','',6);
        $this->Rect(5,111,198,14);
        $this->SetXY(5,111);
        $this->MultiCell(198, 3, utf8_decode("NOTA AUDITORIA: " . (isset(self::$data["medicamentos"][0]['Auth_Nota']) ? self::$data["medicamentos"][0]['Auth_Nota'] : "")), 0, "L", 0);
        $this->SetFont('Arial','B',5);
        if(isset(self::$data["Fecha_estimada"])){
            $this->Rect(5,99.5,198,11);
            $this->SetXY(5,100);
            $this->SetFont('Arial','B',7);
            $this->MultiCell(198,3,utf8_decode('IMPORTANTE: Esta orden es vigente hasta '.self::$data["Fecha_estimada"].' (Resolución 4331 de 2012), Siga las recomendaciones de su médico tratante para garantizar la adecuada administración de sus medicamentos. Recuerde que la adherencia al tratamiento es primordial para los objetivos terapéuticos. En caso de presentar algún evento no deseado, consulte con su médico tratante.'),0,'J',0);
        }
        $this->SetFont('Arial','B',8);
        $this->Text(6,128,utf8_decode('Firma del Medico que Ordena'));
        $this->Text(72,128,utf8_decode('Firma del Usuario'));
        $this->Text(138,128,utf8_decode('Firma de quien Transcribe'));
        $this->Rect(5,125,66,22);
        //$this->Rect(10,121,56,11);
        $this->Rect(71,125,66,22);
        //$this->Rect(75,121,56,11);
        $this->Rect(136.8,125,66.1,22);
        //$this->Rect(143,121,56,11);
        if(self::$consulta->tipo_consulta_id == 1){
            $this->SetFont('Arial','B',6);
            if(self::$afiliado->entidad_id = 2 && self::$consulta->medico_ordena_id){
                $medicoTranscripcion = User::find(self::$consulta->medico_ordena_id);
                $medico = Empleado::where('user_id',$medicoTranscripcion->id)->first();
                if($medico){
                    $this->SetXY(6,145);
                    $this->MultiCell(100,3,utf8_decode($medico->primer_nombre." ".$medico->primer_apellido." R.M:".$medico->documento." (".$medico->especialidad_id.")"),0,'J',0);
                    if($medico->firma){
                        if (file_exists(storage_path(substr($medico->firma, 9)))) {
                            $this->Image(storage_path(substr($medico->firma, 9)), 10, 130, 56, 11);
                        }
                    }
                }
            }
        }else{
            if (isset(self::$medico)) {
                $this->SetFont('Arial','B',6);
                $this->SetXY(6,141);
                $this->MultiCell(65,3,utf8_decode(self::$medico->primer_nombre." ".self::$medico->primer_apellido."   R.M:".self::$medico->documento." (".self::$medico->especialidad_id.")"),0,'J',0);
                if(self::$medico->firma){
                    if (file_exists(storage_path(substr(self::$medico->firma, 9)))) {
                        $this->Image(storage_path(substr(self::$medico->firma, 9)), 10, 130, 56, 11);
                    }
                }
            }
        }

        $this->SetFont('Arial','I',8);
        $this->TextWithDirection(206,130,'Funcionario que Imprime:','U');
        $this->TextWithDirection(206, 97, utf8_decode('PACIENTE'), 'U');
        $this->TextWithDirection(209,130,utf8_decode('Fecha Impresión:'),'U');
        $this->TextWithDirection(209, 108, self::$data["Fecha_actual"], 'U');
    }

    public function body($pdf){
        $Y = 64;
        if(self::$afiliado->entidad_id == 3){
            $Y = 72;
        }
        $X = 2;
        $pdf->SetFont('Arial', '', 6.5);
        foreach (self::$data['medicamentos'] as $codeSumi) {
            $existencia = OrdenArticulo::join('codesumis as c', 'c.id', 'orden_articulos.codesumi_id')
                ->where('orden_articulos.orden_id', self::$orden->id)
                ->where('c.nombre', 'ILIKE', $codeSumi["nombre"])
                ->first();
            if ($existencia) {
                if ($Y > 93) {
                    $Y = 64;
                    if (self::$afiliado->entidad_id == 3) {
                        $Y = 72;
                    }
                    $pdf->AddPage();
                }
                $pdf->SetXY(5, $Y);
                $pdf->MultiCell(15, 4, (isset($codeSumi["Codigo"]) ? $codeSumi["Codigo"] : $codeSumi["id"]), 0, 'C', 0);
                $pdf->SetXY(20, $Y);
                $pdf->MultiCell(52, 4, utf8_decode(strtolower($codeSumi["nombre"])), 0, 'L', 0);
                $YN = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                $pdf->SetXY(75, $Y);
                $pdf->SetFont('Arial', '', 5);
                $pdf->MultiCell(15, 4, utf8_decode($codeSumi["Via"]), 0, 'L', 0);
                $pdf->SetFont('Arial', '', 6.5);
                $pdf->SetXY(87, $Y);
                $pdf->SetFont('Arial', '', 4.5);
                $pdf->MultiCell(30, 4, utf8_decode(intval($codeSumi["Cantidadosis"]) . " " . $codeSumi["Unidadmedida"] . " cada " . $codeSumi["Frecuencia"] . " " . strtolower($codeSumi["Unidadtiempo"])), 0, 'L', 0);
                $pdf->SetFont('Arial', '', 6.5);
                $pdf->SetXY(117, $Y);
                $pdf->MultiCell(13, 4, utf8_decode($codeSumi["Duracion"] . " días"), 0, 'L', 0);
                $pdf->SetXY(130, $Y);
                $pdf->MultiCell(15, 4, intval($codeSumi["Cantidadmensual"]), 0, 'C', 0);
                $pdf->SetXY(145, $Y);
                $pdf->MultiCell(23, 4, intval($codeSumi["Cantidadpormedico"]), 0, 'C', 0);
                $pdf->SetXY(168, $Y);
                $pdf->MultiCell(35, 4, utf8_decode(strtolower($codeSumi["Observacion"])), 0, 'L', 0);
                $YO = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                $pdf->Line(5, ($YO > $YN ? $YO : $YN), 203, ($YO > $YN ? $YO : $YN));
                $YL = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                $Y = $Y + (($YN > $YL ? $YN : $YL) - $Y);
            }
        }
    }

    public function BodyEntidad($pdf){
        $Y = 64;
        $X = 2;
        $pdf->SetFont('Arial', '', 6.5);
        foreach (self::$data['medicamentos'] as $codeSumi) {
            $existencia = OrdenArticulo::join('codesumis as c', 'c.id', 'orden_articulos.codesumi_id')
                ->where('orden_articulos.orden_id', self::$orden->id)
                ->where('c.nombre', 'ILIKE', $codeSumi["nombre"])
                ->first();
            if ($existencia) {
                if (intval($codeSumi["Estado_id"]) != 34 && intval($codeSumi["Estado_id"]) != 35) {
                    if ($Y > 93) {
                        $Y = 64;
                        $pdf->AddPage();
                    }
                    $pdf->SetXY(5, $Y);
                    $pdf->MultiCell(15, 4, (isset($codeSumi["Codigo"]) ? $codeSumi["Codigo"] : $codeSumi["id"]), 0, 'C', 0);
                    $pdf->SetXY(20, $Y);
                    $pdf->MultiCell(52, 4, utf8_decode(strtolower($codeSumi["nombre"])), 0, 'L', 0);
                    $YN = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                    $pdf->SetXY(75, $Y);
                    $pdf->SetFont('Arial', '', 5);
                    $pdf->MultiCell(15, 4, utf8_decode($codeSumi["Via"]), 0, 'L', 0);
                    $pdf->SetFont('Arial', '', 6.5);
                    $pdf->SetXY(87, $Y);
                    $pdf->SetFont('Arial', '', 4.5);
                    $pdf->MultiCell(30, 4, utf8_decode(intval($codeSumi["Cantidadosis"]) . " " . $codeSumi["Unidadmedida"] . " cada " . $codeSumi["Frecuencia"] . " " . strtolower($codeSumi["Unidadtiempo"])), 0, 'L', 0);
                    $pdf->SetFont('Arial', '', 6.5);
                    $pdf->SetXY(117, $Y);
                    $pdf->MultiCell(13, 4, utf8_decode($codeSumi["Duracion"] . " días"), 0, 'L', 0);
                    $pdf->SetXY(130, $Y);
                    $pdf->MultiCell(15, 4, intval($codeSumi["Cantidadmensual"]), 0, 'C', 0);
                    $pdf->SetXY(145, $Y);
                    $pdf->MultiCell(23, 4, intval($codeSumi["Cantidadpormedico"]), 0, 'C', 0);
                    $pdf->SetXY(168, $Y);
                    $pdf->MultiCell(35, 4, utf8_decode(strtolower($codeSumi["Observacion"])), 0, 'L', 0);
                    $YO = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                    $pdf->Line(5, ($YO > $YN ? $YO : $YN), 203, ($YO > $YN ? $YO : $YN));
                    $YL = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                    $Y = $Y + (($YN > $YL ? $YN : $YL) - $Y);
                }
            }
        }
    }

    public function BodyEntidadNoConvenio($pdf){
        $Y = 64;
        $X = 2;
        $pdf->SetFont('Arial', '', 6.5);
        foreach (self::$data['medicamentos'] as $codeSumi) {
            $existencia = OrdenArticulo::join('codesumis as c', 'c.id', 'orden_articulos.codesumi_id')
                ->where('orden_articulos.orden_id', self::$orden->id)
                ->where('c.nombre', 'ILIKE', $codeSumi["nombre"])
                ->first();
            if ($existencia) {
                if (intval($codeSumi["Estado_id"]) == 34) {
                    if ($Y > 93) {
                        $Y = 64;
                        $pdf->AddPage();
                    }
                    $pdf->SetXY(5, $Y);
                    $pdf->MultiCell(15, 4, (isset($codeSumi["Codigo"]) ? $codeSumi["Codigo"] : $codeSumi["id"]), 0, 'C', 0);
                    $pdf->SetXY(20, $Y);
                    $pdf->MultiCell(52, 4, utf8_decode(strtolower($codeSumi["nombre"])), 0, 'L', 0);
                    $YN = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                    $pdf->SetXY(75, $Y);
                    $pdf->SetFont('Arial', '', 5);
                    $pdf->MultiCell(15, 4, utf8_decode($codeSumi["Via"]), 0, 'L', 0);
                    $pdf->SetFont('Arial', '', 6.5);
                    $pdf->SetXY(87, $Y);
                    $pdf->SetFont('Arial', '', 4.5);
                    $pdf->MultiCell(30, 4, utf8_decode(intval($codeSumi["Cantidadosis"]) . " " . $codeSumi["Unidadmedida"] . " cada " . $codeSumi["Frecuencia"] . " " . strtolower($codeSumi["Unidadtiempo"])), 0, 'L', 0);
                    $pdf->SetFont('Arial', '', 6.5);
                    $pdf->SetXY(117, $Y);
                    $pdf->MultiCell(13, 4, utf8_decode($codeSumi["Duracion"] . " días"), 0, 'L', 0);
                    $pdf->SetXY(130, $Y);
                    $pdf->MultiCell(15, 4, intval($codeSumi["Cantidadmensual"]), 0, 'C', 0);
                    $pdf->SetXY(145, $Y);
                    $pdf->MultiCell(23, 4, intval($codeSumi["Cantidadpormedico"]), 0, 'C', 0);
                    $pdf->SetXY(168, $Y);
                    $pdf->MultiCell(35, 4, utf8_decode(strtolower($codeSumi["Observacion"])), 0, 'L', 0);
                    $YO = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                    $pdf->Line(5, ($YO > $YN ? $YO : $YN), 203, ($YO > $YN ? $YO : $YN));
                    $YL = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                    $Y = $Y + (($YN > $YL ? $YN : $YL) - $Y);
                }
            }
        }
    }

    public function BodyEntidadMypress($pdf){
        $Y = 64;
        $X = 2;
        $pdf->SetFont('Arial', '', 6.5);
        foreach (self::$data['medicamentos'] as $codeSumi) {
            $existencia = OrdenArticulo::join('codesumis as c', 'c.id', 'orden_articulos.codesumi_id')
            ->where('orden_articulos.orden_id', self::$orden->id)
            ->where('c.nombre', 'ILIKE', $codeSumi["nombre"])
            ->first();
            if ($existencia) {
                if (intval($codeSumi["Estado_id"]) == 35) {
                    if ($Y > 93) {
                        $Y = 64;
                        $pdf->AddPage();
                    }
                    $pdf->SetXY(5, $Y);
                    $pdf->MultiCell(15, 4, (isset($codeSumi["Codigo"]) ? $codeSumi["Codigo"] : $codeSumi["id"]), 0, 'C', 0);
                    $pdf->SetXY(20, $Y);
                    $pdf->MultiCell(52, 4, utf8_decode(strtolower($codeSumi["nombre"])), 0, 'L', 0);
                    $YN = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                    $pdf->SetXY(75, $Y);
                    $pdf->SetFont('Arial', '', 5);
                    $pdf->MultiCell(15, 4, utf8_decode($codeSumi["Via"]), 0, 'L', 0);
                    $pdf->SetFont('Arial', '', 6.5);
                    $pdf->SetXY(87, $Y);
                    $pdf->SetFont('Arial', '', 4.5);
                    $pdf->MultiCell(30, 4, utf8_decode(intval($codeSumi["Cantidadosis"]) . " " . $codeSumi["Unidadmedida"] . " cada " . $codeSumi["Frecuencia"] . " " . strtolower($codeSumi["Unidadtiempo"])), 0, 'L', 0);
                    $pdf->SetFont('Arial', '', 6.5);
                    $pdf->SetXY(117, $Y);
                    $pdf->MultiCell(13, 4, utf8_decode($codeSumi["Duracion"] . " días"), 0, 'L', 0);
                    $pdf->SetXY(130, $Y);
                    $pdf->MultiCell(15, 4, intval($codeSumi["Cantidadmensual"]), 0, 'C', 0);
                    $pdf->SetXY(145, $Y);
                    $pdf->MultiCell(23, 4, intval($codeSumi["Cantidadpormedico"]), 0, 'C', 0);
                    $pdf->SetXY(168, $Y);
                    $pdf->MultiCell(35, 4, utf8_decode(strtolower($codeSumi["Observacion"])), 0, 'L', 0);
                    $YO = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                    $pdf->Line(5, ($YO > $YN ? $YO : $YN), 203, ($YO > $YN ? $YO : $YN));
                    $YL = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                    $Y = $Y + (($YN > $YL ? $YN : $YL) - $Y);
                }
            }
        }
    }

    function RotatedText($x, $y, $txt, $angle)
    {
        //Text rotated around its origin
        $this->Rotate($angle,$x,$y);
        $this->Text($x,$y,$txt);
        $this->Rotate(0);
    }

    function Rotate($angle,$x=-1,$y=-1)
    {
        if($x==-1)
            $x=$this->x;
        if($y==-1)
            $y=$this->y;
        if($this->angle!=0)
            $this->_out('Q');
        $this->angle=$angle;
        if($angle!=0)
        {
            $angle*=M_PI/180;
            $c=cos($angle);
            $s=sin($angle);
            $cx=$x*$this->k;
            $cy=($this->h-$y)*$this->k;
            $this->_out(sprintf('q %.5F %.5F %.5F %.5F %.2F %.2F cm 1 0 0 1 %.2F %.2F cm',$c,$s,-$s,$c,$cx,$cy,-$cx,-$cy));
        }
    }

    public function TextWithDirection($x, $y, $txt, $direction = 'R')
    {
        if ($direction == 'R') {
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 1, 0, 0, 1, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        } elseif ($direction == 'L') {
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', -1, 0, 0, -1, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        } elseif ($direction == 'U') {
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, 1, -1, 0, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        } elseif ($direction == 'D') {
            $s = sprintf('BT %.2F %.2F %.2F %.2F %.2F %.2F Tm (%s) Tj ET', 0, -1, 1, 0, $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        } else {
            $s = sprintf('BT %.2F %.2F Td (%s) Tj ET', $x * $this->k, ($this->h - $y) * $this->k, $this->_escape($txt));
        }
        if ($this->ColorFlag) {
            $s = 'q ' . $this->TextColor . ' ' . $s . ' Q';
        }
        $this->_out($s);
    }



}

