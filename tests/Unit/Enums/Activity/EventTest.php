<?php

declare(strict_types=1);

namespace Tests\Unit\Enums\Activity;

use App\Enums\Activity\Event;
use Tests\Unit\Enums\BaseEnumTest;

class EventTest extends BaseEnumTest
{
    protected string $enumClass = Event::class;
}
