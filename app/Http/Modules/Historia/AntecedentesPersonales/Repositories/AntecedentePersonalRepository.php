<?php

namespace App\Http\Modules\Historia\AntecedentesPersonales\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\Historia\AntecedentesPersonales\Models\AntecedentePersonale;
use Error;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AntecedentePersonalRepository extends RepositoryBase
{

    protected $antecedentePersonalModel;

    public function __construct(AntecedentePersonale $antecedentePersonalModel)
    {
        parent::__construct($antecedentePersonalModel);
        $this->antecedentePersonalModel = $antecedentePersonalModel;
    }

    public function listarAntecedentes($data)
    {
        return AntecedentePersonale::with(['consulta', 'user.operador:user_id,nombre,apellido'])->whereHas('consulta.afiliado', function ($q) use ($data) {
            $q->where('afiliados.id', $data->afiliado);
        })
            ->orderBy('id', 'asc')
            ->get();
    }

    public function eliminar($data)
    {
        return $this->antecedentePersonalModel->where('id', $data->id)->delete();
    }

    public function crearAntecedente(array $data)
    {
        $user = Auth::user();
        $data['medico_registra'] = $user ? $user->id : null;

        $patologiaRequest = $data['patologias'] ?? null;
        $afiliado_id = $data['afiliado_id'] ?? null;

        // Validar si la patología ya existe para el afiliado específico a través de la consulta
        $patologiaExistente = $this->antecedentePersonalModel
            ->where('patologias', $patologiaRequest)
            ->whereHas('consulta', function ($query) use ($afiliado_id) {
                $query->where('afiliado_id', $afiliado_id);
            })
            ->exists();

        if ($patologiaExistente) {
            throw new Error('Esta patología ya fue registrada para el afiliado especificado');
        }

        $this->antecedentePersonalModel->create($data);
    }

    public function listarAntecedenteAfiliado($numero_documento)
    {
        $antecedentes = $this->antecedentePersonalModel->select('antecedente_personales.id', 'antecedente_personales.medico_registra', 'antecedente_personales.patologias', 'antecedente_personales.created_at', DB::raw("CONCAT(operadores.nombre, ' ', operadores.apellido) as operador_nombre_completo"), 'cie10s.nombre as cie10')
            ->leftjoin('afiliados', 'antecedente_personales.afiliado_id', 'afiliados.id')
            ->leftjoin('users', 'antecedente_personales.medico_registra', 'users.id')
            ->leftjoin('operadores', 'users.id', 'operadores.user_id')
            ->leftjoin('cie10s', 'antecedente_personales.cie10_id', 'cie10s.id')
            ->whereNotNull('antecedente_personales.demanda_inducida_id')
            ->where('afiliados.numero_documento', $numero_documento)
            ->get();

        return $antecedentes;
    }
    
    /**
     * Method obtenerDiabetes
     * Se usa para verificar si el afiliado tiene diabetes
     * @param int $afiliado_id 
     *
     * @return bool
     */
    public function obtenerDiabetes(int $afiliado_id): bool
    {
        return AntecedentePersonale::select('patologias')
            ->where('afiliado_id', $afiliado_id)
            ->where(function ($query) {
                for ($i = 101; $i <= 119; $i++) {
                    $query->orWhere('patologias', 'like', "%E{$i}%");
                }
            })
            ->exists();
    }
}
