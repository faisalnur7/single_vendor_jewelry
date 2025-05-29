<?php

namespace App\Http\Controllers;

use App\Models\PrimeRequest;
use App\Models\User;
use Illuminate\Http\Request;

class PrimeRequestController extends Controller
{
    public function prime_requests(){
        $data['primeRequests'] = PrimeRequest::query()->where('prime_id', auth()->user()->id)->paginate(10);
        return view('prime_user.prime_request.index', $data);
    }
    public function store(Request $request)
    {
        $request->validate([
            'prime_id' => 'required|exists:users,id',
        ]);
    
        $existing = PrimeRequest::where([
            ['requester_id', auth()->id()],
            ['prime_id', $request->prime_id]
        ])->first();
    
        if ($existing) {
            return ['status' => 'You have already requested this user.'];
        }
    
        PrimeRequest::create([
            'requester_id' => auth()->id(),
            'prime_id' => $request->prime_id,
            'status' => 1,
        ]);
        return ['status' => 'Request sent successfully!'];
    }

    public function cancel_request(Request $request){
        $id = $request->request_id;
        $primeRequest = PrimeRequest::query()->findOrFail($id);
        if(!empty($primeRequest)){
            $primeRequest->delete();

            return ['status' => 'Request cancelled successfully.'];
        }
    }

    public function respond(Request $request, $id)
    {
        $primeRequest = PrimeRequest::query()->findOrFail($id);
        if ($primeRequest->prime_id !== auth()->user()->id) {
            abort(403);
        }
        $primeRequest->update(['status' => $request->status]);

        if($primeRequest->status == PrimeRequest::ACCEPTED){
            $user = User::query()->findOrFail($primeRequest->requester_id);
            $user->prime_verified = User::PRIME_VERIFIED_STATUS_VERIFIED;
            $user->save();
        }

        return back()->with('success', 'Response recorded.');
    }

    
}
