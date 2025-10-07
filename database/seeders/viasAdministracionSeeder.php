<?php

namespace Database\Seeders;

use Illuminate\Http\Response;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Http\Modules\Codesumis\viasAdministracion\Model\viasAdministracion;

class viasAdministracionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            $vias = [
                ['nombre' => 'Oral'],
                ['nombre' => 'Topica'],
                ['nombre' => 'Intravenosa/Intraarterial'],
                ['nombre' => 'Oftalmica'],
                ['nombre' => 'Subcutanea'],
                ['nombre' => 'Intravenosa'],
                ['nombre' => 'Parenteral'],
                ['nombre' => 'Conjuntival'],
                ['nombre' => 'Intramuscular'],
                ['nombre' => 'Intraocular'],
                ['nombre' => 'Inhalacion'],
                ['nombre' => 'Intranasal'],
                ['nombre' => 'Vaginal'],
                ['nombre' => 'Uretral'],
                ['nombre' => 'Intravesical'],
                ['nombre' => 'Capilar'],
                ['nombre' => 'Bucal'],
                ['nombre' => 'Sublingual'],
                ['nombre' => 'Dermica'],
                ['nombre' => 'Intramuscular/Intravenosa/Subcutanea'],
                ['nombre' => 'Intravenosa/Intramuscular'],
                ['nombre' => 'Nasal'],
                ['nombre' => 'Intra Corpus Cavernosum'],
                ['nombre' => 'Otica'],
                ['nombre' => 'Intratecal'],
                ['nombre' => 'Transdermico'],
                ['nombre' => 'Intramuscular/Intraarticular/Intralesional'],
                ['nombre' => 'Intramuscular/Intraarticular'],
                ['nombre' => 'Rectal'],
                ['nombre' => 'Epidural'],
                ['nombre' => 'Subaracnoidea'],
                ['nombre' => 'Intravenosa/Subcutanea'],
                ['nombre' => 'Dental'],
                ['nombre' => 'Bucofaringea'],
                ['nombre' => 'Intranasal/Conjuntival'],
                ['nombre' => 'Parenteral/Subcutanea'],
                ['nombre' => 'Intramuscular/Intravenosa/Intraarticular/Intralesional'],
                ['nombre' => 'Hemodialisis'],
                ['nombre' => 'Intraperitoneal'],
                ['nombre' => 'Vesical'],
                ['nombre' => 'Insuflacion'],
                ['nombre' => 'Intralinfatica'],
                ['nombre' => 'Intraarterial/Intrateca/Intravenosa'],
                ['nombre' => 'Intralesional'],
                ['nombre' => 'Intraarticular'],
                ['nombre' => 'Epidural/Intramuscular/Intratecal/Intravenosa/Subcutanea'],
                ['nombre' => 'Intramuscular/Subcutanea'],
                ['nombre' => 'Intrauterina'],
                ['nombre' => 'Topica (Externa)/Uretral'],
                ['nombre' => 'Intravenosa/Parenteral'],
                ['nombre' => 'Intramedular (Medula Del Hueso)'],
                ['nombre' => 'Intracavernosa'],
                ['nombre' => 'Intramuscular/Intravenosa/Intraespinal'],
                ['nombre' => 'Oral/Vaginal'],
                ['nombre' => 'Intradermal'],
                ['nombre' => 'Intracardiaca'],
                ['nombre' => 'Nebulizada'],
                ['nombre' => 'Intratraqueal'],
                ['nombre' => 'Intravenosa/Oral'],


            ];
            foreach ($vias as $via) {
                viasAdministracion::updateOrCreate([
                    'nombre' => $via['nombre'],
                ], [
                    'nombre' => $via['nombre'],
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de vias de administracion'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
