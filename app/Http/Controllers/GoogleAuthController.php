<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleAuthController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('login')->withErrors([
                'google' => 'Unable to authenticate with Google. Please try again.',
            ]);
        }

        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            $user->update([
                'google_id'            => $googleUser->getId(),
                'google_token'         => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
                'avatar'               => $user->avatar ?? $googleUser->getAvatar(),
            ]);
        } else {
            $nameParts = explode(' ', $googleUser->getName(), 2);

            $user = User::create([
                'first_name'           => $nameParts[0] ?? '',
                'last_name'            => $nameParts[1] ?? '',
                'email'                => $googleUser->getEmail(),
                'google_id'            => $googleUser->getId(),
                'google_token'         => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
                'avatar'               => $googleUser->getAvatar(),
                'email_verified_at'    => now(),
            ]);
        }

        Auth::login($user, remember: true);

        return redirect()->intended(route('dashboard'))->with('success', 'Welcome!');
    }
}
