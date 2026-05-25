@extends('layouts.app')

@section('title', 'Welcome')
@section('meta_description', 'ConnectShare helps people share resources, tools, and opportunities in one place.')

@section('content')
<div style="position:relative; overflow:hidden; padding-inline:clamp(1.25rem, 4vw, 4rem);">
    <div style="position:absolute; inset:0; background:
        radial-gradient(circle at top left, rgba(122,92,255,0.24), transparent 28%),
        radial-gradient(circle at 80% 20%, rgba(0,217,166,0.18), transparent 22%),
        linear-gradient(180deg, rgba(9,11,18,0.35), rgba(9,11,18,0.9)); pointer-events:none;"></div>

    <div class="section" style="position:relative; padding-top:2rem; padding-bottom:3rem; max-width:1200px; margin:0 auto;">
        <div style="display:grid; grid-template-columns:minmax(0,1.2fr) minmax(320px,0.8fr); gap:2rem; align-items:center; padding-inline:clamp(0.5rem, 1vw, 1rem);">
            <div>
                <div style="display:inline-flex; align-items:center; gap:8px; padding:6px 12px; border-radius:999px; border:1px solid var(--cs-border); background:rgba(255,255,255,0.03); color:var(--cs-muted); font-size:0.8rem; margin-bottom:1rem;">
                    <i class="ti ti-sparkles"></i> Share what you have, find what you need
                </div>
                <h1 style="font-family:var(--pf); font-size:clamp(2.8rem, 5vw, 5rem); line-height:1; margin-bottom:1rem; max-width:10ch;">
                    Connect, share, and collaborate without friction.
                </h1>
                <p style="max-width:58ch; font-size:1rem; line-height:1.8; color:var(--cs-muted); margin-bottom:1.5rem;">
                    ConnectShare is a focused marketplace for tools, skills, and services. Browse listings, post your own resources, and reach the right person directly when you need to.
                </p>

                <div style="display:flex; gap:12px; flex-wrap:wrap; margin-bottom:1.5rem;">
                    <a href="{{ route('login') }}" class="btn-primary" style="text-decoration:none; padding:12px 18px; display:inline-flex; align-items:center; gap:8px;">
                        <i class="ti ti-login"></i> Log in
                    </a>
                    <a href="{{ route('register') }}" class="btn-ghost" style="text-decoration:none; padding:12px 18px; display:inline-flex; align-items:center; gap:8px;">
                        <i class="ti ti-user-plus"></i> Create account
                    </a>
                </div>

                <div style="display:flex; gap:1rem; flex-wrap:wrap; color:var(--cs-muted); font-size:0.9rem;">
                    <span style="display:inline-flex; align-items:center; gap:6px;"><i class="ti ti-check"></i> Optional file attachments</span>
                    <span style="display:inline-flex; align-items:center; gap:6px;"><i class="ti ti-check"></i> Direct contact via Gmail</span>
                    <span style="display:inline-flex; align-items:center; gap:6px;"><i class="ti ti-check"></i> Fast listing management</span>
                </div>

                <div style="display:flex; gap:1.5rem; flex-wrap:wrap; margin-top:1.75rem; color:var(--cs-text);">
                    <div>
                        <div style="font-family:var(--pf); font-size:1.6rem;">{{ $resourceCount ?? 0 }}</div>
                        <div style="font-size:0.78rem; color:var(--cs-muted);">Resources shared</div>
                    </div>
                    <div>
                        <div style="font-family:var(--pf); font-size:1.6rem;">{{ $userCount ?? 0 }}</div>
                        <div style="font-size:0.78rem; color:var(--cs-muted);">Members</div>
                    </div>
                </div>
            </div>

            <div style="display:grid; gap:1rem;">
                <div class="arch-card" style="padding:1.25rem;">
                    <div class="form-label" style="margin-bottom:8px;">For people with something to share</div>
                    <div style="color:var(--cs-muted); line-height:1.7; font-size:0.95rem;">
                        Post a tool, service, or skill and let others connect with you quickly.
                    </div>
                </div>
                <div class="arch-card" style="padding:1.25rem;">
                    <div class="form-label" style="margin-bottom:8px;">For people looking for help</div>
                    <div style="color:var(--cs-muted); line-height:1.7; font-size:0.95rem;">
                        Request what you need and keep the conversation in one place.
                    </div>
                </div>
                <div class="arch-card" style="padding:1.25rem;">
                    <div class="form-label" style="margin-bottom:8px;">For fast follow-up</div>
                    <div style="color:var(--cs-muted); line-height:1.7; font-size:0.95rem;">
                        Open Gmail with the recipient already filled in so outreach stays simple.
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @media (max-width: 900px) {
        .section > div > div {
            grid-template-columns: 1fr !important;
        }
    }
</style>
@endsection