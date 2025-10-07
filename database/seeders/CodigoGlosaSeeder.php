<?php

namespace Database\Seeders;

use Illuminate\Http\Response;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Http\Modules\CuentasMedicas\CodigoGlosas\Models\CodigoGlosa;

class CodigoGlosaSeeder extends Seeder
{
    public function run()
    {
        try {
            $tipos = [
                ['codigo' => '101','descripcion' => 'Estancia','tipo_cuenta_medica_id'=>1],
                ['codigo' => '102','descripcion' => 'Consultas, interconsultas y visitas médicas','tipo_cuenta_medica_id'=>1],
                ['codigo' => '103','descripcion' => 'Honorarios médicos en procedimientos','tipo_cuenta_medica_id'=>1],
                ['codigo' => '104','descripcion' => 'Honorarios de otros Profesionales','tipo_cuenta_medica_id'=>1],
                ['codigo' => '105','descripcion' => 'Derechos de sala','tipo_cuenta_medica_id'=>1],
                ['codigo' => '106','descripcion' => 'Materiales','tipo_cuenta_medica_id'=>1],
                ['codigo' => '107','descripcion' => 'Medicamentos','tipo_cuenta_medica_id'=>1],
                ['codigo' => '108','descripcion' => 'Ayudas diagnósticas','tipo_cuenta_medica_id'=>1],
                ['codigo' => '109','descripcion' => 'Atención Integral (caso, conjunto integral de atenciones, paquete o Grupo relacionado por diagnóstico)','tipo_cuenta_medica_id'=>1],
                ['codigo' => '110','descripcion' => 'Servicio o insumo incluido en paquete','tipo_cuenta_medica_id'=>1],
                ['codigo' => '111','descripcion' => 'Servicio o insumo incluido en estancia o derechos de sala','tipo_cuenta_medica_id'=>1],
                ['codigo' => '112','descripcion' => 'Factura excede topes autorizados','tipo_cuenta_medica_id'=>1],
                ['codigo' => '113','descripcion' => 'Facturar por separado por tipo de recobro (CTC, ATEP, tutelas)','tipo_cuenta_medica_id'=>1],
                ['codigo' => '114','descripcion' => 'Error en suma de conceptos facturados','tipo_cuenta_medica_id'=>1],
                ['codigo' => '115','descripcion' => 'Datos insuficientes del usuario','tipo_cuenta_medica_id'=>1],
                ['codigo' => '116','descripcion' => 'Usuario o servicio corresponde a otro plan o responsable','tipo_cuenta_medica_id'=>1],
                ['codigo' => '117','descripcion' => 'Usuario retirado o moroso','tipo_cuenta_medica_id'=>1],
                ['codigo' => '119','descripcion' => 'Error en descuento pactado','tipo_cuenta_medica_id'=>1],
                ['codigo' => '120','descripcion' => 'Recibo de pago compartido','tipo_cuenta_medica_id'=>1],
                ['codigo' => '122','descripcion' => 'Prescripción dentro de los términos legales o pactados entre las partes','tipo_cuenta_medica_id'=>1],
                ['codigo' => '123','descripcion' => 'Procedimiento o actividad','tipo_cuenta_medica_id'=>1],
                ['codigo' => '124','descripcion' => 'Falta firma del prestador de servicios de salud','tipo_cuenta_medica_id'=>1],
                ['codigo' => '125','descripcion' => 'Examen o actividad pertenece a detección temprana o protección específica','tipo_cuenta_medica_id'=>1],
                ['codigo' => '126','descripcion' => 'Usuario o servicio corresponde a capitación','tipo_cuenta_medica_id'=>1],
                ['codigo' => '127','descripcion' => 'Servicio o procedimiento incluido en otro','tipo_cuenta_medica_id'=>1],
                ['codigo' => '128','descripcion' => 'Orden cancelada al prestador de servicios de salud','tipo_cuenta_medica_id'=>1],
                ['codigo' => '151','descripcion' => 'Recobro en contrato de capitación por servicios prestados por otro prestador','tipo_cuenta_medica_id'=>1],
                ['codigo' => '152','descripcion' => 'Disminución en el número de personas incluidas en la capitación','tipo_cuenta_medica_id'=>1],
                ['codigo' => '201','descripcion' => 'Estancia','tipo_cuenta_medica_id'=>2],
                ['codigo' => '202','descripcion' => 'Consultas, interconsultas y visitas médicas','tipo_cuenta_medica_id'=>2],
                ['codigo' => '203','descripcion' => 'Honorarios médicos en procedimientos','tipo_cuenta_medica_id'=>2],
                ['codigo' => '204','descripcion' => 'Honorarios de otros profesionales asistenciales','tipo_cuenta_medica_id'=>2],
                ['codigo' => '205','descripcion' => 'Derechos de sala','tipo_cuenta_medica_id'=>2],
                ['codigo' => '206','descripcion' => 'Materiales','tipo_cuenta_medica_id'=>2],
                ['codigo' => '207','descripcion' => 'Medicamentos','tipo_cuenta_medica_id'=>2],
                ['codigo' => '208','descripcion' => 'Ayudas diagnósticas','tipo_cuenta_medica_id'=>2],
                ['codigo' => '209','descripcion' => 'Atención Integral (caso, conjunto integral de atenciones, paquete o Grupo relacionado por diagnóstico)','tipo_cuenta_medica_id'=>2],
                ['codigo' => '223','descripcion' => 'Procedimiento o actividad','tipo_cuenta_medica_id'=>2],
                ['codigo' => '229','descripcion' => 'Recargos no pactados','tipo_cuenta_medica_id'=>2],
                ['codigo' => '301','descripcion' => 'Estancia','tipo_cuenta_medica_id'=>3],
                ['codigo' => '302','descripcion' => 'Consultas, interconsultas y visitas médicas','tipo_cuenta_medica_id'=>3],
                ['codigo' => '303','descripcion' => 'Honorarios médicos en procedimientos','tipo_cuenta_medica_id'=>3],
                ['codigo' => '304','descripcion' => 'Honorarios de otros profesionales asistenciales','tipo_cuenta_medica_id'=>3],
                ['codigo' => '306','descripcion' => 'Materiales','tipo_cuenta_medica_id'=>3],
                ['codigo' => '307','descripcion' => 'Medicamentos','tipo_cuenta_medica_id'=>3],
                ['codigo' => '308','descripcion' => 'Ayudas diagnósticas','tipo_cuenta_medica_id'=>3],
                ['codigo' => '309','descripcion' => 'Atención Integral (caso, conjunto integral de atenciones, paquete o Grupo relacionado por diagnóstico)','tipo_cuenta_medica_id'=>3],
                ['codigo' => '320','descripcion' => 'Recibo de pago compartido','tipo_cuenta_medica_id'=>3],
                ['codigo' => '331','descripcion' => 'Bonos o vouchers sin firma del paciente, con enmendaduras o tachones','tipo_cuenta_medica_id'=>3],
                ['codigo' => '332','descripcion' => 'Detalle de cargos','tipo_cuenta_medica_id'=>3],
                ['codigo' => '333','descripcion' => 'Copia de historia clínica completa','tipo_cuenta_medica_id'=>3],
                ['codigo' => '335','descripcion' => 'Formato ATEP','tipo_cuenta_medica_id'=>3],
                ['codigo' => '336','descripcion' => 'Copia de la factura o detalle de cargos para excedentes de SOAT','tipo_cuenta_medica_id'=>3],
                ['codigo' => '337','descripcion' => 'Orden o fórmula médica','tipo_cuenta_medica_id'=>3],
                ['codigo' => '338','descripcion' => 'Hoja de traslado en ambulancia','tipo_cuenta_medica_id'=>3],
                ['codigo' => '339','descripcion' => 'Comprobante de recibido del usuario','tipo_cuenta_medica_id'=>3],
                ['codigo' => '340','descripcion' => 'Registro de anestesia','tipo_cuenta_medica_id'=>3],
                ['codigo' => '341','descripcion' => 'Descripción quirúrgica','tipo_cuenta_medica_id'=>3],
                ['codigo' => '342','descripcion' => 'Lista de precios','tipo_cuenta_medica_id'=>3],
                ['codigo' => '401','descripcion' => 'Estancia','tipo_cuenta_medica_id'=>4],
                ['codigo' => '402','descripcion' => 'Consultas, interconsultas y visitas médicas','tipo_cuenta_medica_id'=>4],
                ['codigo' => '403','descripcion' => 'Autorización honorarios médicos en procedimientos','tipo_cuenta_medica_id'=>4],
                ['codigo' => '406','descripcion' => 'Materiales','tipo_cuenta_medica_id'=>4],
                ['codigo' => '408','descripcion' => 'Ayudas diagnósticas','tipo_cuenta_medica_id'=>4],
                ['codigo' => '423','descripcion' => 'Procedimiento o actividad','tipo_cuenta_medica_id'=>4],
                ['codigo' => '430','descripcion' => 'Autorización de servicios adicional','tipo_cuenta_medica_id'=>4],
                ['codigo' => '443','descripcion' => 'Orden o autorización de servicios vencida','tipo_cuenta_medica_id'=>4],
                ['codigo' => '444','descripcion' => 'Profesional que ordena no adscrito','tipo_cuenta_medica_id'=>4],
                ['codigo' => '501','descripcion' => 'Estancia','tipo_cuenta_medica_id'=>5],
                ['codigo' => '502','descripcion' => 'Consultas, interconsultas y visitas médicas','tipo_cuenta_medica_id'=>5],
                ['codigo' => '506','descripcion' => 'Materiales','tipo_cuenta_medica_id'=>5],
                ['codigo' => '507','descripcion' => 'Medicamentos','tipo_cuenta_medica_id'=>5],
                ['codigo' => '508','descripcion' => 'Ayudas diagnósticas','tipo_cuenta_medica_id'=>5],
                ['codigo' => '523','descripcion' => 'Procedimiento o actividad','tipo_cuenta_medica_id'=>5],
                ['codigo' => '527','descripcion' => 'Servicio o procedimiento incluido en otro','tipo_cuenta_medica_id'=>5],
                ['codigo' => '545','descripcion' => 'Servicio no pactado','tipo_cuenta_medica_id'=>5],
                ['codigo' => '546','descripcion' => 'Cobertura sin agotar en la póliza (SOAT)','tipo_cuenta_medica_id'=>5],
                ['codigo' => '601','descripcion' => 'Estancia','tipo_cuenta_medica_id'=>6],
                ['codigo' => '602','descripcion' => 'Consultas, interconsultas y visitas médicas','tipo_cuenta_medica_id'=>6],
                ['codigo' => '603','descripcion' => 'Honorarios médicos en procedimientos','tipo_cuenta_medica_id'=>6],
                ['codigo' => '604','descripcion' => 'Honorarios de otros profesionales asistenciales','tipo_cuenta_medica_id'=>6],
                ['codigo' => '605','descripcion' => 'Derechos de sala','tipo_cuenta_medica_id'=>6],
                ['codigo' => '606','descripcion' => 'Materiales','tipo_cuenta_medica_id'=>6],
                ['codigo' => '607','descripcion' => 'Medicamentos','tipo_cuenta_medica_id'=>6],
                ['codigo' => '608','descripcion' => 'Ayudas diagnósticas','tipo_cuenta_medica_id'=>6],
                ['codigo' => '623','descripcion' => 'Procedimiento o actividad','tipo_cuenta_medica_id'=>6],
                ['codigo' => '653','descripcion' => 'Urgencia no pertinente','tipo_cuenta_medica_id'=>6],
                ['codigo' => '816','descripcion' => 'Usuario o servicios corresponde a otro plan o responsable','tipo_cuenta_medica_id'=>7],
                ['codigo' => '817','descripcion' => 'Usuario retirado o moroso','tipo_cuenta_medica_id'=>7],
                ['codigo' => '821','descripcion' => 'Autorización principal no existe o no corresponde al prestador de servicios de salud','tipo_cuenta_medica_id'=>7],
                ['codigo' => '822','descripcion' => 'Respuesta a glosa o devolución extemporánea','tipo_cuenta_medica_id'=>7],
                ['codigo' => '834','descripcion' => 'Resumen del egreso o epicrisis, hoja de atención de urgencias u odontograma','tipo_cuenta_medica_id'=>7],
                ['codigo' => '844','descripcion' => 'Profesional que ordena no adscrito','tipo_cuenta_medica_id'=>7],
                ['codigo' => '847','descripcion' => 'Falta soporte de justificación para recobros (CTC, tutelas, ARP)','tipo_cuenta_medica_id'=>7],
                ['codigo' => '848','descripcion' => 'Informe atención inicial de urgencias','tipo_cuenta_medica_id'=>7],
                ['codigo' => '849','descripcion' => 'Factura no cumple requisitos legales','tipo_cuenta_medica_id'=>7],
                ['codigo' => '850','descripcion' => 'Factura ya cancelada','tipo_cuenta_medica_id'=>7],
                ['codigo' => '995','descripcion' => 'Glosa o devolución extemporánea','tipo_cuenta_medica_id'=>8],
                ['codigo' => '996','descripcion' => 'Glosa o devolución injustificada','tipo_cuenta_medica_id'=>8],
                ['codigo' => '997','descripcion' => 'No subsanada (Glosa o devolución totalmente aceptada)','tipo_cuenta_medica_id'=>8],
                ['codigo' => '998','descripcion' => 'Subsanada parcial (Glosa o devolución parcialmente aceptada)','tipo_cuenta_medica_id'=>8],
                ['codigo' => '999','descripcion' => 'Subsanada (Glosa o Devolución No Aceptada)','tipo_cuenta_medica_id'=>8],
                ['codigo' => '','descripcion' => 'HOSPITALIZACION','tipo_cuenta_medica_id'=>9],
                ['codigo' => '','descripcion' => 'UCI-UCE','tipo_cuenta_medica_id'=>9],
                ['codigo' => '','descripcion' => 'CIRUGIA','tipo_cuenta_medica_id'=>9],
                ['codigo' => '','descripcion' => 'HEMODINAMIA','tipo_cuenta_medica_id'=>9],
                ['codigo' => '','descripcion' => 'CAPITA','tipo_cuenta_medica_id'=>9],
                ['codigo' => '','descripcion' => 'AYUDAS DX','tipo_cuenta_medica_id'=>9],
                ['codigo' => '','descripcion' => 'LABORATORIO','tipo_cuenta_medica_id'=>9],
                ['codigo' => '','descripcion' => 'DIALISIS-HEMODIALISIS','tipo_cuenta_medica_id'=>9],
                ['codigo' => '','descripcion' => 'URGENCIAS','tipo_cuenta_medica_id'=>9],
                ['codigo' => '','descripcion' => 'FARMACIA','tipo_cuenta_medica_id'=>9],
                ['codigo' => '','descripcion' => 'ODONTOLOGIA','tipo_cuenta_medica_id'=>9],
                ['codigo' => '','descripcion' => 'MED DOMICILIARIA','tipo_cuenta_medica_id'=>9],
                ['codigo' => '','descripcion' => 'MULTIUSUARIO','tipo_cuenta_medica_id'=>9],
                ['codigo' => '','descripcion' => 'TERAPIAS','tipo_cuenta_medica_id'=>9],
                ['codigo' => '','descripcion' => 'CONSULTAS','tipo_cuenta_medica_id'=>9],
                ['codigo' => '','descripcion' => 'AMBULANCIA','tipo_cuenta_medica_id'=>9],
                ['codigo' => '','descripcion' => 'VACUNACION','tipo_cuenta_medica_id'=>9],
                ['codigo' => '','descripcion' => 'CONSULTAS','tipo_cuenta_medica_id'=>9]
            ];
            foreach ($tipos as $tipo){
                CodigoGlosa::create([
                    'codigo'    => $tipo['codigo'],
                    'descripcion'    => $tipo['descripcion'],
                    'tipo_cuenta_medica_id'    => $tipo['tipo_cuenta_medica_id']
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo '
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
