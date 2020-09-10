<?php

declare(strict_types=1);

namespace Tests\Unit\Policy;

use App\Enums\Activity\Event;
use App\Models\Activity;
use App\Policies\ActivityPolicy;

class ActivityPolicyTest extends BasePolicyTest
{
    protected string $policyClass = ActivityPolicy::class;

    /** @test */
    public function user_logic_passes(): void
    {
        $this->assertFalse($this->policy->viewAny($this->user));
        $this->assertFalse($this->policy->view($this->user, $this->model));
    }

    /** @test */
    public function admin_logic_passes(): void
    {
        $this->assertTrue($this->policy->viewAny($this->admin));
        $this->assertTrue($this->policy->view($this->admin, $this->model));
    }

    protected function model(): Activity
    {
        activity()->causedBy($this->user)->log(Event::LOGGED_IN);

        return Activity::latest()->first();
    }
}
