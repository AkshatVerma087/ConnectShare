@extends('layouts.app')
@section('title', 'Post a Resource')

@section('content')
<div class="section" style="display:flex; justify-content:center; align-items:flex-start; min-height:70vh; padding-top: 2rem;">
    <div style="background:var(--cs-card); border:1px solid var(--cs-border); border-radius:16px; padding:2.5rem; width:100%; max-width:600px; box-shadow:0 10px 40px rgba(0,0,0,0.5);">
        <div style="margin-bottom:2rem;">
            <a href="{{ route('resources.index') }}" style="font-size:0.875rem; color:var(--cs-muted); text-decoration:none; display:inline-flex; align-items:center; margin-bottom:1rem;">
                <i class="ti ti-arrow-left" style="margin-right:4px;"></i> Back to Resources
            </a>
            <h2 style="font-family:var(--pf); font-size:1.8rem; font-weight:500; color:var(--cs-text);">Post a Resource</h2>
            <p style="color:var(--cs-muted); font-size:0.9rem; margin-top:4px;">Share something with your community.</p>
        </div>

        <form method="POST" action="{{ route('resources.store') }}" enctype="multipart/form-data" onsubmit="const btn = document.getElementById('submit-btn'); btn.innerHTML = '<i class=\'ti ti-loader\' style=\'animation: spin 1s linear infinite;\'></i> Posting...'; btn.style.opacity = '0.7'; btn.style.cursor = 'not-allowed'; btn.disabled = true;">
            @csrf
            
            <style>
                @keyframes spin { 100% { transform: rotate(360deg); } }
                .form-row { display: flex; gap: 1rem; margin-bottom: 1.25rem; }
                .form-col { flex: 1; }
                @media (max-width: 600px) {
                    .form-row { flex-direction: column; gap: 0; margin-bottom: 0; }
                    .form-row .form-group { margin-bottom: 1.25rem; }
                }
            </style>

            <!-- Title -->
            <div class="form-group">
                <label for="title" class="form-label">Title</label>
                <input id="title" class="form-input" type="text" name="title" value="{{ old('title') }}" placeholder="What are you sharing?" required autofocus />
                @error('title')
                    <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <!-- Category -->
                <div class="form-col form-group">
                    <label for="category_id" class="form-label">Category</label>
                    <select id="category_id" class="form-select" name="category_id" required>
                        <option value="">Select category</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Type -->
                <div class="form-col form-group">
                    <label for="type" class="form-label">Type</label>
                    <select id="type" class="form-select" name="type" required>
                        <option value="share" {{ old('type', 'share') === 'share' ? 'selected' : '' }}>Offering</option>
                        <option value="request" {{ old('type') === 'request' ? 'selected' : '' }}>Requesting</option>
                    </select>
                    @error('type')
                        <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Status -->
            <div class="form-group">
                <label for="status" class="form-label">Status</label>
                <select id="status" class="form-select" name="status" required>
                    <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                    <option value="paused" {{ old('status') === 'paused' ? 'selected' : '' }}>Paused</option>
                    <option value="closed" {{ old('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
                @error('status')
                    <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- Description -->
            <div class="form-group">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" class="form-textarea" name="description" rows="5" placeholder="Describe what you're offering or looking for (min 20 characters)..." required>{{ old('description') }}</textarea>
                @error('description')
                    <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-row">
                <!-- Location -->
                <div class="form-col form-group">
                    <label for="location" class="form-label">Location</label>
                    <input id="location" class="form-input" type="text" name="location" value="{{ old('location') }}" placeholder="City or Remote" />
                    @error('location')
                        <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Contact Email -->
                <div class="form-col form-group">
                    <label for="contact_email" class="form-label">Contact Email</label>
                    <input id="contact_email" class="form-input" type="email" name="contact_email" value="{{ old('contact_email') }}" placeholder="your@email.com" />
                    @error('contact_email')
                        <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Attachment File -->
            <div class="form-group">
                <label for="attachment_file" class="form-label">Attachment File <span style="color:var(--cs-muted); font-weight:400;">(optional)</span></label>
                <input id="attachment_file" class="form-input" type="file" name="attachment_file" style="padding-left:0; background:transparent; border:none; color:var(--cs-text);" />
                <div style="font-size:0.75rem; color:var(--cs-muted); margin-top:4px;">Upload a PDF, DOCX, or any other file type if you want to attach something.</div>
                @error('attachment_file')
                    <div style="color:var(--cs-accent2); font-size:0.75rem; margin-top:4px;">{{ $message }}</div>
                @enderror
            </div>

            <div style="display:flex; gap:12px; margin-top:2rem;">
                <button id="submit-btn" type="submit" class="btn-primary" style="padding:12px 24px; display:inline-flex; align-items:center; gap:8px;">
                    <i class="ti ti-check"></i> Post Resource
                </button>
                <a href="{{ route('resources.index') }}" class="btn-ghost" style="padding:12px 24px; text-decoration:none; display:inline-flex; align-items:center;">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
