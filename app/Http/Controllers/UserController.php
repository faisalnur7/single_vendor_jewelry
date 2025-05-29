<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use App\Models\User;
use App\Services\OTPService;
use Carbon\Carbon;

class UserController extends Controller
{
    protected $otpService;

    public function __construct(OTPService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function index()
    {
        $data['users'] = User::paginate(10);
        return view('admin.user.index', $data);
    }

    public function otp(Request $request){
        $request->validate([
            'phone' => 'required|numeric|digits:11|unique:otps,phone',
        ]);

        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(10);

        Otp::updateOrCreate(
            ['phone' => $request->phone],
            ['otp' => $otp, 'expires_at' => $expiresAt]
        );

        $this->otpService->sendOTP($request->phone, $otp);

        session()->flash('status', 'OTP sent successfully');

        return redirect()->route('verify_otp');
    }

    public function verify_otp(Request $request){
        return view('auth.otp');
    }

    public function verify(Request $request){
        $otp = $request->otp;

        $otpObj = Otp::query()->where('otp',$otp)->first();

        if(empty($otpObj)){
            session()->flash('status','OTP Expired!!!');
            return redirect()->back();
        }
        if($otpObj->otp != $otp){
            session()->flash('status','Wrong OTP!!!');
            return redirect()->back();
        }







    }
}
