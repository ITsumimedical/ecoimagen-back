<?php

namespace App\Http\Modules\Clientes\Services;

use Illuminate\Support\Str;
use App\Http\Modules\Clientes\Models\Cliente;
use App\Http\Modules\Clientes\Repositories\ClienteRepository;
use Illuminate\Support\Facades\Mail;

class ClienteService
{
    public function __construct(protected ClienteRepository $clienteRepository) {}

    public function crearClientes($request)
    {
        $token = Str::random(48);
        $crear =  Cliente::create([
            'name' => $request['name'],
            'correo' => $request['correo'],
            'secret' => $token,
            'revoked' => false
        ]);

        $enviar =  Mail::send('emailToken', ['detalle' => $token, 'id' => $crear->id], function ($m) use ($request) {
            $m->to($request['correo'])->subject('Token');
        });
        return (object)[
            'crear' => $crear,
            'enviarCorreo' => $enviar
        ];
    }

    public function actualizarClientes(array $data, int $id)
    {
        return Cliente::where('id', $id)->update($data);
    }
}
