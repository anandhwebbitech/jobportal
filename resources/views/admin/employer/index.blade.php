@extends('admin.layouts.master')
@section('title', 'Education List')
<style>
#employers-table thead th {
    white-space: nowrap;
}
</style>
@section('content')

    <main class="main" id="main">

        <div class="row g-4 mb-4">

            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2>Employer List</h2>

                {{-- <div>
                    <a href="javascript:void(0);" data-title="Add Education" data-size="modal-lg"
                        data-route="{{ route('admin.educations.create') }}" class="btn btn-primary common_model">

                        + Add Education

                    </a>
                </div> --}}
            </div>

            <div class="card">
                <div class="card-body table-responsive">

                    <table class="table table-bordered table-striped align-middle w-100" id="employers-table">

                        <thead class="table-dark text-nowrap">

                            <tr>
                                <th>#</th>
                                <th>Company Name</th>
                                <th>Email</th>
                                <th>Contact</th>
                                <th>GST</th>
                                <th>PAN</th>
                                <th>Status</th>
                                <th width="180">Action</th>
                            </tr>

                        </thead>

                        <tbody></tbody>

                    </table>

                </div>
            </div>

        </div>

        <div class="modal fade" id="viewEmployerModal" tabindex="-1">

            <div class="modal-dialog modal-lg">

                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title">Employer Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <table class="table table-bordered">

                            <tr>
                                <th>Company Name</th>
                                <td id="company_name"></td>
                            </tr>

                            <tr>
                                <th>Owner Name</th>
                                <td id="owner_name"></td>
                            </tr>

                            <tr>
                                <th>Email</th>
                                <td id="email"></td>
                            </tr>

                            <tr>
                                <th>Contact Number</th>
                                <td id="contact_number"></td>
                            </tr>

                            <tr>
                                <th>Contact Type</th>
                                <td id="contact_type"></td>
                            </tr>

                            <tr>
                                <th>Alternate Contact</th>
                                <td id="alternate_contact_number"></td>
                            </tr>

                            <tr>
                                <th>Address</th>
                                <td id="address"></td>
                            </tr>

                            <tr>
                                <th>GST Number</th>
                                <td id="gst_number"></td>
                            </tr>

                            <tr>
                                <th>PAN Number</th>
                                <td id="pan_number"></td>
                            </tr>

                            <tr>
                                <th>Proof Document</th>
                                <td id="proof_document"></td>
                            </tr>

                            <tr>
                                <th>Status</th>
                                <td id="status"></td>
                            </tr>

                            <tr>
                                <th>Created At</th>
                                <td id="created_at"></td>
                            </tr>

                        </table>

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

            $('#employers-table').DataTable({

                processing: true,
                serverSide: true,

                ajax: '{{ route('admin.employers.index') }}',

                columns: [

                    {
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        className: 'text-center'
                    },

                    { data: 'company_name', name: 'company_name' },

                    { data: 'email', name: 'email' },

                    { data: 'contact_number', name: 'contact_number' },

                    { data: 'gst_number', name: 'gst_number' },

                    { data: 'pan_number', name: 'pan_number' },

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

        $(document).on('click', '.viewEmployer', function () {

            let id = $(this).data('id');

            $.ajax({

                url: "{{ url('admin/employers') }}/" + id,
                type: "GET",

                success: function (res) {

                    $('#company_name').text(res.company_name);
                    $('#owner_name').text(res.owner_name);
                    $('#email').text(res.email);
                    $('#contact_number').text(res.contact_number);
                    $('#contact_type').text(res.contact_type);
                    $('#alternate_contact_number').text(res.alternate_contact_number ?? '-');
                    $('#address').text(res.address ?? '-');
                    $('#gst_number').text(res.gst_number ?? '-');
                    $('#pan_number').text(res.pan_number ?? '-');

                    let status = parseInt(res.status); 
                    let statusHtml = '';

                    switch(status) {
                        case 1:
                            statusHtml = '<span class="badge bg-warning">Pending</span>';
                            break;
                        case 2:
                            statusHtml = '<span class="badge bg-info">Waiting</span>';
                            break;
                        case 3:
                            statusHtml = '<span class="badge bg-success">Approved</span>';
                            break;
                        case 4:
                            statusHtml = '<span class="badge bg-danger">Rejected</span>';
                            break;
                        default:
                            statusHtml = '<span class="badge bg-secondary">Unknown</span>';
                    }

                    $('#status').html(statusHtml);

                    $('#created_at').text(res.created_at_formatted ?? '-');

                    $('#viewEmployerModal').modal('show');
                }

            });

        });

        let previousStatus;

        $(document).on('focus', '.changeStatus', function () {
            previousStatus = $(this).val();
        });

        $(document).on('change', '.changeStatus', function () {

            let select = $(this);
            let id = select.data('id');
            let status = select.val();

            // Reject → ask reason using Swal textarea
            if (status == 4) {

                Swal.fire({
                    title: 'Reject Employer',
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
                        select.val(previousStatus);
                    }

                });

            } else {

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You want to change employer status!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, change it!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {

                    if (result.isConfirmed) {
                        sendStatus(id, status, '', select);
                    } else {
                        select.val(previousStatus);
                    }

                });

            }

        });

        function sendStatus(id, status, message, select)
        {
            $.ajax({
                url: "{{ route('admin.employers.approve', ':id') }}".replace(':id', id),
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    status: status,
                    message: message
                },
                success: function (res) {

                    if (res.status) {

                        toastr.success(res.message);
                        $('#employers-table').DataTable().ajax.reload();

                    } else {

                        toastr.error(res.message);
                        select.val(previousStatus);

                    }

                },
                error: function () {

                    toastr.error("Something went wrong");
                    select.val(previousStatus);

                }
            });
        }
    </script>

@endpush