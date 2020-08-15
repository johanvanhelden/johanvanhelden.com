<?php

declare(strict_types=1);

namespace Tests\Unit\Rule;

use App\Models\User;
use App\Rules\CurrentPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CurrentPasswordTest extends BaseRuleTest
{
    protected string $ruleClass = CurrentPassword::class;

    /** @test */
    public function it_passes_if_the_password_matches(): void
    {
        $user = new User([
            'id'       => 1,
            'name'     => 'Test User',
            'password' => Hash::make('password'),
        ]);

        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->andReturn($user);

        $this->assertTrue($this->rule->passes('test', 'password'));
    }

    /** @test */
    public function it_passes_if_the_password_is_empty(): void
    {
        $this->assertTrue($this->rule->passes('test', ''));
    }

    /** @test */
    public function it_fails_if_there_is_no_current_user(): void
    {
        Auth::shouldReceive('check')->andReturn(false);

        $this->assertFalse($this->rule->passes('test', 'password'));
    }

    /** @test  */
    public function it_fails_if_the_password_is_incorrect(): void
    {
        $user = new User([
            'id'       => 1,
            'name'     => 'Test User',
            'password' => Hash::make('password'),
        ]);

        Auth::shouldReceive('check')->andReturn(true);
        Auth::shouldReceive('user')->once()->andReturn($user);

        $this->assertFalse($this->rule->passes('test', 'not-the-password'));
    }
}
