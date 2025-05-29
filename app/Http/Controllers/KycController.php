<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kyc;
use App\Models\Division;
use App\Models\District;
use App\Models\PoliceStation;
use App\Models\PostOffice;
use App\Models\SubscriptionPackage;
use App\Models\PrimeRequest;
use App\Models\NomineeInfo;
use App\Models\User;
use App\Models\PackageUser;

use Carbon\Carbon;

class KycController extends Controller
{
    /**
     * Display a listing of the KYC records.
     */
    public function index()
    {
        $data['kycs'] = Kyc::all();
        $data['divisions'] = Division::all();
        $data['districts'] = District::all();
        $data['policeStations'] = PoliceStation::all();
        $data['postOffices'] = PostOffice::all();
        $data['UserTypes'] = User::USER_TYPES;
        $data['AffiliateTypes'] = User::AFFILIATE_TYPES;
        $data['affiliates'] = User::query()->where('user_type',User::CUSTOMER)->where('user_affiliate_type', '!=',null)->get();
        $data['kyc'] = auth()->user()->kyc;
        return view('user.kyc.create', $data);
    }

    /**
     * Show the form for creating a new KYC record.
     */
    public function create()
    {
        $data['kycs'] = Kyc::all();
        $data['divisions'] = Division::all();
        $data['districts'] = District::all();
        $data['policeStations'] = PoliceStation::all();
        $data['postOffices'] = PostOffice::all();
        $data['UserTypes'] = User::USER_TYPES;
        $data['AffiliateTypes'] = User::AFFILIATE_TYPES;
        $data['affiliates'] = User::query()->where('user_type',User::CUSTOMER)->where('user_affiliate_type', '!=',null)->get();

        return view('user.kyc.create',$data);
    }

