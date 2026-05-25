@extends('layouts.app')

@section('title', $resource->title)
@section('meta_description', Str::limit($resource->description, 160))

@php
    $gmailComposeUrl = $resource->contact_email
        ? 'https://mail.google.com/mail/?view=cm&fs=1&to=' . rawurlencode($resource->contact_email) . '&su=' . rawurlencode('Inquiry about ' . $resource->title)
        : null;
@endphp

@section('content')
<div class="section" style="padding-top:1rem;">
    <!-- Breadcrumb -->
    <div style="margin-bottom:1.5rem; font-size:0.85rem; color:var(--cs-muted);">
        <a href="{{ route('resources.index') }}" style="color:var(--cs-accent); text-decoration:none;">Resources</a>
        <span style="margin:0 6px;">›</span>
        <a href="{{ route('resources.index', ['category' => $resource->category_id]) }}" style="color:var(--cs-accent); text-decoration:none;">{{ $resource->category->name }}</a>
        <span style="margin:0 6px;">›</span>
        <span>{{ Str::limit($resource->title, 40) }}</span>
    </div>

    <div style="display:grid; grid-template-columns:2fr 1fr; gap:2rem; align-items:start;">
        <!-- Left Column -->
        <div>
            @if($resource->cover_image)
                <div class="arch-card" style="margin-bottom:1.5rem; display:flex; align-items:center; justify-content:space-between; gap:1rem;">
                    <div style="display:flex; align-items:center; gap:12px; min-width:0;">
                        <div style="width:44px; height:44px; border-radius:12px; background:rgba(122,92,255,0.14); color:var(--cs-accent); display:flex; align-items:center; justify-content:center; flex:0 0 auto;">
                            <i class="ti ti-paperclip" style="font-size:1.25rem;"></i>
                        </div>
                        <div style="min-width:0;">
                            <div class="form-label" style="margin-bottom:2px;">Attachment</div>
                            <div style="font-size:0.875rem; color:var(--cs-muted); overflow:hidden; text-overflow:ellipsis; white-space:nowrap; max-width:100%;">
                                {{ basename($resource->cover_image) }}
                            </div>
                        </div>
                    </div>
                    <a href="{{ Storage::url($resource->cover_image) }}" target="_blank" rel="noopener" class="btn-ghost" style="text-decoration:none; white-space:nowrap; display:inline-flex; align-items:center; gap:6px; padding:10px 14px;">
                        <i class="ti ti-download"></i> Open
                    </a>
                </div>
            @endif

            <!-- Title & Badges -->
            <div style="margin-bottom:1.5rem;">
                <div style="display:flex; gap:8px; flex-wrap:wrap; margin-bottom:10px;">
                    <span class="card-badge badge-{{ $resource->type === 'share' ? 'tool' : 'knowledge' }}" style="position:static;">
                        {{ $resource->type === 'share' ? 'Offering' : 'Requesting' }}
                    </span>
                    <span style="padding:4px 10px; border-radius:100px; font-size:0.7rem; font-weight:500;
                        background:{{ $resource->status === 'active' ? 'rgba(0,217,166,0.12)' : ($resource->status === 'paused' ? 'rgba(255,179,71,0.12)' : 'rgba(255,107,107,0.12)') }};
                        color:{{ $resource->status === 'active' ? 'var(--cs-accent3)' : ($resource->status === 'paused' ? 'var(--cs-amber)' : 'var(--cs-accent2)') }};
                        border:1px solid {{ $resource->status === 'active' ? 'rgba(0,217,166,0.25)' : ($resource->status === 'paused' ? 'rgba(255,179,71,0.25)' : 'rgba(255,107,107,0.25)') }};">
                        {{ ucfirst($resource->status) }}
                    </span>
                </div>
                <h1 style="font-family:var(--pf); font-size:1.6rem; font-weight:500; line-height:1.3;">{{ $resource->title }}</h1>
            </div>

            <!-- Description Card -->
            <div class="arch-card" style="margin-bottom:1.5rem;">
                <div class="form-label" style="text-transform:uppercase; letter-spacing:0.05em; margin-bottom:10px;">Description</div>
                <div style="font-size:0.9rem; line-height:1.8; color:var(--cs-muted);">
                    {!! nl2br(e($resource->description)) !!}
                </div>
            </div>

            <!-- Details Card -->
            <div class="arch-card">
                <div class="form-label" style="text-transform:uppercase; letter-spacing:0.05em; margin-bottom:12px;">Details</div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div>
                        <div style="font-size:0.72rem; color:var(--cs-muted); margin-bottom:4px;">Category</div>
                        <div style="font-size:0.875rem; display:flex; align-items:center; gap:4px;">
                            <i class="ti ti-tag"></i> {{ $resource->category->name }}
                        </div>
                    </div>
                    @if($resource->location)
                    <div>
                        <div style="font-size:0.72rem; color:var(--cs-muted); margin-bottom:4px;">Location</div>
                        <div style="font-size:0.875rem; display:flex; align-items:center; gap:4px;">
                            <i class="ti ti-map-pin"></i> {{ $resource->location }}
                        </div>
                    </div>
                    @endif
                    @if($resource->contact_email)
                    <div>
                        <div style="font-size:0.72rem; color:var(--cs-muted); margin-bottom:4px;">Contact</div>
                        <div style="font-size:0.875rem;">
                            <a href="{{ $gmailComposeUrl }}" target="_blank" rel="noopener noreferrer" style="color:var(--cs-accent); text-decoration:none; display:flex; align-items:center; gap:4px;">
                                <i class="ti ti-mail"></i> {{ $resource->contact_email }}
                            </a>
                        </div>
                    </div>
                    @endif
                    <div>
                        <div style="font-size:0.72rem; color:var(--cs-muted); margin-bottom:4px;">Posted</div>
                        <div style="font-size:0.875rem; display:flex; align-items:center; gap:4px;">
                            <i class="ti ti-clock"></i> {{ $resource->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column — Sidebar -->
        <div>
            <!-- Posted By Card -->
            <div class="arch-card" style="margin-bottom:1rem;">
                <div class="form-label" style="text-transform:uppercase; letter-spacing:0.05em; margin-bottom:12px;">Listed by</div>
                <div style="display:flex; align-items:center; gap:12px;">
                    <div class="card-avatar" style="width:40px; height:40px; font-size:14px;">
                        {{ strtoupper(substr($resource->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <div style="font-size:0.9rem; font-weight:500;">{{ $resource->user->name }}</div>
                        <div style="font-size:0.75rem; color:var(--cs-muted);">Joined {{ $resource->user->created_at->format('M Y') }}</div>
                    </div>
                </div>
                @if($resource->contact_email)
                    <a href="{{ $gmailComposeUrl }}" target="_blank" rel="noopener noreferrer" class="btn-primary" style="width:100%; display:flex; align-items:center; justify-content:center; gap:6px; margin-top:1rem; padding:10px; text-decoration:none;">
                        <i class="ti ti-mail"></i> Contact
                    </a>
                @endif
            </div>

            <!-- Owner Actions -->
            @auth
                @if(Auth::id() === $resource->user_id)
                    <div class="arch-card">
                        <div class="form-label" style="text-transform:uppercase; letter-spacing:0.05em; margin-bottom:12px;">Manage</div>
                        <div style="display:flex; flex-direction:column; gap:8px;">
                            <a href="{{ route('resources.edit', $resource) }}" class="btn-ghost" style="display:flex; align-items:center; justify-content:center; gap:6px; text-decoration:none; padding:10px;">
                                <i class="ti ti-pencil"></i> Edit Resource
                            </a>
                            <form method="POST" action="{{ route('resources.destroy', $resource) }}" onsubmit="return confirm('Are you sure you want to delete this resource?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="width:100%; background:rgba(255,107,107,0.1); border:1px solid rgba(255,107,107,0.25); color:var(--cs-accent2); padding:10px; border-radius:8px; font-family:var(--dm); font-size:0.875rem; cursor:pointer; display:flex; align-items:center; justify-content:center; gap:6px; transition:all .2s;">
                                    <i class="ti ti-trash"></i> Delete Resource
                                </button>
                            </form>
                        </div>
                    </div>
                @endif
            @endauth
        </div>
    </div>
</div>

<style>
    @media(max-width:768px) {
        .section > div:nth-child(2) { grid-template-columns:1fr !important; }
    }
</style>
@endsection
