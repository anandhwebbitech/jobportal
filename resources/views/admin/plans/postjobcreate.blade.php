<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<div class="card shadow-sm">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Create Job Plan</h5>
    </div>

    <div class="card-body">
        <form id="jobPlanForm">
            @csrf

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label">Plan Name</label>
                    <input type="text" name="name" class="form-control">
                    <small class="text-danger name_error"></small>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Duration (Days)</label>
                    <input type="number" name="duration_days" class="form-control">
                    <small class="text-danger duration_days_error"></small>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Price</label>
                    <input type="number" step="0.01" name="price" class="form-control">
                    <small class="text-danger price_error"></small>
                </div>

                <div class="col-md-4">
                    <label class="form-label">GST (18%)</label>
                    <input type="number" step="0.01" name="gst_amount" class="form-control" readonly>
                </div>

                <div class="col-md-4">
                    <label class="form-label">Total</label>
                    <input type="number" step="0.01" name="total_price" class="form-control" readonly>
                </div>

                <div class="col-md-6">
                    <label class="form-label">Job Post Limit</label>
                    <input type="number" name="job_post_limit" value="1" class="form-control">
                </div>

                <div class="col-md-6">
                    <label class="form-label">Status</label>
                    <select name="is_active" class="form-select">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>
                </div>

            </div>

            <hr>

            <h6 class="mb-3">Features</h6>

            <div class="row">
                <div class="col-md-4">
                    <div class="form-check">
                        <input type="checkbox" name="applicant_management" class="form-check-input" checked>
                        <label class="form-check-label">Applicant Management</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-check">
                        <input type="checkbox" name="email_notifications" class="form-check-input" checked>
                        <label class="form-check-label">Email Notifications</label>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-check">
                        <input type="checkbox" name="tamil_nadu_reach" class="form-check-input" checked>
                        <label class="form-check-label">Tamil Nadu Reach</label>
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-check">
                        <input type="checkbox" name="featured_listing" class="form-check-input">
                        <label class="form-check-label">Featured Listing</label>
                    </div>
                </div>

                <div class="col-md-4 mt-2">
                    <div class="form-check">
                        <input type="checkbox" name="priority_support" class="form-check-input">
                        <label class="form-check-label">Priority Support</label>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-4 w-100">
                Create Plan
            </button>
        </form>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function(){

    // ✅ Auto GST Calculation
    $('input[name="price"]').on('input', function() {
        let price = parseFloat($(this).val()) || 0;
        let gst = price * 0.18;
        let total = price + gst;

        $('input[name="gst_amount"]').val(gst.toFixed(2));
        $('input[name="total_price"]').val(total.toFixed(2));
    });

    // ✅ Form Submit
    $('#jobPlanForm').submit(function(e){
        e.preventDefault();

        let formData = $(this).serialize();

        $('.text-danger').text('');

        $.ajax({
            url: "{{ route('job-plans.store') }}",
            type: "POST",
            data: formData,

            success: function(response){
                toastr.success(response.message);

                $('#jobPlanForm')[0].reset();
                // ✅ Close modal
                var modal = bootstrap.Modal.getInstance(document.getElementById('yourModalId'));
                modal.hide();
            },

            error: function(xhr){

                if(xhr.status === 422){
                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function(key, value){
                        $('.' + key + '_error').text(value[0]);
                    });

                } else {
                    toastr.error("Something went wrong!");
                }
            }
        });
    });

});
</script>