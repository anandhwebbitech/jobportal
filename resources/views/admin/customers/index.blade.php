@extends('admin.layouts.master')
@section('title', 'Users List')
@section('content')
<main class="main" id="main">

    <div class="row g-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Users</h2>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped align-middle" id="user-table">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Status</th>
                            <th>Registered At</th>
                            <th width="150">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</main>
@endsection


@push('scripts')
<script>
$(function () {
    $('#user-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.users.index') }}',
        columns: [
            { data: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'name', name: 'name' },
            { data: 'email', name: 'email' },
            { data: 'status', orderable: false, searchable: false },
            { data: 'created_at', name: 'created_at' },
            { data: 'action', orderable: false, searchable: false }
        ]
    });
});
</script>
@endpush