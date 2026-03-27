@extends('admin.layouts.master')
@section('title', 'Job List')
<style>
    #employers-table thead th {
        white-space: nowrap;
    }

    .modal-content {
        border-radius: 8px;
    }

    .table th {
        color: #6c757d;
        font-weight: 500;
    }

    .btn-outline-danger:hover {
        background-color: #dc3545;
        color: #fff;
    }

    .modal-footer .btn {
        min-width: 110px;
    }
</style>
@section('content')

    <main class="main" id="main">

        <div class="row g-4 mb-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Job List</h2>
            </div>

            <div class="card">
                <div class="card-body table-responsive">

                    <table class="table table-bordered table-striped align-middle w-100" id="jobs-table">

                        <thead class="table-dark text-nowrap">

                            <tr>
                                <th>#</th>
                                <th>Job Title</th>
                                <th>Category</th>
                                <th>Vacancies</th>
                                <th>Experience</th>
                                <th>Location</th>
                                <th>Salary</th>
                                <th>Job Type</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>

                        </thead>

                        <tbody></tbody>

                    </table>

                </div>
            </div>

        </div>

        <div class="modal fade" id="viewJobModal" tabindex="-1">
            <div class="modal-dialog modal-xl">
                <div class="modal-content shadow">

                    <!-- HEADER -->
                    <div class="modal-header border-bottom">
                        <div>
                            <h5 class="modal-title fw-bold" id="job_title"></h5>
                            <small class="text-muted" id="job_company_name"></small>
                        </div>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <!-- TOP SUMMARY -->
                        <div class="row text-center mb-4">
                            <div class="col-md-3">
                                <div class="border rounded p-2">
                                    <small class="text-muted">Location</small>
                                    <div id="job_location"></div>
                                    <small id="job_district"></small>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="border rounded p-2">
                                    <small class="text-muted">Job Type</small>
                                    <div id="job_type"></div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="border rounded p-2">
                                    <small class="text-muted">Experience</small>
                                    <div id="job_experience"></div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="border rounded p-2">
                                    <small class="text-muted">Salary</small>
                                    <div>
                                        ₹ <span id="salary_min"></span> -
                                        ₹ <span id="salary_max"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- DETAILS GRID -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th width="40%">Category</th>
                                        <td id="job_category"></td>
                                    </tr>
                                    <tr>
                                        <th>Industry</th>
                                        <td id="job_industry"></td>
                                    </tr>
                                    <tr>
                                        <th>Education</th>
                                        <td id="education"></td>
                                    </tr>

                                </table>
                            </div>

                            <div class="col-md-6">
                                <table class="table table-sm table-borderless">
                                    <tr>
                                        <th>Vacancies</th>
                                        <td id="num_vacancies"></td>
                                    </tr>
                                    <tr>
                                        <th width="40%">Expiry Date</th>
                                        <td id="expiry_date"></td>
                                    </tr>
                                    {{-- <tr>
                                <th>Status</th>
                                <td id="job_status"></td>
                            </tr> --}}
                                    <tr>
                                        <th>Posted On</th>
                                        <td id="job_created_at"></td>
                                    </tr>
                                </table>
                            </div>
                        </div>

                        <!-- SECTIONS -->
                        <div class="mb-3">
                            <h6 class="fw-bold border-bottom pb-1">Job Description</h6>
                            <p id="description" class="text-muted"></p>
                        </div>

                        <div class="mb-3">
                            <h6 class="fw-bold border-bottom pb-1">Responsibilities</h6>
                            <p id="responsibilities" class="text-muted"></p>
                        </div>

                        <div class="mb-3">
                            <h6 class="fw-bold border-bottom pb-1">Required Skills</h6>
                            <p id="skills" class="text-muted"></p>
                        </div>

                        <div>
                            <h6 class="fw-bold border-bottom pb-1">Benefits</h6>
                            <p id="benefits" class="text-muted"></p>
                        </div>

                    </div>

                    <div class="modal-footer border-top d-flex justify-content-between align-items-center">

                        <!-- LEFT: Status hint -->
                        <div>
                            <small class="text-muted">
                                Action will update job status
                            </small>
                        </div>

                        <!-- RIGHT: Actions -->
                        <div class="d-flex gap-2">

                            <button type="button" class="btn btn-light border" data-bs-dismiss="modal">
                                Close
                            </button>

                            <button type="button" class="btn btn-outline-danger px-4 changeStatus" data-status="3" id="rejectJob">
                                Reject
                            </button>

                            <button type="button" class="btn btn-primary px-4 changeStatus" data-status="1" id="approveJob">
                                Approve
                            </button>

                        </div>

                    </div>

                </div>
            </div>
        </div>
    </main>

