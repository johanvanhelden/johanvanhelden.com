<?php

declare(strict_types=1);

namespace Tests\Unit\Listener;

use Mockery;
use Mockery\LegacyMockInterface;
use Tests\TestCase;

abstract class BaseListenerTest extends TestCase
{
    protected string $listenerClass;

    protected string $eventClass;

    protected object $listener;

    protected LegacyMockInterface $event;

    protected function setUp(): void
    {
        parent::setup();

        $this->listener = $this->app->make($this->listenerClass);
        $this->event = Mockery::mock($this->eventClass);
    }
}
