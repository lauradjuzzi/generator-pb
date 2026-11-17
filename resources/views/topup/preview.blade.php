@extends('layouts.app')

@section('title', 'Preview PB')
@section('page-label', 'Preview Dokumen PB')

@section('content')

    <style>
        .preview-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 20px;
            padding: 16px 18px;
            border: 1px solid #e5ebe8;
            border-radius: 16px;
            background: rgba(255, 255, 255, 0.92);
            box-shadow: 0 5px 18px rgba(20, 35, 32, 0.05);
        }

        .preview-back-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #52625d;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            transition: color 0.18s ease, transform 0.18s ease;
        }

        .preview-back-link:hover {
            color: #087f5b;
            transform: translateX(-2px);
        }

        .preview-back-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border: 1px solid #dfe7e3;
            border-radius: 9px;
            background: #f8faf9;
            font-size: 15px;
        }

        .preview-download-button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            min-height: 40px;
            padding: 10px 17px;
            border: 0;
            border-radius: 10px;
            color: #ffffff;
            background: #087f5b;
            font-family: inherit;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            box-shadow: 0 5px 14px rgba(8, 127, 91, 0.16);
            transition:
                transform 0.18s ease,
                background-color 0.18s ease,
                box-shadow 0.18s ease;
        }

        .preview-download-button:hover {
            background: #056044;
            transform: translateY(-1px);
            box-shadow: 0 8px 18px rgba(8, 127, 91, 0.20);
        }

        .preview-download-button:active {
            transform: translateY(0);
        }

        .preview-download-button:disabled {
            opacity: 0.7;
            cursor: wait;
            transform: none;
        }

        /* Header halaman */

        .preview-page-header {
            margin-bottom: 22px;
        }

        .preview-page-eyebrow {
            display: block;
            margin-bottom: 6px;
            color: #087f5b;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.10em;
            text-transform: uppercase;
        }

        .preview-page-header h1 {
            margin: 0 0 7px;
            color: #182522;
            font-size: 26px;
            font-weight: 800;
            line-height: 1.2;
        }

        .preview-page-header p {
            margin: 0;
            color: #71807b;
            font-size: 13px;
            line-height: 1.5;
        }

        /* Label PB */

        .preview-document-card {
            margin-bottom: 26px;
            padding: 18px;
            border: 1px solid #e3ebe7;
            border-radius: 18px;
            background: #ffffff;
            box-shadow: 0 7px 22px rgba(20, 35, 32, 0.05);
        }

        .preview-document-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 4px;
        }

        .preview-document-title {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .preview-document-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 54px;
            min-height: 30px;
            padding: 6px 10px;
            border-radius: 8px;
            color: #ffffff;
            background: #c62828;
            font-size: 10px;
            font-weight: 800;
        }

        .preview-document-name {
            color: #263532;
            font-size: 13px;
            font-weight: 800;
        }

        /* Area Excel */

        .preview-sheet-wrapper {
            width: 100%;
            overflow-x: auto;
            padding: 16px 4px 26px;
        }

        .preview-sheet {
            width: 820px;
            min-width: 820px;
            margin: 0 auto;
            box-sizing: border-box;
            padding: 28px 42px 35px;
            color: #000000;
            background: #ffffff;
            font-family: Arial, sans-serif;
            box-shadow:
                0 8px 24px rgba(20, 35, 32, 0.10),
                0 1px 4px rgba(20, 35, 32, 0.08);
        }

        /* Grid Excel */

        .excel-grid {
            display: grid;
            grid-template-columns: 31.44fr 19.66fr 31.89fr 24.33fr;
        }

        .cell {
            box-sizing: border-box;
            min-width: 0;
        }

        .center {
            text-align: center;
        }

        .bold {
            font-weight: 700;
        }

        .wrap {
            white-space: normal;
            overflow-wrap: break-word;
        }

        .sheet-title {
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 14px;
            font-weight: 700;
            text-align: center;
        }

        .sheet-header {
            box-sizing: border-box;
            min-height: 30px;
            padding: 7px 4px;
            border: 1px solid #000000;
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
        }

        .account-cell {
            box-sizing: border-box;
            min-height: 27px;
            padding: 5px;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
        }

        .account-name {
            box-sizing: border-box;
            min-height: 27px;
            padding: 5px;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            text-align: center;
        }

        .amount-cell {
            box-sizing: border-box;
            min-height: 27px;
            padding: 5px;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            text-align: center;
        }

        .description-cell {
            display: flex;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            grid-column: span 1;
            min-height: 115px;
            padding: 12px 8px;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            text-align: center;
            overflow-wrap: break-word;
        }

        .description-cell.credit {
            grid-column: span 1;
        }

        .empty-cell {
            box-sizing: border-box;
            min-height: 115px;
            border-left: 1px solid #000000;
            border-right: 1px solid #000000;
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
        }

        .total-label {
            box-sizing: border-box;
            padding: 7px 4px;
            border: 1px solid #000000;
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
        }

        .total-amount {
            box-sizing: border-box;
            padding: 7px 4px;
            border: 1px solid #000000;
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
        }

        .terbilang-label {
            padding: 12px 8px 0 0;
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            text-align: right;
        }

        .terbilang-value {
            grid-column: span 3;
            padding: 12px 8px 0;
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            font-style: italic;
            overflow-wrap: break-word;
        }

        /* Tanda tangan */

        .signature-area {
            width: 50%;
            margin-top: 20px;
            margin-left: auto;
        }

        .signature-date {
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            text-align: center;
        }

        .signature-division {
            margin-top: 4px;
            font-size: 10px;
            text-align: center;
        }

        .signature-knowing {
            margin-top: 24px;
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            text-align: center;
        }

        .signature-space {
            height: 72px;
        }

        .signature-name {
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
            text-decoration: underline;
            overflow-wrap: break-word;
        }

        .signature-position {
            margin-top: 3px;
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 11px;
            text-align: center;
            overflow-wrap: break-word;
        }

        .signature-two {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
        }

        /* Responsive */

        @media (max-width: 700px) {
            .preview-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .preview-download-button {
                width: 100%;
            }

            .preview-page-header h1 {
                font-size: 22px;
            }

            .preview-document-card {
                padding: 12px;
            }

            .preview-document-header {
                align-items: flex-start;
                flex-direction: column;
            }

            .preview-sheet-wrapper {
                padding-right: 0;
                padding-left: 0;
            }
        }

        /* Print */

        @media print {

            .preview-actions,
            .preview-page-header,
            .intro,
            h1,
            .page-label,
            .preview-document-header {
                display: none !important;
            }

            .preview-document-card {
                margin: 0;
                padding: 0;
                border: 0;
                box-shadow: none;
            }

            .preview-sheet-wrapper {
                padding: 0;
                overflow: visible;
            }

            .preview-sheet {
                width: 100%;
                min-width: 0;
                margin: 0;
                box-shadow: none;
            }
        }

        @media print {

            .preview-actions,
            .intro,
            h1,
            .page-label {
                display: none !important;
            }

            .preview-sheet-wrapper {
                padding: 0;
                overflow: visible;
            }

            .preview-sheet {
                width: 100%;
                min-width: 0;
                box-shadow: none;
                margin: 0;
            }
        }
    </style>

    <div class="preview-actions">
        <a href="{{ route('topup.show', [
        'topupType' => $topupType->slug,
    ]) }}" class="preview-back-link">
            <span class="preview-back-icon">←</span>
            <span>Kembali</span>
        </a>

        <button type="button" onclick="downloadExcel()" class="preview-download-button">
            <span>Download Excel</span>
        </button>
    </div>
    <script>
        async function downloadExcel() {
            const button = event.currentTarget;

            button.disabled = true;
            button.textContent = 'Menyiapkan Excel...';

            try {
                const response = await fetch(
                    "{{ route('topup.generator.excel', [
        'topupType' => $topupType->slug,
    ]) }}"
                );

                if (!response.ok) {
                    throw new Error('Gagal mengunduh Excel.');
                }

                const blob = await response.blob();

                const url = window.URL.createObjectURL(blob);
                const link = document.createElement('a');

                link.href = url;
                link.download = 'PB-{{ \Illuminate\Support\Str::slug($topupType->name) }}-{{ now()->format('d-m-Y') }}.xlsx';

                document.body.appendChild(link);
                link.click();
                link.remove();

                window.URL.revokeObjectURL(url);

                window.location.href = "{{ route('dashboard') }}";
            } catch (error) {
                alert('Gagal mengunduh Excel. Silakan coba lagi.');

                button.disabled = false;
                button.textContent = 'Download Excel';
            }
        }
    </script>

    <div class="preview-page-header">
        <span class="preview-page-eyebrow">DOKUMEN PB</span>

        <h1>Preview Dokumen PB</h1>

        <p>
            Periksa dokumen sebelum mengunduh Excel.
        </p>
    </div>

    @foreach ([
            'PB 01' => $pb01,
            'PB 02' => $pb02,
        ] as $label => $document)

        @if ($document)

            @php
                $section = $document->sections->first();

                $entries = $section?->entries->keyBy('entry_type');

                $debit = $entries?->get('debet');
                $credit = $entries?->get('kredit');

                $generator = app(\App\Services\PbExcelGenerator::class);

                $period = $debit->date_from->translatedFormat('d F Y');

                if (
                    $debit->date_until &&
                    !$debit->date_from->isSameDay($debit->date_until)
                ) {
                    $period .= ' s.d. ' .
                        $debit->date_until->translatedFormat('d F Y');
                }

                $isDateRange =
                    $debit->date_until &&
                    !$debit->date_from->isSameDay($debit->date_until);

                $periodText = $isDateRange
                    ? ' periode ' . $period
                    : ' ' . $period;

                $debitDescription =
                    trim($debit->description ?? '') .
                    $periodText;

                $creditDescription =
                    trim($credit->description ?? '') .
                    $periodText;

                $amountForTerbilang = (float) number_format(
                    (float) $debit->amount,
                    2,
                    '.',
                    ''
                );

                $terbilang = $generator->terbilang(
                    $debit->getRawOriginal('amount')
                );

                $signatureDate = $document->signature_date
                    ->locale('id')
                    ->translatedFormat('d F Y');

                $year = $document->signature_date->year;
            @endphp

            <div class="preview-document-card">

                <div class="preview-document-header">
                    <div class="preview-document-title">
                        <span class="preview-document-badge">
                            {{ $label }}
                        </span>

                        <span class="preview-document-name">
                            {{ $document->document_number }}
                        </span>
                    </div>
                </div>

                <div class="preview-sheet-wrapper">

                    <div class="preview-sheet">

                        <div style="font-family:Arial; font-size:10px; font-weight:700; margin-bottom:10px;">
                            PT. BANK RIAU KEPRI SYARIAH
                        </div>

                        <div style="font-family:Arial; font-size:10px; font-weight:700; margin-bottom:10px;">
                            KANTOR PUSAT
                        </div>

                        <div class="sheet-title" style="margin-bottom:2px;">
                            PERINTAH PEMBUKUAN
                        </div>

                        <div class="sheet-title" style="margin-bottom:20px;">
                            No : {{ $document->document_number }} /OPS.PBK/{{ $year }}
                        </div>

                        <div class="excel-grid">

                            <div class="sheet-header" style="grid-column:span 2;">
                                DEBET
                            </div>

                            <div class="sheet-header" style="grid-column:span 2;">
                                KREDIT
                            </div>

                            <div class="sheet-header">
                                KETERANGAN
                            </div>

                            <div class="sheet-header">
                                JUMLAH
                            </div>

                            <div class="sheet-header">
                                KETERANGAN
                            </div>

                            <div class="sheet-header">
                                JUMLAH
                            </div>

                            <div class="account-cell">
                                {{ $debit->account_number }}
                            </div>

                            <div class="amount-cell"></div>

                            <div class="account-cell">
                                {{ $credit->account_number }}
                            </div>

                            <div class="amount-cell"></div>

                            <div class="account-name">
                                {{ $debit->account_name }}
                            </div>

                            <div class="amount-cell">
                                {{ number_format($debit->amount, 2, ',', '.') }}
                            </div>

                            <div class="account-name">
                                {{ $credit->account_name }}
                            </div>

                            <div class="amount-cell">
                                {{ number_format($credit->amount, 2, ',', '.') }}
                            </div>

                            <div class="description-cell">
                                {{ $debitDescription }}
                            </div>

                            <div class="empty-cell"></div>

                            <div class="description-cell credit">
                                {{ $creditDescription }}
                            </div>

                            <div class="empty-cell"></div>

                            <div class="total-label">
                                TOTAL
                            </div>

                            <div class="total-amount">
                                {{ number_format($debit->amount, 2, ',', '.') }}
                            </div>

                            <div class="total-label">
                                TOTAL
                            </div>

                            <div class="total-amount">
                                {{ number_format($credit->amount, 2, ',', '.') }}
                            </div>

                        </div>

                        <div class="excel-grid">

                            <div class="terbilang-label">
                                Terbilang :
                            </div>

                            <div class="terbilang-value">
                                {{ $terbilang }}
                            </div>

                        </div>

                        <div class="signature-area">

                            <div class="signature-date">
                                Pekanbaru, {{ $signatureDate }}
                            </div>

                            <div class="signature-division">
                                DIVISI OPERASIONAL &amp; AKUNTANSI
                            </div>

                            @if ($document->signatory_type === 'pimpinan_bagian')

                                <div class="signature-two">

                                    <div>
                                        <div class="signature-space"></div>

                                        <div class="signature-name">
                                            {{ $document->first_signatory_name }}
                                        </div>

                                        <div class="signature-position">
                                            {{ $document->first_signatory_position }}
                                        </div>
                                    </div>

                                    <div>
                                        <div class="signature-space"></div>

                                        <div class="signature-name">
                                            {{ $document->second_signatory_name }}
                                        </div>

                                        <div class="signature-position">
                                            {{ $document->second_signatory_position }}
                                        </div>
                                    </div>

                                </div>

                            @else

                                <div style="height:115px;"></div>

                                <div class="signature-name">
                                    {{ $document->first_signatory_name }}
                                </div>

                                <div class="signature-position">
                                    {{ $document->first_signatory_position }}
                                </div>

                            @endif

                        </div>

                    </div>

                </div>

        @endif

    @endforeach

@endsection