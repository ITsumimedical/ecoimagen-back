<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Http\Modules\Estados\Models\Estado;
use Illuminate\Http\Response;

class EstadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {

            $estados = [
                [
                    'nombre' => 'Activo',
                    'descripcion' => 'Estado activo',

                ],
                [
                    'nombre' => 'Inactivo',
                    'descripcion' => 'Estado inactivo',

                ],
                [
                    'nombre' => 'Pendiente Autorizar',
                    'descripcion' => 'Estado pendiente autorizar',

                ],
                [
                    'nombre' => 'Autorizado',
                    'descripcion' => 'Estado autorizado',

                ],
                [
                    'nombre' => 'Anulado',
                    'descripcion' => 'Estado anulado',

                ],
                [
                    'nombre' => 'Asignado',
                    'descripcion' => 'Estado asignado',

                ],
                [
                    'nombre' => 'En consulta',
                    'descripcion' => 'Estado en consulta',

                ],
                [
                    'nombre' => 'Inasistencia',
                    'descripcion' => 'Estado inasistencia',

                ],
                [
                    'nombre' => 'Atendido',
                    'descripcion' => 'Estado atendido',

                ],
                [
                    'nombre' => 'Pendiente',
                    'descripcion' => 'Estado pendiente',

                ],
                [
                    'nombre' => 'Disponible',
                    'descripcion' => 'Estado disponible',

                ],
                [
                    'nombre' => 'Bloqueado',
                    'descripcion' => 'Estado bloqueado',

                ],
                [
                    'nombre' => 'Por Confirmar',
                    'descripcion' => 'Estado Por Confirmar',

                ],
                [
                    'nombre' => 'Confirmada',
                    'descripcion' => 'Estado Confirmada',

                ],
                [
                    'nombre' => 'Reasignada',
                    'descripcion' => 'Estado Reasignada',

                ],
                [
                    'nombre' => 'Analizado',
                    'descripcion' => 'Estado analizado',

                ],
                [
                    'nombre' => 'Cerrado',
                    'descripcion' => 'Estado cerrado',

                ],
                [
                    'nombre' => 'Parcial',
                    'descripcion' => 'Estado parcial',

                ],
                [
                    'nombre' => 'En seguimiento',
                    'descripcion' => 'Estado en seguimiento',

                ],
                [
                    'nombre' => 'Inadecuado',
                    'descripcion' => 'Estado Inadecuado',
                ],
                [
                    'nombre' => 'Negado',
                    'descripcion' => 'Estado Negado',
                ],
                [
                    'nombre' => 'Terminado',
                    'descripcion' => 'Estado terminado',
                ],
                [
                    'nombre' => 'Cerrado temporal',
                    'descripcion' => 'Estado cerrado temporal',
                ],
                [
                    'nombre' => 'Validando Estructura',
                    'descripcion' => 'Validando Estructura',
                ],
                [
                    'nombre' => 'Error Estructura',
                    'descripcion' => 'Error Estructura',
                ],
                [
                    'nombre' => 'Validando Contenido',
                    'descripcion' => 'Validando Contenido',
                ],
                [
                    'nombre' => 'Error Contenido',
                    'descripcion' => 'Error Contenido',
                ],
                [
                    'nombre' => 'Error Sistema',
                    'descripcion' => 'Error Sistema',
                ],
                [
                    'nombre' => 'Inactivo Vigencia',
                    'descripcion' => 'Inactivo Vigencia',
                ],
                [
                    'nombre' => 'Cancelado',
                    'descripcion' => 'Cancelado',
                ],
                [
                    'nombre' => 'Retirado',
                    'descripcion' => 'Estado Retirado',
                ],
                [
                    'nombre' => 'Protección Laboral Cotizante',
                    'descripcion' => 'Estado Protección Laboral Cotizante',
                ],
                [
                    'nombre' => 'Protección Laboral Beneficiario',
                    'descripcion' => 'Estado Protección Laboral Beneficiario',
                ],
                [
                    'nombre' => 'Dispensado',
                    'descripcion' => 'Estado Dispensado',
                ],
                [
                    'nombre' => 'Vencido',
                    'descripcion' => 'Estado Vencido',
                ],
                [
                    'nombre' => 'Pendiete por cita',
                    'descripcion' => 'Estado pendiente por asignacion de cita',
                ],
                [
                    'nombre' => 'Pendiete por ordenamiento',
                    'descripcion' => 'Estado pendiente por ordenar servicios',
                ],
                [
                    'nombre' => 'Seguimiento Plan de Mejora',
                    'descripcion' => 'Estado para eventos adversos plan de mejora',
                ],
                [
                    'nombre' => 'Plan de Mejora Cumplido',
                    'descripcion' => 'Estado para eventos adversos plan de mejora',
                ],
                [
                    'nombre' => 'Conteo1 finalizado',
                    'descripcion' => 'Conteo inventario',
                ],
                [
                    'nombre' => 'Conteo2 finalizado',
                    'descripcion' => 'Conteo inventario',
                ],
                [
                    'nombre' => 'Anexo 3',
                    'descripcion' => 'Anexo 3',
                ],
                [
                    'nombre' => 'Anulado por extemporaneidad',
                    'descripcion' => 'Anulado por extemporaneidad',
                ],
                [
                    'nombre' => 'Suspendido',
                    'descripcion' => 'Suspendido',
                ],
                [
                    'nombre' => 'Mipress',
                    'descripcion' => 'Mipress',
                ],
                [
                    'nombre' => 'Enfermeria Imagenologia',
                    'descripcion' => 'Enfermeria Imagenologia',
                ],
                [
                    'nombre' => 'Tecnologo Imagenologia',
                    'descripcion' => 'Tecnologo Imagenologia',
                ],
                [
                    'nombre' => 'Facturacion Imagenologia',
                    'descripcion' => 'Facturacion Imagenologia',
                ],
                [
                    'nombre' => 'Historia Clinica No Finalizada',
                    'descripcion' => 'Historia Clinica No Finalizada',
                ],
                [
                    'nombre' => 'Conteo3 Finalizado',
                    'descripcion' => 'Conteo3 Finalizado',
                ],
                [
                    'nombre' => 'Paciente de alta',
                    'descripcion' => 'Paciente de alta',
                ],
            ];

            foreach ($estados as $estado) {
                Estado::updateOrCreate([
                        'nombre' => $estado['nombre']
                    ],
                    [
                        'nombre'      => $estado['nombre'],
                        'descripcion' => $estado['descripcion']
                    ]
                );
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el estado seeder'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}
