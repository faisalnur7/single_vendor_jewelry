@extends('frontend.user.profile')

@section('user_contents')
<h2 class="text-lg font-semibold mb-4">My Profile</h2>

<div class="bg-white shadow rounded-lg p-6 space-y-4">
    <div class="flex items-center justify-between border-b pb-2">
        <span class="text-gray-600 font-semibold">Name</span>
        <span class="text-gray-800">{{ auth()->user()->name }}</span>
    </div>

    <div class="flex items-center justify-between border-b pb-2 pt-2">
        <span class="text-gray-600 font-semibold">Email</span>
        <span class="text-gray-800">{{ auth()->user()->email }}</span>
    </div>

    <div class="flex items-center justify-between border-b pb-2 pt-2">
        <span class="text-gray-600 font-semibold">Phone</span>
        <span class="text-gray-800">{{ auth()->user()->phone }}</span>
    </div>

    <div class="flex items-center justify-between border-b pb-2 pt-2">
        <span class="text-gray-600 font-semibold">Registered On</span>
        <span class="text-gray-800">{{ auth()->user()->created_at->format('d M, Y') }}</span>
    </div>

    <div class="pt-4">
        <a href="{{ route('user_edit_profile', auth()->user()->id) }}" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
            Edit Profile
        </a>
    </div>
</div>
@endsection
