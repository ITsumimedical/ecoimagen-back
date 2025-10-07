<?php

namespace App\Http\Modules\Historia\AntecedentesEcomapas\Services;

use App\Http\Modules\Historia\AntecedentesEcomapas\Models\AntecedenteEcomapa;
use Illuminate\Support\Facades\Log;

class AntecedenteEcomapaService {

    public function guardarAntecedentes($request) {
            $antecedente = new AntecedenteEcomapa();
            $antecedente->asiste_colegio = $request['asiste_colegio'] ? 1 : 0;
            $antecedente->comparte_amigos = $request['comparte_amigos'] ? 1 : 0;
            $antecedente->comparte_vecinos = $request['comparte_vecinos'] ? 1 : 0;
            $antecedente->pertenece_club_deportivo = $request['pertenece_club_deportivo'] ? 1 : 0;
            $antecedente->pertenece_club_social_cultural = $request['pertenece_club_social_cultural'] ? 1 : 0;
            $antecedente->asiste_iglesia = $request['asiste_iglesia'] ? 1 : 0;
            $antecedente->trabaja = $request['trabaja'] ? 1 : 0;
            $antecedente->medico_registra = auth()->id();
            $antecedente->consulta_id = $request['consulta_id'];
            $antecedente->save();
    }
}
