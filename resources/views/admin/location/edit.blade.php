<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<form id="LocationForm" method="POST">
    @csrf
    @method('PUT')

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
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
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
            border-color: #2563eb;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(37,99,235,.12);
        }

        .field-wrap {
            position: relative;
        }

        .field-icon {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            pointer-events: none;
        }

        .required-star {
            color: #ef4444;
        }

        .btn-update {
            height: 50px;
            border-radius: 14px;
            padding: 0 28px;
            border: none;
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: #fff;
            font-weight: 700;
            transition: .25s ease;
            box-shadow: 0 10px 25px rgba(37,99,235,.22);
        }

        .btn-update:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(37,99,235,.30);
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
                <i class="fa-solid fa-pen-to-square me-2"></i>
                Edit Location
            </h4>

            <p>
                Update state, district and status information.
            </p>
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

                        <input type="text"
                               name="state"
                               class="form-control-custom"
                               value="{{ $location->state }}"
                               placeholder="Example: Tamil Nadu">

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

                        <input type="text"
                               name="district"
                               class="form-control-custom"
                               value="{{ $location->district }}"
                               placeholder="Example: Chennai">

                        <i class="fa-solid fa-location-dot field-icon"></i>
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

                            <option value="1"
                                {{ $location->status == 1 ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0"
                                {{ $location->status == 0 ? 'selected' : '' }}>
                                Inactive
                            </option>

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

                <button type="submit" class="btn-update">
                    <i class="fa-solid fa-floppy-disk me-2"></i>
                    Update Location
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