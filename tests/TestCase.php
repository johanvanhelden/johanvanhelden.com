<?php

declare(strict_types=1);

namespace Tests;

use App\Models\User as UserModel;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use ReflectionClass;
use Tests\Helpers\User;
use Tests\Traits\TestsInertia;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions, TestsInertia;

    protected UserModel $admin;

    protected UserModel $user;

    protected function setUp(): void
    {
        parent::setUp();

        $this->admin = User::getDefaultAdmin();
        $this->user = User::getDefaultUser();

        $this->registerInertiaMacros();
    }

    /**
     * @param mixed ...$parameters
     *
     * @return mixed
     */
    protected function invokeMethod(object &$instance, string $methodName, ...$parameters)
    {
        $reflection = new ReflectionClass(get_class($instance));

        $method = $reflection->getMethod($methodName);
        $method->setAccessible(true);

        return $method->invokeArgs($instance, $parameters);
    }

    /** @return mixed */
    protected function getProperty(object &$instance, string $property)
    {
        $reflection = new ReflectionClass(get_class($instance));
        $property = $reflection->getProperty($property);
        $property->setAccessible(true);

        return $property->getValue($instance);
    }
}
