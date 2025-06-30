@extends('layouts.admin_master')

@section('title', 'Edit Product')
@section('page_title', 'Edit Product')
@section('styles')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.css" rel="stylesheet">
@endsection
@section('contents')
    <div class="container-fluid">
        <div class="card">
            <div
                class="card-header bg-gradient-dark text-white rounded-top d-flex justify-content-between align-items-center">
                <h3 class="card-title">Product Information</h3>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        {{-- Category --}}
                        <div class="col-md-4 form-group">
                            <label>Category</label>
                            <select name="category_id" class="form-control" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Subcategory --}}
                        <div class="col-md-4 form-group">
                            <label>Sub Category</label>
                            <select name="sub_category_id" class="form-control">
                                <option value="">Select Subcategory</option>
                                @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}"
                                        {{ $product->sub_category_id == $subcategory->id ? 'selected' : '' }}>
                                        {{ $subcategory->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Child Subcategory --}}
                        <div class="col-md-4 form-group">
                            <label>Child Sub Category</label>
                            <select name="child_sub_category_id" class="form-control">
                                <option value="">Select Child Subcategory</option>
                                @foreach ($childsubcategories as $childsubcategory)
                                    <option value="{{ $childsubcategory->id }}"
                                        {{ $product->child_sub_category_id == $childsubcategory->id ? 'selected' : '' }}>
                                        {{ $childsubcategory->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Featured / Status --}}
                        <div class="col-md-4 form-group">
                            <label>Featured</label>
                            <select name="featured" class="form-control">
                                <option value="1" {{ $product->featured == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ $product->featured == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $product->status == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ $product->status == '0' ? 'selected' : '' }}>Inactive</option>
                                <option value="2" {{ $product->status == '2' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>

                        {{-- Name / Slug / SKU --}}
                        <div class="col-md-4 form-group">
                            <label>Product Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $product->name }}"
                                required>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" class="form-control" value="{{ $product->slug }}"
                                required>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>SKU</label>
                            <input type="text" name="sku" class="form-control" value="{{ $product->sku }}" readonly
                                required>
                        </div>

                        {{-- Unit / Qty / Price / Stock --}}
                        <div class="col-md-4 form-group">
                            <label>Unit</label>
                            <input type="text" name="unit" class="form-control" value="{{ $product->unit }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Min Order Quantity</label>
                            <input type="number" step="0.01" name="min_order_qty" class="form-control"
                                value="{{ $product->min_order_qty }}">
                        </div>

                        @if ($product->parent_id !== 0)
                            <input type="hidden" name="is_variant" value="1">
                            <div class="col-md-4 form-group">
                                <label>Color</label>
                                <input type="text" name="color" class="form-control" value="{{ $product->color }}">
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Price</label>
                                <input type="number" step="0.01" name="price" class="form-control"
                                    value="{{ $product->price }}">
                            </div>
                        @else
                            <input type="hidden" name="is_variant" value="0">
                            <div class="col-md-4 form-group">
                                <label>Min Price</label>
                                <input type="number" step="0.01" name="min_price" class="form-control"
                                    value="{{ $product->min_price }}">
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Max Price</label>
                                <input type="number" step="0.01" name="max_price" class="form-control"
                                    value="{{ $product->max_price }}">
                            </div>
                        @endif
                        <div class="col-md-4 form-group">
                            <label>Stock</label>
                            <input type="number" name="stock" class="form-control" value="{{ $product->stock }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Weight (grams)</label>
                            <input type="number" step="0.01" name="weight" class="form-control"
                                value="{{ $product->weight }}">
                        </div>

                        @if ($product->parent_id == 0)
                            {{-- Descriptions --}}
                            <div class="col-md-4 form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control">{{ $product->description }}</textarea>
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Short Description</label>
                                <textarea name="short_description" class="form-control" rows="2">{{ $product->short_description }}</textarea>
                            </div>

                            <div class="col-md-4 form-group">
                                <label>Meta Data</label>
                                <textarea name="meta" class="form-control" rows="2">{{ $product->meta }}</textarea>
                            </div>
                        @endif
                        {{-- Image --}}
                        <div class="col-md-6 form-group">
                            <label>Product Image</label>
                            <input type="file" name="image" class="form-control-file">
                        </div>

                        {{-- Variant Section --}}
                        <div class="col-12 form-group">
                            @if ($product->parent_id == 0)
                                <div class="form-check mb-2">
                                    <input type="checkbox" class="form-check-input" id="has_variants"
                                        name="has_variants" value="1"
                                        {{ count($product->variants) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="has_variants">The product has variant</label>
                                </div>
                            @endif

                            <div id="variant_section" data-variant_count = "{{ count($product->variants) }}"
                                style="display: {{ count($product->variants) ? 'block' : 'none' }};">
                                <label>Product Variants</label>
                                <div id="variants_container">
                                    @if (count($product->variants))
                                        @foreach ($product->variants as $index => $variant)
                                            <div class="form-row variant-item mb-3 border p-3 rounded">
                                                <div class="col-md-12 d-flex align-items-center justify-end">
                                                    <button type="button" class="btn btn-outline-danger btn-sm remove-variant"><i class="fas fa-minus"></i></button>
                                                </div>
                                                <input type="hidden" name="variants[{{ $index }}][id]"
                                                    value="{{ $variant->id }}" />
                                                <div class="col-md-3">
                                                    <input type="text" name="variants[{{ $index }}][color]"
                                                        class="form-control" placeholder="Color"
                                                        value="{{ $variant['color'] }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="variants[{{ $index }}][price]"
                                                        class="form-control" placeholder="Price"
                                                        value="{{ $variant['price'] }}">
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="text" name="variants[{{ $index }}][stock]"
                                                        class="form-control" placeholder="Stock"
                                                        value="{{ $variant['stock'] }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <input type="file" name="variants[{{ $index }}][image]"
                                                        class="form-control-file">
                                                </div>
                                                <div class="col-md-12 mb-2">
                                                    <label>Description</label>
                                                    <textarea name="variants[{{ $index }}][description]" class="form-control summernote" rows="3">{{ $variant->description }}</textarea>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <!-- Default One -->
                                        <div class="form-row variant-item mb-3 border p-3 rounded">
                                            <div class="col-md-12 d-flex align-items-center justify-end">
                                                <button type="button" class="btn btn-outline-danger btn-sm remove-variant"><i class="fas fa-minus"></i></button>
                                            </div>
                                            <input type="hidden" name="variants[0][id]" value="" />
                                            <div class="col-md-3">
                                                <input type="text" name="variants[0][color]" class="form-control"
                                                    placeholder="Color">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="text" name="variants[0][price]" class="form-control"
                                                    placeholder="Price">
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" name="variants[0][stock]" class="form-control"
                                                    placeholder="Stock">
                                            </div>
                                            <div class="col-md-3">
                                                <input type="file" name="variants[0][image]"
                                                    class="form-control-file">
                                            </div>
                                            <div class="col-md-12 mb-2">
                                                <label>Description</label>
                                                <textarea name="variants[{{ $index }}][description]" class="form-control summernote" rows="3">{{ $variant->description }}</textarea>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <button type="button" id="add_variant_btn" class="btn btn-primary btn-sm mt-2">Add More
                                    Variant</button>
                            </div>
                        </div>

                        {{-- Submit --}}
                        <div class="col-12">
                            <button type="submit" class="btn btn-success">Save Product</button>
                            <a href="{{ route('product.list') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.18/summernote-lite.min.js"></script>
    <script>
        function slugify(text) {
            return text.toString().toLowerCase().trim()
                .replace(/[\s\W-]+/g, '-') // replace spaces & special chars with -
                .replace(/^-+|-+$/g, ''); // trim leading & trailing hyphens
        }

        $(document).ready(function() {
            var slugEdited = false;
            var variantIndex = {{ count($product->variants) ?? 1 }};

            // Initialize Summernote for existing variant descriptions
            $('.summernote').summernote({
                height: 100
            });

            $('input[name="name"]').on('input', function() {
                if (!slugEdited) {
                    $('input[name="slug"]').val(slugify($(this).val()));
                }
            });

            $('input[name="slug"]').on('input', function() {
                slugEdited = true;
            });

            $('#has_variants').on('change', function() {
                $('#variant_section').toggle(this.checked);
            });

            $('#add_variant_btn').on('click', function() {
                const html = `
            <div class="form-row variant-item mb-3 border p-3 rounded">
                <div class="col-md-12 d-flex align-items-center justify-end">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-variant"><i class="fas fa-minus"></i></button>
                </div>
                <input type="hidden" name="variants[${variantIndex}][id]" />
                <div class="col-md-3">
                    <input type="text" name="variants[${variantIndex}][color]" class="form-control" placeholder="Color">
                </div>
                <div class="col-md-2">
                    <input type="text" name="variants[${variantIndex}][price]" class="form-control" placeholder="Price">
                </div>
                <div class="col-md-2">
                    <input type="text" name="variants[${variantIndex}][stock]" class="form-control" placeholder="Stock">
                </div>
                <div class="col-md-3">
                    <input type="file" name="variants[${variantIndex}][image]" class="form-control-file">
                </div>
                <div class="col-md-12 mb-2">
                    <label>Description</label>
                    <textarea name="variants[${variantIndex}][description]" class="form-control summernote" rows="3"></textarea>
                </div>
            </div>`;
                $('#variants_container').append(html);
                $(`.summernote`).last().summernote({
                    height: 100
                });
                variantIndex++;
            });

            $(document).on('click', '.remove-variant', function() {
                $(this).closest('.variant-item').remove();
            });
        });
    </script>
@endsection
