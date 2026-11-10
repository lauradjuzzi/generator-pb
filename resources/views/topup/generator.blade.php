@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto px-6 py-8">

        <div class="mb-6">
            <a href="{{ route('topup.show', $topupType->slug) }}" class="text-sm text-teal-700 hover:underline">
                &larr; Kembali
            </a>

            <h1 class="mt-3 text-2xl font-bold text-gray-800">
                Formulir {{ strtoupper($documentType) }}
            </h1>

            <p class="mt-1 text-gray-600">
                Jenis Top Up: {{ $topupType->name }}
            </p>
        </div>

        {{-- PESAN BERHASIL --}}
        @if (session('success'))
            <div class="mb-6 rounded-lg border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                {{ session('success') }}
            </div>
        @endif

        {{-- PESAN ERROR --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        {{-- ==================== PB 01 ==================== --}}
        @if ($documentType === 'pb01')

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="mb-6 border-b border-gray-200 pb-3">
                    <h2 class="text-xl font-bold text-gray-800">
                        PB 01
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Mendebet Rekening
                    </p>
                </div>

                <form method="POST" action="{{ route('topup.generator.pb01.store', [
                'topupType' => $topupType->slug,
            ]) }}" class="pb-form" data-form="pb01">

                    @csrf

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        {{-- NOMOR PB --}}
                        <div>
                            <label for="pb01_number" class="mb-1 block text-sm font-medium text-gray-700">
                                Nomor PB
                            </label>

                            <input type="text" id="pb01_number" name="pb_number" value="{{ old('pb_number') }}"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Masukkan nomor PB" required>
                        </div>

                        {{-- PERIODE --}}
                        <div class="form-group">
                            <label for="pb01_date_range">Tanggal</label>

                            <input type="text" id="pb01_date_range" placeholder="Pilih rentang tanggal" autocomplete="off"
                                class="form-control">

                            <input type="hidden" name="date_from" id="pb01_date_from">
                            <input type="hidden" name="date_until" id="pb01_date_until">
                        </div>


                        {{-- DEBET --}}
                        <div class="mt-4 md:col-span-2">
                            <div class="border-b border-gray-200 pb-2">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    Debet
                                </h3>

                                <p class="text-sm text-gray-500">
                                    Data rekening yang akan didebet.
                                </p>
                            </div>
                        </div>

                        <div>
                            <label for="pb01_debit_account_number" class="mb-1 block text-sm font-medium text-gray-700">
                                Nomor Rekening Debet
                            </label>

                            <input type="text" id="pb01_debit_account_number" name="debit_account_number"
                                value="{{ old('debit_account_number', $topupType->default_debit_account_number) }}"
                                maxlength="16" inputmode="numeric" pattern="[0-9]*"
                                class="pb01-number w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Nomor rekening debet" required>

                            <p id="pb01_debit_account_number_error" class="mt-1 hidden text-xs text-red-600">
                                Nomor rekening hanya boleh berisi angka.
                            </p>
                        </div>

                        <div>
                            <label for="pb01_debit_account_name" class="mb-1 block text-sm font-medium text-gray-700">
                                Nama Rekening Debet
                            </label>

                            <input type="text" id="pb01_debit_account_name" name="debit_account_name"
                                value="{{ old('debit_account_name', $topupType->default_debit_account_name) }}"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Nama rekening debet" required>
                        </div>

                        <div>
                            <label for="pb01_debit_amount" class="mb-1 block text-sm font-medium text-gray-700">
                                Nominal Debet (Rp)
                            </label>

                            <input type="number" id="pb01_debit_amount" name="debit_amount" value="{{ old('debit_amount') }}"
                                min="1" step="0.01"
                                class="pb01-amount w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Contoh: 1000000" required>

                            <p id="pb01_debit_amount_error" class="mt-1 hidden text-xs text-red-600">
                                Nominal Debet harus berupa angka.
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <label for="pb01_debit_description" class="mb-1 block text-sm font-medium text-gray-700">
                                Keterangan Debet
                            </label>

                            <textarea id="pb01_debit_description" name="debit_description" rows="3"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Keterangan transaksi debet">{{ old('debit_description', $topupType->default_debit_description) }}</textarea>
                        </div>


                        {{-- KREDIT --}}
                        <div class="mt-4 md:col-span-2">
                            <div class="border-b border-gray-200 pb-2">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    Kredit
                                </h3>

                                <p class="text-sm text-gray-500">
                                    Data rekening yang akan dikredit.
                                </p>
                            </div>
                        </div>

                        <div>
                            <label for="pb01_credit_account_number" class="mb-1 block text-sm font-medium text-gray-700">
                                Nomor Rekening Kredit
                            </label>

                            <input type="text" id="pb01_credit_account_number" name="credit_account_number"
                                value="{{ old('credit_account_number', $topupType->default_credit_account_number) }}"
                                maxlength="16" inputmode="numeric" pattern="[0-9]*"
                                class="pb01-number w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Nomor rekening kredit" required>

                            <p id="pb01_credit_account_number_error" class="mt-1 hidden text-xs text-red-600">
                                Nomor rekening hanya boleh berisi angka.
                            </p>
                        </div>

                        <div>
                            <label for="pb01_credit_account_name" class="mb-1 block text-sm font-medium text-gray-700">
                                Nama Rekening Kredit
                            </label>

                            <input type="text" id="pb01_credit_account_name" name="credit_account_name"
                                value="{{ old('credit_account_name', $topupType->default_credit_account_name) }}"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Nama rekening kredit" required>
                        </div>

                        <div>
                            <label for="pb01_credit_amount" class="mb-1 block text-sm font-medium text-gray-700">
                                Nominal Kredit (Rp)
                            </label>

                            <input type="number" id="pb01_credit_amount" name="credit_amount" value="{{ old('credit_amount') }}"
                                min="1" step="0.01"
                                class="pb01-amount w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Contoh: 1000000" required>

                            <p id="pb01_credit_amount_error" class="mt-1 hidden text-xs text-red-600">
                                Nominal Kredit harus berupa angka.
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <label for="pb01_credit_description" class="mb-1 block text-sm font-medium text-gray-700">
                                Keterangan Kredit
                            </label>

                            <textarea id="pb01_credit_description" name="credit_description" rows="3"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Keterangan transaksi kredit">{{ old('credit_description', $topupType->default_credit_description) }}</textarea>
                        </div>

                    </div>

                    {{-- SIMPAN PB01 --}}
                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                            class="pb01-save hidden rounded-lg bg-teal-700 px-5 py-2.5 font-medium text-white hover:bg-teal-800">
                            Simpan PB01
                        </button>
                    </div>

                </form>
            </div>


            {{-- ==================== PB 02 ==================== --}}
        @elseif ($documentType === 'pb02')

            <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">

                <div class="mb-6 border-b border-gray-200 pb-3">
                    <h2 class="text-xl font-bold text-gray-800">
                        PB 02
                    </h2>

                    <p class="mt-1 text-sm text-gray-500">
                        Penerusan ke BI
                    </p>
                </div>

                <form method="POST" action="{{ route('topup.generator.pb02.store', [
                'topupType' => $topupType->slug,
            ]) }}" class="pb-form" data-form="pb02">

                    @csrf

                    <div class="grid grid-cols-1 gap-5 md:grid-cols-2">

                        {{-- NOMOR PB --}}
                        <div>
                            <label for="pb02_number" class="mb-1 block text-sm font-medium text-gray-700">
                                Nomor PB
                            </label>

                            <input type="text" id="pb02_number" name="pb_number" value="{{ old('pb_number') }}"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Masukkan nomor PB" required>
                        </div>

                        {{-- PERIODE --}}
                        <div class="form-group">
                            <label for="pb02_date_range">Tanggal</label>

                            <input type="text" id="pb02_date_range" placeholder="Pilih rentang tanggal" autocomplete="off"
                                class="form-control">

                            <input type="hidden" name="date_from" id="pb02_date_from">
                            <input type="hidden" name="date_until" id="pb02_date_until">
                        </div>


                        {{-- DEBET --}}
                        <div class="mt-4 md:col-span-2">
                            <div class="border-b border-gray-200 pb-2">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    Debet
                                </h3>

                                <p class="text-sm text-gray-500">
                                    Data rekening yang akan didebet.
                                </p>
                            </div>
                        </div>

                        <div>
                            <label for="pb02_debit_account_number" class="mb-1 block text-sm font-medium text-gray-700">
                                Nomor Rekening Debet
                            </label>

                            <input type="text" id="pb02_debit_account_number" name="debit_account_number"
                                value="{{ old('debit_account_number', $topupType->default_debit_account_number) }}"
                                maxlength="16" inputmode="numeric" pattern="[0-9]*"
                                class="pb02-number w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Nomor rekening debet" required>

                            <p id="pb02_debit_account_number_error" class="mt-1 hidden text-xs text-red-600">
                                Nomor rekening hanya boleh berisi angka.
                            </p>
                        </div>

                        <div>
                            <label for="pb02_debit_account_name" class="mb-1 block text-sm font-medium text-gray-700">
                                Nama Rekening Debet
                            </label>

                            <input type="text" id="pb02_debit_account_name" name="debit_account_name"
                                value="{{ old('debit_account_name', $topupType->default_debit_account_name) }}"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Nama rekening debet" required>
                        </div>

                        <div>
                            <label for="pb02_debit_amount" class="mb-1 block text-sm font-medium text-gray-700">
                                Nominal Debet (Rp)
                            </label>

                            <input type="number" id="pb02_debit_amount" name="debit_amount" value="{{ old('debit_amount') }}"
                                min="1" step="0.01"
                                class="pb02-amount w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Contoh: 1000000" required>

                            <p id="pb02_debit_amount_error" class="mt-1 hidden text-xs text-red-600">
                                Nominal Debet harus berupa angka.
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <label for="pb02_debit_description" class="mb-1 block text-sm font-medium text-gray-700">
                                Keterangan Debet
                            </label>

                            <textarea id="pb02_debit_description" name="debit_description" rows="3"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Keterangan transaksi debet">{{ old('debit_description', $topupType->default_debit_description) }}</textarea>
                        </div>


                        {{-- KREDIT --}}
                        <div class="mt-4 md:col-span-2">
                            <div class="border-b border-gray-200 pb-2">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    Kredit
                                </h3>

                                <p class="text-sm text-gray-500">
                                    Data rekening yang akan dikredit.
                                </p>
                            </div>
                        </div>

                        <div>
                            <label for="pb02_credit_account_number" class="mb-1 block text-sm font-medium text-gray-700">
                                Nomor Rekening Kredit
                            </label>

                            <input type="text" id="pb02_credit_account_number" name="credit_account_number"
                                value="{{ old('credit_account_number', $topupType->default_credit_account_number) }}"
                                maxlength="16" inputmode="numeric" pattern="[0-9]*"
                                class="pb02-number w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Nomor rekening kredit" required>

                            <p id="pb02_credit_account_number_error" class="mt-1 hidden text-xs text-red-600">
                                Nomor rekening hanya boleh berisi angka.
                            </p>
                        </div>

                        <div>
                            <label for="pb02_credit_account_name" class="mb-1 block text-sm font-medium text-gray-700">
                                Nama Rekening Kredit
                            </label>

                            <input type="text" id="pb02_credit_account_name" name="credit_account_name"
                                value="{{ old('credit_account_name', $topupType->default_credit_account_name) }}"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Nama rekening kredit" required>
                        </div>

                        <div>
                            <label for="pb02_credit_amount" class="mb-1 block text-sm font-medium text-gray-700">
                                Nominal Kredit (Rp)
                            </label>

                            <input type="number" id="pb02_credit_amount" name="credit_amount" value="{{ old('credit_amount') }}"
                                min="1" step="0.01"
                                class="pb02-amount w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Contoh: 1000000" required>

                            <p id="pb02_credit_amount_error" class="mt-1 hidden text-xs text-red-600">
                                Nominal Kredit harus berupa angka.
                            </p>
                        </div>

                        <div class="md:col-span-2">
                            <label for="pb02_credit_description" class="mb-1 block text-sm font-medium text-gray-700">
                                Keterangan Kredit
                            </label>

                            <textarea id="pb02_credit_description" name="credit_description" rows="3"
                                class="w-full rounded-lg border-gray-300 focus:border-teal-600 focus:ring-teal-600"
                                placeholder="Keterangan transaksi kredit">{{ old('credit_description', $topupType->default_credit_description) }}</textarea>
                        </div>

                    </div>

                    {{-- SIMPAN PB02 --}}
                    <div class="mt-6 flex justify-end">
                        <button type="submit"
                            class="pb02-save hidden rounded-lg bg-teal-700 px-5 py-2.5 font-medium text-white hover:bg-teal-800">
                            Simpan PB02
                        </button>
                    </div>

                </form>
            </div>

        @endif

    </div>


    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            function setupNumberValidation(formSelector, numberClass, amountClass) {
                const form = document.querySelector(formSelector);
                if (!form) return;

                const inputs = form.querySelectorAll(`.${numberClass}, .${amountClass}`);

                inputs.forEach(function (input) {
                    function validate() {
                        const error = document.getElementById(input.id + '_error');
                        if (!error) return true;

                        const value = input.value.trim();

                        let isValid;

                        if (input.classList.contains(numberClass)) {
                            isValid = /^[0-9]+$/.test(value);
                        } else {
                            isValid = /^[0-9]+(\.[0-9]+)?$/.test(value);
                        }

                        if (isValid) {
                            input.classList.remove('!border-red-500');
                            input.classList.add('!border-gray-300');
                            error.classList.add('hidden');
                        } else {
                            input.classList.remove('!border-gray-300');
                            input.classList.add('!border-red-500');
                            error.classList.remove('hidden');
                        }

                        return isValid;
                    }

                    input.addEventListener('input', validate);
                    input.addEventListener('blur', validate);
                });
            }

            function setupDateRange(formSelector, rangeId, fromHiddenId, untilHiddenId) {
                const form = document.querySelector(formSelector);

                if (!form) {
                    return;
                }

                const rangeInput = document.getElementById(rangeId);
                const fromHidden = document.getElementById(fromHiddenId);
                const untilHidden = document.getElementById(untilHiddenId);

                if (!rangeInput || !fromHidden || !untilHidden) {
                    return;
                }

                flatpickr(rangeInput, {
                    mode: 'range',
                    dateFormat: 'd-m-Y',
                    locale: {
                        firstDayOfWeek: 1
                    },
                    onChange: function (selectedDates) {

                        if (selectedDates.length >= 1) {
                            const from = selectedDates[0];

                            fromHidden.value =
                                from.getFullYear() + '-' +
                                String(from.getMonth() + 1).padStart(2, '0') + '-' +
                                String(from.getDate()).padStart(2, '0');
                        }

                        if (selectedDates.length === 2) {
                            const until = selectedDates[1];

                            untilHidden.value =
                                until.getFullYear() + '-' +
                                String(until.getMonth() + 1).padStart(2, '0') + '-' +
                                String(until.getDate()).padStart(2, '0');
                        } else {
                            untilHidden.value = '';
                        }
                    }
                });
            }


            function setupSaveButton(formSelector, amountSelector, buttonSelector) {
                const form = document.querySelector(formSelector);

                if (!form) {
                    return;
                }

                const amounts = form.querySelectorAll(amountSelector);
                const button = form.querySelector(buttonSelector);

                if (!button) {
                    return;
                }

                function checkAmount() {
                    const filled = Array.from(amounts).every(function (input) {
                        return input.value.trim() !== '';
                    });

                    if (filled) {
                        button.classList.remove('hidden');
                    } else {
                        button.classList.add('hidden');
                    }
                }

                amounts.forEach(function (input) {
                    input.addEventListener('input', checkAmount);
                });

                checkAmount();
            }


            setupDateRange(
                '[data-form="pb01"]',
                'pb01_date_range',
                'pb01_date_from',
                'pb01_date_until'
            );

            setupDateRange(
                '[data-form="pb02"]',
                'pb02_date_range',
                'pb02_date_from',
                'pb02_date_until'
            );

            setupNumberValidation(
                '[data-form="pb01"]',
                'pb01-number',
                'pb01-amount'
            );

            setupNumberValidation(
                '[data-form="pb02"]',
                'pb02-number',
                'pb02-amount'
            );

            setupSaveButton(
                '[data-form="pb01"]',
                '.pb01-amount',
                '.pb01-save'
            );

            setupSaveButton(
                '[data-form="pb02"]',
                '.pb02-amount',
                '.pb02-save'
            );

        });
    </script>

@endsection