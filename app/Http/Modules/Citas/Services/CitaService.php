<?php

namespace App\Http\Modules\Citas\Services;

use App\Http\Modules\CampoHistorias\Models\CampoHistoria;
use App\Http\Modules\CategoriaHistorias\Models\CategoriaHistoria;
use App\Http\Modules\Citas\Models\Cita;
use App\Http\Modules\Citas\Repositories\CitaRepository;
use App\Http\Modules\Consultas\Repositories\ConsultaRepository;
use App\Http\Modules\PlantillaHistoria\Models\PlantillaCategoria;
use App\Http\Modules\PlantillaHistoria\Models\PlantillaHistoria;


class CitaService
{
    protected CitaRepository $citaRepository;

    public function __construct(CitaRepository $citaRepository)
    {
        $this->citaRepository = $citaRepository;
    }

    public function aplicarPlantillas($request){
        switch ($request["tipo"]) {
            case 1:
                $plantillaHistoria = PlantillaHistoria::find($request["componente"]);
                $cita = Cita::find($request["cita"]);
                foreach($plantillaHistoria->categorias as $categoria){
                    $categoriaHistoria = CategoriaHistoria::create([
                        'nombre' => $categoria['nombre'],
                        'titulo' => $categoria['nombre'],
                        'editable' => 0
                    ]);
                    $categoriaHistoria->citas()->attach($cita->id,['orden'=> $categoria['orden']]);
                    foreach($categoria['campos'] as $campo){
                        CampoHistoria::create([
                            'nombre' => $campo['nombre'],
                            'ciclo_vida' => $this->getCicloVida($campo['ciclo_vida']),
                            'requerido' => intval($campo['requerido']),
                            'columnas' => $campo['columnas'],
                            'categoria_historia_id' => $categoriaHistoria['id'],
                            'tipo_campo_id' => $campo['tipo_campo_id'],
                            'opciones' => $campo['opciones'],
                            'orden' => $campo['orden'],
                            'subcategoria_id' => $campo['subcategoria_id']
                        ]);
                    }
                }
                break;
            case 2:
                $ordenAsignado = 0;
                $cita = Cita::with(['categorias'])->find($request["cita"]);
                if(count($cita->categorias) > 0){
                    $utimaOrden = max(array_column(array_column($cita->categorias->toArray(),'pivot'),'orden'));
                    $ordenAsignado = $utimaOrden;
                }
                $categoriaPlantilla = PlantillaCategoria::find($request["componente"]);
                $categoriaHistoria = CategoriaHistoria::create([
                    'nombre' => $categoriaPlantilla['nombre'],
                    'titulo' => $categoriaPlantilla['nombre'],
                    'editable' => 0
                ]);


                $categoriaHistoria->citas()->attach($cita->id,['orden'=> $ordenAsignado+1]);
                foreach($categoriaPlantilla->campos as $campo){
                    CampoHistoria::create([
                        'nombre' => $campo['nombre'],
                        'ciclo_vida' => $this->getCicloVida($campo['ciclo_vida']),
                        'requerido' => intval($campo['requerido']),
                        'columnas' => $campo['columnas'],
                        'categoria_historia_id' => $categoriaHistoria['id'],
                        'tipo_campo_id' => $campo['tipo_campo_id'],
                        'opciones' => $campo['opciones'],
                        'orden' => $campo['orden'],
                        'subcategoria_id' => $campo['subcategoria_id']
                    ]);
                }
                break;
        }
    }

    public function getCicloVida($ciclo){
        $ciclos = [
            ['id' => 1 ,'nombre' => 'Primera infancia'],
            ['id' => 2 ,'nombre' => 'Infancia'],
            ['id' => 3 ,'nombre' =>'Juventud'],
            ['id' => 4 ,'nombre' =>'Vejez'],
            ['id' => 5 ,'nombre' =>'Todos']
        ];
        $key = array_search(intval($ciclo),array_column($ciclos,'id'));

        return $ciclos[$key]['nombre'];
    }

    /**
     * agregarRepsPorCita
     * Añadir reps a una cita
     * @param  mixed $data
     * @return void
     * @author Serna
     */
    public function agregarRepsPorCita(array $data)
    {
        $cita = Cita::where('id', $data['cita_id'])->first();
        $cita->citasReps()->sync($data['rep_id']);
        return $cita;
    }

    /**
     * activa la cita para salir en el panel de autogestion
     * @param array $data
     * @param int $id
     * @return 
     */
    public function activarAutogestion(int $id)
    {
        $cita = $this->citaRepository->buscarCitaPorId($id);
        return $cita->update([
            'activo_autogestion' => !$cita->activo_autogestion
        ]);
    }
}
