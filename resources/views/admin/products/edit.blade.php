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
                        <div class="col-md-4 form-group">
                            <label>Supplier</label>
                            <select name="supplier_id" class="form-control select2" id="supplier_id" required>
                                <option value="">Select Supplier</option>
                                @foreach ($suppliers as $supplier)
                                    <option value="{{ $supplier->id }}"
                                        {{ $product->supplier_id == $supplier->id ? 'selected' : '' }}>
                                        {{ $supplier->contact_person }} - {{ $supplier->company_name }} -
                                        {{ $supplier->mobile_number }}
                                    </option>
                                @endforeach
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
                            <label>Gender</label>
                            <select name="gender" class="form-control">
                                <option value="Female" {{ $product->gender == '0' ? 'selected' : '' }}>Female</option>
                                <option value="Male" {{ $product->gender == '1' ? 'selected' : '' }}>Male</option>
                                <option value="Unisex" {{ $product->gender == '2' ? 'selected' : '' }}>Unisex</option>
                            </select>
                        </div>

                        {{-- Unit / Qty / Price / Stock --}}
                        <div class="col-md-4 form-group">
                            <label>Unit</label>
                            <select name="unit" class="form-control">
                                <option value="pcs" {{ old('unit') == 'pcs' ? 'selected' : '' }}>Pcs</option>
                                <option value="set" {{ old('unit') == 'set' ? 'selected' : '' }}>Set</option>
                            </select>
                        </div>

                        <div class="col-md-4 form-group">
                            <label>Min Order Quantity</label>
                            <input type="number" step="0.01" name="min_order_qty" class="form-control"
                                value="{{ old('min_order_qty', 12) }}">
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
                        @endif

                        @if ($product->parent_id == 0)
                            {{-- Descriptions --}}
                            <div class="col-md-4 form-group">
                                <label>Description</label>
                                <textarea name="description" class="form-control">{{ $product->description }}</textarea>
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
                                    <input type="checkbox" class="form-check-input" id="has_variants" name="has_variants"
                                        value="1" {{ count($product->variants) ? 'checked' : '' }}>
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
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm remove-variant"><i
                                                            class="fas fa-minus"></i></button>
                                                </div>
                                                <input type="hidden" name="variants[{{ $index }}][id]"
                                                    value="{{ $variant->id }}" />
                                                <div class="col-md-4 mt-2">
                                                    <input type="text" name="variants[{{ $index }}][color]"
                                                        class="form-control" placeholder="Color"
                                                        value="{{ $variant['color'] }}">
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <input type="text" name="variants[{{ $index }}][weight]"
                                                        class="form-control" placeholder="Weight (grams)"
                                                        value="{{ $variant['weight'] }}">
                                                </div>

                                                <div class="col-md-4 mt-2">
                                                    <input type="text" name="variants[{{ $index }}][price]"
                                                        class="form-control" placeholder="Price"
                                                        value="{{ $variant['price'] }}">
                                                </div>
                                                <div class="col-md-4 mt-2">
                                                    <input type="text" name="variants[{{ $index }}][price_rmb]"
                                                        class="form-control" placeholder="Price in RMB"
                                                        value="{{ $variant['price_rmb'] }}">
                                                </div>

                                                <div class="col-md-4 mt-2">
                                                    <input type="text"
                                                        name="variants[{{ $index }}][purchase_price]"
                                                        class="form-control" placeholder="Purchase price"
                                                        value="{{ $variant['purchase_price'] }}">
                                                </div>

                                                <div class="col-md-4 mt-2">
                                                    <input type="text"
                                                        name="variants[{{ $index }}][purchase_price_rmb]"
                                                        class="form-control" placeholder="Purchase price in RMB"
                                                        value="{{ $variant['purchase_price_rmb'] }}">
                                                </div>
                                                <div class="col-md-3 mt-2">
                                                    <input type="file" name="variants[{{ $index }}][image]"
                                                        class="form-control-file">
                                                </div>

                                                {{-- ✅ Variant Descriptions Section --}}
                                                <div class="col-md-12 mt-3 border-top pt-3">
                                                    <label><strong>Variant Descriptions</strong></label>
                                                    <div class="variant-descriptions">
                                                        @php
                                                            $descriptions =
                                                                json_decode($variant->description_json, true) ?? [];
                                                        @endphp
                                                        @if (count($descriptions) > 0)
                                                            @foreach ($descriptions as $descIndex => $desc)
                                                                <div class="description-row d-flex gap-2 mb-2">
                                                                    <input type="text"
                                                                        name="variants[{{ $index }}][descriptions][{{ $descIndex }}][label]"
                                                                        class="form-control"
                                                                        placeholder="Label (e.g. Height)"
                                                                        value="{{ $desc['label'] ?? '' }}">
                                                                    <input type="text"
                                                                        name="variants[{{ $index }}][descriptions][{{ $descIndex }}][value]"
                                                                        class="form-control"
                                                                        placeholder="Value (e.g. 120mm)"
                                                                        value="{{ $desc['value'] ?? '' }}">
                                                                    <button type="button"
                                                                        class="btn btn-outline-danger btn-sm remove-description">
                                                                        <i class="fas fa-times"></i>
                                                                    </button>
                                                                </div>
                                                            @endforeach
                                                        @else
                                                            {{-- Default empty row if no descriptions exist --}}
                                                            <div class="description-row d-flex gap-2 mb-2">
                                                                <input type="text"
                                                                    name="variants[{{ $index }}][descriptions][0][label]"
                                                                    class="form-control"
                                                                    placeholder="Label (e.g. Height)">
                                                                <input type="text"
                                                                    name="variants[{{ $index }}][descriptions][0][value]"
                                                                    class="form-control" placeholder="Value (e.g. 120mm)">
                                                                <button type="button"
                                                                    class="btn btn-outline-danger btn-sm remove-description">
                                                                    <i class="fas fa-times"></i>
                                                                </button>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <button type="button"
                                                        class="btn btn-sm btn-outline-primary add-description mt-2">
                                                        <i class="fas fa-plus"></i> Add More Description
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <!-- Default One -->
                                        <div class="form-row variant-item mb-3 border p-3 rounded">
                                            <div class="col-md-12 d-flex align-items-center justify-end">
                                                <button type="button"
                                                    class="btn btn-outline-danger btn-sm remove-variant"><i
                                                        class="fas fa-minus"></i></button>
                                            </div>
                                            <input type="hidden" name="variants[0][id]" value="" />
                                            <div class="col-md-4 mt-2">
                                                <input type="text" name="variants[0][color]" class="form-control"
                                                    placeholder="Color">
                                            </div>
                                            <div class="col-md-4 mt-2">
                                                <input type="text" name="variants[0][weight]" class="form-control"
                                                    placeholder="Weight (grams)">
                                            </div>
                                            <div class="col-md-4 mt-2">
                                                <input type="text" name="variants[0][price]" class="form-control"
                                                    placeholder="Price">
                                            </div>
                                            <div class="col-md-4 mt-2">
                                                <input type="text" name="variants[0][price_rmb]" class="form-control"
                                                    placeholder="Price in RMB">
                                            </div>
                                            <div class="col-md-4 mt-2">
                                                <input type="text" name="variants[0][purchase_price]"
                                                    class="form-control" placeholder="Purchase price">
                                            </div>
                                            <div class="col-md-4 mt-2">
                                                <input type="text" name="variants[0][purchase_price_rmb]"
                                                    class="form-control" placeholder="Purchase price in RMB">
                                            </div>
                                            <div class="col-md-3 mt-2">
                                                <input type="file" name="variants[0][image]"
                                                    class="form-control-file">
                                            </div>

                                            {{-- ✅ Description Pattern Section for new variant --}}
                                            <div class="col-md-12 mt-3 border-top pt-3">
                                                <label><strong>Variant Descriptions</strong></label>
                                                <div class="variant-descriptions">
                                                    <div class="description-row d-flex gap-2 mb-2">
                                                        <input type="text" name="variants[0][descriptions][0][label]"
                                                            class="form-control" placeholder="Label (e.g. Height)">
                                                        <input type="text" name="variants[0][descriptions][0][value]"
                                                            class="form-control" placeholder="Value (e.g. 120mm)">
                                                        <button type="button"
                                                            class="btn btn-outline-danger btn-sm remove-description">
                                                            <i class="fas fa-times"></i>
                                                        </button>
                                                    </div>
                                                </div>
                                                <button type="button"
                                                    class="btn btn-sm btn-outline-primary add-description mt-2">
                                                    <i class="fas fa-plus"></i> Add More Description
                                                </button>
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
                            <a href="{{ route('product.list') }}" class="btn btn-neutral">Cancel</a>
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
                .replace(/[\s\W-]+/g, '-')
                .replace(/^-+|-+$/g, '');
        }

        $(document).ready(function() {
            var slugEdited = false;
            var variantIndex = {{ count($product->variants) ?? 1 }};

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

            // Add new variant
            $('#add_variant_btn').on('click', function() {
                const html = `
            <div class="form-row variant-item mb-3 border p-3 rounded">
                <div class="col-md-12 d-flex align-items-center justify-end">
                    <button type="button" class="btn btn-outline-danger btn-sm remove-variant"><i class="fas fa-minus"></i></button>
                </div>
                <input type="hidden" name="variants[${variantIndex}][id]" />
                <div class="col-md-4 mt-2">
                    <input type="text" name="variants[${variantIndex}][color]" class="form-control" placeholder="Color">
                </div>
                <div class="col-md-4 mt-2">
                    <input type="text" name="variants[${variantIndex}][weight]" class="form-control" placeholder="Weight (grams)">
                </div>
                <div class="col-md-4 mt-2">
                    <input type="text" name="variants[${variantIndex}][price]" class="form-control" placeholder="Price">
                </div>
                <div class="col-md-4 mt-2">
                    <input type="text" name="variants[${variantIndex}][price_rmb]" class="form-control" placeholder="Price in RMB">
                </div>
                <div class="col-md-4 mt-2">
                    <input type="text" name="variants[${variantIndex}][purchase_price]" class="form-control" placeholder="Purchase price">
                </div>
                <div class="col-md-4 mt-2">
                    <input type="text" name="variants[${variantIndex}][purchase_price_rmb]" class="form-control" placeholder="Purchase price in RMB">
                </div>
                <div class="col-md-3 mt-2">
                    <input type="file" name="variants[${variantIndex}][image]" class="form-control-file">
                </div>

                <div class="col-md-12 mt-3 border-top pt-3">
                    <label><strong>Variant Descriptions</strong></label>
                    <div class="variant-descriptions">
                        <div class="description-row d-flex gap-2 mb-2">
                            <input type="text" name="variants[${variantIndex}][descriptions][0][label]" class="form-control" placeholder="Label (e.g. Height)">
                            <input type="text" name="variants[${variantIndex}][descriptions][0][value]" class="form-control" placeholder="Value (e.g. 120mm)">
                            <button type="button" class="btn btn-outline-danger btn-sm remove-description"><i class="fas fa-times"></i></button>
                        </div>
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-primary add-description mt-2">
                        <i class="fas fa-plus"></i> Add More Description
                    </button>
                </div>
            </div>`;
                $('#variants_container').append(html);
                $(`.summernote`).last().summernote({
                    height: 100
                });
                variantIndex++;
            });

            // Remove variant
            $(document).on('click', '.remove-variant', function() {
                $(this).closest('.variant-item').remove();
            });

            // Add new description row inside a variant
            $(document).on('click', '.add-description', function() {
                const variantItem = $(this).closest('.variant-item');
                const descriptionsContainer = variantItem.find('.variant-descriptions');
                const variantIndex = variantItem.index();
                const descCount = descriptionsContainer.find('.description-row').length;

                const newDescRow = `
                    <div class="description-row d-flex gap-2 mb-2">
                        <input type="text" name="variants[${variantIndex}][descriptions][${descCount}][label]" class="form-control" placeholder="Label (e.g. Height)">
                        <input type="text" name="variants[${variantIndex}][descriptions][${descCount}][value]" class="form-control" placeholder="Value (e.g. 120mm)">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-description"><i class="fas fa-times"></i></button>
                    </div>`;
                descriptionsContainer.append(newDescRow);
            });

            // Remove description row
            $(document).on('click', '.remove-description', function() {
                $(this).closest('.description-row').remove();
            });
        });
    </script>
@endsection
