@extends('layouts.app')

@section('title', 'Kelola Jenis Top Up')
@section('page-label', 'Administrasi Jenis Top Up')

@section('content')

    <style>
        :root {
            --teal: #286963;
            --teal-dark: #204F4B;
            --beige: #F5F1E8;
            --pale-green: #E3EFEB;
            --white: #FFFFFF;
            --text: #303C3A;
            --muted: #6B7773;
            --border: #DCE4E0;
            --red: #DC2626;
        }

        * {
            box-sizing: border-box;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            flex-wrap: wrap;
            margin-bottom: 24px;
        }

        h1 {
            margin: 0 0 8px;
            font-size: 27px;
        }

        .subtitle {
            margin: 0;
            color: var(--muted);
            font-size: 14px;
        }

        .back-link {
            color: var(--teal);
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
        }

        .card {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: 24px;
            margin-bottom: 22px;
            box-shadow: 0 4px 15px rgba(32, 79, 75, 0.04);
        }

        .card h2 {
            margin: 0 0 20px;
            font-size: 18px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .field {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .field.full {
            grid-column: 1 / -1;
        }

        label {
            font-size: 13px;
            font-weight: 600;
        }

        .required-mark {
            color: var(--red);
        }

        input,
        textarea {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid var(--border);
            border-radius: 8px;
            font-family: inherit;
            font-size: 14px;
            color: var(--text);
            background: var(--white);
        }

        textarea {
            min-height: 85px;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            outline: 2px solid rgba(40, 105, 99, 0.12);
            border-color: var(--teal);
        }

        .btn {
            border: none;
            border-radius: 8px;
            padding: 11px 16px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            text-align: center;
        }

        .btn-primary {
            color: var(--white);
            background: var(--teal);
        }

        .btn-primary:hover {
            background: var(--teal-dark);
        }

        .btn-light {
            color: var(--teal-dark);
            background: var(--pale-green);
        }

        .btn-danger {
            color: var(--red);
            background: #FEF2F2;
        }

        .form-actions {
            grid-column: 1 / -1;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .alert {
            padding: 13px 15px;
            border-radius: 9px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .alert-success {
            background: var(--pale-green);
            color: var(--teal-dark);
        }

        .alert-error {
            background: #FEF2F2;
            color: #991B1B;
        }

        .error-message {
            color: var(--red);
            font-size: 12px;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th,
        td {
            padding: 14px 12px;
            text-align: left;
            border-bottom: 1px solid var(--border);
            vertical-align: top;
        }

        th {
            background: #F8FAF9;
            color: var(--muted);
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
        }

        .type-name {
            font-weight: 700;
        }

        .description {
            color: var(--muted);
            max-width: 260px;
            white-space: normal;
            overflow-wrap: anywhere;
        }

        .status {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .status-active {
            background: var(--pale-green);
            color: var(--teal-dark);
        }

        .status-inactive {
            background: #F3F4F6;
            color: #6B7280;
        }

        .actions {
            display: flex;
            align-items: center;
            gap: 7px;
            flex-wrap: wrap;
        }

        .actions form {
            margin: 0;
        }

        .empty-state {
            padding: 30px;
            color: var(--muted);
            text-align: center;
        }

        .hint {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.5;
        }

        @media (max-width: 650px) {
            .card {
                padding: 17px;
            }

            .form-grid {
                grid-template-columns: 1fr;
            }

            .field.full,
            .form-actions {
                grid-column: auto;
            }

            h1 {
                font-size: 23px;
            }
        }
    </style>

    <div class="container">

        @if ($errors->any())
            <div class="alert alert-error">
                Ada data yang perlu diperbaiki. Periksa kembali form di bawah.
            </div>
        @endif

        <section class="card">
            <h2>Tambah Jenis Top Up</h2>

            <form action="{{ route('topup-types.store') }}" method="POST">
                @csrf

                <div class="form-grid">
                    <div class="field">
                        <label for="name">
                            Nama Jenis Top Up <span class="required-mark">*</span>
                        </label>

                        <input id="name" name="name" type="text" maxlength="100" value="{{ old('name') }}"
                            placeholder="Contoh: DANA" class="{{ $errors->has('name') ? 'is-invalid' : '' }}" required>

                        @error('name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="description">Deskripsi (opsional)</label>

                        <input id="description" name="description" type="text" value="{{ old('description') }}"
                            placeholder="Keterangan jenis top up">

                        @error('description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field full">
                        <label>Default Debet</label>
                    </div>

                    <div class="field">
                        <label for="default_debit_account_number">Nomor Rekening Debet</label>
                        <input id="default_debit_account_number" name="default_debit_account_number" type="text"
                            maxlength="16" value="{{ old('default_debit_account_number') }}"
                            placeholder="Nomor rekening debet">

                        @error('default_debit_account_number')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="default_debit_account_name">Nama Rekening Debet</label>
                        <input id="default_debit_account_name" name="default_debit_account_name" type="text" maxlength="150"
                            value="{{ old('default_debit_account_name') }}" placeholder="Nama rekening debet">

                        @error('default_debit_account_name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field full">
                        <label for="default_debit_description">Keterangan Debet</label>
                        <textarea id="default_debit_description" name="default_debit_description"
                            placeholder="Keterangan default untuk transaksi debet">{{ old('default_debit_description') }}</textarea>

                        @error('default_debit_description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field full">
                        <label>Default Kredit</label>
                    </div>

                    <div class="field">
                        <label for="default_credit_account_number">Nomor Rekening Kredit</label>
                        <input id="default_credit_account_number" name="default_credit_account_number" type="text"
                            maxlength="16" value="{{ old('default_credit_account_number') }}"
                            placeholder="Nomor rekening kredit">

                        @error('default_credit_account_number')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field">
                        <label for="default_credit_account_name">Nama Rekening Kredit</label>
                        <input id="default_credit_account_name" name="default_credit_account_name" type="text"
                            maxlength="150" value="{{ old('default_credit_account_name') }}"
                            placeholder="Nama rekening kredit">

                        @error('default_credit_account_name')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="field full">
                        <label for="default_credit_description">Keterangan Kredit</label>
                        <textarea id="default_credit_description" name="default_credit_description"
                            placeholder="Keterangan default untuk transaksi kredit">{{ old('default_credit_description') }}</textarea>

                        @error('default_credit_description')
                            <span class="error-message">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="btn btn-primary">
                            + Tambah Jenis Top Up
                        </button>
                    </div>
                </div>
            </form>
        </section>

        <section class="card">
            <h2>Daftar Jenis Top Up</h2>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Nama</th>
                            <th>Slug</th>
                            <th>Deskripsi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($topupTypes as $topupType)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                <td>
                                    <span class="type-name">
                                        {{ $topupType->name }}
                                    </span>
                                </td>

                                <td>{{ $topupType->slug }}</td>

                                <td class="description">
                                    {{ $topupType->description ?: '-' }}
                                </td>

                                <td>
                                    @if ($topupType->is_active)
                                        <span class="status status-active">Aktif</span>
                                    @else
                                        <span class="status status-inactive">Nonaktif</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="actions">
                                        <button type="button" class="btn btn-light" onclick="openEditModal(
                                                                                    {{ $topupType->id }},
                                                                                    {{ Js::from($topupType->name) }},
                                                                                    {{ Js::from($topupType->description ?? '') }},
                                                                                    {{ Js::from($topupType->default_debit_account_number ?? '') }},
                                                                                    {{ Js::from($topupType->default_debit_account_name ?? '') }},
                                                                                    {{ Js::from($topupType->default_debit_description ?? '') }},
                                                                                    {{ Js::from($topupType->default_credit_account_number ?? '') }},
                                                                                    {{ Js::from($topupType->default_credit_account_name ?? '') }},
                                                                                    {{ Js::from($topupType->default_credit_description ?? '') }}
                                                                                )">
                                            Edit
                                        </button>

                                        <form action="{{ route('topup-types.toggle-status', $topupType) }}" method="POST"
                                            onsubmit="return confirm('Yakin ingin {{ $topupType->is_active ? 'menonaktifkan' : 'mengaktifkan' }} jenis top up ini?')">
                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                class="btn {{ $topupType->is_active ? 'btn-danger' : 'btn-primary' }}">
                                                {{ $topupType->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="empty-state">
                                    Belum ada jenis top up. Tambahkan jenis pertama melalui form di atas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

    </div>

    <!-- Modal Edit -->
    <div id="editModal" style="
                            display:none;
                            position:fixed;
                            inset:0;
                            z-index:1000;
                            background:rgba(20,35,32,.45);
                            padding:20px;
                            overflow-y:auto;
                        ">
        <div style="
                                max-width:500px;
                                margin:7vh auto;
                                padding:24px;
                                border-radius:14px;
                                background:white;
                                box-shadow:0 15px 40px rgba(0,0,0,.15);
                            ">
            <h2 style="margin-top:0;font-size:19px;">Edit Jenis Top Up</h2>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="field" style="margin-bottom:17px;">
                    <label for="edit_name">
                        Nama Jenis Top Up <span class="required-mark">*</span>
                    </label>
                    <input id="edit_name" name="name" type="text" maxlength="100" required>
                </div>

                <div class="field" style="margin-bottom:17px;">
                    <label for="edit_description">Deskripsi (opsional)</label>
                    <textarea id="edit_description" name="description"></textarea>
                </div>

                <div style="margin-bottom:12px;">
                    <strong style="font-size:14px;">Default Debet</strong>
                </div>

                <div class="field" style="margin-bottom:17px;">
                    <label for="edit_default_debit_account_number">Nomor Rekening Debet</label>
                    <input id="edit_default_debit_account_number" name="default_debit_account_number" type="text"
                        maxlength="16">
                </div>

                <div class="field" style="margin-bottom:17px;">
                    <label for="edit_default_debit_account_name">Nama Rekening Debet</label>
                    <input id="edit_default_debit_account_name" name="default_debit_account_name" type="text"
                        maxlength="150">
                </div>

                <div class="field" style="margin-bottom:17px;">
                    <label for="edit_default_debit_description">Keterangan Debet</label>
                    <textarea id="edit_default_debit_description" name="default_debit_description"></textarea>
                </div>

                <div style="margin:4px 0 12px;">
                    <strong style="font-size:14px;">Default Kredit</strong>
                </div>

                <div class="field" style="margin-bottom:17px;">
                    <label for="edit_default_credit_account_number">Nomor Rekening Kredit</label>
                    <input id="edit_default_credit_account_number" name="default_credit_account_number" type="text"
                        maxlength="16">
                </div>

                <div class="field" style="margin-bottom:17px;">
                    <label for="edit_default_credit_account_name">Nama Rekening Kredit</label>
                    <input id="edit_default_credit_account_name" name="default_credit_account_name" type="text"
                        maxlength="150">
                </div>

                <div class="field" style="margin-bottom:22px;">
                    <label for="edit_default_credit_description">Keterangan Kredit</label>
                    <textarea id="edit_default_credit_description" name="default_credit_description"></textarea>
                </div>

                <div class="actions">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <button type="button" class="btn btn-light" onclick="closeEditModal()">Batal</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openEditModal(
            id,
            name,
            description,
            debitAccountNumber,
            debitAccountName,
            debitDescription,
            creditAccountNumber,
            creditAccountName,
            creditDescription
        ) {
            const modal = document.getElementById('editModal');
            const form = document.getElementById('editForm');

            form.action = `/topup-types/${id}`;

            document.getElementById('edit_name').value = name;
            document.getElementById('edit_description').value = description;

            document.getElementById('edit_default_debit_account_number').value = debitAccountNumber;
            document.getElementById('edit_default_debit_account_name').value = debitAccountName;
            document.getElementById('edit_default_debit_description').value = debitDescription;

            document.getElementById('edit_default_credit_account_number').value = creditAccountNumber;
            document.getElementById('edit_default_credit_account_name').value = creditAccountName;
            document.getElementById('edit_default_credit_description').value = creditDescription;

            modal.style.display = 'block';
            document.body.style.overflow = 'hidden';
            document.getElementById('edit_name').focus();
        }

        function closeEditModal() {
            document.getElementById('editModal').style.display = 'none';
            document.body.style.overflow = '';
        }

        document.getElementById('editModal').addEventListener('click', function (event) {
            if (event.target === this) {
                closeEditModal();
            }
        });

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeEditModal();
            }
        });
    </script>

@endsection