@extends('admin.layouts.master')
@section('title', 'Create Category')
@section('content')
<main class="main" id="main">
    <!-- Top Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Create Category</h4>
            <small class="text-muted">Dashboard / Categories / Create</small>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fa fa-arrow-left me-2"></i>Back to Categories
        </a>
    </div>

    <!-- Category Create Form Card -->
    <div class="gloss p-4">
        <form action="{{ route('admin.categories.store') }}" method="POST" enctype="multipart/form-data" id="category-form">
            @csrf

            <div class="row g-4">
                <!-- Category Name -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Enter category name (e.g. Electronics)"
                           value="{{ old('name') }}">
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Slug -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Slug</label>
                    <input type="text"
                        name="slug"
                        id="slug"
                        class="form-control @error('slug') is-invalid @enderror"
                        placeholder="auto-generated-slug"
                        value="{{ old('slug') }}">

                    @error('slug')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Parent Category -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Parent Category</label>
                    <select name="parent_id" class="form-select">
                        <option value="">🏷 Main Category</option>
                        @foreach($parents ?? [] as $parent)
                            <option value="{{ $parent->id }}"
                                {{ old('parent_id') == $parent->id ? 'selected' : '' }}>
                                {{ $parent->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Status Toggle -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold d-block">Category Status</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input"
                               type="checkbox"
                               name="status"
                               value="1"
                               checked>
                        <label class="form-check-label fw-semibold text-success">
                            Active Category
                        </label>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Category Image</label>
                    <input type="file"
                           name="image"
                           class="form-control @error('image') is-invalid @enderror"
                           accept="image/*"
                           onchange="previewImage(event)">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <div class="mt-3">
                        <img id="imagePreview"
                             src="#"
                             alt="Preview"
                             class="rounded shadow-sm"
                             style="display:none; width:90px; height:90px; object-fit:cover;">
                    </div>
                </div>

                <!-- Description -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description"
                              class="form-control"
                              rows="4"
                              placeholder="Enter category description (SEO & details)">{{ old('description') }}</textarea>
                </div>

                <!-- SEO Section -->
                {{-- <div class="col-12">
                    <hr>
                    <h6 class="fw-semibold text-muted mb-3">
                        <i class="fa fa-search me-2"></i>SEO Settings (Optional)
                    </h6>
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Meta Title</label>
                    <input type="text"
                           name="meta_title"
                           class="form-control"
                           placeholder="SEO title for Google"
                           value="{{ old('meta_title') }}">
                </div>

                <div class="col-md-6">
                    <label class="form-label fw-semibold">Meta Description</label>
                    <input type="text"
                           name="meta_description"
                           class="form-control"
                           placeholder="Short SEO description"
                           value="{{ old('meta_description') }}">
                </div> --}}

                <!-- Buttons -->
                <div class="col-12 mt-5 ">
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fa fa-save me-2"></i>Save Category
                        </button>

                        <a href="{{ route('admin.categories.index') }}"
                           class="btn btn-danger rounded-pill px-4">
                            Cancel
                        </a>
                    </div>
                </div>

            </div>
        </form>
    </div>

</main>

    @push('scripts')
        <script>
            // Auto slug generation (dashboard friendly)
            document.querySelector('input[name="name"]').addEventListener('keyup', function () {
                let slug = this.value
                    .toLowerCase()
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)/g, '');
                document.getElementById('slug').value = slug;
            });

            // Image Preview
            function previewImage(event) {
                const reader = new FileReader();
                reader.onload = function(){
                    const output = document.getElementById('imagePreview');
                    output.src = reader.result;
                    output.style.display = 'block';
                }
                reader.readAsDataURL(event.target.files[0]);
            }
        </script>
        <script>
            $(document).ready(function() {
                $('#category-form').validate({
                    ignore: [],

                    rules: {
                        name: { required: true, maxlength: 255 },
                        slug: { required: true, maxlength: 255 },
                    },

                    messages: {
                        slug: { required: "Please enter slug" },
                        name: { required: "Please enter name" }
                    },

                    errorClass: 'text-danger',
                    errorElement: 'div',

                    errorPlacement: function (error, element) {
                        if (element.attr("id") === "body_content") {
                            error.insertAfter($('.banner-editor .ck-editor'));
                        } 
                        else if (element.attr("id") === "page_content") {
                            error.insertAfter($('.page-editor .ck-editor'));
                        } 
                        else {
                            error.insertAfter(element);
                        }
                    },

                    highlight: function (element) {
                        $(element).addClass('is-invalid');
                    },

                    unhighlight: function (element) {
                        $(element).removeClass('is-invalid');
                    },

                    submitHandler: function (form) {
                        // Sync CKEditor → textarea
                        $('#body_content').val(bannerEditor.getData());
                        $('#page_content').val(pageEditor.getData());

                        // Extra safety: block empty HTML
                        if (!bannerEditor.getData().trim()) {
                            alert('Paragraph Content is required');
                            return false;
                        }

                        if (!pageEditor.getData().trim()) {
                            alert('Page Content is required');
                            return false;
                        }

                        form.submit();
                    }
                });
            });
        </script>
    @endpush
@endsection