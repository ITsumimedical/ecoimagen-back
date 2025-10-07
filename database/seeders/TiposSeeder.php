<?php

namespace Database\Seeders;

use App\Http\Modules\Tipos\Models\Tipo;
use Illuminate\Http\Response;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TiposSeeder extends Seeder
{
    public function run()
    {
        try {
            $tipos = [
                ['nombre' => 'Entrada','descripcion' => 'Entrada','activo' => 1],
                ['nombre' => 'Salida','descripcion' => 'Salida','activo' => 1],
                ['nombre' => 'Creo Pqrsf','descripcion' => 'Creo Pqrsf','activo' => 1],
                ['nombre' => 'Anulo Pqrsf','descripcion' => 'Anulo Pqrsf','activo' => 1],
                ['nombre' => 'Actualizo Pqrsf','descripcion' => 'Actualizo Pqrsf','activo' => 1],
                ['nombre' => 'Asigno Pqrsf','descripcion' => 'Asigno Pqrsf','activo' => 1],
                ['nombre' => 'Permiso Pqrsf','descripcion' => 'Permiso Pqrsf','activo' => 1],
                ['nombre' => 'Respuesta Pqrsf','descripcion' => 'Respuesta Pqrsf','activo' => 1],
                ['nombre' => 'Solucion Pqrsf','descripcion' => 'Solucion Pqrsf','activo' => 1],
                ['nombre' => 'Reasigno Pqrsf','descripcion' => 'Reasigno Pqrsf','activo' => 1],
                ['nombre' => 'Imagenologia','descripcion' => 'Imagenologia','activo' => 1],
                ['nombre' => 'Sumimedical','descripcion' => 'Sumimedical','activo' => 1],
                ['nombre' => 'Solicitud','descripcion' => 'Solicitud Helpdesk','activo' => 1],
                ['nombre' => 'Solucionar','descripcion' => 'Solucionado','activo' => 1],
                ['nombre' => 'Comentarios al Solicitante','descripcion' => 'Comentario Publico','activo' => 1],
                ['nombre' => 'Comentarios Internos','descripcion' => 'Comentario Privado','activo' => 1],
                ['nombre' => 'Anular','descripcion' => 'Anulado','activo' => 1],
                ['nombre' => 'Re asignar','descripcion' => 'Re asignado','activo' => 1],
                ['nombre' => 'Helpdesk','descripcion' => 'Helpdesk','activo' => 1],
                ['nombre' => 'Asignar','descripcion' => 'Asignado','activo' => 1],
                ['nombre' => 'Respuesta','descripcion' => 'Respuesta','activo' => 1],
                ['nombre' => 'Devolver','descripcion' => 'Devuelto','activo' => 1],
                ['nombre' => 'Evento Seguridad','descripcion' => 'Evento Seguridad','activo' => 1],
                ['nombre' => 'Evento Centinela','descripcion' => 'Evento Centinela','activo' => 1],
                ['nombre' => 'Evento Notificacion','descripcion' => '','activo' => 1],
                ['nombre' => 'Facturacion','descripcion' => 'Cuentas Medicas','activo' => 1],
                ['nombre' => 'Tarifas','descripcion' => 'Cuentas Medicas','activo' => 1],
                ['nombre' => 'Soportes','descripcion' => 'Cuentas Medicas','activo' => 1],
                ['nombre' => 'Autorizaciones','descripcion' => 'Cuentas Medicas','activo' => 1],
                ['nombre' => 'Cobertura','descripcion' => 'Cuentas Medicas','activo' => 1],
                ['nombre' => 'Pertinencia','descripcion' => 'Cuentas Medicas','activo' => 1],
                ['nombre' => 'Devoluciones','descripcion' => 'Cuentas Medicas','activo' => 1],
                ['nombre' => 'Respuestas a glosas y devoluciones','descripcion' => 'Cuentas Medicas','activo' => 1],
                ['nombre' => 'Servicio','descripcion' => 'Cuentas Medicas','activo' => 1],
                ['nombre' => 'Cuentas Medicas','descripcion' => 'Cuentas Medicas','activo' => 1],
                ['nombre' => 'Usuario Nuevo','descripcion' => 'Novedades','activo' => 1],
                ['nombre' => 'Retiro','descripcion' => 'Novedades','activo' => 1],
                ['nombre' => 'Reintegro','descripcion' => 'Novedades','activo' => 1],
                ['nombre' => 'Cambio de Datos Básicos','descripcion' => 'Novedades','activo' => 1],
                ['nombre' => 'Portabilidad Salida','descripcion' => 'Novedades','activo' => 1],
                ['nombre' => 'Finalización Portabilidad Salida','descripcion' => 'Novedades','activo' => 1],
                ['nombre' => 'Traslados','descripcion' => 'Novedades','activo' => 1],
                ['nombre' => 'Re Abierto','descripcion' => 'Re abrir Helpdesk','activo' => 1],

            ];
            foreach ($tipos as $tipo){
                Tipo::updateOrCreate([
                    'nombre'    => $tipo['nombre']
                ],[
                    'nombre'    => $tipo['nombre'],
                    'descripcion' => $tipo['descripcion'],
                    'activo' => $tipo['activo']
                ]);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'Error al ejecutar el seeder de tipo '
            ], Response::HTTP_BAD_REQUEST);
        }
    }
}
