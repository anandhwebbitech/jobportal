@extends('frontend.app')
@section('title', 'Forgot Password – LinearJobs')

@push('styles')
    <style>
        .reset-wrap {
            min-height: 100vh;
            background: #f4f7fb;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px 15px;
        }

        .reset-card {
            width: 100%;
            max-width: 500px;
            background: #fff;
            border-radius: 20px;
            padding: 35px;
            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);
        }

        .reset-logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .reset-logo h2 {
            font-weight: 700;
            color: #111827;
            margin-bottom: 8px;
        }

        .reset-logo p {
            color: #6b7280;
            font-size: 14px;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 8px;
            color: #111827;
        }

        .form-control {
            height: 52px;
            border-radius: 12px;
            border: 1px solid #d1d5db;
            padding-left: 15px;
            font-size: 15px;
        }

        .form-control:focus {
            box-shadow: none;
            border-color: #16a34a;
        }

        .reset-btn {
            width: 100%;
            height: 52px;
            border: none;
            border-radius: 12px;
            background: #16a34a;
            color: #fff;
            font-weight: 600;
            font-size: 16px;
            transition: .3s;
        }

        .reset-btn:hover {
            background: #15803d;
        }

        .alert {
            border-radius: 12px;
        }
    </style>
@endpush
@section('content')

    <div class="reset-wrap">
        <div class="reset-card">
            <div class="reset-logo">
                <h2>Reset Password</h2>
                <p>Create your new password below</p>
            </div> {{-- SUCCESS --}} @if (session('success'))
                <div class="alert alert-success"> {{ session('success') }} </div>
                @endif {{-- ERROR --}} @if (session('error'))
                    <div class="alert alert-danger"> {{ session('error') }} </div>
                @endif
                <form method="POST" action="{{ route('password.update') }}"> @csrf {{-- TOKEN --}} <input type="hidden"
                        name="token" value="{{ $token }}"> {{-- EMAIL --}} <div class="mb-3"> <label
                            class="form-label"> Email Address </label> <input type="email" name="email"
                            class="form-control @error('email') is-invalid @enderror" value="{{ request()->email }}"
                            required> @error('email')
                            <small class="text-danger"> {{ $message }} </small>
                        @enderror
                    </div> {{-- PASSWORD --}} <div class="mb-3"> <label class="form-label"> New Password </label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Enter new password" required> @error('password')
                            <small class="text-danger"> {{ $message }} </small>
                        @enderror
                    </div> {{-- CONFIRM PASSWORD --}} <div class="mb-4"> <label class="form-label"> Confirm Password </label>
                        <input type="password" name="password_confirmation" class="form-control"
                            placeholder="Confirm password" required> </div> {{-- BUTTON --}} <button type="submit"
                        class="reset-btn"> Reset Password </button> </form>
        </div>
    </div>
@endsection
