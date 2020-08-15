<?php

declare(strict_types=1);

namespace Tests\Unit\ServiceProvider;

use Tests\TestCase;

abstract class BaseServiceProviderTest extends TestCase
{
    protected string $serviceProviderClass;

    protected object $serviceProvider;

    protected function setUp(): void
    {
        parent::setup();

        $this->serviceProvider = new $this->serviceProviderClass($this->app);
    }
}
