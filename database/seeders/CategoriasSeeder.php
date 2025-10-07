<?php

namespace Database\Seeders;

use Illuminate\Http\Response;
use Illuminate\Database\Seeder;
use App\Http\Modules\categorias\Models\categorias;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            $categorias = [
                ['categoria_padre_id' => 1,     'nombre' => 'SOLICITUD DE HISTORIA CLÍNICA',                       'descripcion' => 'SOLICITUD DE HISTORIA CLÍNICA',                                   'estado_id' => 7],
                ['categoria_padre_id' => 1,     'nombre' => 'ACTITUD DE SERVICIO ADMINISTRATIVO O ASISTENCIAL',    'descripcion' =>  'ACTITUD DE SERVICIO ADMINISTRATIVO O ASISTENCIAL',               'estado_id' => 7],
                ['categoria_padre_id' => 1,     'nombre' => 'TRÁMITES ADMINISTRATIVOS',                            'descripcion' =>  'TRÁMITES ADMINISTRATIVOS',                                       'estado_id' => 7],
                ['categoria_padre_id' => 1,     'nombre' => 'INOPORTUNIDAD EN LA ASIGNACIÓN DE CITAS',             'descripcion' =>  'INOPORTUNIDAD EN LA ASIGNACIÓN DE CITAS',                        'estado_id' => 7],
                ['categoria_padre_id' => 1,     'nombre' => 'CANCELACIÓN DE SERVICIOS',                            'descripcion' =>  'CANCELACIÓN DE SERVICIOS',                                       'estado_id' => 7],
                ['categoria_padre_id' => 2,     'nombre' => 'DISPENSACIÓN DE MEDICAMENTOS E INSUMOS',              'descripcion' =>  'DISPENSACIÓN DE MEDICAMENTOS E INSUMOS',                         'estado_id' => 7],
                ['categoria_padre_id' => 2,     'nombre' => 'CIRUGÍAS',                                            'descripcion' =>  'CIRUGÍAS',                                                       'estado_id' => 7],
                ['categoria_padre_id' => 1,     'nombre' => 'TIEMPOS DE ESPERA',                                   'descripcion' =>  'TIEMPOS DE ESPERA',                                              'estado_id' => 7],
                ['categoria_padre_id' => 1,     'nombre' => 'REFERENCIA Y CONTRAREFERENCIA',                       'descripcion' =>  'REFERENCIA Y CONTRAREFERENCIA',                                  'estado_id' => 7],
                ['categoria_padre_id' => 2,     'nombre' => 'MEDICINA DOMICILIARIA',                               'descripcion' =>  'MEDICINA DOMICILIARIA',                                          'estado_id' => 7],
                ['categoria_padre_id' => 1,     'nombre' => 'MEDICINA LABORAL',                                    'descripcion' =>  'MEDICINA LABORAL',                                               'estado_id' => 7],
                ['categoria_padre_id' => 1,     'nombre' => 'INSCRIPCIONES Y NOVEDADES',                           'descripcion' =>  'INSCRIPCIONES Y NOVEDADES',                                       'estado_id' => 7],
                ['categoria_padre_id' => 1,     'nombre' => 'RED PR    ESTADORA DE SERVICIOS DE SALUD',                'descripcion' =>  'RED PRESTADORA DE SERVICIOS DE SALUD',                            'estado_id' => 7],
                ['categoria_padre_id' => 2,     'nombre' => 'TIEMPOS DE ESPERA EN EL SERVICIO DE URGENCIAS',       'descripcion' =>  'TIEMPOS DE ESPERA EN EL SERVICIO DE URGENCIAS',                   'estado_id' => 7],
                ['categoria_padre_id' => 1,     'nombre' => 'CONDICIONES DE ASEO Y COMODIDAD DE LAS INSTALACIONES', 'descripcion' =>  'CONDICIONES DE ASEO Y COMODIDAD DE LAS INSTALACIONES',           'estado_id' => 7],
                ['categoria_padre_id' => 1,     'nombre' => 'EVENTO ADVERSO',                                       'descripcion' =>  'EVENTO ADVERSO',                                                 'estado_id' => 7],
                ['categoria_padre_id' => 1,     'nombre' => 'REEMBOLSOS',                                           'descripcion' =>  'REEMBOLSOS',                                                     'estado_id' => 7],
                ['categoria_padre_id' => 1,     'nombre' => 'REINTEGROS',                                           'descripcion' =>  'REINTEGROS',                                                      'estado_id' => 7],
                ['categoria_padre_id' => 1,     'nombre' => 'EXCLUSIONES',                                          'descripcion' =>  'EXCLUSIONES',                                                     'estado_id' => 7],

            ];
            foreach ($categorias as $categoria) {
                categorias::updateOrCreate([
                    'nombre' => $categoria['nombre'],
                ], [
                    'nombre' => $categoria['nombre'],
                    'descripcion' => $categoria['descripcion'],
                    'estado_id' => $categoria['estado_id'],
                    'categoria_padre_id' => $categoria['categoria_padre_id'],
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de de categoriasPadres'
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
