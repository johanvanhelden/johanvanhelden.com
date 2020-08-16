<?php

declare(strict_types=1);

namespace App\Http\Requests\Subscriber;

use App\Models\Subscriber;
use Illuminate\Validation\Rule;

class UpdateRequest extends BaseRequest
{
    public function authorize(): bool
    {
        return Subscriber::where('uuid', $this->route('uuid'))->where('secret', $this->route('secret'))
            ->exists();
    }

    public function rules(): array
    {
        $rules = parent::rules();

        $rules['email'] = [
            'required',
            'email',
            Rule::unique('subscribers', 'email')->ignore($this->route('uuid'), 'uuid'),
        ];

        return $rules;
    }
}
