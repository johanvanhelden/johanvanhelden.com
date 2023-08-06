<?php

declare(strict_types=1);

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::controller(ProjectController::class)
    ->as('project.')
    ->prefix('project')
    ->group(function (): void {
        Route::get('/{slug}', 'show')->name('show');
    });
