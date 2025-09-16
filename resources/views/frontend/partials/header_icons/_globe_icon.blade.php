<!-- Globe Button -->
<button id="globalToggle" class="flex items-center gap-2  rounded-lg px-0 py-1 hover:bg-gray-100">
    <img src="{{ asset('/assets/img/globe.png') }}" class="w-6" />
    <i class="fa-solid fa-chevron-down text-xs"></i>
</button>

<!-- Wrapper for Currency + Language -->
<div id="globalMenu"
    class="hidden absolute right-0 mt-2 w-72 bg-white border border-gray-200 rounded-lg shadow-lg z-50 p-3 space-y-3">

    <!-- Currency Dropdown -->
    <div>
        <span class="block text-sm font-semibold px-2 py-1 text-gray-600">Currency</span>
        <form action="{{ route('setCurrency') }}" method="POST" id="currencyForm" class="flex flex-col">
            @csrf
            <select name="currency" onchange="this.form.submit()"
                class="block w-full border rounded px-3 py-2 text-gray-700 focus:ring focus:ring-blue-200">
                <option value="USD" {{ session('currency', 'USD') == 'USD' ? 'selected' : '' }}>$ USD
                </option>
                <option value="RMB" {{ session('currency') == 'RMB' ? 'selected' : '' }}>¥ RMB</option>
            </select>
        </form>
    </div>

    <!-- Language Dropdown -->
    <div>
        <span class="block text-sm font-semibold px-2 py-1 text-gray-600">Language</span>
        <div class="flex flex-col">
            <select id="languageSelect" class="border rounded px-3 py-2">
                @foreach ($languages as $code => $lang)
                    <option value="{{ $code }}" {{ $currentLang === $code ? 'selected' : '' }}>
                        {{ $lang['flag'] }} {{ $lang['name'] }}
                    </option>
                @endforeach
            </select>

        </div>
    </div>
</div>
