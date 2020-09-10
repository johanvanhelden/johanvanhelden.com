<?php

declare(strict_types=1);

namespace Tests\Unit\Listener;

use App\Enums\Activity\Event;
use App\Listeners\Auth\AfterLogout;
use App\Models\Activity;
use App\Models\User;
use Illuminate\Auth\Events\Logout;

class AfterLogoutTest extends BaseListenerTest
{
    protected string $listenerClass = AfterLogout::class;

    protected string $eventClass = Logout::class;

    /** @test */
    public function it_creates_an_audit_for_the_user(): void
    {
        $this->event->user = $this->user;

        $this->listener->handle($this->event);

        $this->assertDatabaseHas('activity_log', [
            'causer_id'    => $this->user->id,
            'causer_type'  => User::class,
            'description'  => Event::LOGGED_OUT,
            'subject_id'   => null,
            'subject_type' => null,
        ]);
    }

    /** @test */
    public function if_no_user_is_given_nothing_happens(): void
    {
        $originalCount = Activity::count();

        $result = $this->listener->handle($this->event);

        $this->assertNull($result);
        $this->assertEquals($originalCount, Activity::count());
    }
}
