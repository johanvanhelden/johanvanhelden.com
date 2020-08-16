<?php

declare(strict_types=1);

namespace Tests\Unit\ServiceProvider;

use App\Providers\InertiaServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\MessageBag;
use Illuminate\Support\ViewErrorBag;
use Inertia\Inertia;

class InertiaServiceProviderTest extends BaseServiceProviderTest
{
    protected string $serviceProviderClass = InertiaServiceProvider::class;

    /** @test */
    public function has_the_app_name(): void
    {
        Config::set('app.name', 'Inertia Test');

        $this->assertNull($this->serviceProvider->boot());

        $this->assertEquals('Inertia Test', Inertia::getShared('app.name'));
    }

    /** @test */
    public function has_the_environment(): void
    {
        $this->app['env'] = 'production';

        $this->assertNull($this->serviceProvider->boot());

        $this->assertEquals(false, Inertia::getShared('app.isDev'));
    }

    /** @test */
    public function has_the_errors_from_the_session(): void
    {
        $errorMessage = ['inertia-error' => ['fake-error-value']];

        $viewErrors = new ViewErrorBag();
        $viewErrors->put('default', new MessageBag($errorMessage));

        Session::put('errors', $viewErrors);

        $this->assertNull($this->serviceProvider->boot());

        $errors = call_user_func(Inertia::getShared('errors'));

        $this->assertCount(1, $errors);
        $this->assertEquals($errorMessage, $errors);
    }

    /** @test */
    public function has_the_flash_notifications_from_the_session(): void
    {
        flash('Luke, I am your father', 'info');

        $this->assertNull($this->serviceProvider->boot());

        $notifications = call_user_func(Inertia::getShared('flashNotifications'));

        $this->assertCount(1, $notifications->toArray());
        $this->assertEquals('info', $notifications->first()->level);
        $this->assertEquals('Luke, I am your father', $notifications->first()->message);
    }

    /** @test */
    public function has_the_version_of_the_assets_on_production(): void
    {
        $this->app['env'] = 'production';

        $expectedVersion = md5_file(public_path('mix-manifest.json'));

        $this->assertNull($this->serviceProvider->boot());
        $this->assertEquals($expectedVersion, Inertia::getVersion());
    }
}
