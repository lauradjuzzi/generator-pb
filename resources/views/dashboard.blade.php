
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Generator PB</title>
    <style>
        :root {
            --teal: #286963;
            --eucalyptus: #78A69A;
            --pale-eucalyptus: #E3EFEB;
            --warm-beige: #F5F1E8;
            --white: #FFFFFF;
            --text: #303C3A;
            --muted: #6B7773;
            --border: #E0E6E2;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            color: var(--text);
            background: var(--warm-beige);
        }

        .layout {
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 245px;
            flex-shrink: 0;
            padding: 28px 18px;
            background: var(--teal);
            color: var(--white);
        }

        .brand {
            margin: 0 10px 5px;
            font-size: 21px;
            font-weight: bold;
        }

        .brand-subtitle {
            margin: 0 10px 32px;
            color: #D2E4DE;
            font-size: 12px;
        }

        .nav-label {
            margin: 24px 10px 10px;
            color: #C1D8D1;
            font-size: 11px;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .nav-item {
            display: block;
            padding: 12px 14px;
            margin-bottom: 5px;
            border-radius: 7px;
            color: #FFFFFF;
            text-decoration: none;
            font-size: 14px;
        }

        .nav-item.active {
            background: #3D7B72;
        }

        .nav-item:hover {
            background: #356F66;
        }

        .main {
            flex: 1;
            min-width: 0;
        }

        .topbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 20px 32px;
            background: var(--white);
            border-bottom: 1px solid var(--border);
        }

        .topbar-title {
            font-size: 14px;
            color: var(--muted);
        }

        .user-name {
            font-size: 14px;
            font-weight: bold;
        }

        .content {
            padding: 32px;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 27px;
        }

        .intro {
            margin: 0 0 28px;
            color: var(--muted);
            line-height: 1.6;
        }

        .welcome-card {
            padding: 26px;
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 12px;
        }

        .welcome-card h2 {
            margin: 0 0 10px;
            font-size: 19px;
        }

        .welcome-card p {
            margin: 0;
            color: var(--muted);
            line-height: 1.7;
        }

        .notice {
            margin-top: 20px;
            padding: 16px;
            background: var(--pale-eucalyptus);
            border-radius: 8px;
            font-size: 14px;
            line-height: 1.6;
        }

        .logout-button {
            padding: 9px 14px;
            border: 1px solid var(--border);
            border-radius: 7px;
            background: var(--white);
            color: var(--teal);
            cursor: pointer;
        }

        .logout-button:hover {
            background: var(--pale-eucalyptus);
        }

        @media (max-width: 700px) {
            .layout {
                flex-direction: column;
            }

            .sidebar {
                width: 100%;
            }

            .content {
                padding: 22px 16px;
            }

            .topbar {
                padding: 16px;
            }
        }
    </style>
</head>
<body>
    <div class="layout">
        <aside class="sidebar">
            <div class="brand">Generator PB</div>
            <p class="brand-subtitle">E-Channel Dashboard</p>

            <div class="nav-label">MENU UTAMA</div>
            <a href="{{ route('dashboard') }}" class="nav-item active">
                Dashboard
            </a>

            <div class="nav-label">DOKUMEN PB</div>
            <a href="#" class="nav-item">Top Up QRIS</a>
            <a href="#" class="nav-item">Top Up GoPay</a>
            <a href="#" class="nav-item">Top Up DANA</a>
            <a href="#" class="nav-item">Riwayat PB</a>

            @if (auth()->user()->role === 'admin')
                <div class="nav-label">ADMINISTRASI</div>
                <a href="{{ route('admin.users.index') }}" class="nav-item">Kelola User</a>
                <a href="#" class="nav-item">Kelola Jenis Top Up</a>
                <a href="#" class="nav-item">Kelola Pimpinan</a>
            @endif
        </aside>

        <main class="main">
            <header class="topbar">
                <div class="topbar-title">Sistem Generator Pemindah Pembukuan</div>

                <div>
                    <span class="user-name">
                        {{ auth()->user()->name }}
                    </span>

                    <form action="{{ route('logout') }}"
                          method="POST"
                          style="display: inline; margin-left: 12px;">
                        @csrf
                        <button type="submit" class="logout-button">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <section class="content">
                <h1>Dashboard</h1>
                <p class="intro">
                    Selamat datang di Generator PB. Kelola dokumen
                    Pemindah Pembukuan dengan lebih mudah dan terstruktur.
                </p>

                <div class="welcome-card">
                    <h2>Selamat datang, {{ auth()->user()->name }}!</h2>
                    <p>
                        Generator PB membantu staf E-Channel menyiapkan
                        dokumen Pemindah Pembukuan untuk kebutuhan top up
                        melalui formulir digital dan file Excel.
                    </p>

                    <div class="notice">
                        <strong>Informasi:</strong>
                        Sistem ini hanya digunakan untuk membuat dokumen PB.
                        Sistem tidak menjalankan transaksi top up dan tidak
                        mengakses saldo rekening.
                    </div>
                </div>
            </section>
        </main>
    </div>
</body>
</html>
