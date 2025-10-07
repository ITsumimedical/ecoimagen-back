<?php

namespace App\Http\Services;

use Illuminate\Support\Facades\Http;

class SmsService
{
    /**
     * ENvio de mensajes de textos con el proveedor fonoplus
     *
     * @param  mixed $celular
     * @param  mixed $msg
     * @return boolean
     */
    public function envioSms($celular, $msg): bool
    {
        $data = [
            'token' => 'trl0sln27ebdsp0knffyn4',
            'email' => 'sumimedical@fonoplus.com',
            'type_send' => '1via',
            'data' => [
                [
                    'cellphone' => $celular,
                    'message' => $msg
                ]
            ]
        ];
        $response = Http::post('https://contacto-masivo.com/sms/back_sms/public/api/send/sms/json', $data);
        $data = $response->json();
        if (isset($data['type_error'])) {
            throw new \Exception($data['message'], 400);
        }
        
        return true;
    }
}
