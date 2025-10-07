<?php

namespace App\Http\Modules\LogRegistroRipsSumi\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\LogRegistroRipsSumi\Models\LogRegistroRipsSumi;

class LogRegistroRipsSumiRepository extends RepositoryBase
{
    protected $logModel;
    public function __construct()
    {
        $this->logModel = new LogRegistroRipsSumi();
        parent::__construct($this->logModel);
    }

    public function listarLogs(array $data)
    {
        $paginacion = $data['paginacion'];
        return $this->logModel->orderBy('id', 'asc')->paginate($paginacion['cantidadRegistros'], ['*'], 'page', $paginacion['pagina']);
    }
}
