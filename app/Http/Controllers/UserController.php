<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Otp;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserController extends Controller
{
    public function index()
    {
        $data['users'] = User::paginate(10);
        return view('admin.user.index', $data);
    }

    public function user_dashboard(){
        return view('frontend.user.pages.user_profile');
    }

    public function user_profile(){
        return view('frontend.user.pages.user_profile');
    }

    public function user_order(){
        $data['orders'] = Order::query()->where('user_id',auth()->user()->id)->paginate('10');
        return view('frontend.user.pages.user_orders', $data);
    }

    public function user_order_show($id){
        $data['order'] = Order::query()->findOrFail($id);
        return view('frontend.user.pages.user_order_show', $data);
    }

    public function user_view_profile(){
        return view('frontend.user.profile.view_profile');
    }

    public function user_edit_profile(){
        return view('frontend.user.profile.edit_profile');
    }

    public function user_profile_update(Request $request)
    {
        $user = auth()->user();

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $user->name = $data['name'];
        $user->email = $data['email'];
        $user->phone = $data['phone'];

        if(!empty($data['password'])){
            $user->password = bcrypt($data['password']);
        }

        $user->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function showChangePasswordForm()
    {
        return view('frontend.user.change_password.change_password');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:6|confirmed',
        ]);

        $user = auth()->user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password does not match.']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

}
