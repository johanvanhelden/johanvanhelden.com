<?php

declare(strict_types=1);

namespace App;

class Bootstrapper extends \Illuminate\Foundation\Application
{
    /** Adds support for a `public_html` folder instead of the default `public`. */
    public function publicPath(): string
    {
        $path = $this->basePath . DIRECTORY_SEPARATOR . 'public_html';

        return $path;
    }
}
