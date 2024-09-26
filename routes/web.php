<?php

declare(strict_types=1);

use Illuminate\Support\Facades\File;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

foreach (File::files(__DIR__ . '/web') as $file) {
    require $file;
}
