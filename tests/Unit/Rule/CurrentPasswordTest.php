<?php

namespace Tests\Unit\Rule;

use App\Models\User;
use App\Rules\CurrentPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

/**
 * Tests to ensure the CurrentPassword validation rule is working properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class CurrentPasswordTest extends TestCase
{
    /** @var CurrentPassword */
    protected $rule;

    /**
     * Initialize the test.
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->rule = new CurrentPassword();
    }

    /** @test */
    public function it_passes()
    {
        $user = new User([
            'id'       => 1,
            'name'     => 'Test User',
            'password' => Hash::make('password'),
        ]);

        Auth::shouldReceive('user')->andReturn($user);

        $this->assertTrue($this->rule->passes('test', 'password'));
    }

    /** @test  */
    public function it_fails()
    {
        $user = new User([
            'id'       => 1,
            'name'     => 'Test User',
            'password' => Hash::make('password'),
        ]);

        Auth::shouldReceive('user')->once()->andReturn($user);

        $this->assertFalse($this->rule->passes('test', 'not-the-password'));
    }
}
