@extends('admin.layouts.master')
@section('title', 'Job Seeker List')
<style>

.info-box {
    background: #f8f9fa;
    padding: 10px 15px;
    border-radius: 8px;
    height: 100%;
}

.info-box label {
    font-size: 13px;
    color: #6c757d;
    margin-bottom: 2px;
    display: block;
}

.info-box p {
    font-weight: 500;
    margin: 0;
    color: #212529;
}

#view_photo img {
    width: 110px;
    height: 110px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #0d6efd;
}
</style>
@section('content')

    <main class="main" id="main">

        <div class="row g-4 mb-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Job Seeker List</h2>
            </div>

            <div class="card">
                <div class="card-body table-responsive">

                    <table class="table table-bordered table-striped align-middle w-100" id="jobseeker-table">

                        <thead class="table-dark text-nowrap">

                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>Qualification</th>
                                <th>Status</th>
                                <th width="180">Action</th>
                            </tr>

                        </thead>

                        <tbody></tbody>

                    </table>

                </div>
            </div>

        </div>

        <div class="modal fade" id="viewUserModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content shadow-lg border-0 rounded-3">

                    <!-- Header -->
                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title">
                            <i class="fa-solid fa-user me-2"></i> Job Seeker Details
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body p-4">

                        <!-- Profile Section -->
                        <div class="text-center mb-4">
                            <div id="view_photo" class="mb-2"></div>
                            <h5 class="fw-bold mb-0" id="view_name"></h5>
                            <small class="text-muted" id="view_email"></small>
                        </div>

                        <hr>

                        <!-- Info Grid -->
                        <div class="row g-3">

                            <div class="col-md-6">
                                <div class="info-box">
                                    <label>Mobile</label>
                                    <p id="view_mobile"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-box">
                                    <label>Location</label>
                                    <p id="view_location"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-box">
                                    <label>Qualification</label>
                                    <p id="view_qualification"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-box">
                                    <label>Experience</label>
                                    <p id="view_experience"></p>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="info-box">
                                    <label>Skills</label>
                                    <p id="view_skills"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-box">
                                    <label>Status</label>
                                    <p id="view_status"></p>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="info-box">
                                    <label>Created At</label>
                                    <p id="view_created_at"></p>
                                </div>
                            </div>

                        </div>

                        <hr>

                        <!-- Resume Section -->
                        <div class="row align-items-center">
    
                            <div class="col-md-6 text-start">
                                <div id="view_resume"></div>
                            </div>

                            <div class="col-md-6 text-end">
                                <button class="btn btn-success me-2" id="approveBtn">
                                    <i class="fa fa-check"></i> Approve
                                </button>

                                <button class="btn btn-danger" id="rejectBtn">
                                    <i class="fa fa-times"></i> Reject
                                </button>
                            </div>

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

        $(function () {

            $('#jobseeker-table').DataTable({

                processing: true,
                serverSide: false,

                ajax: '{{ route('admin.jobseekers.index') }}',
                order: [[0, 'asc']],
                columns: [

                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },

                    { data: 'name', name: 'name' },

                    { data: 'email', name: 'email' },

                    { data: 'mobile', name: 'mobile' },

                    { data: 'qualification', name: 'qualification' },

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
        const imageUrl = "{{ asset('public/uploads/photos') }}";
        const resumeUrl = "{{ asset('public/uploads/resumes') }}";
        $(document).on('click', '.viewUser', function () {

            let id = $(this).data('id');
            $('#rejectBtn').data('id', id);
            $('#approveBtn').data('id', id);
            $.ajax({

                url: "{{ url('admin/jobseekers') }}/" + id,
                type: "GET",

                success: function (res) {

                    $('#view_name').text(res.name);
                    $('#view_email').text(res.email);
                    $('#view_mobile').text(res.details?.mobile ?? '-');

                    $('#view_location').text(
                        (res.details?.city ?? '') + ', ' + (res.details?.district ?? '') + ', ' + (res.details?.state ?? '')
                    );

                    $('#view_qualification').text(res.details?.qualification ?? '-');

                    $('#view_experience').text(res.details?.exp ?? '-');

                    let skills = res.details?.skills ? JSON.parse(res.details.skills) : [];
                    $('#view_skills').text(skills.length ? skills.join(', ') : '-');

                    $('#view_photo').html(
                        res.details?.profile_photo
                            ? `<img src="${imageUrl}/${res.details.profile_photo}" />`
                            : `<img src="https://via.placeholder.com/110">`
                    );
                    $('#view_resume').html(
                        res.details?.resume
                            ? `<a href="${resumeUrl}/${res.details.resume}" target="_blank" class="btn btn-primary">
                                    <i class="fa-solid fa-file-arrow-down me-1"></i> View Resume
                            </a>`
                            : `<span class="text-muted">No Resume Uploaded</span>`
                    );

                    let status = parseInt(res.status);
                    let statusHtml = '';

                    switch (status) {
                        case 0:
                            statusHtml = '<span class="badge bg-secondary">Inactive</span>';
                            break;
                        case 1:
                            statusHtml = '<span class="badge bg-warning">Pending</span>';
                            break;
                        case 2:
                            statusHtml = '<span class="badge bg-info">Resubmitted</span>';
                            break;
                        case 3:
                            statusHtml = '<span class="badge bg-success">Rejected</span>';
                            break;
                        default:
                            statusHtml = '<span class="badge bg-secondary">Unknown</span>';
                    }

                    $('#view_status').html(statusHtml);

                    $('#view_created_at').text(res.created_at_formatted ?? '-');

                    $('#viewUserModal').modal('show');
                }

            });

        });
        $('#rejectBtn').click(function () {
            let id = $(this).data('id');
            Swal.fire({
                target: document.getElementById('viewUserModal'), // 🔥 attach inside modal
                title: 'Reject User',
                input: 'textarea',
                inputLabel: 'Reject Reason',
                inputPlaceholder: 'Enter reason for rejection...',
                showCancelButton: true,
                confirmButtonText: 'Reject',
                confirmButtonColor: '#d33',
                backdrop: false, // 🔥 important (avoid overlay conflict)
                focusConfirm: false,
                didOpen: () => {
                    document.querySelector('.swal2-textarea').focus();
                },
                inputValidator: (value) => {
                    if (!value || value.trim() === '') {
                        return 'Reject reason is required!';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatus(id,3, result.value);
                }
            });

        });
        $('#approveBtn').click(function () {
            let id = $(this).data('id');
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to approve this user?",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, Approve',
                confirmButtonColor: '#28a745'
            }).then((result) => {
                if (result.isConfirmed) {
                    updateStatus(id,1);
                }
            });
        });

        function updateStatus(id,status, reason = '') {
            $.ajax({
                url: "{{ route('admin.jobseekers.approve', ':id') }}".replace(':id', id),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    is_active: status,
                    reject_reason: reason
                },
                success: function (res) {
                    if (res.status) {
                        toastr.success(res.message); // ✅ success toast
                        $('#viewUserModal').modal('hide');
                        $('#jobseeker-table').DataTable().ajax.reload();
                    } else {
                        toastr.error(res.message || 'Something went wrong'); // ✅ error toast
                    }
                },
                error: function (xhr) {
                    let msg = 'Something went wrong';

                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        msg = xhr.responseJSON.message;
                    }

                    toastr.error(msg); // ✅ error toast
                }
            });
        }
       
    </script>

@endpush