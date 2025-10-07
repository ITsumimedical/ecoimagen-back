<?php

namespace App\Http\Services;

use App\Http\Modulos\Factura\Models\Registrofacturasumimedical;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class facturacionElectronicaService
{
    protected $baseUrl = 'https://integracion.sismacorporation.com/api/';
    protected $token;

    /**
     * Autenticacion con API de facturacion Electronica DIVERGENTE
     *
     * @return void
     */
    // public function logisFacturacionDivergente()
    // {
    //     $response = Http::post($this->baseUrl . 'Auth/login', [
    //         'usuario' => 'AppHorus',
    //         'password'   => 'horus123*',
    //     ]);

    //     if ($response->successful()) {
    //         $this->token = $response->json()['token'];
    //         return $this->token;
    //     }

    //     throw new \Exception('Error al autenticar con Sisma: ' . $response->body());
    // }

    // $datosFactura = [
    //     "number" => 990000961,
    //     "type_document_id" => 1,
    //     "date" => "2024-03-14",
    //     "time" => "04:08:12",
    //     "resolution_number" => "18760000001",
    //     "prefix" => "SETP",
    //     "notes" => "ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA, ESTA ES UNA NOTA DE PRUEBA",
    //     "disable_confirmation_text" => true,
    //     "establishment_name" => "RAZON SOCIAL",
    //     "establishment_address" => "DIRECCION",
    //     "establishment_phone" => "NUMERO TELEFONO ",
    //     "establishment_municipality" => 600,
    //     "atacheddocument_name_prefix" => "FES-SETP990000244-",
    //     "establishment_email" => "alternate_email@alternate.com",
    //     "sendmail" => true,
    //     "seze" => "2021-2017",
    //     "head_note" => "PRUEBA DE TEXTO LIBRE QUE DEBE POSICIONARSE EN EL ENCABEZADO DE PAGINA DE LA REPRESENTACION GRAFICA DE LA FACTURA ELECTRONICA VALIDACION PREVIA DIAN",
    //     "foot_note" => "PRUEBA DE TEXTO LIBRE QUE DEBE POSICIONARSE EN EL PIE DE PAGINA DE LA REPRESENTACION GRAFICA DE LA FACTURA ELECTRONICA VALIDACION PREVIA DIAN",
    //     "health_fields" => [
    //         "invoice_period_start_date" => "2024-02-01",
    //         "invoice_period_end_date" => "2024-03-01",
    //         "health_type_operation_id" => 1,
    //         "users_info" => [
    //             [
    //                 "provider_code" => "AF-0000500-85-XX-001",
    //                 "health_type_document_identification_id" => 4,
    //                 "identification_number" => "A89008003",
    //                 "surname" => "OBANDO",
    //                 "second_surname" => "LONDOÑO",
    //                 "first_name" => "ALEXANDER",
    //                 "health_type_user_id" => 1,
    //                 "health_contracting_payment_method_id" => 2,
    //                 "health_coverage_id" => 5,
    //                 "autorization_numbers" => "A12345;604567;AX-2345",
    //                 "mipres" => "RNA3D345;664FF04567;ARXXX-2765345",
    //                 "mipres_delivery" => "RN6645G-345;6-064XX54FF04567;XXX-2-OO-987D65345",
    //                 "contract_number" => "1000-2021-0005698",
    //                 "policy_number" => "1045-2FG01-0567228",
    //                 "co_payment" => "3300.00",
    //                 "moderating_fee" => "5800.00",
    //                 "recovery_fee" => "105000.00",
    //                 "shared_payment" => "225000.00"
    //             ],
    //             [
    //                 "provider_code" => "AF-0000500-85-XX-002",
    //                 "health_type_document_identification_id" => 3,
    //                 "identification_number" => "41946692",
    //                 "surname" => "CARDONA",
    //                 "second_surname" => "VILLADA",
    //                 "first_name" => "ELIZABETH",
    //                 "health_type_user_id" => 2,
    //                 "health_contracting_payment_method_id" => 3,
    //                 "health_coverage_id" => 3,
    //                 "autorization_numbers" => "A12345;604567;AX-2345",
    //                 "mipres" => "RNA3D345;664FF04567;ARXXX-2765345",
    //                 "mipres_delivery" => "RN6645G-345;6-064XX54FF04567;XXX-2-OO-987D65345",
    //                 "contract_number" => "1000-2021-0005698",
    //                 "policy_number" => "1045-2FG01-0567228",
    //                 "co_payment" => "3300.00",
    //                 "moderating_fee" => "5800.00",
    //                 "recovery_fee" => "105000.00",
    //                 "shared_payment" => "225000.00"
    //             ]
    //         ]
    //     ],
    //     "customer" => [
    //         "identification_number" => 900166483,
    //         "dv" => 1,
    //         "name" => "INVERSIONES DAVAL SAS",
    //         "phone" => "3103891693",
    //         "address" => "CLL 4 NRO 33-90",
    //         "email" => "alexanderobandolondono@gmail.com",
    //         "merchant_registration" => "0000000-00",
    //         "type_document_identification_id" => 6,
    //         "type_organization_id" => 1,
    //         "type_liability_id" => 7,
    //         "municipality_id" => 822,
    //         "type_regime_id" => 1
    //     ],
    //     "payment_form" => [
    //         "payment_form_id" => 2,
    //         "payment_method_id" => 30,
    //         "payment_due_date" => "2024-04-17",
    //         "duration_measure" => "30"
    //     ],
    //     "prepaid_payment" => [
    //         "idpayment" => "A3123856",
    //         "prepaid_payment_type_id" => 1,
    //         "paidamount" => "100000.00",
    //         "receiveddate" => "2023-03-01",
    //         "paiddate" => "2023-03-05",
    //         "instructionid" => "PRUEBA DE PREPAGO RECIBIDO"
    //     ],
    //     "allowance_charges" => [
    //         [
    //             "discount_id" => 1,
    //             "charge_indicator" => false,
    //             "allowance_charge_reason" => "DESCUENTO GENERAL",
    //             "amount" => "230000.00",
    //             "base_amount" => "9663865.54"
    //         ]
    //     ],
    //     "legal_monetary_totals" => [
    //         "line_extension_amount" => "9663865.54",
    //         "tax_exclusive_amount" => "9663865.55",
    //         "tax_inclusive_amount" => "11500000.00",
    //         "allowance_total_amount" => "230000.00",
    //         "charge_total_amount" => "0.00",
    //         "pre_paid_amount" => "100000.00",
    //         "payable_amount" => "11270000.00"
    //     ],
    //     "tax_totals" => [
    //         [
    //             "tax_id" => 1,
    //             "tax_amount" => "1836134.45",
    //             "percent" => "19",
    //             "taxable_amount" => "9663865.55"
    //         ]
    //     ],
    //     "invoice_lines" => [
    //         [
    //             "unit_measure_id" => 70,
    //             "invoiced_quantity" => "1",
    //             "line_extension_amount" => "1260504.20",
    //             "free_of_charge_indicator" => false,
    //             "allowance_charges" => [
    //                 [
    //                     "charge_indicator" => false,
    //                     "allowance_charge_reason" => "DESCUENTO GENERAL",
    //                     "amount" => "30000.00",
    //                     "base_amount" => "1500000.00"
    //                 ]
    //             ],
    //             "tax_totals" => [
    //                 [
    //                     "tax_id" => 1,
    //                     "tax_amount" => "239495.80",
    //                     "taxable_amount" => "1260504.20",
    //                     "percent" => "19.00"
    //                 ]
    //             ],
    //             "description" => "BONOS POR SERVICIOS",
    //             "code" => "BONOS",
    //             "type_item_identification_id" => 4,
    //             "price_amount" => "1290504.20",
    //             "base_quantity" => "1"
    //         ],
    //         [
    //             "unit_measure_id" => 70,
    //             "invoiced_quantity" => "1",
    //             "line_extension_amount" => "8403361.34",
    //             "free_of_charge_indicator" => false,
    //             "allowance_charges" => [
    //                 [
    //                     "charge_indicator" => false,
    //                     "allowance_charge_reason" => "DESCUENTO GENERAL",
    //                     "amount" => "200000.00",
    //                     "base_amount" => "10000000.00"
    //                 ]
    //             ],
    //             "tax_totals" => [
    //                 [
    //                     "tax_id" => 1,
    //                     "tax_amount" => "1596638.65",
    //                     "taxable_amount" => "8403361.34",
    //                     "percent" => "19.00"
    //                 ]
    //             ],
    //             "description" => "COMISION POR SERVICIOS",
    //             "notes" => "ESTA ES UNA PRUEBA DE NOTA DE DETALLE DE LINEA.",
    //             "code" => "COMISION",
    //             "type_item_identification_id" => 4,
    //             "price_amount" => "8603361.34",
    //             "base_quantity" => "1"
    //         ]
    //     ]
    // ];

    public function procesoFacturaDian($datosFactura,)
    {
        // if (!$this->token) {
        //     $this->loginApiSisma();
        // }

        $response = Http::withToken($this->token)
            ->post($this->baseUrl . 'Facturacion/GenerarAdmision', $datosFactura);

        $respuestaDecodificada = json_decode($response->body(), true);
        return $respuestaDecodificada;
        // if ($response->successful()) {
        //     return $response->body();
        // }

        // throw new \Exception('Error al crear paciente: ' . $response->body());
    }

    public function guardarConsultasAfacturar($datosAdmision)
    {
        // dd('datosAdmision', $datosAdmision);

        $registroFactura = Registrofacturasumimedical::firstOrCreate(
            [
                'consulta_id' => $datosAdmision['consulta_id'],
                'codigo_cup'      => $datosAdmision['cups'][0]['codigo'],
            ],
            [
                'sede_atencion_id'     => $datosAdmision['sede_atencion_id'],
                'afiliado_id'          => $datosAdmision['afiliado_id'],
                'codigo_empresa'       => $datosAdmision['codigo_empresa'],
                'codigo_clasificacion' => $datosAdmision['codigo_clasificacion'],
                'fecha_ingreso'        => $datosAdmision['fecha_ingreso'],
                'hora_ingreso'         => $datosAdmision['hora_ingreso'],
                'medico_atiende_id'    => $datosAdmision['medico_atiende_id'],
                'contrato'             => $datosAdmision['contrato'],
                'codigo_diagnostico'   => $datosAdmision['codigo_diagnostico'],
                'codigo_cup'           => $datosAdmision['cups'][0]['codigo'],
                'descripcion_cup'      => $datosAdmision['cups'][0]['descripcion'],
                'cantidad_cup'         => $datosAdmision['cups'][0]['cantidad'],
                'valor_cup'            => $datosAdmision['cups'][0]['valor'],
                'created_by'           => Auth::id(),
            ]
        );
        return $registroFactura;
    }
}
