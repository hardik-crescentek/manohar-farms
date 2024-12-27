<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PasswordResetController extends Controller
{
    public function showResetForm()
    {
        return view('auth.passwords.email');
    }

    public function sendResetEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            $token = Str::random(60);
            $user->update(['password_reset_token' => $token]);

            // Send reset email with $token to user's email address
            $user->notify(new ResetPasswordNotification($token));

            return redirect()->route('password.request')->with('status', 'Reset email sent successfully');
        }

        return redirect()->route('password.request')->withErrors(['email' => 'User not found']);
    }

    public function showResetPasswordForm($token)
    {
        $user = User::where('password_reset_token', $token)->first();

        if ($user) {
            return view('auth.passwords.reset', ['token' => $token]);
        }

        abort(404);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->where('password_reset_token', $request->token)->first();

        if ($user) {
            $user->update([
                'password' => Hash::make($request->password),
                'password_reset_token' => null,
            ]);

            // Log the user in or redirect to login page with a success message

            return redirect()->route('login')->with('status', 'Password reset successfully');
        }

        return back()->withErrors(['email' => 'Invalid email or token']);
    }
}
