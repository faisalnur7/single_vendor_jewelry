@extends('layouts.admin_master')

@section('title', 'Add New Product')
@section('page_title', 'Add New Product')
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

                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="row">
                        <div class="col-md-4 form-group">
                            <label>Category</label>
                            <select name="category_id" class="form-control" id="category_id" required>
                                <option value="">Select Category</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Sub Category</label>
                            <select name="sub_category_id" class="form-control" id="subcategory_id">
                                <option value="">Select Subcategory</option>
                                @foreach ($subcategories as $subcategory)
                                    <option value="{{ $subcategory->id }}"
                                        {{ old('sub_category_id') == $subcategory->id ? 'selected' : '' }}>
                                        {{ $subcategory->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Child Sub Category</label>
                            <select name="child_sub_category_id" class="form-control" id="childsubcategory_id">
                                <option value="">Select Child Subcategory</option>
                                @foreach ($childsubcategories as $childsubcategory)
                                    <option value="{{ $childsubcategory->id }}"
                                        {{ old('child_sub_category_id') == $childsubcategory->id ? 'selected' : '' }}>
                                        {{ $childsubcategory->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Featured</label>
                            <select name="featured" class="form-control">
                                <option value="1" {{ old('featured') == '1' ? 'selected' : '' }}>Yes</option>
                                <option value="0" {{ old('featured') == '0' ? 'selected' : '' }}>No</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Inactive</option>
                                <option value="2" {{ old('status') == '2' ? 'selected' : '' }}>Draft</option>
                            </select>
                        </div>


                        <div class="col-md-4 form-group">
                            <label>Product Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Slug</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug') }}" required>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>SKU</label>
                            <input type="hidden" id="upcoming_product_id">
                            <input type="text" name="sku" id="sku" class="form-control"
                                value="{{ old('sku') }}" readonly required>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Unit</label>
                            <input type="text" name="unit" class="form-control" value="{{ old('unit') }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Min Order Quantity</label>
                            <input type="number" step="0.01" name="min_order_qty" class="form-control"
                                value="{{ old('min_order_qty', 0) }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Minimum Price</label>
                            <input type="number" step="0.01" name="min_price" class="form-control"
                                value="{{ old('min_price', 0) }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Maximum Price</label>
                            <input type="number" step="0.01" name="max_price" class="form-control"
                                value="{{ old('max_price', 0) }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Stock</label>
                            <input type="number" name="stock" class="form-control" value="{{ old('stock', 0) }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Weight (grams)</label>
                            <input type="number" step="0.01" name="weight" class="form-control"
                                value="{{ old('weight') }}">
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control">{{ old('description') }}</textarea>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Short Description</label>
                            <textarea name="short_description" class="form-control" rows="2">{{ old('short_description') }}</textarea>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Meta Data</label>
                            <textarea name="meta" class="form-control" rows="2" placeholder='seo,product'>{{ old('meta') }}</textarea>
                        </div>

                        <div class="col-md-6 form-group">
                            <label>Product Image</label>
                            <input type="file" name="image" class="form-control-file">
                        </div>

                        <div class="col-12 form-group">
                            <div class="form-check mb-2">
                                <input type="checkbox" class="form-check-input" id="has_variants" name="has_variants"
                                    value="1" {{ old('has_variants') ? 'checked' : '' }}>
                                <label class="form-check-label" for="has_variants">The product has variant</label>
                            </div>

                            <div id="variant_section" style="display: {{ old('has_variants') ? 'block' : 'none' }};">
                                <label class="mb-2">Product Variants</label>

                                <div id="variants_container">
                                    @if (old('variants'))
                                        @foreach (old('variants') as $index => $variant)
                                            <div class="form-row variant-item mb-3 border p-3 rounded">
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
                                                    <textarea name="variants[{{$index}}][description]" class="form-control summernote" rows="3"></textarea>
                                                </div>
                                                <div class="col-md-2 d-flex align-items-center justify-end">
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm remove-variant"><i
                                                            class="fas fa-minus"></i></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <!-- Default One -->
                                        <div class="form-row variant-item mb-3 border p-3 rounded">
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
                                                <textarea name="variants[0][description]" class="form-control summernote" rows="3"></textarea>
                                            </div>
                                            <div class="col-md-2 d-flex align-items-center justify-end">
                                                <button type="button"
                                                    class="btn btn-outline-danger btn-sm remove-variant"><i
                                                        class="fas fa-minus"></i></button>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                <button type="button" id="add_variant_btn" class="btn btn-primary btn-sm mt-2">Add More
                                    Variant</button>
                            </div>
                        </div>


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

    <script>
        function slugify(text) {
            return text
                .toString()
                .toLowerCase()
                .trim()
                .replace(/[\s\W-]+/g, '-') // replace spaces & special chars with -
                .replace(/^-+|-+$/g, ''); // trim leading & trailing hyphens
        }

        $(document).ready(function() {
            $('.summernote').summernote({
                height: 100
            });

            var slugManuallyEdited = false;

            // Auto-generate slug when product name is typed
            $('input[name="name"]').on('input', function() {
                if (!slugManuallyEdited) {
                    let slug = slugify($(this).val());
                    $('input[name="slug"]').val(slug);
                }
            });

            // Detect if the user edits the slug manually
            $('input[name="slug"]').on('input', function() {
                slugManuallyEdited = true;
            });

            // Toggle variant section visibility
            $('#has_variants').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#variant_section').slideDown();
                } else {
                    $('#variant_section').slideUp();
                }
            });

            let variantIndex = {{ old('variants') ? count(old('variants')) : 1 }};

            // Add more variants
            $('#add_variant_btn').on('click', function() {
                let variantHtml = `
                <div class="form-row variant-item mb-3 border p-3 rounded">
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
                    <div class="col-md-2 d-flex align-items-center justify-end">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-variant"><i class="fas fa-minus"></i></button>
                    </div>
                </div>`;
                $('#variants_container').append(variantHtml);
                $(`.summernote`).last().summernote({
                    height: 100
                });
                variantIndex++;
            });

            // Remove variant item
            $(document).on('click', '.remove-variant', function() {
                $(this).closest('.variant-item').remove();
            });



            // Generate SKU

            function fetchUpcomingProductIdAndGenerateSKU() {
                // Call backend to get the next product ID
                $.ajax({
                    url: "{{ route('getNextProductId') }}", // Laravel route
                    type: 'GET',
                    success: function(response) {
                        $('#upcoming_product_id').val(response.product_id);
                        generateSKU();
                    }
                });
            }

            function generateSKU() {
                var category = $('#category_id').val() || '';
                var subcategory = $('#subcategory_id').val() || '';
                var childsubcategory = $('#childsubcategory_id').val() || '';
                var upcomingProductId = $('#upcoming_product_id').val() || '';

                if (category && subcategory && childsubcategory && upcomingProductId) {
                    var sku = category + subcategory + childsubcategory + upcomingProductId;
                    $('#sku').val(sku);
                } else {
                    $('#sku').val('');
                }
            }

            $(document).on('change', '#category_id, #subcategory_id, #childsubcategory_id', function() {
                // When all three selected, fetch product id
                console.log($('#category_id').val());
                console.log($('#subcategory_id').val());
                console.log($('#childsubcategory_id').val());
                if ($('#category_id').val() && $('#subcategory_id').val() && $('#childsubcategory_id')
                    .val()) {
                    fetchUpcomingProductIdAndGenerateSKU();
                } else {
                    $('#sku').val('');
                }
            });
        });
    </script>
@endsection
