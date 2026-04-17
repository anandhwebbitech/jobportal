@extends('admin.layouts.master')
@section('title', 'Locations List')

@section('content')

<main class="main" id="main">

    <div class="row g-4 mb-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Location List</h2>

            <div>
                <a href="javascript:void(0);"
                   data-title="Add Location"
                   data-size="modal-lg"
                   data-route="{{ route('admin.locations.create') }}"
                   class="btn btn-primary common_model">

                   + Add Location

                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body table-responsive">

                <table class="table table-bordered table-striped align-middle" id="location-table">

                    <thead class="table-dark">

                        <tr>
                            <th>#</th>
                            <th>State</th>
                            <th>District</th>
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

$(function(){

    $('#location-table').DataTable({

        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.locations.index') }}',
        order: [[1, 'asc']],
        columns: [

            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },

            {
                data: 'state',
                name: 'state'
            },

            {
                data: 'district',
                name: 'district'
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

});

</script>

@endpush