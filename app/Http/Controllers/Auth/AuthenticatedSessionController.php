<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Http\Controllers\Traits\MergesGuestCart;
use Illuminate\Http\JsonResponse;

class AuthenticatedSessionController extends Controller
{
    use MergesGuestCart;
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
    public function store(LoginRequest $request): RedirectResponse|JsonResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        // If AJAX, return JSON response
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Login successful',
                'redirect' => route('homepage'),
            ]);
        }

        return redirect()->intended(route('homepage'));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
