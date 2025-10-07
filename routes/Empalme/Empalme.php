<?php

use Illuminate\Support\Facades\Route;
use App\Http\Modules\Empalme\Controllers\EmpalmeController;

Route::prefix('empalme', 'throttle:60,1')->group(function () {
    Route::controller(EmpalmeController::class)->group(function () {
        Route::get('listarFerrocarriles', 'listarFerrocarriles');  //->middleware('permission:empalme.listarFerrocarriles');
        Route::get('existeEmpalme/{cedula}', 'existeEmpalme');
        Route::post('listarporEntidades/{cedula}', 'listarporEntidades');  //->middleware('permission:empalme.listarFerrocarriles');
        Route::post('crear', 'crear');  //->middleware('permission:empalme.listarFerrocarriles');

    });
});
