<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     */
    public function show()
    {
        return view('profile.index', ['user' => Auth::user()]);
    }

    /**
     * Show the edit profile form.
     */
    public function edit()
    {
        return view('profile.edit', ['user' => Auth::user()]);
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'first_name'        => ['required', 'string', 'max:255'],
            'last_name'         => ['required', 'string', 'max:255'],
            'phone'             => ['nullable', 'string', 'max:20'],
            'date_of_birth'     => ['nullable', 'date'],
            'gender'            => ['nullable', 'string', 'in:Male,Female,Other'],
            'bio'               => ['nullable', 'string', 'max:500'],
            'emergency_contact' => ['nullable', 'string', 'max:20'],
            'address'           => ['nullable', 'string', 'max:500'],
            'avatar'            => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        $user->update($validated);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully!');
    }
}
