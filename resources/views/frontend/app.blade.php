<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <meta name="description" content="LinearJobs – Tamil Nadu's most trusted job platform connecting skilled professionals with verified MSME employers."/>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>@yield('title', 'LinearJobs – Find Your Next Job in Tamil Nadu')</title>
  {{-- Bootstrap 5 --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap.min.css" rel="stylesheet"/>
  {{-- Font Awesome --}}
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet"/>
  {{-- Google Fonts --}}
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet"/>

  {{-- Global CSS --}}
  <link href="{{ asset('frontend/css/lj-global.css') }}" rel="stylesheet"/>
<!-- ✅ 1. jQuery FIRST -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<!-- ✅ 2. Toastr CSS -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

<!-- ✅ 3. Toastr JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  {{-- Page-specific CSS --}}
  @stack('styles')
</head>
<body>

  {{-- HEADER --}}
  @include('frontend.partials.header')

  {{-- MAIN CONTENT --}}
  <main id="ljMain">
    @yield('content')
  </main>

  {{-- FOOTER --}}
  @include('frontend.partials.footer')

  {{-- Scroll to Top --}}
  <button class="lj-totop" id="ljToTop" aria-label="Scroll to top">
    <i class="fas fa-chevron-up"></i>
  </button>

  {{-- Bootstrap JS --}}
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.bundle.min.js"></script>

  {{-- Global JS --}}
  <script src="{{ asset('frontend/js/lj-global.js') }}"></script>

  {{-- Page-specific JS --}}
  @stack('scripts')
</body>
</html>