@extends('layouts.app')

@section('title', 'Top Up ' . $topupType->name)
@section('page-label', 'Transaksi PB / Top Up ' . $topupType->name)

@section('content')
    <div class="brk-page-head brk-animate-in">

        <div class="brk-page-heading">
            <div>
                <span class="brk-page-eyebrow">
                    TRANSAKSI PB
                </span>

                <h1>
                    Top Up {{ $topupType->name }}
                </h1>

                <p>
                    Pilih jenis dokumen pemindahbukuan yang ingin
                    disiapkan untuk kebutuhan administrasi
                    {{ $topupType->name }}.
                </p>
            </div>

            <div class="brk-page-accent" aria-hidden="true">
                <span></span>
                <span></span>
                <span></span>
            </div>
        </div>
    </div>

    <div class="brk-pb-choice-grid">

        <a href="{{ route('topup.generator', [
        'topupType' => $topupType->slug,
        'documentType' => 'pb01',
    ]) }}" class="brk-pb-choice brk-pb-choice-red brk-animate-in brk-animate-delay-1">

            <div class="brk-pb-choice-top">
                <span class="brk-pb-number">
                    DOKUMEN PB 01
                </span>
            </div>

            <div class="brk-pb-choice-body">
                <span class="brk-pb-label">
                    JENIS TRANSAKSI
                </span>

                <h2>
                    Mendebet Rekening
                </h2>
            </div>

            <div class="brk-pb-choice-footer">
                <span>
                    Buka formulir PB 01
                </span>

                <span class="brk-pb-arrow" aria-hidden="true">
                    →
                </span>
            </div>
        </a>

        <a href="{{ route('topup.generator', [
        'topupType' => $topupType->slug,
        'documentType' => 'pb02',
    ]) }}" class="brk-pb-choice brk-pb-choice-green brk-animate-in brk-animate-delay-2">

            <div class="brk-pb-choice-top">
                <span class="brk-pb-number">
                    DOKUMEN PB 02
                </span>
            </div>

            <div class="brk-pb-choice-body">
                <span class="brk-pb-label">
                    JENIS TRANSAKSI
                </span>

                <h2>
                    Penerusan ke BI
                </h2>
            </div>

            <div class="brk-pb-choice-footer">
                <span>
                    Buka formulir PB 02
                </span>

                <span class="brk-pb-arrow" aria-hidden="true">
                    →
                </span>
            </div>
        </a>

    </div>

    @if ($pb01 || $pb02)
        <div class="brk-preview-bar brk-animate-in brk-animate-delay-3">

            <div class="brk-preview-info">
                <div class="brk-preview-status">
                    <span class="brk-status-pulse"></span>
                    <span>Dokumen siap di-preview</span>
                </div>

                <span>
                    Periksa data PB sebelum mengunduh dokumen Excel.
                </span>
            </div>

            <a href="{{ route('topup.generator.preview', [
                'topupType' => $topupType->slug,
            ]) }}" onclick="document.getElementById('success-alert')?.remove()" class="brk-preview-button">

                <span>Preview Dokumen</span>
                <span aria-hidden="true">→</span>
            </a>

        </div>
    @endif
@endsection