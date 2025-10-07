<?php

use App\Http\Modules\CuentasMedicas\EmailCuentasMedicas\Controllers\EmailCuentasMedicasController;
use Illuminate\Support\Facades\Route;

Route::prefix('email-cuentas-medicas','throttle:60,1v')->group(function(){
    Route::controller(EmailCuentasMedicasController::class)->group(function(){
        Route::get('listar','listar');//->middleware('permission:cuentasMedicas.listarEmail');
        Route::post('crear','crear');//->middleware('permission:cuentasMedicas.crearEmail');
        Route::put('cambiarEmail/{id_email_prestador}','cambiarEmail');//->middleware('permission:cuentasMedicas.cambiarEmail');
        Route::post('notificar','notificar');//->middleware('permission:cuentasMedicas.notificar');
    });
});
