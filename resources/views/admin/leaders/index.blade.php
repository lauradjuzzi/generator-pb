@extends('layouts.app')

@section('title', 'Kelola Pimpinan')
@section('page-label', 'Administrasi / Kelola Pimpinan')

@push('styles')
    <style>
        .leader-page {
            color: #303C3A;
        }

        .leader-heading {
            margin-bottom: 24px;
        }

        .leader-heading h1 {
            margin: 0 0 8px;
            font-size: 26px;
            color: #204F4B;
        }

        .leader-heading p {
            margin: 0;
            color: #6B7773;
            font-size: 14px;
        }

        .leader-card {
            margin-bottom: 24px;
            padding: 24px;
            background: #fff;
            border: 1px solid #DCE4E0;
            border-radius: 14px;
        }

        .leader-card h2 {
            margin: 0 0 20px;
            color: #204F4B;
            font-size: 17px;
        }

        .leader-form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .leader-field {
            display: flex;
            flex-direction: column;
            gap: 7px;
        }

        .leader-field label {
            font-size: 13px;
            font-weight: 650;
        }

        .leader-field input,
        .leader-field select {
            width: 100%;
            padding: 11px 12px;
            border: 1px solid #DCE4E0;
            border-radius: 8px;
            color: #303C3A;
            background: #fff;
            font: inherit;
            font-size: 13px;
        }

        .leader-field input:focus,
        .leader-field select:focus {
            outline: 2px solid #E3EFEB;
            border-color: #286963;
        }

        .leader-form-actions {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end;
        }

        .leader-button {
            padding: 11px 17px;
            border: 0;
            border-radius: 8px;
            color: #fff;
            background: #286963;
            font-weight: 650;
            cursor: pointer;
        }

        .leader-button:hover {
            background: #204F4B;
        }

        .leader-table-wrap {
            overflow-x: auto;
        }

        .leader-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        .leader-table th,
        .leader-table td {
            padding: 14px 12px;
            border-bottom: 1px solid #E3EFEB;
            text-align: left;
            vertical-align: top;
        }

        .leader-table th {
            color: #6B7773;
            background: #F5F1E8;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .leader-badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 700;
        }

        .leader-badge.active {
            color: #204F4B;
            background: #E3EFEB;
        }

        .leader-badge.inactive {
            color: #6B7773;
            background: #F1F2F0;
        }

        .leader-error {
            color: #B42318;
            font-size: 12px;
        }

        .leader-empty {
            padding: 24px;
            color: #6B7773;
            text-align: center;
        }

        @media (max-width: 700px) {
            .leader-form-grid {
                grid-template-columns: 1fr;
            }

            .leader-card {
                padding: 18px;
            }
        }


        .leader-type-field {
            grid-column: 1 / -1;
        }

        .leader-signatory-group {
            min-width: 0;
            padding: 18px;
            border: 1px solid #DCE4E0;
            border-radius: 10px;
            background: #FAFCFB;
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .leader-signatory-group h3 {
            margin: 0;
            color: #286963;
            font-size: 15px;
        }

        @media (max-width: 700px) {
            .leader-type-field {
                grid-column: auto;
            }
        }
    </style>
@endpush

@section('content')
    <div class="leader-page">
        <div class="leader-heading">
            <h1>Kelola Pimpinan</h1>
            <p>Kelola nama dan jabatan yang digunakan pada dokumen PB.</p>
        </div>

        <div class="leader-card">
            <h2>Tambah Data Pimpinan</h2>

            <form action="{{ route('admin.leaders.store') }}" method="POST">
                @csrf


                <div class="leader-form-grid">
                    <div class="leader-field leader-type-field">
                        <label for="signatory_type">Jenis Pimpinan</label>
                        <select id="signatory_type" name="signatory_type" required>
                            <option value="">Pilih jenis pimpinan</option>
                            <option value="pimpinan" {{ old('signatory_type') === 'pimpinan' ? 'selected' : '' }}>
                                Pimpinan
                            </option>
                            <option value="pimpinan_bagian" {{ old('signatory_type') === 'pimpinan_bagian' ? 'selected' : '' }}>
                                Pimpinan Bagian
                            </option>
                        </select>
                        @error('signatory_type')
                            <span class="leader-error">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="leader-signatory-group">
                        <h3>Pimpinan 1</h3>

                        <div class="leader-field">
                            <label for="first_position">Jabatan</label>
                            <input id="first_position" name="first_position" value="{{ old('first_position') }}"
                                placeholder="Contoh: Pemimpin Divisi" required>
                            @error('first_position')
                                <span class="leader-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="leader-field">
                            <label for="first_name">Nama</label>
                            <input id="first_name" name="first_name" value="{{ old('first_name') }}"
                                placeholder="Nama lengkap pimpinan 1" required>
                            @error('first_name')
                                <span class="leader-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="leader-signatory-group" id="second-signatory-group">
                        <h3>Pimpinan 2</h3>

                        <div class="leader-field">
                            <label for="second_position">Jabatan</label>
                            <input id="second_position" name="second_position" value="{{ old('second_position') }}"
                                placeholder="Contoh: Pemimpin Bagian">
                            @error('second_position')
                                <span class="leader-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="leader-field">
                            <label for="second_name">Nama</label>
                            <input id="second_name" name="second_name" value="{{ old('second_name') }}"
                                placeholder="Nama lengkap pimpinan 2">
                            @error('second_name')
                                <span class="leader-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>


                <div class="leader-form-actions">
                    <button type="submit" class="leader-button">
                        Simpan Pimpinan
                    </button>
                </div>
            </form>
        </div>

        <div class="leader-card">
            <h2>Daftar Data Pimpinan</h2>

            <div class="leader-table-wrap">
                <table class="leader-table">

                    <thead>
                        <tr>
                            <th>Jenis</th>
                            <th>Jabatan dan Nama</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($leaders as $leader)
                                        <tr>
                                            <td>
                                                {{ $leader->signatory_type === 'pimpinan_bagian'
                            ? 'Pimpinan Bagian'
                            : 'Pimpinan' }}
                                            </td>
                                            <td>
                                                <strong>{{ $leader->first_position }}</strong><br>
                                                {{ $leader->first_name }}

                                                @if ($leader->second_name)
                                                    <br><br>
                                                    <strong>{{ $leader->second_position }}</strong><br>
                                                    {{ $leader->second_name }}
                                                @endif
                                            </td>
                                            <td>
                                                <span class="leader-badge {{ $leader->is_active ? 'active' : 'inactive' }}">
                                                    {{ $leader->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </td>

                                            <td>
                                                <form action="{{ route('admin.leaders.toggle-status', $leader) }}" method="POST"
                                                    onsubmit="return confirm('Yakin ingin mengubah status pimpinan ini?')">
                                                    @csrf
                                                    @method('PATCH')

                                                    <button type="submit" class="leader-button">
                                                        {{ $leader->is_active ? 'Nonaktifkan' : 'Aktifkan' }}
                                                    </button>
                                                </form>
                                            </td>

                                        </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="leader-empty">
                                    Belum ada data pimpinan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>

        document.addEventListener('DOMContentLoaded', function () {
            const typeSelect = document.getElementById('signatory_type');
            const secondSignatoryGroup = document.getElementById('second-signatory-group');
            const secondPosition = document.getElementById('second_position');
            const secondName = document.getElementById('second_name');

            function updateSecondSignatoryFields() {
                const needsSecond = typeSelect.value === 'pimpinan_bagian';

                secondSignatoryGroup.style.display = needsSecond ? 'flex' : 'none';
                secondPosition.required = needsSecond;
                secondName.required = needsSecond;

                if (!needsSecond) {
                    secondPosition.value = '';
                    secondName.value = '';
                }
            }

            typeSelect.addEventListener('change', updateSecondSignatoryFields);
            updateSecondSignatoryFields();
        });

    </script>
@endsection