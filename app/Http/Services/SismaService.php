<?php

namespace App\Http\Services;

use App\Http\Modules\Factura\Models\LogSisma;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class SismaService
{
    protected $baseUrl = 'https://integracion.sismacorporation.com/api/';
    protected $token;

    /**
     * Autenticacion con API de SISMA Se realiza en cada peticion ya que caduca
     *
     * @return void
     */
    public function loginApiSisma()
    {
        $response = Http::post($this->baseUrl . 'Auth/login', [
            'usuario' => 'AppHorus',
            'password'   => 'horus123*',
        ]);

        if ($response->successful()) {
            $this->token = $response->json()['token'];
            return $this->token;
        }

        throw new \Exception('Error al autenticar con Sisma: ' . $response->body());
    }

    /**
     * verificar Afiliado en SISMA
     *
     * @param $tipoDocumento
     * @param $numeroDocumento
     * @author Calvarez
     */
    public function verificarPaciente($tipoDocumento, $numeroDocumento)
    {
        if (!$this->token) {
            $this->loginApiSisma();
        }

        $response = Http::withToken($this->token)
            ->get($this->baseUrl . 'Paciente/BuscarPaciente', [
                'tipoDocumento' => $tipoDocumento,
                'numeroDocumento' => $numeroDocumento,
            ]);

        return $response->body();
    }

    /**
     * Crear un afiliado en SISMA
     *
     * @param $datosPaciente
     * @author Calvarez
     */
    public function crearPaciente(array $datosPaciente)
    {
        if (!$this->token) {
            $this->loginApiSisma();
        }

        $response = Http::withToken($this->token)
            ->post($this->baseUrl . 'Paciente/Crear', $datosPaciente);

        if ($response->successful()) {
            return $response->body();
        }

        throw new \Exception('Error al crear paciente: ' . $response->body());
    }

    /**
     * listar Servicios Pendientes Facturar que cuentan con estudio
     *
     * @param $numDocumento
     * @author Calvarez
     */
    public function listarServiciosPendientesFacturar($numDocumento)
    {
        if (!$this->token) {
            $this->loginApiSisma();
        }
        $response = Http::withToken($this->token)
            ->get($this->baseUrl . 'Facturacion/base64', [
                'documento' => $numDocumento,
            ]);

        return $response->body();
    }

    /**
     * Registro de admision
     *
     * @param $datosAdmision
     * @author Calvarez
     */
    public function registrarAdmision(array $datosAdmision)
    {
        if (!$this->token) {
            $this->loginApiSisma();
        }

        $response = Http::withToken($this->token)
            ->post($this->baseUrl . 'Facturacion/GenerarAdmision', $datosAdmision);

        $respuestaDecodificada = json_decode($response->body(), true);
        $estudio = $respuestaDecodificada['estudio'] ?? null;

        //Guardar el log de registro en SISMA
        LogSisma::create([
            'estudio'             => $estudio,
            'idSede'              => $datosAdmision['idSede'],
            'autoId'              => $datosAdmision['autoId'],
            'codigoEmpresa'       => $datosAdmision['codigoEmpresa'],
            'codigoClasificacion' => $datosAdmision['codigoClasificacion'],
            'fechaIngreso'        => $datosAdmision['fechaIngreso'] ?? null,
            'horaIngreso'         => $datosAdmision['horaIngreso'] ?? null,
            'codigoMedico'        => $datosAdmision['codigoMedico'],
            'contrato'            => $datosAdmision['contrato'],
            'idPuntoAtencion'     => $datosAdmision['idPuntoAtencion'],
            'codigo'              => $datosAdmision['codigo'],
            'descripcion'         => $datosAdmision['descripcion'],
            'cantidad'            => $datosAdmision['cantidad'],
            'valor'               => $datosAdmision['valor'],
            'created_by'          => Auth::id(),
        ]);

        if ($response->successful()) {
            return $response->body(); // o response->body() si quieres texto plano
        }

        throw new \Exception('Error al registrar admisión: ' . $response->body());
    }
}
