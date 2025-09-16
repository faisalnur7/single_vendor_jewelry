<!-- WhatsApp Button -->
<button id="whatsappToggle" class="flex items-center gap-2 rounded-lg px-0 py-1 hover:bg-gray-100">
    <img src="{{ asset('/assets/img/whatsapp.png') }}" class="w-8" />
</button>

<!-- WhatsApp Card -->
<div id="whatsappMenu"
    class="hidden absolute right-0 mt-2 w-42 bg-white border border-gray-200 rounded-lg shadow-lg z-50 p-3 space-y-3 text-center">

    <div class="flex justify-center items-center w-full h-24">
        <img src="{{ asset('small_logo.png') }}" class="w-20 rounded-full border border-black " />
    </div>

    <p class="text-md mb-4 font-bold text-gray-900">Stainless Steel Jewelry</p>
    <a href="{{ $contactSettings?->whatsapp_link }}" target="_blank">{{ $contactSettings?->whatsapp_link }}</a>
    <span class="block text-sm font-semibold text-gray-600">WhatsApp Business Account</span>

    <!-- QR Code -->
    <div class="flex justify-center">
        <img src="{{ asset($contactSettings?->whatsapp_qr) }}" alt="WhatsApp QR" class="w-42 h-42 rounded-md border" />
    </div>
</div>
