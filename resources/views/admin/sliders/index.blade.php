@extends('admin.layouts.master')
@section('title', 'Slider List')
@section('content')
    <main class="main" id="main">

        <div class="row g-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Slider List</h2>
                <div>
                    <a href="{{ route('admin.sliders.create') }}" 
                       data-title="Add Slider" 
                       data-size="modal-lg"
                       data-route="{{ route('admin.sliders.create') }}"
                       class="btn btn-primary">
                        + Add Slider
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="slider-table">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Position</th>
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

        $('#slider-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.sliders.index') }}',
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'image',
                    name: 'image',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'title',
                    name: 'title'
                },
                {
                    data: 'position',
                    name: 'position',
                    className: 'text-center'
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