<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Register – LinearJobs</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,400&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" />
<style>
/* ═══════════════════════════════════════
   CSS VARIABLES
═══════════════════════════════════════ */
:root {
  --blue: #1a56db;
  --blue-d: #1e3a8a;
  --blue-lt: rgba(26,86,219,.07);
  --green: #16a34a;
  --amber: #d97706;
  --n50: #f8f9fb;
  --n100: #f1f2f5;
  --n200: #e4e6ed;
  --n300: #c8ccd8;
  --n400: #9297aa;
  --n500: #6b7280;
  --n600: #4b5160;
  --n700: #374151;
  --n800: #1f2937;
  --n900: #111827;
  --r: 10px;
  --r-lg: 16px;
  --sh: 0 2px 8px rgba(0,0,0,.06), 0 1px 3px rgba(0,0,0,.04);
  --sh-md: 0 4px 20px rgba(0,0,0,.08), 0 2px 8px rgba(0,0,0,.04);
  --sh-lg: 0 12px 40px rgba(0,0,0,.12), 0 4px 16px rgba(0,0,0,.06);
  --t: .18s ease;
  --f:  'Plus Jakarta Sans', sans-serif;
  --fh: 'Outfit', sans-serif;
}

* { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: var(--f);
  background: var(--n50);
  color: var(--n900);
  min-height: 100vh;
  overflow-x: hidden;
}

/* ═══════════════════════════════════════
   NAVBAR
═══════════════════════════════════════ */
.navbar {
  background: #fff;
  border-bottom: 1.5px solid var(--n200);
  padding: 0 32px;
  height: 64px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  position: sticky;
  top: 0;
  z-index: 200;
}
.logo {
  font-family: var(--fh);
  font-size: 1.5rem;
  font-weight: 800;
  color: var(--blue);
  letter-spacing: -.5px;
  text-decoration: none;
}
.logo span { color: var(--n900); }
.nav-link {
  font-size: .875rem;
  font-weight: 500;
  color: var(--n500);
  text-decoration: none;
  transition: color var(--t);
}
.nav-link:hover { color: var(--blue); }

/* ═══════════════════════════════════════
   PAGES
═══════════════════════════════════════ */
.page { display: none; }
.page.active { display: block; }

/* ═══════════════════════════════════════
   SELECTION PAGE
═══════════════════════════════════════ */
.sel-page {
  min-height: calc(100vh - 64px);
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  padding: 40px 20px 60px;
  background: var(--n50);
  position: relative;
  overflow: hidden;
}

/* Decorative background blobs */
.sel-page::before {
  content: '';
  position: absolute;
  top: -120px; right: -120px;
  width: 480px; height: 480px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(26,86,219,.07) 0%, transparent 70%);
  pointer-events: none;
}
.sel-page::after {
  content: '';
  position: absolute;
  bottom: -100px; left: -100px;
  width: 400px; height: 400px;
  border-radius: 50%;
  background: radial-gradient(circle, rgba(22,163,74,.06) 0%, transparent 70%);
  pointer-events: none;
}

.sel-eyebrow {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: rgba(26,86,219,.08);
  border: 1.5px solid rgba(26,86,219,.15);
  border-radius: 100px;
  padding: 6px 16px;
  font-size: .78rem;
  font-weight: 600;
  color: var(--blue);
  margin-bottom: 24px;
  animation: fadeUp .5s ease both;
}

