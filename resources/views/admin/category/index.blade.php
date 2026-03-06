@extends('admin.layouts.master')
@section('title', 'Category List')
@section('content')
    <main class="main" id="main">
        
        <div class="row g-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Categories</h2>
                <div>
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">+ Add Category</a>
                    {{-- <a href="{{ route('admin.categories.trashed') }}" class="btn btn-warning">Trashed</a> --}}
                </div>
            </div>
            
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="category-table">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Slug</th>
                                {{-- <th>Parent</th> --}}
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
            var table = $('#category-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: '{{ route('admin.categories.index') }}',
                columns: [
                    {
                        data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false,
                        searchable: false, className: 'text-center'
                    },
                    { data: 'name', name: 'name' },
                    { data: 'image', name: 'image' },
                    { data: 'slug', name: 'slug' },
                    // { data: 'paragraph', name: 'paragraph' },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ]
            });
        });
    </script>
@endpush