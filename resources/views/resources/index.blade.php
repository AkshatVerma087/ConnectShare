@extends('layouts.app')

@section('title', 'Browse Resources')
@section('meta_description', 'Browse tools, skills, services, and digital resources shared by our community.')

@section('content')
  <div class="hero">
    <div class="hero-badge"><i class="ti ti-bolt" aria-hidden="true"></i> Community-powered sharing</div>
    <h1>Share more,<br><em>need less.</em></h1>
    <p>Access tools, skills, and knowledge from your community. Build together, waste nothing.</p>
    <div class="hero-actions">
      @auth
      <a class="btn-primary btn-lg" href="{{ route('resources.create') }}">Post a Resource</a>
      @else
      <a class="btn-primary btn-lg" href="{{ route('login') }}">Join the Community</a>
      @endauth
      <a class="btn-ghost btn-lg" href="#explore">Explore Community</a>
    </div>
    <div class="hero-stats">
      <div class="stat"><div class="stat-num">{{ \App\Models\Resource::count() ?? 2847 }}</div><div class="stat-label">Resources shared</div></div>
      <div class="stat"><div class="stat-num">{{ \App\Models\User::count() ?? 1204 }}</div><div class="stat-label">Active members</div></div>
      <div class="stat"><div class="stat-num">438</div><div class="stat-label">Collaborations</div></div>
      <div class="stat"><div class="stat-num">4.9★</div><div class="stat-label">Avg. trust score</div></div>
    </div>
  </div>

  <div class="section" id="explore">
    <form method="GET" action="{{ route('resources.index') }}" class="filter-bar">
      <div class="search-wrap">
        <i class="ti ti-search" aria-hidden="true"></i>
        <input name="search" value="{{ request('search') }}" class="search-input" placeholder="Search tools, skills, services...">
      </div>
      <select name="type" class="filter-select" onchange="this.form.submit()">
        <option value="">All Types</option>
        <option value="share" {{ request('type') === 'share' ? 'selected' : '' }}>Offering</option>
        <option value="request" {{ request('type') === 'request' ? 'selected' : '' }}>Requesting</option>
      </select>
      <select name="category" class="filter-select" onchange="this.form.submit()">
        <option value="">All Categories</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
        @endforeach
      </select>
      <div class="filter-tags">
        <button type="submit" class="tag active" style="background:var(--cs-accent);color:#fff;border:none;">Search</button>
        <a href="{{ route('resources.index') }}" class="tag">Clear Filters</a>
      </div>
    </form>

    <div class="section-header">
      <div>
        <div class="section-title">Browse Resources</div>
        <div class="section-sub">Discover what your community has to offer</div>
      </div>
      <button class="btn-ghost btn-sm">View map <i class="ti ti-map-2" aria-hidden="true"></i></button>
    </div>

    @if($resources->count())
        <div class="resource-grid" id="resourceGrid">
            @foreach($resources as $resource)
                @include('components.resource-card', ['resource' => $resource])
            @endforeach
        </div>

        <div style="margin-top:2rem;">
            {{ $resources->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="empty-state">
            <i class="ti ti-box" aria-hidden="true"></i>
            <h5 style="color:var(--cs-text);margin-bottom:8px;font-size:1.1rem;">No resources found</h5>
            <p>Try adjusting your filters or be the first to post a resource.</p>
            @auth
                <a href="{{ route('resources.create') }}" class="btn-primary mt-2" style="display:inline-block;margin-top:1rem;">
                    <i class="ti ti-plus me-1"></i> Post Resource
                </a>
            @endauth
        </div>
    @endif
  </div>
@endsection
