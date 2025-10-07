<?php

use App\Http\Modules\Historia\AntecedentesHospitalarios\Controllers\AntecedentesHospitalariosController;
use Illuminate\Support\Facades\Route;

Route::prefix('antecedentes-hospitalarios', 'throttle:60,1')->group(function ()
{
    Route::controller(AntecedentesHospitalariosController::class)->group(function()
    {
        Route::post('guardar', 'guardar');
        Route::post('listarHospitalario', 'listarHospitalario');
        Route::delete('eliminar/{id}', 'eliminar');



    });
});
