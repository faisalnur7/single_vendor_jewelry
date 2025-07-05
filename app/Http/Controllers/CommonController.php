<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Division;
use App\Models\PoliceStation;
use App\Models\PostOffice;
use App\Models\User;
use App\Models\State;
use App\Models\City;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class CommonController extends Controller
{

    public function load_affiliate_id(Request $request){
        $user = User::findOrFail($request->ref_user_id);
        $refered_user_count = User::query()->where('reference_id',$user->id)->count();
        $reference_id = 'RB-'.sprintf('%04.3d', $user->id).'-'.sprintf('%04.3d', $refered_user_count+1);
        return ['reference_id' => $reference_id];
    }

    public function load_districts(Request $request)
    {
        $data['districts'] = District::query()->where('division_id',$request->division_id)->get();
        return $data;
    }

    public function load_police_stations(Request $request)
    {
        $data['police_stations'] = PoliceStation::query()->where('district_id',$request->district_id)->get();
        return $data;
    }

    public function load_post_offices(Request $request)
    {
        $data['post_offices'] = PostOffice::query()->where('police_station_id',$request->police_station_id)->get();
        return $data;
    }

    public function getStates($country_id)
    {
        $states = State::where('country_id', $country_id)->get();
        return response()->json($states);
    }

    public function getCities($state_id)
    {
        $cities = City::where('state_id', $state_id)->get();
        return response()->json($cities);
    }
}