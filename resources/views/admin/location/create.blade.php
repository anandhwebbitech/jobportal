<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
<form id="LocationForm" action="{{ route('admin.locations.store') }}" method="POST">
    @csrf

    <style>
        .location-card {
            border: 0;
            border-radius: 20px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 10px 35px rgba(0,0,0,0.08);
        }

        .location-header {
            padding: 22px 28px;
            background: linear-gradient(135deg, #0f766e, #16a34a);
            color: #fff;
        }

        .location-header h4 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
        }

        .location-header p {
            margin: 6px 0 0;
            opacity: .9;
            font-size: 14px;
        }

        .location-body {
            padding: 30px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 10px;
        }

        .form-control-custom,
        .form-select-custom {
            width: 100%;
            height: 52px;
            border-radius: 14px;
            border: 1px solid #dbe2ea;
            background: #f8fafc;
            padding: 0 16px;
            font-size: 15px;
            font-weight: 500;
            color: #0f172a;
            transition: all .25s ease;
            outline: none;
        }

        .form-control-custom:focus,
        .form-select-custom:focus {
            border-color: #16a34a;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(22,163,74,.12);
        }

        .form-select-custom option {
            color: #000;
        }

        .field-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            pointer-events: none;
        }

        .field-wrap {
            position: relative;
        }

        .required-star {
            color: #ef4444;
        }

        .btn-save {
            height: 50px;
            border-radius: 14px;
            padding: 0 28px;
            border: none;
            background: linear-gradient(135deg, #16a34a, #15803d);
            color: #fff;
            font-weight: 700;
            transition: .25s ease;
            box-shadow: 0 10px 25px rgba(22,163,74,.22);
        }

        .btn-save:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(22,163,74,.30);
        }

        .btn-cancel {
            height: 50px;
            border-radius: 14px;
            padding: 0 28px;
            font-weight: 700;
        }

        .error-text {
            font-size: 13px;
            margin-top: 6px;
            display: block;
        }

        @media(max-width:768px) {
            .location-body {
                padding: 20px;
            }
        }
    </style>

    <div class="location-card">

        {{-- Header --}}
        <div class="location-header">
            <h4>
                <i class="fa-solid fa-location-dot me-2"></i>
                Add Location
            </h4>
            <p>Add state and district details for job location management.</p>
        </div>

        {{-- Body --}}
        <div class="location-body">

            <div class="row g-4">

                {{-- State --}}
                <div class="col-md-6">
                    <label class="form-label">
                        State <span class="required-star">*</span>
                    </label>

                    <div class="field-wrap">
                        <select class="form-select-custom"
                                name="state"
                                id="ljStateSel">

                            <option value="">Select State</option>

                            <option value="Andhra Pradesh">Andhra Pradesh</option>
                            <option value="Arunachal Pradesh">Arunachal Pradesh</option>
                            <option value="Assam">Assam</option>
                            <option value="Bihar">Bihar</option>
                            <option value="Chhattisgarh">Chhattisgarh</option>
                            <option value="Goa">Goa</option>
                            <option value="Gujarat">Gujarat</option>
                            <option value="Haryana">Haryana</option>
                            <option value="Himachal Pradesh">Himachal Pradesh</option>
                            <option value="Jharkhand">Jharkhand</option>
                            <option value="Karnataka">Karnataka</option>
                            <option value="Kerala">Kerala</option>
                            <option value="Madhya Pradesh">Madhya Pradesh</option>
                            <option value="Maharashtra">Maharashtra</option>
                            <option value="Manipur">Manipur</option>
                            <option value="Meghalaya">Meghalaya</option>
                            <option value="Mizoram">Mizoram</option>
                            <option value="Nagaland">Nagaland</option>
                            <option value="Odisha">Odisha</option>
                            <option value="Punjab">Punjab</option>
                            <option value="Rajasthan">Rajasthan</option>
                            <option value="Sikkim">Sikkim</option>
                            <option value="Tamil Nadu">Tamil Nadu</option>
                            <option value="Telangana">Telangana</option>
                            <option value="Tripura">Tripura</option>
                            <option value="Uttar Pradesh">Uttar Pradesh</option>
                            <option value="Uttarakhand">Uttarakhand</option>
                            <option value="West Bengal">West Bengal</option>

                            <option value="Andaman and Nicobar Islands">
                                Andaman and Nicobar Islands
                            </option>

                            <option value="Chandigarh">Chandigarh</option>

                            <option value="Dadra and Nagar Haveli and Daman and Diu">
                                Dadra and Nagar Haveli and Daman and Diu
                            </option>

                            <option value="Delhi">Delhi</option>
                            <option value="Jammu and Kashmir">Jammu and Kashmir</option>
                            <option value="Ladakh">Ladakh</option>
                            <option value="Lakshadweep">Lakshadweep</option>
                            <option value="Puducherry">Puducherry</option>

                        </select>

                        <i class="fa-solid fa-map field-icon"></i>
                    </div>

                    <span class="text-danger error-text state_error"></span>
                </div>

                {{-- District --}}
                <div class="col-md-6">
                    <label class="form-label">
                        District <span class="required-star">*</span>
                    </label>

                    <div class="field-wrap">
                        <select class="form-select-custom"
                                id="ljLocationSel"
                                name="district">

                            <option value="">Select District</option>

                        </select>

                        <i class="fa-solid fa-location-crosshairs field-icon"></i>
                    </div>

                    <span class="text-danger error-text district_error"></span>
                </div>

                {{-- Status --}}
                <div class="col-md-6">
                    <label class="form-label">
                        Status
                    </label>

                    <div class="field-wrap">
                        <select name="status" class="form-select-custom">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>

                        <i class="fa-solid fa-toggle-on field-icon"></i>
                    </div>

                    <span class="text-danger error-text status_error"></span>
                </div>

            </div>

            {{-- Buttons --}}
            <div class="d-flex justify-content-end gap-3 mt-5">

                <a href="{{ route('admin.locations.index') }}"
                   class="btn btn-secondary btn-cancel">
                    Cancel
                </a>

                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk me-2"></i>
                    Save Location
                </button>

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

            url: "{{ route('admin.locations.store') }}",
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

                    $("#LocationForm")[0].reset();

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
                    });

                } else {

                    toastr.error("Something went wrong");

                }

            }

        });

    });

});

document.getElementById('ljStateSel').addEventListener('change', async function () {

    let state = this.value;
    let districtSel = document.getElementById('ljLocationSel');

    // reset
    districtSel.innerHTML = '<option value  ="">Loading...</option>';

    if (!state) {
        districtSel.innerHTML = '<option value="">District</option>';
        return;
    }

    try {
        let response = await fetch('https://countriesnow.space/api/v0.1/countries/state/cities', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                country: "India",
                state: state
            })
        });

        let result = await response.json();

        districtSel.innerHTML = '<option value="">District</option>';

        if (result.data && result.data.length > 0) {
            result.data.forEach(function (district) {
                let opt = document.createElement('option');
                opt.value = district;
                opt.textContent = district;
                districtSel.appendChild(opt);
            });
        } else {
            districtSel.innerHTML = '<option value="">No District Found</option>';
        }

    } catch (error) {
        console.error(error);
        districtSel.innerHTML = '<option value="">Error loading districts</option>';
    }
});

</script>