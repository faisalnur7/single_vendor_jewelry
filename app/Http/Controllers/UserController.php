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

    public function user_profile(){
        return view('frontend.user.pages.user_profile');
    }

    public function user_order(){

    }
}
