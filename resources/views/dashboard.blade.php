@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-label', 'Dashboard Utama')

@section('content')
    <style>
        .dashboard-header {
            margin-bottom: 28px;
        }

        .dashboard-header h1 {
            margin: 0;
            color: #24312F;
            font-size: 28px;
            font-weight: 800;
        }

        .dashboard-header p {
            margin: 7px 0 0;
            color: #6B7773;
            font-size: 14px;
        }

        .dashboard-summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 18px;
            margin-bottom: 28px;
        }

        .summary-card {
            padding: 22px;
            border: 1px solid #DCE4E0;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 5px 18px rgba(32, 79, 75, .05);
        }

        .summary-label {
            color: #6B7773;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .6px;
        }

        .summary-value {
            margin-top: 8px;
            color: #286963;
            font-size: 30px;
            font-weight: 800;
        }

        .history-card {
            overflow: hidden;
            border: 1px solid #DCE4E0;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 5px 18px rgba(32, 79, 75, .05);
        }

        .history-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 20px 22px;
            border-bottom: 1px solid #E7ECEA;
        }

        .history-header h2 {
            margin: 0;
            color: #24312F;
            font-size: 18px;
            font-weight: 800;
        }

        .history-header p {
            margin: 5px 0 0;
            color: #7A8582;
            font-size: 12px;
        }

        .history-search {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .history-search input {
            width: 280px;
            padding: 9px 11px;
            border: 1px solid #DCE4E0;
            border-radius: 8px;
            color: #34413E;
            background: #fff;
            font-size: 12px;
            outline: none;
        }

        .history-search input:focus {
            border-color: #286963;
        }

        .history-search button {
            padding: 9px 12px;
            border: 1px solid #DCE4E0;
            border-radius: 8px;
            color: #286963;
            background: #fff;
            font-size: 11px;
            font-weight: 700;
            cursor: pointer;
        }

        .history-search button:hover {
            color: #fff;
            background: #286963;
            border-color: #286963;
        }

        .history-table-wrapper {
            overflow-x: auto;
        }

        .history-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 900px;
        }

        .history-table th {
            padding: 13px 16px;
            color: #65716E;
            background: #F6F9F7;
            font-size: 11px;
            font-weight: 800;
            text-align: left;
            text-transform: uppercase;
            letter-spacing: .4px;
            white-space: nowrap;
        }

        .history-table td {
            padding: 15px 16px;
            border-top: 1px solid #EDF1EF;
            color: #34413E;
            font-size: 13px;
            vertical-align: middle;
        }

        .history-table tbody tr:hover {
            background: #FAFCFB;
        }

        .document-number {
            color: #286963;
            font-weight: 800;
        }

        .document-type {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 7px;
            color: #286963;
            background: #EAF4F1;
            font-size: 11px;
            font-weight: 800;
        }

        .nominal {
            color: #24312F;
            font-weight: 750;
            white-space: nowrap;
        }

        .creator-name {
            font-weight: 650;
        }

        .date-text {
            color: #6B7773;
            white-space: nowrap;
        }

        .status-badge {
            display: inline-block;
            padding: 5px 9px;
            border-radius: 7px;
            font-size: 10px;
            font-weight: 800;
        }

        .status-generated {
            color: #286963;
            background: #EAF4F1;
        }

        .status-active {
            color: #A85A00;
            background: #FFF2DD;
        }

        .action-group {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: nowrap;
        }

        .action-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 7px 10px;
            border: 1px solid #DCE4E0;
            border-radius: 7px;
            color: #286963;
            background: #fff;
            font-size: 11px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            white-space: nowrap;
            box-sizing: border-box;
        }

        .action-button:hover {
            color: #fff;
            background: #286963;
            border-color: #286963;
        }

        .empty-history {
            padding: 55px 20px;
            color: #7A8582;
            text-align: center;
        }

        .empty-history strong {
            display: block;
            margin-bottom: 7px;
            color: #34413E;
            font-size: 15px;
        }

        @media (max-width: 900px) {
            .dashboard-summary {
                grid-template-columns: 1fr;
            }

            .history-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .history-search {
                width: 100%;
            }

            .history-search input {
                flex: 1;
                width: auto;
            }
        }

        .edit-modal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            align-items: center;
            justify-content: center;
            padding: 25px;
            background: rgba(20, 35, 32, .55);
        }

        .edit-modal.show {
            display: flex;
        }

        .edit-modal-content {
            width: min(950px, 100%);
            max-height: 90vh;
            overflow-y: auto;
            padding: 25px;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 20px 60px rgba(0, 0, 0, .18);
        }

        .edit-modal-header {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 22px;
        }

        .edit-modal-header h2 {
            margin: 0 0 5px;
            color: #263633;
            font-size: 20px;
        }

        .edit-modal-header p {
            margin: 0;
            color: #7A8582;
            font-size: 12px;
        }

        .edit-modal-close {
            border: none;
            color: #6B7773;
            background: transparent;
            font-size: 28px;
            line-height: 1;
            cursor: pointer;
        }

        .edit-form-top {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 20px;
        }

        .edit-sections {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .edit-section {
            padding: 18px;
            border: 1px solid #DCE4E0;
            border-radius: 10px;
            background: #F8FAF9;
        }

        .edit-section h4 {
            margin: 24px 0 16px;
            padding: 9px 12px;
            border-left: 4px solid #286963;
            border-radius: 5px;
            background: #eef5f3;
            color: #286963;
            font-size: 14px;
            font-weight: 700;
        }

        .edit-section h4:first-of-type {
            margin-top: 8px;
        }

        .edit-section h4+.edit-field {
            margin-top: 0;
        }

        .edit-section h3 {
            margin: 0 0 16px;
            color: #286963;
            font-size: 15px;
        }

        .edit-field {
            margin-bottom: 13px;
        }

        .edit-field:last-child {
            margin-bottom: 0;
        }

        .edit-field label {
            display: block;
            margin-bottom: 6px;
            color: #4B5956;
            font-size: 12px;
            font-weight: 700;
        }

        .edit-field input,
        .edit-field textarea {
            width: 100%;
            box-sizing: border-box;
            padding: 9px 10px;
            border: 1px solid #DCE4E0;
            border-radius: 7px;
            color: #303C3A;
            background: #fff;
            font-size: 12px;
        }

        .edit-field input:focus,
        .edit-field textarea:focus {
            outline: none;
            border-color: #286963;
        }

        .edit-modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 8px;
            margin-top: 20px;
        }

        @media (max-width: 750px) {

            .edit-form-top,
            .edit-sections {
                grid-template-columns: 1fr;
            }
        }

        .edit-input-error {
            margin-top: 4px;
            color: #dc2626;
            font-size: 12px;
        }

        .edit-input-invalid {
            border-color: #dc2626 !important;
            outline-color: #dc2626 !important;
        }

        .history-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-top: 18px;
            padding: 14px 4px 4px;
        }

        .pagination-info {
            color: #6F7D79;
            font-size: 13px;
        }

        .pagination-controls {
            display: flex;
            align-items: center;
            gap: 18px;
        }

        .per-page-form {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
        }

        .per-page-form label,
        .per-page-form span {
            color: #53615D;
            font-size: 13px;
        }

        .per-page-form select {
            min-width: 70px;
            height: 36px;
            padding: 0 30px 0 10px;
            border: 1px solid #D5DEDB;
            border-radius: 6px;
            background: #FFFFFF;
            color: #24312F;
            font-size: 13px;
            cursor: pointer;
            outline: none;
        }

        .per-page-form select:focus {
            border-color: #286963;
        }

        .pagination-links {
            display: flex;
            align-items: center;
        }

        .pagination-links nav {
            display: flex;
            align-items: center;
        }

        .pagination-links nav>div:first-child {
            display: none;
        }

        .pagination-links svg {
            width: 16px;
            height: 16px;
        }

        .pagination-links a,
        .pagination-links span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            height: 34px;
            padding: 0 8px;
            border: 1px solid #D5DEDB;
            background: #FFFFFF;
            color: #53615D;
            font-size: 13px;
            text-decoration: none;
        }

        .pagination-links a:hover {
            background: #EEF5F3;
            color: #286963;
        }

        .pagination-links span[aria-current="page"] {
            background: #286963;
            border-color: #286963;
            color: #FFFFFF;
        }

        .pagination-links a:first-child,
        .pagination-links span:first-child {
            border-radius: 6px 0 0 6px;
        }

        .pagination-links a:last-child,
        .pagination-links span:last-child {
            border-radius: 0 6px 6px 0;
        }

        @media (max-width: 768px) {
            .history-pagination {
                flex-direction: column;
                align-items: flex-start;
            }

            .pagination-controls {
                width: 100%;
                justify-content: space-between;
            }
        }

        .input-error {
            border-color: #dc3545 !important;
            background-color: #fff5f5;
        }

        .edit-field-error {
            display: none;
            margin-top: 5px;
            color: #dc3545;
            font-size: 12px;
        }
    </style>

    <div class="dashboard-header">
        <h1>Dashboard</h1>
        <p>Selamat datang, {{ auth()->user()->name }}. Kelola dan pantau dokumen PB dari halaman ini.</p>
    </div>

    <div class="dashboard-summary">
        <div class="summary-card">
            <div class="summary-label">Total Dokumen PB</div>
            <div class="summary-value">{{ $totalDocuments }}</div>
        </div>

        <div class="summary-card">
            <div class="summary-label">Total Debet Rekening</div>
            <div class="summary-value">{{ $totalPb01 }}</div>
        </div>

        <div class="summary-card">
            <div class="summary-label">Total Penerusan BI</div>
            <div class="summary-value">{{ $totalPb02 }}</div>
        </div>
    </div>

    <div class="history-card">
        <div class="history-header">
            <div>
                <h2>Riwayat Dokumen PB</h2>
                <p>Daftar dokumen PB yang pernah dibuat oleh seluruh staff.</p>
            </div>

            <div class="history-search">
                <input type="text" id="history-search-input" placeholder="Cari No. PB, jenis top up, atau staff..."
                    autocomplete="off">

                <button type="button" id="history-search-reset">
                    Reset
                </button>
            </div>
        </div>

        @if ($documents->isEmpty())
            <div class="empty-history">
                <strong>Belum ada riwayat dokumen PB.</strong>
                Dokumen yang sudah dibuat akan muncul di sini.
            </div>
        @else
            <div class="history-table-wrapper">
                <table class="history-table">
                    <thead>
                        <tr>
                            <th>No. PB</th>
                            <th>Jenis Top Up</th>
                            <th>PB</th>
                            <th>Nominal</th>
                            <th>Dibuat Oleh</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($documents as $document)
                                    @php
                                        $sections = $document->group_documents
                                            ->flatMap(function ($groupDocument) {
                                                return $groupDocument->sections;
                                            });

                                        $debit = $document->group_documents
                                            ->flatMap(function ($groupDocument) {
                                                return $groupDocument->sections;
                                            })
                                            ->flatMap(function ($section) {
                                                return $section->entries;
                                            })
                                            ->firstWhere('entry_type', 'debet');

                                        $hasPb01 = $sections->contains('section_type', 'pb01');
                                        $hasPb02 = $sections->contains('section_type', 'pb02');

                                        $documentType = match (true) {
                                            $hasPb01 && $hasPb02 => 'Debet Rekening & Penerusan BI',
                                            $hasPb01 => 'Mendebet Rekening',
                                            $hasPb02 => 'Penerusan BI',
                                            default => '-',
                                        };
                                    @endphp

                                    <tr data-search="{{ strtolower(
                                $document->group_documents
                                    ->flatMap(function ($groupDocument) {
                                        return $groupDocument->sections;
                                    })
                                    ->flatMap(function ($section) {
                                        return $section->entries;
                                    })
                                    ->map(function ($entry) {
                                        return implode(' ', [
                                            $entry->amount,
                                            number_format(
                                                (float) $entry->amount,
                                                0,
                                                ',',
                                                '.'
                                            ),
                                            $entry->date_from?->format('Y-m-d'),
                                            $entry->date_until?->format('Y-m-d'),
                                        ]);
                                    })
                                    ->implode(' ') . ' ' .
                                $document->group_documents
                                    ->pluck('document_number')
                                    ->implode(' ') . ' ' .
                                ($document->topupType?->name ?? '') . ' ' .
                                $documentType . ' ' .
                                ($document->creator?->name ?? '') . ' ' .
                                ($document->signature_date?->format('Y-m-d') ?? '')
                            ) }}">
                                        <td>
                                            @php
                                                $pb01Document = $document->group_documents
                                                    ->sortByDesc('id')
                                                    ->first(function ($groupDocument) {
                                                        return $groupDocument->sections
                                                            ->contains('section_type', 'pb01');
                                                    });

                                                $pb02Document = $document->group_documents
                                                    ->sortByDesc('id')
                                                    ->first(function ($groupDocument) {
                                                        return $groupDocument->sections
                                                            ->contains('section_type', 'pb02');
                                                    });
                                            @endphp

                                            <div class="document-number">
                                                @if ($pb01Document)
                                                    <div>
                                                        {{ $pb01Document->document_number }}
                                                    </div>
                                                @endif

                                                @if ($pb02Document)
                                                    <div>
                                                        {{ $pb02Document->document_number }}
                                                    </div>
                                                @endif

                                                @if (!$pb01Document && !$pb02Document)
                                                    -
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            {{ $document->topupType?->name ?? '-' }}
                                        </td>

                                        <td>
                                            <span class="document-type">
                                                {{ $documentType }}
                                            </span>
                                        </td>

                                        <td>
                                            @php
                                                $pb01Document = $document->group_documents
                                                    ->sortByDesc('id')
                                                    ->first(function ($groupDocument) {
                                                        return $groupDocument->sections
                                                            ->contains('section_type', 'pb01');
                                                    });

                                                $pb02Document = $document->group_documents
                                                    ->sortByDesc('id')
                                                    ->first(function ($groupDocument) {
                                                        return $groupDocument->sections
                                                            ->contains('section_type', 'pb02');
                                                    });

                                                $pb01Debit = $pb01Document?->sections
                                                    ->flatMap(function ($section) {
                                                        return $section->entries;
                                                    })
                                                    ->firstWhere('entry_type', 'debet');

                                                $pb02Debit = $pb02Document?->sections
                                                    ->flatMap(function ($section) {
                                                        return $section->entries;
                                                    })
                                                    ->firstWhere('entry_type', 'debet');
                                            @endphp

                                            <div class="nominal">
                                                @if ($pb01Debit)
                                                    <div>
                                                        Rp {{ number_format((float) $pb01Debit->amount, 0, ',', '.') }}
                                                    </div>
                                                @endif

                                                @if ($pb02Debit)
                                                    <div>
                                                        Rp {{ number_format((float) $pb02Debit->amount, 0, ',', '.') }}
                                                    </div>
                                                @endif

                                                @if (!$pb01Debit && !$pb02Debit)
                                                    -
                                                @endif
                                            </div>
                                        </td>

                                        <td>
                                            <span class="creator-name">
                                                {{ $document->creator?->name ?? '-' }}
                                            </span>
                                        </td>

                                        <td>
                                            <span class="date-text">
                                                {{ $document->signature_date?->translatedFormat('d F Y') ?? '-' }}
                                            </span>
                                        </td>

                                        <td>
                                            @if ($document->generated_at)
                                                <span class="status-badge status-generated">
                                                    Sudah Digenerate
                                                </span>
                                            @else
                                                <span class="status-badge status-active">
                                                    Belum Digenerate
                                                </span>
                                            @endif
                                        </td>

                                        <td>
                                            <div class="action-group">
                                                <button type="button" class="action-button" onclick="openEditModal({{ $document->id }})">
                                                    Edit
                                                </button>

                                                <button type="button" class="action-button" onclick="downloadDocument({{ $document->id }})">
                                                    Download
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                        @endforeach
                        <tr id="no-search-result" style="display: none;">
                            <td colspan="8" style="padding: 35px 20px; text-align: center; color: #7A8582;">
                                Tidak ada dokumen yang sesuai dengan pencarian.
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    <div class="history-pagination">
        <div class="pagination-info">
            Menampilkan
            {{ $documents->firstItem() ?? 0 }}
            sampai
            {{ $documents->lastItem() ?? 0 }}
            dari
            {{ $documents->total() }}
            data
        </div>

        <div class="pagination-controls">
            <form method="GET" action="{{ route('dashboard') }}" class="per-page-form">

                <label for="per-page">
                    Tampilkan
                </label>

                <select id="per-page" name="per_page" onchange="this.form.submit()">
                    <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>
                        25
                    </option>

                    <option value="50" {{ $perPage == 50 ? 'selected' : '' }}>
                        50
                    </option>

                    <option value="100" {{ $perPage == 100 ? 'selected' : '' }}>
                        100
                    </option>
                </select>

                <span>data</span>

                @if ($search !== '')
                    <input type="hidden" name="search" value="{{ $search }}">
                @endif
            </form>

            <div class="pagination-links">
                {{ $documents->links() }}
            </div>
        </div>
    </div>

    <div id="edit-modal" class="edit-modal">
        <div class="edit-modal-content">

            <div class="edit-modal-header">
                <div>
                    <h2>Edit Dokumen PB</h2>
                    <p id="edit-document-type"></p>
                </div>

                <button type="button" class="edit-modal-close" onclick="closeEditModal()">
                    &times;
                </button>
            </div>

            <form id="edit-form">

                <input type="hidden" id="edit-document-id">

                <div class="edit-form-top">

                    <div class="edit-field">
                        <label>Tanggal</label>
                        <input type="text" id="edit-date-range" readonly>

                        <input type="hidden" id="edit-date-from" name="date_from">
                        <input type="hidden" id="edit-date-until" name="date_until">
                    </div>
                </div>

                <div class="edit-sections">

                    <div class="edit-section" id="edit-section-pb01">

                        <h3>Mendebet Rekening</h3>

                        <div class="edit-field">
                            <label>No. PB</label>
                            <input type="text" id="edit-pb01-number" name="pb01_number" required>
                        </div>

                        <h4>Debet</h4>

                        <div class="edit-field">
                            <label>No. Rekening</label>
                            <input type="text" id="edit-pb01-debit-account-number" name="pb01_debit_account_number"
                                maxlength="16" inputmode="numeric" pattern="[0-9]*" required>

                            <p id="edit-pb01-debit-account-number-error" class="edit-input-error" style="display: none;">
                                Nomor rekening hanya boleh berisi angka.
                            </p>
                        </div>

                        <div class="edit-field">
                            <label>Nama Rekening</label>
                            <input type="text" id="edit-pb01-debit-account-name" name="pb01_debit_account_name" required>
                        </div>

                        <div class="edit-field">
                            <label>Nominal</label>
                            <input type="text" id="edit-pb01-debit-amount" name="pb01_debit_amount" min="0.01" step="0.01"
                                inputmode="decimal" required>

                            <p id="edit-pb01-debit-amount-error" class="edit-input-error" style="display: none;">
                                Nominal harus berupa angka dan lebih dari 0.
                            </p>
                        </div>

                        <div class="edit-field">
                            <label>Keterangan</label>
                            <textarea id="edit-pb01-debit-description" name="pb01_debit_description" rows="3"></textarea>
                        </div>


                        <h4>Kredit</h4>

                        <div class="edit-field">
                            <label>No. Rekening</label>
                            <input type="text" id="edit-pb01-credit-account-number" name="pb01_credit_account_number"
                                maxlength="16" inputmode="numeric" pattern="[0-9]*" required>

                            <p id="edit-pb01-credit-account-number-error" class="edit-input-error" style="display: none;">
                                Nomor rekening hanya boleh berisi angka.
                            </p>
                        </div>

                        <div class="edit-field">
                            <label>Nama Rekening</label>
                            <input type="text" id="edit-pb01-credit-account-name" name="pb01_credit_account_name" required>
                        </div>

                        <div class="edit-field">
                            <label>Nominal</label>
                            <input type="text" id="edit-pb01-credit-amount" name="pb01_credit_amount" min="0.01" step="0.01"
                                inputmode="decimal" required>

                            <p id="edit-pb01-credit-amount-error" class="edit-input-error" style="display: none;">
                                Nominal harus berupa angka dan lebih dari 0.
                            </p>
                        </div>

                        <div class="edit-field">
                            <label>Keterangan</label>
                            <textarea id="edit-pb01-credit-description" name="pb01_credit_description" rows="3"></textarea>
                        </div>

                    </div>


                    <div class="edit-section" id="edit-section-pb02">

                        <h3>Penerusan BI</h3>
                        <div class="edit-field">
                            <label>No. PB</label>
                            <input type="text" id="edit-pb02-number" name="pb02_number" required>
                        </div>

                        <h4>Debet</h4>

                        <div class="edit-field">
                            <label>No. Rekening</label>
                            <input type="text" id="edit-pb02-debit-account-number" name="pb02_debit_account_number"
                                maxlength="16" inputmode="numeric" pattern="[0-9]*" required>

                            <p id="edit-pb02-debit-account-number-error" class="edit-input-error" style="display: none;">
                                Nomor rekening hanya boleh berisi angka.
                            </p>
                        </div>

                        <div class="edit-field">
                            <label>Nama Rekening</label>
                            <input type="text" id="edit-pb02-debit-account-name" name="pb02_debit_account_name" required>
                        </div>

                        <div class="edit-field">
                            <label>Nominal</label>
                            <input type="text" id="edit-pb02-debit-amount" name="pb02_debit_amount" min="0.01" step="0.01"
                                inputmode="decimal" required>

                            <p id="edit-pb02-debit-amount-error" class="edit-input-error" style="display: none;">
                                Nominal harus berupa angka dan lebih dari 0.
                            </p>
                        </div>

                        <div class="edit-field">
                            <label>Keterangan</label>
                            <textarea id="edit-pb02-debit-description" name="pb02_debit_description" rows="3"></textarea>
                        </div>


                        <h4>Kredit</h4>

                        <div class="edit-field">
                            <label>No. Rekening</label>
                            <input type="text" id="edit-pb02-credit-account-number" name="pb02_credit_account_number"
                                maxlength="16" inputmode="numeric" pattern="[0-9]*" required>

                            <p id="edit-pb02-credit-account-number-error" class="edit-input-error" style="display: none;">
                                Nomor rekening hanya boleh berisi angka.
                            </p>
                        </div>

                        <div class="edit-field">
                            <label>Nama Rekening</label>
                            <input type="text" id="edit-pb02-credit-account-name" name="pb02_credit_account_name" required>
                        </div>

                        <div class="edit-field">
                            <label>Nominal</label>
                            <input type="text" id="edit-pb02-credit-amount" name="pb02_credit_amount" min="0.01" step="0.01"
                                inputmode="decimal" required>

                            <p id="edit-pb02-credit-amount-error" class="edit-input-error" style="display: none;">
                                Nominal harus berupa angka dan lebih dari 0.
                            </p>
                        </div>

                        <div class="edit-field">
                            <label>Keterangan</label>
                            <textarea id="edit-pb02-credit-description" name="pb02_credit_description" rows="3"></textarea>
                        </div>

                    </div>

                </div>

                <div class="edit-modal-footer">
                    <button type="button" class="action-button" onclick="closeEditModal()">
                        Batal
                    </button>

                    <button type="submit" class="action-button">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            async function openEditModal(documentId) {
                const modal = document.getElementById('edit-modal');

                try {
                    const response = await fetch(
                        `/documents/${documentId}/edit`
                    );

                    if (!response.ok) {
                        throw new Error('Gagal mengambil data dokumen.');
                    }

                    const data = await response.json();

                    document.getElementById('edit-document-id').value =
                        data.id;

                    const documents = data.documents ?? [];

                    const pb01 = documents.find(
                        document => document.section_type === 'pb01'
                    );

                    const pb02 = documents.find(
                        document => document.section_type === 'pb02'
                    );

                    const pb01Section = document.getElementById(
                        'edit-section-pb01'
                    );

                    const pb02Section = document.getElementById(
                        'edit-section-pb02'
                    );

                    function setSectionState(section, enabled) {
                        if (!section) {
                            return;
                        }

                        section.style.display = enabled ? '' : 'none';

                        section
                            .querySelectorAll('input, select, textarea')
                            .forEach(function (input) {
                                input.disabled = !enabled;
                            });
                    }

                    setSectionState(pb01Section, !!pb01);
                    setSectionState(pb02Section, !!pb02);

                    if (pb01) {
                        document.getElementById(
                            'edit-pb01-number'
                        ).value = pb01.document_number ?? '';
                    }

                    if (pb02) {
                        document.getElementById(
                            'edit-pb02-number'
                        ).value = pb02.document_number ?? '';
                    }

                    function fillEntry(prefix, entry) {
                        if (!entry) {
                            return;
                        }

                        document.getElementById(
                            `edit-${prefix}-account-number`
                        ).value = entry.account_number ?? '';

                        document.getElementById(
                            `edit-${prefix}-account-name`
                        ).value = entry.account_name ?? '';

                        document.getElementById(
                            `edit-${prefix}-amount`
                        ).value = entry.amount ?? '';

                        document.getElementById(
                            `edit-${prefix}-description`
                        ).value = entry.description ?? '';
                    }

                    const pb01Entries = pb01?.entries ?? [];

                    const pb01Debit = pb01Entries.find(
                        entry => entry.entry_type === 'debet'
                    );

                    const pb01Credit = pb01Entries.find(
                        entry => entry.entry_type === 'kredit'
                    );

                    fillEntry(
                        'pb01-debit',
                        pb01Debit
                    );

                    fillEntry(
                        'pb01-credit',
                        pb01Credit
                    );


                    const pb02Entries = pb02?.entries ?? [];

                    const pb02Debit = pb02Entries.find(
                        entry => entry.entry_type === 'debet'
                    );

                    const pb02Credit = pb02Entries.find(
                        entry => entry.entry_type === 'kredit'
                    );

                    fillEntry(
                        'pb02-debit',
                        pb02Debit
                    );

                    fillEntry(
                        'pb02-credit',
                        pb02Credit
                    );


                    const dateEntry =
                        pb01Debit ??
                        pb01Credit ??
                        pb02Debit ??
                        pb02Credit;

                    if (dateEntry) {
                        const start = dateEntry.date_from ?? '';
                        const end = dateEntry.date_until ?? '';

                        document.getElementById(
                            'edit-date-range'
                        ).value =
                            end && end !== start
                                ? `${start} s.d. ${end}`
                                : start;

                        document.getElementById(
                            'edit-date-from'
                        ).value = start;

                        document.getElementById(
                            'edit-date-until'
                        ).value = end;
                    }

                    modal.classList.add('show');

                } catch (error) {
                    console.error(error);
                    alert('Data dokumen gagal dimuat.');
                }
            }

            async function downloadDocument(documentId) {
                try {
                    const response = await fetch(
                        `/documents/${documentId}/download`
                    );

                    if (!response.ok) {
                        throw new Error('Gagal mengunduh dokumen.');
                    }

                    const blob = await response.blob();

                    const url = window.URL.createObjectURL(blob);

                    const link = document.createElement('a');
                    link.href = url;

                    const contentDisposition =
                        response.headers.get('Content-Disposition');

                    let filename = `PB-${documentId}.xlsx`;

                    if (contentDisposition) {
                        const match =
                            contentDisposition.match(/filename="?([^"]+)"?/);

                        if (match) {
                            filename = match[1];
                        }
                    }

                    link.download = filename;

                    document.body.appendChild(link);
                    link.click();
                    link.remove();

                    window.URL.revokeObjectURL(url);

                    window.location.reload();

                } catch (error) {
                    console.error(error);

                    alert('Dokumen gagal di-download.');
                }
            }

            function setupEditValidation() {
                const accountInputs = [
                    {
                        input: document.getElementById(
                            'edit-pb01-debit-account-number'
                        ),
                        error: document.getElementById(
                            'edit-pb01-debit-account-number-error'
                        ),
                    },
                    {
                        input: document.getElementById(
                            'edit-pb01-credit-account-number'
                        ),
                        error: document.getElementById(
                            'edit-pb01-credit-account-number-error'
                        ),
                    },
                    {
                        input: document.getElementById(
                            'edit-pb02-debit-account-number'
                        ),
                        error: document.getElementById(
                            'edit-pb02-debit-account-number-error'
                        ),
                    },
                    {
                        input: document.getElementById(
                            'edit-pb02-credit-account-number'
                        ),
                        error: document.getElementById(
                            'edit-pb02-credit-account-number-error'
                        ),
                    },
                ];

                accountInputs.forEach(function ({ input, error }) {
                    if (!input || !error) {
                        return;
                    }

                    input.addEventListener('input', function () {
                        const value = input.value.trim();

                        if (value === '') {
                            input.classList.remove('input-error');
                            error.textContent = '';
                            error.style.display = 'none';
                            return;
                        }

                        if (!/^[0-9]+$/.test(value)) {
                            input.classList.add('input-error');
                            error.textContent =
                                'Nomor rekening hanya boleh berisi angka.';
                            error.style.display = 'block';
                        } else {
                            input.classList.remove('input-error');
                            error.textContent = '';
                            error.style.display = 'none';
                        }
                    });
                });

                const amountInputs = [
                    {
                        input: document.getElementById(
                            'edit-pb01-debit-amount'
                        ),
                        error: document.getElementById(
                            'edit-pb01-debit-amount-error'
                        ),
                    },
                    {
                        input: document.getElementById(
                            'edit-pb01-credit-amount'
                        ),
                        error: document.getElementById(
                            'edit-pb01-credit-amount-error'
                        ),
                    },
                    {
                        input: document.getElementById(
                            'edit-pb02-debit-amount'
                        ),
                        error: document.getElementById(
                            'edit-pb02-debit-amount-error'
                        ),
                    },
                    {
                        input: document.getElementById(
                            'edit-pb02-credit-amount'
                        ),
                        error: document.getElementById(
                            'edit-pb02-credit-amount-error'
                        ),
                    },
                ];

                amountInputs.forEach(function ({ input, error }) {
                    if (!input || !error) {
                        return;
                    }

                    input.addEventListener('input', function () {
                        const value = input.value.trim();

                        if (value === '') {
                            input.classList.remove('input-error');
                            error.textContent = '';
                            error.style.display = 'none';
                            return;
                        }

                        if (!/^[0-9]+(\.[0-9]+)?$/.test(value)) {
                            input.classList.add('input-error');
                            error.textContent =
                                'Nominal hanya boleh berisi angka.';
                            error.style.display = 'block';
                        } else {
                            input.classList.remove('input-error');
                            error.textContent = '';
                            error.style.display = 'none';
                        }
                    });
                });
            }

            function closeEditModal() {
                document.getElementById('edit-modal')
                    .classList.remove('show');
            }

            document.addEventListener('DOMContentLoaded', function () {
                setupEditValidation();

                const input =
                    document.getElementById('history-search-input');

                const resetButton =
                    document.getElementById('history-search-reset');

                const rows =
                    document.querySelectorAll(
                        '.history-table tbody tr[data-search]'
                    );

                const noResult =
                    document.getElementById('no-search-result');

                if (input && resetButton && noResult) {

                    function filterHistory() {

                        const keyword =
                            input.value.trim().toLowerCase();

                        let visibleRows = 0;

                        rows.forEach(function (row) {

                            const searchableText =
                                row.dataset.search || '';

                            const isMatch =
                                searchableText.includes(keyword);

                            row.style.display =
                                isMatch ? '' : 'none';

                            if (isMatch) {
                                visibleRows++;
                            }
                        });

                        noResult.style.display =
                            visibleRows === 0
                                ? ''
                                : 'none';
                    }

                    input.addEventListener(
                        'input',
                        filterHistory
                    );

                    resetButton.addEventListener(
                        'click',
                        function () {
                            input.value = '';
                            filterHistory();
                            input.focus();
                        }
                    );
                }

                const editForm =
                    document.getElementById('edit-form');

                if (editForm) {

                    editForm.addEventListener(
                        'submit',
                        async function (event) {

                            event.preventDefault();

                            const documentId =
                                document.getElementById(
                                    'edit-document-id'
                                ).value;

                            const formData =
                                new FormData(editForm);

                            formData.append(
                                '_method',
                                'PUT'
                            );

                            try {

                                const response =
                                    await fetch(
                                        `/documents/${documentId}`,
                                        {
                                            method: 'POST',

                                            headers: {
                                                'X-CSRF-TOKEN':
                                                    document
                                                        .querySelector(
                                                            'meta[name="csrf-token"]'
                                                        )
                                                        .getAttribute(
                                                            'content'
                                                        ),

                                                'Accept':
                                                    'application/json',
                                            },

                                            body: formData,
                                        }
                                    );

                                if (!response.ok) {

                                    const data =
                                        await response
                                            .json()
                                            .catch(
                                                () => null
                                            );

                                    if (data?.errors) {

                                        const messages =
                                            Object.values(
                                                data.errors
                                            )
                                                .flat()
                                                .join('\n');

                                        alert(messages);

                                        return;
                                    }

                                    throw new Error(
                                        'Gagal menyimpan perubahan.'
                                    );
                                }

                                window.location.href =
                                    '/dashboard';

                            } catch (error) {

                                console.error(error);

                                alert(
                                    'Perubahan gagal disimpan.'
                                );
                            }
                        }
                    );
                }
            });
        </script>
    @endpush
@endsection