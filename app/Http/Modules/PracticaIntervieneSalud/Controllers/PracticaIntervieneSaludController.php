<?php

namespace App\Http\Modules\PracticaIntervieneSalud\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\PracticaIntervieneSalud\Repositories\PracticaIntervieneSaludRepository;

class PracticaIntervieneSaludController extends Controller
{

    private $practicaIntervieneSaludRepository;

    public function __construct()
    {
        $this->practicaIntervieneSaludRepository = new PracticaIntervieneSaludRepository();
    }

    public function listarTodas()
    {
        try {
            $practicaIntervieneSalud = $this->practicaIntervieneSaludRepository->listarTodas();
            return response()->json($practicaIntervieneSalud, 200);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), 400);
        }
    }
    
}