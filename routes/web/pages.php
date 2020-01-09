<?php

use App\Http\Controllers\PagesController;
use Illuminate\Support\Facades\Route;

Route::group([
    'as' => 'page.',
], function () {
    Route::get('/', [PagesController::class, 'home'])->name('home');
});
