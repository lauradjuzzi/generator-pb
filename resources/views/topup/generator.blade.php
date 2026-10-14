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
                    <div>
                        <label for="pb_number" class="mb-1 block text-sm font-medium text-gray-700">
                            Nomor PB
                        </label>
                        <input type="text" id="pb_number" name="pb_number"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                            placeholder="Masukkan nomor PB" required>
                    </div>

                    <div>
                        <label for="amount" class="mb-1 block text-sm font-medium text-gray-700">
                            Nominal Transfer (Rp)
                        </label>
                        <input type="number" id="amount" name="amount" min="1" step="0.01"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                            placeholder="Contoh: 1000000" required>
                    </div>

                    <div>
                        <label for="date_from" class="mb-1 block text-sm font-medium text-gray-700">
                            Tanggal Mulai
                        </label>
                        <input type="date" id="date_from" name="date_from"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600" required>
                    </div>

                    <div>
                        <label for="date_until" class="mb-1 block text-sm font-medium text-gray-700">
                            Tanggal Selesai (opsional)
                        </label>
                        <input type="date" id="date_until" name="date_until"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600">
                    </div>

                    <div>
                        <label for="account_number" class="mb-1 block text-sm font-medium text-gray-700">
                            Nomor Rekening
                        </label>
                        <input type="text" id="account_number" name="account_number"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600" required>
                    </div>

                    <div>
                        <label for="account_name" class="mb-1 block text-sm font-medium text-gray-700">
                            Nama Rekening
                        </label>
                        <input type="text" id="account_name" name="account_name"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600" required>
                    </div>

                    <div class="md:col-span-2">
                        <label for="description" class="mb-1 block text-sm font-medium text-gray-700">
                            Keterangan
                        </label>
                        <textarea id="description" name="description" rows="3"
                            class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                            placeholder="Masukkan keterangan transaksi"></textarea>
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