<?php

declare(strict_types=1);

namespace App\Enums\Activity;

use App\Enums\BaseEnum;

class Event extends BaseEnum
{
    protected static string $translationKey = 'activity.event.';

    const LOGGED_IN = 'logged-in';

    const LOGGED_OUT = 'logged-out';

    const CREATED = 'created';

    const UPDATED = 'updated';

    const DELETED = 'deleted';

    const RESTORED = 'restored';
}
