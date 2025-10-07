<?php

namespace App\Http\Modules\FacturaIncial\Repositories;


use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\FacturaIncial\Models\FacturaInicial;

class FacturaInicialRepository extends RepositoryBase
{
    public function __construct(protected FacturaInicial $facturaInicialModel) {
        parent::__construct($this->facturaInicialModel);
    }

    public function guardarFactura($data){
        $facturainicial = (new FastExcel)->import($data['adjunto'], function ($line) {
            return $this->facturaInicialModel::create([
                'tipo'         => $line['tipo'],
                'numero'       => $line['numero'],
                'fecha'        => $line['fecha'],
                'cod_int'      => rtrim($line['cod_int']),
                'descripcion'  => $line['descripcion'],
                'presentacion' => $line['presentacion'],
                'nom_com'      => $line['nom_com'],
                'cum'          => $line['cum'],
                'lote'         => $line['lote'],
                'fecha_vence'       => $line['f_venc'],
                'laboratorio'  => $line['laboratorio'],
                'embalaje'     => rtrim($line['embalaje']),
                'cajas'        => rtrim($line['cajas']),
                'unidades'     => $line['unidades'],
                'valor'        => rtrim($line['valor']),
                'total'        => $line['total'],
                'nit'          => $line['nit'],
                'pedido'       => $line['pedido'],
                'user'      => auth()->user()->id,
            ]);

        });
        // DB::select('exec dbo.sp_GeneraDatosFactura ' . auth()->user()->id);

        return  'Factura Cargada con exito!';
;
    }


}
