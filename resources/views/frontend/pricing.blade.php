{{-- ═══════════════════════════════════════════════════
     resources/views/frontend/pricing.blade.php
     Pricing Page – LinearJobs  (Compact & Clean)
═══════════════════════════════════════════════════ --}}
@extends('frontend.app')
@section('title', 'Pricing – LinearJobs')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer"/>
<link href="https://fonts.googleapis.com/css2?family=Sora:wght@400;600;700;800;900&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet"/>
<style>
/* ── TOKENS ─────────────────────────────────────── */
:root{
  --b:   #1a56db; --b-lt: #eff6ff; --b-bd: #bfdbfe;
  --g:   #059669; --g-lt: #f0fdf9; --g-bd: #6ee7b7;
  --a:   #b45309; --a-lt: #fffbeb; --a-bd: #fcd34d;
  --p:   #7c3aed; --p-lt: #f5f3ff; --p-bd: #c4b5fd;
  --t:   #0d9488; --t-lt: #f0fdfa;
  --n0:#fff; --n50:#f8fafc; --n100:#f1f5f9;
  --n200:#e2e8f0; --n300:#cbd5e1; --n400:#94a3b8;
  --n500:#64748b; --n600:#475569; --n700:#334155;
  --n800:#1e293b; --n900:#0f172a;
  --gb: linear-gradient(135deg,#1a56db,#7c3aed);
  --gg: linear-gradient(135deg,#059669,#0d9488);
  --ga: linear-gradient(135deg,#b45309,#d97706);
  --gh: linear-gradient(150deg,#0f172a 0%,#1e293b 70%,#1a3a6e 100%);
  --sh: 0 1px 3px rgba(0,0,0,.06),0 4px 12px rgba(0,0,0,.07);
  --shh:0 8px 28px rgba(0,0,0,.12);
  --r:12px; --f:'Sora',sans-serif; --fb:'DM Sans',sans-serif;
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:var(--fb);color:var(--n700);background:var(--n50);}

/* ── HERO ──────────────────────────────────────── */
.ph{
  background:var(--gh);padding:52px 20px 56px;
  text-align:center;position:relative;overflow:hidden;
}
.ph::before{
  content:'';position:absolute;inset:0;
  background-image:radial-gradient(rgba(255,255,255,.05) 1px,transparent 1px);
  background-size:26px 26px;pointer-events:none;
}
.ph-blob{position:absolute;border-radius:50%;filter:blur(72px);pointer-events:none;}
.ph-b1{width:360px;height:360px;top:-100px;left:-80px;background:rgba(26,86,219,.22);}
.ph-b2{width:280px;height:280px;bottom:-90px;right:-50px;background:rgba(124,58,237,.18);}
.ph-inner{max-width:600px;margin:0 auto;position:relative;z-index:1;}
.ph-badge{
  display:inline-flex;align-items:center;gap:6px;
  background:rgba(255,255,255,.1);border:1.5px solid rgba(255,255,255,.18);
  border-radius:100px;padding:5px 14px;margin-bottom:16px;
  font-family:var(--f);font-size:.68rem;font-weight:700;
  color:rgba(255,255,255,.82);letter-spacing:.08em;text-transform:uppercase;
}
.ph-badge i{color:#fbbf24;font-size:.68rem;}
.ph-title{
  font-family:var(--f);font-size:clamp(1.7rem,4.5vw,2.4rem);
  font-weight:900;color:#fff;letter-spacing:-.5px;line-height:1.15;margin-bottom:12px;
}
.ph-title .ac{
  background:linear-gradient(90deg,#60a5fa,#a78bfa);
  -webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;
}
.ph-sub{font-size:.88rem;color:rgba(255,255,255,.6);line-height:1.7;margin-bottom:20px;}
.ph-gst{
  display:inline-flex;align-items:center;gap:6px;
  background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.16);
  border-radius:100px;padding:5px 14px;
  font-family:var(--f);font-size:.72rem;font-weight:700;color:rgba(255,255,255,.68);
}
.ph-gst i{color:#fbbf24;}

/* ── QUICK SUMMARY STATS ────────────────────────── */
.ph-stats{
  max-width:720px;margin:0 auto;
  display:flex;align-items:stretch;justify-content:center;
  background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.12);
  border-radius:14px;margin-top:28px;overflow:hidden;position:relative;z-index:1;
}
.ph-stat{
  flex:1;padding:14px 10px;text-align:center;
  border-right:1px solid rgba(255,255,255,.1);
}
.ph-stat:last-child{border-right:none;}
.ph-stat-val{font-family:var(--f);font-size:1.1rem;font-weight:900;color:#fff;}
.ph-stat-lbl{font-size:.62rem;color:rgba(255,255,255,.55);margin-top:2px;letter-spacing:.04em;}
@media(max-width:480px){
  .ph-stats{flex-wrap:wrap;}
  .ph-stat{flex:1 1 50%;border-bottom:1px solid rgba(255,255,255,.1);}
  .ph-stat:nth-child(2){border-right:none;}
  .ph-stat:nth-child(3),.ph-stat:nth-child(4){border-bottom:none;}
}

/* ── TAB BAR — HIGHLIGHTED ──────────────────────── */
.pt-bar{
  background:#fff;border-bottom:2px solid var(--n100);
  padding:0 20px;position:sticky;top:0;z-index:50;
  box-shadow:0 2px 8px rgba(0,0,0,.05);
}
.pt-inner{
  max-width:1040px;margin:0 auto;
  display:flex;align-items:stretch;gap:6px;padding:8px 0;
}
.pt-btn{
  flex:1;padding:10px 12px;border-radius:10px;border:none;
  background:var(--n50);cursor:pointer;transition:all .2s;
  display:flex;align-items:center;justify-content:center;
  gap:7px;white-space:nowrap;font-family:var(--f);
  font-size:.78rem;font-weight:700;color:var(--n500);
  border:1.5px solid var(--n100);
}
.pt-btn i{font-size:.8rem;}
.pt-btn:hover{background:var(--n100);color:var(--n800);}
/* Active states — each tab gets its OWN highlight colour */
.pt-btn.a-blue  {background:var(--b-lt); color:var(--b); border-color:var(--b-bd); box-shadow:0 0 0 1px rgba(26,86,219,.15);}
.pt-btn.a-green {background:var(--g-lt); color:var(--g); border-color:var(--g-bd); box-shadow:0 0 0 1px rgba(5,150,105,.15);}
.pt-btn.a-amber {background:var(--a-lt); color:var(--a); border-color:var(--a-bd); box-shadow:0 0 0 1px rgba(180,83,9,.15);}
@media(max-width:520px){
  .pt-bar{overflow-x:auto;scrollbar-width:none;}
  .pt-bar::-webkit-scrollbar{display:none;}
  .pt-inner{min-width:max-content;gap:4px;}
  .pt-btn{padding:9px 12px;font-size:.72rem;}
}

/* ── PANELS ─────────────────────────────────────── */
.pp-wrap{max-width:1040px;margin:0 auto;padding:36px 20px 64px;}
.pp{display:none;}
.pp.active{display:block;animation:pp-in .25s ease both;}
@keyframes pp-in{from{opacity:0;transform:translateY(6px)}to{opacity:1;transform:translateY(0)}}

/* ── MODULE BANNER (compact) ───────────────────── */
.pm-bar{
  display:flex;align-items:center;gap:14px;
  padding:18px 22px;border-radius:var(--r);margin-bottom:24px;
  position:relative;overflow:hidden;
}
.pm-bar.bl{background:var(--gb);}
.pm-bar.gr{background:var(--gg);}
.pm-bar.am{background:var(--ga);}
.pm-bar::after{
  content:'';position:absolute;top:-24px;right:-24px;
  width:110px;height:110px;border-radius:50%;
  background:rgba(255,255,255,.07);pointer-events:none;
}
.pm-ico{
  width:44px;height:44px;border-radius:11px;flex-shrink:0;
  background:rgba(255,255,255,.18);border:1.5px solid rgba(255,255,255,.28);
  display:flex;align-items:center;justify-content:center;
  font-size:1.1rem;color:#fff;
}
.pm-name{font-family:var(--f);font-size:1rem;font-weight:900;color:#fff;letter-spacing:-.25px;}
.pm-sub{font-size:.75rem;color:rgba(255,255,255,.68);margin-top:2px;}
.pm-right{margin-left:auto;display:flex;gap:8px;position:relative;z-index:1;flex-shrink:0;}
.pm-stat{
  background:rgba(255,255,255,.14);border:1px solid rgba(255,255,255,.2);
  border-radius:9px;padding:7px 13px;text-align:center;
}
.pm-stat-v{font-family:var(--f);font-size:.88rem;font-weight:900;color:#fff;}
.pm-stat-l{font-size:.6rem;color:rgba(255,255,255,.6);margin-top:1px;}
@media(max-width:560px){.pm-bar{flex-wrap:wrap;}.pm-right{margin-left:0;}}

/* ── PLAN CARDS GRID ────────────────────────────── */
.pg2{display:grid;grid-template-columns:1fr 1fr;gap:18px;margin-bottom:22px;}
.pg3{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-bottom:22px;}
@media(max-width:780px){.pg3{grid-template-columns:1fr 1fr;}}
@media(max-width:520px){.pg2,.pg3{grid-template-columns:1fr;}}

/* ── PLAN CARD ──────────────────────────────────── */
.pc{
  background:#fff;border:2px solid var(--n200);border-radius:16px;
  display:flex;flex-direction:column;overflow:hidden;position:relative;
  transition:transform .22s,box-shadow .22s,border-color .22s;
  box-shadow:var(--sh);
}
.pc:hover{transform:translateY(-4px);box-shadow:var(--shh);}
.pc.feat-b{border-color:var(--b);box-shadow:0 4px 20px rgba(26,86,219,.13);}
.pc.feat-g{border-color:var(--g);box-shadow:0 4px 20px rgba(5,150,105,.12);}
.pc-stripe{height:3px;}
.pc-stripe.b{background:var(--gb);}
.pc-stripe.g{background:var(--gg);}
.pc-stripe.a{background:var(--ga);}
.pc-stripe.p{background:linear-gradient(90deg,#7c3aed,#a855f7);}
.pc-stripe.s{background:linear-gradient(90deg,#64748b,#94a3b8);}
.pc-stripe.t{background:linear-gradient(90deg,#0d9488,#14b8a6);}
.pc-ribbon{
  position:absolute;top:12px;right:12px;
  font-family:var(--f);font-size:.58rem;font-weight:800;
  letter-spacing:.06em;text-transform:uppercase;
  color:#fff;padding:3px 10px;border-radius:100px;
}
.pc-ribbon.b{background:var(--gb);}
.pc-ribbon.g{background:var(--gg);}
.pc-hdr{padding:18px 20px 0;}
.pc-ico{
  width:40px;height:40px;border-radius:11px;
  display:flex;align-items:center;justify-content:center;font-size:1rem;
  margin-bottom:11px;
}
.pc-ico.b {background:var(--b-lt);color:var(--b);}
.pc-ico.p {background:var(--p-lt);color:var(--p);}
.pc-ico.g {background:var(--g-lt);color:var(--g);}
.pc-ico.a {background:var(--a-lt);color:var(--a);}
.pc-ico.t {background:var(--t-lt);color:var(--t);}
.pc-ico.s {background:#f1f5f9;   color:#64748b;}
.pc-name{font-family:var(--f);font-size:.6rem;font-weight:800;color:var(--n400);letter-spacing:.08em;text-transform:uppercase;margin-bottom:6px;}
.pc-price{display:flex;align-items:flex-end;gap:2px;}
.pc-cur{font-family:var(--f);font-size:1rem;font-weight:800;color:var(--n700);line-height:1;margin-bottom:4px;}
.pc-amt{font-family:var(--f);font-size:2.2rem;font-weight:900;color:var(--n900);line-height:1;letter-spacing:-1.5px;}
.pc.feat-b .pc-amt{color:var(--b);}
.pc.feat-g .pc-amt{color:var(--g);}
.pc-gst{font-size:.7rem;color:var(--n400);align-self:flex-end;padding-bottom:4px;}
.pc-valid{
  display:inline-flex;align-items:center;gap:5px;
  background:var(--n100);border:1.5px solid var(--n200);
  border-radius:100px;padding:3px 10px;
  font-family:var(--f);font-size:.68rem;font-weight:700;color:var(--n600);
  margin:8px 0 14px;
}
.pc.feat-b .pc-valid{background:var(--b-lt);border-color:var(--b-bd);color:var(--b);}
.pc.feat-g .pc-valid{background:var(--g-lt);border-color:var(--g-bd);color:var(--g);}
.pc-valid i{color:var(--g);font-size:.65rem;}
/* total pill */
.pc-tot{
  margin:0 20px 14px;padding:7px 12px;border-radius:8px;
  font-family:var(--f);font-size:.7rem;
}
.pc-tot.b{background:var(--b-lt);color:#1e40af;}
.pc-tot.g{background:var(--g-lt);color:var(--g);}
.pc-tot.s{background:#f1f5f9;color:#475569;}
.pc-tot.p{background:var(--p-lt);color:#4c1d95;}
.pc-tot strong{font-weight:900;}
.pc-div{height:1px;background:var(--n100);margin:0 20px;}
.pc-feats{padding:14px 20px 0;flex:1;}
.pc-feats-ttl{font-family:var(--f);font-size:.6rem;font-weight:800;color:var(--n400);letter-spacing:.07em;text-transform:uppercase;margin-bottom:10px;}
.pc-feats ul{list-style:none;margin-bottom:16px;}
.pc-feats li{
  display:flex;align-items:flex-start;gap:8px;
  font-size:.78rem;color:var(--n600);padding:5px 0;
  border-bottom:1px solid var(--n50);font-family:var(--fb);
}
.pc-feats li:last-child{border-bottom:none;}
.pc-feats li.dim{color:var(--n400);}
.chk{
  flex-shrink:0;width:15px;height:15px;border-radius:50%;
  display:flex;align-items:center;justify-content:center;font-size:.48rem;
  margin-top:1px;
}
.chk.b{background:var(--b-lt);color:var(--b);}
.chk.g{background:var(--g-lt);color:var(--g);}
.chk.a{background:var(--a-lt);color:var(--a);}
.chk.p{background:var(--p-lt);color:var(--p);}
.chk.n{background:var(--n100);color:var(--n300);}
.fd{font-size:.68rem;color:var(--n400);display:block;margin-top:1px;}
.pc-foot{padding:0 20px 20px;}
.pbtn{
  width:100%;border:none;border-radius:10px;
  font-family:var(--f);font-size:.82rem;font-weight:800;
  padding:11px 16px;cursor:pointer;
  display:flex;align-items:center;justify-content:center;gap:8px;
  transition:all .2s;text-decoration:none;
}
.pbtn:hover{transform:translateY(-2px);filter:brightness(1.07);}
.pbtn.ob{background:#fff;border:2px solid var(--b);color:var(--b);}
.pbtn.sb{background:var(--gb);color:#fff;box-shadow:0 3px 12px rgba(26,86,219,.26);}
.pbtn.og{background:#fff;border:2px solid var(--g);color:var(--g);}
.pbtn.sg{background:var(--gg);color:#fff;box-shadow:0 3px 12px rgba(5,150,105,.24);}
.pbtn.sa{background:var(--ga);color:#fff;box-shadow:0 3px 12px rgba(180,83,9,.22);}
.pbtn.oa{background:#fff;border:2px solid var(--a);color:var(--a);}
.pbtn.sp{background:linear-gradient(135deg,#7c3aed,#a855f7);color:#fff;box-shadow:0 3px 12px rgba(124,58,237,.22);}

/* ── GST NOTE ───────────────────────────────────── */
.gst-note{
  display:flex;align-items:flex-start;gap:8px;
  background:#fefce8;border:1.5px solid #fde68a;
  border-radius:9px;padding:10px 14px;
  font-size:.77rem;color:#92400e;margin-bottom:28px;font-family:var(--fb);
}
.gst-note i{flex-shrink:0;margin-top:1px;}

/* ── COMPARE TABLE ──────────────────────────────── */
.cmp{margin-bottom:32px;}
.cmp-hdr{text-align:center;margin-bottom:18px;}
.cmp-hdr h3{font-family:var(--f);font-size:1.1rem;font-weight:800;color:var(--n900);letter-spacing:-.25px;margin-bottom:3px;}
.cmp-hdr p{font-size:.8rem;color:var(--n500);}
.cmp-wrap{overflow-x:auto;border-radius:13px;box-shadow:var(--sh);}
.cmp-tbl{width:100%;border-collapse:collapse;background:#fff;}
.cmp-tbl thead tr{background:var(--n50);}
.cmp-tbl th{
  padding:11px 15px;text-align:left;
  font-family:var(--f);font-size:.63rem;font-weight:800;
  color:var(--n500);text-transform:uppercase;letter-spacing:.06em;
  border-bottom:2px solid var(--n100);
}
.cmp-tbl th:not(:first-child){text-align:center;}
.cmp-tbl td{
  padding:10px 15px;font-size:.8rem;color:var(--n700);
  border-bottom:1px solid var(--n50);font-family:var(--fb);
}
.cmp-tbl td:not(:first-child){text-align:center;font-family:var(--f);font-weight:700;}
.cmp-tbl tr:last-child td{border-bottom:none;}
.cmp-tbl tr:hover td{background:rgba(0,0,0,.012);}
.hl-b{background:rgba(26,86,219,.04);}
.hl-g{background:rgba(5,150,105,.04);}
.tc{color:var(--g);font-size:.85rem;}
.tx{color:var(--n300);font-size:.85rem;}

/* ── BANNER AD WIDE CARD ────────────────────────── */
.ba-card{
  background:#fff;border:2px solid var(--a);
  border-radius:16px;overflow:hidden;margin-bottom:28px;
  box-shadow:0 4px 18px rgba(180,83,9,.09);
}
.ba-top{
  background:var(--ga);padding:22px 26px;
  display:grid;grid-template-columns:auto 1fr auto;
  gap:18px;align-items:center;position:relative;overflow:hidden;
}
.ba-top::before{content:'';position:absolute;top:-30px;right:-30px;width:130px;height:130px;border-radius:50%;background:rgba(255,255,255,.07);}
.ba-ico{
  width:52px;height:52px;border-radius:13px;flex-shrink:0;
  background:rgba(255,255,255,.18);border:1.5px solid rgba(255,255,255,.28);
  display:flex;align-items:center;justify-content:center;font-size:1.3rem;color:#fff;
}
.ba-title{font-family:var(--f);font-size:1rem;font-weight:900;color:#fff;letter-spacing:-.2px;}
.ba-sub{font-size:.75rem;color:rgba(255,255,255,.68);margin-top:3px;}
.ba-price{text-align:right;position:relative;z-index:1;}
.ba-price .amt{font-family:var(--f);font-size:1.8rem;font-weight:900;color:#fff;letter-spacing:-1px;line-height:1;}
.ba-price .gst{font-size:.7rem;color:rgba(255,255,255,.6);margin-top:2px;}
.ba-price .tot{font-family:var(--f);font-size:.75rem;font-weight:800;color:rgba(255,255,255,.88);margin-top:3px;}
@media(max-width:560px){
  .ba-top{grid-template-columns:auto 1fr;grid-template-rows:auto auto;}
  .ba-price{grid-column:1/-1;text-align:left;}
}
.ba-body{padding:22px 26px;}
.ba-feats{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-bottom:20px;}
@media(max-width:600px){.ba-feats{grid-template-columns:1fr 1fr;}}
@media(max-width:380px){.ba-feats{grid-template-columns:1fr;}}
.ba-feat{background:var(--n50);border:1.5px solid var(--n100);border-radius:11px;padding:14px 13px;}
.ba-feat-ico{
  width:32px;height:32px;border-radius:8px;
  background:var(--a-lt);color:var(--a);
  display:flex;align-items:center;justify-content:center;font-size:.82rem;margin-bottom:9px;
}
.ba-feat-title{font-family:var(--f);font-size:.78rem;font-weight:800;color:var(--n800);margin-bottom:3px;}
.ba-feat-desc{font-size:.7rem;color:var(--n500);line-height:1.5;}
.ba-ctas{display:flex;gap:10px;flex-wrap:wrap;}

/* ── FAQ ────────────────────────────────────────── */
.faq{margin-bottom:32px;}
.faq-hdr{text-align:center;margin-bottom:18px;}
.faq-hdr h3{font-family:var(--f);font-size:1.1rem;font-weight:800;color:var(--n900);letter-spacing:-.25px;margin-bottom:3px;}
.faq-hdr p{font-size:.8rem;color:var(--n500);}
.faq-grid{display:grid;grid-template-columns:1fr 1fr;gap:10px;}
@media(max-width:580px){.faq-grid{grid-template-columns:1fr;}}
.faq-item{background:#fff;border:1.5px solid var(--n200);border-radius:11px;overflow:hidden;box-shadow:var(--sh);}
.faq-q{
  padding:13px 16px;font-family:var(--f);font-size:.8rem;font-weight:700;
  color:var(--n800);cursor:pointer;display:flex;align-items:center;
  justify-content:space-between;gap:10px;transition:background .18s;
}
.faq-q:hover{background:var(--n50);}
.faq-q i{color:var(--n400);font-size:.72rem;transition:transform .22s;flex-shrink:0;}
.faq-item.open .faq-q{color:var(--b);}
.faq-item.open .faq-q i{transform:rotate(180deg);color:var(--b);}
.faq-a{max-height:0;overflow:hidden;transition:max-height .3s ease;}
.faq-item.open .faq-a{max-height:200px;}
.faq-a-in{padding:0 16px 13px;font-size:.78rem;color:var(--n600);line-height:1.65;border-top:1px solid var(--n100);}

/* ── CTA ────────────────────────────────────────── */
.pcta{
  background:var(--gh);border-radius:16px;
  padding:40px 32px;text-align:center;position:relative;overflow:hidden;
}
.pcta::before{content:'';position:absolute;inset:0;background-image:radial-gradient(rgba(255,255,255,.04) 1px,transparent 1px);background-size:22px 22px;}
.pcta-in{position:relative;z-index:1;}
.pcta-title{font-family:var(--f);font-size:1.45rem;font-weight:900;color:#fff;letter-spacing:-.35px;margin-bottom:8px;}
.pcta-sub{font-size:.85rem;color:rgba(255,255,255,.62);margin-bottom:22px;line-height:1.65;}
.pcta-btns{display:flex;gap:10px;justify-content:center;flex-wrap:wrap;}
.pcta-w{
  background:#fff;color:var(--b);border:none;border-radius:9px;
  font-family:var(--f);font-size:.84rem;font-weight:800;
  padding:11px 24px;cursor:pointer;display:flex;align-items:center;gap:7px;
  transition:all .2s;text-decoration:none;
}
.pcta-w:hover{transform:translateY(-2px);box-shadow:0 5px 18px rgba(0,0,0,.18);}
.pcta-g{
  background:transparent;color:#fff;
  border:2px solid rgba(255,255,255,.3);border-radius:9px;
  font-family:var(--f);font-size:.84rem;font-weight:800;
  padding:11px 24px;cursor:pointer;display:flex;align-items:center;gap:7px;
  transition:all .2s;text-decoration:none;
}
.pcta-g:hover{border-color:rgba(255,255,255,.7);background:rgba(255,255,255,.07);}
@media(max-width:480px){.pcta{padding:28px 20px;}.pcta-title{font-size:1.2rem;}}
</style>
@endpush

@section('content')

{{-- ═══ HERO ═══ --}}
<div class="ph">
  <div class="ph-blob ph-b1"></div>
  <div class="ph-blob ph-b2"></div>
  <div class="ph-inner">
    <div class="ph-badge"><i class="fa-solid fa-tag"></i> Transparent Pricing</div>
    <h1 class="ph-title">Hire Smarter with<br><span class="ac">Plans Built for MSMEs</span></h1>
    <p class="ph-sub">Job Posting · Resume Database · Banner Advertising — pay only for what you need.</p>
    <div class="ph-gst"><i class="fa-solid fa-circle-info"></i> All prices exclude 18% GST</div>
    <div class="ph-stats">
      <div class="ph-stat"><div class="ph-stat-val">₹600</div><div class="ph-stat-lbl">Job Post Starts</div></div>
      <div class="ph-stat"><div class="ph-stat-val">₹2,000</div><div class="ph-stat-lbl">Resume DB Starts</div></div>
      <div class="ph-stat"><div class="ph-stat-val">₹2,000</div><div class="ph-stat-lbl">Banner Ad</div></div>
      <div class="ph-stat"><div class="ph-stat-val">Free</div><div class="ph-stat-lbl">Job Seekers</div></div>
    </div>
  </div>
</div>

{{-- ═══ TAB BAR ═══ --}}
<div class="pt-bar">
  <div class="pt-inner">
    <button class="pt-btn a-blue" id="tab-job"    onclick="prTab(this,'job')">
      <i class="fa-solid fa-briefcase"></i> Job Posting
    </button>
    <button class="pt-btn"        id="tab-resume" onclick="prTab(this,'resume')">
      <i class="fa-solid fa-database"></i> Resume DB
    </button>
    <button class="pt-btn"        id="tab-banner" onclick="prTab(this,'banner')">
      <i class="fa-solid fa-image"></i> Banner Ad
    </button>
  </div>
</div>

{{-- ═══ PANELS ═══ --}}
<div class="pp-wrap">

  {{-- ─────────────────────────────────────────
       PANEL 1 — JOB POSTING
  ───────────────────────────────────────── --}}
  <div class="pp active" id="pp-job">

    <div class="pm-bar bl">
      <div class="pm-ico"><i class="fa-solid fa-briefcase"></i></div>
      <div><div class="pm-name">Job Posting Plans</div><div class="pm-sub">Reach job seekers across all 32 Tamil Nadu districts</div></div>
      <div class="pm-right">
        <div class="pm-stat"><div class="pm-stat-v">2 Plans</div><div class="pm-stat-l">Available</div></div>
        <div class="pm-stat"><div class="pm-stat-v">₹600</div><div class="pm-stat-l">Starts at</div></div>
      </div>
    </div>

    <div class="pg2">

      {{-- 15 Day --}}
      <div class="pc">
        <div class="pc-stripe b"></div>
        <div class="pc-hdr">
          <div class="pc-ico b"><i class="fa-solid fa-bolt"></i></div>
          <div class="pc-name">15 Day Plan</div>
          <div class="pc-price">
            <div class="pc-cur">₹</div><div class="pc-amt">600</div>
            <div class="pc-gst">+ GST</div>
          </div>
          <div class="pc-valid"><i class="fa-solid fa-clock"></i> Job visible 15 days from activation</div>
        </div>
        <div class="pc-tot b">Total: <strong>₹708</strong> <span style="opacity:.6;font-weight:400;">(incl. 18% GST)</span></div>
        <div class="pc-div"></div>
        <div class="pc-feats">
          <div class="pc-feats-ttl">Includes</div>
          <ul>
            <li><span class="chk b"><i class="fa-solid fa-check"></i></span><div>Post 1 Job Opening<span class="fd">Single active listing</span></div></li>
            <li><span class="chk b"><i class="fa-solid fa-check"></i></span><div>Visible for 15 Days<span class="fd">From date of activation</span></div></li>
            <li><span class="chk b"><i class="fa-solid fa-check"></i></span><div>Applicant Management</div></li>
            <li><span class="chk b"><i class="fa-solid fa-check"></i></span><div>Email Notifications</div></li>
            <li><span class="chk b"><i class="fa-solid fa-check"></i></span><div>Tamil Nadu Reach<span class="fd">All 32 districts</span></div></li>
            <li class="dim"><span class="chk n"><i class="fa-solid fa-xmark"></i></span><div>Featured Listing</div></li>
            <li class="dim"><span class="chk n"><i class="fa-solid fa-xmark"></i></span><div>Priority Support</div></li>
          </ul>
        </div>
        <div class="pc-foot">
          <a href="{{ route('employer.login') }}" class="pbtn ob"><i class="fa-solid fa-bolt"></i> Buy 15 Day Plan</a>
        </div>
      </div>

      {{-- 30 Day --}}
      <div class="pc feat-b">
        <div class="pc-stripe b"></div>
        <div class="pc-ribbon b">⭐ Most Popular</div>
        <div class="pc-hdr">
          <div class="pc-ico p"><i class="fa-solid fa-crown"></i></div>
          <div class="pc-name">30 Day Plan</div>
          <div class="pc-price">
            <div class="pc-cur">₹</div><div class="pc-amt">1,000</div>
            <div class="pc-gst">+ GST</div>
          </div>
          <div class="pc-valid"><i class="fa-solid fa-clock"></i> Job visible 30 days from activation</div>
        </div>
        <div class="pc-tot b">Total: <strong>₹1,180</strong> <span style="opacity:.6;font-weight:400;">(incl. 18% GST)</span></div>
        <div class="pc-div"></div>
        <div class="pc-feats">
          <div class="pc-feats-ttl">Includes</div>
          <ul>
            <li><span class="chk b"><i class="fa-solid fa-check"></i></span><div>Post 1 Job Opening<span class="fd">Single active listing</span></div></li>
            <li><span class="chk b"><i class="fa-solid fa-check"></i></span><div>Visible for 30 Days<span class="fd">From date of activation</span></div></li>
            <li><span class="chk b"><i class="fa-solid fa-check"></i></span><div>Applicant Management</div></li>
            <li><span class="chk b"><i class="fa-solid fa-check"></i></span><div>Email Notifications</div></li>
            <li><span class="chk b"><i class="fa-solid fa-check"></i></span><div>Tamil Nadu Reach<span class="fd">All 32 districts</span></div></li>
            <li><span class="chk b"><i class="fa-solid fa-check"></i></span><div>Featured Listing<span class="fd">Highlighted on Find Jobs page</span></div></li>
            <li><span class="chk b"><i class="fa-solid fa-check"></i></span><div>Priority Support<span class="fd">Email &amp; phone</span></div></li>
          </ul>
        </div>
        <div class="pc-foot">
          <a href="{{ route('employer.login') }}" class="pbtn sb"><i class="fa-solid fa-crown"></i> Buy 30 Day Plan</a>
        </div>
      </div>

    </div>

    <div class="gst-note">
      <i class="fa-solid fa-circle-info"></i>
      Prices exclude 18% GST. &nbsp;<strong>15 Days: ₹600 + ₹108 = ₹708</strong>&nbsp;|&nbsp;<strong>30 Days: ₹1,000 + ₹180 = ₹1,180</strong>
    </div>

    {{-- Compare --}}
    <div class="cmp">
      <div class="cmp-hdr"><h3>Plan Comparison</h3><p>See exactly what you get</p></div>
      <div class="cmp-wrap">
        <table class="cmp-tbl">
          <thead>
            <tr>
              <th style="width:52%;">Feature</th>
              <th>15 Day Plan<br><span style="font-size:.6rem;font-weight:600;color:var(--n500);">₹600 + GST</span></th>
              <th class="hl-b">30 Day Plan<br><span style="font-size:.6rem;font-weight:700;color:var(--b);">₹1,000 + GST</span></th>
            </tr>
          </thead>
          <tbody>
            <tr><td>Job Postings</td><td>1</td><td class="hl-b">1</td></tr>
            <tr><td>Listing Visibility</td><td>15 Days</td><td class="hl-b">30 Days</td></tr>
            <tr><td>Applicant Management</td><td><i class="fa-solid fa-check tc"></i></td><td class="hl-b"><i class="fa-solid fa-check tc"></i></td></tr>
            <tr><td>Email Notifications</td><td><i class="fa-solid fa-check tc"></i></td><td class="hl-b"><i class="fa-solid fa-check tc"></i></td></tr>
            <tr><td>Employer Dashboard</td><td><i class="fa-solid fa-check tc"></i></td><td class="hl-b"><i class="fa-solid fa-check tc"></i></td></tr>
            <tr><td>All-District Reach (TN)</td><td><i class="fa-solid fa-check tc"></i></td><td class="hl-b"><i class="fa-solid fa-check tc"></i></td></tr>
            <tr><td>Featured Listing</td><td><i class="fa-solid fa-xmark tx"></i></td><td class="hl-b"><i class="fa-solid fa-check tc"></i></td></tr>
            <tr><td>Priority Support</td><td><i class="fa-solid fa-xmark tx"></i></td><td class="hl-b"><i class="fa-solid fa-check tc"></i></td></tr>
            <tr><td><strong>Total (incl. GST)</strong></td><td>₹708</td><td class="hl-b" style="color:var(--b);">₹1,180</td></tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>{{-- /pp-job --}}


  {{-- ─────────────────────────────────────────
       PANEL 2 — RESUME DB
  ───────────────────────────────────────── --}}
  <div class="pp" id="pp-resume">

    <div class="pm-bar gr">
      <div class="pm-ico"><i class="fa-solid fa-database"></i></div>
      <div><div class="pm-name">Resume Database Plans</div><div class="pm-sub">Download resumes from Tamil Nadu's active candidate pool</div></div>
      <div class="pm-right">
        <div class="pm-stat"><div class="pm-stat-v">3 Plans</div><div class="pm-stat-l">Available</div></div>
        <div class="pm-stat"><div class="pm-stat-v">₹2,000</div><div class="pm-stat-l">Starts at</div></div>
      </div>
    </div>

    <div class="pg3">

      {{-- Silver --}}
      <div class="pc">
        <div class="pc-stripe s"></div>
        <div class="pc-hdr">
          <div class="pc-ico s"><i class="fa-solid fa-medal" style="color:#94a3b8;"></i></div>
          <div class="pc-name">Silver Plan</div>
          <div class="pc-price">
            <div class="pc-cur">₹</div><div class="pc-amt">2,000</div>
            <div class="pc-gst">+ GST</div>
          </div>
          <div class="pc-valid"><i class="fa-solid fa-clock"></i> Valid 30 Days</div>
        </div>
        <div class="pc-tot s">Total: <strong>₹2,360</strong> <span style="opacity:.6;font-weight:400;">(incl. GST)</span></div>
        <div class="pc-div"></div>
        <div class="pc-feats">
          <div class="pc-feats-ttl">Includes</div>
          <ul>
            <li><span class="chk g"><i class="fa-solid fa-check"></i></span><div>100 Resume Downloads<span class="fd">Active candidate database</span></div></li>
            <li><span class="chk g"><i class="fa-solid fa-check"></i></span><div>Full Profile Access</div></li>
            <li><span class="chk g"><i class="fa-solid fa-check"></i></span><div>Filter by Skills &amp; Location</div></li>
            <li><span class="chk g"><i class="fa-solid fa-check"></i></span><div>Export to Excel / PDF</div></li>
            <li><span class="chk g"><i class="fa-solid fa-check"></i></span><div>Email Support</div></li>
            <li class="dim"><span class="chk n"><i class="fa-solid fa-xmark"></i></span><div>Dedicated Manager</div></li>
          </ul>
        </div>
        <div class="pc-foot">
          <a href="{{ route('employer.login') }}" class="pbtn og"><i class="fa-solid fa-medal"></i> Buy Silver</a>
        </div>
      </div>

      {{-- Gold --}}
      <div class="pc feat-g">
        <div class="pc-stripe g"></div>
        <div class="pc-ribbon g">🥇 Best Value</div>
        <div class="pc-hdr">
          <div class="pc-ico t"><i class="fa-solid fa-medal"></i></div>
          <div class="pc-name">Gold Plan</div>
          <div class="pc-price">
            <div class="pc-cur">₹</div><div class="pc-amt">3,000</div>
            <div class="pc-gst">+ GST</div>
          </div>
          <div class="pc-valid"><i class="fa-solid fa-clock"></i> Valid 45 Days</div>
        </div>
        <div class="pc-tot g">Total: <strong>₹3,540</strong> <span style="opacity:.6;font-weight:400;">(incl. GST)</span></div>
        <div class="pc-div"></div>
        <div class="pc-feats">
          <div class="pc-feats-ttl">Includes</div>
          <ul>
            <li><span class="chk g"><i class="fa-solid fa-check"></i></span><div>200 Resume Downloads<span class="fd">Active candidate database</span></div></li>
            <li><span class="chk g"><i class="fa-solid fa-check"></i></span><div>Full Profile Access</div></li>
            <li><span class="chk g"><i class="fa-solid fa-check"></i></span><div>Advanced Filters</div></li>
            <li><span class="chk g"><i class="fa-solid fa-check"></i></span><div>Export to Excel / PDF</div></li>
            <li><span class="chk g"><i class="fa-solid fa-check"></i></span><div>Priority Email Support</div></li>
            <li><span class="chk g"><i class="fa-solid fa-check"></i></span><div>Candidate Shortlisting</div></li>
          </ul>
        </div>
        <div class="pc-foot">
          <a href="{{ route('employer.login') }}" class="pbtn sg"><i class="fa-solid fa-medal"></i> Buy Gold</a>
        </div>
      </div>

      {{-- Platinum --}}
      <div class="pc">
        <div class="pc-stripe p"></div>
        <div class="pc-hdr">
          <div class="pc-ico p"><i class="fa-solid fa-gem"></i></div>
          <div class="pc-name">Platinum Plan</div>
          <div class="pc-price">
            <div class="pc-cur">₹</div><div class="pc-amt">5,000</div>
            <div class="pc-gst">+ GST</div>
          </div>
          <div class="pc-valid"><i class="fa-solid fa-clock"></i> Valid 60 Days</div>
        </div>
        <div class="pc-tot p">Total: <strong>₹5,900</strong> <span style="opacity:.6;font-weight:400;">(incl. GST)</span></div>
        <div class="pc-div"></div>
        <div class="pc-feats">
          <div class="pc-feats-ttl">Includes</div>
          <ul>
            <li><span class="chk p"><i class="fa-solid fa-check"></i></span><div>500 Resume Downloads<span class="fd">Active candidate database</span></div></li>
            <li><span class="chk p"><i class="fa-solid fa-check"></i></span><div>Full Profile Access</div></li>
            <li><span class="chk p"><i class="fa-solid fa-check"></i></span><div>All Advanced Filters</div></li>
            <li><span class="chk p"><i class="fa-solid fa-check"></i></span><div>Export to Excel / PDF</div></li>
            <li><span class="chk p"><i class="fa-solid fa-check"></i></span><div>Dedicated Account Manager</div></li>
            <li><span class="chk p"><i class="fa-solid fa-check"></i></span><div>Unlimited Shortlisting</div></li>
            <li><span class="chk p"><i class="fa-solid fa-check"></i></span><div>WhatsApp Support</div></li>
          </ul>
        </div>
        <div class="pc-foot">
          <a href="{{ route('employer.login') }}" class="pbtn sp"><i class="fa-solid fa-gem"></i> Buy Platinum</a>
        </div>
      </div>

    </div>

    <div class="gst-note">
      <i class="fa-solid fa-circle-info"></i>
      Prices exclude 18% GST.&nbsp;
      <strong>Silver: ₹2,360</strong>&nbsp;|&nbsp;
      <strong>Gold: ₹3,540</strong>&nbsp;|&nbsp;
      <strong>Platinum: ₹5,900</strong>
    </div>

    <div class="cmp">
      <div class="cmp-hdr"><h3>Resume DB Comparison</h3><p>Pick the plan for your hiring volume</p></div>
      <div class="cmp-wrap">
        <table class="cmp-tbl">
          <thead>
            <tr>
              <th style="width:36%;">Feature</th>
              <th>Silver<br><span style="font-size:.6rem;font-weight:600;color:var(--n500);">₹2,000+GST</span></th>
              <th class="hl-g">Gold<br><span style="font-size:.6rem;font-weight:700;color:var(--g);">₹3,000+GST</span></th>
              <th>Platinum<br><span style="font-size:.6rem;font-weight:600;color:var(--p);">₹5,000+GST</span></th>
            </tr>
          </thead>
          <tbody>
            <tr><td>Resume Downloads</td><td>100</td><td class="hl-g">200</td><td>500</td></tr>
            <tr><td>Validity</td><td>30 Days</td><td class="hl-g">45 Days</td><td>60 Days</td></tr>
            <tr><td>Full Profile Access</td><td><i class="fa-solid fa-check tc"></i></td><td class="hl-g"><i class="fa-solid fa-check tc"></i></td><td><i class="fa-solid fa-check tc"></i></td></tr>
            <tr><td>Filter by Skills / Location</td><td><i class="fa-solid fa-check tc"></i></td><td class="hl-g"><i class="fa-solid fa-check tc"></i></td><td><i class="fa-solid fa-check tc"></i></td></tr>
            <tr><td>Export (Excel / PDF)</td><td><i class="fa-solid fa-check tc"></i></td><td class="hl-g"><i class="fa-solid fa-check tc"></i></td><td><i class="fa-solid fa-check tc"></i></td></tr>
            <tr><td>Advanced Filters</td><td><i class="fa-solid fa-xmark tx"></i></td><td class="hl-g"><i class="fa-solid fa-check tc"></i></td><td><i class="fa-solid fa-check tc"></i></td></tr>
            <tr><td>Candidate Shortlisting</td><td><i class="fa-solid fa-xmark tx"></i></td><td class="hl-g"><i class="fa-solid fa-check tc"></i></td><td><i class="fa-solid fa-check tc"></i></td></tr>
            <tr><td>Dedicated Manager</td><td><i class="fa-solid fa-xmark tx"></i></td><td class="hl-g"><i class="fa-solid fa-xmark tx"></i></td><td><i class="fa-solid fa-check tc"></i></td></tr>
            <tr><td>WhatsApp Support</td><td><i class="fa-solid fa-xmark tx"></i></td><td class="hl-g"><i class="fa-solid fa-xmark tx"></i></td><td><i class="fa-solid fa-check tc"></i></td></tr>
            <tr><td><strong>Total (incl. GST)</strong></td><td>₹2,360</td><td class="hl-g" style="color:var(--g);">₹3,540</td><td style="color:var(--p);">₹5,900</td></tr>
          </tbody>
        </table>
      </div>
    </div>

  </div>{{-- /pp-resume --}}


  {{-- ─────────────────────────────────────────
       PANEL 3 — BANNER AD
  ───────────────────────────────────────── --}}
  <div class="pp" id="pp-banner">

    <div class="pm-bar am">
      <div class="pm-ico"><i class="fa-solid fa-image"></i></div>
      <div><div class="pm-name">Banner Advertisement</div><div class="pm-sub">Image banner on LinearJobs home page — supports multiple positions</div></div>
      <div class="pm-right">
        <div class="pm-stat"><div class="pm-stat-v">10 Days</div><div class="pm-stat-l">Duration</div></div>
        <div class="pm-stat"><div class="pm-stat-v">₹2,360</div><div class="pm-stat-l">Incl. GST</div></div>
      </div>
    </div>

    <div class="ba-card">
      <div class="ba-top">
        <div class="ba-ico"><i class="fa-solid fa-image"></i></div>
        <div>
          <div class="ba-title">Home Page Banner Advertisement</div>
          <div class="ba-sub">Full-width image banner on the LinearJobs home page — visible to all visitors</div>
        </div>
        <div class="ba-price">
          <div class="amt">₹2,000</div>
          <div class="gst">+ 18% GST (₹360)</div>
          <div class="tot">Total: ₹2,360</div>
        </div>
      </div>
      <div class="ba-body">
        <div class="ba-feats">
          <div class="ba-feat">
            <div class="ba-feat-ico"><i class="fa-solid fa-image"></i></div>
            <div class="ba-feat-title">Image Banner</div>
            <div class="ba-feat-desc">Upload PNG, JPG or WEBP — recommended 1200 × 400 px</div>
          </div>
          <div class="ba-feat">
            <div class="ba-feat-ico"><i class="fa-solid fa-list-check"></i></div>
            <div class="ba-feat-title">Multi-Position</div>
            <div class="ba-feat-desc">Show multiple job openings in one banner — great for bulk hiring</div>
          </div>
          <div class="ba-feat">
            <div class="ba-feat-ico"><i class="fa-solid fa-calendar-days"></i></div>
            <div class="ba-feat-title">10-Day Exposure</div>
            <div class="ba-feat-desc">Banner live on home page for 10 continuous days from activation</div>
          </div>
          <div class="ba-feat">
            <div class="ba-feat-ico"><i class="fa-solid fa-eye"></i></div>
            <div class="ba-feat-title">Prime Placement</div>
            <div class="ba-feat-desc">Sponsored banner slot on the home page — highest traffic section</div>
          </div>
          <div class="ba-feat">
            <div class="ba-feat-ico"><i class="fa-solid fa-clock"></i></div>
            <div class="ba-feat-title">Quick Activation</div>
            <div class="ba-feat-desc">Goes live within 24 hours of payment verification</div>
          </div>
          <div class="ba-feat">
            <div class="ba-feat-ico"><i class="fa-solid fa-indian-rupee-sign"></i></div>
            <div class="ba-feat-title">Flat Rate</div>
            <div class="ba-feat-desc">₹2,000 + GST for 10 days. No bidding, no hidden charges</div>
          </div>
        </div>
        <div class="gst-note" style="background:#fff7ed;border-color:#fed7aa;margin-bottom:18px;">
          <i class="fa-solid fa-circle-info"></i>
          ₹2,000 + 18% GST (₹360) = <strong>₹2,360 total.</strong> Banner goes live within 24 hours of payment.
        </div>
        <div class="ba-ctas">
          <a href="{{ route('employer.login') }}" class="pbtn sa" style="width:auto;padding:11px 24px;">
            <i class="fa-solid fa-image"></i> Purchase Banner Ad
          </a>
          <a href="{{ route('employer.login') }}" class="pbtn oa" style="width:auto;padding:11px 20px;">
            <i class="fa-solid fa-eye"></i> Preview Placement
          </a>
        </div>
      </div>
    </div>

  </div>{{-- /pp-banner --}}


  {{-- ═══ SHARED FAQ ═══ --}}
  <div class="faq">
    <div class="faq-hdr">
      <h3>Frequently Asked Questions</h3>
      <p>Everything you need to know about LinearJobs pricing</p>
    </div>
    <div class="faq-grid">
      @php
      $faqs = [
        ['q'=>'Is GST applicable on all plan prices?','a'=>'Yes. 18% GST applies to all plans. Prices shown are exclusive of GST. The final payable amount including GST is displayed at checkout.'],
        ['q'=>'Can I post multiple jobs in one plan?','a'=>'Each Job Posting plan supports 1 active listing. To post multiple jobs at once, purchase one plan per job opening.'],
        ['q'=>'What happens when my posting plan expires?','a'=>'Your listing is automatically taken offline. Renew anytime from your employer dashboard by purchasing a new plan.'],
        ['q'=>'How does the Resume DB plan work?','a'=>'Once purchased, search and download candidate resumes within your download limit and validity window directly from your dashboard.'],
        ['q'=>'How do I submit my banner image?','a'=>'After purchasing, upload your banner (PNG/JPG, 1200×400 recommended) from your employer dashboard. It goes live within 24 hours.'],
        ['q'=>'Are refunds available?','a'=>'Refunds are not available after a plan is activated. Review all plan details carefully before purchasing.'],
        ['q'=>'Is LinearJobs free for job seekers?','a'=>'Yes — 100% free. No charges for browsing, applying, or creating a job seeker profile.'],
        ['q'=>'What payment methods are accepted?','a'=>'UPI, Net Banking, Debit/Credit Cards, and all major wallets. Payments are processed securely.'],
      ];
      @endphp
      @foreach($faqs as $i => $f)
      <div class="faq-item" id="prf-{{ $i }}">
        <div class="faq-q" onclick="prFaq({{ $i }})">{{ $f['q'] }}<i class="fa-solid fa-chevron-down"></i></div>
        <div class="faq-a"><div class="faq-a-in">{{ $f['a'] }}</div></div>
      </div>
      @endforeach
    </div>
  </div>

  {{-- ═══ CTA ═══ --}}
  <div class="pcta">
    <div class="pcta-in">
      <div class="pcta-title">Ready to Hire Top Talent in Tamil Nadu?</div>
      <div class="pcta-sub">Register your company and post your first job in minutes. Trusted by MSMEs across all 32 districts.</div>
      <div class="pcta-btns">
        <a href="{{ route('employer.register') }}" class="pcta-w"><i class="fa-solid fa-building-flag"></i> Register Company</a>
        <a href="{{ route('contact') }}"           class="pcta-g"><i class="fa-solid fa-phone"></i> Talk to Us</a>
      </div>
    </div>
  </div>

</div>{{-- /pp-wrap --}}
@endsection

@push('scripts')
<script>
/* Tab colours per module */
var TAB_CLS = { job:'a-blue', resume:'a-green', banner:'a-amber' };

function prTab(btn, panel) {
  /* reset tabs */
  document.querySelectorAll('.pt-btn').forEach(function(t){
    t.classList.remove('a-blue','a-green','a-amber');
  });
  /* reset panels */
  document.querySelectorAll('.pp').forEach(function(p){ p.classList.remove('active'); });
  /* activate */
  btn.classList.add(TAB_CLS[panel]);
  document.getElementById('pp-' + panel).classList.add('active');
  /* smooth scroll to panel area */
  document.querySelector('.pp-wrap').scrollIntoView({behavior:'smooth',block:'start'});
}

/* FAQ */
function prFaq(i) {
  var item = document.getElementById('prf-' + i);
  var open = item.classList.contains('open');
  document.querySelectorAll('.faq-item.open').forEach(function(el){ el.classList.remove('open'); });
  if (!open) item.classList.add('open');
}
</script>
@endpush