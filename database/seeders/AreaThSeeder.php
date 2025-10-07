<?php

namespace Database\Seeders;

use App\Http\Modules\AreasTalentoHumano\Models\AreaTh;
use Illuminate\Database\Seeder;
use Illuminate\Http\Response;

class AreaThSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        try {
            $Areas = [
                ['nombre'   =>  'GERENCIA', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION DE COMUNICACIONES Y BIENESTAR', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION DE CALIDAD', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION DE EXPERIENCIA DEL USUARIO', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION DE CONTROL INTERNO', 'estado_id' => 1],
                ['nombre'   =>  'DIRECCION DE RED Y ACCESO A SERVICIOS DE SALUD ', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION DE AUDITORIA CONCURRENTE Y CENTRO REGULADOR', 'estado_id' => 1],
                ['nombre'   =>  'DIRECCION DE GESTION DEL RIESGO EN SALUD', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION DE POBLACIONES EN RIESGO', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION PROMOCION Y PREVENCION', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION GESTION INTEGRAL DE RIESGO EN SALUD', 'estado_id' => 1],
                ['nombre'   =>  'DIRECCION REGIONAL CHOCO', 'estado_id' => 1],
                ['nombre'   =>  'DIRECCION REGIONAL NORORIENTAL', 'estado_id' => 1],
                ['nombre'   =>  'SUBGERENCIA ADMINISTRATIVA Y FINANCIERA', 'estado_id' => 1],
                ['nombre'   =>  'DIRECCION ADMINISTRATIVA', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION DE INFRAESTRUCTURA TECNOLOGIA', 'estado_id' => 1],
                ['nombre'   =>  'COORDINADOR DE CONTAC CENTER', 'estado_id' => 1],
                ['nombre'   =>  'COORDINADOR DE INFRAESTRUCTURA FISICA', 'estado_id' => 1],
                ['nombre'   =>  'COORDINADOR DE SEGURIDAD FISICA', 'estado_id' => 1],
                ['nombre'   =>  'ARCHIVO Y CORRESPONDENCIA', 'estado_id' => 1],
                ['nombre'   =>  'LIDER ADMINISTRATIVO Y LOGISTICO', 'estado_id' => 1],
                ['nombre'   =>  'ANALISTA DE COMPRAS Y LOGISTICA', 'estado_id' => 1],
                ['nombre'   =>  'DIRECCION FINANCIERA', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION DE CONTABILIDAD', 'estado_id' => 1],
                ['nombre'   =>  'CUENTAS MEDICAS', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE FACTURACION', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE TESORERIA', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION DE SISTEMAS DE INFORMACION', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION BASE DE DATOS', 'estado_id' => 1],
                ['nombre'   =>  'SUBGERENCIA DE DESARROLLO ORGANIZACIONAL Y PLANEACION', 'estado_id' => 1],
                ['nombre'   =>  'DIRECCION DE TALENTO HUMANO', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION DE NOMINA Y SEGURIDAD SOCIAL', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION DE SEGURIDAD Y SALUD EN EL TRABAJO', 'estado_id' => 1],
                ['nombre'   =>  'SUBGERENCIA DE PRESTACION DE SERVICIOS DE SALUD', 'estado_id' => 1],
                ['nombre'   =>  'DIRECTOR MEDICO', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE SEDE TURBO', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE SEDE APARTADO', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE SEDE PUERTO BERRIO', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE SEDE ITAGUI', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE SEDE ESTADIO', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE SEDE APOYO TERAPEUTICO', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE SEDE BELLO', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE SEDE ENVIGADO', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE SEDE BOLIVIA', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE SEDE CAUCASIA', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE SEDE TORRE MEDICA', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE SEDE TORRE RIONEGRO', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE SEDE CHOCO', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION MEDICINA LABORAL', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION DE SERVICIOS FARMACEUTICOS', 'estado_id' => 1],
                ['nombre'   =>  'SUBGERENCIA CLINICA VICTORIANA', 'estado_id' => 1],
                ['nombre'   =>  'DIRECCION MEDICA CLINICA VICTORIANA', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION DE ATENCION DOMICILIARIA', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION DE ENFERMERIA', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE HOSPITALIZACION', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE UNIDAD DE CUIDADOS CRITICOS', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE CIRUGIA', 'estado_id' => 1],
                ['nombre'   =>  'LIDER DE ONCOLOGIA', 'estado_id' => 1],
                ['nombre'   =>  'LIDER CENTRAL DE ESTERILIZACION', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION DE GESTION DE SOLICITUDES', 'estado_id' => 1],
                ['nombre'   =>  'SUBDIRECCION DE SERVICIOS DE SALUD AMBULATORIOS', 'estado_id' => 1],
                ['nombre'   =>  'COORDINACION DE ARQUITECTURA DE DATOS', 'estado_id' => 1],
            ];
            foreach ($Areas as $Area) {
                AreaTh::updateOrCreate([
                    'nombre' => $Area['nombre'],
                ],[
                    'nombre' => $Area['nombre'],
                    'estado_id' => $Area['estado_id'],
                ]);
            };
        } catch (\Throwable $th) {
            return response()->json([
                'mensaje' => 'error al ejecutar el seeder de AreaTh seeder'
            ],Response::HTTP_BAD_REQUEST);
        }
    }
}
