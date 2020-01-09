<?php

namespace App\Http\Requests\Subscriber;

use App\Models\Subscriber;
use Illuminate\Validation\Rule;

/**
 * The update request.
 */
class UpdateRequest extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Subscriber::where('uuid', $this->route('uuid'))->where('secret', $this->route('secret'))
            ->exists();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
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
