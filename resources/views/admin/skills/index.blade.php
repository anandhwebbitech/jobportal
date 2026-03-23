@extends('admin.layouts.master')
@section('title', 'Skill List')
@section('content')
    <main class="main" id="main">
        
        <div class="row g-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Skill List</h2>
                <div>
                    <a href="javascript:void(0);" data-title="Add Skill" data-size="modal-lg"
                        data-route="{{ route('admin.skills.create') }}" class="btn btn-primary common_model">+ Add Skill</a>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="skill-table">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Skill</th>
                                <th>Discription</th>
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
            var table = $('#skill-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.skills.index') }}',
                order: [[1, 'asc']],
                columns: [
                    {
                        data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,
                        searchable: false, className: 'text-center'
                    },
                    { data: 'skill_name', name: 'skill_name' },
                    { data: 'description', name: 'description' },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });
    </script>
@endpush