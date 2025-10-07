<?php

namespace App\Http\Modules\ConfiguracionReportes\Services;

use App\Http\Modules\Reportes\Models\CabeceraReporte;
use App\Http\Modules\Reportes\Models\DetalleReporte;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Modules\Reportes\Models\EndpointRuta;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class ParametrizacionReporteService
{

    /**
     * Se consultan todas las rutas y se insertan en la tablas las no existentes
     *
     * @author Calvarez
     */
    public function registroRutas()
    {
        set_time_limit(300);
        $routes = Route::getRoutes();

        $routesArray = iterator_to_array($routes);

        $chunks = array_chunk($routesArray, 100);

        foreach ($chunks as $chunk) {
            DB::transaction(function () use ($chunk) {
                foreach ($chunk as $route) {
                    $uri = $route->uri();

                    // Guardar o actualizar el registro en la tabla
                    EndpointRuta::updateOrCreate(
                        ['url' => $uri],
                        [
                            'methods' => $route->methods(),
                            'name' => $route->getName(),
                            'action' => $route->getActionName(),
                            'url' => $uri,
                        ]
                    );
                }
            });

            unset($chunk);
        }
    }

    /**
     * crear reporte y detalle de reporte
     *
     * @param $request
     * @author Calvarez
     */
    public function crearReporte($request)
    {
        DB::beginTransaction();

        try {
            $userId = auth()->id();

            $cabeceraReporte = CabeceraReporte::create([
                'nombre_reporte' => $request['nombre_reporte'],
                'nombre_procedimiento' => $request['nombre_procedimiento'],
                'nombre_permiso' => $request['nombre_procedimiento'],
                'created_by' => $userId,
            ]);

            $cabeceraId = $cabeceraReporte->id;

            $detallesReporte = collect($request['parametros'])->map(function ($parametro) use ($cabeceraId, $userId) {
                return [
                    'cabecera_reporte_id' => $cabeceraId,
                    'nombre_parametro' => $parametro['nombre_parametro'],
                    'orden_parametro' => $parametro['orden_parametro'],
                    'tipo_dato' => $parametro['tipo_dato'],
                    'origen' => $parametro['origen'],
                    'nombre_columna_bd' => $parametro['nombre_columna_bd'],
                    'valor_columna_guardar' => $parametro['valor_columna_guardar'],
                    'created_by' => $userId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            })->toArray();

            DetalleReporte::insert($detallesReporte);

            Permission::updateOrCreate(
                ['name' => $request['nombre_procedimiento']],
                [
                    'guard_name' => 'api',
                    'descripcion' => $request['nombre_reporte'],
                    'created_by' => auth()->id()
                ]
            );

            DB::commit();

            return response()->json([
                'message' => 'Reporte creado exitosamente'
            ], Response::HTTP_CREATED);
        } catch (\Throwable $th) {
            DB::rollBack();

            return response()->json([
                'message' => 'Error al crear el reporte',
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
