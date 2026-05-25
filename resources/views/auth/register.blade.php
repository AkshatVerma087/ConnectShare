@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="section" style="display:flex; justify-content:center; align-items:center; min-height:70vh;">
    <div style="background:var(--cs-card); border:1px solid var(--cs-border); border-radius:16px; padding:2.5rem; width:100%; max-width:420px; box-shadow:0 10px 40px rgba(0,0,0,0.5);">
        <div style="text-align:center; margin-bottom:2rem;">
            <div style="width:48px; height:48px; background:linear-gradient(135deg,var(--cs-accent3),var(--cs-accent)); border-radius:12px; display:inline-flex; align-items:center; justify-content:center; font-size:24px; color:#fff; margin-bottom:1rem;">
                <i class="ti ti-user-plus"></i>
            </div>
            <h2 style="font-family:var(--pf); font-size:1.8rem; font-weight:500; color:var(--cs-text);">Join ConnectShare</h2>
            <p style="color:var(--cs-muted); font-size:0.9rem; margin-top:4px;">Create your account to start sharing</p>
        </div>

        <style>
            @keyframes spin { 100% { transform: rotate(360deg); } }
        </style>
        <form method="POST" action="{{ route('register') }}" onsubmit="const btn = document.getElementById('register-btn'); btn.innerHTML = '<i class=\'ti ti-loader\' style=\'animation: spin 1s linear infinite;\'></i> Loading...'; btn.style.opacity = '0.7'; btn.style.cursor = 'not-allowed'; btn.disabled = true;">
            @csrf

            <!-- Name -->
            <div class="form-group">
                <label for="name" class="form-label">Full Name</label>
                <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
                @error('name')
                    <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Email Address -->
            <div class="form-group">
                <label for="email" class="form-label">Email Address</label>
                <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
                @error('email')
                    <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Password -->
            <div class="form-group">
                <label for="password" class="form-label">Password</label>
                <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" />
                @error('password')
                    <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="form-group">
                <label for="password_confirmation" class="form-label">Confirm Password</label>
                <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" />
                @error('password_confirmation')
                    <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <button id="register-btn" type="submit" class="btn-primary" style="width:100%; padding:12px; font-size:1rem; margin-top:1rem; display:flex; justify-content:center; align-items:center; gap:8px; transition: all 0.2s;">Register</button>
            
            <div style="text-align:center; margin-top:1.5rem; font-size:0.85rem; color:var(--cs-muted);">
                Already have an account? <a href="{{ route('login') }}" style="color:var(--cs-accent); text-decoration:none;">Log In</a>
            </div>
        </form>
    </div>
</div>
@endsection
