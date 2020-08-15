<?php

declare(strict_types=1);

namespace Tests\Unit\Policy;

use App\Policies\ActionEventPolicy;
use Laravel\Nova\Actions\ActionEvent;

class ActionEventPolicyTest extends BasePolicyTest
{
    protected string $policyClass = ActionEventPolicy::class;

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

    protected function model(): ActionEvent
    {
        return ActionEvent::create([
            'batch_id'        => 'test',
            'user_id'         => $this->user->id,
            'name'            => 'test',
            'actionable_type' => ActionEvent::class,
            'actionable_id'   => 2,
            'target_type'     => ActionEvent::class,
            'target_id'       => 2,
            'model_type'      => ActionEvent::class,
            'model_id'        => 2,
            'fields'          => '{}',
            'exception'       => '',
        ]);
    }
}
