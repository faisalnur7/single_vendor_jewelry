@php
    $wholesale_trendings = \App\Models\CustomCategory::where('type', \App\Models\CustomCategory::TRENDING)->orderBy('order', 'asc')->get();
@endphp

@foreach ($wholesale_trendings as $trending)
    @php
        $route = "#";
        if(!empty($trending->child_sub_category_id)){
            $route = route('childsubcategory.show', [$trending->category->slug, $trending->subCategory->slug, $trending->childSubCategory->slug]);
        }else if(!empty($trending->sub_category_id)){
            $route = route('subcategory.show', [$trending->category->slug, $trending->subCategory->slug]);
        }else if(!empty($trending->category_id)){
            $route = route('category.show', $trending->category->slug);
        }
    @endphp
    <a href="{{$route}}">
        <div class="relative bg-white  rounded-lg group overflow-hidden">
            <img src="{{ asset($trending->image) }}" alt="{{ $trending->name }}"
                class="mx-auto flex justify-center items-center transition-transform duration-1000 object-contain scale-[1.05] group-hover:scale-[1.5] group-hover:rotate-12" />
            <div
                class="absolute inset-0 bg-black bg-opacity-50 opacity-0 group-hover:opacity-100 transition-opacity duration-500 flex items-center justify-center">
                <span class="text-white text-lg font-semibold text-center px-2">{{ $trending->name }}</span>
            </div>
        </div>
    </a>
@endforeach
