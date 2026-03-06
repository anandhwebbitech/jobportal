<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin Login</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    @include('admin.layouts.css_master')

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #e6f7f1, #c8f0e1, #e9fbf5);
            min-height: 100vh;
        }
        .error{
            color:#dc3545;
        }
        .login-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-card {
            width: 100%;
            max-width: 420px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 24px;
            padding: 40px 35px;
            border: 1px solid rgba(16, 185, 129, 0.15);
            box-shadow: 0 25px 60px rgba(16, 185, 129, 0.15);
        }

        .login-logo {
            height: 55px;
        }

        .login-title {
            color: #065f46;
            font-weight: 700;
        }

        .form-label {
            font-weight: 600;
            color: #065f46;
        }

        /* Username Field */
        .form-control {
            border-radius: 12px;
            background: #f5fdf9;
            border: 1px solid #e0f2ea;
            height: 48px;
        }

        .form-control:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
            border-color: #10b981;
            background: #fff;
        }

        /* Password Box */
        .password-box {
            position: relative;
            display: flex;
            align-items: center;
            height: 48px;
            background: #f5fdf9;
            border: 1px solid #e0f2ea;
            border-radius: 12px;
            transition: 0.2s ease;
        }

        .password-box:focus-within {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
            background: #fff;
        }

        .password-input {
            width: 100%;
            height: 100%;
            border: none;
            outline: none;
            background: transparent;
            padding: 0 70px 0 40px;
        }

        .left-icon {
            position: absolute;
            left: 14px;
        }

        .right-icon {
            position: absolute;
            right: 14px;
            cursor: pointer;
        }

        .char-count {
            position: absolute;
            right: 40px;
            font-size: 12px;
            color: #dc3545;
            font-weight: 500;
        }

        .password-box.error {
            border-color: #dc3545;
            box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.15);
        }

        .login-btn {
            height: 48px;
            border-radius: 14px;
            font-weight: 600;
            background: linear-gradient(135deg, #10b981, #059669);
            border: none;
            color: #fff;
        }

        .login-btn:hover {
            background: linear-gradient(135deg, #059669, #047857);
        }
    </style>
</head>

<body>
<div class="login-wrapper">
    <div class="login-card">

        <div class="text-center mb-4">
            <img src="{{ asset('frontend/logo3.png') }}" class="login-logo mb-3">
            <h4 class="login-title">Admin Login</h4>
            <p class="text-muted small">Welcome back! Please login to continue.</p>
        </div>

        <form id="adminLoginForm" method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            {{-- Username --}}
            <div class="mb-3">
                <label class="form-label">Username / Email</label>
                <input type="text"
                       name="username"
                       id="username"
                       class="form-control" value="{{ old('username')}}"
                       placeholder="Enter your username or email">
            </div>

            {{-- Password --}}
            <div class="mb-4">
                <label class="form-label">Password</label>

                <div class="password-box" id="passwordBox">
                    <span class="left-icon">
                        <i class="fa-solid fa-lock text-success"></i>
                    </span>

                    <input type="password"
                           name="password"
                           id="password"
                           class="password-input"
                           placeholder="Enter your password">

                    {{-- <span class="char-count" id="charCount">0</span> --}}

                    <span class="right-icon" id="togglePassword">
                        <i class="fa-solid fa-eye text-success" id="toggleIcon"></i>
                    </span>
                </div>

                <span class="text-danger small d-block mt-1" id="password-error"></span>
            </div>

            <button type="submit" id="loginBtn" class="btn login-btn w-100">
                <span class="btn-text">
                    <i class="fa-solid fa-right-to-bracket me-2"></i>
                    Login to Dashboard
                </span>

                <span class="btn-loader d-none">
                    <i class="fa fa-spinner fa-spin me-2"></i>
                    Logging in...
                </span>
            </button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.21.0/jquery.validate.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css"/>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
    $(document).ready(function () {

        $('#adminLoginForm').on('submit', function () {

            if ($(this).valid()) {
                $('#loginBtn').prop('disabled', true);

                $('#loginBtn .btn-text').addClass('d-none');
                $('#loginBtn .btn-loader').removeClass('d-none');
            }

        });

    });
</script>
<script>
$(function(){

    // Eye Toggle
    $("#togglePassword").click(function(){
        let input = $("#password");
        let icon = $("#toggleIcon");

        if(input.attr("type") === "password"){
            input.attr("type","text");
            icon.removeClass("fa-eye").addClass("fa-eye-slash");
        } else {
            input.attr("type","password");
            icon.removeClass("fa-eye-slash").addClass("fa-eye");
        }
    });

    // Character Counter
    $("#password").on("input", function(){
        let length = $(this).val().length;
        $("#charCount").text(length);

        if(length > 0 && length < 6){
            $("#passwordBox").addClass("error");
            $("#password-error").text("Minimum 6 characters required");
        } else {
            $("#passwordBox").removeClass("error");
            $("#password-error").text("");
        }
    });

    // jQuery Validation
    $("#adminLoginForm").validate({
        rules:{
            username:{ required:true, minlength:3 },
            password:{ required:true, minlength:6 }
        },
        messages:{
            username:{
                required:"Please enter username or email",
                minlength:"Minimum 3 characters required"
            },
            password:{
                required:"Please enter password",
                minlength:"Minimum 6 characters required"
            }
        },
        errorPlacement:function(error, element){
            if(element.attr("name") === "password"){
                $("#password-error").text(error.text());
                $("#passwordBox").addClass("error");
            } else {
                error.insertAfter(element);
            }
        }
    });

    // Toastr
    @if(session('success'))
        toastr.success("{{ session('success') }}");
    @endif

    @if(session('error'))
        toastr.error("{{ session('error') }}");
    @endif

});
</script>

</body>
</html>