@php
    $featuredCategories = [
        [
            'name' => 'Faux Fur Bags',
            'image_url' =>
                '//factorypricejewelry.com/cdn/shop/files/Pericardium-Heart-Bag-Heart-Bag-1_4e2a1480-195a-4a75-b395-add1e6f54f33.webp?v=1734460272&width=900',
        ],
        [
            'name' => 'Party Necessities',
            'image_url' =>
                '//factorypricejewelry.com/cdn/shop/files/Glam-Shiny-Pin-Butterfly-Alloy-Plating-Inlay-Artificial-Pearls-Rhinestones-Unisex-Brooches_42139bdf-d12f-4214-b80c-f5a634c2922d.webp?v=1734489213&width=900',
        ],
        [
            'name' => 'Clear Lens Glasses',
            'image_url' =>
                '//factorypricejewelry.com/cdn/shop/files/Fashion-Solid-Color-Ac-Square-Full-Frame-Optical-Glasses_93e888f0-3238-47e3-9416-09549ac8bfdc.webp?v=1734488388&width=900',
        ],
        [
            'name' => 'Bow Necklaces',
            'image_url' =>
                '//factorypricejewelry.com/cdn/shop/files/Wholesale-Jewelry-Glam-Lady-Sexy-Bow-Knot-304-Stainless-Steel-316-Stainless-Steel-Pendant-Necklace_7052e7f6-86a5-4feb-975b-bbe82fa80a38.webp?v=1739459609&width=900',
        ],
        [
            'name' => 'Clear Lens Glasses',
            'image_url' =>
                '//factorypricejewelry.com/cdn/shop/files/S925-Sterling-Silver-Heart-Pendnat-Ear-Buckle-Wholesale-Nihaojewelry_b0ca46d0-899d-46fa-825f-7999afeaaecb.webp?v=1710490291&width=900',
        ],
        [
            'name' => 'Bow Necklaces',
            'image_url' =>
                '//factorypricejewelry.com/cdn/shop/files/women-s-lady-printing-polyester-printing-silk-scarves_a78e4623-c4ab-462f-9475-a9cc5cb48bdd.webp?v=1734443340&width=900',
        ],
        [
            'name' => 'Dainty Earrings',
            'image_url' =>
                '//factorypricejewelry.com/cdn/shop/files/Simple-Style-Circle-Alloy-Plating-Hair-Claws_d9f31cc2-77d5-4eab-9c46-3b3f35a30333.webp?v=1734463719&width=900',
        ],
        [
            'name' => 'Head Scarves',
            'image_url' =>
                '//factorypricejewelry.com/cdn/shop/files/Casual-Letter-Horseshoe-Buckle-Quartz-Women-s-Watches_cf5cb1e1-74f6-4d59-89d8-04fbba82a8a9.webp?v=1734490142&width=900',
        ],
        [
            'name' => 'Chunky Hair Accessories',
            'image_url' =>
                '//factorypricejewelry.com/cdn/shop/files/1-Pair-Ig-Style-Leaves-Flower-Ginkgo-Leaf-Plating-Stainless-Steel-Drop-Earrings.webp?v=1712122967&width=900',
        ],
        [
            'name' => 'Rectangular Watches',
            'image_url' =>
                '//factorypricejewelry.com/cdn/shop/files/1-Pair-Simple-Style-Bee-Pearl-Inlay-Pearl-Zircon-Drop-Earrings_aa01469e-2b50-42e2-a0e0-b1b45dcdb49e.webp?v=1730434011&width=900',
        ],
        [
            'name' => 'Leaf Jewelry',
            'image_url' => '//factorypricejewelry.com/cdn/shop/files/1747078506589851648.jpg?v=1743479203&width=900',
        ],
        [
            'name' => 'Quilora Jewelry',
            'image_url' =>
                '//factorypricejewelry.com/cdn/shop/files/1-Pair-Sweet-Simple-Style-C-Shape-Heart-Shape-Enamel-Plating-Inlay-304-Stainless-Steel-Zircon-Drop-Earrings-Ear-Studs_2a3fb773-e326-4244-a94b-2c87373d91a5.webp?v=1739457060&width=900',
        ],
        [
            'name' => 'Invitations',
            'image_url' =>
                '//factorypricejewelry.com/cdn/shop/files/1-piece-304-stainless-steel-18k-gold-plated-cross-heart-shape-sandblasted-polished-pendant_1ae67fa2-eed4-4c24-a81d-d53bdddf701e.webp?v=1729006192&width=900',
        ],
        [
            'name' => 'Colorful Enamel Earrings',
            'image_url' =>
                '//factorypricejewelry.com/cdn/shop/files/New-Fashion-Korean-Shoulder-Chain-Small-Square-Bag-Shoulder-Bags_0e6afff7-b943-4b87-b7c5-5f03b5971565.webp?v=1734458751&width=900',
        ],
        [
            'name' => 'Cross Charms',
            'image_url' => '//factorypricejewelry.com/cdn/shop/files/1704378656106876928.jpg?v=1743481540&width=900',
        ],
        [
            'name' => 'Winter Bags',
            'image_url' =>
                '//factorypricejewelry.com/cdn/shop/files/Unisex-Vintage-Style-Portrait-Animal-Canvas-Shopping-Bags_22f43a18-a932-4d82-b0fe-789fbc111169.webp?v=1734457403&width=900',
        ],
    ];
@endphp

@foreach ($featuredCategories as $item)
    <div class="flex flex-col items-center text-center">
        <div class="bg-white border rounded-full group overflow-hidden aspect-square">
            <img src="https:{{ $item['image_url'] }}" alt="{{ $item['name'] ?: 'Category Image' }}"
                class="mx-auto w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" />
        </div>
        <p class="mt-2 text-sm font-medium text-gray-700">{{ $item['name'] ?: 'No Name' }}</p>
    </div>
@endforeach

