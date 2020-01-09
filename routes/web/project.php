<?php

use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'project',
    'as'     => 'project.',
], function () {
    Route::get('/{project}', [ProjectController::class, 'show'])->name('show');
});
