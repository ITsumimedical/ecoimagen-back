<?php

namespace App\Http\Modules\FacturacionElectronica\Repositories;

use App\Formats\Prefactura;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\FacturacionElectronica\Models\Conceptoprefactura;
use App\Http\Modulos\Factura\Models\Registrofacturasumimedical;
use Illuminate\Support\Facades\DB;

class EstructuraFacturaElectronicaRepository extends RepositoryBase
{
    public function __construct(protected Registrofacturasumimedical $registrofacturasumimedical, protected Conceptoprefactura $conceptoprefacturaModel)
    {
        parent::__construct($registrofacturasumimedical);
    }

    /**
     * Crea nueva estructura de facturacion en la base de datos.
     *
     * @param array $data Los datos de la estructura.
     * @return Estructura_factura_electronica
     */
    public function createEstructura(array $data)
    {
        return $this->model->create($data);
    }
    /**
     * Obtiene las facturas electrónicas pendientes de ser facturadas.
     *
     * @param $request
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function facturasElectronicasPendientes($request)
    {

        $perPage = $request->input('per_page', 2000);
        $page = $request->input('page', 1);
        $search = $request->input('search');
        $fechaDesde = $request->input('fecha_desde');
        $fechaHasta = $request->input('fecha_hasta');

        $query = $this->registrofacturasumimedical
            ->select([
                'registrofacturasumimedicals.id',
                'registrofacturasumimedicals.sede_atencion_id',
                'registrofacturasumimedicals.afiliado_id',
                'registrofacturasumimedicals.consulta_id',
                'registrofacturasumimedicals.codigo_empresa',
                'registrofacturasumimedicals.codigo_clasificacion',
                'registrofacturasumimedicals.fecha_ingreso',
                'registrofacturasumimedicals.hora_ingreso',
                'registrofacturasumimedicals.medico_atiende_id',
                'registrofacturasumimedicals.contrato',
                'registrofacturasumimedicals.codigo_diagnostico',
                'registrofacturasumimedicals.codigo_cup',
                'registrofacturasumimedicals.descripcion_cup',
                'registrofacturasumimedicals.cantidad_cup',
                'registrofacturasumimedicals.valor_cup',
                'registrofacturasumimedicals.estado',
                'reps.nombre as sede_atencion',
                'afiliados.numero_documento',
                'operadores.nombre as medico_atiende'
            ])
            ->leftjoin('reps', 'registrofacturasumimedicals.sede_atencion_id', 'reps.id')
            ->join('afiliados', 'registrofacturasumimedicals.afiliado_id', 'afiliados.id')
            ->leftjoin('operadores', 'registrofacturasumimedicals.medico_atiende_id', 'operadores.user_id');
            // ->where('registrofacturasumimedicals.estado', false)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('afiliados.numero_documento', 'ILIKE', "%{$search}%")
                    // ->orWhere('log_sismas.estudio', 'ILIKE', "%{$search}%")
                    ->orWhere('registrofacturasumimedicals.descripcion_cup', 'ILIKE', "%{$search}%");
                    // ->orWhere('entidades.nombre', 'ILIKE', "%{$search}%")
                    // ->orWhereRaw("(CASE WHEN log_sismas.estado_factura_sisma = true THEN 'facturado' ELSE 'pendiente' END) ILIKE ?", ["%{$search}%"]);
            });
        }

        if ($fechaDesde) {
            $query->whereDate('registrofacturasumimedicals.fecha_ingreso', '>=', $fechaDesde);
        }

        if ($fechaHasta) {
            $query->whereDate('registrofacturasumimedicals.fecha_ingreso', '<=', $fechaHasta);
        }

        $total = $query->count();

        $totalPendientes = (clone $query)
            // ->where('registrofacturasumimedicals.estado', false)
            ->count();

        $items = $query->offset(($page - 1) * $perPage)
            ->limit($perPage)
            ->get();

        return response()->json([
            'items' => $items,
            'total' => $total,
            'totalPendientes' => $totalPendientes,
        ]);
    }

    public function preFactura(array $data)
    {
         $pdf = new Prefactura();
        return $pdf->generar($data);
    }

    public function listarConceptoPreFactura() {
        return Conceptoprefactura::all();
    }

}
