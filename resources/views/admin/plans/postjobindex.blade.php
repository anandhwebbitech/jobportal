@extends('admin.layouts.master')
@section('title', 'Plan List')
@section('content')
<main class="main" id="main">

    <div class="row g-4 mb-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Plan List</h2>
            <button class="btn btn-primary" id="createPlanModalBtn">
                + Add Plan
            </button>
        </div>

        <div class="card">
            <div class="card-body table-responsive">
                <table class="table table-bordered table-striped align-middle" id="plan-table">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Plan</th>
                            <th>Price</th>
                            <th>Job Post Limit</th>
                            <th>Status</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>
            </div>
        </div>

        <!-- Create/Edit Modal -->
        <div class="modal fade" id="planModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header bg-primary text-white">
                        <h5 class="modal-title" id="planModalTitle">Create Plan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <form id="planForm">
                            @csrf
                            <input type="hidden" name="id" id="plan_id">
                            <input type="hidden" name="_method" id="form_method">

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label>Plan Name</label>
                                    <input type="text" name="name" id="plan_name" class="form-control">
                                    <small class="text-danger name_error"></small>
                                </div>

                                <div class="col-md-6">
                                    <label>Duration (Days)</label>
                                    <input type="number" name="duration_days" id="plan_duration" class="form-control">
                                </div>

                                <div class="col-md-4">
                                    <label>Price</label>
                                    <input type="number" step="0.01" name="price" id="plan_price" class="form-control">
                                    <small class="text-danger price_error"></small>
                                </div>

                                <div class="col-md-4">
                                    <label>GST (18%)</label>
                                    <input type="number" id="plan_gst" class="form-control" readonly>
                                    <input type="hidden" name="gst_amount" id="gst_amount_hidden">
                                </div>

                                <div class="col-md-4">
                                    <label>Total</label>
                                    <input type="number" id="plan_total" class="form-control" readonly>
                                    <input type="hidden" name="total_price" id="total_price_hidden">
                                </div>

                                <div class="col-md-6">
                                    <label>Job Post Limit</label>
                                    <input type="number" name="job_post_limit" id="plan_limit" class="form-control" value="1">
                                </div>

                                <div class="col-md-6">
                                    <label>Status</label>
                                    <select name="is_active" id="plan_status" class="form-select">
                                        <option value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <hr>
                            <h6>Features</h6>
                            <div class="row">
                                @foreach (['applicant_management', 'email_notifications', 'tamil_nadu_reach', 'featured_listing', 'priority_support'] as $feature)
                                <div class="col-md-4 mt-2">
                                    <div class="form-check">
                                        <input type="checkbox" name="{{ $feature }}" class="form-check-input" id="{{ $feature }}">
                                        <label class="form-check-label">{{ ucwords(str_replace('_', ' ', $feature)) }}</label>
                                    </div>
                                </div>
                                @endforeach
                            </div>

                            <button type="submit" class="btn btn-success mt-4 w-100" id="planSubmitBtn">Save Plan</button>
                        </form>
                    </div>

                </div>
            </div>
        </div>

    </div>
</main>
@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(function () {
    const table = $('#plan-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: '{{ route('admin.plans.index') }}',
        order: [[1, 'asc']],
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false, className: 'text-center'},
            {data: 'name', name: 'name'},
            {data: 'price', name: 'price'},
            {data: 'job_post_limit', name: 'job_post_limit'},
            {data: 'status', name: 'status', orderable: false, searchable: false},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });

    let modalMode = 'create';

    // Auto GST
    $('#plan_price').on('input', function () {
        const price = parseFloat($(this).val()) || 0;
        const gst = price * 0.18;
        const total = price + gst;

        $('#plan_gst').val(gst.toFixed(2));
        $('#plan_total').val(total.toFixed(2));

        $('#gst_amount_hidden').val(gst.toFixed(2));
        $('#total_price_hidden').val(total.toFixed(2));
    });

    // Open Create Modal
    $('#createPlanModalBtn').on('click', function () {
        modalMode = 'create';
        $('#planForm')[0].reset();
        $('#form_method').val('');
        $('#planModalTitle').text('Create Plan');
        $('#planModal .modal-header').removeClass('bg-warning text-dark').addClass('bg-primary text-white');
        $('#planModal').modal('show');
    });

    // Open Edit Modal
    $(document).on('click', '.editPlan', function () {
        modalMode = 'edit';
        const editUrl = $(this).data('edit-url');
        const updateUrl = $(this).data('update-url');
        $('#planForm').data('update-url', updateUrl);
        $('#form_method').val('PUT'); // Add PUT method

        $.get(editUrl, function (data) {
            $('#plan_id').val(data.id);
            $('#plan_name').val(data.name);
            $('#plan_duration').val(data.duration_days);
            $('#plan_price').val(data.price).trigger('input');
            $('#plan_limit').val(data.job_post_limit);
            $('#plan_status').val(data.is_active);

            ['applicant_management', 'email_notifications', 'tamil_nadu_reach', 'featured_listing', 'priority_support'].forEach(f => {
                $(`#${f}`).prop('checked', data[f] == 1);
            });

            $('#planModalTitle').text('Edit Plan');
            $('#planModal .modal-header').removeClass('bg-primary text-white').addClass('bg-warning text-dark');
            $('#planModal').modal('show');
        });
    });

    // Submit Form
    $('#planForm').submit(function (e) {
        e.preventDefault();
        const url = modalMode === 'create' ? "{{ route('job-plans.store') }}" : $(this).data('update-url');

        $.ajax({
            url: url,
            type: "POST",
            data: $(this).serialize(),
            success: function (res) {
                toastr.success(res.message);
                $('#planModal').modal('hide');
                table.ajax.reload();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    const errors = xhr.responseJSON.errors;
                    Object.keys(errors).forEach(key => {
                        $(`.${key}_error`).text(errors[key][0]);
                    });
                } else {
                    toastr.error("Something went wrong!");
                }
            }
        });
    });
});
</script>
@endpush