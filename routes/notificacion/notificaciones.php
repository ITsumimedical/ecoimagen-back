<?php

use App\Http\Modules\Notificacion\Controllers\NotificacionControllers;
use Illuminate\Support\Facades\Route;

Route::prefix('notificaciones', 'throttle:60,1')->group(function () {
    Route::controller(NotificacionControllers::class)->group(function () {
        Route::get('listar', 'listar');
        Route::delete('eliminar-notificacion/{id}/{redis_id}', 'eliminarNotificacion');
    });
});
