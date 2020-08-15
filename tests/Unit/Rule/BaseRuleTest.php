<?php

declare(strict_types=1);

namespace Tests\Unit\Rule;

use Tests\TestCase;

abstract class BaseRuleTest extends TestCase
{
    protected string $ruleClass;

    protected object $rule;

    protected function setUp(): void
    {
        parent::setup();

        $this->rule = $this->app->make($this->ruleClass);
    }

    /** @test */
    public function it_has_a_message(): void
    {
        $this->assertNotEmpty($this->rule->message());
    }
}
