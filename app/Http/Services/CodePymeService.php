<?php

namespace App\Http\Services;

use App\Interfaces\FacturacionInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;

class CodePymeService implements FacturacionInterface
{
    private string $apiUrl;
    private string $apiKey;

    public function __construct()
    {
        $this->apiUrl = config('services.codepyme.api_url');
        $this->apiKey = config('services.codepyme.api_key');
    }

    public function emitirFactura(array $data)
    {
        $json = $this->json($data);
        # realizamos la peticion a codepyme con Http facade
        $response = Http::withOptions([
            'verify' => false, // Deshabilita la verificación SSL
        ])->withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ])->post($this->apiUrl . '/invoice', $json);

        if ($response->failed()) {
            throw new \Exception('Error al emitir la factura: ' . $response->body());
        }
        return $response->json();
    }

    private function json(array $data): array
    {
        return [
            "number" => $data['consecutivo'],
            "type_document_id" => 1,
            "date" => Carbon::parse($data['fecha'])->format('Y-m-d'),
            "time" => '00:00:00',
            "resolution_number" => $data['resolucion']['numero'],
            "prefix" => $data['resolucion']['prefijo'],
            "notes" => '.',
            "disable_confirmation_text" => true,
            "establishment_name" => "SUMIMEDICAL S.A.S",
            "establishment_address" => "CL 37 SUR 37 23",
            "establishment_phone" => "6045201040",
            "establishment_municipality" => 1,
            "establishment_email" => "david.cano@sumimedical.com",
            "sendmail" => true,
            "sendmailtome" => true,
            "send_customer_credentials" => true,
            "seze" => "0000-0000",
            "customer" => $this->formatearCliente($data['cliente']),
            "payment_form" => [
                "payment_form_id" => 1,
                "payment_method_id" => 10,
                "payment_due_date" => Carbon::now()->addDays(30)->format('Y-m-d'),
                "duration_measure" => 30
            ],
            "tax_totals" => [
                [
                    "tax_id" => 1,
                    "tax_amount" => 0,
                    "taxable_amount" => 0,
                    "percent" => "0"
                ]
            ],
            "legal_monetary_totals" => $this->calcularTotales($data['detalles']),
            "invoice_lines" => $this->formatearDetalles($data['detalles']),
        ];
    }

    /**
     * calcula los totales de la factura
     * @param array $detalles
     * @return array
     * @author David Pelaez
     */
    private function calcularTotales(array $detalles): array
    {
        $subtotal = 0;
        $impuesto = 0;
        foreach ($detalles as $detalle) {
            $subtotal += $detalle['cantidad'] * $detalle['precio_unitario'];
            // $impuesto += ($detalle['cantidad'] * $detalle['precio']) * ($detalle['impuesto'] / 100);
        }
        $total = $subtotal + $impuesto;
        return [
            "line_extension_amount" => (string)round($subtotal, 2),
            "tax_exclusive_amount" => (string)0,
            "tax_inclusive_amount" => (string)round($total, 2),
            "allowance_total_amount" => (string)0,
            "payable_amount" => (string)round($total, 2)
        ];
    }

    /**
     * formatea los detalles de la factura
     * @param array $detalles
     * @return array
     */
    private function formatearDetalles(array $detalles): array
    {
        $lineas = [];
        foreach ($detalles as $detalle) {
            $linea = [
                "unit_measure_id" => 99,
                "invoiced_quantity" => (string)$detalle['cantidad'],
                "line_extension_amount" => (string)($detalle['cantidad'] * $detalle['precio_unitario']),
                "free_of_charge_indicator" => false,
                "description" => $detalle['descripcion'],
                "notes" => ".",
                "code" => (string)$detalle['id'],
                "type_item_identification_id" => 1,
                "price_amount" => $detalle['precio_unitario'],
                "base_quantity" => (string)$detalle['cantidad'],
                "tax_totals" => [
                    [
                        "tax_id" => 1,
                        "tax_amount" => 0,
                        "taxable_amount" => 0,
                        "percent" => "0"
                    ]
                ],
            ];
            $lineas[] = $linea;
        }

        return $lineas;
    }

    /**
     * formatear el cliente
     * @param array $cliente
     * @return array
     * @author David Pelaez
     */
    private function formatearCliente(array $cliente): array
    {
        $data = [
            "name" => $cliente['nombre'],
            "email" => $cliente['email'],
            "type_document_identification_id" => $cliente['tipo_documento'],
            "identification_number" => $cliente['documento'],
        ];

        if ($cliente['tipo_documento'] == 6) {
            $data['dv'] = $cliente['digito_verificacion'];
        }
        if (isset($cliente['telefono']) && !empty($cliente['telefono'])) {
            $data['phone'] = $cliente['telefono'];
        }
        if (isset($cliente['direccion']) && !empty($cliente['direccion'])) {
            $data['address'] = $cliente['direccion'];
        }
        if (isset($cliente['tipo_organizacion']) && !empty($cliente['tipo_organizacion'])) {
            $data['type_organization_id'] = $cliente['tipo_organizacion'];
        }
        if (isset($cliente['responsabilidad']) && !empty($cliente['responsabilidad'])) {
            $data['type_liability_id'] = $cliente['responsabilidad'];
        }
        if (isset($cliente['municipalidad']) && !empty($cliente['municipalidad'])) {
            $data['municipality_id'] = $cliente['municipalidad'];
        }
        if (isset($cliente['regimen']) && !empty($cliente['regimen'])) {
            $data['type_regime_id'] = $cliente['regimen'];
        }

        return $data;
    }
}
