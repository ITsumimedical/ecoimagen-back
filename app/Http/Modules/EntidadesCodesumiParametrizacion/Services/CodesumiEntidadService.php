<?php

namespace App\Http\Modules\EntidadesCodesumiParametrizacion\Services;

use App\Http\Modules\EntidadesCodesumiParametrizacion\Model\CodesumiEntidad;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CodesumiEntidadService
{
    /**
     * Crear e insertar programas asociados a los nuevos registros en CodesumiEntidad.
     *
     * @param array $request Datos enviados desde el frontend, incluyendo 'codesumi_id',
     * 'entidad_id' (array de IDs) y otros campos de parametrización.
     * @return bool Retorna true si la inserción fue exitosa, false si ocurre algún error.
     * @throws \Throwable Lanza una excepción si la transacción falla.
     */
    public function crearParametrizacionCodesumi(array $request): bool
    {
        DB::beginTransaction();
        try {
            $timestamps = Carbon::now();
            // Mapeo de datos para la inserción masiva
            $data = array_map(function ($entidadId) use ($request, $timestamps) {
                return [
                    'codesumi_id' => $request['codesumi_id'],
                    'entidad_id' => $entidadId,
                    'requiere_autorizacion' => $request['requiere_autorizacion'],
                    'nivel_ordenamiento' => $request['nivel_ordenamiento'],
                    'estado_normativo' => $request['estado_normativo'],
                    'requiere_mipres' => $request['requiere_mipres'],
                    'created_at' =>$timestamps,
                    'updated_at' =>$timestamps
                ];
            }, $request['entidad_id']);

            // Inserta en la base de datos
            CodesumiEntidad::insert($data);

            // Obtener los IDs recién creados
            $idsInsertados = CodesumiEntidad::whereIn('entidad_id', $request['entidad_id'])
                ->where('codesumi_id', $request['codesumi_id'])
                ->pluck('id')
                ->toArray();

            // Si hay programas, sincronizarlos con los nuevos registros
            if (!empty($request['programas'])) {
                $this->agregarProgramasCodesumiEntidad($idsInsertados, $request['programas']);
            }

            DB::commit();
            return true;
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }

    /**
     * Actualiza los campos de la tabla CodesumiEntidad con los datos enviados desde el frontend.
     *
     * @param int $id ID de la entidad Codesumi a actualizar.
     * @param array $request Datos a actualizar en formato clave-valor.
     * @return bool Retorna true si la actualización fue exitosa, false si no se afectó ninguna fila.
     */
    public function actualizarParametrizacionEntidad($codesumiEntidad, array $request): bool
    {
        if ($codesumiEntidad instanceof CodesumiEntidad) {
            // Si es una instancia del modelo, actualizar directamente
            return $codesumiEntidad->update($request);
        }

        // Si es un id, buscar y actualizar
        return CodesumiEntidad::where('id', $codesumiEntidad)->update($request);
    }

    /**
     * Sincroniza programas con múltiples CodesumiEntidad.
     *
     * @param array $ids Array de IDs de CodesumiEntidad.
     * @param array|string $programas IDs de programas o un array anidado con 'programas'.
     * @return bool Retorna true si la operación fue exitosa.
     * @author Serna
     */
    public function agregarProgramasCodesumiEntidad(array $ids, array $programas): bool
    {

        if (isset($programas['programas'])) {
            $programas = $programas['programas'];
        }

        foreach ($ids as $id) {
            $codesumi = CodesumiEntidad::where('id', $id)->first();
            $codesumi->programaCodesumi()->sync($programas);
            if ($codesumi) {
                $codesumi->programaCodesumi()->sync($programas);
            }
        }
        return true;
    }
}
