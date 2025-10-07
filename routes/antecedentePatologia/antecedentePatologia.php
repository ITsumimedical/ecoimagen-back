<?php

use App\Http\Modules\Patologia\Controllers\PatologiaController;
use Illuminate\Support\Facades\Route;

Route::prefix('patologias', 'throttle:60,1')->group(function ()
{
    Route::controller(PatologiaController::class)->group(function()
    {
        Route::post('crear', 'crear');
    });
});
