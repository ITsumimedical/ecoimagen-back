<?php

use App\Http\Modules\LogRegistroRipsSumi\Controllers\LogRegistroRipsSumiController;
use Illuminate\Support\Facades\Route;

Route::prefix('logs-registros-rips-sumi')->group(function () {
    Route::post('listar', [LogRegistroRipsSumiController::class, 'listarLogs']);
});
