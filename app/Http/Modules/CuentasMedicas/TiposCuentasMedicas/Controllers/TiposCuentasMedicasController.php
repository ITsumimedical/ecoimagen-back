<?php

namespace App\Http\Modules\CuentasMedicas\TiposCuentasMedicas\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Modules\CuentasMedicas\TiposCuentasMedicas\Repositories\TipoCuentaMedicaRepository;
use App\Http\Modules\CuentasMedicas\TiposCuentasMedicas\Requests\CrearTipoCuentaMedicaRequest;
use Illuminate\Http\Request;

class TiposCuentasMedicasController extends Controller
{
    private $tipoCuentasMedicasRepository;

     function __construct(TipoCuentaMedicaRepository $tipoCuentasMedicasRepository){
        $this->tipoCuentasMedicasRepository = $tipoCuentasMedicasRepository;
    }

    /**
     * listar los tipo de Cuentas medicas
     * @param Request $request
     * @return Response $tipoCuentaMedica
     * @author JDSS
     */

     public function listar(Request $request){
        try {
            $tipoCuentaMedica = $this->tipoCuentasMedicasRepository->listar($request);
            return response()->json($tipoCuentaMedica);
        } catch(\Throwable $th) {
            return response()->json(false);
        }
    }

    /**
     * crea un tipo de Cuentas medicas
     * @param Request $request
     * @return Response $tipoCuentaMedica
     * @author JDSS
     */

     public function guardar(CrearTipoCuentaMedicaRequest $request){
        try {
            $tipoCuentaMedica = $this->tipoCuentasMedicasRepository->crear($request->validated());
            return response()->json($tipoCuentaMedica);
        } catch (\Throwable $th) {
            return response()->json(false);

        }
     }

}


