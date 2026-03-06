@extends('admin.layouts.master')
@section('title', 'Products List')
@section('content')
<main class="main" id="main">
    
    <div class="row g-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Products</h2>
            <div>
                <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                    + Add Product
                </a>
            </div>
        </div>
        
        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped align-middle" id="product-table">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Name</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Price</th>
                            <th>Stock</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>
    </div>

</main>
@endsection

@push('scripts')
<script>
$(function () {

    // =========================
    // DataTable
    // =========================
    let table = $('#product-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.products.index') }}',
        columns: [
            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },
            {
                data: 'thumbnail',
                name: 'thumbnail',
                orderable: false,
                searchable: false
            },
            {
                data: 'name',
                name: 'name'
            },
            {
                data: 'category',
                name: 'category.name'
            },
            {
                data: 'subcategory',
                name: 'subcategory.name'
            },
            {
                data: 'base_price',
                name: 'base_price'
            },
            {
                data: 'stock',
                name: 'stock'
            },
            {
                data: 'status',
                name: 'status',
                orderable: false,
                searchable: false
            },
            {
                data: 'action',
                name: 'action',
                orderable: false,
                searchable: false
            }
        ]
    });


    // =========================
    // Delete Product (AJAX)
    // =========================
    $(document).on('click', '.delete', function () {

        let route = $(this).data('route');

        if (confirm("Are you sure you want to delete this product?")) {

            $.ajax({
                url: route,
                type: "DELETE",
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function (response) {
                    if (response.status) {
                        table.ajax.reload();
                    }
                }
            });

        }

    });

});
</script>
@endpush