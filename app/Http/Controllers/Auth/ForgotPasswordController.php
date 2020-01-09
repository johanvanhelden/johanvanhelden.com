<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

/**
 * Forgot password controller.
 */
class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param Request $request
     * @param string  $response
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * Overrides the stock Laravel method to make it more secure
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return back()->with('status', __('auth.message.forgotten_status', ['email' => $request->email]));
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param Request $request
     * @param string  $response
     *
     * @return \Illuminate\Http\RedirectResponse
     *
     * Overrides the stock Laravel method to make it more secure
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    protected function sendResetLinkResponse(Request $request, $response)
    {
        return back()->with('status', __('auth.message.forgotten_status', ['email' => $request->email]));
    }
}
