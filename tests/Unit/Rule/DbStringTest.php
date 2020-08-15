<?php

declare(strict_types=1);

namespace Tests\Unit\Rule;

use App\Rules\DbString;
use Illuminate\Support\Str;

class DbStringTest extends BaseRuleTest
{
    protected string $ruleClass = DbString::class;

    /**
     * @test
     *
     * @dataProvider valid
     */
    public function it_passes(string $string): void
    {
        $this->assertTrue($this->rule->passes('test', $string));
    }

    /** @test */
    public function it_fails(): void
    {
        $longString = Str::random(config('validation.db_string.length') + 1);

        $this->assertFalse($this->rule->passes('test', $longString));
    }

    public function valid(): array
    {
        return [
            ['123'],
            ['asd'],
            [''],
        ];
    }
}
