<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * Register controller.
 */
class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers {
        register as defaultRegister;
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /** @var UserService */
    protected $userService;

    /**
     * Create a new controller instance.
     *
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->redirectTo = url(config('nova.path'));
        $this->userService = $userService;

        $this->middleware('guest');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Response
     *
     * Overrides the stock Laravel method in order to only validate the email for uniqueness once the captcha passes
     */
    public function register(Request $request)
    {
        $this->validator($request->all(), false)->validate();

        return $this->defaultRegister($request);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param array $data
     * @param bool  $uniqueUser
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data, $uniqueUser = true)
    {
        $uniqueRule = '|unique:users';
        if (!$uniqueUser) {
            $uniqueRule = '';
        }

        $validator = Validator::make($data, [
            'name'     => 'required|string|db_string',
            'email'    => 'required|string|email|db_string' . $uniqueRule,
            'password' => 'required|string|strong_password|confirmed',

            'g-recaptcha-response' => 'required|captcha',
        ]);

        $validator->after(function ($validator) {
            $validator->errors()->add('email', __('validation.signup_not_allowed'));
        });

        return $validator;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param array $data
     *
     * @return User
     */
    protected function create(array $data)
    {
        return $this->userService->create($data);
    }
}
