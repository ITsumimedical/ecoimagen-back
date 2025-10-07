<?php

namespace App\Http\Modules\Cac\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Cac\Models\PatologiasCac;
use Illuminate\Support\Collection;

class PatologiasCacRepository extends RepositoryBase
{
    protected PatologiasCac $patologiasCacModel;

    public function __construct()
    {
        parent::__construct($this->patologiasCacModel = new PatologiasCac());
    }

    /**
     * Listar patologias
     * @return PatologiasCac[]
     * @author Thomas
     */
    public function listarPatologias(array $data): Collection
    {
        $activos = filter_var($data['activo'], FILTER_VALIDATE_BOOLEAN) ?? false;

        $query = $this->patologiasCacModel->query();

        if ($activos) {
            $query->where('activo', true);
        }

        return $query->orderBy('id', 'asc')->get();
    }

    /**
     * Activa o inactiva una patologia
     * @param int $patologia_id
     * @return bool
     * @author Thomas
     */
    public function cambiarEstado(int $patologia_id): bool
    {
        $patologia = $this->patologiasCacModel->findOrFail($patologia_id);

        return $patologia->update([
            "activo" => !$patologia->activo
        ]);
    }

    /**
     * Asocia especialidades a una patologia
     * @param array $data
     * @return array
     * @author Thomas
     */
    public function asociarEspecialidadesPatologia(array $data): array
    {
        $patologiaId = $data['patologia_id'];
        $especialidades = $data['especialidades'];

        $patologia = $this->patologiasCacModel->findOrFail($patologiaId);

        return $patologia->especialidades()->syncWithoutDetaching($especialidades);
    }

    /**
     * Remueve especialidades de una patologia
     * @param array $data
     * @return int
     * @author Thomas
     */
    public function removerEspecialidadesPatologia(array $data): int
    {
        $patologiaId = $data['patologia_id'];
        $especialidades = $data['especialidades'];

        $patologia = $this->patologiasCacModel->findOrFail($patologiaId);

        return $patologia->especialidades()->detach($especialidades);
    }

    /**
     * Listar especialidades de una patologia
     * @param int $patologia_id
     * @return Collection
     */
    public function listarEspecialidadesPatologia(int $patologia_id): Collection
    {
        return $this->patologiasCacModel->findOrFail($patologia_id)->especialidades()->get();
    }
}