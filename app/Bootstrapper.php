<?php

namespace App;

/**
 * The custom bootstrapper.
 */
class Bootstrapper extends \Illuminate\Foundation\Application
{
    /**
     * Sets the new public path.
     *
     * @return string
     */
    public function publicPath()
    {
        $path = $this->basePath . DIRECTORY_SEPARATOR . 'public_html';

        return $path;
    }
}
