<?php

namespace App\Http\Modules\Eventos\EventosAsignados\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Eventos\EventosAsignados\Models\EventoAsignado;

class EventoAsignadoRepository extends RepositoryBase {

    protected $eventoAsignadoRepository;

    public function __construct(){
        $this->eventoAsignadoRepository = new EventoAsignado();
        parent::__construct($this->eventoAsignadoRepository);
    }

    public function crearRegistro($request){
        foreach ($request['empleado_asignado'] as $gestion) {
            $nuevaGestion = $this->eventoAsignadoRepository::firstOrCreate([
                'evento_adverso_id' => $request['id'],
                'user_id' => $gestion,
            ]);
        }
        return $nuevaGestion;
    }

    public function listarUsuarios($id){
        $usuarios = EventoAsignado::select('evento_asignados.user_id', 'evento_asignados.id',
        'operadores.id as empleado_id')
        ->selectRaw("CONCAT(operadores.nombre, ' ',operadores.apellido) as nombre_empleado")
        ->where('evento_adverso_id',$id)
        ->leftJoin('operadores', 'evento_asignados.user_id', 'operadores.user_id')
        ->get();

        return $usuarios;
    }
}
