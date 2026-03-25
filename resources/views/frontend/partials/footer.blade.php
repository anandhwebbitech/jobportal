
{{-- ═══════════════════════════════════════════════════
     resources/views/frontend/partials/footer.blade.php
═══════════════════════════════════════════════════ --}}

<footer class="lj-footer">
  <div class="lj-wrap">
    <div class="lj-footer-grid">

      {{-- ── Brand Column ── --}}
      <div class="lj-footer-col lj-footer-brand-col">
        <div class="lj-ft-brand">LinearJobs</div>
        <div class="lj-ft-about">
          Tamil Nadu's most trusted job platform connecting skilled professionals
          with verified MSME employers since 2024.
        </div>
        <div class="lj-ft-social">
          <a href="#" class="lj-ft-sico" aria-label="Facebook">
            <i class="fab fa-facebook-f"></i>
          </a>
          <a href="#" class="lj-ft-sico" aria-label="Instagram">
            <i class="fab fa-instagram"></i>
          </a>
          <a href="#" class="lj-ft-sico" aria-label="LinkedIn">
            <i class="fab fa-linkedin-in"></i>
          </a>
          <a href="#" class="lj-ft-sico" aria-label="WhatsApp">
            <i class="fab fa-whatsapp"></i>
          </a>
          <a href="#" class="lj-ft-sico" aria-label="YouTube">
            <i class="fab fa-youtube"></i>
          </a>
        </div>
      </div>

      {{-- ── Job Seekers Column ── --}}
      <div class="lj-footer-col">
        <div class="lj-ft-head">Job Seekers</div>
        <a href="{{ route('jobs.index') }}"    class="lj-ft-link">Browse Jobs</a>
        <a href="{{ route('jobseeker.login') }}"          class="lj-ft-link">Login</a>
        <a href="{{ route('jobseeker.register') }}"       class="lj-ft-link">Register</a>
        <a href="{{ route('home') }}"  class="lj-ft-link">Upload Resume</a>
        <a href="{{ route('home') }}"  class="lj-ft-link">Career Advice</a>
      </div>

      {{-- ── Employers Column ── --}}
      <div class="lj-footer-col">
        <div class="lj-ft-head">Employers</div>
        <a href="{{ route('post-job') }}"            class="lj-ft-link">Post a Job</a>
        <a href="{{ route('employer.login') }}"      class="lj-ft-link">Employer Login</a>
        <a href="{{ route('employer.register') }}"   class="lj-ft-link">Register Company</a>
        <a href="{{ route('pricing') }}"             class="lj-ft-link">Pricing Plans</a>
        <a href="{{ route('jobs.index') }}"          class="lj-ft-link">Hire Talent</a>
      </div>

      {{-- ── Contact Column ── --}}
      <div class="lj-footer-col">
        <div class="lj-ft-head">Contact</div>
        <a href="{{ route('about') }}"           class="lj-ft-link">About Us</a>
        <a href="{{ route('home') }}"         class="lj-ft-link">Privacy Policy</a>
        <a href="{{ route('home') }}"           class="lj-ft-link">Terms &amp; Conditions</a>

        <div class="lj-ft-contact">
          <i class="fas fa-envelope"></i>
          <span>support@linearjobs.com</span>
        </div>
        <div class="lj-ft-contact">
          <i class="fas fa-phone"></i>
          <span>+91 XXXXX XXXXX</span>
        </div>
        <div class="lj-ft-contact">
          <i class="fas fa-location-dot"></i>
          <span>Tamil Nadu, India</span>
        </div>
      </div>

    </div>{{-- /lj-footer-grid --}}

    {{-- ── Bottom Bar ── --}}
    <div class="lj-footer-bar">
      <div class="lj-ft-copy">
        &copy; {{ date('Y') }} LinearJobs. All rights reserved.
        Made with <span style="color:#e25555;">❤️</span> in Tamil Nadu.
      </div>
      <div class="lj-ft-legal">
        <a href="{{ route('home') }}">Privacy Policy</a>
        <a href="{{ route('home') }}">Terms &amp; Conditions</a>
        <a href="{{ route('home') }}">Accessibility</a>
      </div>
    </div>

  </div>
  <script>
    // ✅ ADD HERE (GLOBAL CONFIG)
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: 4000
    };
</script>
</footer>