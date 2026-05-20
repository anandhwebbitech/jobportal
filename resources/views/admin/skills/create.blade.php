<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<style>
    .skill-card{
        border:none;
        border-radius:20px;
        overflow:hidden;
        box-shadow:0 8px 25px rgba(0,0,0,0.08);
    }

    .card-header-custom{
        background:linear-gradient(135deg,#198754,#20c997);
        padding:25px;
        color:#fff;
    }

    .form-control,
    .form-select{
        border-radius:12px;
        padding:12px 15px;
        border:1px solid #dcdcdc;
        transition:0.3s;
    }

    .form-control:focus,
    .form-select:focus{
        border-color:#20c997;
        box-shadow:0 0 0 0.15rem rgba(32,201,151,0.2);
    }

    .upload-box{
        border:2px dashed #20c997;
        border-radius:16px;
        padding:30px;
        text-align:center;
        background:#f8fffc;
    }

    .btn-custom-success{
        background:linear-gradient(135deg,#198754,#20c997);
        border:none;
        border-radius:50px;
        padding:10px 25px;
        color:#fff;
        transition:0.3s;
    }

    .btn-custom-success:hover{
        transform:translateY(-2px);
        box-shadow:0 5px 15px rgba(25,135,84,0.3);
    }

    .btn-upload{
        background:#0d6efd;
        border:none;
        border-radius:50px;
        padding:10px 25px;
        color:#fff;
    }

    .btn-cancel{
        border-radius:50px;
        padding:10px 25px;
    }

    .section-title{
        font-size:18px;
        font-weight:600;
        margin-bottom:20px;
        color:#198754;
    }
</style>


<!-- =========================
SAMPLE DOWNLOAD BUTTON
========================= -->

<div class="d-flex justify-content-end mb-3">

    <a href="{{ asset('sample/skills_sample.xlsx') }}"
       class="btn btn-outline-success rounded-pill"
       download="skills_sample.xlsx">

        <i class="fa fa-download me-2"></i>
        Download Sample Excel

    </a>

</div>


<!-- =========================
CREATE SKILL FORM
========================= -->

<form id="SkillForm" action="{{ route('admin.skills.store') }}" method="POST">

    @csrf

    <div class="card skill-card">

        <!-- Header -->
        <div class="card-header-custom">

            <h3 class="mb-1">
                <i class="fa fa-lightbulb me-2"></i>
                Create Skill
            </h3>

            <p class="mb-0 text-light">
                Add new skill details
            </p>

        </div>

        <div class="card-body p-4">

            <!-- Skill Form -->
            <div class="section-title">
                Skill Information
            </div>

            <div class="row">

                <!-- Skill Name -->
                <div class="col-md-6 mb-4">

                    <label class="form-label fw-semibold">
                        Skill Name
                        <span class="text-danger">*</span>
                    </label>

                    <input type="text"
                           name="skill_name"
                           class="form-control"
                           placeholder="Enter skill name">

                    <span class="text-danger error-text skill_name_error"></span>

                </div>

                <!-- Description -->
                <div class="col-md-6 mb-4">

                    <label class="form-label fw-semibold">
                        Description
                    </label>

                    <textarea name="description"
                              class="form-control"
                              rows="3"
                              placeholder="Enter skill description"></textarea>

                    <span class="text-danger error-text description_error"></span>

                </div>

                <!-- Status -->
                <div class="col-md-6 mb-4">

                    <label class="form-label fw-semibold">
                        Status
                    </label>

                    <select name="status" class="form-select">

                        <option value="1">Active</option>
                        <option value="0">Inactive</option>

                    </select>

                    <span class="text-danger error-text status_error"></span>

                </div>

            </div>

            <!-- Buttons -->
            <div class="text-end mt-2">

                <button type="submit" class="btn btn-custom-success">

                    <i class="fa fa-save me-2"></i>
                    Save Skill

                </button>

                <a href="{{ route('admin.skills.index') }}"
                   class="btn btn-secondary btn-cancel">

                    Cancel

                </a>

            </div>

        </div>

    </div>

</form>


<!-- =========================
BULK UPLOAD FORM
========================= -->

<form id="BulkUploadForm"
      enctype="multipart/form-data"
      class="mt-4">

    @csrf

    <div class="card skill-card">

        <!-- Header -->
        <div class="card-header-custom">

            <h3 class="mb-1">
                <i class="fa fa-file-excel me-2"></i>
                Bulk Upload Skills
            </h3>

            <p class="mb-0 text-light">
                Upload skills using Excel or CSV
            </p>

        </div>

        <div class="card-body p-4">

            <div class="upload-box">

                <div class="mb-3">

                    <i class="fa fa-file-excel fa-3x text-success mb-3"></i>

                    <h5>
                        Upload Excel File
                    </h5>

                    <p class="text-muted mb-3">
                        Supported formats:
                        .xlsx, .xls, .csv
                    </p>

                    <input type="file"
                           name="excel_file"
                           class="form-control">

                    <span class="text-danger error-text excel_file_error"></span>

                </div>

                <button type="submit" class="btn btn-upload">

                    <i class="fa fa-upload me-2"></i>
                    Upload Excel

                </button>

            </div>

        </div>

    </div>

</form>


@if ($errors->any())

<div class="alert alert-danger mt-3">

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

    /* =========================
    SINGLE SKILL SAVE
    ========================= */

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

                        window.location.href =
                            "{{ route('admin.skills.index') }}";

                    },1200);
                }
            },

            error:function(xhr){

                if(xhr.status === 422){

                    let errors = xhr.responseJSON.errors;

                    $.each(errors,function(key,value){

                        $("."+key+"_error")
                            .text(value[0]);

                    });

                }else{

                    toastr.error("Something went wrong");

                }
            }
        });

    });


    /* =========================
    BULK UPLOAD
    ========================= */

    $("#BulkUploadForm").submit(function(e){

        e.preventDefault();

        let formData = new FormData(this);

        $(".error-text").text('');

        $.ajax({

            url: "{{ route('admin.skills.bulkUpload') }}",

            method: "POST",

            data: formData,

            processData:false,

            contentType:false,

            success:function(response){

                if(response.status){

                    toastr.success(response.message);

                    $("#BulkUploadForm")[0].reset();

                    setTimeout(function(){

                        window.location.href =
                            "{{ route('admin.skills.index') }}";

                    },1200);
                }
            },

            error:function(xhr){

                if(xhr.status === 422){

                    let errors = xhr.responseJSON.errors;

                    $.each(errors,function(key,value){

                        $("."+key+"_error")
                            .text(value[0]);

                    });

                }else{

                    toastr.error("Upload failed");

                }
            }

        });

    });

});
</script>