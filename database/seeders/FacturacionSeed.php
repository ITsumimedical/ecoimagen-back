<?php

namespace Database\Seeders;

use App\Http\Modules\Facturacion\FacturaCliente;
use App\Http\Modules\Facturacion\FacturaResolucion;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FacturacionSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        FacturaResolucion::create([
            'prefijo' => 'SETP',
            'numero' => '18760000001',
            'rango_inicio' => 990000000,
            'rango_fin' => 995000000,
            'actual' => 990000000,
            'fecha_expedicion' => '2019-01-18',
            'fecha_vencimiento' => '2032-12-31',
        ]);

        FacturaCliente::create([
            'nombre' => 'FIDEICOMISOS PATRIMONIOS AUTONOMOS FIDUCIARIA LA PREVISORA S.A.',
            'telefono' => '3001234567',
            'email' => 'david.cano@sumimedical.com',
            'direccion' => 'Calle 123 #45-67',
            'tipo_documento' => 6,
            'documento' => '830053105',
            'digito_verificacion' => 3,
            'municipalidad' => 1,
            'regimen' => 1,
            'responsabilidad' => 7,
            'tipo_organizacion' => 1,
        ]);
    }
}
