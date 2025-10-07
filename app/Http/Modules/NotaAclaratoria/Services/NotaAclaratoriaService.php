<?php

namespace App\Http\Modules\NotaAclaratoria\Services;

use App\Http\Modules\NotaAclaratoria\Repositories\NotaAclaratoriaRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class NotaAclaratoriaService{

    public function __construct( private NotaAclaratoriaRepository $notaAclaratoria)
    {

    }

    public function guardar($data){
        return DB::transaction(function () use ($data) {
            $data['user_id'] = Auth::id();
            $area = $this->notaAclaratoria->crear($data);
            $area->historiaClinica()->attach($data['historia']);
            return '$area';
        });
    }
}
