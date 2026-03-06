@extends('admin.layouts.master')
@section('title', 'Product Create')
@section('content')
    <main class="main" id="main">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Create Product</h4>
                <small class="text-muted">Dashboard / Products / Create</small>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-primary rounded-pill px-4">
                <i class="fa fa-arrow-left me-2"></i>Back to Products
            </a>
        </div>

        <div class="gloss p-4">
            <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row g-4">

                    <!-- Product Name -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Product Name *</label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name') }}" placeholder="Enter product name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Slug -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Slug *</label>
                        <input type="text" name="slug" class="form-control @error('slug') is-invalid @enderror"
                            value="{{ old('slug') }}" placeholder="auto-generated-slug">
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- SKU -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">SKU</label>
                        <input type="text" name="sku" class="form-control" value="{{ old('sku') }}"
                            placeholder="Enter SKU">
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category *</label>
                        <select name="category_id" class="form-select @error('category_id') is-invalid @enderror">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Subcategory -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Subcategory *</label>
                        <select name="sub_category_id" class="form-select @error('sub_category_id') is-invalid @enderror">
                            <option value="">Select Subcategory</option>
                            @foreach ($subcategories as $subcategory)
                                <option value="{{ $subcategory->id }}"
                                    {{ old('sub_category_id') == $subcategory->id ? 'selected' : '' }}>
                                    {{ $subcategory->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('sub_category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Base Price -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Base Price *</label>
                        <input type="number" step="0.01" name="base_price"
                            class="form-control @error('base_price') is-invalid @enderror" value="{{ old('base_price') }}"
                            placeholder="0.00">
                        @error('base_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Discount Price -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Discount Price</label>
                        <input type="number" step="0.01" name="discount_price" class="form-control"
                            value="{{ old('discount_price') }}" placeholder="0.00">
                    </div>

                    <!-- Stock -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Stock *</label>
                        <input type="number" name="stock" class="form-control @error('stock') is-invalid @enderror"
                            value="{{ old('stock') }}" placeholder="Enter stock">
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold d-block">Status</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="status" value="1"
                                {{ old('status', 1) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-success">
                                Active Product
                            </label>
                        </div>
                    </div>

                    <!-- Colors -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Colors</label>
                        <div class="border rounded p-3" style="max-height:150px; overflow-y:auto;">
                            @foreach ($colors as $color)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="colors[]"
                                        value="{{ $color->id }}" id="color{{ $color->id }}"
                                        {{ in_array($color->id, old('colors', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="color{{ $color->id }}">
                                        {{ $color->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Sizes -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Sizes</label>
                        <div class="border rounded p-3" style="max-height:150px; overflow-y:auto;">
                            @foreach ($sizes as $size)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="sizes[]"
                                        value="{{ $size->id }}" id="size{{ $size->id }}"
                                        {{ in_array($size->id, old('sizes', [])) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="size{{ $size->id }}">
                                        {{ $size->name }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Thumbnail -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Thumbnail Image</label>
                        <input type="file" name="thumbnail" class="form-control" accept="image/*">
                        <div class="mt-3">
                            <img id="thumbPreview" style="display:none;width:90px;height:90px;object-fit:cover;"
                                class="rounded shadow-sm" />
                        </div>
                    </div>

                    <!-- Gallery Images -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Gallery Images</label>
                        <input type="file" id="galleryInput" name="images[]" multiple accept="image/*" class="form-control">
                        <small id="imageError" class="text-danger d-none"></small>
                    </div>

                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Gallery</label>
                        <div id="galleryPreviewContainer" class="d-flex flex-wrap gap-3 mt-2">
                        </div>
                    </div>
                    <!-- Short Description -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Short Description</label>
                        <textarea name="short_description" id="short_description" class="form-control" rows="3">{!! old('short_description') !!}</textarea>
                    </div>

                    <!-- Description -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Full Description</label>
                        <textarea name="description" id="description" class="form-control" rows="6">{!! old('description') !!}</textarea>
                    </div>

                    <!-- Buttons -->
                    <div class="col-12 mt-4 text-end">
                        <button type="submit" class="btn btn-primary px-4">
                            Save Product
                        </button>

                        <a href="{{ route('admin.products.index') }}" class="btn btn-danger px-4">
                            Cancel
                        </a>
                    </div>

                </div>
            </form>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            // =========================
            // CKEditor Init (Same as Edit)
            // =========================
            let shortDescEditor;
            let descEditor;

            ClassicEditor
                .create(document.querySelector('#short_description'), {
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'underline', '|',
                        'bulletedList', 'numberedList', '|',
                        'link', 'undo', 'redo'
                    ]
                })
                .then(editor => {
                    shortDescEditor = editor;
                    editor.editing.view.change(writer => {
                        writer.setStyle(
                            'min-height',
                            '200px',
                            editor.editing.view.document.getRoot()
                        );
                    });
                })
                .catch(error => console.error(error));

            ClassicEditor
                .create(document.querySelector('#description'), {
                    toolbar: [
                        'heading', '|',
                        'bold', 'italic', 'underline', 'strikethrough', '|',
                        'bulletedList', 'numberedList', '|',
                        'link', 'blockQuote', 'insertTable', '|',
                        'undo', 'redo'
                    ]
                })
                .then(editor => {
                    descEditor = editor;
                    editor.editing.view.change(writer => {
                        writer.setStyle(
                            'min-height',
                            '400px',
                            editor.editing.view.document.getRoot()
                        );
                    });
                })
                .catch(error => console.error(error));

            // =========================
            // Sync CKEditor before submit
            // =========================
            $('#product-form').on('submit', function() {
                if (shortDescEditor) {
                    $('#short_description').val(shortDescEditor.getData());
                }
                if (descEditor) {
                    $('#description').val(descEditor.getData());
                }
            });

            // =========================
            // Auto Slug Generator
            // =========================
            $('input[name="name"]').on('keyup', function() {
                let slug = $(this).val()
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)/g, '');

                $('#slug').val(slug);
            });

            // =========================
            // Thumbnail Preview + 1MB Limit
            // =========================
            $('input[name="thumbnail"]').on('change', function() {
                let file = this.files[0];
                if (!file) return;

                // 1MB validation
                if (file.size > 1024 * 1024) {
                    alert('Thumbnail must be less than 1MB');
                    $(this).val('');
                    return;
                }

                let reader = new FileReader();
                reader.onload = function(e) {
                    $('#thumbPreview')
                        .attr('src', e.target.result)
                        .show();
                };
                reader.readAsDataURL(file);
            });

            // =========================
            // Dynamic Subcategory Load
            // =========================
            $('#category').on('change', function() {

                let categoryId = $(this).val();
                $('#subcategory').html('<option value="">Loading...</option>');

                if (categoryId) {
                    $.ajax({
                        url: "/admin/get-subcategories/" + categoryId,
                        type: "GET",
                        success: function(response) {

                            let options = '<option value="">Select Subcategory</option>';

                            $.each(response, function(key, value) {
                                options += '<option value="' + value.id + '">' + value
                                    .name + '</option>';
                            });

                            $('#subcategory').html(options);
                        }
                    });
                } else {
                    $('#subcategory').html('<option value="">Select Subcategory</option>');
                }
            });

            // =========================
            // Auto Discount Calculation
            // =========================
            function calculateDiscount() {
                let base = parseFloat($('input[name="base_price"]').val());
                let discount = parseFloat($('input[name="discount_price"]').val());

                if (base > 0 && discount > 0 && discount < base) {

                    let percentage = ((base - discount) / base) * 100;
                    percentage = percentage.toFixed(2);

                    if ($('#discountPercentage').length === 0) {
                        $('<small id="discountPercentage" class="text-success fw-bold d-block mt-1"></small>')
                            .insertAfter('input[name="discount_price"]');
                    }

                    $('#discountPercentage').text("Discount: " + percentage + "%");

                } else {
                    $('#discountPercentage').remove();
                }
            }

            $('input[name="base_price"], input[name="discount_price"]').on('keyup', calculateDiscount);

            // =========================
            // GALLERY: MAX 5 IMAGES + 1MB + PREVIEW
            // =========================
            let selectedFiles = [];
            const maxFiles = 5;
            const maxSize = 1024 * 1024; // 1MB

            $('#galleryInput').on('change', function() {

                let files = Array.from(this.files);

                // Reset previews
                selectedFiles = [];
                $('#galleryPreviewContainer').html('');
                $('#imageError').addClass('d-none').text('');

                if (files.length > maxFiles) {
                    $('#imageError')
                        .removeClass('d-none')
                        .text('Maximum 5 images allowed.');
                    $(this).val('');
                    return;
                }

                files.forEach((file, index) => {

                    // File size validation (1MB)
                    if (file.size > maxSize) {
                        $('#imageError')
                            .removeClass('d-none')
                            .text('Each image must be less than 1MB.');
                        return;
                    }

                    // File type validation
                    if (!file.type.startsWith('image/')) {
                        $('#imageError')
                            .removeClass('d-none')
                            .text('Only image files are allowed.');
                        return;
                    }

                    selectedFiles.push(file);

                    let reader = new FileReader();
                    reader.onload = function(e) {

                        let previewHtml = `
                    <div class="position-relative image-box preview" data-index="${index}">
                        <button type="button"
                                class="btn btn-sm btn-danger position-absolute top-0 end-0 remove-preview"
                                style="border-radius:50%; width:24px; height:24px; padding:0; z-index:10;">
                            ×
                        </button>

                        <img src="${e.target.result}"
                             width="90"
                             height="90"
                             class="rounded border shadow-sm"
                             style="object-fit:cover;">
                    </div>
                `;

                        $('#galleryPreviewContainer').append(previewHtml);
                    };

                    reader.readAsDataURL(file);
                });

                updateFileInput();
            });

            // Remove preview & update input files
            $(document).on('click', '.remove-preview', function() {

                let previewBox = $(this).closest('.image-box');
                let index = previewBox.data('index');

                selectedFiles.splice(index, 1);
                previewBox.remove();

                // Re-index
                $('#galleryPreviewContainer .image-box').each(function(i) {
                    $(this).attr('data-index', i);
                });

                updateFileInput();
            });

            function updateFileInput() {
                let dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });
                document.getElementById('galleryInput').files = dataTransfer.files;
            }

            // =========================
            // jQuery Validation (Same as Edit)
            // =========================
            $('#product-form').validate({
                ignore: [],
                rules: {
                    name: {
                        required: true,
                        maxlength: 255
                    },
                    slug: {
                        required: true,
                        maxlength: 255
                    },
                    category_id: {
                        required: true
                    },
                    sub_category_id: {
                        required: true
                    },
                    base_price: {
                        required: true,
                        number: true
                    },
                    stock: {
                        required: true,
                        digits: true
                    }
                },
                messages: {
                    name: "Please enter product name",
                    slug: "Slug is required",
                    category_id: "Please select category",
                    sub_category_id: "Please select subcategory",
                    base_price: "Enter valid base price",
                    stock: "Enter valid stock"
                },
                errorClass: 'text-danger',
                errorElement: 'div',
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });

        });
    </script>
@endpush