.sel-title {
  font-family: var(--fh);
  font-size: clamp(2rem, 5vw, 3rem);
  font-weight: 800;
  color: var(--n900);
  text-align: center;
  letter-spacing: -.04em;
  line-height: 1.15;
  margin-bottom: 14px;
  animation: fadeUp .5s .08s ease both;
}
.sel-title .accent {
  background: linear-gradient(135deg, #1a56db, #7c3aed);
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
  background-clip: text;
}

.sel-sub {
  font-size: 1.05rem;
  color: var(--n500);
  text-align: center;
  max-width: 480px;
  line-height: 1.65;
  margin-bottom: 52px;
  animation: fadeUp .5s .14s ease both;
}

/* Cards grid */
.sel-grid {
  display: grid;
  grid-template-columns: 1fr 1fr;
  gap: 24px;
  max-width: 760px;
  width: 100%;
  animation: fadeUp .5s .2s ease both;
}

.sel-card {
  background: #fff;
  border: 2px solid var(--n200);
  border-radius: 20px;
  padding: 40px 36px;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  transition: all .28s cubic-bezier(.34,1.56,.64,1);
  text-align: center;
  box-shadow: var(--sh);
}

.sel-card::before {
  content: '';
  position: absolute;
  inset: 0;
  opacity: 0;
  transition: opacity .28s ease;
  border-radius: inherit;
}

.sel-card.jobseeker::before {
  background: linear-gradient(135deg, rgba(26,86,219,.04), rgba(124,58,237,.04));
}
.sel-card.employer::before {
  background: linear-gradient(135deg, rgba(22,163,74,.04), rgba(5,150,105,.04));
}

.sel-card:hover {
  border-color: transparent;
  transform: translateY(-6px) scale(1.015);
  box-shadow: 0 20px 60px rgba(0,0,0,.12), 0 6px 20px rgba(0,0,0,.06);
}
.sel-card.jobseeker:hover { border-color: rgba(26,86,219,.4); }
.sel-card.employer:hover { border-color: rgba(22,163,74,.4); }
.sel-card:hover::before { opacity: 1; }

.sel-card-glow {
  position: absolute;
  top: -30px; left: 50%;
  transform: translateX(-50%);
  width: 160px; height: 80px;
  border-radius: 50%;
  filter: blur(30px);
  opacity: 0;
  transition: opacity .28s ease;
  pointer-events: none;
}
.sel-card.jobseeker .sel-card-glow { background: rgba(26,86,219,.25); }
.sel-card.employer .sel-card-glow { background: rgba(22,163,74,.25); }
.sel-card:hover .sel-card-glow { opacity: 1; }

.sel-card-ico {
  width: 76px; height: 76px;
  border-radius: 20px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.75rem;
  margin: 0 auto 24px;
  position: relative;
  transition: transform .28s cubic-bezier(.34,1.56,.64,1);
}
.sel-card.jobseeker .sel-card-ico {
  background: linear-gradient(135deg, #dbeafe, #ede9fe);
  color: #1a56db;
  box-shadow: 0 4px 16px rgba(26,86,219,.18);
}
.sel-card.employer .sel-card-ico {
  background: linear-gradient(135deg, #dcfce7, #d1fae5);
  color: #16a34a;
  box-shadow: 0 4px 16px rgba(22,163,74,.18);
}
.sel-card:hover .sel-card-ico { transform: scale(1.1) rotate(-3deg); }

.sel-card-title {
  font-family: var(--fh);
  font-size: 1.4rem;
  font-weight: 800;
  color: var(--n900);
  letter-spacing: -.03em;
  margin-bottom: 10px;
}

.sel-card-desc {
  font-size: .875rem;
  color: var(--n500);
  line-height: 1.65;
  margin-bottom: 28px;
}

.sel-card-features {
  list-style: none;
  text-align: left;
  margin-bottom: 32px;
  display: flex;
  flex-direction: column;
  gap: 8px;
}
.sel-card-features li {
  display: flex;
  align-items: center;
  gap: 9px;
  font-size: .82rem;
  color: var(--n600);
  font-weight: 500;
}
.sel-card-features li i {
  font-size: .7rem;
  width: 18px; height: 18px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  flex-shrink: 0;
}
.sel-card.jobseeker .sel-card-features li i { background: #dbeafe; color: #1a56db; }
.sel-card.employer .sel-card-features li i { background: #dcfce7; color: #16a34a; }

.sel-card-btn {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 9px;
  width: 100%;
  border: none;
  border-radius: 12px;
  padding: 13px 24px;
  font-family: var(--fh);
  font-size: .9375rem;
  font-weight: 700;
  cursor: pointer;
  transition: all .2s ease;
  letter-spacing: -.01em;
}
.sel-card.jobseeker .sel-card-btn {
  background: linear-gradient(135deg, #1a56db, #2563eb);
  color: #fff;
  box-shadow: 0 4px 16px rgba(26,86,219,.3);
}
.sel-card.employer .sel-card-btn {
  background: linear-gradient(135deg, #16a34a, #22c55e);
  color: #fff;
  box-shadow: 0 4px 16px rgba(22,163,74,.3);
}
.sel-card-btn:hover { transform: translateY(-1px); filter: brightness(1.05); }

.sel-card-tag {
  position: absolute;
  top: 16px; right: 16px;
  font-size: .68rem;
  font-weight: 700;
  padding: 3px 10px;
  border-radius: 100px;
  letter-spacing: .03em;
  text-transform: uppercase;
}
.sel-card.jobseeker .sel-card-tag { background: #dbeafe; color: #1d4ed8; }
.sel-card.employer .sel-card-tag { background: #dcfce7; color: #15803d; }

.sel-divider {
  text-align: center;
  margin-top: 36px;
  font-size: .875rem;
  color: var(--n400);
  animation: fadeUp .5s .28s ease both;
}
.sel-divider a { color: var(--blue); font-weight: 600; text-decoration: none; }
.sel-divider a:hover { text-decoration: underline; }

/* Trust strip */
.trust-strip {
  display: flex;
  align-items: center;
  justify-content: center;
  gap: 24px;
  margin-top: 52px;
  flex-wrap: wrap;
  animation: fadeUp .5s .32s ease both;
}
.trust-item {
  display: flex;
  align-items: center;
  gap: 7px;
  font-size: .78rem;
  color: var(--n400);
  font-weight: 500;
}
.trust-item i { color: var(--green); font-size: .8rem; }

@keyframes fadeUp {
  from { opacity: 0; transform: translateY(20px); }
  to { opacity: 1; transform: translateY(0); }
}

/* ═══════════════════════════════════════
   REGISTRATION PAGE (shared styles)
═══════════════════════════════════════ */
.reg-page {
  background: var(--n50);
  min-height: calc(100vh - 64px);
  padding: 36px 20px 60px;
}
.reg-wrap { max-width: 860px; margin: 0 auto; }

/* Back button */
.reg-back {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  font-size: .875rem;
  font-weight: 600;
  color: var(--n500);
  background: #fff;
  border: 1.5px solid var(--n200);
  border-radius: var(--r);
  padding: 8px 16px;
  cursor: pointer;
  margin-bottom: 28px;
  transition: all var(--t);
  text-decoration: none;
}
.reg-back:hover { color: var(--blue); border-color: var(--blue); background: var(--blue-lt); }

/* Header */
.reg-head { text-align: center; margin-bottom: 32px; }
.reg-head-ico {
  width: 64px; height: 64px;
  border-radius: 18px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  margin: 0 auto 16px;
}
.reg-head-ico.blue {
  background: linear-gradient(135deg, #dbeafe, #ede9fe);
  color: var(--blue);
  box-shadow: 0 6px 20px rgba(26,86,219,.2);
}
.reg-head-ico.green {
  background: linear-gradient(135deg, #dcfce7, #d1fae5);
  color: var(--green);
  box-shadow: 0 6px 20px rgba(22,163,74,.2);
}
.reg-head-title {
  font-family: var(--fh);
  font-size: 1.85rem;
  font-weight: 800;
  color: var(--n900);
  letter-spacing: -.04em;
  margin-bottom: 8px;
}
.reg-head-sub { font-size: .9rem; color: var(--n500); line-height: 1.6; }

/* Steps */
.lj-steps {
  display: flex;
  align-items: flex-start;
  justify-content: center;
  max-width: 560px;
  margin: 0 auto 36px;
}
.lj-step {
  display: flex;
  flex-direction: column;
  align-items: center;
  flex: 1;
  position: relative;
  cursor: default;
}
.lj-step:not(:last-child)::after {
  content: '';
  position: absolute;
  top: 14px; left: 50%;
  width: 100%; height: 2px;
  background: var(--n200);
  z-index: 0;
  transition: background .4s;
}
.lj-step.done:not(:last-child)::after { background: var(--green); }
.lj-step.active:not(:last-child)::after { background: var(--blue); }
.lj-step-num {
  width: 28px; height: 28px;
  border-radius: 50%;
  background: var(--n100);
  color: var(--n400);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: .75rem;
  font-weight: 700;
  position: relative;
  z-index: 1;
  transition: all .3s;
}
.lj-step.active .lj-step-num { background: var(--blue); color: #fff; box-shadow: 0 0 0 4px rgba(26,86,219,.14); }
.lj-step.done .lj-step-num { background: var(--green); color: #fff; }
.lj-step-lbl {
  font-size: .62rem;
  color: var(--n400);
  margin-top: 5px;
  font-weight: 600;
  text-align: center;
  white-space: nowrap;
}
.lj-step.active .lj-step-lbl { color: var(--blue); }
.lj-step.done .lj-step-lbl { color: var(--green); }
.lj-step.done { cursor: pointer; }

/* Steps — employer green theme */
.employer-form .lj-step.active .lj-step-num { background: var(--green); box-shadow: 0 0 0 4px rgba(22,163,74,.14); }
.employer-form .lj-step.active:not(:last-child)::after { background: var(--green); }
.employer-form .lj-step.active .lj-step-lbl { color: var(--green); }

/* Card */
.lj-reg-card {
  background: #fff;
  border: 1.5px solid var(--n200);
  border-radius: var(--r-lg);
  box-shadow: var(--sh-md);
  overflow: hidden;
  animation: fadeUp .3s ease;
}
.lj-reg-card-head {
  padding: 18px 28px;
  display: flex;
  align-items: center;
  gap: 12px;
}
.js-head { background: linear-gradient(90deg, #1a56db 0%, #7c3aed 100%); }
.emp-head { background: linear-gradient(90deg, #16a34a 0%, #0891b2 100%); }
.lj-reg-card-head i { color: rgba(255,255,255,.9); font-size: 1rem; }
.lj-reg-card-head-title { font-family: var(--fh); font-size: .9375rem; font-weight: 700; color: #fff; }
.lj-reg-card-head-sub { font-size: .78rem; color: rgba(255,255,255,.7); margin-top: 1px; }
.lj-reg-body { padding: 28px; }

/* Panels */
.lj-tab-panel { display: none; }
.lj-tab-panel.active { display: block; animation: fadeUp .3s ease; }

/* Form elements */
.lj-fgroup { margin-bottom: 16px; }
.lj-frow { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
.lj-frow3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 14px; }
.lj-label { display: block; font-size: .8125rem; font-weight: 600; color: var(--n700); margin-bottom: 6px; }
.lj-label .req { color: #e53e3e; margin-left: 2px; }
.lj-opt-badge { font-size: .68rem; font-weight: 500; color: var(--n400); margin-left: 6px; background: var(--n100); padding: 1px 7px; border-radius: 100px; }
.lj-iw { position: relative; }
.lj-iw-ico { position: absolute; left: 13px; top: 50%; transform: translateY(-50%); color: var(--n400); font-size: .82rem; pointer-events: none; z-index: 1; }
.lj-iw-ico-r { position: absolute; right: 13px; top: 50%; transform: translateY(-50%); color: var(--n400); font-size: .82rem; cursor: pointer; z-index: 1; background: none; border: none; padding: 0; transition: color var(--t); }
.lj-iw-ico-r:hover { color: var(--n700); }
.lj-input {
  width: 100%;
  border: 1.5px solid var(--n200);
  border-radius: var(--r);
  padding: 10px 14px 10px 38px;
  font-family: var(--f);
  font-size: .875rem;
  color: var(--n900);
  background: #fff;
  outline: none;
  transition: border-color var(--t), box-shadow var(--t);
}
.lj-input.no-ico { padding-left: 14px; }
.lj-input.pr { padding-right: 40px; }
.lj-input:focus { border-color: var(--blue); box-shadow: 0 0 0 3px rgba(26,86,219,.1); }
.employer-form .lj-input:focus { border-color: var(--green); box-shadow: 0 0 0 3px rgba(22,163,74,.1); }
.lj-input::placeholder { color: var(--n400); }
.lj-input.field-error { border-color: #ef4444; box-shadow: 0 0 0 3px rgba(239,68,68,.1); }
select.lj-input {
  background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='11' height='7' fill='none'%3E%3Cpath d='M1 1l4.5 4.5L10 1' stroke='%23a09e9b' stroke-width='1.5' stroke-linecap='round' stroke-linejoin='round'/%3E%3C/svg%3E");
  background-repeat: no-repeat;
  background-position: right 12px center;
  padding-right: 34px;
  cursor: pointer;
  -webkit-appearance: none;
  appearance: none;
}
textarea.lj-input { padding-top: 10px; resize: vertical; min-height: 90px; }
.lj-hint { font-size: .73rem; color: var(--n400); margin-top: 4px; display: flex; align-items: center; gap: 5px; }
.lj-hint i { font-size: .68rem; }

/* Field error */
.lj-field-err { font-size: .75rem; color: #dc2626; margin-top: 4px; display: none; align-items: center; gap: 4px; }
.lj-field-err.show { display: flex; }
.lj-field-err i { font-size: .7rem; flex-shrink: 0; }

/* Section divider */
.lj-fsec { display: flex; align-items: center; gap: 10px; margin: 22px 0 16px; }
.lj-fsec-line { flex: 1; height: 1px; background: var(--n100); }
.lj-fsec-lbl { font-size: .7rem; font-weight: 800; color: var(--n400); letter-spacing: .08em; text-transform: uppercase; white-space: nowrap; display: flex; align-items: center; gap: 6px; }
.lj-fsec-lbl i { font-size: .75rem; color: var(--blue); }

/* Step alert */
.lj-step-alert { background: #fef2f2; border: 1.5px solid #fecaca; border-radius: var(--r); padding: 11px 14px; margin-bottom: 16px; display: none; align-items: flex-start; gap: 9px; font-size: .83rem; color: #b91c1c; animation: shakeX .35s ease; }
.lj-step-alert.show { display: flex; }
@keyframes shakeX { 0%,100%{transform:translateX(0)} 20%{transform:translateX(-6px)} 40%{transform:translateX(6px)} 60%{transform:translateX(-4px)} 80%{transform:translateX(4px)} }

/* Info box */
.lj-info-box { background: var(--blue-lt); border: 1.5px solid rgba(26,86,219,.12); border-radius: var(--r); padding: 13px 16px; margin-bottom: 20px; display: flex; align-items: flex-start; gap: 10px; font-size: .82rem; color: var(--n700); }
.lj-info-box i { color: var(--blue); flex-shrink: 0; margin-top: 1px; }

/* File upload */
.lj-file-zone { border: 1.5px dashed var(--n200); border-radius: var(--r); padding: 20px 16px; text-align: center; cursor: pointer; transition: border-color var(--t),background var(--t); background: var(--n50); position: relative; }
.lj-file-zone:hover { border-color: var(--blue); background: rgba(26,86,219,.03); }
.lj-file-zone input[type="file"] { position: absolute; inset: 0; opacity: 0; cursor: pointer; }
.lj-fz-ico { width: 44px; height: 44px; border-radius: 50%; background: #fff; border: 1.5px solid var(--n200); display: flex; align-items: center; justify-content: center; font-size: 1rem; color: var(--n400); margin: 0 auto 10px; }
.lj-fz-title { font-size: .875rem; font-weight: 600; color: var(--n700); margin-bottom: 3px; }
.lj-fz-sub { font-size: .75rem; color: var(--n400); }

/* Password strength */
.lj-pwd-strength { height: 4px; border-radius: 2px; background: var(--n100); margin-top: 6px; overflow: hidden; }
.lj-pwd-bar { height: 100%; width: 0%; border-radius: 2px; transition: width .3s, background .3s; }

/* Footer */
.lj-reg-footer { padding: 20px 28px; border-top: 1px solid var(--n100); background: var(--n50); display: flex; align-items: center; justify-content: space-between; flex-wrap: wrap; gap: 12px; }
.lj-btn-nav { border: none; border-radius: var(--r); font-family: var(--f); font-size: .9rem; font-weight: 700; padding: 11px 24px; cursor: pointer; display: flex; align-items: center; gap: 8px; transition: all var(--t); }
.lj-btn-prev { background: #fff; border: 1.5px solid var(--n200); color: var(--n700); }
.lj-btn-prev:hover { border-color: var(--n400); background: var(--n50); }
.lj-btn-next { background: var(--blue); color: #fff; }
.lj-btn-next:hover { background: #1e40af; transform: translateY(-1px); box-shadow: 0 4px 14px rgba(26,86,219,.28); }
.lj-btn-next.green-btn { background: var(--green); }
.lj-btn-next.green-btn:hover { background: #15803d; box-shadow: 0 4px 14px rgba(22,163,74,.28); }
.lj-submit { border: none; border-radius: var(--r); font-family: var(--fh); font-size: .9375rem; font-weight: 700; padding: 12px 28px; cursor: pointer; display: flex; align-items: center; gap: 10px; transition: all var(--t); color: #fff; }
.lj-submit.blue-submit { background: linear-gradient(135deg,#1a56db,#7c3aed); }
.lj-submit.green-submit { background: linear-gradient(135deg,#16a34a,#0891b2); }
.lj-submit:hover { transform: translateY(-1px); box-shadow: 0 6px 20px rgba(0,0,0,.25); }
.lj-submit:disabled { opacity: .7; cursor: not-allowed; transform: none; }
.lj-reg-switch { font-size: .875rem; color: var(--n500); }
.lj-reg-switch a { color: var(--blue); font-weight: 600; text-decoration: none; }
.lj-reg-switch a:hover { text-decoration: underline; }

/* Summary card */
.lj-summary-card { background: var(--n50); border: 1.5px solid var(--n100); border-radius: var(--r); padding: 18px; margin-top: 20px; }
.lj-summary-title { font-size: .8rem; font-weight: 700; color: var(--n700); margin-bottom: 12px; display: flex; align-items: center; gap: 8px; }
.lj-summary-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 8px 24px; font-size: .8rem; color: var(--n600); }
.lj-summary-grid div span:first-child { color: var(--n400); }

/* Exp toggle */
.lj-exp-row { display: flex; gap: 10px; }
.lj-exp-opt { flex: 1; }
.lj-exp-opt input[type="radio"] { display: none; }
.lj-exp-opt label { display: flex; align-items: center; justify-content: center; gap: 8px; border: 1.5px solid var(--n200); border-radius: var(--r); padding: 10px 14px; font-size: .875rem; font-weight: 600; color: var(--n600); cursor: pointer; transition: all var(--t); }
.lj-exp-opt input:checked + label { background: var(--blue-lt); border-color: var(--blue); color: var(--blue); }
#expFields { display: none; }
#expFields.show { display: block; }

/* Skills chips */
.lj-skill-wrap { display: flex; flex-wrap: wrap; gap: 8px; }
.lj-skill-chip input[type="checkbox"] { display: none; }
.lj-skill-chip label { display: inline-flex; align-items: center; gap: 6px; border: 1.5px solid var(--n200); border-radius: 100px; padding: 5px 14px; font-size: .8rem; font-weight: 500; color: var(--n600); cursor: pointer; transition: all var(--t); }
.lj-skill-chip label:hover { border-color: var(--blue); color: var(--blue); background: var(--blue-lt); }
.lj-skill-chip input:checked + label { background: var(--blue-lt); border-color: var(--blue); color: var(--blue); }

/* ═══════════════════════════════════════
   RESPONSIVE
═══════════════════════════════════════ */
@media(max-width:680px) {
  .sel-grid { grid-template-columns: 1fr; max-width: 420px; }
  .sel-card { padding: 28px 24px; }
  .lj-frow, .lj-frow3 { grid-template-columns: 1fr; }
  .lj-reg-body { padding: 20px 16px; }
  .lj-reg-footer { padding: 16px; flex-direction: column; align-items: stretch; }
  .lj-btn-nav, .lj-submit { width: 100%; justify-content: center; }
  .lj-step-lbl { font-size: .58rem; }
  .navbar { padding: 0 16px; }
}
</style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar">
  <a class="logo" href="#" onclick="showPage('selection'); return false;">Linear<span>Jobs</span></a>
  <a class="nav-link" href="#">Sign In</a>
</nav>

<!-- ════════════════════════════════════
     PAGE: SELECTION
════════════════════════════════════ -->
<div class="page active" id="page-selection">
  <div class="sel-page">
    <div class="sel-eyebrow"><i class="fa-solid fa-bolt"></i> Get started for free</div>
    <h1 class="sel-title">Join <span class="accent">LinearJobs</span><br>as…</h1>
    <p class="sel-sub">Connecting the right talent with the right companies across Tamil Nadu.</p>

    <div class="sel-grid">
      <!-- Job Seeker Card -->
      <div class="sel-card jobseeker" onclick="showRegPage('jobseeker')">
        <div class="sel-card-glow"></div>
        <div class="sel-card-tag">100% Free</div>
        <div class="sel-card-ico"><i class="fa-solid fa-user-tie"></i></div>
        <div class="sel-card-title">Job Seeker</div>
        <p class="sel-card-desc">Find your dream job and take the next step in your career journey.</p>
        <ul class="sel-card-features">
          <li><i class="fa-solid fa-check"></i> Browse hundreds of local jobs</li>
          <li><i class="fa-solid fa-check"></i> Upload resume & get discovered</li>
          <li><i class="fa-solid fa-check"></i> Apply with one click</li>
          <li><i class="fa-solid fa-check"></i> Get job alerts via WhatsApp</li>
        </ul>
        <button class="sel-card-btn">Register as Job Seeker <i class="fa-solid fa-arrow-right"></i></button>
      </div>

      <!-- Employer Card -->
      <div class="sel-card employer" onclick="showRegPage('employer')">
        <div class="sel-card-glow"></div>
        <div class="sel-card-tag">Hire Fast</div>
        <div class="sel-card-ico"><i class="fa-solid fa-building-flag"></i></div>
        <div class="sel-card-title">Employer</div>
        <p class="sel-card-desc">Post jobs, find skilled candidates, and grow your business team.</p>
        <ul class="sel-card-features">
          <li><i class="fa-solid fa-check"></i> Post unlimited job listings</li>
          <li><i class="fa-solid fa-check"></i> Access verified candidate pool</li>
          <li><i class="fa-solid fa-check"></i> Smart applicant screening</li>
          <li><i class="fa-solid fa-check"></i> Dashboard &amp; analytics</li>
        </ul>
        <button class="sel-card-btn">Register Your Company <i class="fa-solid fa-arrow-right"></i></button>
      </div>
    </div>

    <div class="sel-divider">
      Already have an account? <a href="#">Sign in here</a>
    </div>

    <div class="trust-strip">
      <div class="trust-item"><i class="fa-solid fa-shield-halved"></i> 100% Secure & Private</div>
      <div class="trust-item"><i class="fa-solid fa-check-circle"></i> Verified Companies Only</div>
      <div class="trust-item"><i class="fa-solid fa-users"></i> 10,000+ Active Candidates</div>
    </div>
  </div>
</div>

<!-- ════════════════════════════════════
     PAGE: JOB SEEKER REGISTRATION
════════════════════════════════════ -->
<div class="page" id="page-jobseeker">
  <div class="reg-page">
    <div class="reg-wrap">
      <button class="reg-back" onclick="showPage('selection')"><i class="fa-solid fa-arrow-left"></i> Back to selection</button>

      <div class="reg-head">
        <div class="reg-head-ico blue"><i class="fa-solid fa-user-plus"></i></div>
        <div class="reg-head-title">Create Your Job Seeker Account</div>
        <div class="reg-head-sub">Join thousands of professionals finding great jobs across Tamil Nadu. It's 100% free.</div>
      </div>

      <!-- Steps -->
      <div class="lj-steps" id="js-stepIndicator">
        <div class="lj-step active" data-step="1" data-form="js" onclick="jsGoToStep(1)">
          <div class="lj-step-num"><i class="fa-solid fa-user" style="font-size:.6rem;"></i></div>
          <div class="lj-step-lbl">Personal</div>
        </div>
        <div class="lj-step" data-step="2" data-form="js" onclick="jsGoToStep(2)">
          <div class="lj-step-num">2</div>
          <div class="lj-step-lbl">Location</div>
        </div>
        <div class="lj-step" data-step="3" data-form="js" onclick="jsGoToStep(3)">
          <div class="lj-step-num">3</div>
          <div class="lj-step-lbl">Education</div>
        </div>
        <div class="lj-step" data-step="4" data-form="js" onclick="jsGoToStep(4)">
          <div class="lj-step-num">4</div>
          <div class="lj-step-lbl">Skills</div>
        </div>
        <div class="lj-step" data-step="5" data-form="js" onclick="jsGoToStep(5)">
          <div class="lj-step-num">5</div>
          <div class="lj-step-lbl">Documents</div>
        </div>
      </div>

      <form method="POST" action="/jobseeker/register" enctype="multipart/form-data" id="jsForm" novalidate>

        <!-- TAB 1: Personal -->
        <div class="lj-tab-panel active" id="js-tab-1">
          <div class="lj-reg-card">
            <div class="lj-reg-card-head js-head">
              <i class="fa-solid fa-user"></i>
              <div>
                <div class="lj-reg-card-head-title">Personal Information</div>
                <div class="lj-reg-card-head-sub">Your basic details</div>
              </div>
            </div>
            <div class="lj-reg-body">
              <div class="lj-step-alert" id="js-alert-1"><i class="fa-solid fa-triangle-exclamation"></i><span id="js-alert-1-msg">Please fill in all required fields.</span></div>
              <div class="lj-frow">
                <div class="lj-fgroup">
                  <label class="lj-label" for="js_full_name">Full Name <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-user lj-iw-ico"></i>
                    <input type="text" id="js_full_name" name="full_name" class="lj-input" placeholder="Your full name" />
                  </div>
                  <div class="lj-field-err" id="err-js_full_name"><i class="fa-solid fa-circle-exclamation"></i><span>Full name is required (min. 2 characters).</span></div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label" for="js_mobile">Mobile Number <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-mobile-screen lj-iw-ico"></i>
                    <input type="tel" id="js_mobile" name="mobile" class="lj-input" placeholder="+91 XXXXX XXXXX" maxlength="15" />
                  </div>
                  <div class="lj-field-err" id="err-js_mobile"><i class="fa-solid fa-circle-exclamation"></i><span>Enter a valid 10-digit mobile number.</span></div>
                </div>
              </div>
              <div class="lj-fgroup">
                <label class="lj-label" for="js_email">Email Address <span class="req">*</span></label>
                <div class="lj-iw"><i class="fa-solid fa-envelope lj-iw-ico"></i>
                  <input type="email" id="js_email" name="email" class="lj-input" placeholder="you@example.com" autocomplete="email" />
                </div>
                <div class="lj-field-err" id="err-js_email"><i class="fa-solid fa-circle-exclamation"></i><span>Enter a valid email address.</span></div>
              </div>
              <div class="lj-fsec"><div class="lj-fsec-line"></div><div class="lj-fsec-lbl"><i class="fa-solid fa-lock"></i> Account Security</div><div class="lj-fsec-line"></div></div>
              <div class="lj-frow">
                <div class="lj-fgroup">
                  <label class="lj-label" for="js_password">Password <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-lock lj-iw-ico"></i>
                    <input type="password" id="js_password" name="password" class="lj-input pr" placeholder="Min. 8 characters" autocomplete="new-password" oninput="checkStrength(this.value,'jsPwdBar')" />
                    <button type="button" class="lj-iw-ico-r" onclick="togglePwd('js_password',this)" tabindex="-1"><i class="fa-solid fa-eye"></i></button>
                  </div>
                  <div class="lj-pwd-strength"><div class="lj-pwd-bar" id="jsPwdBar"></div></div>
                  <div class="lj-field-err" id="err-js_password"><i class="fa-solid fa-circle-exclamation"></i><span>Password must be at least 8 characters.</span></div>
                  <div class="lj-hint"><i class="fa-solid fa-circle-info"></i> Min 8 chars with letters and numbers</div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label" for="js_password_conf">Confirm Password <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-lock lj-iw-ico"></i>
                    <input type="password" id="js_password_conf" name="password_confirmation" class="lj-input pr" placeholder="Re-enter password" autocomplete="new-password" />
                    <button type="button" class="lj-iw-ico-r" onclick="togglePwd('js_password_conf',this)" tabindex="-1"><i class="fa-solid fa-eye"></i></button>
                  </div>
                  <div class="lj-field-err" id="err-js_password_conf"><i class="fa-solid fa-circle-exclamation"></i><span>Passwords do not match.</span></div>
                </div>
              </div>
            </div>
            <div class="lj-reg-footer">
              <div class="lj-reg-switch">Already have an account? <a href="#">Login here</a></div>
              <button type="button" class="lj-btn-nav lj-btn-next" onclick="jsNextStep(1)">Next: Location <i class="fa-solid fa-arrow-right"></i></button>
            </div>
          </div>
        </div>

        <!-- TAB 2: Location -->
        <div class="lj-tab-panel" id="js-tab-2">
          <div class="lj-reg-card">
            <div class="lj-reg-card-head js-head"><i class="fa-solid fa-map-location-dot"></i>
              <div><div class="lj-reg-card-head-title">Location Information</div><div class="lj-reg-card-head-sub">Where are you based?</div></div>
            </div>
            <div class="lj-reg-body">
              <div class="lj-step-alert" id="js-alert-2"><i class="fa-solid fa-triangle-exclamation"></i><span>Please fill in all location fields.</span></div>
              <div class="lj-frow3">
                <div class="lj-fgroup">
                  <label class="lj-label" for="js_state">State <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-map lj-iw-ico"></i>
                    <select id="js_state" name="state" class="lj-input">
                      <option value="" disabled selected>Select State</option>
                      <option value="Tamil Nadu">Tamil Nadu</option>
                      <option value="Kerala">Kerala</option>
                      <option value="Karnataka">Karnataka</option>
                      <option value="Andhra Pradesh">Andhra Pradesh</option>
                      <option value="Telangana">Telangana</option>
                      <option value="Other">Other</option>
                    </select>
                  </div>
                  <div class="lj-field-err" id="err-js_state"><i class="fa-solid fa-circle-exclamation"></i><span>Please select a state.</span></div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label" for="js_district">District <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-location-dot lj-iw-ico"></i>
                    <select id="js_district" name="district" class="lj-input">
                      <option value="" disabled selected>Select District</option>
                      <option>Chennai</option><option>Coimbatore</option><option>Madurai</option>
                      <option>Tiruchirappalli</option><option>Salem</option><option>Tirunelveli</option>
                      <option>Erode</option><option>Vellore</option><option>Thanjavur</option>
                      <option>Dindigul</option><option>Kanchipuram</option><option>Tiruppur</option>
                      <option>Nagercoil</option><option>Cuddalore</option><option>Sivakasi</option>
                      <option>Pollachi</option><option>Hosur</option><option>Ooty</option>
                      <option>Karur</option><option>Namakkal</option>
                    </select>
                  </div>
                  <div class="lj-field-err" id="err-js_district"><i class="fa-solid fa-circle-exclamation"></i><span>Please select a district.</span></div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label" for="js_city">City / Town <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-city lj-iw-ico"></i>
                    <input type="text" id="js_city" name="city" class="lj-input" placeholder="Your city" />
                  </div>
                  <div class="lj-field-err" id="err-js_city"><i class="fa-solid fa-circle-exclamation"></i><span>Please enter your city.</span></div>
                </div>
              </div>
            </div>
            <div class="lj-reg-footer">
              <button type="button" class="lj-btn-nav lj-btn-prev" onclick="jsPrevStep(2)"><i class="fa-solid fa-arrow-left"></i> Back</button>
              <button type="button" class="lj-btn-nav lj-btn-next" onclick="jsNextStep(2)">Next: Education <i class="fa-solid fa-arrow-right"></i></button>
            </div>
          </div>
        </div>

        <!-- TAB 3: Education -->
        <div class="lj-tab-panel" id="js-tab-3">
          <div class="lj-reg-card">
            <div class="lj-reg-card-head js-head"><i class="fa-solid fa-graduation-cap"></i>
              <div><div class="lj-reg-card-head-title">Education & Experience</div><div class="lj-reg-card-head-sub">Your qualifications and work history</div></div>
            </div>
            <div class="lj-reg-body">
              <div class="lj-step-alert" id="js-alert-3"><i class="fa-solid fa-triangle-exclamation"></i><span>Please select your qualification.</span></div>
              <div class="lj-fgroup">
                <label class="lj-label" for="js_qual">Highest Education Qualification <span class="req">*</span></label>
                <div class="lj-iw"><i class="fa-solid fa-book lj-iw-ico"></i>
                  <select id="js_qual" name="qualification" class="lj-input">
                    <option value="" disabled selected>Select Qualification</option>
                    <option value="none">None</option>
                    <option value="10th">10th Pass (SSLC)</option>
                    <option value="12th">12th Pass (HSC / +2)</option>
                    <option value="diploma">Diploma</option>
                    <option value="bachelor">Bachelor's Degree (UG)</option>
                    <option value="master">Master's Degree (PG)</option>
                    <option value="doctorate">Doctorate / PhD</option>
                  </select>
                </div>
                <div class="lj-field-err" id="err-js_qual"><i class="fa-solid fa-circle-exclamation"></i><span>Please select your qualification.</span></div>
              </div>
              <div class="lj-fsec"><div class="lj-fsec-line"></div><div class="lj-fsec-lbl"><i class="fa-solid fa-briefcase"></i> Experience Level</div><div class="lj-fsec-line"></div></div>
              <div class="lj-fgroup">
                <div class="lj-exp-row">
                  <div class="lj-exp-opt">
                    <input type="radio" id="exp_fresher" name="experience_level" value="fresher" checked onchange="toggleExpFields(false)">
                    <label for="exp_fresher"><i class="fa-solid fa-seedling"></i> Fresher</label>
                  </div>
                  <div class="lj-exp-opt">
                    <input type="radio" id="exp_experienced" name="experience_level" value="experienced" onchange="toggleExpFields(true)">
                    <label for="exp_experienced"><i class="fa-solid fa-briefcase"></i> Experienced</label>
                  </div>
                </div>
              </div>
              <div id="expFields">
                <div class="lj-frow">
                  <div class="lj-fgroup">
                    <label class="lj-label" for="js_years">Years of Experience</label>
                    <div class="lj-iw"><i class="fa-solid fa-clock lj-iw-ico"></i>
                      <select id="js_years" name="years_of_experience" class="lj-input">
                        <option value="">Select Years</option>
                        <option value="less_1">Less than 1 year</option>
                        <option value="1">1 year</option><option value="2">2 years</option>
                        <option value="3">3 years</option><option value="4">4 years</option>
                        <option value="5">5 years</option><option value="6">6 years</option>
                        <option value="7">7 years</option><option value="8">8 years</option>
                        <option value="9">9 years</option><option value="10">10 years</option>
                        <option value="15+">15+ years</option>
                      </select>
                    </div>
                  </div>
                  <div class="lj-fgroup">
                    <label class="lj-label" for="js_prev_co">Previous Company Name</label>
                    <div class="lj-iw"><i class="fa-solid fa-building lj-iw-ico"></i>
                      <input type="text" id="js_prev_co" name="previous_company" class="lj-input" placeholder="e.g. ABC Pvt Ltd" />
                    </div>
                  </div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label" for="js_prev_role">Previous Job Designation</label>
                  <div class="lj-iw"><i class="fa-solid fa-id-badge lj-iw-ico"></i>
                    <input type="text" id="js_prev_role" name="previous_designation" class="lj-input" placeholder="e.g. Sales Executive" />
                  </div>
                </div>
              </div>
            </div>
            <div class="lj-reg-footer">
              <button type="button" class="lj-btn-nav lj-btn-prev" onclick="jsPrevStep(3)"><i class="fa-solid fa-arrow-left"></i> Back</button>
              <button type="button" class="lj-btn-nav lj-btn-next" onclick="jsNextStep(3)">Next: Skills <i class="fa-solid fa-arrow-right"></i></button>
            </div>
          </div>
        </div>

        <!-- TAB 4: Skills -->
        <div class="lj-tab-panel" id="js-tab-4">
          <div class="lj-reg-card">
            <div class="lj-reg-card-head js-head"><i class="fa-solid fa-screwdriver-wrench"></i>
              <div><div class="lj-reg-card-head-title">Skills Selection</div><div class="lj-reg-card-head-sub">Select all skills that apply to you</div></div>
            </div>
            <div class="lj-reg-body">
              <div class="lj-step-alert" id="js-alert-4"><i class="fa-solid fa-triangle-exclamation"></i><span>Please select at least one skill.</span></div>
              <div id="skillsContainer"></div>
            </div>
            <div class="lj-reg-footer">
              <button type="button" class="lj-btn-nav lj-btn-prev" onclick="jsPrevStep(4)"><i class="fa-solid fa-arrow-left"></i> Back</button>
              <button type="button" class="lj-btn-nav lj-btn-next" onclick="jsNextStep(4)">Next: Documents <i class="fa-solid fa-arrow-right"></i></button>
            </div>
          </div>
        </div>

        <!-- TAB 5: Documents -->
        <div class="lj-tab-panel" id="js-tab-5">
          <div class="lj-reg-card">
            <div class="lj-reg-card-head js-head"><i class="fa-solid fa-file-arrow-up"></i>
              <div><div class="lj-reg-card-head-title">Resume & Profile Photo</div><div class="lj-reg-card-head-sub">Upload your documents (optional but recommended)</div></div>
            </div>
            <div class="lj-reg-body">
              <div class="lj-frow">
                <div class="lj-fgroup">
                  <label class="lj-label">Upload Resume</label>
                  <div class="lj-file-zone" id="js-resumeZone">
                    <input type="file" name="resume" id="js_resumeInput" accept=".pdf,.doc,.docx" onchange="showFile('js-resumeZone','js-resumeLabel',this,5)">
                    <div class="lj-fz-ico"><i class="fa-solid fa-file-pdf" style="color:var(--blue);"></i></div>
                    <div class="lj-fz-title" id="js-resumeLabel">Click to upload resume</div>
                    <div class="lj-fz-sub">PDF, DOC, DOCX — Max 5 MB</div>
                  </div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label">Profile Photo <span class="lj-opt-badge">Optional</span></label>
                  <div class="lj-file-zone" id="js-photoZone">
                    <input type="file" name="profile_photo" id="js_photoInput" accept="image/*" onchange="showFile('js-photoZone','js-photoLabel',this,2)">
                    <div class="lj-fz-ico"><i class="fa-solid fa-image" style="color:var(--blue);"></i></div>
                    <div class="lj-fz-title" id="js-photoLabel">Click to upload photo</div>
                    <div class="lj-fz-sub">JPG, PNG — Max 2 MB</div>
                  </div>
                </div>
              </div>
              <div class="lj-summary-card">
                <div class="lj-summary-title"><i class="fa-solid fa-list-check" style="color:var(--blue);"></i> Registration Summary</div>
                <div class="lj-summary-grid" id="js-summaryGrid">
                  <div><span>Name:</span> <strong id="js-sum-name">—</strong></div>
                  <div><span>Mobile:</span> <strong id="js-sum-mobile">—</strong></div>
                  <div><span>Email:</span> <strong id="js-sum-email">—</strong></div>
                  <div><span>Location:</span> <strong id="js-sum-location">—</strong></div>
                  <div><span>Qualification:</span> <strong id="js-sum-qual">—</strong></div>
                  <div><span>Experience:</span> <strong id="js-sum-exp">—</strong></div>
                  <div style="grid-column:1/-1;"><span>Skills:</span> <strong id="js-sum-skills">—</strong></div>
                </div>
              </div>
            </div>
            <div class="lj-reg-footer">
              <button type="button" class="lj-btn-nav lj-btn-prev" onclick="jsPrevStep(5)"><i class="fa-solid fa-arrow-left"></i> Back</button>
              <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                <div style="font-size:.78rem;color:var(--n400);display:flex;align-items:center;gap:6px;"><i class="fa-solid fa-shield-halved" style="color:var(--green);"></i> Your data is safe & private</div>
                <button type="submit" class="lj-submit blue-submit" id="jsSubmitBtn"><i class="fa-solid fa-user-plus"></i> Create Account</button>
              </div>
            </div>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

<!-- ════════════════════════════════════
     PAGE: EMPLOYER REGISTRATION
════════════════════════════════════ -->
<div class="page" id="page-employer">
  <div class="reg-page">
    <div class="reg-wrap">
      <button class="reg-back" onclick="showPage('selection')"><i class="fa-solid fa-arrow-left"></i> Back to selection</button>

      <div class="reg-head">
        <div class="reg-head-ico green"><i class="fa-solid fa-building-flag"></i></div>
        <div class="reg-head-title">Register Your Company</div>
        <div class="reg-head-sub">Join LinearJobs and connect with skilled professionals across Tamil Nadu. Post jobs in minutes.</div>
      </div>

      <!-- Steps -->
      <div class="lj-steps" id="emp-stepIndicator">
        <div class="lj-step active" data-step="1" data-form="emp" onclick="empGoToStep(1)">
          <div class="lj-step-num"><i class="fa-solid fa-building" style="font-size:.6rem;"></i></div>
          <div class="lj-step-lbl">Company</div>
        </div>
        <div class="lj-step" data-step="2" data-form="emp" onclick="empGoToStep(2)">
          <div class="lj-step-num">2</div>
          <div class="lj-step-lbl">Contact</div>
        </div>
        <div class="lj-step" data-step="3" data-form="emp" onclick="empGoToStep(3)">
          <div class="lj-step-num">3</div>
          <div class="lj-step-lbl">Account</div>
        </div>
        <div class="lj-step" data-step="4" data-form="emp" onclick="empGoToStep(4)">
          <div class="lj-step-num">4</div>
          <div class="lj-step-lbl">Verification</div>
        </div>
        <div class="lj-step" data-step="5" data-form="emp" onclick="empGoToStep(5)">
          <div class="lj-step-num">5</div>
          <div class="lj-step-lbl">Documents</div>
        </div>
      </div>

      <form method="POST" action="/employer/register" enctype="multipart/form-data" id="empForm" novalidate class="employer-form">

        <!-- TAB 1: Company Info -->
        <div class="lj-tab-panel active" id="emp-tab-1">
          <div class="lj-reg-card">
            <div class="lj-reg-card-head emp-head"><i class="fa-solid fa-building"></i>
              <div><div class="lj-reg-card-head-title">Company Information</div><div class="lj-reg-card-head-sub">Tell us about your business</div></div>
            </div>
            <div class="lj-reg-body">
              <div class="lj-step-alert" id="emp-alert-1"><i class="fa-solid fa-triangle-exclamation"></i><span>Please fill in all required fields.</span></div>
              <div class="lj-fgroup">
                <label class="lj-label" for="emp_company_name">Company Name <span class="req">*</span></label>
                <div class="lj-iw"><i class="fa-solid fa-building lj-iw-ico"></i>
                  <input type="text" id="emp_company_name" name="company_name" class="lj-input" placeholder="e.g. ABC Industries Pvt Ltd" />
                </div>
                <div class="lj-field-err" id="err-emp_company_name"><i class="fa-solid fa-circle-exclamation"></i><span>Company name is required.</span></div>
              </div>
              <div class="lj-fgroup">
                <label class="lj-label" for="emp_address">Company Address <span class="req">*</span></label>
                <div class="lj-iw"><i class="fa-solid fa-map-pin lj-iw-ico" style="top:18px;transform:none;"></i>
                  <textarea id="emp_address" name="company_address" class="lj-input" placeholder="Full registered address of your company" rows="3"></textarea>
                </div>
                <div class="lj-field-err" id="err-emp_address"><i class="fa-solid fa-circle-exclamation"></i><span>Please enter your company address.</span></div>
              </div>
              <div class="lj-frow3">
                <div class="lj-fgroup">
                  <label class="lj-label" for="emp_state">State <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-map lj-iw-ico"></i>
                    <select id="emp_state" name="state" class="lj-input">
                      <option value="" disabled selected>Select State</option>
                      <option>Tamil Nadu</option><option>Kerala</option><option>Karnataka</option>
                      <option>Andhra Pradesh</option><option>Telangana</option><option>Other</option>
                    </select>
                  </div>
                  <div class="lj-field-err" id="err-emp_state"><i class="fa-solid fa-circle-exclamation"></i><span>Please select a state.</span></div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label" for="emp_district">District <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-location-dot lj-iw-ico"></i>
                    <select id="emp_district" name="district" class="lj-input">
                      <option value="" disabled selected>Select District</option>
                      <option>Chennai</option><option>Coimbatore</option><option>Madurai</option>
                      <option>Tiruchirappalli</option><option>Salem</option><option>Tirunelveli</option>
                      <option>Erode</option><option>Vellore</option><option>Thanjavur</option>
                      <option>Dindigul</option><option>Kanchipuram</option><option>Tiruppur</option>
                      <option>Nagercoil</option><option>Cuddalore</option><option>Sivakasi</option>
                      <option>Pollachi</option><option>Hosur</option><option>Ooty</option>
                      <option>Karur</option><option>Namakkal</option>
                    </select>
                  </div>
                  <div class="lj-field-err" id="err-emp_district"><i class="fa-solid fa-circle-exclamation"></i><span>Please select a district.</span></div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label" for="emp_city">City / Town <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-city lj-iw-ico"></i>
                    <input type="text" id="emp_city" name="city" class="lj-input" placeholder="City" />
                  </div>
                  <div class="lj-field-err" id="err-emp_city"><i class="fa-solid fa-circle-exclamation"></i><span>Please enter the city.</span></div>
                </div>
              </div>
              <div class="lj-fgroup">
                <label class="lj-label" for="emp_pincode">Pincode <span class="req">*</span></label>
                <div class="lj-iw"><i class="fa-solid fa-hashtag lj-iw-ico"></i>
                  <input type="text" id="emp_pincode" name="pincode" class="lj-input" placeholder="6-digit pincode" maxlength="6" style="max-width:200px;" />
                </div>
                <div class="lj-field-err" id="err-emp_pincode"><i class="fa-solid fa-circle-exclamation"></i><span>Enter a valid 6-digit pincode.</span></div>
              </div>
            </div>
            <div class="lj-reg-footer">
              <div class="lj-reg-switch">Already registered? <a href="#">Login here</a></div>
              <button type="button" class="lj-btn-nav lj-btn-next green-btn" onclick="empNextStep(1)">Next: Contact Details <i class="fa-solid fa-arrow-right"></i></button>
            </div>
          </div>
        </div>

        <!-- TAB 2: Contact -->
        <div class="lj-tab-panel" id="emp-tab-2">
          <div class="lj-reg-card">
            <div class="lj-reg-card-head emp-head"><i class="fa-solid fa-address-book"></i>
              <div><div class="lj-reg-card-head-title">Contact Details</div><div class="lj-reg-card-head-sub">Owner and HR / Recruiter information</div></div>
            </div>
            <div class="lj-reg-body">
              <div class="lj-step-alert" id="emp-alert-2"><i class="fa-solid fa-triangle-exclamation"></i><span>Please fill in all required contact fields.</span></div>
              <div class="lj-fsec" style="margin-top:0;"><div class="lj-fsec-lbl"><i class="fa-solid fa-user-tie"></i> Owner / Director</div><div class="lj-fsec-line"></div></div>
              <div class="lj-frow">
                <div class="lj-fgroup">
                  <label class="lj-label" for="emp_owner_name">Owner Name <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-user lj-iw-ico"></i>
                    <input type="text" id="emp_owner_name" name="owner_name" class="lj-input" placeholder="Full name" />
                  </div>
                  <div class="lj-field-err" id="err-emp_owner_name"><i class="fa-solid fa-circle-exclamation"></i><span>Owner name is required.</span></div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label" for="emp_owner_mobile">Owner Mobile <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-mobile-screen lj-iw-ico"></i>
                    <input type="tel" id="emp_owner_mobile" name="owner_mobile" class="lj-input" placeholder="+91 XXXXX XXXXX" maxlength="15" />
                  </div>
                  <div class="lj-field-err" id="err-emp_owner_mobile"><i class="fa-solid fa-circle-exclamation"></i><span>Enter a valid 10-digit mobile number.</span></div>
                </div>
              </div>
              <div class="lj-fsec"><div class="lj-fsec-lbl"><i class="fa-solid fa-user-gear"></i> HR / Recruiter</div><div class="lj-fsec-line"></div></div>
              <div class="lj-info-box"><i class="fa-solid fa-circle-info"></i><span>If you don't have a dedicated HR, you can enter the owner's details again below.</span></div>
              <div class="lj-frow">
                <div class="lj-fgroup">
                  <label class="lj-label" for="emp_hr_name">HR / Recruiter Name <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-user lj-iw-ico"></i>
                    <input type="text" id="emp_hr_name" name="hr_name" class="lj-input" placeholder="Full name" />
                  </div>
                  <div class="lj-field-err" id="err-emp_hr_name"><i class="fa-solid fa-circle-exclamation"></i><span>HR name is required.</span></div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label" for="emp_hr_mobile">HR Mobile <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-mobile-screen lj-iw-ico"></i>
                    <input type="tel" id="emp_hr_mobile" name="hr_mobile" class="lj-input" placeholder="+91 XXXXX XXXXX" maxlength="15" />
                  </div>
                  <div class="lj-field-err" id="err-emp_hr_mobile"><i class="fa-solid fa-circle-exclamation"></i><span>Enter a valid 10-digit mobile number.</span></div>
                </div>
              </div>
            </div>
            <div class="lj-reg-footer">
              <button type="button" class="lj-btn-nav lj-btn-prev" onclick="empPrevStep(2)"><i class="fa-solid fa-arrow-left"></i> Back</button>
              <button type="button" class="lj-btn-nav lj-btn-next green-btn" onclick="empNextStep(2)">Next: Account Setup <i class="fa-solid fa-arrow-right"></i></button>
            </div>
          </div>
        </div>

        <!-- TAB 3: Account -->
        <div class="lj-tab-panel" id="emp-tab-3">
          <div class="lj-reg-card">
            <div class="lj-reg-card-head emp-head"><i class="fa-solid fa-shield-halved"></i>
              <div><div class="lj-reg-card-head-title">Account Details</div><div class="lj-reg-card-head-sub">Set up your login credentials</div></div>
            </div>
            <div class="lj-reg-body">
              <div class="lj-step-alert" id="emp-alert-3"><i class="fa-solid fa-triangle-exclamation"></i><span>Please fill in all account fields.</span></div>
              <div class="lj-fgroup">
                <label class="lj-label" for="emp_email">Official Email Address <span class="req">*</span></label>
                <div class="lj-iw"><i class="fa-solid fa-envelope lj-iw-ico"></i>
                  <input type="email" id="emp_email" name="email" class="lj-input" placeholder="company@example.com" autocomplete="email" />
                </div>
                <div class="lj-field-err" id="err-emp_email"><i class="fa-solid fa-circle-exclamation"></i><span>Enter a valid email address.</span></div>
                <div class="lj-hint"><i class="fa-solid fa-circle-info"></i> This will be your login email</div>
              </div>
              <div class="lj-fsec"><div class="lj-fsec-line"></div><div class="lj-fsec-lbl"><i class="fa-solid fa-lock"></i> Account Security</div><div class="lj-fsec-line"></div></div>
              <div class="lj-frow">
                <div class="lj-fgroup">
                  <label class="lj-label" for="emp_password">Password <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-lock lj-iw-ico"></i>
                    <input type="password" id="emp_password" name="password" class="lj-input pr" placeholder="Min. 8 characters" autocomplete="new-password" oninput="checkStrength(this.value,'empPwdBar')" />
                    <button type="button" class="lj-iw-ico-r" onclick="togglePwd('emp_password',this)" tabindex="-1"><i class="fa-solid fa-eye"></i></button>
                  </div>
                  <div class="lj-pwd-strength"><div class="lj-pwd-bar" id="empPwdBar"></div></div>
                  <div class="lj-field-err" id="err-emp_password"><i class="fa-solid fa-circle-exclamation"></i><span>Password must be at least 8 characters.</span></div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label" for="emp_password_conf">Confirm Password <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-lock lj-iw-ico"></i>
                    <input type="password" id="emp_password_conf" name="password_confirmation" class="lj-input pr" placeholder="Re-enter password" autocomplete="new-password" />
                    <button type="button" class="lj-iw-ico-r" onclick="togglePwd('emp_password_conf',this)" tabindex="-1"><i class="fa-solid fa-eye"></i></button>
                  </div>
                  <div class="lj-field-err" id="err-emp_password_conf"><i class="fa-solid fa-circle-exclamation"></i><span>Passwords do not match.</span></div>
                </div>
              </div>
            </div>
            <div class="lj-reg-footer">
              <button type="button" class="lj-btn-nav lj-btn-prev" onclick="empPrevStep(3)"><i class="fa-solid fa-arrow-left"></i> Back</button>
              <button type="button" class="lj-btn-nav lj-btn-next green-btn" onclick="empNextStep(3)">Next: Business Verification <i class="fa-solid fa-arrow-right"></i></button>
            </div>
          </div>
        </div>

        <!-- TAB 4: Verification -->
        <div class="lj-tab-panel" id="emp-tab-4">
          <div class="lj-reg-card">
            <div class="lj-reg-card-head emp-head"><i class="fa-solid fa-file-certificate"></i>
              <div><div class="lj-reg-card-head-title">Business Verification</div><div class="lj-reg-card-head-sub">Provide your business registration numbers</div></div>
            </div>
            <div class="lj-reg-body">
              <div class="lj-step-alert" id="emp-alert-4"><i class="fa-solid fa-triangle-exclamation"></i><span>Please provide your GST and PAN numbers.</span></div>
              <div class="lj-info-box" style="border-color:rgba(22,163,74,.15);background:rgba(22,163,74,.04);">
                <i class="fa-solid fa-shield-check" style="color:var(--green);"></i>
                <span>Your business details are encrypted and used only for verification. Only verified employers can post jobs on LinearJobs.</span>
              </div>
              <div class="lj-frow">
                <div class="lj-fgroup">
                  <label class="lj-label" for="emp_gst">GST Number <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-receipt lj-iw-ico"></i>
                    <input type="text" id="emp_gst" name="gst_number" class="lj-input" placeholder="e.g. 33AABCU9603R1ZX" maxlength="15" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()" />
                  </div>
                  <div class="lj-field-err" id="err-emp_gst"><i class="fa-solid fa-circle-exclamation"></i><span>Enter a valid 15-character GST number.</span></div>
                  <div class="lj-hint"><i class="fa-solid fa-circle-info"></i> 15-character alphanumeric GST registration number</div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label" for="emp_pan">PAN Number <span class="req">*</span></label>
                  <div class="lj-iw"><i class="fa-solid fa-id-card lj-iw-ico"></i>
                    <input type="text" id="emp_pan" name="pan_number" class="lj-input" placeholder="e.g. AABCU9603R" maxlength="10" style="text-transform:uppercase;" oninput="this.value=this.value.toUpperCase()" />
                  </div>
                  <div class="lj-field-err" id="err-emp_pan"><i class="fa-solid fa-circle-exclamation"></i><span>Enter a valid 10-character PAN number.</span></div>
                  <div class="lj-hint"><i class="fa-solid fa-circle-info"></i> Company / Individual PAN number</div>
                </div>
              </div>
              <div class="lj-fgroup">
                <label class="lj-label" for="emp_msme">MSME Number <span class="lj-opt-badge">Optional</span></label>
                <div class="lj-iw"><i class="fa-solid fa-industry lj-iw-ico"></i>
                  <input type="text" id="emp_msme" name="msme_number" class="lj-input" placeholder="MSME / Udyam Registration Number" style="max-width:380px;" />
                </div>
                <div class="lj-hint"><i class="fa-solid fa-circle-info"></i> Udyam number (e.g. UDYAM-TN-01-0000000) — optional but recommended</div>
              </div>
            </div>
            <div class="lj-reg-footer">
              <button type="button" class="lj-btn-nav lj-btn-prev" onclick="empPrevStep(4)"><i class="fa-solid fa-arrow-left"></i> Back</button>
              <button type="button" class="lj-btn-nav lj-btn-next green-btn" onclick="empNextStep(4)">Next: Documents <i class="fa-solid fa-arrow-right"></i></button>
            </div>
          </div>
        </div>

        <!-- TAB 5: Documents -->
        <div class="lj-tab-panel" id="emp-tab-5">
          <div class="lj-reg-card">
            <div class="lj-reg-card-head emp-head"><i class="fa-solid fa-file-arrow-up"></i>
              <div><div class="lj-reg-card-head-title">Document Upload</div><div class="lj-reg-card-head-sub">Upload your verification documents</div></div>
            </div>
            <div class="lj-reg-body">
              <div class="lj-frow">
                <div class="lj-fgroup">
                  <label class="lj-label">GST Certificate <span class="req">*</span></label>
                  <div class="lj-file-zone" id="emp-gstZone">
                    <input type="file" name="gst_certificate" id="emp_gstInput" accept=".pdf,.jpg,.jpeg,.png" onchange="showFile('emp-gstZone','emp-gstLabel',this,5)">
                    <div class="lj-fz-ico"><i class="fa-solid fa-file-invoice" style="color:var(--green);"></i></div>
                    <div class="lj-fz-title" id="emp-gstLabel">Click to upload GST certificate</div>
                    <div class="lj-fz-sub">PDF, JPG, PNG — Max 5 MB</div>
                  </div>
                  <div class="lj-field-err" id="err-emp_gst_cert"><i class="fa-solid fa-circle-exclamation"></i><span>GST certificate is required.</span></div>
                </div>
                <div class="lj-fgroup">
                  <label class="lj-label">PAN Document <span class="req">*</span></label>
                  <div class="lj-file-zone" id="emp-panZone">
                    <input type="file" name="pan_document" id="emp_panInput" accept=".pdf,.jpg,.jpeg,.png" onchange="showFile('emp-panZone','emp-panLabel',this,5)">
                    <div class="lj-fz-ico"><i class="fa-solid fa-id-card" style="color:var(--green);"></i></div>
                    <div class="lj-fz-title" id="emp-panLabel">Click to upload PAN document</div>
                    <div class="lj-fz-sub">PDF, JPG, PNG — Max 5 MB</div>
                  </div>
                  <div class="lj-field-err" id="err-emp_pan_doc"><i class="fa-solid fa-circle-exclamation"></i><span>PAN document is required.</span></div>
                </div>
              </div>
              <div class="lj-fgroup">
                <label class="lj-label">MSME Certificate <span class="lj-opt-badge">Optional</span></label>
                <div class="lj-file-zone" id="emp-msmeZone" style="max-width:380px;">
                  <input type="file" name="msme_certificate" id="emp_msmeInput" accept=".pdf,.jpg,.jpeg,.png" onchange="showFile('emp-msmeZone','emp-msmeLabel',this,5)">
                  <div class="lj-fz-ico"><i class="fa-solid fa-industry" style="color:var(--green);"></i></div>
                  <div class="lj-fz-title" id="emp-msmeLabel">Click to upload MSME certificate</div>
                  <div class="lj-fz-sub">PDF, JPG, PNG — Max 5 MB</div>
                </div>
              </div>
              <div class="lj-summary-card">
                <div class="lj-summary-title"><i class="fa-solid fa-list-check" style="color:var(--green);"></i> Registration Summary</div>
                <div class="lj-summary-grid">
                  <div><span>Company:</span> <strong id="emp-sum-company">—</strong></div>
                  <div><span>Location:</span> <strong id="emp-sum-location">—</strong></div>
                  <div><span>Owner:</span> <strong id="emp-sum-owner">—</strong></div>
                  <div><span>HR Contact:</span> <strong id="emp-sum-hr">—</strong></div>
                  <div><span>Email:</span> <strong id="emp-sum-email">—</strong></div>
                  <div><span>GST:</span> <strong id="emp-sum-gst">—</strong></div>
                  <div><span>PAN:</span> <strong id="emp-sum-pan">—</strong></div>
                  <div><span>MSME:</span> <strong id="emp-sum-msme">Not provided</strong></div>
                </div>
              </div>
            </div>
            <div class="lj-reg-footer">
              <button type="button" class="lj-btn-nav lj-btn-prev" onclick="empPrevStep(5)"><i class="fa-solid fa-arrow-left"></i> Back</button>
              <div style="display:flex;align-items:center;gap:12px;flex-wrap:wrap;">
                <div style="font-size:.78rem;color:var(--n400);display:flex;align-items:center;gap:6px;"><i class="fa-solid fa-shield-halved" style="color:var(--green);"></i> Your data is safe & private</div>
                <button type="submit" class="lj-submit green-submit" id="empSubmitBtn"><i class="fa-solid fa-building-flag"></i> Register Company</button>
              </div>
            </div>
          </div>
        </div>

      </form>
    </div>
  </div>
</div>

<!-- ════════════════════════════════════
     JAVASCRIPT
════════════════════════════════════ -->
<script>
/* ─── PAGE SWITCHING ─────────────────── */
function showPage(name) {
  document.querySelectorAll('.page').forEach(p => p.classList.remove('active'));
  document.getElementById('page-' + name).classList.add('active');
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function showRegPage(type) {
  showPage(type);
  // Reset steps
  if (type === 'jobseeker') {
    jsCurrentStep = 1;
    jsShowStep(1);
    resetSteps('js-stepIndicator');
  } else {
    empCurrentStep = 1;
    empShowStep(1);
    resetSteps('emp-stepIndicator');
  }
}

function resetSteps(indicatorId) {
  const steps = document.querySelectorAll('#' + indicatorId + ' .lj-step');
  steps.forEach((s, i) => {
    s.classList.remove('active','done');
    const num = s.querySelector('.lj-step-num');
    if (i === 0) {
      s.classList.add('active');
      num.innerHTML = s.querySelector('.lj-step-num').innerHTML;
    } else {
      num.textContent = i + 1;
    }
  });
}

/* ─── JOB SEEKER STEPS ───────────────── */
let jsCurrentStep = 1;

function jsGoToStep(t) { if (t >= jsCurrentStep) return; jsShowStep(t); }
function jsNextStep(from) { if (!jsValidate(from)) return; jsMarkDone(from); jsShowStep(from + 1); if (from + 1 === 5) jsBuildSummary(); }
function jsPrevStep(from) { jsShowStep(from - 1); }

function jsShowStep(step) {
  document.querySelectorAll('#page-jobseeker .lj-tab-panel').forEach(p => p.classList.remove('active'));
  document.getElementById('js-tab-' + step).classList.add('active');
  document.querySelectorAll('#js-stepIndicator .lj-step').forEach(s => {
    s.classList.remove('active');
    s.style.cursor = parseInt(s.dataset.step) < step ? 'pointer' : 'default';
  });
  document.querySelector('#js-stepIndicator .lj-step[data-step="' + step + '"]').classList.add('active');
  jsCurrentStep = step;
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function jsMarkDone(step) {
  const el = document.querySelector('#js-stepIndicator .lj-step[data-step="' + step + '"]');
  el.classList.remove('active');
  el.classList.add('done');
  el.querySelector('.lj-step-num').innerHTML = '<i class="fa-solid fa-check" style="font-size:.6rem;"></i>';
}

function jsValidate(step) {
  let valid = true;
  const alertEl = document.getElementById('js-alert-' + step);
  if (alertEl) alertEl.classList.remove('show');

  function err(id, msg) {
    valid = false;
    const f = document.getElementById(id);
    const e = document.getElementById('err-' + id);
    if (f) f.classList.add('field-error');
    if (e) { e.classList.add('show'); const sp = e.querySelector('span'); if (sp && msg) sp.textContent = msg; }
  }
  function clr(id) {
    const f = document.getElementById(id);
    const e = document.getElementById('err-' + id);
    if (f) f.classList.remove('field-error');
    if (e) e.classList.remove('show');
  }

  if (step === 1) {
    clr('js_full_name'); clr('js_mobile'); clr('js_email'); clr('js_password'); clr('js_password_conf');
    const name = document.getElementById('js_full_name').value.trim();
    if (name.length < 2) err('js_full_name', 'Full name is required (min. 2 characters).');
    const mob = document.getElementById('js_mobile').value.replace(/\D/g,'');
    if (mob.length < 10) err('js_mobile', 'Enter a valid 10-digit mobile number.');
    const em = document.getElementById('js_email').value.trim();
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(em)) err('js_email', 'Enter a valid email address.');
    const pw = document.getElementById('js_password').value;
    if (pw.length < 8) err('js_password', 'Password must be at least 8 characters.');
    const cpw = document.getElementById('js_password_conf').value;
    if (cpw !== pw) err('js_password_conf', 'Passwords do not match.');
  }
  if (step === 2) {
    clr('js_state'); clr('js_district'); clr('js_city');
    if (!document.getElementById('js_state').value) err('js_state', 'Please select a state.');
    if (!document.getElementById('js_district').value) err('js_district', 'Please select a district.');
    if (document.getElementById('js_city').value.trim().length < 2) err('js_city', 'Please enter your city.');
  }
  if (step === 3) {
    clr('js_qual');
    if (!document.getElementById('js_qual').value) err('js_qual', 'Please select your qualification.');
  }
  if (step === 4) {
    const checked = document.querySelectorAll('input[name="skills[]"]:checked');
    if (checked.length === 0) { if (alertEl) alertEl.classList.add('show'); return false; }
  }
  if (!valid && alertEl && step !== 4) alertEl.classList.add('show');
  return valid;
}

function jsBuildSummary() {
  const qMap = {none:'None','10th':'10th Pass','12th':'12th / HSC',diploma:'Diploma',bachelor:"Bachelor's",master:"Master's",doctorate:'Doctorate'};
  const skills = Array.from(document.querySelectorAll('input[name="skills[]"]:checked')).map(c => c.value);
  const qual = document.getElementById('js_qual');
  const city = document.getElementById('js_city').value;
  const dist = document.getElementById('js_district').value;
  const state = document.getElementById('js_state').value;
  document.getElementById('js-sum-name').textContent = document.getElementById('js_full_name').value || '—';
  document.getElementById('js-sum-mobile').textContent = document.getElementById('js_mobile').value || '—';
  document.getElementById('js-sum-email').textContent = document.getElementById('js_email').value || '—';
  document.getElementById('js-sum-location').textContent = [city,dist,state].filter(Boolean).join(', ') || '—';
  document.getElementById('js-sum-qual').textContent = qMap[qual.value] || qual.value || '—';
  document.getElementById('js-sum-exp').textContent = document.getElementById('exp_experienced').checked ? 'Experienced' : 'Fresher';
  document.getElementById('js-sum-skills').textContent = skills.length ? skills.slice(0,8).join(', ') + (skills.length > 8 ? ' +' + (skills.length-8) + ' more' : '') : 'None selected';
}

document.getElementById('jsForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const btn = document.getElementById('jsSubmitBtn');
  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Creating Account...';
});

/* ─── EMPLOYER STEPS ─────────────────── */
let empCurrentStep = 1;

function empGoToStep(t) { if (t >= empCurrentStep) return; empShowStep(t); }
function empNextStep(from) { if (!empValidate(from)) return; empMarkDone(from); empShowStep(from + 1); if (from + 1 === 5) empBuildSummary(); }
function empPrevStep(from) { empShowStep(from - 1); }

function empShowStep(step) {
  document.querySelectorAll('#page-employer .lj-tab-panel').forEach(p => p.classList.remove('active'));
  document.getElementById('emp-tab-' + step).classList.add('active');
  document.querySelectorAll('#emp-stepIndicator .lj-step').forEach(s => {
    s.classList.remove('active');
    s.style.cursor = parseInt(s.dataset.step) < step ? 'pointer' : 'default';
  });
  document.querySelector('#emp-stepIndicator .lj-step[data-step="' + step + '"]').classList.add('active');
  empCurrentStep = step;
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function empMarkDone(step) {
  const el = document.querySelector('#emp-stepIndicator .lj-step[data-step="' + step + '"]');
  el.classList.remove('active');
  el.classList.add('done');
  el.querySelector('.lj-step-num').innerHTML = '<i class="fa-solid fa-check" style="font-size:.6rem;"></i>';
}

function empValidate(step) {
  let valid = true;
  const alertEl = document.getElementById('emp-alert-' + step);
  if (alertEl) alertEl.classList.remove('show');

  function err(id, msg) {
    valid = false;
    const f = document.getElementById(id);
    const e = document.getElementById('err-' + id);
    if (f) f.classList.add('field-error');
    if (e) { e.classList.add('show'); const sp = e.querySelector('span'); if (sp && msg) sp.textContent = msg; }
  }
  function clr(id) {
    const f = document.getElementById(id);
    const e = document.getElementById('err-' + id);
    if (f) f.classList.remove('field-error');
    if (e) e.classList.remove('show');
  }

  if (step === 1) {
    clr('emp_company_name'); clr('emp_address'); clr('emp_state'); clr('emp_district'); clr('emp_city'); clr('emp_pincode');
    if (document.getElementById('emp_company_name').value.trim().length < 2) err('emp_company_name','Company name is required.');
    if (document.getElementById('emp_address').value.trim().length < 10) err('emp_address','Please enter your company address.');
    if (!document.getElementById('emp_state').value) err('emp_state','Please select a state.');
    if (!document.getElementById('emp_district').value) err('emp_district','Please select a district.');
    if (document.getElementById('emp_city').value.trim().length < 2) err('emp_city','Please enter the city.');
    if (!/^\d{6}$/.test(document.getElementById('emp_pincode').value.trim())) err('emp_pincode','Enter a valid 6-digit pincode.');
  }
  if (step === 2) {
    clr('emp_owner_name'); clr('emp_owner_mobile'); clr('emp_hr_name'); clr('emp_hr_mobile');
    if (document.getElementById('emp_owner_name').value.trim().length < 2) err('emp_owner_name','Owner name is required.');
    if (document.getElementById('emp_owner_mobile').value.replace(/\D/g,'').length < 10) err('emp_owner_mobile','Enter a valid 10-digit mobile number.');
    if (document.getElementById('emp_hr_name').value.trim().length < 2) err('emp_hr_name','HR name is required.');
    if (document.getElementById('emp_hr_mobile').value.replace(/\D/g,'').length < 10) err('emp_hr_mobile','Enter a valid 10-digit mobile number.');
  }
  if (step === 3) {
    clr('emp_email'); clr('emp_password'); clr('emp_password_conf');
    if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(document.getElementById('emp_email').value.trim())) err('emp_email','Enter a valid email address.');
    const pw = document.getElementById('emp_password').value;
    if (pw.length < 8) err('emp_password','Password must be at least 8 characters.');
    if (document.getElementById('emp_password_conf').value !== pw) err('emp_password_conf','Passwords do not match.');
  }
  if (step === 4) {
    clr('emp_gst'); clr('emp_pan');
    if (!/^[0-9]{2}[A-Z]{5}[0-9]{4}[A-Z]{1}[1-9A-Z]{1}Z[0-9A-Z]{1}$/.test(document.getElementById('emp_gst').value.trim())) err('emp_gst','Enter a valid 15-character GST number.');
    if (!/^[A-Z]{5}[0-9]{4}[A-Z]{1}$/.test(document.getElementById('emp_pan').value.trim())) err('emp_pan','Enter a valid 10-character PAN number.');
  }
  if (!valid && alertEl) alertEl.classList.add('show');
  return valid;
}

function empBuildSummary() {
  const v = id => (document.getElementById(id)||{}).value || '—';
  const city = v('emp_city'), dist = v('emp_district'), state = v('emp_state');
  document.getElementById('emp-sum-company').textContent = v('emp_company_name');
  document.getElementById('emp-sum-location').textContent = [city,dist,state].filter(s=>s&&s!=='—').join(', ') || '—';
  document.getElementById('emp-sum-owner').textContent = v('emp_owner_name') + (v('emp_owner_mobile')!=='—' ? ' · ' + v('emp_owner_mobile') : '');
  document.getElementById('emp-sum-hr').textContent = v('emp_hr_name') + (v('emp_hr_mobile')!=='—' ? ' · ' + v('emp_hr_mobile') : '');
  document.getElementById('emp-sum-email').textContent = v('emp_email');
  document.getElementById('emp-sum-gst').textContent = v('emp_gst');
  document.getElementById('emp-sum-pan').textContent = v('emp_pan');
  const msme = v('emp_msme');
  document.getElementById('emp-sum-msme').textContent = msme !== '—' ? msme : 'Not provided';
}

document.getElementById('empForm').addEventListener('submit', function(e) {
  e.preventDefault();
  const gst = document.getElementById('emp_gstInput');
  const pan = document.getElementById('emp_panInput');
  let ok = true;
  if (!gst.files || !gst.files[0]) { document.getElementById('err-emp_gst_cert').classList.add('show'); ok = false; }
  if (!pan.files || !pan.files[0]) { document.getElementById('err-emp_pan_doc').classList.add('show'); ok = false; }
  if (!ok) return;
  const btn = document.getElementById('empSubmitBtn');
  btn.disabled = true;
  btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i> Registering Company...';
});

/* ─── SHARED UTILITIES ───────────────── */
function togglePwd(id, btn) {
  const inp = document.getElementById(id);
  const ico = btn.querySelector('i');
  if (inp.type === 'password') { inp.type = 'text'; ico.className = 'fa-solid fa-eye-slash'; }
  else { inp.type = 'password'; ico.className = 'fa-solid fa-eye'; }
}

function checkStrength(val, barId) {
  const bar = document.getElementById(barId);
  if (!bar) return;
  let score = 0;
  if (val.length >= 8) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  bar.style.width = ['0%','30%','55%','75%','100%'][score];
  bar.style.background = ['','#ef4444','#f97316','#eab308','#22c55e'][score];
}

function toggleExpFields(show) {
  const el = document.getElementById('expFields');
  el.style.display = show ? 'block' : 'none';
}

function showFile(zoneId, labelId, input, maxMB) {
  if (input.files && input.files[0]) {
    const file = input.files[0];
    if (file.size > maxMB * 1024 * 1024) {
      alert('File must not exceed ' + maxMB + ' MB.');
      input.value = '';
      return;
    }
    document.getElementById(labelId).textContent = file.name;
  }
}

/* ─── LIVE CLEAR ERRORS ──────────────── */
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.lj-input').forEach(function(inp) {
    ['input','change'].forEach(ev => inp.addEventListener(ev, function() {
      this.classList.remove('field-error');
      const errEl = document.getElementById('err-' + this.id);
      if (errEl) errEl.classList.remove('show');
    }));
  });

  /* Build skills checkboxes */
  const skillsData = {
    'IT & Software': ['PHP Developer','Java Developer','Python Developer','React Developer','Angular Developer','Node.js Developer','MySQL / Database','WordPress Developer','UI/UX Designer','Network Engineer'],
    'Technical & Trade': ['Electrician','Plumber','Welder','Machine Operator','CNC Operator','Lathe Operator','Mechanic','HVAC Technician','Quality Inspector','Safety Officer'],
    'Sales & Marketing': ['Sales Executive','Marketing Executive','Field Sales','Tele-calling','Business Development','Digital Marketing','SEO Specialist','Brand Manager'],
    'Office & Admin': ['Data Entry','HR Executive','Accountant','Office Admin','Receptionist','Customer Support','Back Office','Payroll Executive'],
    'Driver & Logistics': ['Driver','Delivery Executive','Forklift Operator','Warehouse Staff','Packing & Loading'],
  };
  const container = document.getElementById('skillsContainer');
  Object.entries(skillsData).forEach(([cat, skills], i) => {
    const sec = document.createElement('div');
    sec.className = 'lj-fsec';
    sec.style.marginTop = i === 0 ? '0' : '16px';
    sec.innerHTML = `<div class="lj-fsec-lbl" style="font-size:.68rem;">${cat}</div><div class="lj-fsec-line"></div>`;
    container.appendChild(sec);
    const wrap = document.createElement('div');
    wrap.className = 'lj-skill-wrap';
    skills.forEach(skill => {
      const id = 'skill_' + skill.toLowerCase().replace(/[^a-z0-9]/g,'_');
      const chip = document.createElement('div');
      chip.className = 'lj-skill-chip';
      chip.innerHTML = `<input type="checkbox" id="${id}" name="skills[]" value="${skill}"><label for="${id}">${skill}</label>`;
      wrap.appendChild(chip);
    });
    container.appendChild(wrap);
  });
});
</script>
</body>
</html>