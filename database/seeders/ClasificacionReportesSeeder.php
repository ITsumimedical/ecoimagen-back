<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class ClasificacionReportesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $reportes = [
            [
                'nombre' => 'Pesos y Tallas',
                'url' => 'peso-y-talla',
                'funcion_sql' => 'fn_pesostallasta',
                'campos_requeridos' => json_encode(['fechaInicial', 'fechaFinal', 'estado']),
                'permiso' => 'pesos.tallas',
            ],
            [
                'nombre' => 'Servicios Pendientes',
                'url' => 'servicios-pendientes',
                'funcion_sql' => 'fnservicios_pendientes',
                'campos_requeridos' => json_encode(['fechaInicial', 'fechaFinal', 'estado']),
                'permiso' => 'servicios.pendientes',
            ],
            [
                'nombre' => 'Medicamentos Pendientes',
                'url' => 'medicamentos-pendientes',
                'funcion_sql' => 'fnmedicamentos_pendientes',
                'campos_requeridos' => json_encode(['fechaInicial', 'fechaFinal', 'estado']),
                'permiso' => 'medicamentos.pendientes',
            ],
            [
                'nombre' => 'Consultas Riesgo Cardiovascular',
                'url' => 'rcv',
                'funcion_sql' => 'fn_consultas_rcv',
                'campos_requeridos' => json_encode(['fechaInicial', 'fechaFinal', 'entidad']),
                'permiso' => 'riesgo.cardiovascular',
            ],
            [
                'nombre' => 'Demanda Insatisfecha',
                'url' => 'demanda-insatisfecha',
                'funcion_sql' => 'fn_demanda_insatisfecha',
                'campos_requeridos' => json_encode(['fechaiInicial', 'fechaFinal']),
                'permiso' => 'demanda.insatisfecha',
            ],
            [
                'nombre' => 'Citas agendadas global',
                'url' => 'export-agenda-completa',
                'funcion_sql' => 'fn_export_agenda_completa',
                'campos_requeridos' => json_encode(['fechaiInicial', 'fechaFinal']),
                'permiso' => 'citas.agendadasGlobal',
            ],
            [
                'nombre' => 'Citas agendadas por sede',
                'url' => 'export-agenda',
                'funcion_sql' => 'fn_export_agenda',
                'campos_requeridos' => json_encode(['fechaiInicial', 'fechaFinal', 'rep']),
                'permiso' => 'citas.agendadadSede',
            ],
            [
                'nombre' => 'Medicamentos Dispensados',
                'url' => 'medicamentos-dispensados',
                'funcion_sql' => 'fn_medicamentos_dispensados',
                'campos_requeridos' => json_encode(['fechaInicial', 'fechaFinal']),
                'permiso' => 'medicamentos.dispensados',
            ],
            [
                'nombre' => 'Movimientos bodegas',
                'url' => 'movimiento-bodegas',
                'funcion_sql' => 'fn_movimientos_bodegas',
                'campos_requeridos' => json_encode(["fechaiInicial", "fechaFinal", "bodega_id", "codigos", "factura"]),
                'permiso' => 'movimiento.bodegas',
            ],
            [
                'nombre' => 'Reporte de helpdesk',
                'url' => 'reporte-helpdesk',
                'funcion_sql' => 'fn_reporte_helpdesk',
                'campos_requeridos' => json_encode(['fechaiInicial', 'fechaFinal']),
                'permiso' => 'reporte.helpdesk',
            ],
            [
                'nombre' => 'Entrada por factura',
                'url' => 'entrada-por-factura',
                'funcion_sql' => 'fn_entrada_por_factura',
                'campos_requeridos' => json_encode(['fechaiInicial', 'fechaFinal']),
                'permiso' => 'entrada.factura',
            ],
            [
                'nombre' => 'Agendas Disponibles',
                'url' => 'agendas-disponibles',
                'funcion_sql' => 'fn_export_agendas_disponibles',
                'campos_requeridos' => json_encode(['fechaiInicial', 'fechaFinal']),
                'permiso' => 'agendas.disponibles',
            ],
            [
                'nombre' => 'Eventos adversos',
                'url' => 'eventos-adversos',
                'funcion_sql' => 'fn_reporte_eventos_adversos',
                'campos_requeridos' => json_encode(['fechaiInicial', 'fechaFinal']),
                'permiso' => 'eventos.adversos',
            ],
            [
                'nombre' => 'Caracterización',
                'url' => 'caracterizacion',
                'funcion_sql' => 'fn_caracterizacion',
                'campos_requeridos' => json_encode(['fechaiInicial', 'fechaFinal']),
                'permiso' => 'caracterizacion',
            ],
            [
                'nombre' => 'Demanda inducida',
                'url' => 'demanda-inducida',
                'funcion_sql' => 'fn_obtener_demanda_inducida',
                'campos_requeridos' => json_encode(['fechaiInicial', 'fechaFinal']),
                'permiso' => 'demanda.inducidaReporte',
            ],
            [
                'nombre' => 'Asistencias educativas',
                'url' => 'asistencias-educativas',
                'funcion_sql' => 'fn_obtener_asistencias_educativas',
                'campos_requeridos' => json_encode(['fechaiInicial', 'fechaFinal']),
                'permiso' => 'asistenciasEducativas.reporte',
            ],
            [
                'nombre' => 'Pendientes PQRS',
                'url' => 'pendientes-pqrs',
                'funcion_sql' => 'fn_pendientes_pqrs',
                'campos_requeridos' => json_encode([]),
                'permiso' => 'pendientes.pqrsfReporte',
            ],
            [
                'nombre' => 'Global PQRS',
                'url' => 'global-pqrs',
                'funcion_sql' => 'fn_global_pqrs',
                'campos_requeridos' => json_encode(['fechaiInicial', 'fechaFinal']),
                'permiso' => 'globalPqrsf.reporte',
            ],
            [
                'nombre' => 'Medicamentos pendientes de farmacia',
                'url' => 'medicamentos-pendientes-farmacia',
                'funcion_sql' => 'fn_medicamentos_pendientes',
                'campos_requeridos' => json_encode(['fechaiInicial', 'fechaFinal']),
                'permiso' => 'medicamentosPendientesFarmacia.reporte',
            ],
            [
                'nombre' => 'Agenda disponible oftalmología',
                'url' => 'agenda-disponible-oftalmologia',
                'funcion_sql' => 'fn_export_citas_y_agenda_disponible_oftalmologia',
                'campos_requeridos' => json_encode(['fechaiInicial', 'fechaFinal']),
                'permiso' => 'reporte.agendaDisponibleOftalmologia',
            ],
            [
                'nombre' => 'Medicamentos dispensados por bodega',
                'url' => 'medicamentos-dispensados-bodega',
                'funcion_sql' => 'fn_medicamentos_dispensados_bodega',
                'campos_requeridos' => json_encode(['fechaiInicial', 'fechaFinal', 'bodega_id']),
                'permiso' => 'reporte.medicamentosDispensadosBodega',
            ]
        ];

        foreach ($reportes as $reporte) {
            DB::table('clasificacion_reportes')->insert(array_merge($reporte, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}
