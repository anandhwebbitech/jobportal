@extends('admin.layouts.master')
@section('title', 'Education List')

@section('content')

<main class="main" id="main">

    <div class="row g-4 mb-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Education List</h2>

            <div>
                <a href="javascript:void(0);"
                   data-title="Add Education"
                   data-size="modal-lg"
                   data-route="{{ route('admin.educations.create') }}"
                   class="btn btn-primary common_model">

                   + Add Education

                </a>
            </div>
        </div>

        <div class="card">
            <div class="card-body table-responsive">

                <table class="table table-bordered table-striped align-middle" id="education-table">

                    <thead class="table-dark">

                        <tr>
                            <th>#</th>
                            <th>Level of Education</th>
                            <th>Field of Study</th>
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

    $('#education-table').DataTable({

        processing: true,
        serverSide: true,

        ajax: '{{ route('admin.educations.index') }}',

        columns: [

            {
                data: 'DT_RowIndex',
                name: 'DT_RowIndex',
                orderable: false,
                searchable: false,
                className: 'text-center'
            },

            {
                data: 'level_of_education',
                name: 'level_of_education'
            },

            {
                data: 'field_of_study',
                name: 'field_of_study'
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