@extends('layouts.app')
@section('title', 'Log In')

@section('content')
<div class="section" style="display:flex; justify-content:center; align-items:center; min-height:70vh;">
    <div style="background:var(--cs-card); border:1px solid var(--cs-border); border-radius:16px; padding:2.5rem; width:100%; max-width:420px; box-shadow:0 10px 40px rgba(0,0,0,0.5);">
        <div style="text-align:center; margin-bottom:2rem;">
            <div style="width:48px; height:48px; background:linear-gradient(135deg,var(--cs-accent),var(--cs-accent2)); border-radius:12px; display:inline-flex; align-items:center; justify-content:center; font-size:24px; color:#fff; margin-bottom:1rem;">
                <i class="ti ti-login"></i>
            </div>
            <h2 style="font-family:var(--pf); font-size:1.8rem; font-weight:500; color:var(--cs-text);">Welcome Back</h2>
            <p style="color:var(--cs-muted); font-size:0.9rem; margin-top:4px;">Enter your credentials to continue</p>
        </div>

        <!-- Session Status -->
        @if (session('status'))
            <div style="color:var(--cs-accent3); font-size:0.875rem; margin-bottom:1rem; text-align:center;">
                {{ session('status') }}
            </div>
        @endif

        <style>
            @keyframes spin { 100% { transform: rotate(360deg); } }
        </style>
        <form method="POST" action="{{ route('login') }}" onsubmit="const btn = document.getElementById('login-btn'); btn.innerHTML = '<i class=\'ti ti-loader\' style=\'animation: spin 1s linear infinite;\'></i> Loading...'; btn.style.opacity = '0.7'; btn.style.cursor = 'not-allowed'; btn.disabled = true;">
            @csrf
            
            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
                @error('email')
                    <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <label for="password" class="form-label" style="margin-bottom:0;">Password</label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:0.75rem; color:var(--cs-accent); text-decoration:none;">Forgot password?</a>
                    @endif
                </div>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" style="margin-top:6px;" />
                @error('password')
                    <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Remember Me -->
            <div class="form-group" style="display:flex; align-items:center; gap:8px;">
                <input id="remember_me" type="checkbox" name="remember" style="accent-color:var(--cs-accent);">
                <label for="remember_me" style="font-size:0.8rem; color:var(--cs-muted);">Remember me</label>
            </div>

            <button id="login-btn" type="submit" class="btn-primary" style="width:100%; padding:12px; font-size:1rem; margin-top:1rem; display:flex; justify-content:center; align-items:center; gap:8px; transition: all 0.2s;">Log In</button>
            
            <div style="text-align:center; margin-top:1.5rem; font-size:0.85rem; color:var(--cs-muted);">
                Don't have an account? <a href="{{ route('register') }}" style="color:var(--cs-accent); text-decoration:none;">Register</a>
            </div>
        </form>
    </div>
</div>
@endsection
