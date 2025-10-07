<?php

namespace App\Http\Modules\Empalme\Repositories;


use App\Http\Modules\Empalme\Models\Empalme;
use App\Http\Modules\Afiliados\Models\Afiliado;
use Illuminate\Http\Request;

class EmpalmeRepository
{

    public function listarAfiliadosPorCedulaConEntidadEspecifica($cedula)
    {
        $afiliado = Afiliado::select(
            'afiliados.id',
            'afiliados.numero_documento as cedula',
            'afiliados.primer_nombre',
            'afiliados.segundo_nombre',
            'afiliados.primer_apellido',
            'afiliados.segundo_apellido',
            'afiliados.sexo',
            'afiliados.fecha_nacimiento',
            'afiliados.edad_cumplida',
            'afiliados.entidad_id',
            'afiliados.tipo_cotizante',
            'entidades.nombre as nombre_entidad',
            'tipo_documentos.nombre as Tipo_Documento',
            'departamentos.nombre as Departamento_afiliacion',
            'municipios.nombre as Municipio_afiliacion'
        )
            ->join('entidades', 'afiliados.entidad_id', 'entidades.id')
            ->join('tipo_documentos', 'afiliados.tipo_documento', 'tipo_documentos.id')
            ->join('departamentos', 'afiliados.departamento_afiliacion_id', 'departamentos.id')
            ->join('municipios', 'afiliados.municipio_afiliacion_id', 'municipios.id')
            ->where('afiliados.numero_documento', $cedula)
            ->first();

        if ($afiliado && $afiliado->entidad_id == 3) {
            return $afiliado;
        } else {
            return ['mensaje' => 'Este afiliado no pertenece a la entidad Ferrocarriles.'];
        }
    }


    public function listarEmpalmes(Request $request)
    {
        $cantidad = $request->get('cantidad', 10);

        $empalme = Empalme::select(
            'empalme.id as id_Empalme',
            'empalme.acepta_represa',
            'empalme.tutela',
            'empalme.tipo_servicio',
            'empalme.cie10s_id',
            'empalme.afiliado_id',
            'empalme.empalme',
            'empalme.observaciones_contratista',
            'empalme.fecha_solicitud',
            'empalme.cup_id',
            'empalme.codesumi_id',
            'empalme.codigo_propio_id',
            'empalme.anexos',
            'afiliados.id',
            'afiliados.primer_nombre',
            'afiliados.segundo_nombre',
            'afiliados.primer_apellido',
            'afiliados.numero_documento as Cedula',
            'afiliados.entidad_id',
            'entidades.nombre as nombre_entidad',
            'adjunto_empalme.ruta as adjunto'
        )
            ->leftJoin('adjunto_empalme', 'empalme.id', 'adjunto_empalme.empalme_id')
            ->join('afiliados', 'empalme.afiliado_id', 'afiliados.id')
            ->join('entidades', 'afiliados.entidad_id', 'entidades.id')
            ->selectRaw("CONCAT(afiliados.primer_nombre, ' ' , afiliados.segundo_nombre, ' ', afiliados.primer_apellido, ' ', afiliados.segundo_apellido) as nombreAfiliado");

        if ($request->has('page')) {
            return $empalme->paginate($cantidad);
        } else {
            return $empalme->get();
        }
    }

    public function crear(array $data)
    {
        return Empalme::create($data);
    }
}
