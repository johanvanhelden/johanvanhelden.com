<?php

declare(strict_types=1);

namespace Tests\Unit\Policy;

use App\Policies\RolePolicy;
use Spatie\Permission\Models\Role;

class RolePolicyTest extends BasePolicyTest
{
    protected string $policyClass = RolePolicy::class;

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

    /** @test */
    public function the_admin_can_not_interact_with_the_default_roles(): void
    {
        $defaultRole = Role::where('name', 'admin')->first();

        $this->assertFalse($this->policy->update($this->admin, $defaultRole));
        $this->assertFalse($this->policy->delete($this->admin, $defaultRole));
        $this->assertFalse($this->policy->restore($this->admin, $defaultRole));
        $this->assertFalse($this->policy->forceDelete($this->admin, $defaultRole));
    }

    protected function model(): Role
    {
        return Role::create(['name' => 'test-permission']);
    }
}
