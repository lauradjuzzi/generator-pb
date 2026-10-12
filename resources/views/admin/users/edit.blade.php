<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Akun | Generator PB</title>
    <style>
        :root {
            --teal: #286963;
            --teal-dark: #204F4B;
            --beige: #F5F1E8;
            --white: #FFFFFF;
            --text: #303C3A;
            --muted: #6B7773;
            --border: #DCE4E0;
            --danger: #A63D40;
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            padding: 36px 20px;
            background: var(--beige);
            color: var(--text);
            font-family: "Segoe UI", Arial, sans-serif;
            font-size: 14px;
        }

        .card {
            width: 100%;
            max-width: 580px;
            margin: 0 auto;
            padding: 28px;
            border: 1px solid var(--border);
            border-radius: 14px;
            background: var(--white);
            box-shadow: 0 5px 18px rgba(32, 79, 75, 0.05);
        }

        .eyebrow {
            margin-bottom: 8px;
            color: var(--teal);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 1.5px;
        }

        h1 { margin: 0; font-size: 26px; }

        .subtitle {
            margin: 9px 0 24px;
            color: var(--muted);
            line-height: 1.6;
        }

        .field { margin-bottom: 18px; }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: 600;
        }

        input, select {
            width: 100%;
            min-height: 42px;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            background: var(--white);
            color: var(--text);
            font: inherit;
        }

        input:focus, select:focus {
            outline: 2px solid #B8D9CA;
            border-color: var(--teal);
        }

        .hint {
            margin-top: 6px;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        .alert {
            margin-bottom: 18px;
            padding: 13px 16px;
            border-radius: 8px;
            background: #FFF1F0;
            color: var(--danger);
            line-height: 1.6;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 24px;
        }

        .button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 42px;
            padding: 10px 16px;
            border: 1px solid transparent;
            border-radius: 8px;
            font: inherit;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .primary {
            background: var(--teal);
            color: var(--white);
        }

        .primary:hover { background: var(--teal-dark); }

        .secondary {
            border-color: var(--border);
            background: var(--white);
            color: var(--text);
        }

        @media (max-width: 480px) {
            .card { padding: 20px; }
            .actions { flex-direction: column; }
            .button { width: 100%; }
        }
    </style>
</head>
<body>
    <main class="card">
        <div class="eyebrow">SISTEM INTERNAL</div>
        <h1>Edit Akun</h1>
        <p class="subtitle">
            Perbarui informasi akun pengguna Generator PB.
        </p>

        @if ($errors->any())
            <div class="alert">
                <strong>Periksa kembali data berikut:</strong>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="field">
                <label for="name">Nama Lengkap</label>
                <input id="name" name="name" type="text"
                    value="{{ old('name', $user->name) }}" required>
            </div>

            <div class="field">
                <label for="username">Username</label>
                <input id="username" name="username" type="text"
                    value="{{ old('username', $user->username) }}"
                    pattern="[A-Za-z0-9_-]+" required>
                <div class="hint">Username harus unik.</div>
            </div>

            <div class="field">
                <label for="email">Email (opsional)</label>
                <input id="email" name="email" type="email"
                    value="{{ old('email', $user->email) }}">
            </div>

            <div class="field">
                <label for="role">Role Pengguna</label>
                <select id="role" name="role" required>
                    <option value="staff"
                        {{ old('role', $user->role) === 'staff' ? 'selected' : '' }}>
                        Staf
                    </option>
                    <option value="admin"
                        {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>
                </select>
                @if ($user->id === auth()->id())
                    <div class="hint">
                        Role akun yang sedang digunakan tidak dapat diubah.
                    </div>
                @endif
            </div>

            <div class="hint">
                Password tidak berubah saat data akun diedit.
            </div>

            <div class="actions">
                <button type="submit" class="button primary">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.users.index') }}"
                    class="button secondary">
                    Batal
                </a>
            </div>
        </form>
    </main>
</body>
</html>
