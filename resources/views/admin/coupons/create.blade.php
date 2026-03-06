@extends('admin.layouts.master')
@section('title', 'Coupon Create')
@section('content')
<main class="main" id="main">

    <!-- Top Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Create Coupon</h4>
            <small class="text-muted">Dashboard / Coupons / Create</small>
        </div>
        <a href="{{ route('admin.coupons.index') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fa fa-arrow-left me-2"></i>Back to Coupons
        </a>
    </div>

    <!-- Coupon Create Form Card -->
    <div class="gloss p-4">
        <form action="{{ route('admin.coupons.store') }}" method="POST" id="coupon-form">
            @csrf

            <div class="row g-4">

                <!-- Coupon Code -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Coupon Code <span class="text-danger">*</span></label>
                    <input type="text"
                           name="code"
                           class="form-control @error('code') is-invalid @enderror"
                           placeholder="Enter coupon code (e.g. SAVE10)"
                           value="{{ old('code') }}">
                    @error('code')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Coupon Type -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Discount Type <span class="text-danger">*</span></label>
                    <select name="type" class="form-select @error('type') is-invalid @enderror">
                        <option value="">Select Type</option>
                        <option value="fixed" {{ old('type') == 'fixed' ? 'selected' : '' }}>Fixed Amount</option>
                        <option value="percent" {{ old('type') == 'percent' ? 'selected' : '' }}>Percentage (%)</option>
                    </select>
                    @error('type')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Discount Value -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Discount Value <span class="text-danger">*</span></label>
                    <input type="number"
                           step="0.01"
                           name="value"
                           class="form-control @error('value') is-invalid @enderror"
                           placeholder="Enter discount value"
                           value="{{ old('value') }}">
                    @error('value')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Usage Limit -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Usage Limit</label>
                    <input type="number"
                           name="usage_limit"
                           class="form-control @error('usage_limit') is-invalid @enderror"
                           placeholder="Leave empty for unlimited"
                           value="{{ old('usage_limit') }}">
                    @error('usage_limit')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Minimum Order Amount -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold">Minimum Order Amount</label>
                    <input type="number"
                           step="0.01"
                           name="minimum_order_amount"
                           class="form-control @error('minimum_order_amount') is-invalid @enderror"
                           placeholder="Minimum cart value required"
                           value="{{ old('minimum_order_amount') }}">
                    @error('minimum_order_amount')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Start Date -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Start Date</label>
                    <input type="date"
                           name="start_date"
                           class="form-control @error('start_date') is-invalid @enderror"
                           value="{{ old('start_date') }}">
                    @error('start_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- End Date -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">End Date</label>
                    <input type="date"
                           name="end_date"
                           class="form-control @error('end_date') is-invalid @enderror"
                           value="{{ old('end_date') }}">
                    @error('end_date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status Toggle -->
                <div class="col-md-6">
                    <label class="form-label fw-semibold d-block">Coupon Status</label>
                    <div class="form-check form-switch mt-2">
                        <input class="form-check-input"
                               type="checkbox"
                               name="status"
                               value="1"
                               checked>
                        <label class="form-check-label fw-semibold text-success">
                            Active Coupon
                        </label>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="col-12 mt-5">
                    <div class="d-flex gap-2 justify-content-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-4">
                            <i class="fa fa-save me-2"></i>Save Coupon
                        </button>

                        <a href="{{ route('admin.coupons.index') }}"
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
    $(document).ready(function() {
        $('#coupon-form').validate({
            rules: {
                code: { required: true, maxlength: 50 },
                type: { required: true },
                value: { required: true, number: true }
            },
            messages: {
                code: { required: "Please enter coupon code" },
                type: { required: "Please select discount type" },
                value: { required: "Please enter discount value" }
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