<?php

namespace App\Http\Modules\AfiliadoClasificaciones\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\NovedadesAfiliados\Models\novedadAfiliado;
use App\Http\Modules\AfiliadoClasificaciones\Models\AfiliadoClasificacion;

class AfiliadoClasificacionRepository extends RepositoryBase
{
    protected $afiliacionClasificacionModel;

    public function __construct()
    {
        $this->afiliacionClasificacionModel = new AfiliadoClasificacion();
        parent::__construct($this->afiliacionClasificacionModel);
    }

    /**
     * Listar las clasificaciones de un afiliado.
     *
     * @param int $afiliado_id
     * @return Collection
     * @author kobatime
     * @since 18 agosto 2024
     */
    public function listarAfiliacionClasificacion(int $afiliado_id)
    {
        return $this->afiliacionClasificacionModel
            ->with('clasificacion:id,nombre,descripcion,color')
            ->where('afiliado_id', $afiliado_id)
            ->where('estado', 1)
            ->get();
    }

    /**
     * Crear una nueva clasificación para un afiliado.
     *
     * @param array $data
     * @return bool|null
     * @author kobatime
     * @since 18 agosto 2024
     */
    public function crearClasificacion(array $data)
    {
        $existeClasificacion = $this->afiliacionClasificacionModel
            ->where('afiliado_id', $data['afiliado_id'])
            ->where('clasificacion_id', $data['clasificacion_id'])
            ->where('estado', 1)
            ->first();
        if ($existeClasificacion) {
            return null;
        }
        $data['user_id'] = Auth::id();
        $this->afiliacionClasificacionModel->create([
            'user_id' => $data['user_id'],
            'afiliado_id' => $data['afiliado_id'],
            'clasificacion_id' => $data['clasificacion_id'],
            'estado' => 1,
        ]);

        novedadAfiliado::create([
            'fecha_novedad' => Carbon::now(),
            'motivo' => 'Clasificacion de afiliado',
            'tipo_novedad_afiliados_id' => 4,
            'user_id' => auth()->user()->id,
            'afiliado_id' => $data['afiliado_id'],
        ]);

        return true;
    }

    
}
