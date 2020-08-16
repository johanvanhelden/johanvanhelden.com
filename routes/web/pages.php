<?php

declare(strict_types=1);

use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'page.',
], function (): void {
    Route::get('/', [PagesController::class, 'home'])->name('home');
});
