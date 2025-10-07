<?php

namespace Database\Seeders;

use App\Http\Modules\EvaluacionesPeriodosPruebas\CriteriosEvaluacionesPeriodosPruebas\Models\CriterioEvaluacionPeriodoPrueba;
use App\Http\Modules\EvaluacionesPeriodosPruebas\PlantillasEvaluacionesPeriodosPruebas\Models\PlantillaEvaluacionPeriodoPrueba;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class PlantillaEvaluacionPeriodoPruebaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // CREACIÓN DE PLANTILLA ACTITUD
        $plantillaActitud = PlantillaEvaluacionPeriodoPrueba::create([
            'nombre' => 'ACTITUD',
            'descripcion' => 'Desarrollar las actividades que le son asignadas con entusiasmo y alegria despertando admiracion y siendo lider en el puesto que realiza generando acciones para hacer cada vez mejor su trabajo.',
        ]);

        // CREACIÓN DE TEMAS RELACIONADO A PLANTILLAS DE ACTITUD
        CriterioEvaluacionPeriodoPrueba::create([
            'nombre' => 'Trasmite energía y disposición en la ejecución de las actividades',
            'plantilla_evaluacion_periodo_pruebas_id' => $plantillaActitud->id
        ]);

        CriterioEvaluacionPeriodoPrueba::create([
            'nombre' => 'Actúa con iniciativa para emprender acciones que conducen al logro de los resultados',
            'plantilla_evaluacion_periodo_pruebas_id' => $plantillaActitud->id
        ]);

        CriterioEvaluacionPeriodoPrueba::create([
            'nombre' => 'Cumple con las normas y directices dadas por el líder en representacion de la empresa,escruchando y comunicandose efectivamente',
            'plantilla_evaluacion_periodo_pruebas_id' => $plantillaActitud->id
        ]);

        // CREACIÓN DE PLANTILLA TRABAJO EN EQUIPO
        $plantillaTrabajoEquipo = PlantillaEvaluacionPeriodoPrueba::create([
            'nombre' => 'TRABAJO EN EQUIPO',
            'descripcion' => 'Integrar esfuerzos individuales en la obtención de metas comunes, manteniendo una actitud de servicio y apertura para aprender de otros.',
        ]);

        // CREACIÓN DE TEMAS RELACIONADO A PLANTILLAS DE TRABAJO EN EQUIPO
        CriterioEvaluacionPeriodoPrueba::create([
            'nombre' => 'Toma en cuenta los aportes de otros para realizar su trabajo',
            'plantilla_evaluacion_periodo_pruebas_id' => $plantillaTrabajoEquipo->id
        ]);

        CriterioEvaluacionPeriodoPrueba::create([
            'nombre' => 'Brinda apoyo a sus compañeros en el desarrollo de tareas asignadas',
            'plantilla_evaluacion_periodo_pruebas_id' => $plantillaTrabajoEquipo->id
        ]);

        CriterioEvaluacionPeriodoPrueba::create([
            'nombre' => 'Contribuye a mantener un ambiente de trabajo conforme los valores organizacionales',
            'plantilla_evaluacion_periodo_pruebas_id' => $plantillaTrabajoEquipo->id
        ]);

        // CREACIÓN DE PLANTILLA CONFIABILIDAD TECNICA
        $plantillaConfiabilidadTecnica = PlantillaEvaluacionPeriodoPrueba::create([
            'nombre' => 'CONFIABILIDAD TECNICA',
            'descripcion' => 'Capacidad para alcanzar con precisión los objetivos planteados, superar los estándares de calidad establecidos',
        ]);

        // CREACIÓN DE TEMAS RELACIONADO A PLANTILLAS DE CONFIABILIDAD TECNICA
        CriterioEvaluacionPeriodoPrueba::create([
            'nombre' => 'Cumple con las politicas organizacionales socializadas en induccion general',
            'plantilla_evaluacion_periodo_pruebas_id' => $plantillaConfiabilidadTecnica->id
        ]);

        CriterioEvaluacionPeriodoPrueba::create([
            'nombre' => 'Su presentacion personal es acorde al cargo que desempeña',
            'plantilla_evaluacion_periodo_pruebas_id' => $plantillaConfiabilidadTecnica->id
        ]);

        CriterioEvaluacionPeriodoPrueba::create([
            'nombre' => 'Domina los temas referentes al area asignada',
            'plantilla_evaluacion_periodo_pruebas_id' => $plantillaConfiabilidadTecnica->id
        ]);

        CriterioEvaluacionPeriodoPrueba::create([
            'nombre' => 'Cumple de manera apropiada con las funciones y actividades asignadas para su cargo',
            'plantilla_evaluacion_periodo_pruebas_id' => $plantillaConfiabilidadTecnica->id
        ]);

    }
}