    /**
     * Store a newly created KYC record in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            // 'reference_user' => 'required|string|max:255',
            // 'affiliate_id' => 'nullable|string|max:255',
            // 'doc_type' => 'required|integer',
            // 'document_file' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            // 'father' => 'nullable|string|max:255',
            // 'mother' => 'nullable|string|max:255',
            // 'dob' => 'nullable|date',
            // 'referer_id' => 'nullable',
            // 'permanent_division_id' => 'nullable|exists:divisions,id',
            // 'permanent_district_id' => 'nullable|exists:districts,id',
            // 'permanent_police_station_id' => 'nullable|exists:police_stations,id',
            // 'permanent_post_office_id' => 'nullable|exists:post_offices,id',
            // 'permanent_post_code' => 'nullable|string|max:10',
            // 'present_division_id' => 'nullable|exists:divisions,id',
            // 'present_district_id' => 'nullable|exists:districts,id',
            // 'present_police_station_id' => 'nullable|exists:police_stations,id',
            // 'present_post_office_id' => 'nullable|exists:post_offices,id',
            // 'present_post_code' => 'nullable|string|max:10',
            // 'account_type' => 'nullable|integer',
            // 'account_number' => 'nullable|string|max:50',
        ]);

        $kyc = Kyc::query()->where('user_id',auth()->user()->id)->first();

        if($request->second_step){
            $kyc->permanent_division_id = $request->permanent_division_id;
            $kyc->permanent_district_id = $request->permanent_district_id;
            $kyc->permanent_police_station_id = $request->permanent_police_station_id;
            $kyc->permanent_post_office_id = $request->permanent_post_office_id;
            $kyc->permanent_address = $request->permanent_address;

            if($request->sameAddress){
                $kyc->present_division_id = $request->permanent_division_id;
                $kyc->present_district_id = $request->permanent_district_id;
                $kyc->present_police_station_id = $request->permanent_police_station_id;
                $kyc->present_post_office_id = $request->permanent_post_office_id;
                $kyc->present_address = $request->permanent_address;

                $kyc->is_same_address = 1;
            }else{
                $kyc->present_division_id = $request->present_division_id;
                $kyc->present_district_id = $request->present_district_id;
                $kyc->present_police_station_id = $request->present_police_station_id;
                $kyc->present_post_office_id = $request->present_post_office_id;
                $kyc->is_same_address = 0;
            }
            
            $kyc->save();

            return $kyc;
        }

        if($request->final_step){
            $kyc->account_type = $request->account_type;
            $kyc->account_number = $request->account_number;

            $kyc->save();

            return $kyc;
        }

        $data = $request->except('document_file');
        $data['user_id'] = auth()->user()->id;
        
        if($request->has('document_file') && $request->document_file !== 'undefined') {
            $filename = Date('Y') . "_" . substr(md5(time()), 0, 6) . "." . $request->document_file->getClientOriginalExtension();
            $request->document_file->move(base_path('public/kyc/document_file/'), $filename);
            $data["document_file"] = $filename;
        }


        if(!empty($kyc)){
            $kyc->update($data);
        }else{
            Kyc::create($data);
        }

        if(!empty($request->referer_id)){
            $user = auth()->user();
            $user->reference_user_id = $request->referer_id;
            $user->user_affiliate_type = User::GENERAL;
            $user->save();
        }

        return redirect()->route('kyc.list')->with('success', 'KYC record created successfully.');
    }

    public function prime(){
        $data['kycs'] = Kyc::all();
        $data['divisions'] = Division::all();
        $data['districts'] = District::all();
        $data['policeStations'] = PoliceStation::all();
        $data['postOffices'] = PostOffice::all();
        $data['UserTypes'] = User::USER_TYPES;
        $data['AffiliateTypes'] = User::AFFILIATE_TYPES;
        $data['primeStatus'] = auth()->user()->prime_verified;
        $data['affiliates'] = User::query()->where('user_type',User::CUSTOMER)->where('user_affiliate_type', User::PRIME)->get();
        $data['kyc'] = auth()->user()->kyc;
        $data['packages'] = SubscriptionPackage::all();

        $data['primeRequest'] = PrimeRequest::query()->where('requester_id', auth()->user()->id)->where('status', PrimeRequest::PENDING)->first();
        
        return view('user.kyc.prime_affiliate_form',$data);
    }

    public function prime_store(Request $request){

        $request->validate([
            'affiliate_id'      => 'required|string',
            'reference_user_id' => 'nullable|exists:users,id',
            'postal_code'       => 'nullable|string|max:20',
            'transaction_number'=> 'nullable|string|max:100',
            'mobile_number'     => 'nullable|string|max:100',
            'payment_type'      => 'nullable|string',
            'nominee_name'      => 'nullable|string|max:255',
            'nominee_nid'       => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'relation'          => 'nullable|string|max:100',
            'package'           => 'nullable|string',
        ]);

        $kyc = Kyc::query()->where('user_id',auth()->user()->id)->first();

        $data = $request->except('nominee_nid');
        $data['user_id'] = auth()->user()->id;
        
        if($request->has('nominee_nid') && $request->nominee_nid !== 'undefined') {
            $filename = Date('Y') . "_" . substr(md5(time()), 0, 6) . "." . $request->nominee_nid->getClientOriginalExtension();
            $request->nominee_nid->move(base_path('public/kyc/nominee_nid/'), $filename);
            $data["nominee_nid"] = $filename;
        }

        $data['user_affiliate_type'] = User::PRIME;
        $data['affiliate_id'] = $request->affiliate_id;
        $data['reference_user_id'] = $request->reference_user_id;

        if(!empty($kyc)){
            $kyc->update($data);
        }else{
            Kyc::query()->create($data);
        }

        $user = auth()->user();
        $user->reference_user_id = $request->referer_id;
        $user->user_affiliate_type = User::PRIME;
        $user->save();

        return redirect()->route('dashboard');
    }

    /**
     * Show the form for editing the specified KYC record.
     */
    public function edit($id)
    {
        $kyc = Kyc::findOrFail($id);
        return view('user.kyc.edit', compact('kyc'));
    }

