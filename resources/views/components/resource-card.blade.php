<a href="{{ route('resources.show', $resource) }}" class="resource-card">
  <div class="card-img card-img-tools">
    <i class="ti ti-file-description" aria-hidden="true"></i>
    <div class="card-badge badge-{{ $resource->type === 'share' ? 'tool' : 'knowledge' }}">
        {{ $resource->type === 'share' ? 'Offering' : 'Requesting' }}
    </div>
    <div class="card-fav"><i class="ti ti-bookmark" aria-hidden="true"></i></div>
  </div>
  <div class="card-body">
    <div class="card-title">{{ Str::limit($resource->title, 60) }}</div>
    <div class="card-meta">
      <div class="card-avatar">{{ strtoupper(substr($resource->user->name ?? 'A', 0, 1)) }}</div>
      <span>{{ $resource->user->name ?? 'Anonymous' }}</span>
      <div class="card-rating">4.9★</div>
    </div>
    <div style="font-size: 0.8125rem; color: var(--cs-muted); margin-bottom:10px;">
        {{ Str::limit($resource->description, 80) }}
    </div>
    <div class="card-footer">
      <div class="card-loc"><i class="ti ti-tag" aria-hidden="true"></i> {{ $resource->category->name ?? 'Uncategorized' }}</div>
      <div class="availability">
        <div class="avail-dot {{ $resource->type === 'share' ? 'avail-yes' : 'avail-no' }}"></div>
        {{ $resource->type === 'share' ? 'Available' : 'Needed' }}
      </div>
    </div>
  </div>
</a>
