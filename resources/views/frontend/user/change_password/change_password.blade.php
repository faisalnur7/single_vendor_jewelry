@extends('frontend.user.profile')

@section('user_contents')
<h2 class="text-lg font-semibold mb-4">Change Password</h2>

<!-- Flash Messages -->
@if(session('success'))
    <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 px-4 py-2 bg-red-100 text-red-700 rounded">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('user_password_update') }}" method="POST" class="bg-white shadow rounded-lg p-6 space-y-4">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-gray-600">Current Password</label>
        <input type="password" name="current_password" class="w-full border rounded px-3 py-2" required>
        @error('current_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-gray-600">New Password</label>
        <input type="password" name="new_password" class="w-full border rounded px-3 py-2" required>
        @error('new_password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-gray-600">Confirm New Password</label>
        <input type="password" name="new_password_confirmation" class="w-full border rounded px-3 py-2" required>
    </div>

    <div>
        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600">Update Password</button>
    </div>
</form>
@endsection
