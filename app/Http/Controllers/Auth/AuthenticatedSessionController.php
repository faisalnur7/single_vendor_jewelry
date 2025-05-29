<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\LoginOTP;
use App\Models\User;
use App\Services\OTPService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class AuthenticatedSessionController extends Controller
{
    protected $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }


    public function initiateLogin(Request $request)
    {
        // Validate inputs
        $request->validate([
            'email' => 'required|exists:users,email',
            'password' => 'required',
        ]);
        
        // Find the user
        $user = User::where('email', $request->email)->first();
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials'], 401);
        }
        
        // Generate OTP
        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(10);
        // Store login attempt with OTP
        $loginAttempt = LoginOTP::create([
                'user_id' => $user->id,
                'phone' => $user->phone,
                'otp' => $otp,
                'expires_at' => $expiresAt
        ]);
        
        // Send OTP
        try {
            $otpService = new OTPService();
            $this->otpService->sendOTP($user->phone, $otp);
            session()->flash('status', 'OTP sent successfully');

            return redirect()->route('login_otp', $loginAttempt->id);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to send OTP: ' . $e->getMessage()], 500);
        }
    }

    public function login_otp(Request $request){
        $data['temp_id'] = $request->temp_id;
        return view('auth.login_otp', $data);
    }

    public function verifyLoginOTP(Request $request)
    {
        $request->validate([
            'temp_id' => 'required',
            'otp' => 'required|numeric',
        ]);
        
        $loginAttempt = LoginOTP::find($request->temp_id);
        
        if (!$loginAttempt) {
            return response()->json(['error' => 'Invalid login attempt'], 400);
        }
        
        if ($loginAttempt->expires_at < now()) {
            return response()->json(['error' => 'OTP has expired'], 400);
        }
        
        if ($loginAttempt->otp != $request->otp) {
            return response()->json(['error' => 'Invalid OTP'], 400);
        }
        
        // OTP is valid, get the user
        $user = User::find($loginAttempt->user_id);
        
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }
        
        // Delete login attempt
        $loginAttempt->delete();
        
        // Log the user in
        Auth::login($user);
        
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
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
