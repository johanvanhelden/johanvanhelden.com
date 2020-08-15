<?php

declare(strict_types=1);

namespace Tests\Unit\Enums\Audit;

use App\Enums\Audit\Event;
use Tests\Unit\Enums\BaseEnumTest;

class EventTest extends BaseEnumTest
{
    protected string $enumClass = Event::class;
}
