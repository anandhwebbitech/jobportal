@extends('admin.layouts.master')
@section('title', 'Inventory Edit')
@section('content')
<main class="main">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-0">Update Stock</h4>
            <small class="text-muted">Dashboard / Inventory / Update</small>
        </div>

        <a href="{{ route('admin.inventory.index') }}" class="btn btn-primary rounded-pill px-4">
            <i class="fa fa-arrow-left me-2"></i>Back
        </a>
    </div>

    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.inventory.update', $product->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">

                    {{-- Product Name --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Product Name</label>
                        <input type="text" class="form-control" 
                               value="{{ $product->name }}" readonly>
                    </div>

                    {{-- SKU --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">SKU</label>
                        <input type="text" class="form-control" 
                               value="{{ $product->sku }}" readonly>
                    </div>

                    {{-- Current Stock --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">
                            Stock Quantity <span class="text-danger">*</span>
                        </label>

                        <input type="number" 
                               name="stock" 
                               class="form-control @error('stock') is-invalid @enderror"
                               value="{{ old('stock', $product->stock) }}"
                               min="0">

                        @error('stock')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    {{-- Stock Status Preview --}}
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Current Status</label>
                        <div class="mt-2">
                            @if($product->stock > 0)
                                <span class="badge bg-success">In Stock</span>
                            @else
                                <span class="badge bg-danger">Out of Stock</span>
                            @endif
                        </div>
                    </div>

                </div>

                <div class="mt-4 text-end">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fa fa-save me-2"></i>Update Stock
                    </button>
                </div>

            </form>

        </div>
    </div>

</main>
@endsection