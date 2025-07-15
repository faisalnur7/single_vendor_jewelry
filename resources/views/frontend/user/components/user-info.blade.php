<div class="flex items-center gap-4 mb-8">
    <img src="https://i.pravatar.cc/80?u={{ Auth::id() }}" alt="User Avatar"
        class="w-16 h-16 rounded-full border border-gray-300 shadow">
    <div>
        <h1 class="text-2xl font-bold">{{ Auth::user()->name }}</h1>
        <p class="text-gray-500 text-sm">{{ Auth::user()->email }}</p>
    </div>
</div>
