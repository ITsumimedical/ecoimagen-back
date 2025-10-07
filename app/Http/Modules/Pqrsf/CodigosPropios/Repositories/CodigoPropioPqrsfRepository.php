<?php

namespace App\Http\Modules\Pqrsf\CodigosPropios\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\GestionPqrsf\Formulario\Models\Formulariopqrsf;
use App\Http\Modules\Pqrsf\CodigosPropios\Models\CodigoPropioPqrsf;
use Illuminate\Http\JsonResponse;

class CodigoPropioPqrsfRepository extends RepositoryBase
{

    protected $codigos;

    public function __construct()
    {
        $this->codigos = new CodigoPropioPqrsf();
        parent::__construct($this->codigos);
    }

    public function listarCodigos($data)
    {
        return $this->codigos::where('formulariopqrsf_id', $data['pqr_id'])->with('codigoPropio')->get();
    }

    public function crearCodigoPropio($codigo, $formulariopqrsf_id)
    {
        $this->codigos::create(['codigo_propio_id' => $codigo, 'formulariopqrsf_id' => $formulariopqrsf_id]);
    }

    public function eliminar($data)
    {
        return   $this->codigos::find($data['codigo'])->delete();
    }

    /**
     * Actualiza los codigos propios de una PQRSF
     * @param int $pqrsfId
     * @param array<array<int>> $request
     * @return JsonResponse
     * @author Thomas
     */
    public function actualizarCodigosPropios($pqrsfId, $request)
    {
        $pqrsf = Formulariopqrsf::findOrFail($pqrsfId);

        $pqrsf->codigoPropioPqrsf()->syncWithoutDetaching($request['codigos_propios']);

        return response()->json(['message' => 'Codigos Propios actualizados correctamente.']);
    }

    /**
     * Elimina un Codigo Propio de una PQRSF
     * @param int $pqrsfId
     * @param array<int> $request
     * @return JsonResponse
     * @author Thomas
     */
    public function removerCodigoPropio($pqrsfId, $request)
    {
        $pqrsf = Formulariopqrsf::findOrFail($pqrsfId);

        // Eliminamos la relacion en la tabla intermedia
        $pqrsf->codigoPropioPqrsf()->detach($request['codigo_propio']);

        return response()->json(['message' => 'Codigo Propio removido correctamente.']);
    }
}
