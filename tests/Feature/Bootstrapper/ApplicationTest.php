<?php

declare(strict_types=1);

namespace Tests\Feature\Bootstrapper;

class ApplicationTest extends BaseBootstrapperTest
{
    /** @test */
    public function it_works(): void
    {
        $this->artisan('bootstrap:application')

            ->expectsOutput('Bootstrapping application...')
            ->expectsOutput('Bootstrapping done')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_bootstraps_users(): void
    {
        $this->artisan('bootstrap:application')

            ->expectsOutput('Bootstrapping users...')
            ->expectsOutput('Bootstrapping users done');
    }

    /** @test */
    public function it_bootstraps_permissions(): void
    {
        $this->artisan('bootstrap:application')

            ->expectsOutput('Bootstrapping permissions...')
            ->expectsOutput('Bootstrapping permissions done');
    }
}
