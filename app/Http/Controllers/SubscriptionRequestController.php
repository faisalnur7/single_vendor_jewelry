<?php

namespace App\Http\Controllers;

use App\Models\PrimeRequest;
use App\Models\PackageUser;
use App\Models\User;
use Illuminate\Http\Request;

class SubscriptionRequestController extends Controller
{
    public function pending_list(){
        $data['packageUsers'] = PackageUser::with('payment_options','subscription_package','user')->get();
        return view('admin.subscription_requests.subscriptio_request', $data);
    }

    public function respond(Request $request, $id){
        $packageUser = PackageUser::query()->findOrFail($id);

        $packageUser->update(['status' => $request->status]);
        $user = User::query()->findOrFail($packageUser->user_id);

        if($packageUser->status == User::USER_PACKAGE_ACTIVE){
            $user->prime_verified = User::PRIME_VERIFIED_STATUS_COMPLETED;
            $user->save();
        }

        if($packageUser->status == User::USER_PACKAGE_INACTIVE){
            $user->prime_verified = User::PRIME_VERIFIED_STATUS_PACKAGE;
            $user->save();
        }

        return back()->with('success', 'Response recorded.');
    }
}
