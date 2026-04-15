@extends('admin.layouts.master')
@section('title', 'Skill List')
@section('content')
    <main class="main" id="main">
        
        <div class="row g-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Notifications List</h2>
                
            </div>
            
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="skill-table">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Type</th>
                                <th>Message</th>
                                <th>Send From</th>
                                <th>Date</th>
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
        $(function () {
            $('#skill-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.notifications.data') }}', // update route
                order: [[4, 'desc']], // sort by date
                columns: [
                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },
                    { data: 'type', name: 'type' },
                    { data: 'message', name: 'message' },
                    { data: 'send_from', name: 'send_from' },
                    { data: 'date', name: 'created_at' },
                    { data: 'action', name: 'action', orderable: false, searchable: false }
                ]
            });
        });
    </script>
@endpush