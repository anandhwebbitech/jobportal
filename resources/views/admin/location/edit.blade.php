<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<form id="LocationForm" method="POST">
    @csrf
    @method('PUT')

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="row">

                <!-- State -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">
                        State <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                        name="state"
                        class="form-control"
                        value="{{ $location->state }}"
                        placeholder="Example: Tamil Nadu">

                    <span class="text-danger error-text state_error"></span>
                </div>

                <!-- District -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">
                        District <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                        name="district"
                        class="form-control"
                        value="{{ $location->district }}"
                        placeholder="Example: Chennai">

                    <span class="text-danger error-text district_error"></span>
                </div>

                <!-- Status -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Status</label>

                    <select name="status" class="form-select">
                        <option value="1" {{ $location->status == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ $location->status == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>

                    <span class="text-danger error-text status_error"></span>
                </div>

            </div>

            <div class="text-end mt-4">

                <button type="submit" class="btn btn-success rounded-pill px-4">
                    <i class="fa fa-save me-2"></i>Update Location
                </button>

                <a href="{{ route('admin.locations.index') }}" class="btn btn-secondary rounded-pill px-4">
                    Cancel
                </a>

            </div>

        </div>
    </div>

</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>
$(document).ready(function () {

    $("#LocationForm").submit(function (e) {

        e.preventDefault();

        let formData = new FormData(this);

        $(".error-text").text('');

        $.ajax({

            url: "{{ route('admin.locations.update', $location->id) }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,

            success: function (response) {

                if (response.status === true) {

                    toastr.success(response.message);

                    setTimeout(function () {
                        window.location.href = "{{ route('admin.locations.index') }}";
                    }, 1200);
                }
            },

            error: function (xhr) {

                if (xhr.status === 422) {

                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, value) {

                        toastr.error(value[0]);

                        $("." + key + "_error").text(value[0]);
                    });

                } else {

                    toastr.error("Something went wrong");
                }
            }

        });

    });

});
</script>