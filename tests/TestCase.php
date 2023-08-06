<?php

declare(strict_types=1);

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use ReflectionClass;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    protected function setUp(): void
    {
        parent::setUp();

        $this->withoutVite();
    }

    protected function invokeMethod(object &$instance, string $methodName, mixed ...$parameters): mixed
    {
        $reflection = new ReflectionClass(get_class($instance));

        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($instance, $parameters);
    }

    protected function getProperty(object &$instance, string $property): mixed
    {
        $reflection = new ReflectionClass(get_class($instance));
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($instance);
    }
}
