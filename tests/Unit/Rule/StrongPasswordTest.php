<?php

namespace Tests\Unit\Rule;

use App\Rules\StrongPassword;
use Tests\TestCase;

/**
 * Tests to ensure the StrongPassword validation rule is working properly.
 *
 * @SuppressWarnings(PHPMD.CamelCaseMethodName)
 */
class StrongPasswordTest extends TestCase
{
    /** @var StrongPassword */
    protected $rule;

    /**
     * Initialize the test.
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->rule = new StrongPassword();
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

    /**
     * @test
     * @dataProvider invalid
     *
     * @param string $string
     */
    public function it_fails($string)
    {
        $this->assertFalse($this->rule->passes('test', $string));
    }

    /**
     * Provides the valid data.
     *
     * @return array
     */
    public function valid()
    {
        return [
            ['Testi0ng!1'],
            ['123Dsti0ng!1'],
            ['123414123123DAsdasdas!!@#!'],
            ['1234567aA!'],
        ];
    }

    /**
     * Provides the invalid data.
     *
     * @return array
     */
    public function invalid()
    {
        return [
            ['123!1'],
            ['asd!1'],
            ['x@#!'],
            ['12312312'],
            ['!@#!@#!@#'],
            ['strong'],
            ['admin123'],
            ['password'],
        ];
    }
}
