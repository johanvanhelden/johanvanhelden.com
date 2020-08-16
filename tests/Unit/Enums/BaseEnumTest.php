<?php

declare(strict_types=1);

namespace Tests\Unit\Enums;

use App\Enums\BaseEnum;
use Tests\TestCase;

abstract class BaseEnumTest extends TestCase
{
    protected string $enumClass;

    protected BaseEnum $enum;

    protected function setUp(): void
    {
        parent::setUp();

        $this->enum = $this->app->make($this->enumClass);
    }

    /** @test */
    public function the_translations_exist(): void
    {
        foreach ($this->enum::toArray() as $constant) {
            $key = $this->getProperty($this->enum, 'translationKey') . $constant;

            $this->assertFalse($key === trans($key), 'The translation for "' . $key . '" is missing.');
        }
    }

    /** @test */
    public function it_has_a_list_of_translated_options(): void
    {
        $select = $this->enum::asSelect();
        foreach ($this->enum::toArray() as $constant) {
            $this->assertTrue(isset($select[$constant]));

            $this->assertEquals(
                trans($this->getProperty($this->enum, 'translationKey') . $constant),
                $select[$constant]
            );
        }
    }

    /** @test */
    public function it_can_display_the_value(): void
    {
        foreach ($this->enum->toArray() as $constant) {
            $this->assertEquals(
                trans($this->getProperty($this->enum, 'translationKey') . $constant),
                $this->enum::display($constant)
            );
        }
    }
}
