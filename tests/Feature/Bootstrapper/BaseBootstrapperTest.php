<?php

declare(strict_types=1);

namespace Tests\Feature\Bootstrapper;

use App\Models\User;
use Illuminate\Support\Facades\Config;
use Spatie\Permission\Models\Permission;
use Tests\TestCase;

abstract class BaseBootstrapperTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Permission::query()->delete();
        User::query()->delete();

        $this->setFakeDefaults();
    }

    protected function setFakeDefaults(): void
    {
        Config::set('bootstrap.users', [
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

        Config::set('bootstrap.roles', [
            'admin' => [
                'test-admin-permission',
            ],
            'user' => [
                'test-user-permission',
            ],
        ]);
    }
}
