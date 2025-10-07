<?php
namespace App\Formats;


use DNS2D;
use Codedge\Fpdf\Fpdf\Fpdf;
use Carbon\Carbon;
use App\Http\Modules\Reps\Models\Rep;
use App\Http\Modules\Usuarios\Models\User;
use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Consultas\Models\Consulta;
use App\Http\Modules\Empleados\Models\Empleado;
use App\Http\Modules\Ordenamiento\Models\Orden;
use App\Http\Modules\Cie10Afiliado\Models\Cie10Afiliado;

class ServicioGestion extends Fpdf
{
    var $angle=0;
    public static $orden;
    public static $afiliado;
    public static $data;
    public static $tipoMensaje;
    public static $rep;
    public static $qr;
    public static $medico;
    public static $consulta;
    public static $ubicacion;
    public static $cie10;


    public function generar($data,$tipoMensaje ="S E R V I C I O  M E D I C O")
    {

        $pdf             = new ServicioGestion('p', 'mm', 'A4');
        self::$data      = $data;
        self::$afiliado = Afiliado::where('numero_documento',$data["numero_documento"])->first();
        self::$orden = Orden::find($data["orden_id"]);
        self::$tipoMensaje      = $tipoMensaje;
        if(self::$afiliado->entidad_id == 1 || self::$afiliado->entidad_id == 3 || self::$afiliado->entidad_id == 5){
            self::$rep = Rep::select(
                "reps.*",
                "presta.nit",
                "mp.nombre as municipioPrestador",
                "dp.nombre as departamentoPrestador")
                ->join('prestadores as presta', 'reps.prestador_id', 'presta.id')
                ->leftJoin('municipios as mp', 'reps.municipio_id', 'mp.id')
                ->leftJoin('departamentos as dp', 'mp.departamento_id', 'dp.id')
                ->where('reps.nombre', $data["servicios"][0]["ubicacion"])->first();
        }

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
        }elseif(self::$afiliado->entidad_id == 2 && isset($data["servicios"][0]["Estado_id"])){
            $this->BodyEntidad($pdf);
        }
        $pdf->Output();
    }

    public function header(){
        $this->SetFont('Arial','B',50);
        $this->SetTextColor(255,192,203);
        $this->RotatedText(12,134,self::$tipoMensaje,33);
        $this->SetTextColor(0,0,0);
        self::$consulta = Consulta::find(self::$orden->consulta_id);
         $user =  User::find(self::$orden->user_id);
         self::$medico = Empleado::where('user_id',$user->id)->first();
         self::$cie10 = Cie10Afiliado::select('cie10s.codigo_cie10')->join('cie10s','cie10s.id','cie10_afiliados.cie10_id')
         ->where('cie10_afiliados.consulta_id',self::$consulta->id)->get()->toArray();
         $tipo = "(Consulta Medica)";
         if(self::$consulta->tipo_consulta_id == 1){
        $tipo = "Transcripción";
        }else{
             $tipo = "Consulta Medica";
         }
        $this->SetFont('Arial','I',10);
        $this->SetTextColor(251,44,0);
        $this->TextWithDirection(207, 40, utf8_decode($tipo), 'U');
        $this->SetTextColor(0,0,0);
         $arSedeProveedor = Rep::find(self::$afiliado->ips_id);
        $arOrden         = Orden::find(self::$data["orden_id"]);
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
        $this->SetXY(84, $Y + 11);
        if (self::$afiliado->entidad_id == 1 || self::$afiliado->entidad_id == 3 || self::$afiliado->entidad_id == 5) {
            $this->SetFont('Arial', 'B', 7);
            $this->Cell(88, 4, utf8_decode("Régimen: Especial / Número de Orden: " . self::$orden->id), 0, 0, 'C');
        }else {
            $this->Cell(88, 4, utf8_decode("Régimen: ".self::$afiliado->tipo_categoria." / Número de Orden: " . self::$orden->id), 0, 0, 'C');
        }
        $this->SetXY(84, $Y + 8);
        if(self::$afiliado->entidad_id == 1 || self::$afiliado->entidad_id == 3 || self::$afiliado->entidad_id == 5){
            $this->SetFont('Arial', 'B', 6);
            $this->Cell(88, 4, utf8_decode('IPS Primaria: ' . $arSedeProveedor->nombre), 0, 0, 'C');
        }else{
            $this->Cell(88, 4, utf8_decode('IPS Primaria: MEDIMAS'), 0, 0, 'C');
        }
        $this->Rect(165, 5, 38, 22);
        $this->SetXY(60, $Y + 6);
        $this->Image(self::$qr, 175, 8, 21, 17);
        $this->SetFillColor(216, 216, 216);
        $this->SetFont('Arial', 'B', 8);
        $this->SetXY(5, 28);
        if(self::$afiliado->entidad_id == 1 || self::$afiliado->entidad_id == 3 || self::$afiliado->entidad_id == 5){
            $this->Cell(134, 4, utf8_decode('Nombre Paciente'), 1, 0, 'C', 1);
        }else{
            $this->Cell(124, 4, utf8_decode('Nombre Paciente'), 1, 0, 'C', 1);
            $this->Cell(10, 4, utf8_decode('Nivel'), 1, 0, 'C', 1);
        }
        $this->Cell(14, 4, utf8_decode('Sexo'), 1, 0, 'C', 1);
        $this->Cell(22, 4, utf8_decode('Identificación'), 1, 0, 'C', 1);
        $this->Cell(10, 4, 'Edad', 1, 0, 'C', 1);
        $this->Cell(18, 4, 'Nacimiento', 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 8);
        if(self::$afiliado->entidad_id == 1 || self::$afiliado->entidad_id == 3 || self::$afiliado->entidad_id == 5) {
            $this->Cell(134, 4, utf8_decode(self::$afiliado->primer_apellido." ".self::$afiliado->segundo_apellido." ".self::$afiliado->primer_nombre." ".self::$afiliado->segundo_nombre), 1, 0, 'C');
        }else{
            $this->Cell(124, 4, utf8_decode(self::$afiliado->primer_apellido." ".self::$afiliado->segundo_apellido." ".self::$afiliado->primer_nombre." ".self::$afiliado->segundo_nombre), 1, 0, 'C');
            $this->Cell(10, 4, utf8_decode(self::$afiliado->nivel), 1, 0, 'C');
        }
        $this->Cell(14, 4, utf8_decode(self::$afiliado->sexo), 1, 0, 'C');
        $this->Cell(22, 4, utf8_decode(self::$afiliado->tipo_documento." ".self::$afiliado->numero_documento), 1, 0, 'C');
        $this->Cell(10, 4, self::$afiliado->edad_cumplida, 1, 0, 'C');
        $this->Cell(18, 4, substr(self::$afiliado->fecha_nacimiento,0,10), 1, 0, 'C');
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', 'B', 8);
        $this->Cell(59, 4, 'Direccion', 1, 0, 'C', 1);
        $this->Cell(59, 4, 'Telefono', 1, 0, 'C', 1);
        $this->Cell(40, 4, 'Correo', 1, 0, 'C', 1);
        $this->Cell(40, 4, 'Municipio', 1, 0, 'C', 1);
        $this->Ln();
        $this->SetX(5);
        $this->SetFont('Arial', '', 6);
        $this->Cell(59, 4, utf8_decode(substr(self::$afiliado->direccion_Residencia_cargue, 0, 38)), 1, 0, 'C');
        $this->Cell(59, 4, utf8_decode(self::$afiliado->telefono) . " - " . utf8_decode(self::$afiliado->celular1), 1, 0, 'C');
        $this->Cell(40, 4, utf8_decode(self::$afiliado->correo1), 1, 0, 'C');
        $this->Cell(40, 4, 'Antioquia-Medellin', 1, 0, 'C');
        if(self::$afiliado->entidad_id == 1 || self::$afiliado->entidad_id == 3 || self::$afiliado->entidad_id == 5) {
            $this->Ln();
            $this->SetX(5);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(133, 4, 'Nombre Prestador', 1, 0, 'C', 1);
            $this->Cell(65, 4, utf8_decode('Dirección'), 1, 0, 'C', 1);
            $this->Ln();
            $this->SetX(5);
            $this->SetFont('Arial', 'B', 6);
            $this->Cell(133, 4, utf8_decode(self::$data["servicios"][0]["ubicacion"]), 1, 0, 'L');
            $this->Cell(65, 4, utf8_decode(self::$data["servicios"][0]["direccion"]), 1, 0, 'C');
            $this->Ln();
            $this->SetX(5);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(39.6, 4, utf8_decode('NIT'), 1, 0, 'C', 1);
            $this->Cell(39.6, 4, 'Telefono', 1, 0, 'C', 1);
            $this->Cell(39.6, 4, utf8_decode('Cod Habilitaciòn'), 1, 0, 'C', 1);
            $this->Cell(39.6, 4, 'Municipio', 1, 0, 'C', 1);
            $this->Cell(39.6, 4, 'Diagnostico DX', 1, 0, 'C', 1);
            $this->Ln();
            $this->SetX(5);
            $this->SetFont('Arial', '', 7.5);
            $this->Cell(39.6, 4, utf8_decode(isset(self::$rep["nit"])?self::$rep["nit"]:''), 1, 0, 'C');
            $this->Cell(39.6, 4, utf8_decode(isset(self::$data["servicios"][0]["telefono"])?self::$data["servicios"][0]["telefono"]:'' ), 1, 0, 'C');
            $this->Cell(39.6, 4, utf8_decode(isset(self::$rep["codigo_habilitacion"])?self::$rep["codigo_habilitacion"]:''), 1, 0, 'C');
            $this->Cell(39.6, 4, utf8_decode(isset(self::$rep["municipioPrestador"])? self::$rep["municipioPrestador"]. "-" . self::$rep["departamentoPrestador"]:''), 1, 0, 'C');
            // $this->Cell(39.6, 4, utf8_decode(self::$data["dx_principal"]), 1, 0, 'C');
            $this->SetFillColor(216, 216, 216);
        }
        else{

            $direccionamientos = [] ;
            // DB::select("exec dbo.CupsDireccionamientoEntidad " . intval(self::$data["order_id"]));
            $i = 0;
            $ubicaciones= [];
            $listaServicios= self::$data["servicios"];
            foreach (self::$data["servicios"] as $key => $servicios){
                if($servicios["ubicacion_id"]) {
                    $sede = Rep::find($servicios["ubicacion_id"]);
                    $datosSede = ["nombrePrestador" => $sede->nombre,
                        "direccion" =>  $sede->direccion,
                        "telefono" => $sede->telefono1];
                    $ubicaciones[$sede->id]["servicios"][] = $servicios;
                    $ubicaciones[$sede->id]["datos"] = $datosSede;
                    unset($listaServicios[$key]);
                }else{
                    foreach ($direccionamientos as $direccionamiento){
                        if(intval($direccionamiento->cup_id) == intval($servicios["id"])) {
                            $datosSede = ["nombrePrestador" => $direccionamiento->nombre_prestador,
                                "direccion" =>  $direccionamiento->direccion,
                                "telefono" => $direccionamiento->telefono];
                            $ubicaciones[$direccionamiento->sedeproveedor_id]["servicios"][] = $servicios;
                            $ubicaciones[$direccionamiento->sedeproveedor_id]["datos"] = $datosSede;
                            unset($listaServicios[$key]);
                        }
                    }
                }
            }
            if($listaServicios){
                $datosSede = ["nombrePrestador" => "",
                    "direccion" =>  "",
                    "telefono" => ""];
                $ubicaciones[0]["servicios"][] = $listaServicios;
                $ubicaciones[0]["datos"] = $datosSede;
            }
            self::$ubicacion = $ubicaciones;

            $this->Ln();
            $this->SetX(5);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(113, 4, 'Nombre Prestador', 1, 0, 'C', 1);
            $this->Cell(20, 4, 'Telefono', 1, 0, 'C', 1);
            $this->Cell(65, 4, utf8_decode('Dirección'), 1, 0, 'C', 1);
            $this->Ln();

        }
        if (self::$afiliado->entidad_id == 1 || self::$afiliado->entidad_id == 3 || self::$afiliado->entidad_id == 5) {
            $this->SetXY(5, 61);
        }else{
            $this->SetXY(5,52);
            $this->SetFont('Arial', 'B', 8);
            $this->Cell(25, 4, utf8_decode('Diagnósticos'), 1, 0, 'C', 1);
            $this->SetFont('Arial', '', 7.5);
            $this->Cell(173, 4, "  ".(self::$cie10?implode(', ', array_column(self::$cie10, 'Codigo')):""), 1, 0, 'L');
            $this->SetXY(5, 59);
        }

        $this->SetFont('Arial', 'B', 6);
        $this->Cell(30, 4, utf8_decode('Código'), 1, 0, 'C', 1);
        $this->Cell(100, 4, utf8_decode('Nombre'), 1, 0, 'C', 1);
        $this->Cell(20, 4, utf8_decode('Cantidad'), 1, 0, 'C', 1);
        $this->Cell(48, 4, utf8_decode('Observación'), 1, 0, 'C', 1);

    }

    public function footer(){
        $this->SetFont('Arial','',6);
        $this->Rect(5,102,198,14);
        $this->SetXY(5,103);
        $this->MultiCell(198, 3, utf8_decode("NOTA AUDITORIA: " . (isset(self::$data["servicios"][0]['Auth_Nota']) ? self::$data["servicios"][0]['Auth_Nota'] : "")), 0, "L", 0);
        $this->SetFont('Arial','B',5);
        $this->Rect(5,99.5,198,3);
        $this->Text(10,101.5,utf8_decode('IMPORTANTE: '));
        $this->SetFont('Arial','',4.8);
        $this->Text(24,101.5,utf8_decode('AUTORIZACION VALIDA SOLAMENTE EN LOS 60 DIAS DESPUES A LA FECHA DE SU EXPEDICION, UNA VEZ CUMPLIDO DICHO PLAZO NO HAY RESPOABILIDAD DE SUMIMEDICAL - RED VITAL. (Resolucion 4331 de 2012) .'));
        $this->SetFont('Arial','B',8);
        $this->Text(6,119,utf8_decode('Firma del Medico que Ordena'));
        $this->Text(72,119,utf8_decode('Firma del Usuario'));
        $this->Text(138,119,utf8_decode('Firma de quien Transcribe'));
        $this->Rect(5,116,66,18);
        $this->Rect(71,116,66,18);
        $this->Rect(136.8,116,66.1,18);
        if(self::$consulta->tipo_consulta_id == 1){
            $this->SetFont('Arial','B',6);

            if(self::$afiliado->entidad_id == 2 && isset(self::$consulta->medico_ordena_id)){
                $user = User::find(intval(self::$consulta->medico_ordena_id));
                $medicoTranscripcion = Empleado::where('user_id',$user->id)->first();
                if($medicoTranscripcion){
                    $this->Text(6,133,utf8_decode($medicoTranscripcion->primer_nombre." ".$medicoTranscripcion->primer_apellido."   R.M:".$medicoTranscripcion->documento." (".$medicoTranscripcion->especialidad_id.")"));
                    if($medicoTranscripcion->firma){
                        // if (file_exists(storage_path(substr($medicoTranscripcion->firma, 9)))) {
                        //     $this->Image(storage_path(substr($medicoTranscripcion->firma, 9)), 10, 120, 56, 11);
                        // }
                    }
                }
            }
        }
        else{
            if (isset(self::$medico)) {
                $this->SetFont('Arial','B',6);
                $this->Text(6,133,utf8_decode(self::$medico->primer_nombre." ".self::$medico->primer_apellido."   R.M:".self::$medico->documento." (".self::$medico->especialidad_id.")"));
                if(self::$medico->firma){
                    // if (file_exists(storage_path(substr(self::$medico->firma, 9)))) {
                    //     $this->Image(storage_path(substr(self::$medico->firma, 9)), 10, 121, 56, 11);
                    // }
                }
            }
        }

        $this->SetFont('Arial','I',8);
        $this->TextWithDirection(206,120,'Funcionario que Imprime:','U');
        $this->TextWithDirection(206, 87, utf8_decode('PACIENTE'), 'U');
        $this->TextWithDirection(209,120,utf8_decode('Fecha Impresión:'),'U');
        $this->TextWithDirection(209, 98, self::$data["Fecha_actual"], 'U');
    }

    public function Body($pdf){
        $Y = 65;
        $X = 2;
        $pdf->SetFont('Arial', '', 8);
        foreach (self::$data["servicios"] as $key => $servicio) {
            if ($Y  > 93) {
                $Y = 65;
                $pdf->AddPage();
            }
            $pdf->SetXY(5, $Y);
            $pdf->MultiCell(30, 4, $servicio["codigo"], 0, 'C', 0);
            $pdf->SetXY(35, $Y);
            if(isset($servicio["descripcion"])){
                $pdf->MultiCell(100, 4, utf8_decode(strtolower($servicio["descripcion"])), 0, 'L', 0);
                $YN = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
            }else{
                $pdf->MultiCell(100, 4, utf8_decode(strtolower($servicio["nombre"])), 0, 'L', 0);
                $YN = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
            }
            $pdf->SetXY(135, $Y);
            $pdf->MultiCell(20, 4, $servicio['cantidad'], 0, 'C', 0);
            $pdf->SetXY(155, $Y);
            $pdf->MultiCell(48, 4, utf8_decode($servicio["observacion"]), 0, 'L', 0);
            $YO = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
            $pdf->Line(5, ($YO > $YN ? $YO : $YN), 203, ($YO > $YN ? $YO : $YN));
            $YL = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
            $Y = $Y + (($YN > $YL ? $YN : $YL) - $Y);
        }
    }

    public function BodyEntidad($pdf){
        $pdf->SetFont('Arial', '', 8);
        $keys = array_keys(self::$ubicacion);
        foreach (self::$ubicacion as $keyUbicacion => $sede) {
            $pdf->SetXY(5,48);
            $pdf->SetFont('Arial', '', 6);
            $pdf->Cell(113, 4, utf8_decode($sede["datos"]["nombrePrestador"]), 1, 0, 'L');
            $pdf->Cell(20, 4, utf8_decode($sede["datos"]["telefono"]), 1, 0, 'C');
            $pdf->Cell(65, 4, utf8_decode($sede["datos"]["direccion"]), 1, 0, 'C');

            $Y = 64;
            $pdf->SetFont('Arial', '', 8);
            foreach ($sede["servicios"] as $key => $servicio) {
                if(intval($servicio["estado_id"]) != 34 && intval($servicio["estado_id"]) != 35 ){
                    if ($Y > 93) {
                        $Y = 64;
                        $pdf->AddPage();
                        $pdf->SetXY(5, 48);
                        $pdf->SetFont('Arial', '', 6);
                        $pdf->Cell(113, 4, utf8_decode($sede["datos"]["nombrePrestador"]), 1, 0, 'L');
                        $pdf->Cell(20, 4, utf8_decode($sede["datos"]["telefono"]), 1, 0, 'C');
                        $pdf->Cell(65, 4, utf8_decode($sede["datos"]["direccion"]), 1, 0, 'C');
                        $pdf->SetFont('Arial', '', 8);
                    }
                    $pdf->SetXY(5, $Y);
                    $pdf->MultiCell(30, 4, $servicio["codigo"], 0, 'C', 0);
                    $pdf->SetXY(35, $Y);
                    if (isset($servicio["descripcion"])) {
                        $pdf->MultiCell(100, 4, utf8_decode(strtolower($servicio["descripcion"])), 0, 'L', 0);
                        $YN = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                    } else {
                        $pdf->MultiCell(100, 4, utf8_decode(strtolower($servicio["nombre"])), 0, 'L', 0);
                        $YN = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                    }
                    $pdf->SetXY(135, $Y);
                    $pdf->MultiCell(20, 4, $servicio['cantidad'], 0, 'C', 0);
                    $pdf->SetXY(155, $Y);
                    $pdf->MultiCell(48, 4, utf8_decode($servicio["observacion"]), 0, 'L', 0);
                    $YO = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                    $pdf->Line(5, ($YO > $YN ? $YO : $YN), 203, ($YO > $YN ? $YO : $YN));
                    $YL = round($pdf->GetY(), 0, PHP_ROUND_HALF_DOWN);
                    $Y = $Y + (($YN > $YL ? $YN : $YL) - $Y);
                }
            }
            if($keyUbicacion != end($keys)){
                $pdf->AddPage();
            }
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



}