@endsection


@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(function() {

            $('#jobs-table').DataTable({
                processing: true,
                serverSide: true,

                ajax: '{{ route('admin.jobs.index') }}',
                order: [
                    [1, 'asc']
                ],
                columns: [

                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },

                    {
                        data: 'title',
                        name: 'title'
                    },
                    {
                        data: 'category',
                        name: 'category'
                    },

                    {
                        data: 'num_vacancies',
                        name: 'num_vacancies'
                    },

                    {
                        data: 'experience',
                        name: 'experience'
                    },
                    {
                        data: 'district',
                        name: 'district'
                    },

                    {
                        data: 'salary_min',
                        name: 'salary_min'
                    },

                    {
                        data: 'job_type',
                        name: 'job_type'
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

        $(document).on('click', '.viewjob', function() {

            let id = $(this).data('id');
            $('#approveJob').data('id', id);
            $('#rejectJob').data('id', id);
            $.ajax({
                url: "{{ url('admin/jobs') }}/" + id, // ✅ FIXED URL
                type: "GET",

                success: function(res) {

                    // ✅ BASIC INFO
                    $('#job_title').text(res.title ?? '-');
                    $('#job_company_name').text(res.company_name ?? '-');

                    $('#job_category').text(res.category ?? '-');
                    $('#job_industry').text(res.industry ?? '-');

                    $('#job_location').text(res.location ?? '-');
                    $('#job_district').text(res.district ?? '-');

                    $('#job_experience').text(res.experience ?? '-');
                    $('#job_type').text(res.job_type ?? '-');

                    // ✅ SALARY
                    $('#salary_min').text(res.salary_min ?? '0');
                    $('#salary_max').text(res.salary_max ?? '0');

                    // ✅ OTHER DETAILS
                    $('#num_vacancies').text(res.num_vacancies ?? '-');
                    $('#education').text(res.education ?? '-');
                    $('#skills').text(res.skills ?? '-');

                    $('#description').text(res.description ?? '-');
                    $('#responsibilities').text(res.responsibilities ?? '-');
                    $('#benefits').text(res.benefits ?? '-');

                    $('#expiry_date').text(res.expiry_date ?? '-');
                    $('#job_created_at').text(res.created_at ?? '-');

                    // ✅ STATUS
                    let status = parseInt(res.status);
                    let statusHtml = '';

                    switch (status) {
                        case 1:
                            statusHtml = '<span class="badge bg-success">Active</span>';
                            break;
                        case 0:
                            statusHtml = '<span class="badge bg-secondary">Inactive</span>';
                            break;
                        default:
                            statusHtml = '<span class="badge bg-dark">Unknown</span>';
                    }

                    $('#job_status').html(statusHtml);

                    // ✅ SHOW MODAL
                    $('#viewJobModal').modal('show');
                },

                error: function(xhr) {
                    console.log(xhr.responseText);
                }
            });
        });

        let previousStatus;

     

        $(document).on('click', '.changeStatus', function() {

            let select = $(this);
            let id = select.data('id');
            let status = select.data('status');

            // Reject → ask reason using Swal textarea
            if (status == 3) {

                Swal.fire({
                    target: document.getElementById('viewJobModal'),
                    title: 'Reject Job',
                    input: 'textarea',
                    inputLabel: 'Enter rejection reason',
                    inputPlaceholder: 'Write rejection reason here...',
                    inputAttributes: {
                        'aria-label': 'Type your message here'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Submit',
                    cancelButtonText: 'Cancel',
                    preConfirm: (message) => {
                        if (!message) {
                            Swal.showValidationMessage('Rejection reason is required');
                        }
                        return message;
                    }
                }).then((result) => {

                    if (result.isConfirmed) {

                        sendStatus(id, status, result.value, select);

                    } else {
                    }

                });

            } else {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to change Job status!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, change it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {

                    if (result.isConfirmed) {
                        sendStatus(id, status, '', select);
                    } else {
                    }

                });

            }

        });

        function sendStatus(id, status, message, select) {
            $.ajax({
                url: "{{ route('admin.jobs.approve', ':id') }}".replace(':id', id),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    status: status,
                    message: message
                },
                success: function(res) {

                    if (res.status) {
                        toastr.success(res.message);
                        $('#jobs-table').DataTable().ajax.reload();
                         $('#viewJobModal').modal('hide');
                    } else {
                        toastr.error(res.message);
                    }

                },
                error: function() {
                    toastr.error("Something went wrong");
                }
            });
        }
    </script>
@endpush
