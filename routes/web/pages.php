<?php

declare(strict_types=1);

use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::controller(PagesController::class)
    ->as('page.')
    ->group(function (): void {
        Route::get('/', 'home')->name('home');
    });
