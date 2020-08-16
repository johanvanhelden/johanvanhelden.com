<?php

declare(strict_types=1);

namespace App\Http\Requests\Subscriber;

use Illuminate\Foundation\Http\FormRequest;

class BaseRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'  => 'required|db_string',
            'email' => 'required|email',
        ];
    }

    public function attributes(): array
    {
        return __('subscriber.attributes');
    }
}
