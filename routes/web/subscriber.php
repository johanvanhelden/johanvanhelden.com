<?php

declare(strict_types=1);

use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

Route::controller(SubscriberController::class)
    ->as('subscriber.')
    ->prefix('subscriber')
    ->group(function (): void {
        Route::post('', 'store')->name('store');
    });

Route::controller(SubscriberController::class)
    ->as('subscriber.')
    ->prefix('subscriber/{uuid}/{secret}')
    ->group(function (): void {
        Route::get('confirm', 'confirm')->name('confirm');
        Route::get('edit', 'edit')->name('edit');
        Route::put('', 'update')->name('update');
        Route::delete('', 'destroy')->name('destroy');
    });
