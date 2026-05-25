@extends('layouts.app')
@section('title', 'My Resources')

@section('content')
<div class="section" style="padding-top:1rem;">
    <div class="section-header">
        <div>
            <div class="section-title">My Resources</div>
            <div class="section-sub">Manage your listings</div>
        </div>
        <a href="{{ route('resources.create') }}" class="btn-primary btn-sm" style="text-decoration:none; display:inline-flex; align-items:center; gap:4px;">
            <i class="ti ti-plus"></i> Post New
        </a>
    </div>

    @if($resources->count())
        <div style="background:var(--cs-card); border:1px solid var(--cs-border); border-radius:14px; overflow:hidden;">
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:1px solid var(--cs-border);">
                        <th style="text-align:left; padding:14px 16px; font-size:0.75rem; color:var(--cs-muted); font-weight:500; text-transform:uppercase; letter-spacing:0.05em;">Title</th>
                        <th style="text-align:left; padding:14px 16px; font-size:0.75rem; color:var(--cs-muted); font-weight:500; text-transform:uppercase; letter-spacing:0.05em;">Category</th>
                        <th style="text-align:left; padding:14px 16px; font-size:0.75rem; color:var(--cs-muted); font-weight:500; text-transform:uppercase; letter-spacing:0.05em;">Type</th>
                        <th style="text-align:left; padding:14px 16px; font-size:0.75rem; color:var(--cs-muted); font-weight:500; text-transform:uppercase; letter-spacing:0.05em;">Status</th>
                        <th style="text-align:left; padding:14px 16px; font-size:0.75rem; color:var(--cs-muted); font-weight:500; text-transform:uppercase; letter-spacing:0.05em;">Posted</th>
                        <th style="text-align:right; padding:14px 16px; font-size:0.75rem; color:var(--cs-muted); font-weight:500; text-transform:uppercase; letter-spacing:0.05em;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($resources as $resource)
                        <tr style="border-bottom:1px solid var(--cs-border); transition:background .15s;" onmouseover="this.style.background='var(--cs-card2)'" onmouseout="this.style.background='transparent'">
                            <td style="padding:12px 16px;">
                                <a href="{{ route('resources.show', $resource) }}" style="color:var(--cs-text); text-decoration:none; font-weight:500; font-size:0.875rem;">
                                    {{ Str::limit($resource->title, 45) }}
                                </a>
                            </td>
                            <td style="padding:12px 16px; font-size:0.8rem; color:var(--cs-muted);">
                                <span style="display:inline-flex; align-items:center; gap:4px;">
                                    <i class="ti ti-tag"></i> {{ $resource->category->name ?? 'N/A' }}
                                </span>
                            </td>
                            <td style="padding:12px 16px;">
                                <span class="card-badge badge-{{ $resource->type === 'share' ? 'tool' : 'knowledge' }}" style="position:static;">
                                    {{ $resource->type === 'share' ? 'Offering' : 'Requesting' }}
                                </span>
                            </td>
                            <td style="padding:12px 16px;">
                                <span style="padding:4px 10px; border-radius:100px; font-size:0.7rem; font-weight:500;
                                    background:{{ $resource->status === 'active' ? 'rgba(0,217,166,0.12)' : ($resource->status === 'paused' ? 'rgba(255,179,71,0.12)' : 'rgba(255,107,107,0.12)') }};
                                    color:{{ $resource->status === 'active' ? 'var(--cs-accent3)' : ($resource->status === 'paused' ? 'var(--cs-amber)' : 'var(--cs-accent2)') }};">
                                    {{ ucfirst($resource->status) }}
                                </span>
                            </td>
                            <td style="padding:12px 16px; font-size:0.8rem; color:var(--cs-muted);">
                                {{ $resource->created_at->format('M d, Y') }}
                            </td>
                            <td style="padding:12px 16px; text-align:right;">
                                <div style="display:inline-flex; gap:6px;">
                                    <a href="{{ route('resources.show', $resource) }}" class="btn-ghost" style="padding:5px 10px; font-size:0.75rem; text-decoration:none;">
                                        <i class="ti ti-eye"></i>
                                    </a>
                                    <a href="{{ route('resources.edit', $resource) }}" class="btn-ghost" style="padding:5px 10px; font-size:0.75rem; text-decoration:none;">
                                        <i class="ti ti-pencil"></i>
                                    </a>
                                    <form method="POST" action="{{ route('resources.destroy', $resource) }}" onsubmit="return confirm('Delete this resource?')" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="background:rgba(255,107,107,0.1); border:1px solid rgba(255,107,107,0.25); color:var(--cs-accent2); padding:5px 10px; border-radius:8px; font-size:0.75rem; cursor:pointer; transition:all .2s;">
                                            <i class="ti ti-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top:2rem; display:flex; justify-content:center;">
            {{ $resources->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="empty-state">
            <i class="ti ti-folder" aria-hidden="true"></i>
            <h5 style="color:var(--cs-text); margin-bottom:8px; font-size:1.1rem;">No resources yet</h5>
            <p>You haven't posted any resources. Get started by sharing something with your community.</p>
            <a href="{{ route('resources.create') }}" class="btn-primary" style="display:inline-flex; align-items:center; gap:6px; margin-top:1rem; text-decoration:none;">
                <i class="ti ti-plus"></i> Post Resource
            </a>
        </div>
    @endif
</div>
@endsection
