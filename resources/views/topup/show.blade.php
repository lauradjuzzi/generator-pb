@extends('layouts.app')

@section('title', 'Top Up ' . $topupType->name)
@section('page-label', 'Transaksi PB / Top Up ' . $topupType->name)

@section('content')
    <a href="{{ route('dashboard') }}"
        style="display:inline-flex; align-items:center; gap:8px; margin-bottom:20px; font-weight:600;">
        ← Kembali ke Dashboard
    </a>

    <h1>Top Up {{ $topupType->name }}</h1>

    <p class="intro">
        Pilih jenis dokumen pemindahbukuan yang ingin disiapkan
        untuk kebutuhan administrasi {{ $topupType->name }}.
    </p>

    <div style="display:grid; grid-template-columns:repeat(auto-fit,minmax(250px,1fr)); gap:20px;">
        <a href="{{ route('topup.generator', [
        'topupType' => $topupType->slug,
        'documentType' => 'pb01',
    ]) }}" class="card card-hover" style="display:block; padding:24px; color:inherit;">
            <div style="font-size:12px; font-weight:700; color:#286963; margin-bottom:12px;">
                DOKUMEN PB 01
            </div>

            <h2 style="font-size:20px; margin-bottom:10px;">
                Mendebet Rekening
            </h2>

            <p style="margin-bottom:18px;">
                Siapkan dokumen PB untuk proses pendebetan rekening.
            </p>

            <span style="font-weight:700; color:#286963;">
                Pilih menu →
            </span>
        </a>

        <a href="{{ route('topup.generator', [
        'topupType' => $topupType->slug,
        'documentType' => 'pb02',
    ]) }}" class="card card-hover" style="display:block; padding:24px; color:inherit;">
            <div style="font-size:12px; font-weight:700; color:#286963; margin-bottom:12px;">
                DOKUMEN PB 02
            </div>

            <h2 style="font-size:20px; margin-bottom:10px;">
                Penerusan ke BI
            </h2>

            <p style="margin-bottom:18px;">
                Siapkan dokumen PB untuk proses penerusan ke BI.
            </p>

            <span style="font-weight:700; color:#286963;">
                Pilih menu →
            </span>
        </a>
    </div>

    @if ($pb01 || $pb02)
        <div style="margin-top:24px; display:flex; justify-content:flex-end;">
            <a href="{{ route('topup.generator.preview', [
                'topupType' => $topupType->slug,
            ]) }}" onclick="document.getElementById('success-alert')?.remove()"
                style="display:inline-block; padding:12px 20px; border-radius:9px; color:#fff; background:#286963; font-weight:700; text-decoration:none;">
                Preview
            </a>
        </div>
    @endif
@endsection