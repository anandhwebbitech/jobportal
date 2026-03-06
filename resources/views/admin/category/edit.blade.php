@extends('admin.layouts.master')
@section('title', 'Edit Category')
@section('content')
<main class="main" id="main">
    <!-- Top Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Edit Category</h4>
            <small class="text-muted">Dashboard / Categories / Edit</small>
        </div>
        <a href="{{ route('admin.categories.index') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fa fa-arrow-left me-2"></i>Back to Categories
        </a>
    </div>

    <!-- Category Edit Form Card -->
    <div class="gloss p-4">
        <form action="{{ route('admin.categories.update', $category->id) }}" 
              method="POST" 
              enctype="multipart/form-data" 
              id="category-form">
            @csrf
            @method('PUT')

            <div class="row g-4">

                <!-- Category Name -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Category Name <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           placeholder="Enter category name (e.g. Electronics)"
                           value="{{ old('name', $category->name) }}">
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
                           value="{{ old('slug', $category->slug) }}">
                    @error('slug')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Parent Category -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Parent Category</label>
                    <select name="parent_id" class="form-select">
                        <option value="">🏷 Main Category</option>
                        @foreach($parents ?? [] as $parent)
                            <option value="{{ $parent->id }}"
                                {{ old('parent_id', $category->parent_id) == $parent->id ? 'selected' : '' }}>
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
                               {{ old('status', $category->status) ? 'checked' : '' }}>
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

                    <!-- Old Image Preview -->
                    <div class="mt-3">
                        @if($category->image)
                            <img id="imagePreview"
                                 src="{{ asset($category->image) }}"
                                 alt="Category Image"
                                 class="rounded shadow-sm"
                                 style="width:90px; height:90px; object-fit:cover;">
                        @else
                            <img id="imagePreview"
                                 src="#"
                                 alt="Preview"
                                 class="rounded shadow-sm"
                                 style="display:none; width:90px; height:90px; object-fit:cover;">
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="col-md-12">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description"
                              class="form-control @error('description') is-invalid @enderror"
                              rows="4"
                              placeholder="Enter category description">{{ old('description', $category->description) }}</textarea>
                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Buttons -->
                <div class="col-12 mt-5">
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fa fa-save me-2"></i>Update Category
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
    // Auto slug generation (only if slug is empty or user edits name)
    document.querySelector('input[name="name"]').addEventListener('keyup', function () {
        let slugInput = document.getElementById('slug');
        if (!slugInput.dataset.manual) {
            let slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9]+/g, '-')
                .replace(/(^-|-$)/g, '');
            slugInput.value = slug;
        }
    });

    // Detect manual slug edit
    document.getElementById('slug').addEventListener('input', function () {
        this.dataset.manual = true;
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
@endpush
@endsection