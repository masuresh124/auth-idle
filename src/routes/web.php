<?php

use Illuminate\Support\Facades\Route;
use Masuresh124\AuthIdle\Http\Controllers\AuthIdleController;


Route::group(['middleware' => 'web'], function () {
    Route::get('check-activity', [AuthIdleController::class, 'checkActivity'])->name('activity.checkActivity');
});
