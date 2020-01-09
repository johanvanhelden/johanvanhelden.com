<?php

namespace App\Http\Requests\User;

/**
 * The set password request.
 */
class SetPasswordRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'token'                 => 'required',
            'email'                 => 'required|email',
            'password'              => 'required|confirmed|strong_password',
            'password_confirmation' => 'required',
        ];
    }
}
