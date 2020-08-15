<?php

declare(strict_types=1);

namespace Tests\Unit\Policy;

use App\Models\Audit;
use App\Policies\AuditPolicy;

class AuditPolicyTest extends BasePolicyTest
{
    protected string $policyClass = AuditPolicy::class;

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

    protected function model(): Audit
    {
        Audit::createForLogin($this->user);

        return Audit::latest()->first();
    }
}
