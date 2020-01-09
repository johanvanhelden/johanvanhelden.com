<?php

namespace Tests\Feature\Bootstrapper;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

/**
 * The base bootstrapper test.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
abstract class BaseBootstrapperTest extends TestCase
{
    /**
     * Initialize the test.
     */
    public function setUp() : void
    {
        parent::setUp();

        Permission::query()->delete();
        User::query()->delete();

        $this->setFakeDefaults();
    }

    /**
     * Sets predictable defaults for testing purposes.
     */
    protected function setFakeDefaults()
    {
        Config::set('defaults.users', [
            [
                'on-production' => true,
                'data'          => [
                    'name'     => 'Production User',
                    'email'    => 'at@production.com',
                    'password' => 'password',
                ],
                'roles' => [
                    'admin',
                    'user',
                ],
            ],
            [
                'on-production' => false,
                'data'          => [
                    'name'     => 'Not Production User',
                    'email'    => 'not@production.com',
                    'password' => 'password',
                ],
                'roles' => [
                    'user',
                ],
            ],
        ]);

        Config::set('defaults.roles', [
            'admin' => [
                'test-admin-permission',
            ],
            'user' => [
                'test-user-permission',
            ],
        ]);
    }
}
