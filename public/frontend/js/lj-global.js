/* ═══════════════════════════════════════════════════════════
   lj-global.js  — LinearJobs Global JavaScript
   Place at: public/js/lj-global.js
═══════════════════════════════════════════════════════════ */

(function () {
  'use strict';

  /* ── HAMBURGER / DRAWER ─────────────────────────────────── */
  const ham    = document.getElementById('ljHam');
  const hamIco = document.getElementById('ljHamIco');
  const drawer = document.getElementById('ljDrawer');

  function openDrawer() {
    drawer.classList.add('is-open');
    ham.setAttribute('aria-expanded', 'true');
    hamIco.className = 'fas fa-times';
    document.body.style.overflow = 'hidden';
  }
  function closeDrawer() {
    drawer.classList.remove('is-open');
    ham.setAttribute('aria-expanded', 'false');
    hamIco.className = 'fas fa-bars';
    document.body.style.overflow = '';
  }

  if (ham && drawer) {
    ham.addEventListener('click', () => {
      drawer.classList.contains('is-open') ? closeDrawer() : openDrawer();
    });

    // close on link click
    drawer.querySelectorAll('a, button').forEach(el => {
      el.addEventListener('click', closeDrawer);
    });

    // close on outside click
    document.addEventListener('click', (e) => {
      if (drawer.classList.contains('is-open') &&
          !drawer.contains(e.target) &&
          !ham.contains(e.target)) {
        closeDrawer();
      }
    });

    // close on Escape
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && drawer.classList.contains('is-open')) closeDrawer();
    });
  }

  /* ── SCROLL TO TOP ──────────────────────────────────────── */
  const toTop = document.getElementById('ljToTop');
  if (toTop) {
    window.addEventListener('scroll', () => {
      toTop.classList.toggle('is-vis', window.scrollY > 300);
    }, { passive: true });
    toTop.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* ── COUNTER ANIMATION ──────────────────────────────────── */
  function fmtCount(n, target) {
    if (target >= 1000) {
      const k = n / 1000;
      return (k % 1 === 0 ? k.toFixed(0) : k.toFixed(1)) + 'k+';
    }
    return n + (target > 10 ? '+' : '');
  }
  function runCount(el) {
    const target = parseInt(el.dataset.count, 10);
    if (isNaN(target)) return;
    let cur = 0;
    const inc = target / 90;
    const id = setInterval(() => {
      cur = Math.min(cur + inc, target);
      el.textContent = fmtCount(Math.floor(cur), target);
      if (cur >= target) {
        clearInterval(id);
        el.textContent = fmtCount(target, target);
      }
    }, 16);
  }

  const countEls = document.querySelectorAll('[data-count]');
  if (countEls.length) {
    const cObs = new IntersectionObserver((entries, obs) => {
      entries.forEach(e => {
        if (e.isIntersecting) { runCount(e.target); obs.unobserve(e.target); }
      });
    }, { threshold: 0.5 });
    countEls.forEach(el => cObs.observe(el));
  }

  /* ── SCROLL REVEAL ──────────────────────────────────────── */
  const revEls = document.querySelectorAll('[data-reveal]');
  if (revEls.length) {
    const rObs = new IntersectionObserver((entries) => {
      entries.forEach((e, i) => {
        if (e.isIntersecting) {
          const delay = parseFloat(e.target.dataset.revealDelay || 0) || (i * 0.07);
          e.target.style.animation = `ljUp .45s ease ${delay}s both`;
          e.target.style.opacity = '';
          rObs.unobserve(e.target);
        }
      });
    }, { threshold: 0.08 });

    revEls.forEach(el => {
      el.style.opacity = '0';
      rObs.observe(el);
    });
  }

  /* ── ACTIVE NAV LINK (SPA-like) ─────────────────────────── */
  // Already handled via Blade @routeIs, but add JS fallback
  const navLinks = document.querySelectorAll('.lj-nav-links li a');
  navLinks.forEach(link => {
    if (link.href === window.location.href) {
      link.closest('li')?.classList.add('lj-cur');
    }
  });

  /* ── SEARCH (if search box present) ────────────────────── */
  const searchBtn   = document.getElementById('ljSearchBtn');
  const searchBox   = document.getElementById('ljSearchBox');
  const searchInput = document.getElementById('ljSearchInput');
  const skillSel    = document.getElementById('ljSkillSel');
  const locSel      = document.getElementById('ljLocSel');

  function doSearch() {
    if (!searchBox || !searchInput) return;
    const title = searchInput.value.trim();
    const skill = skillSel?.value || '';
    const loc   = locSel?.value   || '';

    if (!title && !skill && !loc) {
      searchBox.style.borderColor = 'var(--red)';
      searchBox.style.boxShadow   = '0 0 0 3px rgba(217,48,37,.12)';
      searchInput.focus();
      setTimeout(() => {
        searchBox.style.borderColor = '';
        searchBox.style.boxShadow   = '';
      }, 2000);
      return;
    }
    const p = new URLSearchParams();
    if (title) p.set('q', title);
    if (skill) p.set('skill', skill);
    if (loc)   p.set('location', loc);
    window.location.href = '/jobs?' + p.toString();
  }

  // if (searchBtn)   searchBtn.addEventListener('click', doSearch);
  if (searchInput) searchInput.addEventListener('keydown', e => { if (e.key === 'Enter') doSearch(); });

  /* ── CHIP → FILL SEARCH ─────────────────────────────────── */
  document.querySelectorAll('.lj-chip[data-search], .lj-trend-tag[data-search]').forEach(c => {
    c.addEventListener('click', () => {
      if (searchInput) {
        searchInput.value = c.textContent.trim();
        searchInput.focus();
        document.getElementById('ljSearchBox')?.scrollIntoView({ behavior: 'smooth', block: 'center' });
      } else {
        // If not on home page, redirect to jobs with query
        window.location.href = '/jobs?q=' + encodeURIComponent(c.textContent.trim());
      }
    });
  });

  /* ── PAGINATION ─────────────────────────────────────────── */
  document.querySelectorAll('.lj-pg-btn').forEach(btn => {
    btn.addEventListener('click', function () {
      if (this.disabled || this.querySelector('i')) return;
      document.querySelectorAll('.lj-pg-btn').forEach(b => b.classList.remove('active'));
      this.classList.add('active');
    });
  });

  /* ── AUTO-DISMISS ALERTS ────────────────────────────────── */
  document.querySelectorAll('.lj-alert[data-auto-dismiss]').forEach(alert => {
    const ms = parseInt(alert.dataset.autoDismiss, 10) || 4000;
    setTimeout(() => {
      alert.style.transition = 'opacity .4s';
      alert.style.opacity = '0';
      setTimeout(() => alert.remove(), 400);
    }, ms);
  });

  /* ── FLASH MESSAGE CLOSE ────────────────────────────────── */
  document.querySelectorAll('[data-dismiss-alert]').forEach(btn => {
    btn.addEventListener('click', () => {
      btn.closest('.lj-alert')?.remove();
    });
  });

})();