<form id="SkillForm" action="{{ route('admin.skills.update', $skill->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="card shadow-sm border-0">
        <div class="card-body">
            <div class="row">

                <!-- Skill Name -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">
                        Skill Name <span class="text-danger">*</span>
                    </label>
                    <input type="text"
                           name="skill_name"
                           class="form-control @error('skill_name') is-invalid @enderror"
                           value="{{ old('skill_name', $skill->skill_name) }}"
                           placeholder="Enter skill name">

                    @error('skill_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Description -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">
                        Skill Description
                    </label>

                    <textarea name="description"
                              class="form-control @error('description') is-invalid @enderror"
                              rows="3"
                              placeholder="Enter skill description">{{ old('description', $skill->description) }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Status -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status"
                            class="form-select @error('status') is-invalid @enderror">

                        <option value="1" {{ old('status', $skill->status) == 1 ? 'selected' : '' }}>
                            Active
                        </option>

                        <option value="0" {{ old('status', $skill->status) == 0 ? 'selected' : '' }}>
                            Inactive
                        </option>

                    </select>

                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

            </div>

            <!-- Buttons -->
            <div class="text-end mt-4">
                <button type="submit" class="btn btn-success rounded-pill px-4">
                    <i class="fa fa-save me-2"></i>Update Skill
                </button>

                <a href="{{ route('admin.skills.index') }}" class="btn btn-secondary rounded-pill px-4">
                    Cancel
                </a>
            </div>

        </div>
    </div>
</form>
<script>
$(document).ready(function () {

    $('#SkillForm').validate({
        rules: {
            skill_name: {
                required: true,
                minlength: 2,
                maxlength: 100
            },
            description: {
                maxlength: 500
            }
        },

        messages: {
            skill_name: {
                required: "Skill name is required",
                minlength: "Minimum 2 characters required"
            }
        },

        errorElement: 'span',
        errorClass: 'text-danger small',

        highlight: function (element) {
            $(element).addClass('is-invalid');
        },

        unhighlight: function (element) {
            $(element).removeClass('is-invalid');
        }

    });

});
</script>