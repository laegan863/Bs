<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class SecurityController extends Controller
{
    /**
     * Show the security and settings page.
     */
    public function index()
    {
        return view('security.index', ['user' => Auth::user()]);
    }

    /**
     * Show the edit email form.
     */
    public function editEmail()
    {
        return view('security.email', ['user' => Auth::user()]);
    }

    /**
     * Update the user's email.
     */
    public function updateEmail(Request $request)
    {
        $validated = $request->validate([
            'email'            => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'current_password' => ['required', 'string'],
        ]);

        if (!Hash::check($validated['current_password'], Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'The provided password is incorrect.']);
        }

        Auth::user()->update(['email' => $validated['email']]);

        return redirect()->route('settings.index')->with('success', 'Email updated successfully!');
    }

    /**
     * Show the edit mobile form.
     */
    public function editMobile()
    {
        return view('security.mobile', ['user' => Auth::user()]);
    }

    /**
     * Update the user's mobile number.
     */
    public function updateMobile(Request $request)
    {
        $validated = $request->validate([
            'phone'            => ['required', 'string', 'max:20'],
            'current_password' => ['required', 'string'],
        ]);

        if (!Hash::check($validated['current_password'], Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'The provided password is incorrect.']);
        }

        Auth::user()->update(['phone' => $validated['phone']]);

        return redirect()->route('settings.index')->with('success', 'Mobile number updated successfully!');
    }

    /**
     * Show the change password form.
     */
    public function editPassword()
    {
        return view('security.password');
    }

    /**
     * Update the user's password.
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'string', 'min:8', 'confirmed', Password::defaults()],
        ]);

        if (!Hash::check($validated['current_password'], Auth::user()->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        Auth::user()->update(['password' => Hash::make($validated['password'])]);

        return redirect()->route('settings.index')->with('success', 'Password changed successfully!');
    }

    /**
     * Show connected devices (static).
     */
    public function devices()
    {
        $devices = [
            [
                'name'     => 'Chrome on Windows',
                'icon'     => 'bi-laptop',
                'location' => 'New York, United States',
                'ip'       => '192.168.1.101',
                'last_active' => 'Active now',
                'current'  => true,
            ],
            [
                'name'     => 'Safari on iPhone',
                'icon'     => 'bi-phone',
                'location' => 'New York, United States',
                'ip'       => '192.168.1.102',
                'last_active' => '2 hours ago',
                'current'  => false,
            ],
            [
                'name'     => 'Firefox on MacOS',
                'icon'     => 'bi-laptop',
                'location' => 'Los Angeles, United States',
                'ip'       => '10.0.0.55',
                'last_active' => '3 days ago',
                'current'  => false,
            ],
        ];

        return view('security.devices', ['devices' => $devices]);
    }
}
