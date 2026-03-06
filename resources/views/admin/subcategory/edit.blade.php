@extends('admin.layouts.master')
@section('title', 'Sub Category Edit')
@section('content')
<main class="main" id="main">

    <!-- Top Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Edit Sub Category</h4>
            <small class="text-muted">Dashboard / Sub Categories / Edit</small>
        </div>
        <a href="{{ route('admin.subcategories.index') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fa fa-arrow-left me-2"></i>Back to Sub Categories
        </a>
    </div>

    <!-- Edit Form -->
    <div class="gloss p-4">
        <form action="{{ route('admin.subcategories.update', $subcategory->id) }}"
              method="POST"
              enctype="multipart/form-data"
              id="subcategory-form">
            @csrf
            @method('PUT')

            <div class="row g-4">

                <!-- Category Select -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Parent Category <span class="text-danger">*</span>
                    </label>
                    <select name="category_id"
                            class="form-select @error('category_id') is-invalid @enderror">
                        <option value="">Select Category</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id', $subcategory->category_id) == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Subcategory Name -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Sub Category Name <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $subcategory->name) }}">
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
                           value="{{ old('slug', $subcategory->slug) }}">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold d-block">Status</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input"
                               type="checkbox"
                               name="status"
                               value="1"
                               {{ old('status', $subcategory->status) ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold text-success">
                            Active Sub Category
                        </label>
                    </div>
                </div>

                <!-- Image Upload -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Sub Category Image</label>
                    <input type="file"
                           name="image"
                           class="form-control @error('image') is-invalid @enderror"
                           accept="image/*"
                           onchange="previewImage(event)">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror

                    <!-- Old Image -->
                    @if($subcategory->image)
                        <div class="mt-3">
                            <p class="mb-1 fw-semibold">Current Image:</p>
                            <img src="{{ asset($subcategory->image) }}"
                                 class="rounded shadow-sm"
                                 style="width:90px;height:90px;object-fit:cover;">
                        </div>
                    @endif

                    <!-- Preview New -->
                    <div class="mt-3">
                        <img id="imagePreview"
                             src="#"
                             style="display:none;width:90px;height:90px;object-fit:cover;"
                             class="rounded shadow-sm">
                    </div>
                </div>

                <!-- Description -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description"
                              class="form-control"
                              rows="4">{{ old('description', $subcategory->description) }}</textarea>
                </div>

                <!-- Buttons -->
                <div class="col-12 mt-5">
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-success rounded-pill px-4">
                            <i class="fa fa-save me-2"></i>Update Sub Category
                        </button>

                        <a href="{{ route('admin.subcategories.index') }}"
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
    // Auto slug
    document.querySelector('input[name="name"]').addEventListener('keyup', function () {
        let slug = this.value
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)/g, '');
        document.getElementById('slug').value = slug;
    });

    // Image preview
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function(){
            const output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = 'block';
        }
        reader.readAsDataURL(event.target.files[0]);
    }

    // jQuery Validation
    $(document).ready(function() {
        $('#subcategory-form').validate({
            rules: {
                category_id: { required: true },
                name: { required: true, maxlength: 255 },
                slug: { required: true, maxlength: 255 },
            },
            messages: {
                category_id: "Please select category",
                name: "Please enter sub category name",
                slug: "Please enter slug"
            },
            errorClass: 'text-danger',
            errorElement: 'div',
            highlight: function (element) {
                $(element).addClass('is-invalid');
            },
            unhighlight: function (element) {
                $(element).removeClass('is-invalid');
            }
        });
    });
</script>
@endpush
@endsection