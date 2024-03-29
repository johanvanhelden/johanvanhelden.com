<?php

declare(strict_types=1);

namespace Tests\Unit\Exception\Handler;

use App\Exceptions\Handler;
use Exception;
use Illuminate\Support\Facades\App;
use Mockery\MockInterface;
use stdClass;
use Tests\TestCase;

class SentryTest extends TestCase
{
    private Handler $handler;

    private Exception $exception;

    protected function setUp(): void
    {
        parent::setUp();

        $this->handler = $this->app->make(Handler::class);
        $this->exception = new Exception('This is a test!');
    }

    /** @test */
    public function will_skip_sentry_on_local(): void
    {
        App::shouldReceive('environment')->twice()->andReturn(true);

        $this->handler->register();
        $this->handler->report($this->exception);
    }

    /** @test */
    public function will_not_trigger_sentry_if_not_bound(): void
    {
        App::shouldReceive('environment')->twice()->andReturn(false);
        App::shouldReceive('bound')->twice()->andReturn(false);

        $this->handler->register();
        $this->handler->report($this->exception);
    }

    /** @test */
    public function will_trigger_sentry_on_production(): void
    {
        $sentry = $this->mock(stdClass::class, function (MockInterface $mock): void {
            $mock->shouldReceive('captureException')->andReturn(true);
        });

        App::shouldReceive('environment')->twice()->andReturn(false);
        App::shouldReceive('bound')->withArgs(['sentry'])->twice()->andReturn(true);
        App::shouldReceive('get')->twice()->andReturn($sentry);

        $this->handler->register();
        $this->handler->report($this->exception);
    }
}
