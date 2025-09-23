<?php

namespace App\Http\Controllers;

use App\Models\District;
use App\Models\Division;
use App\Models\PoliceStation;
use App\Models\PostOffice;
use App\Models\User;
use App\Models\State;
use App\Models\Product;
use App\Models\City;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;
use Stichoza\GoogleTranslate\GoogleTranslate;


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
    
    public function setCurrency(Request $request)
    {
        $currency = $request->currency ?? 'USD';
        session(['currency' => $currency]);
        return back();
    }

    protected $supportedLanguages = [
        'en', 'pt', 'ar', 'es', 'fr', 'it', 'de', 'sv', 'no', 'tr', 'hi', 'ru', 'el', 'ro', 'cs', 'pl'
    ];

    public function switchLanguage(Request $request)
    {
        $request->validate([
            'language' => 'required|string|in:en,pt,ar,es,fr,it,de,sv,no,tr,hi,ru,el,ro,cs,pl'
        ]);

        Session::put('lang', $request->language);
        
        return response()->json([
            'success' => true,
            'language' => $request->language,
            'message' => 'Language switched successfully'
        ]);
    }

    public function translateTexts(Request $request)
    {
        $request->validate([
            'texts' => 'required|array|max:100',
            'texts.*' => 'string|max:2000',
            'language' => 'required|string|in:en,pt,ar,es,fr,it,de,sv,no,tr,hi,ru,el,ro,cs,pl'
        ]);

        $texts = $request->texts;
        $language = $request->language;
        
        if ($language === 'en') {
            return response()->json([
                'success' => true,
                'translations' => $texts
            ]);
        }

        $translations = [];
        
        try {
            $tr = new GoogleTranslate($language);
            $tr->setSource('en');
            
            foreach ($texts as $key => $text) {
                if (empty(trim($text))) {
                    $translations[$key] = $text;
                    continue;
                }
                
                $cacheKey = 'trans_' . md5($text . '_' . $language);
                
                $translated = Cache::remember($cacheKey, 86400, function () use ($tr, $text) {
                    return $tr->translate($text);
                });
                
                $translations[$key] = $translated;
            }
            
            return response()->json([
                'success' => true,
                'translations' => $translations
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Translation failed', [
                'language' => $language,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Translation service temporarily unavailable',
                'translations' => $texts // Return original texts as fallback
            ]);
        }
    }

    public function recentProducts(Request $request)
    {
        $ids = $request->ids ?? [];
        $products = Product::with('variants')->whereIn('id', $ids)->get();

        return view('frontend.partials.recent_products', compact('products'))->render();
    }


}