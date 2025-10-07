<?php

namespace App\Http\Modules\Historia\AntecedentesHospitalarios\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Modules\Historia\AntecedentesHospitalarios\Repositories\AntecedentesHospitalariosRepository;

class AntecedentesHospitalariosController extends Controller
{
    public function __construct(private AntecedentesHospitalariosRepository $antecedentesHospitalariosRepository) {

    }

    public function listarHospitalario(Request $request) {
        try {
            $antecedentes =  $this->antecedentesHospitalariosRepository->listarAntecedentes($request);
            return response()->json($antecedentes);
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al consultar los antecedentes hospitalarios',
                $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function guardar(Request $request) {
        try {
            $this->antecedentesHospitalariosRepository->crearAntecedente($request->all());
            return response()->json([
                'mensaje' => 'Los antecedentes hospitalarios guardados con exito.'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            return response()->json([
                'error' => $th->getMessage()
            ], Response::HTTP_BAD_REQUEST);
        }
    }

    public function eliminar($id)
    {
        try {
            $this->antecedentesHospitalariosRepository->eliminarAntecedente($id);
            return response()->json(['message' => 'Eliminado con éxito'], 200);
        } catch (\Throwable $th) {
            return response()->json(['Error' => $th->getMessage()], 400);
        }
    }
}
