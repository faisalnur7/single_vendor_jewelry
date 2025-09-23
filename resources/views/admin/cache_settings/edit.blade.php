@extends('layouts.admin_master')

@section('title', 'Cache Setting')
@section('page_title', 'Cache Setting')

@section('contents')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="p-6 bg-white rounded">
                <h2 class="text-xl font-bold mb-4">Cache Settings</h2>

                <form method="POST" action="{{ route('admin.cache_settings.update') }}" id="cacheForm">
                    @csrf
                    <!-- Switch -->
                    <div class="flex items-center space-x-4">
                        <span class="text-lg text-gray-700">Enable Product Caching</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="is_enabled" value="1" class="sr-only peer"
                                @if ($setting->is_enabled) checked @endif
                                onchange="document.getElementById('cacheForm').submit()">
                            <div
                                class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:bg-blue-600
                                       peer-focus:ring-4 peer-focus:ring-blue-300 
                                       transition-all duration-200">
                            </div>
                            <div
                                class="absolute left-1 top-1 bg-white w-4 h-4 rounded-full 
                                       peer-checked:translate-x-5 transition-transform duration-200">
                            </div>
                        </label>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
