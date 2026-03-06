@extends('admin.layouts.master')
@section('title', 'Application Settings')
@section('content')
    <main class="main" id="main">

        <!-- Top Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-0">Application Settings</h4>
                <small class="text-muted">Dashboard / Settings</small>
            </div>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary rounded-pill px-4">
                <i class="fa fa-arrow-left me-2"></i>Back to Dashboard
            </a>
        </div>

        <!-- Settings Card -->
        <div class="gloss p-4">

            @php
                $activeTab = session('activeTab', 'general');
            @endphp
            <!-- Tabs -->
            <ul class="nav nav-tabs nav-justified nav-border-top nav-border-success mb-4">

                <li class="nav-item">
                    <button type="button"
                        class="nav-link {{ $activeTab == 'general' ? 'active' : '' }} text-success"
                        data-bs-toggle="tab"
                        data-bs-target="#general">
                        General
                    </button>
                </li>

                <li class="nav-item">
                    <button type="button"
                        class="nav-link {{ $activeTab == 'email' ? 'active' : '' }} text-danger"
                        data-bs-toggle="tab"
                        data-bs-target="#email">
                        Email Config
                    </button>
                </li>

                <li class="nav-item">
                    <button type="button"
                        class="nav-link {{ $activeTab == 'payment' ? 'active' : '' }} text-primary"
                        data-bs-toggle="tab"
                        data-bs-target="#payment">
                        Payment Settings
                    </button>
                </li>

                <li class="nav-item">
                    <button type="button"
                        class="nav-link {{ $activeTab == 'profile' ? 'active' : '' }} text-warning"
                        data-bs-toggle="tab"
                        data-bs-target="#profile">
                        Profile
                    </button>
                </li>

            </ul>

            <div class="tab-content">

                <!-- ================= GENERAL ================= -->
                <div class="tab-pane fade {{ $activeTab == 'general' ? 'show active' : '' }}" id="general">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" id="settings-form">
                        @csrf
                        <input type="hidden" name="type" value="general">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Site Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="site_name" class="form-control"
                                    value="{{ old('site_name', setting('site_name')) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Site Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="site_email" class="form-control"
                                    value="{{ old('site_email', setting('site_email')) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Site Logo</label>
                                <input type="file" name="site_logo" class="form-control">
                            </div>

                            <div class="col-md-12">
                                <label class="form-label fw-semibold">Site Address</label>
                                <textarea name="site_address" class="form-control" rows="3">{{ old('site_address', setting('site_address')) }}</textarea>
                            </div>

                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                Save General Settings
                            </button>
                        </div>
                    </form>
                </div>

                <!-- ================= EMAIL ================= -->
                <div class="tab-pane fade {{ $activeTab == 'email' ? 'show active' : '' }}" id="email">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="email">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mail Host</label>
                                <input type="text" name="mail_host" class="form-control"
                                    value="{{ old('mail_host', setting('mail_host')) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mail Port</label>
                                <input type="text" name="mail_port" class="form-control"
                                    value="{{ old('mail_port', setting('mail_port')) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mail Username</label>
                                <input type="text" name="mail_username" class="form-control"
                                    value="{{ old('mail_username', setting('mail_username')) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Mail Password</label>
                                <input type="password" name="mail_password" class="form-control"
                                    value="{{ old('mail_password', setting('mail_password')) }}">
                            </div>

                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                Save Email Settings
                            </button>
                        </div>
                    </form>
                </div>

                <!-- ================= PAYMENT ================= -->
                <div class="tab-pane fade {{ $activeTab == 'payment' ? 'show active' : '' }}" id="payment">
                    <form action="{{ route('admin.settings.update') }}" method="POST">
                        @csrf
                        <input type="hidden" name="type" value="payment">
                        <div class="row g-4">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Client ID
                                </label>
                                <input type="text" name="payment_client_id" class="form-control"
                                    value="{{ old('payment_client_id', setting('payment_client_id')) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Secret Key
                                </label>
                                <input type="text" name="payment_secret_key" class="form-control"
                                    value="{{ old('payment_secret_key', setting('payment_secret_key')) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold d-block">
                                    Online Payment
                                </label>

                                <div class="form-check form-switch mt-2">
                                    <input class="form-check-input" type="checkbox" name="online_payment_status"
                                        value="1" {{ setting('online_payment_status') ? 'checked' : '' }}>
                                    <label class="form-check-label fw-semibold text-success">
                                        Enable Online Payment
                                    </label>
                                </div>
                            </div>

                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-primary rounded-pill px-4">
                                Save Payment Settings
                            </button>
                        </div>
                    </form>
                </div>

                <!-- ================= PROFILE ================= -->
                <div class="tab-pane fade {{ $activeTab == 'profile' ? 'show active' : '' }}" id="profile">

                    <!-- ===== Profile Edit Form ===== -->
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="type" value="profile">

                        <div class="row g-4">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" name="name" class="form-control"
                                    value="{{ old('name', auth()->user()->name) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" name="email" class="form-control"
                                    value="{{ old('email', auth()->user()->email) }}">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">Profile Image</label>
                                <input type="file" name="avatar" class="form-control" id="avatarInput">
                                <!-- Image Preview -->
                                <div class="mt-3 position-relative d-inline-block">
                                    @if(auth()->user()->avatar && file_exists(public_path(auth()->user()->avatar)))
                                        <img id="avatarPreview"
                                            src="{{ auth()->user()->avatar ? asset(auth()->user()->avatar) : 'https://via.placeholder.com/120' }}"
                                            alt="Profile Preview"
                                            class="rounded-circle border"
                                            width="120"
                                            height="120"
                                            style="object-fit: cover;">
                                        
                                        @if(auth()->user()->avatar)
                                            <div class="form-check mt-2">
                                                <input class="form-check-input" type="checkbox" name="remove_avatar" value="1" id="removeAvatar">
                                                <label class="form-check-label text-danger fw-semibold" for="removeAvatar">
                                                    Remove Profile Image
                                                </label>
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-success rounded-pill px-4">
                                Update Profile
                            </button>
                        </div>
                    </form>

                    <hr class="my-5">

                    <!-- ===== Password Update Form ===== -->
                    <form action="{{ route('admin.settings.update') }}" method="POST" id="password-form">
                        @csrf
                        <input type="hidden" name="type" value="password">

                        <div class="row g-4">

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Current Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="current_password" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    New Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="new_password" class="form-control">
                            </div>

                            <div class="col-md-6">
                                <label class="form-label fw-semibold">
                                    Confirm Password <span class="text-danger">*</span>
                                </label>
                                <input type="password" name="new_password_confirmation" class="form-control">
                            </div>

                        </div>

                        <div class="mt-4 text-end">
                            <button type="submit" class="btn btn-danger rounded-pill px-4">
                                Update Password
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>

    </main>

    @push('scripts')
    <script>
        document.getElementById('avatarInput').addEventListener('change', function(e) {
            const reader = new FileReader();

            reader.onload = function(event) {
                document.getElementById('avatarPreview').src = event.target.result;
            };

            reader.readAsDataURL(e.target.files[0]);
        });
    </script>
        <script>
            $(document).ready(function() {
                $('#settings-form').validate({
                    rules: {
                        site_name: {
                            required: true
                        },
                        site_email: {
                            required: true,
                            email: true
                        }
                    },
                    messages: {
                        site_name: {
                            required: "Please enter site name"
                        },
                        site_email: {
                            required: "Please enter site email"
                        }
                    },
                    errorClass: 'text-danger',
                    errorElement: 'div',
                    highlight: function(element) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element) {
                        $(element).removeClass('is-invalid');
                    }
                });
                $('#password-form').validate({
                    rules: {
                        current_password: {
                            required: true
                        },
                        new_password: {
                            required: true,
                            minlength: 6
                        },
                        new_password_confirmation: {
                            required: true,
                            equalTo: '[name="new_password"]'
                        }
                    },
                    messages: {
                        current_password: {
                            required: "Please enter your current password"
                        },
                        new_password: {
                            required: "Please enter a new password",
                            minlength: "Password must be at least 6 characters"
                        },
                        new_password_confirmation: {
                            required: "Please confirm your new password",
                            equalTo: "Passwords do not match"
                        }
                    },
                    errorClass: 'text-danger',
                    errorElement: 'div',
                    highlight: function(element) {
                        $(element).addClass('is-invalid');
                    },
                    unhighlight: function(element) {
                        $(element).removeClass('is-invalid');
                    }
                });
            });
        </script>
    @endpush
@endsection
