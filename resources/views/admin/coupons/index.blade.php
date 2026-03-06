@extends('admin.layouts.master')
@section('title', 'Coupon List')
@section('content')
<main class="main" id="main">

    <div class="row g-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Coupons</h2>
            <div>
                <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">+ Add Coupon</a>
            </div>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped align-middle" id="coupon-table">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Code</th>
                            <th>Type</th>
                            <th>Value</th>
                            <th>Usage Limit</th>
                            <th>Min Order</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Status</th>
                            <th width="180">Action</th>
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
    $(function() {
        // Initialize DataTable
        var table = $('#coupon-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.coupons.index') }}',
            columns: [
                {
                    data: 'DT_RowIndex', 
                    name: 'DT_RowIndex', 
                    orderable: false,
                    searchable: false, 
                    className: 'text-center'
                },
                { data: 'code', name: 'code' },
                { data: 'type', name: 'type' },
                { data: 'value', name: 'value' },
                { data: 'usage_limit', name: 'usage_limit' },
                { data: 'minimum_order_amount', name: 'minimum_order_amount' },
                { data: 'start_date', name: 'start_date' },
                { data: 'end_date', name: 'end_date' },
                { data: 'status', name: 'status', orderable: false, searchable: false },
                { data: 'action', name: 'action', orderable: false, searchable: false },
            ]
        });
    });
</script>
@endpush