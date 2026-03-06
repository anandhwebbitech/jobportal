
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
                    @error('skill_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">
                        Skill Description
                    </label>

                    <textarea name="description"
                            class="form-control @error('description') is-invalid @enderror"
                            rows="3"
                            placeholder="Enter skill description">{{ old('description') }}</textarea>

                    @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <!-- Status -->
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-semibold">Status</label>
                    <select name="status"
                            class="form-select @error('status') is-invalid @enderror">
                        <option value="1" {{ old('status',1) == 1 ? 'selected' : '' }}>Active</option>
                        <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
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

<script>
 
</script>