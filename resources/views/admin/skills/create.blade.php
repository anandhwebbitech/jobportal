<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<form id="SkillForm" action="{{ route('admin.skills.store') }}" method="POST">
    @csrf

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row">

                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">
                        Skill Name <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                            name="skill_name"
                            class="form-control @error('skill_name') is-invalid @enderror"
                            value="{{ old('skill_name') }}"
                            placeholder="Enter color skill name ">
                    <span class="text-danger error-text skill_name_error"></span>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">
                        Skill Description
                    </label>

                    <textarea name="description"
                            class="form-control @error('description') is-invalid @enderror"
                            rows="3"
                            placeholder="Enter skill description">{{ old('description') }}</textarea>

                    <span class="text-danger error-text description_error"></span>
                </div>
                <!-- Status -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status"
                            class="form-select @error('status') is-invalid @enderror">
                        <option value="1" {{ old('status',1) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    <span class="text-danger error-text status_error"></span>
                </div>

            </div>

            <!-- Buttons -->
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success rounded-pill px-4">
                    <i class="fa fa-save me-2"></i>Save Skill
                </button>
                <a href="{{ route('admin.skills.index') }}" class="btn btn-secondary rounded-pill px-4">
                    Cancel
                </a>
            </div>

        </div>
    </div>

</form>
@if ($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$(document).ready(function(){

    $("#SkillForm").submit(function(e){

        e.preventDefault();

        let formData = new FormData(this);

        $(".error-text").text('');

        $.ajax({
            url: "{{ route('admin.skills.store') }}",
            method: "POST",
            data: formData,
            processData:false,
            contentType:false,

            success:function(response){

                if(response.status){

                    toastr.success(response.message);

                    $("#SkillForm")[0].reset();

                    setTimeout(function(){
                        window.location.href = "{{ route('admin.skills.index') }}";
                    },1200);
                }

            },

            error:function(xhr){

                if(xhr.status === 422){

                    let errors = xhr.responseJSON.errors;

                    $.each(errors,function(key,value){

                        $("."+key+"_error").text(value[0]);

                    });

                }else{

                    toastr.error("Something went wrong");

                }

            }

        });

    });

});
</script>