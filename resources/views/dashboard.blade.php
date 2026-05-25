@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="section" style="padding-top:0;">
    <div class="section-header">
      <div>
        <div class="section-title">Your Dashboard</div>
        <div class="section-sub">Welcome back, {{ Auth::user()->name }} — here's what's happening</div>
      </div>
      <a href="{{ route('resources.create') }}" class="btn-primary btn-sm" style="text-decoration:none;">+ Add Listing</a>
    </div>

    <div class="dash-grid">
      <div class="dash-card">
        <div class="dash-card-label"><i class="ti ti-layers-intersect" aria-hidden="true"></i> Active listings</div>
        <div class="dash-card-val">{{ $activeListings ?? 0 }}</div>
        <div class="dash-card-change change-up">Live and visible resources</div>
      </div>
      <div class="dash-card">
        <div class="dash-card-label"><i class="ti ti-clock" aria-hidden="true"></i> Paused listings</div>
        <div class="dash-card-val">{{ $pausedListings ?? 0 }}</div>
        <div class="dash-card-change change-dn">Temporarily hidden</div>
      </div>
      <div class="dash-card">
        <div class="dash-card-label"><i class="ti ti-tag" aria-hidden="true"></i> Categories used</div>
        <div class="dash-card-val">{{ $categoriesUsed ?? 0 }}</div>
        <div class="dash-card-change change-up">Across your listings</div>
      </div>
      <div class="dash-card">
        <div class="dash-card-label"><i class="ti ti-refresh" aria-hidden="true"></i> Last updated</div>
        <div class="dash-card-val" style="font-size:1.2rem; line-height:1.25;">{{ ($lastUpdatedAt ?? null) ? $lastUpdatedAt->diffForHumans() : '—' }}</div>
        <div class="dash-card-change change-up">Most recent listing change</div>
      </div>
    </div>

    <div class="dash-two">
      <div class="arch-card">
        <h3 style="font-size:0.875rem;text-transform:none;letter-spacing:0;color:var(--cs-text);font-weight:500;margin-bottom:1rem">Recent Updates</h3>
        <div class="activity-list">
            @forelse($recentResources ?? [] as $resource)
                <div class="activity-item">
                    <div class="activity-icon ai-purple">
                        <i class="ti ti-briefcase"></i>
                    </div>
                    <div class="activity-text">
                        <strong>{{ $resource->title }}</strong>
                        <p>{{ $resource->category->name ?? 'Uncategorized' }} · {{ ucfirst($resource->status) }}</p>
                    </div>
                    <div class="activity-time">{{ $resource->updated_at->diffForHumans() }}</div>
                </div>
            @empty
                <div class="empty-state" style="padding: 2rem;">
                    <i class="ti ti-bell-z" style="font-size: 2rem;"></i>
                    <p>No recent activity.</p>
                    <a href="{{ route('resources.create') }}" class="btn-primary btn-sm" style="display:inline-flex; margin-top:1rem; text-decoration:none;">Create your first listing</a>
                </div>
            @endforelse
        </div>
      </div>
      <div>
        <div class="arch-card" style="margin-bottom:1rem">
          <h3 style="font-size:0.875rem;text-transform:none;letter-spacing:0;color:var(--cs-text);font-weight:500;margin-bottom:1rem">Latest Listing</h3>
          <div class="bookings-list">
            @if(($recentResources ?? collect())->first())
                @php($latest = $recentResources->first())
                <div class="booking-item">
                    <div class="booking-head">
                        <div class="booking-title">{{ $latest->title }}</div>
                        <span class="booking-status status-{{ $latest->status === 'active' ? 'active' : ($latest->status === 'paused' ? 'pending' : 'done') }}">{{ ucfirst($latest->status) }}</span>
                    </div>
                    <div class="booking-meta">
                        <span>{{ $latest->category->name ?? 'Uncategorized' }}</span>
                        <span>•</span>
                        <span>{{ $latest->updated_at->diffForHumans() }}</span>
                    </div>
                    <div style="margin-top:12px; display:flex; gap:8px; flex-wrap:wrap;">
                        <a href="{{ route('resources.show', $latest) }}" class="btn-ghost btn-sm" style="text-decoration:none;">View</a>
                        <a href="{{ route('resources.edit', $latest) }}" class="btn-primary btn-sm" style="text-decoration:none;">Edit</a>
                    </div>
                </div>
            @else
                <div class="empty-state" style="padding: 1rem;">
                    <p>No listings yet.</p>
                </div>
            @endif
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
