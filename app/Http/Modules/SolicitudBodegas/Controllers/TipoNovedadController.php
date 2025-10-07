<?php

namespace App\Http\Modules\SolicitudBodegas\Controllers;

use App\Http\Modules\SolicitudBodegas\Models\TipoNovedadSolicitud;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

use Throwable;



class TipoNovedadController extends Controller
{
    public function listar()
    {
        return response()->json(TipoNovedadSolicitud::all());
    }
}
