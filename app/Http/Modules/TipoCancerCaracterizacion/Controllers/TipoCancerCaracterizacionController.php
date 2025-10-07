<?php 

namespace App\Http\Modules\TipoCancerCaracterizacion\Controllers;
use App\Http\Controllers\Controller;
use App\Http\Modules\TipoCancerCaracterizacion\Repositories\TipoCancerCaracterizacionRepository;
use Illuminate\Http\Response;

class TipoCancerCaracterizacionController extends Controller
{
    private $repository;

    public function __construct(){
        $this->repository = new TipoCancerCaracterizacionRepository();
    }

    public function listarTodas(){
        try {
            $tipoCancer = $this->repository->listarTodas();
            return response()->json($tipoCancer, Response::HTTP_OK);
        } catch (\Throwable $th) {
            return response()->json($th->getMessage(), Response::HTTP_BAD_REQUEST);
        }
    }
    
}