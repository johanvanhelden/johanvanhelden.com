<?php

declare(strict_types=1);

namespace Tests\Feature\Audit;

use App\Models\Audit;
use App\Models\User;
use OwenIt\Auditing\AuditableObserver;
use Tests\TestCase;

abstract class BaseTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Audit::query()->delete();

        // there is a bug with observers during testing.
        // because we have a custom user observer, the package's observer is overwritten during testing.
        User::observe(AuditableObserver::class);
    }
}
