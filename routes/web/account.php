<?php

use App\Http\Controllers\Auth\SetPasswordController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'account',
], function () {
    Auth::routes([
        'register' => false,
        'verify'   => true,
    ]);

    // Custom password set routes
    Route::get('password/set/{token}', [SetPasswordController::class, 'show'])->name('password-set.show');
    Route::post('password/set', [SetPasswordController::class, 'post'])->name('password-set.post');
});
