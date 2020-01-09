<?php

namespace Tests;

use Anhskohbo\NoCaptcha\Facades\NoCaptcha;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Illuminate\Foundation\Testing\TestResponse;
use Illuminate\Support\Arr;
use PHPUnit\Framework\Assert;

/**
 * General test case.
 */
abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, DatabaseTransactions;

    /**
     * Set up the test suite.
     */
    public function setUp() : void
    {
        parent::setUp();

        $this->registerInertiaMacros();
    }

    /**
     * Ignores the captcha.
     *
     * @param string $name
     *
     * @return $this
     */
    protected function ignoreCaptcha($name = 'g-recaptcha-response')
    {
        // prevent validation error on captcha
        NoCaptcha::shouldReceive('verifyResponse')
            ->andReturn(true);

        // provide hidden input for the 'required' validation
        NoCaptcha::shouldReceive('display')
            ->zeroOrMoreTimes()
            ->andReturn('<input type="hidden" name="' . $name . '" value="1" />');

        return $this;
    }

    /**
     * Register macros that help with testing Inertia.
     *
     * Source: https://github.com/inertiajs/pingcrm/blob/master/tests/TestCase.php
     */
    public function registerInertiaMacros()
    {
        TestResponse::macro('props', function ($key = null) {
            $props = json_decode(json_encode($this->original->getData()['page']['props']), JSON_OBJECT_AS_ARRAY);
            if ($key) {
                return Arr::get($props, $key);
            }

            return $props;
        });

        TestResponse::macro('assertHasProp', function ($key) {
            Assert::assertTrue(Arr::has($this->props(), $key));

            return $this;
        });

        TestResponse::macro('assertPropValue', function ($key, $value) {
            $this->assertHasProp($key);
            if (is_callable($value)) {
                $value($this->props($key));
            } else {
                Assert::assertEquals($this->props($key), $value);
            }

            return $this;
        });

        TestResponse::macro('assertPropCount', function ($key, $count) {
            $this->assertHasProp($key);
            Assert::assertCount($count, $this->props($key));

            return $this;
        });

        TestResponse::macro('assertPropResourceCollection', function ($key, $resourceCollection) {
            $this->assertHasProp($key);

            $resourceContent = $resourceCollection->response()->getContent();

            Assert::assertSame($resourceContent, json_encode($this->props($key)));

            return $this;
        });
    }
}
