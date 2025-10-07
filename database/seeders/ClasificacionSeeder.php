<?php

namespace Database\Seeders;

use App\Http\Modules\Clasificaciones\Models\clasificacion;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class ClasificacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $clasificaciones = [
        [
            'nombre'      => 'Código AZUL',
            'descripcion' => 'Es un sistema de alarma (clave, alerta y códigos), para el manejo de pacientes en paro Cardio-respiratorio por un grupo entrenado y coordinado con previas funciones establecidas',
            'user_id'     => 1,
        ],
        [
            'nombre'      => 'Código BLANCO',
            'descripcion' => 'Atención Integral a víctimas de violencia sexual',
            'user_id'     => 1,
        ],
        [
            'nombre'      => 'Código LILA',
            'descripcion' => 'Protocolo activado para señalar el final de la vida, es decir pacientes oncológicos en los que existen fallecimientos esperados detectados en el programa de cuidado paliativo',
            'user_id'     => 1,
        ],
        [
            'nombre'      => 'Confidencialidad de Historia Clínica',
            'descripcion' => 'Las personas pueden exigir que su historia clínica sea tratada de manera confidencial y reservada',
            'user_id'     => 1,
        ],
        [
            'nombre'      => 'Paciente Domiciliario',
            'descripcion' => 'Usuarios que hacen parte del proceso de Victoriana en casa',
            'user_id'     => 1,
        ],
        [
            'nombre'      => 'Voluntad Anticipada',
            'descripcion' => 'Documento en el que toda persona capaz, sana o en estado de enfermedad, en pleno uso de sus facultades legales y mentales y como previsión de no poder tomar decisiones en el futuro, declara, de forma libre, consciente e informada su voluntad sobre las preferencias al final de la vida que sean relevantes para su marco de valores personales',
            'user_id'     => 1,
        ],
        [
            'nombre'      => 'Portabilidad',
            'descripcion' => 'Garantía de la accesibilidad a los servicios de salud en cualquier municipio del territorio nacional para todo afiliado',
            'user_id'     => 1,
        ],
        [
            'nombre'      => 'Presunción donación de órganos',
            'descripcion' => 'Presunción donación de órganos',
            'user_id'     => 1,
        ],
        [
            'nombre'      => 'Punta pirámide',
            'descripcion' => 'Pacientes en estrategia Punta Pirámide',
            'user_id'     => 1,
        ],
        [
            'nombre'      => 'Tutela',
            'descripcion' => 'Pacientes con proceso jurídico vigente',
            'user_id'     => 1,
        ]
    ];
         foreach ($clasificaciones as $clasificacion) {
            clasificacion::updateOrCreate([
                'nombre' => $clasificacion['nombre'],
            ],[
                'nombre' => $clasificacion['nombre'],
                'descripcion' => $clasificacion['descripcion'],
                'user_id' => $clasificacion['user_id'],
            ]);
         };

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al crear el seeder de la clasificacion'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}
