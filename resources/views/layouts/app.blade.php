<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @stack('styles')
</head>

<body class="brk-app-body">

    <div class="app-layout">

        <aside class="app-sidebar">

            <div class="app-sidebar-decoration app-sidebar-decoration-one"></div>
            <div class="app-sidebar-decoration app-sidebar-decoration-two"></div>

            <div class="app-brand-wrap">
                <div class="app-brand-mark">
                    <span>BRK</span>
                </div>

                <div>
                    <div class="app-brand">Generator PB</div>
                    <p class="app-brand-subtitle">BRK Syariah · E-Channel</p>
                </div>
            </div>

            <div class="app-nav">

                <div class="app-nav-label">
                    <span>Workspace</span>
                </div>

                <a href="{{ route('dashboard') }}"
                    class="app-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <span class="app-nav-icon">⌂</span>
                    <span>Dashboard</span>
                </a>

                <div class="app-nav-label">
                    <span>Transaksi PB</span>
                </div>

                @foreach (\App\Models\TopupType::where('is_active', true)->orderBy('name')->get() as $topupType)
                    <a href="{{ route('topup.show', $topupType->slug) }}"
                        class="app-nav-item {{ request()->routeIs('topup.show') && request()->route('topupType')?->slug === $topupType->slug ? 'active' : '' }}">
                        <span class="app-nav-icon">＋</span>
                        <span>Top Up {{ $topupType->name }}</span>
                    </a>
                @endforeach

                <div class="app-nav-label">
                    <span>Administrasi</span>
                </div>

                <a href="{{ route('topup-types.index') }}"
                    class="app-nav-item {{ request()->routeIs('topup-types.*') ? 'active' : '' }}">
                    <span class="app-nav-icon">▦</span>
                    <span>Kelola Jenis Top Up</span>
                </a>

                <a href="{{ route('leaders.index') }}"
                    class="app-nav-item {{ request()->routeIs('leaders.*') ? 'active' : '' }}">
                    <span class="app-nav-icon">♙</span>
                    <span>Kelola Pimpinan</span>
                </a>

                @if (auth()->user()->role === 'admin')
                    <a href="{{ route('admin.users.index') }}"
                        class="app-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <span class="app-nav-icon">♙</span>
                        <span>Kelola Pengguna</span>
                    </a>
                @endif

            </div>

            <div class="app-sidebar-footer">
                <span class="app-status-dot"></span>
                <span>Sistem aktif</span>
            </div>

        </aside>

        <main class="app-main">

            <header class="app-topbar">

                <div class="app-topbar-left">
                    <div class="app-topbar-mobile-brand">
                        <span>BRK</span>
                    </div>

                    <div>
                        <div class="app-topbar-label">
                            @yield('page-label', 'Sistem Pembuatan Dokumen PB')
                        </div>

                        <div class="app-topbar-title">
                            Generator PB
                        </div>
                    </div>
                </div>

                <div class="app-user-area">

                    <div class="app-user-avatar">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div class="app-user-info">
                        <span class="app-user-name">
                            {{ auth()->user()->name }}
                        </span>

                        <span class="app-user-role">
                            {{ ucfirst(auth()->user()->role) }}
                        </span>
                    </div>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="app-logout-button">
                            <span>Keluar</span>
                        </button>
                    </form>

                </div>

            </header>

            <section class="app-content">

                @if (session('success'))
                    <div id="success-alert" class="alert alert-success brk-alert brk-alert-success">
                        <div class="brk-alert-icon">✓</div>

                        <div class="brk-alert-content">
                            <strong>Berhasil</strong>
                            <span>{{ session('success') }}</span>
                        </div>

                        <button type="button" class="brk-alert-close" onclick="this.closest('.alert').remove()"
                            aria-label="Tutup">
                            ×
                        </button>
                    </div>
                @endif

                @yield('content')

            </section>

        </main>

    </div>

    @stack('scripts')

</body>

</html>