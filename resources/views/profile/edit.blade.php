@extends('layouts.app')
@section('title', 'Edit Profile')

@section('content')
<div class="section profile-page">
    <div class="profile-toolbar">
        <div>
            <div class="section-title" style="margin-bottom:6px;">Profile Settings</div>
            <div class="section-sub">Update your account information, password, and security settings.</div>
        </div>
        <a href="{{ route('resources.index') }}" class="btn-ghost" style="text-decoration:none; display:inline-flex; align-items:center; gap:6px;">
            <i class="ti ti-arrow-left"></i> Back to browse
        </a>
    </div>

    <div class="profile-shell">
        <aside class="profile-summary">
            <div class="profile-head">
                <div class="profile-avatar">{{ strtoupper(substr($user->name, 0, 1)) }}</div>
                <div class="profile-info">
                    <div class="profile-name">{{ $user->name }}</div>
                    <div class="profile-bio">{{ $user->email }}</div>
                </div>
            </div>

            <div class="profile-stats">
                <div>
                    <div class="pstat-num">{{ $user->resources_count }}</div>
                    <div class="pstat-label">Listings</div>
                </div>
                <div>
                    <div class="pstat-num">{{ $user->created_at->format('Y') }}</div>
                    <div class="pstat-label">Joined</div>
                </div>
                <div>
                    <div class="pstat-num">{{ $user->updated_at->diffForHumans() }}</div>
                    <div class="pstat-label">Updated</div>
                </div>
            </div>

            <div style="display:grid; gap:10px;">
                <div class="profile-mini">
                    <div class="form-label" style="margin-bottom:6px;">Account status</div>
                    <div style="color:var(--cs-muted); font-size:0.9rem; line-height:1.6;">Manage your public identity and login credentials from one place.</div>
                </div>
                <div class="profile-mini">
                    <div class="form-label" style="margin-bottom:6px;">Security</div>
                    <div style="color:var(--cs-muted); font-size:0.9rem; line-height:1.6;">Use a strong password and keep the account deletion flow as a last resort.</div>
                </div>
            </div>
        </aside>

        <div class="profile-stack">
            <div class="arch-card">
                @include('profile.partials.update-profile-information-form')
            </div>

            <div class="arch-card">
                @include('profile.partials.update-password-form')
            </div>

            <div class="arch-card" style="border-color:rgba(255,107,107,0.16);">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>
</div>
@endsection
