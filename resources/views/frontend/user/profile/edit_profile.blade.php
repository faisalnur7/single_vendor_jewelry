@extends('frontend.user.profile')

@section('user_contents')
<h2 class="text-lg font-semibold mb-4">Edit Profile</h2>

<form action="{{ route('user_profile_update') }}" method="POST" class="bg-white  rounded-lg p-6 space-y-4">
    @csrf

    <div>
        <label class="block text-gray-600">Name</label>
        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" class="w-full border rounded px-3 py-2" required>
        @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-gray-600">Email</label>
        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" class="w-full border rounded px-3 py-2" required>
        @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>

    <div>
        <label class="block text-gray-600">Phone</label>
        <input type="text" name="phone" value="{{ old('phone', auth()->user()->phone) }}" class="w-full border rounded px-3 py-2" required>
        @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
    </div>


    <div>
        <button type="submit" class="px-4 py-2 bg-orange-500 text-white rounded hover:bg-orange-600">Update Profile</button>
    </div>
</form>
@endsection
