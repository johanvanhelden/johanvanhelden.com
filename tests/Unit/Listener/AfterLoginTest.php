<?php

declare(strict_types=1);

namespace Tests\Unit\Listener;

use App\Enums\Audit\Event;
use App\Listeners\Auth\AfterLogin;
use App\Models\Audit;
use App\Models\User;
use Illuminate\Auth\Events\Login;
use OwenIt\Auditing\AuditableObserver;

class AfterLoginTest extends BaseListenerTest
{
    protected string $listenerClass = AfterLogin::class;

    protected string $eventClass = Login::class;

    /** @test */
    public function it_creates_an_audit_for_the_user(): void
    {
        User::observe(AuditableObserver::class);

        $this->event->user = $this->user;

        $this->listener->handle($this->event);

        $this->assertDatabaseHas('audits', [
            'user_id'        => $this->user->id,
            'event'          => Event::LOGGED_IN,
            'auditable_type' => User::class,
            'auditable_id'   => $this->user->id,
        ]);
    }

    /** @test */
    public function if_no_user_is_given_nothing_happens(): void
    {
        $originalAuditCount = Audit::count();

        $result = $this->listener->handle($this->event);

        $this->assertNull($result);
        $this->assertEquals($originalAuditCount, Audit::count());
    }
}
