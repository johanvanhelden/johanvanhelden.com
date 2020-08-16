<?php

declare(strict_types=1);

namespace App\Enums\Audit;

use App\Enums\BaseEnum;

class Event extends BaseEnum
{
    protected static string $translationKey = 'audit.event.';

    /** @var string */
    const LOGGED_IN = 'logged-in';

    /** @var string */
    const LOGGED_OUT = 'logged-out';

    /** @var string */
    const CREATED = 'created';

    /** @var string */
    const UPDATED = 'updated';

    /** @var string */
    const DELETED = 'deleted';

    /** @var string */
    const RESTORED = 'restored';
}
