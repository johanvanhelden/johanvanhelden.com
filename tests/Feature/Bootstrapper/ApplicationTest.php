<?php

namespace Tests\Feature\Bootstrapper;

/**
 * Tests to ensure the application bootstrapper is working properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class ApplicationTest extends BaseBootstrapperTest
{
    /** @test */
    public function it_works()
    {
        $this->artisan('bootstrap:application')
            ->expectsOutput('Bootstrapping application...')
            ->expectsOutput('Bootstrapping done')
            ->assertExitCode(0);
    }

    /** @test */
    public function it_bootstraps_users()
    {
        $this->artisan('bootstrap:application')
            ->expectsOutput('Bootstrapping users...')
            ->expectsOutput('Bootstrapping users done');
    }

    /** @test */
    public function it_bootstraps_permissions()
    {
        $this->artisan('bootstrap:application')
            ->expectsOutput('Bootstrapping permissions...')
            ->expectsOutput('Bootstrapping permissions done');
    }
}
