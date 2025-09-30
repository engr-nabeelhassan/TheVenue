<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        // Check if the email exists in the database
        $user = User::where('email', $request->input('email'))->first();

        if (!$user) {
            return back()
                ->withInput($request->only('email'))
                ->withErrors(['email' => __('We can\'t find a user with that email address.')]);
        }

        // Create a password reset token and build the reset URL to display inline
        $token = Password::createToken($user);
        $resetUrl = route('password.reset', ['token' => $token]) . '?email=' . urlencode($user->email);

        // Optionally, you could still send the email here if desired
        // Password::sendResetLink($request->only('email'));

        return back()->with([
            'status' => __('Password reset link generated.'),
            'reset_link' => $resetUrl,
        ]);
    }
}
