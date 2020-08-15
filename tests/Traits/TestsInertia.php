<?php

declare(strict_types=1);

namespace Tests\Traits;

use Closure;
use Exception;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\App;
use Illuminate\Testing\Assert;
use Illuminate\Testing\TestResponse;

trait TestsInertia
{
    /** @return static */
    public function asInertia()
    {
        $this->withHeader('X-Inertia', 'true');

        return $this;
    }

    /**
     * Register macros that help with testing Inertia.
     *
     * @see https://github.com/inertiajs/pingcrm/blob/master/tests/TestCase.php
     * @see https://github.com/inertiajs/inertia-laravel/pull/105
     */
    public function registerInertiaMacros(): void
    {
        TestResponse::macro('props', function ($key = null) {
            /** @var TestResponse $this */
            $response = $this;

            $data = optional($response->original)->getData();
            if (!$data) {
                throw new Exception('Something is wrong with the response.');
            }

            $rawProps = json_encode($data['page']['props']);
            $arrayProps = json_decode($rawProps, true, 512, JSON_OBJECT_AS_ARRAY);

            if ($key) {
                return Arr::get($arrayProps, $key);
            }

            return $arrayProps;
        });

        TestResponse::macro('assertHasProps', function ($propKeys = []) {
            /** @var TestResponse $this */
            $response = $this;

            $allProps = $response->props();

            foreach ($propKeys as $key) {
                Assert::assertTrue(
                    Arr::has($allProps, $key),
                    "Failed asserting that prop $key exists"
                );
            }

            return $this;
        });

        TestResponse::macro('assertHasProp', function ($key = '') {
            /** @var TestResponse $this */
            $response = $this;

            $response->assertHasProps([$key]);

            return $this;
        });

        TestResponse::macro('assertPropValue', function ($key, $value) {
            /** @var TestResponse $this */
            $response = $this;

            $response->assertHasProp($key);

            $prop = $this->props($key);

            if ($value instanceof AnonymousResourceCollection) {
                $value = $value->resolve();
            }

            if ($value instanceof JsonResource) {
                $value = $value->resolve();
            }

            if ($value instanceof Closure) {
                $value = App::call($value);
            }

            if ($value instanceof Arrayable) {
                $value = $value->toArray();
            }

            Assert::assertSame($value, $prop);

            return $this;
        });

        TestResponse::macro('assertPropCount', function ($key, $count) {
            /** @var TestResponse $this */
            $response = $this;

            $response->assertHasProp($key);
            Assert::assertCount($count, $this->props($key));

            return $this;
        });
    }
}
