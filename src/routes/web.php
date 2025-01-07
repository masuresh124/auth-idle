<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' => 'web'], function () {
    // Route::get('agree-terms/show', [AgreeTermsController::class, 'show'])->name('agree-terms.show');
    // Route::post('agree-terms/store', [AgreeTermsController::class, 'store'])->name('agree-terms.store');
});
