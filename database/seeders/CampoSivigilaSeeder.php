<?php

namespace Database\Seeders;

use App\Http\Modules\Epidemiologia\Models\CampoSivigila;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CampoSivigilaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        try {
            $campoSivigilas = [
                // ACIDENTE OFIDICO
                // NOTIFICACION
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 1,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 1,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 1,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 1,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 1,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 1,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 1,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 6
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 1,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 1,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 8
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 1,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 8
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 1,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 8
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 2,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 2,
                    'obligatorio' => false,
                ],
                // RELACIÓN CON DATOS BÁSICOS
                [
                    'nombre_campo' => 'Fecha del accidente (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 3,
                ],
                [
                    'nombre_campo' => 'Dirección del lugar donde ocurrió el accidente',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 3,
                ],
                [
                    'nombre_campo' => 'Actividad que realizaba al momento del accidente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 3,
                ],
                [
                    'nombre_campo' => '¿Cuál otra actividad realizaba al momento del accidente?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 3,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Tipo de atención inicial',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 3,
                ],
                [
                    'nombre_campo' => '¿Cuál otro tipo de atención inicial?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 3,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '¿La persona fue sometida a prácticas no médicas?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 3,
                ],
                [
                    'nombre_campo' => '¿Cuál otra prácticas no médicas fue sometida la persona?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 3,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Localización de la mordedura',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 3,
                ],
                [
                    'nombre_campo' => '¿Hay evidencia de huellas de colmillos?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 3,
                ],
                [
                    'nombre_campo' => '¿La persona vió la serpiente que la mordió?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 3,
                ],
                [
                    'nombre_campo' => '¿Se capturó la serpiente?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 3,
                ],
                [
                    'nombre_campo' => 'Agente agresor, identificación género',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 3,
                ],
                [
                    'nombre_campo' => '¿Cuál otro agente agresor, identificación género?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 3,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Agente agresor, nombre común',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 3,
                ],
                [
                    'nombre_campo' => '¿Cuál otro agente agresor, nombre común?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 3,
                    'obligatorio' => false,
                ],
                // CUADRO CLINICO
                [
                    'nombre_campo' => 'Manifestaciones locales (Seleccione las que se presentan)',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 4,
                ],
                [
                    'nombre_campo' => '¿Cuál otra manifestacion local?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 4,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Manifestaciones sistémicas (Seleccione las que se presentan)',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 4,
                ],
                [
                    'nombre_campo' => '¿Cuál otra manifestacion sistémica?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 4,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Complicaciones locales (Seleccione las que se presentan)',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 4,
                ],
                [
                    'nombre_campo' => '¿Cuál otra complicacion local?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 4,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Complicaciones sistémicas',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 4,
                ],
                [
                    'nombre_campo' => '¿Cuál otra complicacion sistémica?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 4,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Gravedad del accidente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 4,
                ],

                // ATENCION HOSPITALARIA
                [
                    'nombre_campo' => '¿Empleó Suero?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 5,
                ],
                [
                    'nombre_campo' => 'Tiempo trancurrido días',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 5,
                ],
                [
                    'nombre_campo' => 'Tiempo trancurrido horas',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 5,
                ],
                [
                    'nombre_campo' => 'Tipo de suero antiofídico',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 5,
                ],
                [
                    'nombre_campo' => 'Fabricante',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 5,
                ],
                [
                    'nombre_campo' => '¿Cuál?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 5,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Lote',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 5,
                ],
                [
                    'nombre_campo' => 'Reacciones a la aplicación del suero',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 5,
                ],
                [
                    'nombre_campo' => 'Dosis de suero (ampollas)',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 5,
                ],
                [
                    'nombre_campo' => 'Tiempo de administración de suero',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 5,
                ],
                [
                    'nombre_campo' => '¿Remitido a otra institución?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 5,
                ],
                [
                    'nombre_campo' => 'Tratamiento quirúrgico',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 5,
                ],
                [
                    'nombre_campo' => 'Tipo de tratamiento quirúrgico',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 5,
                ],

                [
                    'nombre_campo' => 'Reacciones a la aplicación del suero',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 5,
                ],

                // AGRECIONES APTR
                // NOTIFICACION
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 6,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 6,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 6,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 6,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 6,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 6,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 6,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 57
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 6,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 6,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 59
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 6,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 59
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 6,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 59
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 7,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 7,
                    'obligatorio' => false,
                ],
                //DATOS DE LA AGRESIÓN O CONTACTO, DE LA ESPECIE AGRESORA Y DE LA CLASIFICACIÓN DE LA EXPOSICIÓN
                [
                    'nombre_campo' => 'Tipo de agresión o contacto',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 8,
                ],
                [
                    'nombre_campo' => 'Si seleccionó: Mordedura, indique el area',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 8,
                ],
                [
                    'nombre_campo' => '¿Agresión provocada?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 8,
                ],
                [
                    'nombre_campo' => 'Tipo de lesión',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 8,
                ],
                [
                    'nombre_campo' => 'Profundidad',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 8,
                ],
                [
                    'nombre_campo' => 'Localización anatómica de la lesión (Seleccione más de una en caso necesario)',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 8,
                ],
                [
                    'nombre_campo' => 'Fecha de la agresión o contacto (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 8,
                ],
                [
                    'nombre_campo' => 'Especie agresora',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 8,
                ],
                [
                    'nombre_campo' => 'Animal vacunado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 8,
                ],
                [
                    'nombre_campo' => '¿Presentó carné de vacunación antirrábica?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 8,
                ],
                [
                    'nombre_campo' => 'Fecha de vacunación (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 8,
                ],
                [
                    'nombre_campo' => 'Nombre del propietario o responsable del agresor:',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 8,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Dirección del propietario o responsable del agresor',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 8,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Teléfono del propietario',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 8,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Estado del animal al momento de la agresión o contacto',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 8,
                ],
                [
                    'nombre_campo' => 'Estado del animal al momento de la consulta',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 8,
                ],
                [
                    'nombre_campo' => 'Ubicación del animal agreso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 8,
                ],
                [
                    'nombre_campo' => 'Tipo de exposición',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 8,
                ],
                // ANTECEDENTES DE INMUNIZACIÓN DEL PACIENTE
                [
                    'nombre_campo' => 'Suero antirrábico',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 9,
                ],
                [
                    'nombre_campo' => 'Fecha de aplicación (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 9,
                ],
                [
                    'nombre_campo' => 'Vacuna antirrábica',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 9,
                ],
                [
                    'nombre_campo' => 'Número de dosis',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 9,
                ],
                [
                    'nombre_campo' => 'Fecha de última dosis (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 9,
                    'obligatorio' => false,
                ],
                // DATOS DEL TRATAMIENTO ORDENADO EN LA ACTUALIDAD
                [
                    'nombre_campo' => '¿Lavado de herida con agua y jabón?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 10,
                ],
                [
                    'nombre_campo' => '¿Sutura de la herida?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 10,
                ],
                [
                    'nombre_campo' => '¿Ordenó suero antirrábico?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 10,
                ],
                [
                    'nombre_campo' => '¿Ordenó aplicación vacuna?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 10,
                ],

                // CÁNCER DE CUELLO UTERINO
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 11,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 11,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 11,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 11,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 11,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 11,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 11,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 97
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 11,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 11,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 99
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 11,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 99
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 11,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 99
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 12,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 12,
                    'obligatorio' => false,
                ],
                // DATOS ESPECÍFICOS
                [
                    'nombre_campo' => 'Tipo de cáncer',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 13,
                ],
                [
                    'nombre_campo' => 'Fecha de procedimiento (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 13,
                ],
                [
                    'nombre_campo' => 'Fecha resultado (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 13,
                ],
                [
                    'nombre_campo' => 'Resultado biopsia',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 13,
                ],
                [
                    'nombre_campo' => 'Grado histopatológico',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 13,
                ],
                [
                    'nombre_campo' => 'Fecha de toma de muestra (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 13,
                ],
                [
                    'nombre_campo' => 'Fecha de resultado (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 13,
                ],
                [
                    'nombre_campo' => 'Resultado de la biopsia',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 13,
                ],
                [
                    'nombre_campo' => 'Grado histopatológico examen',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 13,
                ],
                [
                    'nombre_campo' => 'Tratamiento',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 13,
                ],
                [
                    'nombre_campo' => 'Fecha de inicio del tratamiento (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 13,
                    'obligatorio' => false,
                ],

                // CÁNCER DE MAMA
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 14,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 14,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 14,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 14,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 14,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 14,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 14,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 121
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 14,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 14,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 123
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 14,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 123
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 14,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 123
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 15,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 15,
                    'obligatorio' => false,
                ],
                // DATOS ESPECÍFICOS
                [
                    'nombre_campo' => 'Tipo de cáncer',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 16,
                ],
                [
                    'nombre_campo' => 'Fecha de procedimiento (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 16,
                ],
                [
                    'nombre_campo' => 'Fecha resultado (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 16,
                ],
                [
                    'nombre_campo' => 'Resultado biopsia',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 16,
                ],
                [
                    'nombre_campo' => 'Grado histopatológico',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 16,
                ],
                [
                    'nombre_campo' => 'Fecha de toma de muestra (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 16,
                ],
                [
                    'nombre_campo' => 'Fecha de resultado (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 16,
                ],
                [
                    'nombre_campo' => 'Resultado de la biopsia',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 16,
                ],
                [
                    'nombre_campo' => 'Grado histopatológico examen',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 16,
                ],
                [
                    'nombre_campo' => 'Tratamiento',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 16,
                ],
                [
                    'nombre_campo' => 'Fecha de inicio del tratamiento (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 16,
                    'obligatorio' => false,
                ],

                // Cancer en menores de 18 años
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 17,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 17,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 17,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 17,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 17,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 17,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 17,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 145
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 17,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 17,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 147
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 17,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 147
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 17,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 147
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 18,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 18,
                    'obligatorio' => false,
                ],
                // TIPO DE CÁNCER
                [
                    'nombre_campo' => 'Tipo de cáncer',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 19,
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de tratamiento (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 19,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '¿Consulta actual por segunda neoplasia?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 19,
                ],
                [
                    'nombre_campo' => '¿Consulta actual por recaída?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 19,
                ],
                [
                    'nombre_campo' => 'Fecha de diagnóstico Inicial (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 19,
                    'obligatorio' => false,
                ],
                // DATOS DE LABORATORIO - MÉTODOS DIAGNÓSTICOS
                [
                    'nombre_campo' => 'Criterio de diagnóstico probable',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 20,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de toma (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 20,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de resultado (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 20,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Criterio de confirmación del diagnóstico',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 20,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de toma confirmación del diagnóstico (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 20,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de resultado confirmación del diagnóstico (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 20,
                    'obligatorio' => false,
                ],

                // DEFECTOS CONGENITOS
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 21,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 21,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 21,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 21,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 21,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 21,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 21,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 169
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 21,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 21,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 171
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 21,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 171
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 21,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 171
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 22,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 22,
                    'obligatorio' => false,
                ],

                // RELACIÓN CON LOS DATOS BÁSICOS
                [
                    'nombre_campo' => 'Nombres y apellidos del paciente',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 23,
                ],
                [
                    'nombre_campo' => 'Tipo de ID paciente*',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 23,
                ],
                [
                    'nombre_campo' => 'Número de identificación',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 23,
                ],
                [
                    'nombre_campo' => 'Nombres y apellidos de la madre',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 23,
                ],
                [
                    'nombre_campo' => 'Tipo de ID madre*',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 23,
                ],

                [
                    'nombre_campo' => 'Edad',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 23,
                ],

                // INFORMACÓN MATERNA
                [
                    'nombre_campo' => 'Número de embarazos totales',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 24,
                ],
                [
                    'nombre_campo' => 'Nacidos vivos',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 24,
                ],
                [
                    'nombre_campo' => 'Abortos (<22 sem)',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 24,
                ],
                [
                    'nombre_campo' => 'Mortinatos (>=22)',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 24,
                ],
                [
                    'nombre_campo' => 'Diagnóstico',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 24,
                ],
                [
                    'nombre_campo' => 'Edad gestacional al diagnóstico',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 24,
                ],
                [
                    'nombre_campo' => 'Patología crónica adicional o complicaciones durante el embarazo:',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 24,
                ],
                [
                    'nombre_campo' => '¿Cúales patología crónica adicional o complicaciones durante el embarazo?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 24,
                ],

                // INFORMACIÓN COMPLEMENTARIA DEL NIÑO
                [
                    'nombre_campo' => 'Embarazo múltiple',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 25,
                ],
                [
                    'nombre_campo' => 'Nativivo',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 25,
                ],
                [
                    'nombre_campo' => 'Edad Gestacional al momento del nacimiento',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 25,
                ],
                [
                    'nombre_campo' => 'Peso al nacer (Gramos)',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 25,
                ],
                [
                    'nombre_campo' => 'Perímetro cefálico',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 25,
                ],

                // DEFECTOS CONGÉNITOS
                [
                    'nombre_campo' => '1. Descripción (Defectos metabólicos (incluye el hipotiroidismo congénito))',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 26,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '1. Descripción (Defectos sensoriales)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 26,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '2. Descripción (Defectos sensoriales)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 26,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '1. Descripción (Malformaciones congénitas (Reporte las malformaciones en orden de gravedad))',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 26,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '2. Descripción (Malformaciones congénitas (Reporte las malformaciones en orden de gravedad))',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 26,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '3. Descripción (Malformaciones congénitas (Reporte las malformaciones en orden de gravedad))',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 26,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '4. Descripción (Malformaciones congénitas (Reporte las malformaciones en orden de gravedad))',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 26,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '5. Descripción (Malformaciones congénitas (Reporte las malformaciones en orden de gravedad))',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 26,
                    'obligatorio' => false,
                ],

                // DATOS DE LABORATORIO
                [
                    'nombre_campo' => 'STORCH en recién nacido',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 27,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'TSH',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 27,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Resultado TSH',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 27,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '1. T4 Total suero',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 27,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '1. Resultado T4 Total Suero',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 27,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '2. T4 Libre suero',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 27,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '2. Resultado T4 Libre Suero',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 27,
                    'obligatorio' => false,
                ],

                // DENGUE
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 28,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 28,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 28,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 28,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 28,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 28,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 28,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 216
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 28,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 28,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 218
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 28,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 218
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 28,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 218
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 29,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 29,
                    'obligatorio' => false,
                ],
                // DATOS ESPECÍFICOS
                [
                    'nombre_campo' => '¿Desplazamiento en los últimos 15 días?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 30,
                ],
                [
                    'nombre_campo' => 'País al que se desplazó',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 30,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Municipio al que se desplazó',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 30,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'departamento al que se desplazó',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 30,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '¿Algún familiar o conviviente ha tenido sintomatología de dengue en los últimos 15 días?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 30,
                ],
                [
                    'nombre_campo' => 'Nombre del establecimiento donde estudia o trabaja:',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 30,
                ],
                // DATOS PARA CLASIFICACIÓN DEL DENGUE
                [
                    'nombre_campo' => 'Dengue sin signos de alarma',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 31,
                ],
                [
                    'nombre_campo' => 'Dengue con signos de alarma',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 31,
                ],
                [
                    'nombre_campo' => 'Dengue grave',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 31,
                ],
                // CLASIFICACIÓN FINAL Y ATENCION DEL CASO
                [
                    'nombre_campo' => 'Clasificación final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 32,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Conducta',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 32,
                    'obligatorio' => false,
                ],
                // EN CASO DE MORTALIDAD POR DENGUE
                [
                    'nombre_campo' => 'Muestras',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 33,
                    'obligatorio' => false,
                ],
                // DATOS DE LABORATORIO
                [
                    'nombre_campo' => 'Fecha toma de examen (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 34,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de recepción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 34,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Muestra',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 34,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Prueba',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 34,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Agente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 34,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Resultado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 34,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de resultado (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 34,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Valor',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 34,
                    'obligatorio' => false,
                ],

                // DESNUTRICIÓN MENORES DE 5 AÑOS
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 35,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 35,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 35,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 35,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 35,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 35,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 35,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 249
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 35,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 35,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 251
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 35,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 251
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 35,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 251
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 36,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 36,
                    'obligatorio' => false,
                ],
                // DATOS DE LA MADRE O CUIDADOR
                [
                    'nombre_campo' => 'Primer nombre',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 37,
                ],
                [
                    'nombre_campo' => 'Segundo nombre',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 37,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Primer apellido',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 37,
                ],
                [
                    'nombre_campo' => 'Segundo apellido',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 37,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Tipo de ID*',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 37,
                ],
                [
                    'nombre_campo' => 'Número de identificación',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 37,
                ],
                [
                    'nombre_campo' => 'Nivel educativo de la madre o cuidador',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 37,
                ],
                [
                    'nombre_campo' => 'Número hijos < 5 años',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 37,
                ],
                // IDENTIFICACIÓN DE FACTORES
                [
                    'nombre_campo' => 'Peso al nacer (g)',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 38,
                ],
                [
                    'nombre_campo' => 'Talla al nacer (cm)',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 38,
                ],
                [
                    'nombre_campo' => 'Edad gestacional al nacer (Semanas)',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 38,
                    'max' => true,
                    'min' => true,
                ],
                [
                    'nombre_campo' => 'Tiempo que recibió leche materna (meses)',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 38,
                ],
                [
                    'nombre_campo' => 'Edad inicio alimentación complementaria',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 38,
                ],
                [
                    'nombre_campo' => 'Inscrito a crecimiento y desarrollo',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 38,
                ],
                [
                    'nombre_campo' => '¿Esquema de vacunación completo a la edad?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 38,
                ],
                [
                    'nombre_campo' => 'Referido por carné de vacunación',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 38,
                ],
                [
                    'nombre_campo' => 'Peso actual (Kg)',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 38,
                ],
                [
                    'nombre_campo' => 'Talla actual (cm)',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 38,
                ],
                [
                    'nombre_campo' => 'Circunferencia media del brazo ( ≥ 6cm y ≤ 30cm) Mayores de 6 meses hasta 59 meses',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 38,
                ],
                [
                    'nombre_campo' => 'Resultado de la prueba de apetito (Mayores de 6 meses)',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 38,
                ],
                // SIGNOS CLÍNICOS
                [
                    'nombre_campo' => '¿Edema?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 39,
                ],
                [
                    'nombre_campo' => '¿Desnutrición emaciación o delgadez visible?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 39,
                ],
                [
                    'nombre_campo' => '¿Piel reseca o áspera?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 39,
                ],
                [
                    'nombre_campo' => '¿Hipo o hiperpigmentación de la piel?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 39,
                ],
                [
                    'nombre_campo' => '¿Cambios en el cabello?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 39,
                ],
                [
                    'nombre_campo' => '¿Anemia detectada por palidez palmar o de mucosas?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 39,
                ],
                // RUTA DE ATENCIÓN
                [
                    'nombre_campo' => 'Activación ruta de atención',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 40,
                ],
                [
                    'nombre_campo' => 'Tipo de atención suministrada',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 40,
                ],
                [
                    'nombre_campo' => 'Diagnóstico médico',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 40,
                ],

                // ENFERMEDADES RARAS
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 41,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 41,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 41,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 41,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 41,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 41,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 41,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 291
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 41,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 41,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 293
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 41,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 293
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 41,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 293
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 42,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 42,
                    'obligatorio' => false,
                ],
                // DATOS COMPLEMENTARIOS
                [
                    'nombre_campo' => 'Nivel educativo',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 43,
                ],
                [
                    'nombre_campo' => 'Otros grupos poblacionales',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 43,
                ],
                [
                    'nombre_campo' => 'Fecha de diagnóstico de la enfermedad (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 43,
                ],
                [
                    'nombre_campo' => '¿Cuál prueba confirmatoria?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 43,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Nombre de la enfermedad',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 43,
                    'obligatorio' => false,
                ],

                // ENERMEDADES HUERFANAS POR ALIMENTOS O AGUA
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 44,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 44,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 44,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 44,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 44,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 44,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 44,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 309
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 44,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 44,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 311
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 44,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 311
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 44,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 311
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 45,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 45,
                    'obligatorio' => false,
                ],
                // DATOS CLÍNICOS
                [
                    'nombre_campo' => 'Signos y síntomas',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 46,
                ],
                [
                    'nombre_campo' => 'Sí marcó otros, cuál?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 46,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Hora de inicio de los sintomas',
                    'tipo_campo' => 'hora',
                    'cabecera_id' => 46,
                ],
                // DATOS DE LA EXPOSICIÓN
                [
                    'nombre_campo' => '1. Nombre del alimento ingerido (día de los síntomas)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '1. Hora en que ingerio el alimento (día de los síntomas)',
                    'tipo_campo' => 'hora',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '1. Lugar del consumo del alimento (día de los síntomas)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '2. Nombre del alimento ingerido (día de los síntomas)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '2. Hora en que ingerio el alimento (día de los síntomas)',
                    'tipo_campo' => 'hora',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '2. Lugar del consumo del alimento (día de los síntomas)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '3. Nombre del alimento ingerido (día de los síntomas)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '3. Hora en que ingerio el alimento (día de los síntomas)',
                    'tipo_campo' => 'hora',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '3. Lugar del consumo del alimento (día de los síntomas)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '1. Nombre del alimento ingerido (día anterior)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '1. Hora en que ingerio el alimento (día anterior)',
                    'tipo_campo' => 'hora',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '1. Lugar del consumo del alimento (día anterior)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '2. Nombre del alimento ingerido (día anterior)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '2. Hora en que ingerio el alimento (día anterior)',
                    'tipo_campo' => 'hora',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '2. Lugar del consumo del alimento (día anterior)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '3. Nombre del alimento ingerido (día anterior)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '3. Hora en que ingerio el alimento (día anterior)',
                    'tipo_campo' => 'hora',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '3. Lugar del consumo del alimento (día anterior)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '1. Nombre del alimento ingerido (días antes)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '1. Hora en que ingerio el alimento (días antes)',
                    'tipo_campo' => 'hora',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '1. Lugar del consumo del alimento (días antes)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '2. Nombre del alimento ingerido (días antes)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '2. Hora en que ingerio el alimento (días antes)',
                    'tipo_campo' => 'hora',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '2. Lugar del consumo del alimento (días antes)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '3. Nombre del alimento ingerido (días antes)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '3. Hora en que ingerio el alimento (días antes)',
                    'tipo_campo' => 'hora',
                    'cabecera_id' => 47,
                ],
                [
                    'nombre_campo' => '3. Lugar del consumo del alimento (días antes)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 47,
                ],
                // DATOS DE LABORATORIO
                [
                    'nombre_campo' => 'Nombre del lugar de consumo implicado',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 48,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Dirección',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 48,
                    'obligatorio' => false,
                ],
                // ASOCIACIÓN CON BROTE
                [
                    'nombre_campo' => '¿Caso asociado a un brote?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 49,
                ],
                [
                    'nombre_campo' => '¿Caso captado por?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 49,
                ],
                [
                    'nombre_campo' => 'Relación con la exposición',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 49,
                ],
                // LABORATORIO
                [
                    'nombre_campo' => '¿Se recolectó muestra biológica?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 50,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Tipo de muestra',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 50,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '¿Cuál?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 50,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '1. Agente identificado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 50,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '2. Agente identificado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 50,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '3. Agente identificado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 50,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '4. Agente identificado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 50,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Si marco 77 Otro: Cuál otro?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 50,
                    'obligatorio' => false,
                ],

                // HEPATITIS A
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 51,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 51,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 51,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 51,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 51,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 51,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 51,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 365
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 51,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 51,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 367
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 51,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 367
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 51,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 367
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 52,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 52,
                    'obligatorio' => false,
                ],

                // HEPATITIS B
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 53,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 53,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 53,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 53,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 53,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 53,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 53,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 378
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 53,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 53,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 380
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 53,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 380
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 53,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 380
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 54,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 54,
                    'obligatorio' => false,
                ],
                // CLASIFICACIÓN DEL CASO
                [
                    'nombre_campo' => 'Con base en las definiciones de caso vigentes en el protocolo de vigilancia, este caso se clasifica como',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 55,
                ],
                // INFORMACIÓN EPIDEMIOLÓGICA
                [
                    'nombre_campo' => 'Poblaciones y factores de riesgo',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 56,
                ],
                [
                    'nombre_campo' => 'Modo de transmisión más probable',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 56,
                ],
                [
                    'nombre_campo' => 'Donante de sangre',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 56,
                ],
                [
                    'nombre_campo' => 'Momento en el que fue diagnosticada con HB',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 56,
                    'condicion' => 'Materno infantil',
                    'comparacion' => 388
                ],
                [
                    'nombre_campo' => 'Semanas de gestación',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 56,
                    'max' => true,
                    'min' => true,
                    'condicion' => 'Materno infantil',
                    'comparacion' => 388
                ],
                [
                    'nombre_campo' => '¿Vacunación previa con Hepatitis B?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 56,
                ],
                [
                    'nombre_campo' => 'Número de dosis',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 56,
                ],
                [
                    'nombre_campo' => 'Fecha última dosis (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 56,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 56,
                ],
                // DATOS CLÍNICOS
                [
                    'nombre_campo' => 'Signos y síntomas',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 57,
                ],
                [
                    'nombre_campo' => '¿Presenta alguna de las siguientes complicaciones?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 57,
                ],
                [
                    'nombre_campo' => 'Coinfección VIH',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 57,
                ],
                // DIAGNÓSTICO DE TRANSMISION MATERNO INFANTIL
                [
                    'nombre_campo' => 'Nombres y apellidos de la madre (aplica solo para transmisión materno infantil)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 58,
                    'condicion' => 'Materno infantil',
                    'comparacion' => 388
                ],
                [
                    'nombre_campo' => 'Tipo de ID*',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 58,
                    'condicion' => 'Materno infantil',
                    'comparacion' => 388
                ],
                [
                    'nombre_campo' => 'Número de identificación',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 58,
                    'condicion' => 'Materno infantil',
                    'comparacion' => 388
                ],
                [
                    'nombre_campo' => 'Aplicación de la vacuna contra la hepatitis B al recién nacido',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 58,
                    'condicion' => 'Materno infantil',
                    'comparacion' => 388
                ],
                [
                    'nombre_campo' => 'Aplicación de gamaglobulina/inmunoglobulina contra la hepatitis B al recién nacido',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 58,
                    'condicion' => 'Materno infantil',
                    'comparacion' => 388
                ],
                // DATOS DE LABORATORIO
                [
                    'nombre_campo' => 'Fecha toma de examen (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 59,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de recepción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 59,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Muestra',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 59,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Prueba',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 59,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Agente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 59,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Resultado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 59,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de resultado (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 59,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'valor',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 59,
                    'obligatorio' => false,
                ],

                // HEPATITIS C
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 60,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 60,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 60,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 60,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 60,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 60,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 60,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 417
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 60,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 60,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 419
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 60,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 419
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 60,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 419
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 61,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 61,
                    'obligatorio' => false,
                ],
                // CLASIFICACIÓN DEL CASO
                [
                    'nombre_campo' => 'Con base en las definiciones de caso vigentes en el protocolo de vigilancia, este caso se clasifica como',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 62,
                ],
                // INFORMACIÓN EPIDEMIOLÓGICA
                [
                    'nombre_campo' => 'Poblaciones y factores de riesgo',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 63,
                ],
                [
                    'nombre_campo' => 'Modo de transmisión más probable',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 63,
                ],
                [
                    'nombre_campo' => 'Donante de sangre',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 63,
                ],
                [
                    'nombre_campo' => 'Momento en el que fue diagnosticada con HB',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 63,
                    'condicion' => 'Materno infantil',
                    'comparacion' => 427
                ],
                [
                    'nombre_campo' => 'Semanas de gestación',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 63,
                    'max' => true,
                    'min' => true,
                    'condicion' => 'Materno infantil',
                    'comparacion' => 427
                ],
                [
                    'nombre_campo' => '¿Vacunación previa con Hepatitis B?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 63,
                ],
                [
                    'nombre_campo' => 'Número de dosis',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 63,
                ],
                [
                    'nombre_campo' => 'Fecha última dosis (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 63,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 63,
                ],
                // DATOS CLÍNICOS
                [
                    'nombre_campo' => 'Signos y síntomas',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 64,
                ],
                [
                    'nombre_campo' => '¿Presenta alguna de las siguientes complicaciones?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 64,
                ],
                [
                    'nombre_campo' => 'Coinfección VIH',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 64,
                ],
                // DIAGNÓSTICO DE TRANSMISION MATERNO INFANTIL
                [
                    'nombre_campo' => 'Nombres y apellidos de la madre (aplica solo para transmisión materno infantil)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 65,
                    'condicion' => 'Materno infantil',
                    'comparacion' => 427
                ],
                [
                    'nombre_campo' => 'Tipo de ID*',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 65,
                    'condicion' => 'Materno infantil',
                    'comparacion' => 427
                ],
                [
                    'nombre_campo' => 'Número de identificación',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 65,
                    'condicion' => 'Materno infantil',
                    'comparacion' => 427
                ],
                [
                    'nombre_campo' => 'Aplicación de la vacuna contra la hepatitis B al recién nacido',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 65,
                    'condicion' => 'Materno infantil',
                    'comparacion' => 427
                ],
                [
                    'nombre_campo' => 'Aplicación de gamaglobulina/inmunoglobulina contra la hepatitis B al recién nacido',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 65,
                    'condicion' => 'Materno infantil',
                    'comparacion' => 427
                ],
                // DATOS DE LABORATORIO
                [
                    'nombre_campo' => 'Fecha toma de examen (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 66,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de recepción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 66,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Muestra',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 66,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Prueba',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 66,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Agente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 66,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Resultado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 66,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de resultado (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 66,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'valor',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 66,
                    'obligatorio' => false,
                ],

                // INTOXICACIONES POR SUSTANCIAS QUIMICAS
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 67,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 67,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 67,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 67,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 67,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 67,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 67,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 456
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 67,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 67,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 458
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 67,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 458
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 67,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 458
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 68,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 68,
                    'obligatorio' => false,
                ],
                // DATOS DE LA EXPOSICIÓN
                [
                    'nombre_campo' => 'Grupo de sustancias',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 69,
                ],
                [
                    'nombre_campo' => 'Código y nombre del producto:',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 69,
                ],
                [
                    'nombre_campo' => 'Tipo de exposición',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 69,
                ],
                [
                    'nombre_campo' => 'Lugar donde se produjo la intoxicación',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 69,
                ],
                [
                    'nombre_campo' => 'Fecha de exposición (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 69,
                ],
                [
                    'nombre_campo' => 'Hora (0 a 24)',
                    'tipo_campo' => 'hora',
                    'cabecera_id' => 69,
                ],
                [
                    'nombre_campo' => 'Vía de exposición',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 69,
                ],
                // OTROS DATOS
                [
                    'nombre_campo' => 'Escolaridad',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 70,
                ],
                [
                    'nombre_campo' => '¿Afiliado a A.R.L.?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 70,
                ],
                [
                    'nombre_campo' => 'Código de la A.R.L',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 70,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Nombre de la A.R.L',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 70,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Estado civil',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 70,
                ],
                // SEGUIMIENTO
                [
                    'nombre_campo' => '¿El caso hace parte de un brote?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 71,
                ],
                [
                    'nombre_campo' => 'Número de casos en este brote',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 71,
                ],
                [
                    'nombre_campo' => 'Fecha investigación epidemiológia brote (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 71,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Situación de alerta',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 71,
                ],
                // DATOS DE LABORATORIO
                [
                    'nombre_campo' => 'Se tomaron muestras de toxicología',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 72,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Tipo de muestras solicitada',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 72,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Nombre de la prueba toxicológica',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 72,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Diligencie Valor resultado/unidades',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 72,
                    'obligatorio' => false,
                ],

                // LEPTOPIROSIS
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 73,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 73,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 73,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 73,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 73,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 73,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 73,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 489
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 73,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 73,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 491

                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 73,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 491

                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 73,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 491
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 74,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 74,
                    'obligatorio' => false,
                ],
                // DATOS CLINICOS
                [
                    'nombre_campo' => 'Signos y síntomas (marque con X los que se presenten)',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 75,
                ],
                // ANTECEDENTES EPIDEMIOLOGICOS
                [
                    'nombre_campo' => '¿Hay animales en la casa? (Selecciones los que tenga)',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 76,
                ],
                [
                    'nombre_campo' => '¿Cuál otro?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 76,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Ha visto ratas dentro o alrededor de su domicilio o lugar de trabajo?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 76,
                ],
                [
                    'nombre_campo' => 'Abastecimiento de agua',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 76,
                ],
                [
                    'nombre_campo' => '¿Cuenta con sistema de alcantarillado?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 76,
                ],
                [
                    'nombre_campo' => '¿Contacto con aguas estancadas durante los últimos 30 días',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 76,
                ],
                [
                    'nombre_campo' => 'Actividades recreativas en represa, lago o laguna a en los últimos 30 días antes del comienzo de los síntoma',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 76,
                ],
                [
                    'nombre_campo' => 'Disposición de residuos sólidos',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 76,
                ],

                // MALARIA
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 77,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 77,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 77,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 77,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 77,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 77,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 77,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 511
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 77,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 77,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 513
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 77,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 513
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 77,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 513
                ],
                // DATOS COMPLEMENTARIOS
                [
                    'nombre_campo' => 'Vigilancia activa',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 78,
                ],
                [
                    'nombre_campo' => 'Sintomático',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 78,
                ],
                [
                    'nombre_campo' => 'Clasificación según origen',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 78,
                ],
                [
                    'nombre_campo' => 'Recurrencia',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 78,
                ],
                [
                    'nombre_campo' => 'Trimestre de gestación',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 78,
                ],
                [
                    'nombre_campo' => 'Tipo de examen',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 78,
                ],
                [
                    'nombre_campo' => 'Recuento parasitario (Valor minimo 16 parásitos)',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 78,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Gametocitos',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 78,
                ],
                [
                    'nombre_campo' => '¿Desplazamiento en los últimos 15 días?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 78,
                ],
                [
                    'nombre_campo' => 'País de desplazamiento',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 78,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Departamento de desplazamiento',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 78,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Municipio de desplazamiento',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 78,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Complicaciones',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 78,
                ],
                [
                    'nombre_campo' => '¿Cuáles?',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 78,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Tratamiento',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 78,
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de tratamiento (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 78,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Especie infectante',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 78,
                ],
                [
                    'nombre_campo' => 'Fecha del resultado (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 78,
                    'obligatorio' => false,
                ],
                // REGISTRO INDIVIDUAL DE MALARIA
                [
                    'nombre_campo' => 'Nombres del paciente',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 79,
                ],
                [
                    'nombre_campo' => 'Apellidos del paciente',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 79,
                ],
                [
                    'nombre_campo' => 'Tipo de examen',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 79,
                ],
                [
                    'nombre_campo' => 'Especie infectante',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 79,
                ],
                [
                    'nombre_campo' => 'Recuento parasitario (Valor mínimo 16 parásitos)',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 79,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha del resultado (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 79,
                    'obligatorio' => false,
                ],

                // Campo faltante defectos congenitos
                [
                    'nombre_campo' => 'Número de identificación madre',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 23,
                ],

                // MORTALIDAD MATERBA EXTREMA
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 80,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 80,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 80,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 80,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 80,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 80,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 80,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 547
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 80,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 80,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 549
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 80,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 549
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 80,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 549
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 81,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 81,
                    'obligatorio' => false,
                ],
                // SISTEMA DE REFERENCIA
                [
                    'nombre_campo' => '¿La paciente ingresa remitida de otra institución?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 82,
                ],
                [
                    'nombre_campo' => 'Institución de referencia 1',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 82,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Institución de referencia 2',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 82,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Tiempo del tramite de remision',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 82,
                    'obligatorio' => false,
                ],
                // CARACTERÍSTICAS MATERNAS
                [
                    'nombre_campo' => 'Número de gestaciones',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 83,
                ],
                [
                    'nombre_campo' => 'Partos vaginales',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 83,
                ],
                [
                    'nombre_campo' => 'Cesáreas',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 83,
                ],
                [
                    'nombre_campo' => 'Abortos',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 83,
                ],
                [
                    'nombre_campo' => 'Molas',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 83,
                ],
                [
                    'nombre_campo' => 'Ectópicos',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 83,
                ],
                [
                    'nombre_campo' => 'Muertos',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 83,
                ],
                [
                    'nombre_campo' => 'Vivos',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 83,
                ],
                [
                    'nombre_campo' => 'Fecha de terminación de la última gestación (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 83,
                ],
                [
                    'nombre_campo' => 'Número de controles prenatales',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 83,
                ],
                [
                    'nombre_campo' => 'Semanas al inicio CPN',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 83,
                    'max' => true,
                    'min' => true,
                ],
                [
                    'nombre_campo' => 'Terminación de la gestación',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 83,
                ],
                [
                    'nombre_campo' => 'Momento de ocurrencia con relación a terminación de gestación',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 83,
                ],

                // CRITERIOS DE INCLUSIÓN
                [
                    'nombre_campo' => 'Cardiovascular',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 84,
                ],
                [
                    'nombre_campo' => 'Renal',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 84,
                ],
                [
                    'nombre_campo' => 'Hepática',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 84,
                ],
                [
                    'nombre_campo' => 'Cerebral',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 84,
                ],
                [
                    'nombre_campo' => 'Respiratoria',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 84,
                ],
                [
                    'nombre_campo' => 'Coagulación/Hematológica',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 84,
                ],
                [
                    'nombre_campo' => 'Eclampsia',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 84,
                ],
                [
                    'nombre_campo' => 'Preeclamsia severa',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 84,
                ],
                [
                    'nombre_campo' => 'Sepsis o infección sistemica severa',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 84,
                ],
                [
                    'nombre_campo' => 'Hemorragia obstetrica severa',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 84,
                ],
                [
                    'nombre_campo' => 'Ruptura uterina',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 84,
                ],
                [
                    'nombre_campo' => 'Cirugía adicional',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 84,
                ],
                // DATOS RELACIONADOS CON EL MANEJO
                [
                    'nombre_campo' => 'Si en cirugía adicional marcó SI, indique que cirugía 1',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 85,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '¿Cuál cirugía adicional 1?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 85,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Si en cirugía adicional marcó SI, indique que cirugía 2',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 85,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => '¿Cuál cirugía adicional 2?',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 85,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de egreso (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 85,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Egreso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 85,
                    'obligatorio' => false,
                ],
                // CAUSAS DE MORBILIDAD
                [
                    'nombre_campo' => 'Causa principal agrupada',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 86,
                ],
                [
                    'nombre_campo' => 'Causa asociada 1 (CIE 10):',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 86,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Causa asociada 2 (CIE 10):',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 86,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Causa asociada 3 (CIE 10):',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 86,
                    'obligatorio' => false,
                ],

                // TUBERCULOSIS
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 87,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 87,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 87,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 87,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 87,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 87,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 87,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 599
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 87,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 87,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 601
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 87,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 601
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 87,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 601
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 88,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 88,
                    'obligatorio' => false,
                ],
                // CLASIFICACIÓN DE LA TUBERCULOSIS
                [
                    'nombre_campo' => 'Condición',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 89,
                ],
                [
                    'nombre_campo' => 'Tipo de tuberculosis',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 89,
                ],
                [
                    'nombre_campo' => 'Localización de la tuberculosis extrapulmonar',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 89,
                ],
                // CLASIFICACIÓN DE CASO BASADA EN LA HISTORIA DE TRATAMIENTO PREVIO DE LA TUBERCULOSIS Y BASADA EN EL RESULTADO DEL TRATAMIENTO
                [
                    'nombre_campo' => 'Según antecedente de tratamiento',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 90,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Previamente tratado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 90,
                    'obligatorio' => false,
                ],
                // INFORMACIÓN ADICIONAL
                [
                    'nombre_campo' => 'El paciente es trabajador de la salud?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 91,
                ],
                [
                    'nombre_campo' => 'Ocupación',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 91,
                ],
                [
                    'nombre_campo' => '¿Clasifiación basada en el estado de la prueba para VIH?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 91,
                ],
                [
                    'nombre_campo' => 'Peso actual (Kg)',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 91,
                ],
                [
                    'nombre_campo' => 'Talla actual (Mts)',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 91,
                ],
                [
                    'nombre_campo' => 'IMC (índice masa corporal)',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 91,
                ],
                // CONFIGURACIÓN DE CASO
                [
                    'nombre_campo' => 'Baciloscopia',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Resultado baciloscopia',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Cultivo',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Resultado cultivo',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Prueba Molecular',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Resultado prueba molecular para la confirmación del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Nombre de la especie identificada',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Histopatologia',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Resultado histopatología',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Resultado prueba de sensibilidad a fármacos (PSF)',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Cuadro clínico',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Nexo epidemiológico',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Radiológico',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'ADA',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Tuberculina',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de confirmación diagnóstico TBFR (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Clasificación de caso según tipo de resistencia',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Monoresistencia - Isoniazida',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Monoresistencia - Etambutol',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Monoresistencia - Pirazinamida',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'MDR - Isoniazida',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'MDR - Rifampicina',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Poliresistente - Isoniazida',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Poliresistente - Etambutol',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Poliresistente - Pirazinamida',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'XDR (Extensivamente resistente) - Isoniazida',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'XDR (Extensivamente resistente) - Rifampicina',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'XDR (Extensivamente resistente) - Levofloxacina',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'XDR (Extensivamente resistente) - Moxifloxacina',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'XDR (Extensivamente resistente) - Bedaquilina',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'XDR (Extensivamente resistente) - Linezolid',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'RR (Resistencia a rifampicina) - Rifampicina',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Resistencia a pre XDR - Isoniazida',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Resistencia a pre XDR - Rifampicina',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Resistencia a pre XDR - Levofloxacina',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Resistencia a pre XDR - Moxifloxacina',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Resistencia a pre XDR - Bedaquilina',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Resistencia a pre XDR - Linezolid',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Resistencia a otros medicamentos - Clofazimina',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Resistencia a otros medicamentos - Delamanid',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],

                // VARICELA
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 93,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 93,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 93,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 93,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 93,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 93,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 93,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 663
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 93,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 93,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 665
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 93,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 665
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 93,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 665
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 94,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 94,
                    'obligatorio' => false,
                ],

                // VIH - SIDA
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 95,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 95,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 95,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 95,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 95,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 95,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 95,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 676
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 95,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 95,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 678
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 95,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 678
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 95,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 678
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 96,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 96,
                    'obligatorio' => false,
                ],
                // ANTECEDENTES EPIDEMIOLÓGICOS
                [
                    'nombre_campo' => 'Sexual',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 97,
                ],
                [
                    'nombre_campo' => 'Parenteral',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 97,
                ],
                [
                    'nombre_campo' => 'Nombre de la madre',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 97,
                ],
                [
                    'nombre_campo' => 'Tipo de ID*',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 97,
                ],
                [
                    'nombre_campo' => 'Número de identificación',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 97,
                ],
                [
                    'nombre_campo' => 'Identidad de género',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 97,
                ],
                [
                    'nombre_campo' => '¿Donó sangre en los 12 meses anteriores a esta notificación?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 97,
                ],
                // DIAGNÓTICO DE LABORATORIO
                [
                    'nombre_campo' => 'Tipo de prueba con la cual se confirmá el diagnóstico',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 98,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de resultado (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 98,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Valor de la carga viral (N° de copias)',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 98,'
                    obligatorio' => false,
                ],
                // INFORMACIÓN CLÍNICA I
                [
                    'nombre_campo' => 'Estado clínico',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 99,
                    'obligatorio' => false,
                ],
                // INFORMACIÓN CLÍNICA II
                [
                    'nombre_campo' => 'Enfermedades asociadas - Seleccione las enfermedades oportunistas/coinfecciones que presente el paciente con estadio SIDA',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 100,
                    'obligatorio' => false,
                ],

                // VIOLENCIA DE GENERO
                // NOTIFICACIÓN
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 101,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 101,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 101,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 101,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 101,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 101,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 101,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 701
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 101,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 101,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 703
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 101,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 703
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 101,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 703
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 102,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 102,
                    'obligatorio' => false,
                ],
                // MODALIDAD DE LA VIOLENCIA (Notifique el tipo de violencia que cause mayor afectación la víctima)
                [
                    'nombre_campo' => 'Violencia no sexual',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 103,
                ],
                [
                    'nombre_campo' => 'Violencia sexual',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 103,
                ],
                // DATOS DE LA VÍCTIMA
                [
                    'nombre_campo' => 'Actividad',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 104,
                ],
                [
                    'nombre_campo' => 'Orientación sexual',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 104,
                ],
                [
                    'nombre_campo' => 'Identidad de género',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 104,
                ],
                [
                    'nombre_campo' => 'Persona consumidora de SPA',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 104,
                ],
                [
                    'nombre_campo' => 'Persona con jefatura de hogar',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 104,
                ],
                [
                    'nombre_campo' => 'Antecedente de violencia',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 104,
                ],
                [
                    'nombre_campo' => 'Alcohol víctima',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 104,
                ],
                // DATOS DEL AGRESOR
                [
                    'nombre_campo' => 'Sexo',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 105,
                ],
                [
                    'nombre_campo' => 'Parentesco con la víctima',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 105,
                ],
                [
                    'nombre_campo' => 'Convive con el agresor (a)',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 105,
                ],
                [
                    'nombre_campo' => 'Agresor no familiar',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 105,
                ],
                [
                    'nombre_campo' => '¿Hecho violento ocurrido en el marco del conflicto armado?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 105,
                ],
                // DATOS DEL HECHO
                [
                    'nombre_campo' => 'Mecanismo utlizado para la agresión',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 106,
                ],
                [
                    'nombre_campo' => 'Sitio Anatómico comprometido con la quemadura',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 106,
                ],
                [
                    'nombre_campo' => 'Grado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 106,
                ],
                [
                    'nombre_campo' => 'Extensión',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 106,
                ],
                [
                    'nombre_campo' => 'Fecha del hecho (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 106,
                ],
                [
                    'nombre_campo' => 'Escenario',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 106,
                ],
                [
                    'nombre_campo' => 'Ámbito de la violencia según lugar de ocurrencia',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 106,
                ],
                // ATENCIÓN INTEGRAL EN SALUD
                [
                    'nombre_campo' => 'Profilaxis VIH.',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 107,
                ],
                [
                    'nombre_campo' => 'Profilaxis Hep B.',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 107,
                ],
                [
                    'nombre_campo' => 'Otras profilaxis',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 107,
                ],
                [
                    'nombre_campo' => 'Anticoncepción de emergencia',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 107,
                ],
                [
                    'nombre_campo' => 'Orientación IVE',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 107,
                ],
                [
                    'nombre_campo' => 'Salud Mental',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 107,
                ],
                [
                    'nombre_campo' => 'Remisión a protección',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 107,
                ],
                [
                    'nombre_campo' => 'Informe a autoridades / denuncia a policía judicíal (URI, CTI), fiscalía , policia nacional',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 107,
                ],
                [
                    'nombre_campo' => 'Recolección de evidencia médico legal',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 107,
                ],

                // campo faltante en TUBERCULOSIS
                [
                    'nombre_campo' => 'Coomorbilidades - condiciones especiales para el manejo',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 92,
                    'obligatorio' => false,
                ],

                // LEISHMANIASIS
                // NOTIFICACION
                [
                    'nombre_campo' => 'Fuente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 108,
                ],
                [
                    'nombre_campo' => 'Dirección de residencia',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 108,
                ],
                [
                    'nombre_campo' => 'Fecha de consulta (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 108,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de inicio de síntomas (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 108,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Clasificación inicial de caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 108,
                ],
                [
                    'nombre_campo' => 'Hospitalizado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 108,
                ],
                [
                    'nombre_campo' => 'Fecha de hospitalización (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 108,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Si',
                    'comparacion' => 6
                ],
                [
                    'nombre_campo' => 'Condición final',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 108,
                ],
                [
                    'nombre_campo' => 'Fecha de defunción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 108,
                    'obligatorio' => false,
                    'max' => true,
                    'condicion' => 'Muerto',
                    'comparacion' => 8
                ],
                [
                    'nombre_campo' => 'Número certificado de defunción',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 108,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 8
                ],
                [
                    'nombre_campo' => 'Causa básica de muerte',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 108,
                    'obligatorio' => false,
                    'condicion' => 'Muerto',
                    'comparacion' => 8
                ],
                // ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES
                [
                    'nombre_campo' => 'Seguimiento y clasificación final del caso',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 109,
                    'obligatorio' => false,
                ],
                [
                    'nombre_campo' => 'Fecha de ajuste (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 109,
                    'obligatorio' => false,
                ],
                // CUTANEA
                [
                    'nombre_campo' => 'Localización de la (s) lesión (es) ',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 110,
                    'obligatorio' => true,
                ],
                // MUCOSA
                [
                    'nombre_campo' => 'Mucosa afectada',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 111,
                    'obligatorio' => true,
                ],
                [
                    'nombre_campo' => 'Signos y síntomas',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 111,
                    'obligatorio' => true,
                ],
                // VISCERAL
                [
                    'nombre_campo' => 'Signos y síntomas',
                    'tipo_campo' => 'seleccion_multiple',
                    'cabecera_id' => 112,
                    'obligatorio' => true,
                ],
                [
                    'nombre_campo' => '¿Tiene Diagnóstico VIH confirmado?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 112,
                    'obligatorio' => true,
                ],
                // TRATAMIENTO
                [
                    'nombre_campo' => '¿Recibió tratamiento anterior?',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 113,
                    'obligatorio' => true,
                ],
                [
                    'nombre_campo' => 'Tratamiento local',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 113,
                    'obligatorio' => true,
                ],
                [
                    'nombre_campo' => 'Peso actual del paciente',
                    'tipo_campo' => 'numero',
                    'cabecera_id' => 113,
                    'obligatorio' => true,
                ],
                [
                    'nombre_campo' => 'Medicamento formulado actualmente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 113,
                    'obligatorio' => true,
                ],
                [
                    'nombre_campo' => 'Otro cuál',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 113,
                    'obligatorio' => true,
                ],
                [
                    'nombre_campo' => 'Número de cápsulas o volumen diario a aplicar',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 113,
                    'obligatorio' => true,
                ],
                [
                    'nombre_campo' => 'Días de tratamiento',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 113,
                    'obligatorio' => true,
                ],
                [
                    'nombre_campo' => 'Total de cápsulas ó ampollas',
                    'tipo_campo' => 'texto',
                    'cabecera_id' => 113,
                    'obligatorio' => true,
                ],
                // DATOS DE LABORATORIO
                [
                    'nombre_campo' => 'Fecha toma de examen (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 114,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Fecha de recepción (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 114,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Muestra',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 114,
                ],
                [
                    'nombre_campo' => 'Prueba',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 114,
                ],
                [
                    'nombre_campo' => 'Agente',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 114,
                ],
                [
                    'nombre_campo' => 'Resultado',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 114,
                ],
                [
                    'nombre_campo' => 'Fecha de resultado (dd/mm/aaaa)',
                    'tipo_campo' => 'fecha',
                    'cabecera_id' => 114,
                    'max' => true
                ],
                [
                    'nombre_campo' => 'Valor',
                    'tipo_campo' => 'seleccion_simple',
                    'cabecera_id' => 114,
                ],

            ];

            foreach ($campoSivigilas as $campoSivigila) {
                CampoSivigila::updateOrCreate([
                    'nombre_campo' => $campoSivigila['nombre_campo'],
                    'cabecera_id' => $campoSivigila['cabecera_id'],
                ], [
                    'nombre_campo' => $campoSivigila['nombre_campo'],
                    'tipo_campo' => $campoSivigila['tipo_campo'],
                    'cabecera_id' => $campoSivigila['cabecera_id'],
                    'obligatorio' => $campoSivigila['obligatorio'] ?? true,
                    'max' => $campoSivigila['max'] ?? false,
                    'min' => $campoSivigila['min'] ?? false,
                    'condicion' => $campoSivigila['condicion'] ?? null,
                    'comparacion' => $campoSivigila['comparacion'] ?? null,
                ]);
            }
        } catch (\Throwable $th) {
            Log::error('Error en CampoSivigilaSeeder: ' . $th->getMessage());
        }
    }
}
