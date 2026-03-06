@extends('admin.layouts.master')
@section('title', 'Slider Edit')
@section('content')
<main class="main" id="main">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Edit Slider</h4>
            <small class="text-muted">Dashboard / Sliders / Edit</small>
        </div>
        <a href="{{ route('admin.sliders.index') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fa fa-arrow-left me-2"></i>Back
        </a>
    </div>

    <div class="card">
        <div class="card-body p-4">
            <form action="{{ route('admin.sliders.update', $slider->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  id="slider-form">
                @csrf
                @method('PUT')

                <div class="row g-4">

                    {{-- Title --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Title</label>
                        <input type="text" name="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $slider->title) }}">
                        @error('title')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Subtitle --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Subtitle</label>
                        <input type="text" name="subtitle"
                               class="form-control @error('subtitle') is-invalid @enderror"
                               value="{{ old('subtitle', $slider->subtitle) }}">
                        @error('subtitle')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Button Text --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Button Text</label>
                        <input type="text" name="button_text"
                               class="form-control @error('button_text') is-invalid @enderror"
                               value="{{ old('button_text', $slider->button_text) }}">
                        @error('button_text')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Button Link --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Button Link</label>
                        <input type="url" name="button_link"
                               class="form-control @error('button_link') is-invalid @enderror"
                               value="{{ old('button_link', $slider->button_link) }}">
                        @error('button_link')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Position --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">Position</label>
                        <input type="number" name="position"
                               class="form-control @error('position') is-invalid @enderror"
                               value="{{ old('position', $slider->position) }}">
                        @error('position')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Status --}}
                    <div class="col-md-3">
                        <label class="form-label fw-semibold d-block">Status</label>
                        <div class="form-check form-switch mt-2">
                            <input class="form-check-input" type="checkbox" name="status" value="1"
                                   {{ $slider->status ? 'checked' : '' }}>
                            <label class="form-check-label text-success fw-semibold">
                                Active
                            </label>
                        </div>
                    </div>

                    {{-- Image --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Slider Image</label>
                        <input type="file" name="image" id="imageInput"
                               class="form-control @error('image') is-invalid @enderror"
                               accept="image/*">
                        @error('image')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror

                        <div class="mt-3">
                            @if($slider->image)
                                <img src="{{ asset($slider->image) }}"
                                     id="imagePreview"
                                     style="width:120px;height:70px;object-fit:none;border-radius:6px;"
                                     class="border shadow-sm">
                            @else
                                <img id="imagePreview"
                                     style="display:none;width:120px;height:70px;object-fit:none;"
                                     class="border shadow-sm">
                            @endif
                        </div>
                    </div>

                    {{-- Description --}}
                    <div class="col-md-12">
                        <label class="form-label fw-semibold">Description</label>
                        <textarea name="description" rows="4"
                                  class="form-control @error('description') is-invalid @enderror">{{ old('description', $slider->description) }}</textarea>
                        @error('description')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fa fa-save me-2"></i>Update Slider
                        </button>
                    </div>

                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
$(document).ready(function(){

    // Image Preview (Edit)
    $('#imageInput').on('change', function(){
        let reader = new FileReader();
        reader.onload = function(e){
            $('#imagePreview').attr('src', e.target.result).show();
        };
        reader.readAsDataURL(this.files[0]);
    });

    // jQuery Validation
    $('#slider-form').validate({
        rules: {
            button_link: { url: true },
            position: { number: true, min: 0 }
        },
        messages: {
            button_link: "Enter a valid URL",
            position: "Position must be a number"
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