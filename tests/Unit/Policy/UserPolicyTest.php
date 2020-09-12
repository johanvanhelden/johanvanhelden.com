<?php

declare(strict_types=1);

namespace Tests\Unit\Policy;

use App\Models\User;
use App\Policies\UserPolicy;

class UserPolicyTest extends BasePolicyTest
{
    protected string $policyClass = UserPolicy::class;

    /** @test */
    public function user_logic_passes(): void
    {
        $this->assertFalse($this->policy->viewAny($this->user));
        $this->assertFalse($this->policy->view($this->user, $this->model));
        $this->assertFalse($this->policy->create($this->user));
        $this->assertFalse($this->policy->update($this->user, $this->model));
        $this->assertFalse($this->policy->delete($this->user, $this->model));
        $this->assertFalse($this->policy->restore($this->user, $this->model));
        $this->assertFalse($this->policy->forceDelete($this->user, $this->model));
    }

    /** @test */
    public function admin_logic_passes(): void
    {
        $this->assertTrue($this->policy->viewAny($this->admin));
        $this->assertTrue($this->policy->view($this->admin, $this->model));
        $this->assertTrue($this->policy->create($this->admin));
        $this->assertTrue($this->policy->update($this->admin, $this->model));
        $this->assertTrue($this->policy->delete($this->admin, $this->model));
        $this->assertTrue($this->policy->restore($this->admin, $this->model));
        $this->assertTrue($this->policy->forceDelete($this->admin, $this->model));
    }

    protected function model(): User
    {
        return User::factory()->create();
    }
}
