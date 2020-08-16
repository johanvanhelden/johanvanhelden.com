<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ConfirmsPasswords;

class ConfirmPasswordController extends Controller
{
    use ConfirmsPasswords;

    /** @var string */
    protected $redirectTo = '/';

    public function __construct()
    {
        $this->middleware('auth');

        $this->redirectTo = url(config('nova.path'));
    }
}
