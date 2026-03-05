<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Jenssegers\Agent\Agent;

class SecurityController extends Controller
{
    public function index()
    {
        return view('security.index', ['user' => Auth::user()]);
    }

    public function editEmail()
    {
        return view('security.email', ['user' => Auth::user()]);
    }

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

    public function editMobile()
    {
        return view('security.mobile', ['user' => Auth::user()]);
    }

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

    public function editPassword()
    {
        return view('security.password');
    }

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

    public function devices(Request $request)
    {
        $currentSessionId = session()->getId();

        $sessions = DB::table('sessions')
            ->where('user_id', Auth::id())
            ->orderByDesc('last_activity')
            ->get();

        $agent = new Agent();

        $devices = $sessions->map(function ($session) use ($agent, $currentSessionId) {
            $agent->setUserAgent($session->user_agent);

            $browser  = $agent->browser() ?: 'Unknown Browser';
            $platform = $agent->platform() ?: 'Unknown OS';
            $platformVersion = $agent->version($platform);
            $isCurrent = $session->id === $currentSessionId;

            if ($agent->isPhone()) {
                $icon = 'bi-phone';
            } elseif ($agent->isTablet()) {
                $icon = 'bi-tablet';
            } else {
                $icon = 'bi-laptop';
            }

            $deviceName = $platform . ($platformVersion ? ' ' . $platformVersion : '');

            $lastActive = Carbon::createFromTimestamp($session->last_activity);

            return [
                'id'          => $session->id,
                'name'        => $deviceName,
                'browser'     => $browser,
                'icon'        => $icon,
                'ip'          => $session->ip_address ?? 'Unknown',
                'last_active' => $isCurrent ? 'Active now' : $lastActive->diffForHumans(),
                'last_active_date' => $lastActive->format('M d, Y \a\t g:ia'),
                'current'     => $isCurrent,
            ];
        });

        $deviceCount = $devices->count();

        return view('security.devices', compact('devices', 'deviceCount'));
    }

    public function destroySession(Request $request, string $sessionId)
    {
        if ($sessionId === session()->getId()) {
            return back()->with('error', 'You cannot sign out of your current session here. Use the logout button instead.');
        }

        DB::table('sessions')
            ->where('id', $sessionId)
            ->where('user_id', Auth::id())
            ->delete();

        return back()->with('success', 'Device signed out successfully.');
    }
}
