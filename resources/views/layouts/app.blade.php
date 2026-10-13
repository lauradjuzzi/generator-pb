<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Generator PB') - BRK Syariah</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('styles')

    <style>
        body {
            min-height: 100vh;
        }

        .app-layout {
            display: flex;
            min-height: 100vh;
        }

        .app-sidebar {
            position: relative;
            width: 255px;
            flex-shrink: 0;
            padding: 30px 18px;
            color: #fff;
            background: linear-gradient(165deg, #286963, #204F4B);
        }

        .app-brand {
            margin: 0 10px 6px;
            color: #fff;
            font-size: 22px;
            font-weight: 750;
        }

        .app-brand-subtitle {
            margin: 0 10px 32px;
            color: #D2E4DE;
            font-size: 12px;
        }

        .app-nav-label {
            margin: 25px 10px 10px;
            color: #C1D8D1;
            font-size: 10px;
            font-weight: 750;
            letter-spacing: 1.2px;
            text-transform: uppercase;
        }

        .app-nav-item {
            display: block;
            margin-bottom: 6px;
            padding: 12px 14px;
            border: 1px solid transparent;
            border-radius: 9px;
            color: #F7FBF9;
            font-size: 13px;
            text-decoration: none;
            transition: 180ms ease;
        }

        .app-nav-item:hover {
            padding-left: 18px;
            color: #fff;
            background: rgba(255, 255, 255, .11);
        }

        .app-nav-item.active {
            color: #204F4B;
            background: #fff;
            font-weight: 700;
            box-shadow: 0 4px 12px rgba(0, 0, 0, .09);
        }

        .app-main {
            flex: 1;
            min-width: 0;
        }

        .app-topbar {
            position: sticky;
            top: 0;
            z-index: 5;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 19px 30px;
            background: rgba(255, 255, 255, .96);
            border-bottom: 1px solid #DCE4E0;
        }

        .app-topbar-label {
            color: #6B7773;
            font-size: 13px;
        }

        .app-user-area {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .app-user-name {
            color: #303C3A;
            font-size: 13px;
            font-weight: 700;
        }

        .app-logout-button {
            padding: 9px 14px;
            border: 1px solid #DCE4E0;
            border-radius: 9px;
            color: #286963;
            background: #fff;
            font-weight: 650;
            cursor: pointer;
            transition: 180ms ease;
        }

        .app-logout-button:hover {
            color: #fff;
            background: #286963;
        }

        .app-content {
            max-width: 1440px;
            padding: 32px;
            margin: 0 auto;
        }

        @media (max-width: 800px) {
            .app-layout {
                flex-direction: column;
            }

            .app-sidebar {
                width: 100%;
                padding: 20px 16px;
            }

            .app-brand-subtitle {
                margin-bottom: 18px;
            }

            .app-nav-label {
                margin-top: 16px;
            }

            .app-topbar {
                position: static;
                padding: 16px;
            }

            .app-content {
                padding: 22px 16px;
            }

            .app-user-area {
                gap: 8px;
            }
        }
    </style>
</head>

<body>
    <div class="app-layout">
        <aside class="app-sidebar">
            <div class="app-brand">Generator PB</div>
            <p class="app-brand-subtitle">BRK Syariah · E-Channel</p>

            <div class="app-nav-label">Menu Utama</div>

            <a href="{{ route('dashboard') }}"
                class="app-nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                Dashboard
            </a>

            <div class="app-nav-label">Transaksi PB</div>

            @foreach (\App\Models\TopupType::where('is_active', true)->orderBy('name')->get() as $topupType)
                <a href="{{ route('topup.show', $topupType->slug) }}"
                    class="app-nav-item {{ request()->routeIs('topup.show') && request()->route('topupType')?->slug === $topupType->slug ? 'active' : '' }}">
                    Top Up {{ $topupType->name }}
                </a>
            @endforeach

            <a href="#" class="app-nav-item {{ request()->routeIs('history.*') ? 'active' : '' }}">
                Riwayat PB
            </a>


            @if (auth()->user()->role === 'admin')
                <div class="app-nav-label">Administrasi</div>

                <a href="{{ route('topup-types.index') }}"
                    class="app-nav-item {{ request()->routeIs('topup-types.*') ? 'active' : '' }}">
                    Kelola Jenis Top Up
                </a>

                <a href="{{ route('admin.users.index') }}"
                    class="app-nav-item {{ request()->routeIs('admin.users.index', 'admin.users.store') ? 'active' : '' }}">
                    Kelola Pengguna
                </a>
            @endif

        </aside>

        <main class="app-main">
            <header class="app-topbar">
                <div class="app-topbar-label">
                    @yield('page-label', 'Sistem Pembuatan Dokumen PB')
                </div>

                <div class="app-user-area">
                    <span class="app-user-name">
                        {{ auth()->user()->name }}
                    </span>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="app-logout-button">
                            Keluar
                        </button>
                    </form>
                </div>
            </header>

            <section class="app-content">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                @yield('content')
            </section>
        </main>
    </div>
</body>

</html>