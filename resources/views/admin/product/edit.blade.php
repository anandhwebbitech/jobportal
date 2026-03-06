@extends('admin.layouts.master')
@section('title', 'Product Edit')
@section('content')
    <main class="main" id="main">

        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Edit Product</h4>
                <small class="text-muted">Dashboard / Products / Edit</small>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn btn-primary rounded-pill px-4">
                <i class="fa fa-arrow-left me-2"></i>Back to Products
            </a>
        </div>

        <div class="gloss p-4">
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
                id="product-form">
                @csrf
                @method('PUT')

                <div class="row g-4">

                    <!-- Product Name -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Product Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $product->name) }}" placeholder="Enter product name">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>

                    <!-- Slug -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Slug <span class="text-danger">*</span></label>
                        <input type="text" name="slug" id="slug"
                            class="form-control @error('slug') is-invalid @enderror"
                            value="{{ old('slug', $product->slug) }}" placeholder="auto-generated-slug">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                    </div>

                    <!-- SKU -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">SKU</label>
                        <input type="text" name="sku" class="form-control" value="{{ old('sku', $product->sku) }}">
                        @error('sku')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Category -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Category <span class="text-danger">*</span></label>
                        <select name="category_id" id="category" class="form-select">
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
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
                        <label class="form-label fw-semibold">Subcategory <span class="text-danger">*</span></label>
                        <select name="sub_category_id" id="subcategory" class="form-select">
                            <option value="">Loading...</option>
                        </select>
                    </div>

                    <!-- Base Price -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Base Price <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="base_price" class="form-control"
                            value="{{ old('base_price', $product->base_price) }}">
                        @error('base_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Discount Price -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Discount Price</label>
                        <input type="number" step="0.01" name="discount_price" class="form-control"
                            value="{{ old('discount_price', $product->discount_price) }}">
                        @error('discount_price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Stock -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Stock <span class="text-danger">*</span></label>
                        <input type="number" name="stock" class="form-control"
                            value="{{ old('stock', $product->stock) }}">
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div class="col-md-3">
                        <label class="form-label fw-semibold d-block">Status</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="status" value="1"
                                {{ $product->status ? 'checked' : '' }}>
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
                                        value="{{ $color->id }}"
                                        {{ in_array($color->id, old('colors', $selectedColorIds ?? [])) ? 'checked' : '' }}>
                                    <label class="form-check-label">
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
                                        value="{{ $size->id }}"
                                        {{ in_array($size->id, old('sizes', $selectedSizeIds ?? [])) ? 'checked' : '' }}>
                                    <label class="form-check-label">
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
                        @error('thumbnail')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-3">
                            @if ($product->thumbnail)
                                <img src="{{ asset($product->thumbnail) }}" id="thumbPreview"
                                    style="width:90px;height:90px;object-fit:cover;" class="rounded shadow-sm" />
                            @else
                                <img id="thumbPreview" style="display:none;width:90px;height:90px;object-fit:cover;"
                                    class="rounded shadow-sm" />
                            @endif
                        </div>
                    </div>
                    <input type="hidden" id="existingImageCount" value="{{ $product->images->count() }}">

                    <!-- Gallery Images -->
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Add Gallery Images (Max 5, 1MB each)</label>
                        <input type="file" 
                            id="galleryInput"
                            name="images[]" 
                            class="form-control" 
                            multiple 
                            accept="image/*">

                        <small id="imageError" class="text-danger d-none mt-1"></small>
                    </div>

                    <!-- Existing + Preview Gallery -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Gallery</label>
                        <div id="galleryContainer" class="d-flex flex-wrap gap-3">

                            @foreach ($product->images as $img)
                                <div class="position-relative image-box existing" id="image-box-{{ $img->id }}">
                                    <button type="button"
                                            class="btn btn-sm btn-danger position-absolute top-0 end-0 delete-image"
                                            data-id="{{ $img->id }}"
                                            style="border-radius:50%; width:24px; height:24px; padding:0; z-index:10;">
                                        ×
                                    </button>

                                    <img src="{{ asset($img->image) }}"
                                        width="90"
                                        height="90"
                                        class="rounded border shadow-sm"
                                        style="object-fit:cover;">
                                </div>
                            @endforeach

                        </div>
                    </div>

                    <!-- Short Description -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Short Description</label>
                        <textarea name="short_description" id="short_description" class="form-control" rows="3">{!! old('short_description', $product->short_description) !!}</textarea>
                    </div>

                    <!-- Description -->
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Full Description</label>
                        <textarea name="description" id="description" class="form-control" rows="6">{!! old('description', $product->description) !!}</textarea>
                    </div>

                    <div class="col-12 mt-4 text-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fa fa-save me-2"></i>Update Product
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </main>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            let shortDescEditor;
            let descEditor;

            ClassicEditor.create(document.querySelector('#short_description'))
                .then(editor => {
                    shortDescEditor = editor;
                    editor.editing.view.change(writer => {
                        writer.setStyle('min-height', '200px', editor.editing.view.document.getRoot());
                    });
                });

            ClassicEditor.create(document.querySelector('#description'))
                .then(editor => {
                    descEditor = editor;
                    editor.editing.view.change(writer => {
                        writer.setStyle('min-height', '400px', editor.editing.view.document.getRoot());
                    });
                });

            $('#product-form').on('submit', function() {
                if (shortDescEditor) {
                    $('#short_description').val(shortDescEditor.getData());
                }
                if (descEditor) {
                    $('#description').val(descEditor.getData());
                }
            });

            // =========================
            // DISCOUNT CALCULATION
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
            calculateDiscount();

            // =========================
            // AUTO SLUG
            // =========================
            $('input[name="name"]').on('keyup', function() {
                let slug = $(this).val()
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)/g, '');
                $('#slug').val(slug);
            });

            // =========================
            // THUMBNAIL PREVIEW
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
                    $('#thumbPreview').attr('src', e.target.result).show();
                };
                reader.readAsDataURL(file);
            });

            // =========================
            // SUBCATEGORY LOAD
            // =========================
            let selectedSubcategory = "{{ $product->sub_category_id }}";
            let categoryId = "{{ $product->category_id }}";

            if (categoryId) {
                loadSubcategories(categoryId, selectedSubcategory);
            }

            $('#category').on('change', function() {
                loadSubcategories($(this).val(), null);
            });

            function loadSubcategories(categoryId, selectedId = null) {
                $('#subcategory').html('<option>Loading...</option>');
                if (categoryId) {
                    $.ajax({
                        url: "/admin/get-subcategories/" + categoryId,
                        type: "GET",
                        success: function(response) {
                            let options = '<option value="">Select Subcategory</option>';
                            $.each(response, function(key, value) {
                                let selected = (selectedId == value.id) ? 'selected' : '';
                                options += '<option value="' + value.id + '" ' + selected +
                                    '>' + value.name + '</option>';
                            });
                            $('#subcategory').html(options);
                        }
                    });
                }
            }

            // =====================================
            // GALLERY: MAX 5 IMAGES + 1MB + PREVIEW
            // =====================================

            let selectedFiles = [];
            const maxFiles = 5;
            const maxSize = 1024 * 1024; // 1MB

            function getExistingImageCount() {
                return $('#galleryContainer .image-box.existing').length;
            }

            function showImageError(message) {
                $('#imageError').removeClass('d-none').text(message);
            }

            function hideImageError() {
                $('#imageError').addClass('d-none').text('');
            }

            $('#galleryInput').on('change', function() {

                let files = Array.from(this.files);
                let existingCount = getExistingImageCount();

                // Clear old previews
                selectedFiles = [];
                $('#galleryContainer .image-box.preview').remove();
                hideImageError();

                // Check total image limit
                if ((existingCount + files.length) > maxFiles) {
                    showImageError('Maximum 5 images allowed (including existing images).');
                    $(this).val('');
                    return;
                }

                files.forEach((file, index) => {

                    // File size validation (1MB)
                    if (file.size > maxSize) {
                        showImageError('Each image must be less than 1MB.');
                        return;
                    }

                    // File type validation
                    if (!file.type.startsWith('image/')) {
                        showImageError('Only image files are allowed.');
                        return;
                    }

                    selectedFiles.push(file);

                    let reader = new FileReader();
                    reader.onload = function(e) {

                        let previewHtml = `
                    <div class="position-relative image-box preview" data-index="${selectedFiles.length - 1}">
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

                        $('#galleryContainer').append(previewHtml);
                    };

                    reader.readAsDataURL(file);
                });

                updateFileInput();
            });

            // Remove preview AND remove file from input
            $(document).on('click', '.remove-preview', function() {

                let previewBox = $(this).closest('.image-box');
                let removeIndex = previewBox.data('index');

                // Remove from array
                selectedFiles.splice(removeIndex, 1);

                // Remove UI
                previewBox.remove();

                // Re-index previews
                $('#galleryContainer .image-box.preview').each(function(i) {
                    $(this).attr('data-index', i);
                });

                updateFileInput();
                hideImageError();
            });

            // Sync selected files with input
            function updateFileInput() {
                let dataTransfer = new DataTransfer();
                selectedFiles.forEach(file => {
                    dataTransfer.items.add(file);
                });
                document.getElementById('galleryInput').files = dataTransfer.files;
            }

            // =========================
            // DELETE EXISTING IMAGE AJAX
            // =========================
            $(document).on('click', '.delete-image', function() {

                let imageId = $(this).data('id');
                let imageBox = $('#image-box-' + imageId);

                if (confirm('Are you sure you want to delete this image?')) {

                    $.ajax({
                        url: "{{ route('admin.products.image.delete', ':id') }}".replace(':id',
                            imageId),
                        type: "DELETE",
                        data: {
                            _token: "{{ csrf_token() }}"
                        },
                        success: function(response) {
                            if (response.success) {
                                imageBox.fadeOut(300, function() {
                                    $(this).closest('.image-box').remove();
                                });
                            }
                        },
                        error: function() {
                            alert('Error deleting image.');
                        }
                    });
                }
            });
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
