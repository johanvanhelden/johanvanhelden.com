<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SetPasswordRequest;
use App\Models\NewPassword;
use App\Models\User;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

/**
 * Set password controller.
 */
class SetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');

        $this->redirectTo = url(config('nova.path'));
    }

    /**
     * Display the password set form.
     *
     * @param Request     $request
     * @param string|null $token
     *
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(Request $request, $token = null)
    {
        if (empty($token)) {
            return redirect()->route('login');
        }

        $email = $request->email;

        return view('auth.passwords.set', compact('token', 'email'));
    }

    /**
     * Set the given user's password.
     *
     * @param SetPasswordRequest $request
     *
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function post(SetPasswordRequest $request)
    {
        $credentials = $this->credentials($request);

        $user = $this->validateSet($credentials);
        if (!$user instanceof User) {
            return $this->sendResetFailedResponse($request, Password::INVALID_TOKEN);
        }

        $pass = $credentials['password'];
        $this->resetPassword($user, $pass);

        NewPassword::whereToken($credentials['token'])->delete();

        return $this->sendResetResponse($request, Password::PASSWORD_RESET);
    }

    /**
     * Validate a password set for the given credentials.
     *
     * @param array $credentials
     *
     * @return \Illuminate\Contracts\Auth\CanResetPassword|string
     */
    protected function validateSet(array $credentials)
    {
        $user = User::whereEmail($credentials['email'])->first();
        if (empty($user)) {
            return Password::INVALID_TOKEN;
        }

        $tokenRequirements = [
            ['user_id', $user->id],
            ['token', $credentials['token']],
        ];

        $token = NewPassword::where($tokenRequirements)->count();
        if (empty($token)) {
            return Password::INVALID_TOKEN;
        }

        return $user;
    }
}
