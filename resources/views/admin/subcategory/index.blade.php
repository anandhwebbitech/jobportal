@extends('admin.layouts.master')
@section('title', 'Sub Category List')
@section('content')
    <main class="main" id="main">
        
        <div class="row g-4 mb-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Subcategories</h2>
                <div>
                    <a href="{{ route('admin.subcategories.create') }}" class="btn btn-primary">
                        + Add Subcategory
                    </a>
                </div>
            </div>
            
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-striped align-middle" id="subcategory-table">
                        <thead class="table-dark">
                            <tr>
                                <th>#</th>
                                <th>Category</th>
                                <th>Name</th>
                                <th>Image</th>
                                <th>Slug</th>
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
    $(function () {
        $('#subcategory-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('admin.subcategories.index') }}',
            columns: [
                {
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                { 
                    data: 'category', 
                    name: 'category.name' 
                },
                { 
                    data: 'name', 
                    name: 'name' 
                },
                { 
                    data: 'image', 
                    name: 'image',
                    orderable: false,
                    searchable: false
                },
                { 
                    data: 'slug', 
                    name: 'slug' 
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
                },
            ]
        });
    });
</script>
@endpush
