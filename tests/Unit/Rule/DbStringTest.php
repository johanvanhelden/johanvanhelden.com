<?php

namespace Tests\Unit\Rule;

use App\Rules\DbString;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * Tests to ensure the DbString validation rule is working properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class DbStringTest extends TestCase
{
    /** @var DbString */
    protected $rule;

    /**
     * Initialize the test.
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->rule = new DbString();
    }

    /**
     * @test
     * @dataProvider valid
     *
     * @param string $string
     */
    public function it_passes($string)
    {
        $this->assertTrue($this->rule->passes('test', $string));
    }

    /** @test */
    public function it_fails()
    {
        $longString = Str::random(config('validation.db_string.length') + 1);

        $this->assertFalse($this->rule->passes('test', $longString));
    }

    /**
     * Provides the valid data.
     *
     * @return array
     */
    public function valid()
    {
        return [
            ['123'],
            ['asd'],
            [''],
        ];
    }
}
