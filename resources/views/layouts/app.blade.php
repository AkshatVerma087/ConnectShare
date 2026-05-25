<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ConnectShare — @yield('title', 'Share Resources')</title>
    <meta name="description" content="@yield('meta_description', 'A resource-sharing platform where users can list tools, skills, and services.')">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;1,9..40,300&family=Playfair+Display:wght@500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@tabler/icons-webfont@latest/dist/tabler-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/theme.css') }}">
    @vite(['resources/js/app.js'])
    
    @stack('styles')
</head>
<body>
    <nav>
      <div class="nav-logo">
        <div class="nav-logo-icon"><i class="ti ti-share-3" aria-hidden="true"></i></div>
        <a href="{{ route('resources.index') }}" style="color:var(--cs-text);text-decoration:none;">ConnectShare</a>
      </div>
      <div class="nav-links">
        @auth
          <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
          <a href="{{ route('resources.my') }}" class="{{ request()->routeIs('resources.my') ? 'active' : '' }}">My Listings</a>
        @endauth
      </div>
      <div class="nav-actions">
        @guest
            <a class="btn-ghost btn-sm" href="{{ route('login') }}">Log in</a>
            <a class="btn-primary btn-sm" href="{{ route('register') }}">Register</a>
        @endguest
        @auth
            <a class="btn-ghost btn-sm" href="{{ route('profile.edit') }}">Profile</a>
            <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                @csrf
                <button type="submit" class="btn-ghost btn-sm" style="cursor:pointer;">Log out</button>
            </form>
        @endauth
      </div>
    </nav>

    <!-- Flash Messages -->
    <div class="container" style="padding-top: 1rem;">
        @if(session('success'))
            <div style="background:rgba(0,217,166,0.1);border:1px solid rgba(0,217,166,0.3);color:var(--cs-accent3);padding:12px;border-radius:8px;margin-bottom:1rem;display:flex;align-items:center;gap:8px;font-size:0.875rem;">
                <i class="ti ti-check"></i> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div style="background:rgba(255,107,107,0.1);border:1px solid rgba(255,107,107,0.3);color:var(--cs-accent2);padding:12px;border-radius:8px;margin-bottom:1rem;display:flex;align-items:center;gap:8px;font-size:0.875rem;">
                <i class="ti ti-alert-triangle"></i> {{ session('error') }}
            </div>
        @endif
    </div>

    <!-- Main Content -->
    <div id="view-browse" class="view active">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
