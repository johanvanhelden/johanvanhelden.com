<?php

declare(strict_types=1);

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'project',
    'as'     => 'project.',
], function (): void {
    Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
});
