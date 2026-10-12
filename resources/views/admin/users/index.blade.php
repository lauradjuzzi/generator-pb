
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola User | Generator PB</title>

    <style>
        :root {
            --teal: #286963;
            --teal-dark: #204F4B;
            --eucalyptus: #78A69A;
            --pale-green: #E3EFEB;
            --beige: #F5F1E8;
            --white: #FFFFFF;
            --text: #303C3A;
            --muted: #6B7773;
            --border: #DCE4E0;
            --danger: #A63D40;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            padding: 36px 24px;
            background: var(--beige);
            color: var(--text);
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 14px;
        }

        .page {
            width: 100%;
            max-width: 1120px;
            margin: 0 auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 28px;
        }

        .eyebrow {
            margin-bottom: 8px;
            color: var(--teal);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
        }

        h1 {
            margin: 0;
            font-size: 28px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .subtitle {
            margin: 9px 0 0;
            color: var(--muted);
            line-height: 1.6;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 10px 16px;
            border: 1px solid var(--border);
            border-radius: 9px;
            background: var(--white);
            color: var(--teal-dark);
            text-decoration: none;
            font-weight: 600;
            white-space: nowrap;
        }

        .back-link:hover {
            background: var(--pale-green);
        }

        .layout {
            display: grid;
            grid-template-columns: 340px minmax(0, 1fr);
            gap: 22px;
            align-items: start;
        }

        .card {
            overflow: hidden;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: var(--white);
            box-shadow: 0 5px 18px rgba(32, 79, 75, 0.04);
        }

        .card-header {
            padding: 20px 22px;
            border-bottom: 1px solid var(--border);
        }

        .card-header h2 {
            margin: 0;
            font-size: 17px;
        }

        .card-header p {
            margin: 7px 0 0;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .card-body {
            padding: 22px;
        }

        .field {
            margin-bottom: 17px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-size: 12px;
            font-weight: 650;
        }

        .optional {
            color: var(--muted);
            font-weight: 400;
        }

        input,
        select {
            display: block;
            width: 100%;
            min-height: 42px;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            outline: none;
            background: var(--white);
            color: var(--text);
            font: inherit;
            transition: border-color 0.2s, box-shadow 0.2s;
        }

        input:focus,
        select:focus {
            border-color: var(--eucalyptus);
            box-shadow: 0 0 0 3px rgba(120, 166, 154, 0.18);
        }

        .hint {
            margin-top: 6px;
            color: var(--muted);
            font-size: 11px;
        }

        .btn-primary {
            width: 100%;
            min-height: 43px;
            margin-top: 3px;
            padding: 11px 16px;
            border: none;
            border-radius: 8px;
            background: var(--teal);
            color: var(--white);
            font: inherit;
            font-weight: 650;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-primary:hover {
            background: var(--teal-dark);
        }

        .alert {
            margin-bottom: 20px;
            padding: 13px 16px;
            border: 1px solid;
            border-radius: 9px;
            line-height: 1.6;
        }

        .alert-success {
            border-color: #B8D9CA;
            background: var(--pale-green);
            color: var(--teal-dark);
        }

        .alert-danger {
            border-color: #E8C4C4;
            background: #FFF1F0;
            color: var(--danger);
        }

        .alert ul {
            margin: 0;
            padding-left: 20px;
        }

        .table-summary {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 18px;
        }

        .count {
            padding: 6px 10px;
            border-radius: 7px;
            background: var(--pale-green);
            color: var(--teal-dark);
            font-size: 12px;
            font-weight: 700;
        }

        .table-wrap {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            text-align: left;
            white-space: nowrap;
        }

        thead {
            background: var(--teal);
            color: var(--white);
        }

        th {
            padding: 13px 15px;
            font-size: 11px;
            font-weight: 650;
            letter-spacing: 0.3px;
        }

        td {
            padding: 14px 15px;
            border-bottom: 1px solid #EDF0EE;
            font-size: 12px;
        }

        tbody tr:last-child td {
            border-bottom: none;
        }

        tbody tr:hover {
            background: #F7FAF8;
        }

        .user-name {
            font-weight: 650;
        }

        .role {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .role-admin {
            background: #F5E8C9;
            color: #795B19;
        }

        .role-staff {
            background: var(--pale-green);
            color: var(--teal-dark);
        }

        .empty {
            padding: 32px 16px;
            color: var(--muted);
            text-align: center;
        }

        .page-footer {
            margin-top: 25px;
            color: var(--muted);
            font-size: 11px;
            text-align: center;
        }

        @media (max-width: 900px) {
            .layout {
                grid-template-columns: 1fr;
            }

            .card-form {
                max-width: none;
            }
        }

        @media (max-width: 560px) {
            body {
                padding: 24px 14px;
            }

            .page-header {
                align-items: flex-start;
                flex-direction: column;
            }

            h1 {
                font-size: 24px;
            }

            .card-header,
            .card-body {
                padding: 17px;
            }
        }
         
        .action-buttons {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .icon-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 34px;
            height: 34px;
            padding: 0;
            border: 1px solid var(--border);
            border-radius: 7px;
            background: var(--white);
            cursor: pointer;
            text-decoration: none;
            transition: background 0.2s;
        }

        .edit-button {
            color: var(--teal);
        }

        .edit-button:hover {
            background: var(--pale-green);
        }

        .delete-button {
            color: var(--danger);
            background: #FFF1F0;
        }

        .delete-button:hover {
            background: #FBE0DE;
        }

        .icon-button svg {
            width: 17px;
            height: 17px;
        }

    </style>
</head>
<body>
    <main class="page">
        <header class="page-header">
            <div>
                <div class="eyebrow">SISTEM INTERNAL</div>
                <h1>Kelola User</h1>
                <p class="subtitle">
                    Pengelolaan akun pengguna Generator Pemindah Pembukuan.
                </p>
            </div>

            <a href="{{ route('dashboard') }}" class="back-link">
                Kembali ke Dashboard
            </a>
        </header>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <strong>Periksa kembali data berikut:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="layout">
            <section class="card card-form">
                <div class="card-header">
                    <h2>Tambah Akun</h2>
                    <p>Isi informasi pengguna untuk membuat akun baru.</p>
                </div>

                <div class="card-body">
                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <div class="field">
                            <label for="name">Nama Lengkap</label>
                            <input id="name" name="name" type="text"
                                value="{{ old('name') }}"
                                placeholder="Masukkan nama lengkap" required>
                        </div>

                        <div class="field">
                            <label for="username">Username</label>
                            <input id="username" name="username" type="text"
                                value="{{ old('username') }}"
                                placeholder="Masukkan username"
                                pattern="[A-Za-z0-9_-]+"
                                title="Gunakan huruf, angka, tanda hubung, atau garis bawah."
                                required>
                            <div class="hint">Username harus unik.</div>
                        </div>

                        <div class="field">
                            <label for="email">
                                Email <span class="optional">(opsional)</span>
                            </label>
                            <input id="email" name="email" type="email"
                                value="{{ old('email') }}"
                                placeholder="nama@contoh.com">
                        </div>

                        <div class="field">
                            <label for="password">Password Awal</label>
                            <input id="password" name="password" type="password"
                                minlength="8" placeholder="Minimal 8 karakter"
                                required>
                        </div>

                        <div class="field">
                            <label for="role">Role Pengguna</label>
                            <select id="role" name="role" required>
                                <option value="staff"
                                    {{ old('role', 'staff') === 'staff' ? 'selected' : '' }}>
                                    Staf
                                </option>
                                <option value="admin"
                                    {{ old('role') === 'admin' ? 'selected' : '' }}>
                                    Admin
                                </option>
                            </select>
                        </div>

                        <button type="submit" class="btn-primary">
                            Tambah Akun
                        </button>
                    </form>
                </div>
            </section>

            <section class="card">
                <div class="card-header">
                    <h2>Daftar Akun</h2>
                    <p>Akun yang terdaftar pada sistem Generator PB.</p>
                </div>

                <div class="card-body">
                    <div class="table-summary">
                        <strong>Pengguna Terdaftar</strong>
                        <span class="count">{{ $users->count() }} akun</span>
                    </div>

                    <div class="table-wrap">
                        <table>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($users as $user)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="user-name">{{ $user->name }}</td>
                                        <td>{{ $user->username }}</td>
                                        <td>{{ $user->email ?: '-' }}</td>
                                        <td>
                                            <span class="role {{ $user->role === 'admin' ? 'role-admin' : 'role-staff' }}">
                                                {{ $user->role === 'admin' ? 'Admin' : 'Staf' }}
                                            </span>
                                        </td>
                                        
                                        
<td>
    <div class="action-buttons">
        <a href="{{ route('admin.users.edit', $user) }}"
           class="icon-button edit-button"
           title="Edit akun"
           aria-label="Edit akun {{ $user->username }}">
            <svg xmlns="http://www.w3.org/2000/svg"
                 viewBox="0 0 24 24"
                 fill="none"
                 stroke="currentColor"
                 stroke-width="2"
                 stroke-linecap="round"
                 stroke-linejoin="round">
                <path d="M12 20h9"/>
                <path d="M16.5 3.5a2.12 2.12 0 0 1 3 3L8 18l-4 1 1-4Z"/>
            </svg>
        </a>

        @if ($user->id !== auth()->id())
            <form action="{{ route('admin.users.destroy', $user) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin ingin menghapus akun {{ $user->username }}?');">
                @csrf
                @method('DELETE')

                <button type="submit"
                        class="icon-button delete-button"
                        title="Hapus akun"
                        aria-label="Hapus akun {{ $user->username }}">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24"
                         fill="none"
                         stroke="currentColor"
                         stroke-width="2"
                         stroke-linecap="round"
                         stroke-linejoin="round">
                        <path d="M3 6h18"/>
                        <path d="M8 6V4h8v2"/>
                        <path d="m19 6-1 14H6L5 6"/>
                        <path d="M10 11v5M14 11v5"/>
                    </svg>
                </button>
            </form>
        @endif
    </div>
</td>


                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="empty">
                                            Belum ada akun terdaftar.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>

        <footer class="page-footer">
            Generator PB &middot; Divisi E-Channel &middot; Bank Riau Kepri Syariah
        </footer>
    </main>
</body>
</html>
