<?php

declare(strict_types=1);

namespace Tests\Unit\ServiceProvider;

use App\Providers\ValidationServiceProvider;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Validator;

class ValidationServiceProviderTest extends BaseServiceProviderTest
{
    protected string $serviceProviderClass = ValidationServiceProvider::class;

    /** @test */
    public function it_replaces_the_db_string_translation(): void
    {
        Config::set('validation.db_string.length', 2);

        $this->assertNull($this->serviceProvider->boot());

        $validator = Validator::make(['test' => 'teeee'], ['test' => 'db_string']);

        $errors = $validator->errors();

        $this->assertEquals(__('validation.db_string', ['max' => 2]), $errors->first('test'));
    }
}
