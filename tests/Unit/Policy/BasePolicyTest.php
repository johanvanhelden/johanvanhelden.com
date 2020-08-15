<?php

declare(strict_types=1);

namespace Tests\Unit\Policy;

use Illuminate\Database\Eloquent\Model;
use Tests\TestCase;

abstract class BasePolicyTest extends TestCase
{
    protected string $policyClass;

    protected object $policy;

    protected Model $model;

    protected function setUp(): void
    {
        parent::setup();

        $this->policy = $this->app->make($this->policyClass);
        $this->model = $this->model();
    }

    abstract protected function model(): Model;
}
