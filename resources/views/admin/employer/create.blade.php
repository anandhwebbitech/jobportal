<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<form id="EducationForm" action="{{ route('admin.educations.store') }}" method="POST">
    @csrf

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <div class="row">

                <!-- Level of Education -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">
                        Level of Education <span class="text-danger">*</span>
                    </label>

                    <select name="level_of_education" class="form-select">
                        <option value="">Select Level</option>
                        <option value="High School">High School</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Bachelor Degree">Bachelor Degree</option>
                        <option value="Master Degree">Master Degree</option>
                        <option value="PhD">PhD</option>
                    </select>

                    <span class="text-danger error-text education_level_error"></span>
                </div>


                <!-- Field of Study -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">
                        Field of Study <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="field_of_study" class="form-control"
                        placeholder="Example: Computer Science">

                    <span class="text-danger error-text field_of_study_error"></span>
                </div>


                <!-- Status -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Status</label>

                    <select name="status" class="form-select">
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </select>

                    <span class="text-danger error-text status_error"></span>
                </div>

            </div>


            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success rounded-pill px-4">
                    <i class="fa fa-save me-2"></i>Save Education
                </button>

                <a href="{{ route('admin.educations.index') }}" class="btn btn-secondary rounded-pill px-4">
                    Cancel
                </a>
            </div>

        </div>
    </div>

</form>


<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script>

$(document).ready(function () {

    $("#EducationForm").submit(function (e) {

        e.preventDefault();

        let formData = new FormData(this);

        $(".error-text").text('');

        $.ajax({

            url: "{{ route('admin.educations.store') }}",
            method: "POST",
            data: formData,
            processData: false,
            contentType: false,

            success: function (response) {

                // 🔴 Validation error from controller
                if(response.status === false){

                    $.each(response.errors, function (key, value) {
                        toastr.error(value[0]);
                    });

                    return;
                }

                // 🟢 Success
                if (response.status === true) {

                    toastr.success(response.message);

                    $("#EducationForm")[0].reset();

                    setTimeout(function () {
                        window.location.href = "{{ route('admin.educations.index') }}";
                    }, 1200);

                }

            },

            error: function (xhr) {

                if (xhr.status === 422) {

                    let errors = xhr.responseJSON.errors;

                    $.each(errors, function (key, value) {
                        toastr.error(value[0]);
                    });

                } else {

                    toastr.error("Something went wrong");

                }

            }

        });

    });

});

</script>