    /**
     * Update the specified KYC record in the database.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'referer_id' => 'nullable|exists:users,id',
            'affiliate_id' => 'nullable|string|max:255',
            'doc_type' => 'required|integer',
            'document_file' => 'nullable|file|mimes:jpeg,png,pdf|max:2048',
            'father' => 'nullable|string|max:255',
            'mother' => 'nullable|string|max:255',
            'dob' => 'nullable|date',
            'permanent_division_id' => 'nullable|exists:divisions,id',
            'permanent_district_id' => 'nullable|exists:districts,id',
            'permanent_police_station_id' => 'nullable|exists:police_stations,id',
            'permanent_post_office_id' => 'nullable|exists:post_offices,id',
            'permanent_post_code' => 'nullable|string|max:10',
            'present_division_id' => 'nullable|exists:divisions,id',
            'present_district_id' => 'nullable|exists:districts,id',
            'present_police_station_id' => 'nullable|exists:police_stations,id',
            'present_post_office_id' => 'nullable|exists:post_offices,id',
            'present_post_code' => 'nullable|string|max:10',
            'account_type' => 'nullable|integer',
            'account_number' => 'nullable|string|max:50',
        ]);

        $kyc = Kyc::findOrFail($id);

        $data = $request->except('document_file');
        if($request->has('document_file')) {
            $filename = Date('Y') . "_" . substr(md5(time()), 0, 6) . "." . $request->document_file->getClientOriginalExtension();
            $request->document_file->move(base_path('public/kyc/document_file/'), $filename);
            $data["document_file"] = $filename;
        }

        $kyc->update($data);

        return redirect()->route('kyc.list')->with('success', 'KYC record updated successfully.');
    }

    /**
     * Remove the specified KYC record from the database.
     */
    public function destroy($id)
    {
        $kyc = Kyc::findOrFail($id);
        $kyc->delete();

        return redirect()->route('kyc.list')->with('success', 'KYC record deleted successfully.');
    }

    public function assign_postal_area(Request $request){

        $user = auth()->user();
        $user->district_id          = $request->district_id;
        $user->police_station_id    = $request->police_station_id;
        $user->post_office_id       = $request->post_office_id;
        $user->postal_code          = $request->postal_code;
        $user->prime_verified       = User::PRIME_VERIFIED_STATUS_POSTAL_ASSIGN;
        $user->save();

        return ['status','Postal area assigned.'];
    }

    public function nominee(Request $request){
        $data = $request->all();
        $user = auth()->user();
        $data['user_id'] = $user->id;

        $nomineeInfo = NomineeInfo::query()->where('user_id',$data['user_id'])->first();
        if(!empty($nomineeInfo)){
            $nomineeInfo->update($data);
        }else{
            NomineeInfo::create($data);
        }

        $user->prime_verified = User::PRIME_VERIFIED_STATUS_NOMINEE;
        $user->save();

        return ['status','Nominee information is successfully saved.'];
    }

    public function choose_package(Request $request)
    {
        $user = auth()->user();
    
        $alreadyHasActive = PackageUser::where('user_id', $user->id)->where('subscription_package_id', $request->subscription_package_id)
            ->where('status', User::USER_PACKAGE_INACTIVE)
            ->exists();
    
        if ($alreadyHasActive) {
            return response()->json(['status' => false, 'message' => 'You already enrolled this package.'], 409);
        }
    
        $user->prime_verified = User::PRIME_VERIFIED_STATUS_PACKAGE;
        $user->save();
    
        $data = $request->all();
        $data['user_id'] = $user->id;
        $data['assigned_at'] = null;
        $data['expires_at'] = null;
        $data['status'] = User::USER_PACKAGE_PENDING;
    
        $updatePackage = PackageUser::where('user_id', $user->id)->where('status', User::USER_PACKAGE_PENDING)->first();

        if(!empty($updatePackage)){
            $updatePackage->update($data);
        }else{
            PackageUser::create($data);
        }
    
        return response()->json(['status' => true, 'message' => 'Package selected.']);
    }

    public function finish_payment(Request $request){
        
        $user = auth()->user();
        $user->prime_verified = User::PRIME_VERIFIED_STATUS_PAYMENT;
        $user->save();

        $updatePackage = PackageUser::where('user_id', $user->id)->where('status', User::USER_PACKAGE_PENDING)->first();
        $package = SubscriptionPackage::query()->findOrFail($request->subscription_package_id);

        $data = $request->all();
        $data['user_id'] = $user->id;
        $data['amount'] = $package->discount;
        
        $updatePackage->update($data);

        return response()->json(['status' => true, 'message' => 'Payment done']);
    }
    
}
