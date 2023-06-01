<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\Customer;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $data =  Customer::where('email', $request->email)->first();
        if (!empty($data)) {
            if ($data->status == false) {
                return redirect()->back()->with('error', 'You are now disable. Please contact with admin');
            }
        }

        $request->authenticate();

        $request->session()->regenerate();
        if (Auth::guard('admin')->check()) {
            return redirect()->route('users.index');
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request)
    {
        if (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }

        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        }

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
