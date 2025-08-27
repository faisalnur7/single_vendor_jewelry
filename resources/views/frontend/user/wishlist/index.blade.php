@extends('frontend.user.profile')

@section('user_contents')
<h2 class="text-lg font-semibold mb-4">My Wishlist</h2>

@if(session('success'))
    <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="mb-4 px-4 py-2 bg-red-100 text-red-700 rounded">{{ session('error') }}</div>
@endif

<div class="bg-white shadow rounded-lg p-4">
    @if($wishlists->count())
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm border border-gray-200">
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs">
                    <tr>
                        <th class="px-4 py-2 border">#</th>
                        <th class="px-4 py-2 border">Product</th>
                        <th class="px-4 py-2 border">Action</th>
                    </tr>
                </thead>
                <tbody class="text-gray-600">
                    @foreach($wishlists as $key => $wishlist)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $key + 1 }}</td>
                            <td class="px-4 py-2 border">
                            @foreach($wishlist->product->variants as $variant)
                                {{ $variant->name }} | <strong>{{ $variant->color }}</strong><br>
                            @endforeach
                            </td>
                            <td class="px-4 py-2 border space-x-2">
                                <form action="{{ route('user_wishlist_delete', $wishlist->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">
                                        <i class="fa fa-trash"></i> Remove
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <p class="text-gray-500">No products in your wishlist.</p>
    @endif
</div>
@endsection
