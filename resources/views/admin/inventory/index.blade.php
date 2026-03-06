@extends('admin.layouts.master')
@section('title', 'Inventory List')
@section('content')
<main class="main">

    <div class="row g-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Inventory List</h2>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped align-middle" id="inventory-table">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Product Name</th>
                            <th>SKU</th>
                            <th>Stock Qty</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>

    </div>

</main>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    $('#inventory-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route("admin.inventory.index") }}',
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center' },
            { data: 'name', name: 'name' },
            { data: 'sku', name: 'sku' },
            { data: 'stock', name: 'stock' },
            { data: 'status', name: 'status', orderable: false, searchable: false },
            { data: 'action', name: 'action', orderable: false, searchable: false },
        ]
    });
});
</script>
@endpush