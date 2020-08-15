<?php

declare(strict_types=1);

namespace App\Http\Requests\Subscriber;

class StoreRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return true;
    }
}
