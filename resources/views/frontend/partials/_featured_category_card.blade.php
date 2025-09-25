@php
    $featuredCategories = \App\Models\CustomCategory::where('type', \App\Models\CustomCategory::FEATURED)->orderBy('order', 'asc')->get();
@endphp

@foreach ($featuredCategories as $featuredCategory)
    @php
        $route = "#";
        if(!empty($featuredCategory->child_sub_category_id)){
            $route = route('childsubcategory.show', [$featuredCategory->category->slug, $featuredCategory->subCategory->slug, $featuredCategory->childSubCategory->slug]);
        }else if(!empty($featuredCategory->sub_category_id)){
            $route = route('subcategory.show', [$featuredCategory->category->slug, $featuredCategory->subCategory->slug]);
        }else if(!empty($featuredCategory->category_id)){
            $route = route('category.show', $featuredCategory->category->slug);
        }
    @endphp
    <a href="{{ $route }}">
        <div class="flex flex-col items-center text-center mt-6">
            <div class="bg-white border rounded-full group overflow-hidden aspect-square">
                <img src="{{$featuredCategory->image}}"
                    class="mx-auto w-full h-full object-cover transition-transform duration-1000 group-hover:scale-110" />
            </div>
            <p class="mt-2 text-md font-bold text-gray-700">{{ $featuredCategory->name }}</p>
        </div>
    </a>
@endforeach
