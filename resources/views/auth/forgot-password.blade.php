@extends('layouts.app')
@section('title', 'Forgot Password')

@section('content')
<div class="section" style="display:flex; justify-content:center; align-items:center; min-height:70vh;">
    <div style="background:var(--cs-card); border:1px solid var(--cs-border); border-radius:16px; padding:2.5rem; width:100%; max-width:420px; box-shadow:0 10px 40px rgba(0,0,0,0.5);">
        <div style="text-align:center; margin-bottom:2rem;">
            <div style="width:48px; height:48px; background:linear-gradient(135deg,var(--cs-amber),var(--cs-accent2)); border-radius:12px; display:inline-flex; align-items:center; justify-content:center; font-size:24px; color:#fff; margin-bottom:1rem;">
                <i class="ti ti-key"></i>
            </div>
            <h2 style="font-family:var(--pf); font-size:1.8rem; font-weight:500; color:var(--cs-text);">Forgot Password</h2>
            <p style="color:var(--cs-muted); font-size:0.85rem; margin-top:8px; line-height:1.6;">No worries. Enter your email and we'll send you a reset link.</p>
        </div>

        @if (session('status'))
            <div style="color:var(--cs-accent3); font-size:0.875rem; margin-bottom:1rem; text-align:center; background:rgba(0,217,166,0.1); border:1px solid rgba(0,217,166,0.25); border-radius:8px; padding:10px;">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus />
                @error('email')
                    <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn-primary" style="width:100%; padding:12px; font-size:1rem; margin-top:1rem;">Email Password Reset Link</button>

            <div style="text-align:center; margin-top:1.5rem; font-size:0.85rem; color:var(--cs-muted);">
                Remember it? <a href="{{ route('login') }}" style="color:var(--cs-accent); text-decoration:none;">Log In</a>
            </div>
        </form>
    </div>
</div>
@endsection
