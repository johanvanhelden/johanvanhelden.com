<?php

declare(strict_types=1);

namespace Tests\Unit\Rule;

use App\Rules\StrongPassword;

class StrongPasswordTest extends BaseRuleTest
{
    protected string $ruleClass = StrongPassword::class;

    /**
     * @test
     *
     * @dataProvider valid
     */
    public function it_passes(string $string): void
    {
        $this->assertTrue($this->rule->passes('test', $string));
    }

    /**
     * @test
     *
     * @dataProvider invalid
     */
    public function it_fails(string $string): void
    {
        $this->assertFalse($this->rule->passes('test', $string));
    }

    public function valid(): array
    {
        return [
            ['Testi0ng!1'],
            ['123Dsti0ng!1'],
            ['123414123123DAsdasdas!!@#!'],
            ['1234567aA!'],
        ];
    }

    public function invalid(): array
    {
        return [
            ['short'],
            ['nouppercase'],
            ['NOLOWERCASE'],
            ['noDigits'],
            ['n0Sp3cialChars'],
        ];
    }
}
