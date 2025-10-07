<?php

namespace Database\Seeders;

use App\Http\Modules\Entidad\Models\Entidad;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Permission;

class EntidadSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $Entidades = [
                [
                    'nombre' => 'Redvital',
                    'agendar_pacientes' => false,
                    'entregar_medicamentos' => false,
                    'atender_pacientes' => true,
                    'autorizar_ordenes' => false,
                    'consultar_historicos' => false,
                    'generar_ordenes' => false,
                    'estado' => true,
                ],
                [
                    'nombre' => 'Medimas',
                    'agendar_pacientes' => false,
                    'entregar_medicamentos' => false,
                    'atender_pacientes' => false,
                    'autorizar_ordenes' => false,
                    'consultar_historicos' => false,
                    'generar_ordenes' => false,
                    'estado' => false,
                ],
                [
                    'nombre' => 'Fondo de pasivo social de ferrocarriles nacionales de Colombia',
                    'agendar_pacientes' => false,
                    'entregar_medicamentos' => false,
                    'atender_pacientes' => false,
                    'autorizar_ordenes' => false,
                    'consultar_historicos' => false,
                    'generar_ordenes' => false,
                    'estado' => false,
                ],
                [
                    'nombre' => 'Salud ocupacional',
                    'agendar_pacientes' => false,
                    'entregar_medicamentos' => false,
                    'atender_pacientes' => false,
                    'autorizar_ordenes' => false,
                    'consultar_historicos' => false,
                    'generar_ordenes' => false,
                    'estado' => false,
                ],
                [
                    'nombre' => 'Secretaria seccional de salud de Antioquia (SSSA)',
                    'agendar_pacientes' => false,
                    'entregar_medicamentos' => false,
                    'atender_pacientes' => false,
                    'autorizar_ordenes' => false,
                    'consultar_historicos' => false,
                    'generar_ordenes' => false,
                    'estado' => false,
                ],
                [
                    'nombre' => 'Fideicomiso fondo nacional de salud PPL (INPEC)',
                    'agendar_pacientes' => false,
                    'entregar_medicamentos' => false,
                    'atender_pacientes' => false,
                    'autorizar_ordenes' => false,
                    'consultar_historicos' => false,
                    'generar_ordenes' => false,
                    'estado' => false,
                ],
                [
                    'nombre' => 'Universidad de Antioquia',
                    'agendar_pacientes' => false,
                    'entregar_medicamentos' => false,
                    'atender_pacientes' => false,
                    'autorizar_ordenes' => false,
                    'consultar_historicos' => false,
                    'generar_ordenes' => false,
                    'estado' => false,
                ],
                [
                    'nombre' => 'Fondo de ferrocarriles nacionales Magdalena',
                    'agendar_pacientes' => false,
                    'entregar_medicamentos' => false,
                    'atender_pacientes' => false,
                    'autorizar_ordenes' => false,
                    'consultar_historicos' => false,
                    'generar_ordenes' => false,
                    'estado' => false,
                ],
                [
                    'nombre' => 'Eps y medicina prepagada Suramericana S.A.',
                    'agendar_pacientes' => false,
                    'entregar_medicamentos' => false,
                    'atender_pacientes' => false,
                    'autorizar_ordenes' => false,
                    'consultar_historicos' => false,
                    'generar_ordenes' => false,
                    'estado' => false,
                ],
            ];
            foreach ($Entidades as $entidad) {
                Entidad::updateOrCreate([
                    'nombre' => $entidad['nombre']
                ],[
                    'nombre' => $entidad['nombre'],
                    'agendar_pacientes' => $entidad['agendar_pacientes'],
                    'entregar_medicamentos' => $entidad['entregar_medicamentos'],
                    'atender_pacientes' => $entidad['atender_pacientes'],
                    'autorizar_ordenes' => $entidad['autorizar_ordenes'],
                    'consultar_historicos' => $entidad['consultar_historicos'],
                    'generar_ordenes' => $entidad['generar_ordenes'],
                    'estado' => $entidad['estado'],
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de entidad'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}
