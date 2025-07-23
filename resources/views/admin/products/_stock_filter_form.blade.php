<form method="GET" action="{{ route('stock') }}">
    <div class="row">

        <!-- Name -->
        <div class="col-md-3 col-lg-2">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ request()->get('name') }}">
        </div>

        <!-- SKU -->
        <div class="col-md-3 col-lg-2">
            <label for="sku" class="form-label">SKU</label>
            <input type="text" name="sku" id="sku" class="form-control"
                   value="{{ request()->get('sku') }}">
        </div>

        <!-- Category -->
        <div class="col-md-3 col-lg-2">
            <label for="category" class="form-label">Category</label>
            <select name="category" id="category" class="form-control select2">
                <option value="">Select Category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ request()->get('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Sub Category -->
        <div class="col-md-3 col-lg-2">
            <label for="sub_category" class="form-label">Sub Category</label>
            <select name="sub_category" id="sub_category" class="form-control select2">
                <option value="">Select Sub Category</option>
                @foreach ($subCategories as $subCategory)
                    <option value="{{ $subCategory->id }}"
                        {{ request()->get('sub_category') == $subCategory->id ? 'selected' : '' }}>
                        {{ $subCategory->name }}
                    </option>
                @endforeach
            </select>
        </div>

         <!-- Child Sub Category -->
        <div class="col-md-3 col-lg-2">
            <label for="child_sub_category" class="form-label">Sub Category</label>
            <select name="child_sub_category" id="child_sub_category" class="form-control select2">
                <option value="">Select Child Sub Category</option>
                @foreach ($childSubCategories as $childSubCategory)
                    <option value="{{ $childSubCategory->id }}"
                        {{ request()->get('child_sub_category') == $childSubCategory->id ? 'selected' : '' }}>
                        {{ $childSubCategory->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Submit Button -->
        <div class="col-md-3 col-lg-2 align-self-end mt-4">
            <button type="submit" class="btn btn-primary w-100 shadow-sm">
                <i class="fas fa-filter"></i> Filter
            </button>
        </div>

    </div>
</form>

<script>
    const subCategories = @json($subCategories);
    const childSubCategories = @json($childSubCategories);

    $(document).ready(function () {
        const selectedSubCategory = "{{ request()->get('sub_category') }}";
        const selectedChildSubCategory = "{{ request()->get('child_sub_category') }}";

        function populateSubCategories(categoryId) {
            const filteredSubCategories = subCategories.filter(item => item.category_id == categoryId);
            $('#sub_category').empty().append('<option value="">Select Sub Category</option>');

            filteredSubCategories.forEach(item => {
                $('#sub_category').append(
                    `<option value="${item.id}" ${item.id == selectedSubCategory ? 'selected' : ''}>${item.name}</option>`
                );
            });

            $('#sub_category').trigger('change'); // trigger next level
        }

        function populateChildSubCategories(subCategoryId) {
            const filteredChildSubCategories = childSubCategories.filter(item => item.subcategory_id == subCategoryId);
            $('#child_sub_category').empty().append('<option value="">Select Child Sub Category</option>');

            filteredChildSubCategories.forEach(item => {
                $('#child_sub_category').append(
                    `<option value="${item.id}" ${item.id == selectedChildSubCategory ? 'selected' : ''}>${item.name}</option>`
                );
            });
        }

        // On Category change
        $('#category').change(function () {
            const categoryId = $(this).val();
            populateSubCategories(categoryId);
        });

        // On SubCategory change
        $('#sub_category').change(function () {
            const subCategoryId = $(this).val();
            populateChildSubCategories(subCategoryId);
        });

        // Trigger pre-selection if form submitted with values
        if ($('#category').val()) {
            populateSubCategories($('#category').val());
        }

        if ($('#sub_category').val()) {
            populateChildSubCategories($('#sub_category').val());
        }
    });
</script>


