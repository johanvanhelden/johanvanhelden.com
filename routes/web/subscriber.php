<?php

declare(strict_types=1);

use App\Http\Controllers\SubscriberController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'subscriber',
    'as'     => 'subscriber.',
], function (): void {
    Route::post('', [SubscriberController::class, 'store'])->name('store');
});

Route::group([
    'prefix' => 'subscriber/{uuid}/{secret}',
    'as'     => 'subscriber.',
], function (): void {
    Route::get('confirm', [SubscriberController::class, 'confirm'])->name('confirm');
    Route::get('edit', [SubscriberController::class, 'edit'])->name('edit');
    Route::put('', [SubscriberController::class, 'update'])->name('update');
    Route::delete('', [SubscriberController::class, 'destroy'])->name('destroy');
});
