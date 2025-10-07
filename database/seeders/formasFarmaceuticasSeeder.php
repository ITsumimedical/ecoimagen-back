<?php

namespace Database\Seeders;

use App\Http\Modules\Codesumis\FormasFarmaceuticas\Models\formasFarmaceuticas;
use Illuminate\Http\Response;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class formasFarmaceuticasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            $formas = [
                ['nombre' => 'Tableta'],
                ['nombre' => 'Capsula'],
                ['nombre' => 'Gotas Oftalmicas'],
                ['nombre' => 'Solucion Esteril'],
                ['nombre' => 'Suspension Para Inhalar'],
                ['nombre' => 'Gel'],
                ['nombre' => 'Tableta Recubierta'],
                ['nombre' => 'Ovulo'],
                ['nombre' => 'Jarabe'],
                ['nombre' => 'Locion Topica'],
                ['nombre' => 'Suspensión Oral'],
                ['nombre' => 'Crema Topica'],
                ['nombre' => 'Granulado'],
                ['nombre' => 'Polvo Para Inhlador'],
                ['nombre' => 'Solucion Inyectable'],
                ['nombre' => 'Solucion Oftalmica'],
                ['nombre' => 'Solucion Oral'],
                ['nombre' => 'Gragea'],
                ['nombre' => 'Gel Topico'],
                ['nombre' => 'Suspension'],
                ['nombre' => 'Spray Nasal'],
                ['nombre' => 'Ungüento'],
                ['nombre' => 'Polvo Efervescente'],
                ['nombre' => 'Ampolla'],
                ['nombre' => 'Polvo Esteril'],
                ['nombre' => 'Aerosol'],
                ['nombre' => 'Polvo Liofilizado'],
                ['nombre' => 'Polvo Granulado'],
                ['nombre' => 'Polvo'],
                ['nombre' => 'Parche Transdermico'],
                ['nombre' => 'Gel Oftalmico'],
                ['nombre' => 'Suspension Oral'],
                ['nombre' => 'Aerosol Nasal'],
                ['nombre' => 'Ungüento Oftalmico'],
                ['nombre' => 'Solucion Nasal'],
                ['nombre' => 'Jalea'],
                ['nombre' => 'Solucion Topica'],
                ['nombre' => 'Dispositivo Implantable'],
                ['nombre' => 'Solucion Para Inyectar'],
                ['nombre' => 'Ungüento Proctologico'],
                ['nombre' => 'Gotas Orales'],
                ['nombre' => 'Crema Vaginal'],
                ['nombre' => 'Gotas Oticas'],
                ['nombre' => 'Laca'],
                ['nombre' => 'Enema'],
                ['nombre' => 'Supositorio'],
                ['nombre' => 'Alimentos / Suplementos Dietarios'],
                ['nombre' => 'Solucion Otica'],
                ['nombre' => 'Ungüento Topico'],
                ['nombre' => 'Tableta Vaginal'],
                ['nombre' => 'Inhalador'],
                ['nombre' => 'Emulsion'],
                ['nombre' => 'Gas Medicinal'],
                ['nombre' => 'Capsula Blanda'],
                ['nombre' => 'Implante Subdermico'],
                ['nombre' => 'Polvo Para Reconstituir'],
            ];

            foreach ($formas as $forma) {
                formasFarmaceuticas::updateOrCreate([
                    'nombre' => $forma['nombre'],
                ], [
                    'nombre' => $forma['nombre'],
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de formas Farmaceuticas'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
