<?php

namespace App\Http\Modules\CuentasMedicas\EmailCuentasMedicas\Repositories;

use App\Http\Modules\Bases\RepositoryBase;
use App\Http\Modules\CuentasMedicas\EmailCuentasMedicas\Models\EmailCuentasMedica;

class EmailCuentasMedicaRepository extends RepositoryBase {

    protected $emailCuentaMedica;

    public function __construct() {
        $this->emailCuentaMedica = new EmailCuentasMedica();
        parent::__construct($this->emailCuentaMedica);
    }

    public function listarEmail($data){
        $codigo = $this->emailCuentaMedica->select('email_cuentas_medicas.email','email_cuentas_medicas.id as idEmail','email_cuentas_medicas.prestador_id',
        'prestadores.nombre_prestador','prestadores.nit','prestadores.id')
        ->selectRaw("CONCAT(prestadores.nit,' - ',prestadores.nombre_prestador) as nombrePrestador")
        ->join('prestadores','prestadores.id','email_cuentas_medicas.prestador_id');
    return  $data['page'] ? $codigo->paginate($data['cantidad']) : $codigo->get();

    }

    public function cambiarEmail($id_email_prestador,$email){
        $codigo = $this->emailCuentaMedica::find($id_email_prestador);
        return $codigo->update([
            'email' => $email
          ]);
    }

    public function crearActualizar($data){
        $email =  $this->emailCuentaMedica::updateOrCreate(['prestador_id' => $data->prestador], ['email' => $data->correo]);
        return $email;
    }
}
