@extends('layouts.app')

@section('title', 'Preview PB')
@section('page-label', 'Preview Dokumen PB')

@section('content')

    <style>
        .preview-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .preview-sheet-wrapper {
            overflow-x: auto;
            padding: 20px 0 40px;
        }

        .preview-sheet {
            width: 820px;
            min-width: 820px;
            margin: 0 auto;
            background: #fff;
            padding: 28px 42px 35px;
            box-sizing: border-box;
            color: #000;
            font-family: Arial, sans-serif;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .12);
        }

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
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
            border: 1px solid #000;
            padding: 7px 4px;
            min-height: 30px;
            box-sizing: border-box;
        }

        .account-cell {
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            padding: 5px;
            min-height: 27px;
            box-sizing: border-box;
        }

        .account-name {
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            text-align: center;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            padding: 5px;
            min-height: 27px;
            box-sizing: border-box;
        }

        .amount-cell {
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            text-align: center;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            padding: 5px;
            min-height: 27px;
            box-sizing: border-box;
        }

        .description-cell {
            grid-column: span 1;
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            text-align: center;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            min-height: 115px;
            padding: 12px 8px;
            box-sizing: border-box;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow-wrap: break-word;
        }

        .description-cell.credit {
            grid-column: span 1;
        }

        .empty-cell {
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            border-left: 1px solid #000;
            border-right: 1px solid #000;
            min-height: 115px;
        }

        .total-label {
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
            border: 1px solid #000;
            padding: 7px 4px;
        }

        .total-amount {
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            font-weight: 700;
            text-align: center;
            border: 1px solid #000;
            padding: 7px 4px;
        }

        .terbilang-label {
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            text-align: right;
            padding: 12px 8px 0 0;
        }

        .terbilang-value {
            grid-column: span 3;
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            font-style: italic;
            padding: 12px 8px 0;
            overflow-wrap: break-word;
        }

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
            font-size: 10px;
            text-align: center;
            margin-top: 4px;
        }

        .signature-knowing {
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 12px;
            text-align: center;
            margin-top: 24px;
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
            font-family: Arial Narrow, Arial, sans-serif;
            font-size: 11px;
            text-align: center;
            margin-top: 3px;
            overflow-wrap: break-word;
        }

        .signature-two {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
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
    ]) }}" style="font-weight:600; text-decoration:none;">
            ← Kembali
        </a>

        <button type="button" onclick="downloadExcel()"
            style="display:inline-block; padding:12px 20px; border:none; border-radius:9px; color:#fff; background:#286963; font-weight:700; text-decoration:none; cursor:pointer;">
            Download Excel
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

    <h1 style="margin-bottom:8px;">Preview Dokumen PB</h1>

    <p class="intro" style="margin-bottom:20px;">
        Periksa dokumen sebelum mengunduh Excel.
    </p>

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

                $debitDescription =
                    trim($debit->description ?? '') .
                    ' periode ' .
                    $period;

                $creditDescription =
                    trim($credit->description ?? '') .
                    ' periode ' .
                    $period;

                $terbilang = $generator->terbilang(
                    (float) $debit->amount
                );

                $signatureDate = $document->signature_date
                    ->locale('id')
                    ->translatedFormat('d F Y');

                $year = $document->signature_date->year;
            @endphp

            <div class="preview-sheet-wrapper">

                <div class="preview-sheet">

                    <div style="text-align:center; font-family:Arial; font-size:10px; font-weight:700; margin-bottom:2px;">
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