<?php

namespace Database\Seeders;

use App\Http\Modules\Epidemiologia\Models\CabeceraSivigila;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CabeceraSivigilaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        try {
            $cabeceraSivigilas = [

                // ACIDENTE OFICIDICO
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 1,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 1,
                ],
                [
                    'nombre_cabecera' => 'RELACIÓN CON LOS DATOS BÁSICOS',
                    'evento_id' => 1,
                ],
                [
                    'nombre_cabecera' => 'CUADRO CLÍNICO',
                    'evento_id' => 1,
                ],
                [
                    'nombre_cabecera' => 'ATENCIÓN HOSPITALARIA',
                    'evento_id' => 1,
                ],

                // AGRECION POR APTR
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 2,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 2,
                ],
                [
                    'nombre_cabecera' => 'DATOS DE LA AGRESIÓN O CONTACTO, DE LA ESPECIE AGRESORA Y DE LA CLASIFICACIÓN DE LA EXPOSICIÓN',
                    'evento_id' => 2,
                ],
                [
                    'nombre_cabecera' => 'ANTECEDENTES DE INMUNIZACIÓN DEL PACIENTE',
                    'evento_id' => 2,
                ],
                [
                    'nombre_cabecera' => 'DATOS DEL TRATAMIENTO ORDENADO EN LA ACTUALIDAD',
                    'evento_id' => 2,
                ],

                // CANCER DE CUELLO UTERINO
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 3,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 3,
                ],
                [
                    'nombre_cabecera' => 'DATOS ESPECÍFICOS',
                    'evento_id' => 3,
                ],

                // CANCER DE MAMA
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 4,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 4,
                ],
                [
                    'nombre_cabecera' => 'DATOS ESPECÍFICOS',
                    'evento_id' => 4,
                ],

                // CANCER EN MENORES DE 18 AÑOS
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 5,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 5,
                ],
                [
                    'nombre_cabecera' => 'TIPO DE CÁNCER',
                    'evento_id' => 5,
                ],
                [
                    'nombre_cabecera' => 'DATOS DE LABORATORIO - MÉTODOS DIAGNÓSTICOS',
                    'evento_id' => 5,
                ],

                // DEFECTOS CONGENITOS
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 6,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 6,
                ],
                [
                    'nombre_cabecera' => 'RELACIÓN CON LOS DATOS BÁSICOS',
                    'evento_id' => 6,
                ],
                [
                    'nombre_cabecera' => 'INFORMACÓN MATERNA',
                    'evento_id' => 6,
                ],
                [
                    'nombre_cabecera' => 'INFORMACIÓN COMPLEMENTARIA DEL NIÑO',
                    'evento_id' => 6,
                ],
                [
                    'nombre_cabecera' => 'DEFECTOS CONGÉNITOS',
                    'evento_id' => 6,
                ],
                [
                    'nombre_cabecera' => 'DATOS DE LABORATORIO',
                    'evento_id' => 6,
                ],

                // DENGUE
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 7,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 7,
                ],
                [
                    'nombre_cabecera' => 'DATOS ESPECÍFICOS',
                    'evento_id' => 7,
                ],
                [
                    'nombre_cabecera' => 'DATOS PARA CLASIFICACIÓN DEL DENGUE',
                    'evento_id' => 7,
                ],
                [
                    'nombre_cabecera' => 'CLASIFICACIÓN FINAL Y ATENCION DEL CASO',
                    'evento_id' => 7,
                ],
                [
                    'nombre_cabecera' => 'EN CASO DE MORTALIDAD POR DENGUE',
                    'evento_id' => 7,
                ],
                [
                    'nombre_cabecera' => 'DATOS DE LABORATORIO',
                    'sub_titulo' => 'La información relacionada con laboratorios debe ingresarse a través del modulo de laboratorios del aplicativo sivigila',
                    'evento_id' => 7,
                ],

                // DESNUTRICION EN MENORES DE  AÑOS
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 8,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 8,
                ],
                [
                    'nombre_cabecera' => 'DATOS DE LA MADRE O CUIDADOR',
                    'evento_id' => 8,
                ],
                [
                    'nombre_cabecera' => 'IDENTIFICACIÓN DE FACTORES',
                    'evento_id' => 8,
                ],
                [
                    'nombre_cabecera' => 'SIGNOS CLÍNICOS',
                    'evento_id' => 8,
                ],
                [
                    'nombre_cabecera' => 'RUTA DE ATENCIÓN',
                    'evento_id' => 8,
                ],

                // ENFERMEDADES HUERFANAS RARAS
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 9,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 9,
                ],
                [
                    'nombre_cabecera' => 'DATOS COMPLEMENTARIOS',
                    'evento_id' => 9,
                ],


                // ENFERMEDADES TRANSMITIDAS POR ALIMENTOS O AGUA
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 10,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 10,
                ],
                [
                    'nombre_cabecera' => 'DATOS CLÍNICOS',
                    'evento_id' => 10,
                ],
                [
                    'nombre_cabecera' => 'DATOS DE LA EXPOSICIÓN',
                    'evento_id' => 10,
                ],
                [
                    'nombre_cabecera' => 'DATOS DE LABORATORIO',
                    'evento_id' => 10,
                ],
                [
                    'nombre_cabecera' => 'ASOCIACIÓN CON BROTE',
                    'evento_id' => 10,
                ],
                [
                    'nombre_cabecera' => 'LABORATORIO',
                    'evento_id' => 10,
                ],

                // DATOS BASICOS - HEPATITIS A
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 11,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 11,
                ],

                // HEPATITIS B
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 12,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 12,
                ],
                [
                    'nombre_cabecera' => 'CLASIFICACIÓN DEL CASO',
                    'evento_id' => 12,
                ],
                [
                    'nombre_cabecera' => 'INFORMACIÓN EPIDEMIOLÓGICA',
                    'evento_id' => 12,
                ],
                [
                    'nombre_cabecera' => 'DATOS CLÍNICOS',
                    'evento_id' => 12,
                ],
                [
                    'nombre_cabecera' => 'DIAGNÓSTICO DE TRANSMISION MATERNO INFANTIL',
                    'evento_id' => 12,
                ],
                [
                    'nombre_cabecera' => 'DATOS DE LABORATORIO',
                    'evento_id' => 12,
                ],

                // HEPATITIS C
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 13,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 13,
                ],
                [
                    'nombre_cabecera' => 'CLASIFICACIÓN DEL CASO',
                    'evento_id' => 13,
                ],
                [
                    'nombre_cabecera' => 'INFORMACIÓN EPIDEMIOLÓGICA',
                    'evento_id' => 13,
                ],
                [
                    'nombre_cabecera' => 'DATOS CLÍNICOS',
                    'evento_id' => 13,
                ],
                [
                    'nombre_cabecera' => 'DIAGNÓSTICO DE TRANSMISION MATERNO INFANTIL',
                    'evento_id' => 13,
                ],
                [
                    'nombre_cabecera' => 'DATOS DE LABORATORIO',
                    'evento_id' => 13,
                ],


                //INTOXICACIONES POR SUSTANCIAS QUIMICAS
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 14,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 14,
                ],
                [
                    'nombre_cabecera' => 'DATOS DE LA EXPOSICIÓN',
                    'evento_id' => 14,
                ],
                [
                    'nombre_cabecera' => 'OTROS DATOS',
                    'evento_id' => 14,
                ],
                [
                    'nombre_cabecera' => 'SEGUIMIENTO',
                    'evento_id' => 14,
                ],
                [
                    'nombre_cabecera' => 'DATOS DE LABORATORIO',
                    'evento_id' => 14,
                ],

                // LEPTOSPIROSIS
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 15,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 15,
                ],
                [
                    'nombre_cabecera' => 'DATOS CLÍNICOS',
                    'evento_id' => 15,
                ],
                [
                    'nombre_cabecera' => 'ANTECEDENTES EPIDEMIOLÓGICOS',
                    'evento_id' => 15,
                ],

                // MALARIA
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 16,
                ],
                [
                    'nombre_cabecera' => 'DATOS COMPLEMENTARIOS',
                    'evento_id' => 16,
                ],
                [
                    'nombre_cabecera' => 'REGISTRO INDIVIDUAL DE MALARIA',
                    'evento_id' => 16,
                ],

                // MORTALIDAD MATERNA EXTREMA
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 17,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 17,
                ],
                [
                    'nombre_cabecera' => 'SISTEMA DE REFERENCIA',
                    'evento_id' => 17,
                ],
                [
                    'nombre_cabecera' => 'CARACTERÍSTICAS MATERNAS',
                    'evento_id' => 17,
                ],
                [
                    'nombre_cabecera' => 'CRITERIOS DE INCLUSIÓN',
                    'evento_id' => 17,
                ],
                [
                    'nombre_cabecera' => 'DATOS RELACIONADOS CON EL MANEJO',
                    'evento_id' => 17,
                ],
                [
                    'nombre_cabecera' => 'CAUSAS DE MORBILIDAD',
                    'evento_id' => 17,
                ],

                // TUBERCULOSIS
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 18,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 18,
                ],
                [
                    'nombre_cabecera' => 'CLASIFICACIÓN DE LA TUBERCULOSIS',
                    'evento_id' => 18,
                ],
                [
                    'nombre_cabecera' => 'CLASIFICACIÓN DE CASO BASADA EN LA HISTORIA DE TRATAMIENTO PREVIO DE LA TUBERCULOSIS Y BASADA EN EL RESULTADO DEL TRATAMIENTO',
                    'evento_id' => 18,
                ],
                [
                    'nombre_cabecera' => 'INFORMACIÓN ADICIONAL',
                    'evento_id' => 18,
                ],
                [
                    'nombre_cabecera' => 'CONFIGURACIÓN DE CASO',
                    'evento_id' => 18,
                ],

                // DATOS BASICOS - VARICELA
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 19,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 19,
                ],

                // VIH - SIDA
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 20,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 20,
                ],
                [
                    'nombre_cabecera' => 'ANTECEDENTES EPIDEMIOLÓGICOS',
                    'evento_id' => 20,
                ],
                [
                    'nombre_cabecera' => 'DIAGNÓSTICO DE LABORATORIO',
                    'evento_id' => 20,
                ],
                [
                    'nombre_cabecera' => 'INFORMACIÓN CLÍNICA I',
                    'evento_id' => 20,
                ],
                [
                    'nombre_cabecera' => 'INFORMACIÓN CLÍNICA II',
                    'evento_id' => 20,
                ],

                // VIOLENCIA DE GENERO E INTRAFAMILIAR
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 21,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 21,
                ],
                [
                    'nombre_cabecera' => 'MODALIDAD DE LA VIOLENCIA',
                    'evento_id' => 21,
                ],
                [
                    'nombre_cabecera' => 'DATOS DE LA VÍCTIMA',
                    'evento_id' => 21,
                ],
                [
                    'nombre_cabecera' => 'DATOS DEL AGRESOR',
                    'evento_id' => 21,
                ],
                [
                    'nombre_cabecera' => 'DATOS DEL HECHO',
                    'evento_id' => 21,
                ],
                [
                    'nombre_cabecera' => 'ATENCIÓN INTEGRAL EN SALUD',
                    'evento_id' => 21,
                ],

                // LEISHMANIASIS
                [
                    'nombre_cabecera' => 'NOTIFICACIÓN',
                    'evento_id' => 22,
                ],
                [
                    'nombre_cabecera' => 'ESPACIO EXCLUSIVO PARA USO DE LOS ENTES TERRITORIALES',
                    'evento_id' => 22,
                ],
                [
                    'nombre_cabecera' => 'CUTÁNEA',
                    'evento_id' => 22,
                ],
                [
                    'nombre_cabecera' => 'MUCOSA',
                    'evento_id' => 22,
                ],
                [
                    'nombre_cabecera' => 'VISCERAL',
                    'evento_id' => 22,
                ],
                [
                    'nombre_cabecera' => 'TRATAMIENTO',
                    'evento_id' => 22,
                ],
                [
                    'nombre_cabecera' => 'DATOS DE LABORATORIO',
                    'evento_id' => 22,
                ],

            ];
            foreach ($cabeceraSivigilas as $cabeceraSivigila) {
                CabeceraSivigila::updateOrCreate([
                    'nombre_cabecera' => $cabeceraSivigila['nombre_cabecera'],
                    'evento_id' => $cabeceraSivigila['evento_id'],
                ], [
                    'nombre_cabecera' => $cabeceraSivigila['nombre_cabecera'],
                    'sub_titulo' => $cabeceraSivigila['sub_titulo'] ?? null,
                    'evento_id' => $cabeceraSivigila['evento_id'],
                ]);
            }
        } catch (\Throwable $th) {
            Log::error('Error en CabeceraSigigilaSeeder: ' . $th->getMessage());
        }
    }
}
