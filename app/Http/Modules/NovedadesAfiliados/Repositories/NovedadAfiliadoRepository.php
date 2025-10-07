<?php

namespace App\Http\Modules\NovedadesAfiliados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\NovedadesAfiliados\Models\novedadAfiliado;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class NovedadAfiliadoRepository extends RepositoryBase
{
    protected $novedadAfiliadoModel;

    public function __construct()
    {
        $this->novedadAfiliadoModel = new novedadAfiliado();
        parent::__construct($this->novedadAfiliadoModel);
    }

    /**
     * Crear una novedad para un afiliado.
     *
     * @param int $afiliado_id
     * @param object $data
     * @return NovedadAfiliado
     * @author kobatime
     * @since 18 agosto 2024
     */
    public function crearNovedadAfiliado(int $afiliado_id, $data)
    {
        $novedadData = [
            'fecha_novedad' => $data->actualizacionTotal == 1 ? $data->fecha_novedad : Carbon::now(),
            'motivo' => $data->actualizacionTotal == 1 ? $data->motivo : 'Creación de afiliado',
            'tipo_novedad_afiliados_id' => $data->actualizacionTotal == 1 ? $data->tipo_novedad_id : 1,
            'user_id' => Auth::id(),
            'afiliado_id' => $afiliado_id,
        ];

        return $this->novedadAfiliadoModel->create($novedadData);
    }

    /**
     * Crear una novedad de entrada para un afiliado.
     *
     * @param array $request
     * @param int $id
     * @return NovedadAfiliado
     */
    public function crearNovedadEntrada(array $request, int $id)
    {
        return $this->novedadAfiliadoModel->create([
            'fecha_novedad' => Carbon::now(),
            'motivo' => 'Nueva Portabilidad de Entrada',
            'documento_afiliado' => $request['numero_documento'] ?? '',
            'user_id' => Auth::id(),
            'tipo_novedad_afiliados_id' => 8,
            'portabilidad_entrada_id' => $id,
            'afiliado_id' => $request['afiliado_id']
        ]);
    }

    /**
     * Crear una novedad de salida para un afiliado.
     *
     * @param array $request
     * @param int $id
     * @return NovedadAfiliado
     */
    public function crearNovedadSalida(array $request, int $id)
    {
        return $this->novedadAfiliadoModel->create([
            'fecha_novedad' => Carbon::now(),
            'motivo' => 'Nueva Portabilidad de Salida',
            'documento_afiliado' => $request['numero_documento'],
            'user_id' => Auth::id(),
            'tipo_novedad_afiliados_id' => 5,
            'portabilidad_salida_id' => $id,
            'afiliado_id' => $request['afiliado_id'],
        ]);
    }

    /**
     * Crear una novedad genérica para un afiliado.
     *
     * @param array $data
     * @return NovedadAfiliado
     */
    public function crearNovedad(array $data)
    {
        return $this->novedadAfiliadoModel->create($data);
    }

    /**
     * Crear una novedad de entrada.
     *
     * @param array $data
     * @return NovedadAfiliado
     */
    public function NovedadEntrada(array $data)
    {
        return $this->novedadAfiliadoModel->create($data);
    }

    /**
     * Buscar novedades de un afiliado.
     *
     * @param int $afiliado_id
     * @param object $request
     * @return mixed
     * @author kobatime
     * @since 18 agosto 2024
     */
    public function buscarNovedadAfiliado(int $afiliado_id, $request)
    {
        $consulta = $this->novedadAfiliadoModel->with([
            'tipoNovedad:id,nombre',
            'usuario:id,email',
            'usuario.operador:user_id,id,nombre,apellido'
        ])->where('afiliado_id', $afiliado_id)
            ->orderBy('id', 'desc');

        return $request->page ? $consulta->paginate($request->cant) : $consulta->get();
    }

    /**
     * Busca una novedad por su id.
     * @param mixed $novedadId
     * @return object
     */
    public function buscarNovedadPorId($novedadId)
    {
        return $this->novedadAfiliadoModel->with(['tipoNovedad', 'usuario.operador', 'afiliado', 'adjuntos'])->where('id', $novedadId)->first();
    }

    public function guardarNovedadAdmision($id_afiliado){
            novedadAfiliado::create([
            'afiliado_id' => $id_afiliado,
            'motivo' => "Creación de Afiliado",
            'fecha_novedad' => Carbon::now(),
            'user_id' => auth()->user()->id,
            'tipo_novedad_afiliados_id' => 1
        ]);
    }
}
