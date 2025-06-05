<?php

use Illuminate\Support\Facades\Route;
use ZPlus\ViPOS\Http\Controllers\ViPOSController;

Route::group(['middleware' => ['admin'], 'prefix' => config('app.admin_url') . '/vipos'], function () {
    Route::get('/', [ViPOSController::class, 'index'])->name('admin.vipos.index');
    Route::post('/session/start', [ViPOSController::class, 'startSession'])->name('admin.vipos.session.start');
    Route::post('/session/close', [ViPOSController::class, 'closeSession'])->name('admin.vipos.session.close');
    Route::get('/session/status', [ViPOSController::class, 'getSessionStatus'])->name('admin.vipos.session.status');
});