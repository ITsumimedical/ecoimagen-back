<?php

namespace App\Http\Modules\Caracterizacion\Services;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Caracterizacion\Models\IntegrantesFamiliaCaracterizacionEcis;
use Illuminate\Database\Eloquent\Model;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class IntegrantesFamiliaCaracterizacionEcisService
{
    /**
     * Agrega un integrante a la caracterización ECIS de un afiliado.
     * @param array $data
     * @throws ConflictHttpException
     * @return Model
     * @author Thomas
     */
    public function agregarIntegranteCaracterizacionEcis(array $data): Model
    {
        $afiliado = Afiliado::findOrFail($data['afiliado_id']);

        // Buscar el integrante por documento
        $integrante = IntegrantesFamiliaCaracterizacionEcis::where('tipo_documento_id', $data['tipo_documento_id'])
            ->where('numero_documento', $data['numero_documento'])
            ->first();

        if ($integrante) {
            // Ya existe el integrante. ¿Está asociado a este afiliado?
            $yaAsociado = $afiliado->integrantesFamilia()
                ->where('integrante_id', $integrante->id)
                ->exists();

            if ($yaAsociado) {
                throw new ConflictHttpException('YA_EXISTE_PARA_AFILIADO');
            }

            // Existe pero no está asociado. Le delegamos al frontend la decisión.
            throw new ConflictHttpException('YA_EXISTE_EN_OTRO_AFILIADO');
        }

        // Si no existe, se crea y se asocia
        $integrante = IntegrantesFamiliaCaracterizacionEcis::create($data);

        $afiliado->integrantesFamilia()->attach($integrante->id);

        return $integrante;
    }

    /**
     * Asocia un integrante existente a la caracterización ECIS de un afiliado.
     * @param array $data
     * @throws ConflictHttpException
     * @return Model
     * @author Thomas
     */
    public function asociarIntegranteExistente(array $data): Model
    {
        $afiliado = Afiliado::findOrFail($data['afiliado_id']);

        $integrante = IntegrantesFamiliaCaracterizacionEcis::where('tipo_documento_id', $data['tipo_documento_id'])
            ->where('numero_documento', $data['numero_documento'])
            ->firstOrFail();

        // Verificar si ya está asociado
        if ($afiliado->integrantesFamilia()->where('integrante_id', $integrante->id)->exists()) {
            throw new ConflictHttpException('YA_EXISTE_PARA_AFILIADO');
        }

        // Asociar al afiliado
        $afiliado->integrantesFamilia()->attach($integrante->id);

        return $integrante;
    }
}