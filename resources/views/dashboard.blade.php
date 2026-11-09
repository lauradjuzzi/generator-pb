@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-label', 'Dashboard Utama')

@section('content')
    <h1>Dashboard</h1>

    <div class="welcome-message">
        <h2>Selamat Datang, {{ auth()->user()->name }}!</h2>
    </div>
@endsection