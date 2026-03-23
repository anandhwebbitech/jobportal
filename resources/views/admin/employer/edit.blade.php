<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<form id="EducationForm" action="{{ route('admin.educations.update', $education->id) }}" method="POST">
    @csrf
    @method('PUT')

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

                        <option value="High School" {{ $education->level_of_education == 'High School' ? 'selected' : '' }}>
                            High School</option>

                        <option value="Diploma" {{ $education->level_of_education == 'Diploma' ? 'selected' : '' }}>Diploma
                        </option>

                        <option value="Bachelor Degree" {{ $education->level_of_education == 'Bachelor Degree' ? 'selected' : '' }}>Bachelor Degree</option>

                        <option value="Master Degree" {{ $education->level_of_education == 'Master Degree' ? 'selected' : '' }}>Master Degree</option>

                        <option value="PhD" {{ $education->level_of_education == 'PhD' ? 'selected' : '' }}>PhD</option>

                    </select>

                    <span class="text-danger error-text level_of_education_error"></span>

                </div>


                <!-- Field of Study -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">
                        Field of Study <span class="text-danger">*</span>
                    </label>

                    <input type="text" name="field_of_study" class="form-control"
                        value="{{ $education->field_of_study }}" placeholder="Example: Computer Science">

                    <span class="text-danger error-text field_of_study_error"></span>

                </div>


                <!-- Status -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Status</label>

                    <select name="status" class="form-select">

                        <option value="1" {{ $education->status == 1 ? 'selected' : '' }}>Active</option>

                        <option value="0" {{ $education->status == 0 ? 'selected' : '' }}>Inactive</option>

                    </select>

                    <span class="text-danger error-text status_error"></span>

                </div>

            </div>


            <div class="text-end mt-4">

                <button type="submit" class="btn btn-success rounded-pill px-4">
                    <i class="fa fa-save me-2"></i>Update Education
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

                url: "{{ route('admin.educations.update', $education->id) }}",
                method: "POST",
                data: formData,
                processData: false,
                contentType: false,

                success: function (response) {

                    if (response.status) {

                        toastr.success(response.message);

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