<?php

namespace App\Http\Modules\AsistenciaEducativa\Repositories;

use App\Http\Modules\AsistenciaEducativa\Models\AsistenciaEducativa;
use App\Http\Modules\Bases\RepositoryBase;
use Illuminate\Http\Request;

class AsistenciaEducativaRepository extends RepositoryBase
{

    public function __construct(protected AsistenciaEducativa $asistenciaEducativaModel)
    {
        parent::__construct($this->asistenciaEducativaModel);
    }

    public function listarAsistencia(Request $request)
    {
        $cantidad = $request->get('cantidad', 10);
        $asistencia = AsistenciaEducativa::select(
            'asistencia_educativas.id',
            'asistencia_educativas.fecha',
            'asistencia_educativas.ambito',
            'asistencia_educativas.finalidad',
            'cups.nombre as Nombre_cups',
            'asistencia_educativas.tema',
            'afiliados.numero_documento as Cedula'
        )
            ->join('cups', 'asistencia_educativas.cup_id', 'cups.id')
            ->join('afiliados', 'asistencia_educativas.afiliado_id', 'afiliados.id')
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ', afiliados.primer_apellido, ' ', afiliados.segundo_apellido) as nombre_completo")
            ->join('users', 'asistencia_educativas.usuario_registra_id', 'users.id')
            ->join('empleados', 'users.id', 'empleados.user_id')
            ->selectRaw("CONCAT(empleados.primer_nombre, ' ', empleados.primer_apellido) as nombre_completo")
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ' ,afiliados.segundo_nombre, ' ', afiliados.primer_apellido, ' ', afiliados.segundo_apellido) as NombreAfiliado")
            ->orderBy('asistencia_educativas.id', 'asc');
            if ($request->has('page')) {
                return $asistencia->paginate($cantidad);
            } else {
                return $asistencia->get();
            }
    }
}
