<?php

namespace App\Http\Modules\Caracterizacion\Services;

use App\Http\Modules\Afiliados\Models\Afiliado;
use App\Http\Modules\Afiliados\Repositories\AfiliadoRepository;
use App\Http\Modules\Caracterizacion\Models\Encuesta;
use App\Http\Modules\Caracterizacion\Models\EncuestaUser;
use App\Http\Modules\Caracterizacion\Repositories\EncuestaRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EncuestaService {

    public function __construct(
        protected EncuestaRepository $encuestaRepository,
        protected Encuesta $encuestaModel,
        protected AfiliadoRepository $afiliadoRepository,
        protected Afiliado  $afiliadoModel
    ){}

    /**
     * Crea una encuesta
     * @author Manuela
     * @param array $data
     * @return Encuesta
     */
    public function
    crearEncuesta(array $data)
    {
        $userId = Auth::id();
        return DB::transaction(function () use ($data, $userId) {
            $encuesta = $this->encuestaRepository->crear($data);
            EncuestaUser::create([
                'encuesta_id' => $encuesta->id,
                'user_id' => $userId
            ]);
            return $encuesta;
        });
    }

    /**
     * Crea una encuesta por id
     * @author Manuela
     * @param array $data
     * @return Encuesta
     */
    public function crearEncuestaId(int $afiliado_id)
    {
        $userId = Auth::id();
        return DB::transaction(function () use ($afiliado_id, $userId) {

            $encuesta = $this->encuestaRepository->crear([
                'afiliado_id' => $afiliado_id,
            ]);

            EncuestaUser::create([
                'encuesta_id' => $encuesta->id,
                'user_id' => $userId
            ]);

            return $encuesta;
        });
    }


    /**
     * Actualiza una encuesta
     * @author Manuela
     * @param int $encuestaId
     * @param array $data
     * @return Encuesta
     */
    public function actualizarEncuesta(int $encuestaId, array $data)
    {
        $userId = Auth::id();

        return DB::transaction(function () use ($encuestaId, $data, $userId) {
            $encuesta = $this->encuestaRepository->actualizar($encuestaId, $data);
            EncuestaUser::create([
                'encuesta_id' => $encuestaId,
                'user_id' => $userId
            ]);
            return $encuesta;
        });
    }

}

