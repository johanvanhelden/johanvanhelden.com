<?php

declare(strict_types=1);

namespace Tests\Unit\Policy;

use App\Policies\PermissionPolicy;
use Spatie\Permission\Models\Permission;

class PermissionPolicyTest extends BasePolicyTest
{
    protected string $policyClass = PermissionPolicy::class;

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

        $this->assertFalse($this->policy->create($this->admin));
        $this->assertFalse($this->policy->update($this->admin, $this->model));
        $this->assertFalse($this->policy->delete($this->admin, $this->model));
        $this->assertFalse($this->policy->restore($this->admin, $this->model));
        $this->assertFalse($this->policy->forceDelete($this->admin, $this->model));
    }

    protected function model(): Permission
    {
        return Permission::create(['name' => 'test-permission']);
    }
}
