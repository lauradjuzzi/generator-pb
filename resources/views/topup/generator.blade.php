@extends('layouts.app')

@section('content')
    <div class="max-w-4xl mx-auto px-6 py-8">
        <div class="mb-6">
            <a href="{{ route('topup.show', $topupType->slug) }}" class="text-sm text-teal-700 hover:underline">
                &larr; Kembali
            </a>

            <h1 class="mt-3 text-2xl font-bold text-gray-800">
                Formulir Dokumen PB
            </h1>

            <p class="mt-1 text-gray-600">
                Jenis Top Up: {{ $topupType->name }}
            </p>

            <p class="text-gray-600">
                {{ $documentType === 'pb01'
        ? 'PB 01 — Mendebet Rekening'
        : 'PB 02 — Penerusan ke BI' }}
            </p>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
            <form method="POST" action="{{ route('topup.generator.store', [
        'topupType' => $topupType->slug,
        'documentType' => $documentType,
    ]) }}">
                @csrf

                <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                    {{-- Informasi PB --}}
                    <div>
                        <label for="pb_number" class="mb-1 block text-sm font-medium text-gray-700">
                            Nomor PB
                        </label>
                        <input type="text" id="pb_number" name="pb_number" value="{{ old('pb_number') }}"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                            placeholder="Masukkan nomor PB" required>
                    </div>

                    <div class="md:col-span-2">
                        <label for="date_range" class="mb-1 block text-sm font-medium text-gray-700">
                            Periode Transaksi
                        </label>

                        <input type="text" id="date_range"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                            placeholder="Pilih tanggal mulai dan selesai" autocomplete="off" required>

                        <input type="hidden" id="date_from" name="date_from" value="{{ old('date_from') }}">
                        <input type="hidden" id="date_until" name="date_until" value="{{ old('date_until') }}">

                        <p class="mt-1 text-xs text-gray-500">
                            Klik tanggal pertama sebagai tanggal mulai, lalu klik tanggal kedua sebagai tanggal selesai.
                        </p>
                    </div>

                    {{-- DEBET --}}
                    <div class="md:col-span-2 mt-4">
                        <div class="border-b border-gray-200 pb-2">
                            <h2 class="text-lg font-semibold text-gray-800">
                                Debet
                            </h2>
                            <p class="text-sm text-gray-500">
                                Data rekening yang akan didebet.
                            </p>
                        </div>
                    </div>

                    <div>
                        <label for="debit_account_number" class="mb-1 block text-sm font-medium text-gray-700">
                            Nomor Rekening Debet
                        </label>
                        <input type="text" id="debit_account_number" name="debit_account_number"
                            value="{{ old('debit_account_number', $topupType->default_debit_account_number) }}"
                            maxlength="16"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                            placeholder="Nomor rekening debet" required>
                    </div>

                    <div>
                        <label for="debit_account_name" class="mb-1 block text-sm font-medium text-gray-700">
                            Nama Rekening Debet
                        </label>
                        <input type="text" id="debit_account_name" name="debit_account_name"
                            value="{{ old('debit_account_name', $topupType->default_debit_account_name) }}"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                            placeholder="Nama rekening debet" required>
                    </div>

                    <div>
                        <label for="debit_amount" class="mb-1 block text-sm font-medium text-gray-700">
                            Nominal Debet (Rp)
                        </label>
                        <input type="number" id="debit_amount" name="debit_amount" value="{{ old('debit_amount') }}" min="1"
                            step="0.01" class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                            placeholder="Contoh: 1000000" required>
                    </div>

                    <div class="md:col-span-2">
                        <label for="debit_description" class="mb-1 block text-sm font-medium text-gray-700">
                            Keterangan Debet
                        </label>
                        <textarea id="debit_description" name="debit_description" rows="3"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                            placeholder="Keterangan transaksi debet">{{ old('debit_description', $topupType->default_debit_description) }}</textarea>
                    </div>

                    {{-- KREDIT --}}
                    <div class="md:col-span-2 mt-4">
                        <div class="border-b border-gray-200 pb-2">
                            <h2 class="text-lg font-semibold text-gray-800">
                                Kredit
                            </h2>
                            <p class="text-sm text-gray-500">
                                Data rekening yang akan dikredit.
                            </p>
                        </div>
                    </div>

                    <div>
                        <label for="credit_account_number" class="mb-1 block text-sm font-medium text-gray-700">
                            Nomor Rekening Kredit
                        </label>
                        <input type="text" id="credit_account_number" name="credit_account_number"
                            value="{{ old('credit_account_number', $topupType->default_credit_account_number) }}"
                            maxlength="16"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                            placeholder="Nomor rekening kredit" required>
                    </div>

                    <div>
                        <label for="credit_account_name" class="mb-1 block text-sm font-medium text-gray-700">
                            Nama Rekening Kredit
                        </label>
                        <input type="text" id="credit_account_name" name="credit_account_name"
                            value="{{ old('credit_account_name', $topupType->default_credit_account_name) }}"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                            placeholder="Nama rekening kredit" required>
                    </div>

                    <div>
                        <label for="credit_amount" class="mb-1 block text-sm font-medium text-gray-700">
                            Nominal Kredit (Rp)
                        </label>
                        <input type="number" id="credit_amount" name="credit_amount" value="{{ old('credit_amount') }}"
                            min="1" step="0.01"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                            placeholder="Contoh: 1000000" required>
                    </div>

                    <div class="md:col-span-2">
                        <label for="credit_description" class="mb-1 block text-sm font-medium text-gray-700">
                            Keterangan Kredit
                        </label>
                        <textarea id="credit_description" name="credit_description" rows="3"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                            placeholder="Keterangan transaksi kredit">{{ old('credit_description', $topupType->default_credit_description) }}</textarea>
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                        class="rounded-lg bg-teal-700 px-5 py-2.5 font-medium text-white hover:bg-teal-800">
                        Generate Excel
                    </button>
                </div>
            </form>
        </div>
    </div>

    
@endsection