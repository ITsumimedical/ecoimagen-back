<?php

namespace App\Http\Modules\ProveedoresCompras\Services;

use App\Http\Modules\AdjuntosProveedoresCompras\Models\AdjuntoProveedor;
use App\Http\Modules\AdjuntosProveedoresCompras\Service\AdjuntoProveedoresService;
use App\Http\Modules\ProveedoresCompras\Models\ProveedoresCompras;
use App\Traits\ArchivosTrait;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Rap2hpoutre\FastExcel\FastExcel;

use function PHPUnit\Framework\isEmpty;

class ProveedoresComprasService
{

    use ArchivosTrait;

    public function __construct(protected AdjuntoProveedoresService $adjuntoProveedoresService)
    {
    }

    public function crearProveedor($data)
    {   
        DB::beginTransaction();
        try {
            $existe = ProveedoresCompras::where('nit', $data['nit'])->exists();

            if ($existe) {
                throw new \Exception('El proveedor ya existe dentro de la plataforma', 409);
            }

            $crearProveedor = ProveedoresCompras::create($data);

            $adjuntos = [];
            if (!empty($data['files'])) {
                $ruta = 'adjuntosProveedoresCompras';
            
                foreach ($data['files'] as $index => $file) {
                    if ($file instanceof \Illuminate\Http\UploadedFile) {
                        $nombre = $file->getClientOriginalName();
                        $uuid = Str::uuid();
                        $nombreUnicoAdjunto = $uuid . '.' . $nombre;
            
                        $subirArchivo = $this->subirArchivoNombre($ruta, $file, $nombreUnicoAdjunto, 'server37');
            
                        $tipoAdjunto = $data['tipo_adjunto'][$index] ?? null;
                        $adjuntos[] = $this->adjuntoProveedoresService->crearAdjunto([
                            'nombre' => $nombre,
                            'tipo_adjunto' => $tipoAdjunto,
                            'ruta_adjunto' => $subirArchivo,
                            'proveedor_id' => $crearProveedor->id
                        ]);
                    }
                }
            }
            
         
            if (!empty($data['linea_id'])) {
                $lineaCompra = ProveedoresCompras::where('id', $crearProveedor->id)->first();
                $lineaCompra->lineasCompra()->sync($data['linea_id']);
            }
            DB::commit();
            return [
                // 'proveedor' => $crearProveedor,
                'comprador' => $lineaCompra
            ];
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    public function listarProveedor($request)
    {
        $query = ProveedoresCompras::with('municipio:id,nombre', 'area:id,nombre,estado', 'lineasCompra', 'pais:id,nombre');

        if (isset($request['nit'])) {
            $query->porNIT($request['nit']);
        }

        if (isset($request['contrato'])) {
            $query->PorContrato($request['contrato']);
        }

        return $query->orderBy('id', 'desc')->get();
    }

    public function cambiarEstado(int $id)
    {
        $proveedor = ProveedoresCompras::findOrFail($id);
        return ProveedoresCompras::where('id', $id)->update(['estado' => $proveedor->estado ? false : true]);
    }

    public function contadoresProveedor()
    {
        $modalidadVinculacion = DB::table('proveedores_compras')
            ->selectRaw('count(*) as total, modalidad_vinculacion')
            ->groupBy('modalidad_vinculacion')
            ->get();

        return $modalidadVinculacion;
    }

    public function proveedoresLineas($request)
    {
        $cita = ProveedoresCompras::where('id', $request['proveedor_id'])->first();
        $cita->lineasCompra()->sync($request['lineas']);
        return $cita;
    }

    public function modificarProveedor($request, $id)
    {
        $post = ProveedoresCompras::findOrFail($id);
        return $post->update($request);
    }

    public function obtenerAdjuntosPorProveedorId($proveedor)
    {
        $adjuntos = AdjuntoProveedor::where('proveedor_id', $proveedor)->get();

        return $adjuntos->map(function ($adjunto) {
            return [
                'id' => $adjunto->id,
                'nombre' => $adjunto->nombre,
                'tipo' => $adjunto->tipo_adjunto,
                'url' => Storage::disk('server37')->temporaryUrl($adjunto->ruta_adjunto, now()->addMinutes(5))
            ];
        })->toArray();
    }

    public function cargaMasiva(array $adjuntos)
    {
        try {
            $archivo = $adjuntos['file'];
            $coleccion = (new FastExcel)->import($archivo);

            if ($coleccion->isEmpty()) {
                throw new \Exception('El archivo no contiene los datos esperados', 409);
            }

            $errores = [];

            DB::beginTransaction();

            foreach ($coleccion as $item) {
                try {
                    ProveedoresCompras::insert([
                        'nombre_proveedor' => $item['nombre_proveedor'] ?? '',
                        'nit' => $item['nit'] ?? '',
                        'nombre_representante' => $item['nombre_representante'] ?? '',
                        'telefono' => $item['telefono'] ?? '',
                        'direccion' => $item['direccion'] ?? '',
                        'municipio_id' => $item['municipio_id'] ?? null,
                        'email' => $item['email'] ?? '',
                        'actividad_economica' => $item['actividad_economica'] ?? '',
                        'modalidad_vinculacion' => $item['modalidad_vinculacion'] ?? '',
                        'forma_pago' => $item['forma_pago'] ?? '',
                        'tiempo_entrega' => $item['tiempo_entrega'] ?? '',
                        'tipo_proveedor' => $item['tipo_proveedor'] ?? '',
                        'estado' => $item['estado'] ?? '',
                        'fecha_ingreso' => $item['fecha_ingreso'] ?? now(),
                        'observaciones' => $item['observaciones'] ?? '',
                        'tipo_documento_legal' => $item['tipo_documento_legal'] ?? '',
                        'pais_id' => $item['pais_id'] ?? null,
                        'codigo_dian' => $item['codigo_dian'] ?? null,
                        'responsabilidad_fiscal' => $item['responsabilidad_fiscal'] ?? null,
                        'created_at' => now(),
                    ]);
                } catch (\Exception $e) {
                    $errores[] = "Error en el registro con NIT {$item['nit']}: " . $e->getMessage();
                }
            }

            if (!empty($errores)) {
                DB::rollBack();
                return response()->json(['message' => 'Errores en la importación', 'errores' => $errores], 422);
            }

            DB::commit();
            return response()->json(['message' => 'Importación exitosa'], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error en la carga masiva', 'error' => $e->getMessage()], 500);
        }
    }
}
