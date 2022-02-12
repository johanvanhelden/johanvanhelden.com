<?php

declare(strict_types=1);

namespace Tests;

use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use ReflectionClass;
use Tests\Helpers\User;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    protected UserModel $admin;

    protected UserModel $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::getDefaultAdmin();
        $this->user = User::getDefaultUser();
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
