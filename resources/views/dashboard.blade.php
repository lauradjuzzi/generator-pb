@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-label', 'Dashboard Utama')

@section('content')
    <h1>Dashboard</h1>

    <p class="intro">
        Selamat datang di Sistem Generator PB BRK Syariah.
        Gunakan menu di sebelah kiri untuk mengakses jenis top up
        dan mengelola dokumen pemindahbukuan.
    </p>

    <div class="welcome-card card">
        <h2>Selamat Datang, {{ auth()->user()->name }}!</h2>

        <p>
            Sistem ini membantu staf E-Channel menyiapkan dokumen
            Pemindahbukuan (PB) untuk kebutuhan administrasi top up.
            Pilih jenis top up melalui sidebar untuk memulai.
        </p>
    </div>

    <div class="notice">
        <strong>Informasi:</strong>
        Sistem ini digunakan untuk membuat dokumen PB dalam format Excel.
        Sistem tidak menjalankan transaksi top up dan tidak mengakses saldo rekening.
    </div>
@endsection