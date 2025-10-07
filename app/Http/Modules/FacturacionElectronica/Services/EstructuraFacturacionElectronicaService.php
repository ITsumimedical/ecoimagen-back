<?php

namespace App\Http\Modules\FacturacionElectronica\Services;

use App\Http\Modules\FacturacionElectronica\Models\Conceptoprefactura;
use App\Http\Modules\FacturacionElectronica\Repositories\EstructuraFacturaElectronicaRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EstructuraFacturacionElectronicaService
{

    public function __construct(protected EstructuraFacturaElectronicaRepository $estructuraRepository) {}

    public function createDocument(array $data)
    {

        $data['date'] = $data['date'] ?? Carbon::now()->format('Y-m-d');
        $data['time'] = $data['time'] ?? Carbon::now()->format('H:i:s');

        return $this->estructuraRepository->createEstructura($data);
    }

    public function crearConceptoPreFactura($data) {
        return Conceptoprefactura::create([
            'nombre' => $data['nombre'],
            'esta_activo' => true,
            'create_by' => Auth::id()
        ]);
    }

}
