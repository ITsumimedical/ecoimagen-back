<?php

namespace Database\Seeders;

use App\Http\Modules\Sedes\Models\Sede;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class SedeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $sedes = [
                [
                    'nombre'      => 'SUMIMEDICAL SEDE CAUCASIA',
                    'direccion'   => 'CALLE 30 # 20 - 26 LOCALES 101 Y 102',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'      => 'SUMIMEDICAL SEDE APARTADO',
                    'direccion'   => 'CARRERA 106 C # 99 C 17',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'      => 'SEDE SUMIMEDICAL ITAGÜÍ',
                    'direccion'   => 'CARRERA 49 51 40',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'      => 'SUMIMEDICAL SEDE APOYO TERAPEUTICO',
                    'direccion'   => 'CALLE 45 E NO. 73 40',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'      => 'SUMIMEDICAL SEDE PUERTO BERRIO',
                    'direccion'   => 'CALLE 45 # 6 - 12',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'      => 'SUMIMEDICAL RIONEGRO',
                    'direccion'   => 'CARRERA 49 N 50 58 LOCAL 108 Y 109',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'      => 'SUMIMEDICAL QUIBDO',
                    'direccion'   => 'CALLE 31 #2-30',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'      => 'SUMIMEDICAL SEDE BUCARAMANGA',
                    'direccion'   => 'CALLE 54 N° 31 -122',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'      => 'SUMIMEDICAL SEDE TURBO',
                    'direccion'   => 'CARRERA 14B #101 72',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'      => 'SUMIMEDICAL COPACABANA',
                    'direccion'   => 'CALLE 53 N° 56 - 30/34',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'      => 'SUMIMEDICAL SEDE CHIGORODÓ',
                    'direccion'   => 'CALLE 96 N° 102 - 59/61/6',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'      => 'SUMIMEDICAL SEDE ORIENTAL',
                    'direccion'   => 'CALLE 58 # 49 - 46',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'      => 'SUMIMEDICAL SEDE VILLANUEVA',
                    'direccion'   => 'CARRERA 49 # 58 45',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'      => 'SUMIMEDICAL SEDE ENVIGADO',
                    'direccion'   => 'CALLE 37 SUR # 37 23',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'      => 'SUMIMEDICAL SEDE ESTADIO',
                    'direccion'   => 'CALLE 47D # 70-113',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'      => 'SUMIMEDICAL SAS BELLO',
                    'direccion'   => 'CARRERA 50 N° 46 - 146',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'        => 'CLINICA VICTORIANA',
                    'direccion'     => 'CARRERA 49 NO. 58 19',
                    'telefono'      => '6043228064',
                    'hora_inicio'   => '07:00',
                    'hora_fin'      => '19:00',
                    'propia'        => 1,
                    'activo'        => 1,
                    'rep_id'        => null

                ],

                [
                    'nombre'        => 'SUMIMEDICAL ISTMINA',
                    'direccion'     => 'CARRERA 8# 26-65',
                    'telefono'      => '6045201040',
                    'hora_inicio'   => '07:00',
                    'hora_fin'      => '19:00',
                    'propia'        => 1,
                    'activo'        => 1,
                    'rep_id'        => null

                ],

                [
                    'nombre'      => 'SUMIMEDICAL SEDE 80',
                    'direccion'   => 'CARRERA 80C #32EE-65',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'      => 'SUMIMEDICAL SEDE AGUACATALA',
                    'direccion'   => 'CARRERA 48A #16 Sur - 86 Of 404',
                    'telefono'    => '6045201040',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],

                [
                    'nombre'      => 'TRABAJO EN CASA',
                    'direccion'   => 'No aplica',
                    'telefono'    => '0',
                    'hora_inicio' => '07:00',
                    'hora_fin'    => '19:00',
                    'propia'      => 1,
                    'activo'      => 1,
                    'rep_id'      => null
                ],
            ];
            foreach ($sedes as $sede) {
                Sede::updateOrCreate([
                    'nombre' => $sede['nombre']
                ], [
                    'nombre'      => $sede['nombre'],
                    'direccion'   => $sede['direccion'],
                    'telefono'    => $sede['telefono'],
                    'hora_inicio' => $sede['hora_inicio'],
                    'hora_fin'    => $sede['hora_fin'],
                    'propia'      => $sede['propia'],
                    'activo'      => $sede['activo'],
                ]);
            }
        } catch (\Throwable $th) {
            return response()->json('No se han podido crear los seeders de sedes');
        }
    }
}
