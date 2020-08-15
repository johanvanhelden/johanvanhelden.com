<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\SetPasswordRequest;
use App\Models\NewPassword;
use App\Models\User;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\Response as HttpFoundationResponse;

class SetPasswordController extends Controller
{
    use ResetsPasswords;

    /** @var string */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('guest');

        $this->redirectTo = url(config('nova.path'));
    }

    public function show(Request $request, string $token): View
    {
        return view('auth.passwords.set', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    public function post(SetPasswordRequest $request): HttpFoundationResponse
    {
        $credentials = $this->credentials($request);

        $user = $this->validateSet($credentials);
        if (empty($user)) {
            return $this->sendResetFailedResponse($request, Password::INVALID_TOKEN);
        }

        $pass = $credentials['password'];
        $this->resetPassword($user, $pass);

        NewPassword::whereToken($credentials['token'])->delete();

        return $this->sendResetResponse($request, 'passwords.set');
    }

    protected function validateSet(array $credentials): ?CanResetPassword
    {
        $user = User::whereEmail($credentials['email'])->first();
        if (empty($user)) {
            return null;
        }

        $tokenRequirements = [
            ['user_id', $user->id],
            ['token', $credentials['token']],
        ];

        $token = NewPassword::where($tokenRequirements)->count();
        if (empty($token)) {
            return null;
        }

        return $user;
    }
}
