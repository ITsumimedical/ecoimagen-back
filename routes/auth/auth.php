<?php

use App\Http\Modules\Afiliados\Controllers\AfiliadoController;
use App\Http\Modules\Agendas\Controllers\AgendaController;
use App\Http\Modules\Auth\Controllers\AuthController;
use App\Http\Modules\Certificados\Controllers\CertificadoController;
use App\Http\Modules\Consultas\Controllers\ConsultaController;
use App\Http\Modules\Departamentos\Controllers\DepartamentoController;
use App\Http\Modules\GestionPqrsf\Formulario\Controllers\FormulariopqrsfController;
use App\Http\Modules\Municipios\Controllers\MunicipioController;
use App\Http\Modules\Reps\Controllers\RepsController;
use App\Http\Modules\Usuarios\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\Http\Controllers\AccessTokenController;

Route::prefix('auth', 'throttle:60,1')->group(function () {

    Route::post('login', [AuthController::class, 'login']);
    Route::post('pagina', [AfiliadoController::class, 'consultarWeb']);
    Route::post('actualizacion-pacientes', [AfiliadoController::class, 'actualizarWeb']);
    Route::get('municipios', [MunicipioController::class, 'listar']);
    Route::get('departamentos', [DepartamentoController::class, 'listar']);
    Route::post('reps', [RepsController::class, 'listarConfiltro']);
    Route::post('certificado/crear', [CertificadoController::class, 'crear']);
    Route::post('certificado/pdf', [CertificadoController::class, 'pdf']);
    Route::get('/reps-municipio/{municipio}', [MunicipioController::class, 'listarReps']);
    Route::post('validar-informacion', [UsuarioController::class, 'validarInformacion']);
    Route::post('recuperar-contrasena', [UsuarioController::class, 'actualizacionContrasena']);
    Route::post('validar-codigo-operador', [UsuarioController::class, 'validarCodigoRecuperacion']);

    Route::middleware(['token.api', 'cita.tipo'])->group(function () {
        Route::get('listar', [AgendaController::class, 'consultarCitas']);

    });

    Route::middleware(['token.api'])->group(function () {
        Route::post('firmar-consentimiento', [ConsultaController::class, 'firmaConsentimientos']);
        Route::post('consultar', [ConsultaController::class, 'consultarConsentimientoTeleconsulta']);
        Route::post('encuesta-satisfaccion', [FormulariopqrsfController::class, 'encuestaSatisfaccion']);
    });

    Route::middleware(['auth:api'])->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);//->middleware('permission:auth.logout');
        Route::get('me', [AuthController::class, 'me']);//->middleware('permission:auth.logout');
        Route::get('usuarios-activos', [AuthController::class, 'getUsuariosActivos']);//->middleware('permission:auth.logout');
    });

    /**
     * grupo de rutas para autenticar a clientes
     */
    Route::post('/login-client/token', [AccessTokenController::class, 'issueToken']);
});
