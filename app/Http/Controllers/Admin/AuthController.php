<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle the login form data
    public function login(Request $request)
    {
        // Validate the form data
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Attempt to authenticate the user
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // If authentication is successful, redirect to the desired location
            auth()->user()->update(['device_token'=>$request->device_token]);
            return redirect()->intended('/dashboard');
        } else {
            // If authentication fails, redirect back with an error message
            return back()->withErrors(['email' => 'Invalid credentials']);
        }
    }

    // Logout the user
    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
