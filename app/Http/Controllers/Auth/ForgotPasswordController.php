<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    use SendsPasswordResetEmails;

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Overrides the stock Laravel method to make it more secure.
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function sendResetLinkFailedResponse(Request $request, string $response): RedirectResponse
    {
        flash(__('auth.message.forgotten_status', ['email' => $request->email]), 'info');

        return back();
    }

    /** Overrides the stock Laravel method to make it more secure. */
    protected function sendResetLinkResponse(Request $request, string $response): RedirectResponse
    {
        return $this->sendResetLinkFailedResponse($request, $response);
    }
}
